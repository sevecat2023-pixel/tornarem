<?php
/* =============================================================
   TORNAREM — recepción de pedidos de la tienda

   Funciona en cualquier hosting con PHP (Hostinger lo trae de serie).
   Sin librerías, sin composer: se sube y ya está.

   Qué hace con cada pedido:
   1. Valida los datos del cliente y recalcula el total con los precios
      del catálogo: el navegador nunca decide lo que se cobra.
   2. GUARDA el pedido en datos/pedidos/ y descuenta el stock, así que
      aparece en el panel al instante.
   3. Si el pago es con tarjeta y hay clave de Stripe, crea la sesión
      de pago y devuelve la URL de la pasarela.
   4. Manda un correo al cliente y otro a la tienda.

   Toda la lógica de catálogo, importes y guardado vive en
   lib/tienda.php, que es el mismo código que usa el panel. Aquí sólo
   queda lo propio de la tienda: correos, Stripe y la respuesta.
   ============================================================= */

/* -------------------------------------------------------------
   1. CONFIGURACIÓN — lo único que hay que tocar
   ------------------------------------------------------------- */

/* A dónde llegan los avisos de pedido nuevo. Varias, separadas por coma. */
$DESTINO          = 'pedidos@tornarem.cat';

/* Desde qué dirección salen los correos.
   IMPORTANTE: tiene que ser una cuenta del propio dominio o los
   servidores lo tirarán a spam. Créala en hPanel → Correos. */
$REMITENTE        = 'web@tornarem.cat';
$REMITENTE_NOMBRE = 'Tornarem · Pedidos';

/* Pago con tarjeta real. Pega aquí la clave secreta de Stripe
   (empieza por sk_live_ o sk_test_). Vacío = el cliente recibe el
   pedido como "pendiente de pago" y le mandas tú el enlace de cobro. */
$STRIPE_SECRET_KEY = '';

/* Dirección pública de la web, con barra final. Vacío = se detecta sola. */
$URL_BASE         = '';

/* -------------------------------------------------------------
   2. De aquí para abajo no hace falta tocar nada
   ------------------------------------------------------------- */

require_once __DIR__ . '/lib/tienda.php';

header('X-Content-Type-Options: nosniff');

$quiereJson =
  (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
  (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false);

function responder($data, $codigo = 200) {
    global $quiereJson;
    http_response_code($codigo);
    if ($quiereJson) {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    /* Sin JavaScript no hay carrito, así que esto sólo lo ve alguien
       que abra la URL a mano. Una página sencilla y para casa. */
    header('Content-Type: text/html; charset=utf-8');
    $ok = !empty($data['ok']);
    $m  = htmlspecialchars($ok ? ('Pedido ' . $data['pedido'] . ' recibido.') : $data['mensaje'], ENT_QUOTES, 'UTF-8');
    echo "<!DOCTYPE html><html lang=\"es\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">"
       . "<title>Tornarem</title><link rel=\"stylesheet\" href=\"styles.css?v=20260910\"></head><body><main style=\"min-height:70vh;display:grid;place-items:center;padding:2rem\">"
       . "<div style=\"max-width:34rem\"><h1 style=\"font-family:var(--display);text-transform:uppercase\">$m</h1>"
       . "<p style=\"margin-top:1rem\"><a class=\"btn btn-solid\" href=\"index.html#lotes\">Volver a la tienda</a></p></div></main></body></html>";
    exit;
}
function fallo($mensaje, $codigo = 422) { responder(array('ok' => false, 'mensaje' => $mensaje), $codigo); }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fallo('Método no permitido.', 405);

/* ---- Entrada: JSON (desde main.js) o formulario clásico ---- */
if (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $in = tienda_entrada_json();
    if (!count($in)) fallo('Petición mal formada.', 400);
} else {
    $in = array(
        'cliente' => $_POST,
        'pago'    => isset($_POST['pago']) ? $_POST['pago'] : '',
        'items'   => isset($_POST['items']) ? json_decode((string) $_POST['items'], true) : array(),
        'web'     => isset($_POST['web']) ? $_POST['web'] : '',
    );
}

/* Cazabobos: campo oculto que las personas no ven y los robots rellenan.
   Se le responde que todo ha ido bien y no se guarda nada. */
if (trim((string) (isset($in['web']) ? $in['web'] : '')) !== '') {
    responder(array('ok' => true, 'pedido' => 'TR-000000-0000', 'pago' => 'contrarreembolso', 'total' => 0, 'url' => null));
}

/* ---- De dónde viene: se guarda con el pedido para poder rastrearlo ---- */
$origen = array(
    'ip'     => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
    'agente' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
    'url'    => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
);
if (isset($in['origen'])) {
    /* main.js manda la URL a secas; el panel podría mandar el array entero. */
    if (is_array($in['origen'])) {
        foreach (array('ip', 'agente', 'url') as $k) {
            if (isset($in['origen'][$k]) && $in['origen'][$k] !== '') $origen[$k] = $in['origen'][$k];
        }
    } elseif (is_string($in['origen']) && $in['origen'] !== '') {
        $origen['url'] = $in['origen'];
    }
}

/* ---- Alta del pedido: valida, recalcula, descuenta stock y guarda ----
   Los mensajes de error de la capa de datos ya vienen en castellano y
   son para el cliente ("Sólo quedan 2 unidades de…"), así que se pasan
   tal cual. Cualquier otro fallo se contesta en genérico. */
$pedido = null;
try {
    $pedido = tienda_crear_pedido(array(
        'cliente' => isset($in['cliente']) && is_array($in['cliente']) ? $in['cliente'] : array(),
        'pago'    => isset($in['pago']) ? $in['pago'] : '',
        'items'   => isset($in['items']) && is_array($in['items']) ? $in['items'] : array(),
        'origen'  => $origen,
    ));
} catch (RuntimeException $e) {
    fallo($e->getMessage());
} catch (Exception $e) {
    fallo('No se ha podido registrar el pedido. Vuelve a intentarlo en un momento.', 500);
}

$numero   = $pedido['numero'];
$cliente  = $pedido['cliente'];
$lineas   = $pedido['lineas'];
$subtotal = $pedido['importes']['subtotal'];
$recargo  = $pedido['importes']['recargo'];
$total    = $pedido['importes']['total'];
$hayPale  = !empty($pedido['envio']['es_pale']);

/* ---- Stripe Checkout (sólo si hay clave) ---- */
$estadoPago  = $pedido['pago']['metodo'];   /* contrarreembolso | tarjeta | tarjeta-pendiente */
$urlPago     = null;
$errorStripe = '';
if ($estadoPago === 'tarjeta') {
    if ($STRIPE_SECRET_KEY !== '' && function_exists('curl_init')) {
        if ($URL_BASE !== '') {
            $base = rtrim($URL_BASE, '/') . '/';
        } else {
            $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
            $dir   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
            $base  = ($https ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $dir . '/';
        }
        $params = array(
            'mode'           => 'payment',
            'locale'         => 'es',
            'customer_email' => $cliente['email'],
            'client_reference_id' => $numero,
            'success_url'    => $base . 'gracias.html?p=' . rawurlencode($numero) . '&pago=tarjeta&stripe=ok&total=' . $total . '&email=' . rawurlencode($cliente['email']),
            'cancel_url'     => $base . 'checkout.html?cancelado=1',
            'metadata[pedido]' => $numero,
            'payment_intent_data[description]' => 'Pedido ' . $numero . ' · ' . $cliente['nombre'],
        );
        foreach ($lineas as $i => $ln) {
            $params["line_items[$i][quantity]"] = $ln['qty'];
            $params["line_items[$i][price_data][currency]"] = 'eur';
            $params["line_items[$i][price_data][unit_amount]"] = (int) round($ln['precio'] * 100);
            $params["line_items[$i][price_data][product_data][name]"] = $ln['nombre'] . ' (' . $ln['ref'] . ')';
        }
        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        curl_setopt_array($ch, array(
            CURLOPT_POST => true, CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_USERPWD => $STRIPE_SECRET_KEY . ':', CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20,
        ));
        $res  = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $s = json_decode((string) $res, true);
        if ($code === 200 && is_array($s) && !empty($s['url'])) {
            $urlPago = $s['url'];
            $pedido['pago']['referencia'] = isset($s['id']) ? (string) $s['id'] : '';
            tienda_historial($pedido, 'Sesión de pago con tarjeta creada en Stripe.', 'tienda');
        } else {
            $estadoPago = 'tarjeta-pendiente';
            $errorStripe = (is_array($s) && isset($s['error']['message'])) ? $s['error']['message'] : ('HTTP ' . $code);
            tienda_historial($pedido, 'Stripe no ha podido crear la sesión de pago (' . $errorStripe . '). Hay que enviar al cliente un enlace de cobro.', 'tienda');
        }
    } else {
        /* Sin clave de Stripe el cobro se hace a mano: queda apuntado. */
        $estadoPago = 'tarjeta-pendiente';
        tienda_historial($pedido, 'Pago con tarjeta sin pasarela configurada: hay que enviar al cliente un enlace de cobro.', 'tienda');
    }
}

/* ---- Correos ---- */
$textoLineas = array();
foreach ($lineas as $ln) {
    $textoLineas[] = sprintf('  %d × %s  [%s · %s uds · grado %s]  %s', $ln['qty'], $ln['nombre'], $ln['ref'], $ln['uds'], $ln['grado'], tienda_eur($ln['total']));
}
$textosPago = array(
    'contrarreembolso'  => 'Contrarreembolso: se paga al transportista al recibir (efectivo o tarjeta en datáfono). Incluye recargo de la agencia: ' . tienda_eur($recargo) . '.',
    'tarjeta'           => 'Tarjeta a través de Stripe. Comprueba el cobro en el panel de Stripe (referencia ' . $numero . ') antes de enviar.',
    'tarjeta-pendiente' => 'Tarjeta: PENDIENTE. ACCIÓN: enviar al cliente un enlace de pago por ' . tienda_eur($total) . ' (correo o WhatsApp). El lote queda reservado 24 h.',
);
$textoPago = $textosPago[$estadoPago];

$direccion = $cliente['direccion'] . ', ' . $cliente['cp'] . ' ' . $cliente['poblacion'] . ' (' . $cliente['provincia'] . ')';

$contacto = array('telefono' => '', 'direccion' => '');
try {
    $cat = tienda_catalogo_base();
    if (isset($cat['contacto']['telefono'])) $contacto['telefono'] = (string) $cat['contacto']['telefono'];
    if (isset($cat['contacto']['direccion'])) $contacto['direccion'] = (string) $cat['contacto']['direccion'];
} catch (Exception $e) {
    /* El catálogo ya se ha leído bien más arriba; si fallase aquí, el
       correo sale sin el teléfono antes que no salir. */
}

/* Para la tienda */
$cuerpoTienda = implode("\n", array_merge(array(
    'PEDIDO NUEVO ' . $numero,
    str_repeat('=', 52),
    'Cliente:    ' . $cliente['nombre'] . ($cliente['empresa'] !== '' ? ' · ' . $cliente['empresa'] : ''),
    'Teléfono:   ' . $cliente['telefono'],
    'Correo:     ' . $cliente['email'],
    'Entrega:    ' . $direccion,
    ($cliente['nif'] !== '' ? 'NIF/CIF:    ' . $cliente['nif'] : 'NIF/CIF:    (no indicado)'),
    '',
    'Lotes:',
), $textoLineas, array(
    '',
    'Subtotal (IVA incl.):        ' . tienda_eur($subtotal),
    'Recargo contrarreembolso:    ' . tienda_eur($recargo),
    'TOTAL:                       ' . tienda_eur($total),
    '',
    'Pago:       ' . $textoPago,
    ($errorStripe !== '' ? 'Aviso Stripe: ' . $errorStripe : ''),
    ($hayPale ? 'Transporte: PALÉ → llamar al cliente para concertar la entrega.' : 'Transporte: mensajería 24 h.'),
    'Entrega prevista: ' . $pedido['envio']['fecha_prevista'],
    '',
    'Notas del cliente:',
    ($cliente['notas'] !== '' ? $cliente['notas'] : '(ninguna)'),
    '',
    str_repeat('-', 52),
    'Recibido el ' . date('d/m/Y \a \l\a\s H:i'),
    'IP: ' . ($origen['ip'] !== '' ? $origen['ip'] : 'desconocida'),
    'El pedido ya está en el panel, con el stock descontado.',
)));

/* Para el cliente */
$pasosCliente = array(
    'contrarreembolso'  => "Pagarás al transportista al recibir el lote, en efectivo o con tarjeta en su datáfono.\nEl total ya incluye el recargo del contrarreembolso (" . tienda_eur($recargo) . ").",
    'tarjeta'           => "Estás pagando con tarjeta en la pasarela segura. En cuanto se confirme el cobro,\nprecintamos el lote y sale en la siguiente recogida.",
    'tarjeta-pendiente' => "Has elegido pagar con tarjeta: en unos minutos te enviamos un enlace de pago seguro\n(por correo y, si nos has dejado móvil, por WhatsApp). El lote queda reservado 24 horas.",
);

$cuerpoCliente = implode("\n", array_merge(array(
    'Hola ' . $cliente['nombre'] . ',',
    '',
    'Hemos recibido tu pedido ' . $numero . '. Gracias.',
    '',
    'Lotes:',
), $textoLineas, array(
    '',
    'Subtotal (IVA incl.):        ' . tienda_eur($subtotal),
    ($recargo > 0 ? 'Recargo contrarreembolso:    ' . tienda_eur($recargo) : 'Pago con tarjeta:            sin recargo'),
    'TOTAL:                       ' . tienda_eur($total),
    '',
    'Entrega en: ' . $direccion,
    ($hayPale ? 'Tu pedido incluye un palé: te llamaremos para concertar la entrega (24–48 h).' : 'Si has confirmado antes de las 14:00 de un día laborable, sale hoy y lo recibes mañana (península).'),
    '',
    $pasosCliente[$estadoPago],
    '',
    'En el paquete viaja el listado de contenido y la factura. Tienes 14 días desde la entrega',
    'para reclamar cualquier unidad de un lote clasificado que no funcione como se describe.',
    '',
    'Cualquier duda: responde a este correo o llama al ' . $contacto['telefono'] . '.',
    '',
    'Tornarem · Lotes de devoluciones',
    $contacto['direccion'],
    'Liquidador independiente. Amazon es una marca registrada de Amazon.com, Inc.; no existe afiliación ni respaldo por su parte.',
)));

$cabeceras = function ($replyTo) use ($REMITENTE, $REMITENTE_NOMBRE) {
    return implode("\r\n", array(
        'From: ' . mb_encode_mimeheader($REMITENTE_NOMBRE) . ' <' . $REMITENTE . '>',
        'Reply-To: ' . $replyTo,
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'X-Mailer: tornarem-tienda',
    ));
};

$enviadoTienda  = @mail($DESTINO, mb_encode_mimeheader('Pedido ' . $numero . ' · ' . $cliente['nombre'] . ' · ' . tienda_eur($total)), $cuerpoTienda, $cabeceras($cliente['email']), '-f' . $REMITENTE);
$enviadoCliente = @mail($cliente['email'], mb_encode_mimeheader('Tu pedido ' . $numero . ' en Tornarem'), $cuerpoCliente, $cabeceras($DESTINO), '-f' . $REMITENTE);

/* El pedido ya está guardado; esto sólo apunta cómo ha ido el correo y
   la pasarela, para que en el panel se vea qué falta por hacer a mano. */
tienda_historial($pedido, 'Aviso a la tienda: ' . ($enviadoTienda ? 'enviado' : 'NO enviado') . '. Confirmación al cliente: ' . ($enviadoCliente ? 'enviada' : 'NO enviada') . '.', 'tienda');
tienda_guardar_pedido($pedido);

responder(array(
    'ok'     => true,
    'pedido' => $numero,
    'pago'   => $estadoPago,
    'total'  => $total,
    'url'    => $urlPago,
    'correo' => $enviadoCliente ? 'enviado' : 'no enviado',
));
