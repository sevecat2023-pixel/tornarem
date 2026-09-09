<?php
/* =============================================================
   TORNAREM — recepción de pedidos de la tienda

   Funciona en cualquier hosting con PHP (Hostinger lo trae de serie).
   Sin librerías, sin composer: se sube y ya está.

   Qué hace con cada pedido:
   1. Lee el catálogo de lib/catalogo.js (precios y stock reales, el
      navegador nunca decide el precio).
   2. Valida los datos del cliente y recalcula el total.
   3. Si el pago es con tarjeta y hay clave de Stripe, crea la sesión
      de pago y devuelve la URL de la pasarela.
   4. Manda un correo al cliente y otro a la tienda.
   5. Guarda una copia en pedidos.log por si el correo falla.
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

/* Copia de seguridad en disco. Cadena vacía para desactivarla. */
$REGISTRO         = __DIR__ . '/pedidos.log';

/* -------------------------------------------------------------
   2. De aquí para abajo no hace falta tocar nada
   ------------------------------------------------------------- */

mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Madrid');
header('X-Content-Type-Options: nosniff');

$quiereJson =
  (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
  (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false);

function responder($data, $codigo = 200) {
    global $quiereJson;
    http_response_code($codigo);
    if ($quiereJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    /* Sin JavaScript no hay carrito, así que esto sólo lo ve alguien
       que abra la URL a mano. Una página sencilla y para casa. */
    header('Content-Type: text/html; charset=utf-8');
    $ok = !empty($data['ok']);
    $m  = htmlspecialchars($ok ? ('Pedido ' . $data['pedido'] . ' recibido.') : $data['mensaje'], ENT_QUOTES, 'UTF-8');
    echo "<!DOCTYPE html><html lang=\"es\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">"
       . "<title>Tornarem</title><link rel=\"stylesheet\" href=\"styles.css\"></head><body><main style=\"min-height:70vh;display:grid;place-items:center;padding:2rem\">"
       . "<div style=\"max-width:34rem\"><h1 style=\"font-family:var(--display);text-transform:uppercase\">$m</h1>"
       . "<p style=\"margin-top:1rem\"><a class=\"btn btn-solid\" href=\"index.html#lotes\">Volver a la tienda</a></p></div></main></body></html>";
    exit;
}
function fallo($mensaje, $codigo = 422) { responder(['ok' => false, 'mensaje' => $mensaje], $codigo); }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fallo('Método no permitido.', 405);

/* ---- Catálogo: la misma fuente que usa el navegador ---- */
$rutaCatalogo = __DIR__ . '/lib/catalogo.js';
$raw = @file_get_contents($rutaCatalogo);
if ($raw === false) fallo('No se encuentra lib/catalogo.js en el servidor.', 500);
$marca = strpos($raw, '__TIENDA__');
$ini = $marca !== false ? strpos($raw, '{', $marca) : false;
$fin = strrpos($raw, '}');
$tienda = ($ini !== false && $fin !== false) ? json_decode(substr($raw, $ini, $fin - $ini + 1), true) : null;
if (!is_array($tienda) || empty($tienda['lotes'])) fallo('El catálogo no es JSON válido: revisa lib/catalogo.js (comillas dobles, sin comas finales).', 500);
$LOTES = [];
foreach ($tienda['lotes'] as $l) $LOTES[$l['id']] = $l;

/* ---- Entrada: JSON (desde main.js) o formulario clásico ---- */
if (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $in = json_decode(file_get_contents('php://input'), true);
    if (!is_array($in)) fallo('Petición mal formada.', 400);
} else {
    $in = [
        'cliente' => $_POST,
        'pago'    => isset($_POST['pago']) ? $_POST['pago'] : '',
        'items'   => isset($_POST['items']) ? json_decode((string) $_POST['items'], true) : [],
        'web'     => isset($_POST['web']) ? $_POST['web'] : '',
    ];
}

/* Cazabobos: campo oculto que las personas no ven y los robots rellenan */
if (trim((string) (isset($in['web']) ? $in['web'] : '')) !== '') {
    responder(['ok' => true, 'pedido' => 'TR-000000-0000', 'pago' => 'contrarreembolso', 'total' => 0]);
}

/* ---- Limpieza de campos ---- */
function limpiar($v, $max = 200) {
    $v = is_array($v) ? '' : (string) $v;
    $v = str_replace(["\r", "\n", "\0"], ' ', $v);
    $v = trim(preg_replace('/[ \t]+/u', ' ', $v));
    return mb_substr($v, 0, $max);
}
function limpiarTexto($v, $max = 2000) {
    $v = is_array($v) ? '' : (string) $v;
    $v = str_replace(["\r\n", "\r", "\0"], ["\n", "\n", ''], $v);
    return mb_substr(trim($v), 0, $max);
}
$c = isset($in['cliente']) && is_array($in['cliente']) ? $in['cliente'] : [];
$g = function ($k) use ($c) { return isset($c[$k]) ? $c[$k] : ''; };
$cliente = [
    'nombre'    => limpiar($g('nombre'), 120),
    'email'     => limpiar($g('email'), 160),
    'telefono'  => limpiar($g('telefono'), 40),
    'direccion' => limpiar($g('direccion'), 200),
    'cp'        => limpiar($g('cp'), 10),
    'poblacion' => limpiar($g('poblacion'), 120),
    'provincia' => limpiar($g('provincia'), 80),
    'nif'       => limpiar($g('nif'), 24),
    'empresa'   => limpiar($g('empresa'), 160),
    'notas'     => limpiarTexto($g('notas')),
];
$pago = (isset($in['pago']) && $in['pago'] === 'tarjeta') ? 'tarjeta' : 'contrarreembolso';

/* ---- Validación (la misma que hace el navegador) ---- */
$etiquetas = ['nombre' => 'el nombre', 'email' => 'el correo', 'telefono' => 'el teléfono', 'direccion' => 'la dirección',
              'cp' => 'el código postal', 'poblacion' => 'la población', 'provincia' => 'la provincia'];
$faltan = [];
foreach ($etiquetas as $k => $et) if ($cliente[$k] === '') $faltan[] = $et;
if ($faltan) fallo('Falta ' . implode(', ', $faltan) . '.');
if (!filter_var($cliente['email'], FILTER_VALIDATE_EMAIL)) fallo('El correo no parece válido.');
if (preg_match_all('/\d/', $cliente['telefono']) < 9) fallo('El teléfono no parece completo.');
if (!preg_match('/^\d{5}$/', $cliente['cp'])) fallo('El código postal debe tener cinco dígitos.');

/* ---- Líneas del pedido: precios y stock del catálogo, nunca del navegador ---- */
$items = isset($in['items']) && is_array($in['items']) ? $in['items'] : [];
if (!count($items)) fallo('El carrito está vacío.');
$lineas = []; $subtotal = 0.0; $hayPale = false;
foreach ($items as $it) {
    $id  = isset($it['id']) ? (string) $it['id'] : '';
    $qty = isset($it['qty']) ? (int) $it['qty'] : 0;
    if (!isset($LOTES[$id])) fallo('Uno de los lotes ya no está en el catálogo (' . limpiar($id, 40) . ').');
    if ($qty < 1) continue;
    $l = $LOTES[$id];
    if ($qty > (int) $l['stock']) fallo('Sólo quedan ' . (int) $l['stock'] . ' unidades de «' . $l['nombre'] . '».');
    $precio = (float) $l['precio'];
    $lineas[] = ['id' => $id, 'ref' => $l['ref'], 'nombre' => $l['nombre'], 'uds' => $l['uds'], 'grado' => $l['grado'],
                 'qty' => $qty, 'precio' => $precio, 'total' => round($qty * $precio, 2)];
    $subtotal += $qty * $precio;
    if (preg_match('/pal[eé]/iu', isset($l['formato']) ? $l['formato'] : '')) $hayPale = true;
}
if (!$lineas) fallo('El carrito está vacío.');
$subtotal = round($subtotal, 2);
$recargo = 0.0;
if ($pago === 'contrarreembolso') {
    $p   = isset($tienda['contrarreembolso']['porcentaje']) ? (float) $tienda['contrarreembolso']['porcentaje'] : 0;
    $min = isset($tienda['contrarreembolso']['minimo']) ? (float) $tienda['contrarreembolso']['minimo'] : 0;
    $recargo = max($min, round($subtotal * $p / 100, 2));
}
$total = round($subtotal + $recargo, 2);

/* ---- Número de pedido: TR-AAMMDD-XXXX ---- */
$alfabeto = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$sufijo = '';
for ($i = 0; $i < 4; $i++) $sufijo .= $alfabeto[random_int(0, strlen($alfabeto) - 1)];
$numero = 'TR-' . date('ymd') . '-' . $sufijo;

function eur($n) { return number_format((float) $n, (round($n * 100) % 100) ? 2 : 0, ',', '.') . ' €'; }

/* ---- Stripe Checkout (sólo si hay clave) ---- */
$estadoPago = $pago;           /* contrarreembolso | tarjeta | tarjeta-pendiente */
$urlPago    = null;
$errorStripe = '';
if ($pago === 'tarjeta') {
    if ($STRIPE_SECRET_KEY !== '' && function_exists('curl_init')) {
        if ($URL_BASE !== '') {
            $base = rtrim($URL_BASE, '/') . '/';
        } else {
            $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
            $dir   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
            $base  = ($https ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $dir . '/';
        }
        $params = [
            'mode'           => 'payment',
            'locale'         => 'es',
            'customer_email' => $cliente['email'],
            'client_reference_id' => $numero,
            'success_url'    => $base . 'gracias.html?p=' . rawurlencode($numero) . '&pago=tarjeta&stripe=ok&total=' . $total . '&email=' . rawurlencode($cliente['email']),
            'cancel_url'     => $base . 'checkout.html?cancelado=1',
            'metadata[pedido]' => $numero,
            'payment_intent_data[description]' => 'Pedido ' . $numero . ' · ' . $cliente['nombre'],
        ];
        foreach ($lineas as $i => $ln) {
            $params["line_items[$i][quantity]"] = $ln['qty'];
            $params["line_items[$i][price_data][currency]"] = 'eur';
            $params["line_items[$i][price_data][unit_amount]"] = (int) round($ln['precio'] * 100);
            $params["line_items[$i][price_data][product_data][name]"] = $ln['nombre'] . ' (' . $ln['ref'] . ')';
        }
        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        curl_setopt_array($ch, [
            CURLOPT_POST => true, CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_USERPWD => $STRIPE_SECRET_KEY . ':', CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20,
        ]);
        $res  = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $s = json_decode((string) $res, true);
        if ($code === 200 && !empty($s['url'])) {
            $urlPago = $s['url'];
        } else {
            $estadoPago = 'tarjeta-pendiente';
            $errorStripe = isset($s['error']['message']) ? $s['error']['message'] : ('HTTP ' . $code);
        }
    } else {
        $estadoPago = 'tarjeta-pendiente';
    }
}

/* ---- Correos ---- */
$textoLineas = [];
foreach ($lineas as $ln) {
    $textoLineas[] = sprintf('  %d × %s  [%s · %s uds · grado %s]  %s', $ln['qty'], $ln['nombre'], $ln['ref'], $ln['uds'], $ln['grado'], eur($ln['total']));
}
$textoPago = [
    'contrarreembolso'  => 'Contrarreembolso: se paga al transportista al recibir (efectivo o tarjeta en datáfono). Incluye recargo de la agencia: ' . eur($recargo) . '.',
    'tarjeta'           => 'Tarjeta a través de Stripe. Comprueba el cobro en el panel de Stripe (referencia ' . $numero . ') antes de enviar.',
    'tarjeta-pendiente' => 'Tarjeta: PENDIENTE. ACCIÓN: enviar al cliente un enlace de pago por ' . eur($total) . ' (correo o WhatsApp). El lote queda reservado 24 h.',
][$estadoPago];

$direccion = $cliente['direccion'] . ', ' . $cliente['cp'] . ' ' . $cliente['poblacion'] . ' (' . $cliente['provincia'] . ')';

/* Para la tienda */
$cuerpoTienda = implode("\n", array_merge([
    'PEDIDO NUEVO ' . $numero,
    str_repeat('=', 52),
    'Cliente:    ' . $cliente['nombre'] . ($cliente['empresa'] !== '' ? ' · ' . $cliente['empresa'] : ''),
    'Teléfono:   ' . $cliente['telefono'],
    'Correo:     ' . $cliente['email'],
    'Entrega:    ' . $direccion,
    ($cliente['nif'] !== '' ? 'NIF/CIF:    ' . $cliente['nif'] : 'NIF/CIF:    (no indicado)'),
    '',
    'Lotes:',
], $textoLineas, [
    '',
    'Subtotal (IVA incl.):        ' . eur($subtotal),
    'Recargo contrarreembolso:    ' . eur($recargo),
    'TOTAL:                       ' . eur($total),
    '',
    'Pago:       ' . $textoPago,
    ($errorStripe !== '' ? 'Aviso Stripe: ' . $errorStripe : ''),
    ($hayPale ? 'Transporte: PALÉ → llamar al cliente para concertar la entrega.' : 'Transporte: mensajería 24 h.'),
    '',
    'Notas del cliente:',
    ($cliente['notas'] !== '' ? $cliente['notas'] : '(ninguna)'),
    '',
    str_repeat('-', 52),
    'Recibido el ' . date('d/m/Y \a \l\a\s H:i'),
    'IP: ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'desconocida'),
]));

/* Para el cliente */
$pasosCliente = [
    'contrarreembolso'  => "Pagarás al transportista al recibir el lote, en efectivo o con tarjeta en su datáfono.\nEl total ya incluye el recargo del contrarreembolso (" . eur($recargo) . ").",
    'tarjeta'           => "Estás pagando con tarjeta en la pasarela segura. En cuanto se confirme el cobro,\nprecintamos el lote y sale en la siguiente recogida.",
    'tarjeta-pendiente' => "Has elegido pagar con tarjeta: en unos minutos te enviamos un enlace de pago seguro\n(por correo y, si nos has dejado móvil, por WhatsApp). El lote queda reservado 24 horas.",
][$estadoPago];

$cuerpoCliente = implode("\n", array_merge([
    'Hola ' . $cliente['nombre'] . ',',
    '',
    'Hemos recibido tu pedido ' . $numero . '. Gracias.',
    '',
    'Lotes:',
], $textoLineas, [
    '',
    'Subtotal (IVA incl.):        ' . eur($subtotal),
    ($recargo > 0 ? 'Recargo contrarreembolso:    ' . eur($recargo) : 'Pago con tarjeta:            sin recargo'),
    'TOTAL:                       ' . eur($total),
    '',
    'Entrega en: ' . $direccion,
    ($hayPale ? 'Tu pedido incluye un palé: te llamaremos para concertar la entrega (24–48 h).' : 'Si has confirmado antes de las 14:00 de un día laborable, sale hoy y lo recibes mañana (península).'),
    '',
    $pasosCliente,
    '',
    'En el paquete viaja el listado de contenido y la factura. Tienes 14 días desde la entrega',
    'para reclamar cualquier unidad de un lote clasificado que no funcione como se describe.',
    '',
    'Cualquier duda: responde a este correo o llama al ' . (isset($tienda['contacto']['telefono']) ? $tienda['contacto']['telefono'] : '') . '.',
    '',
    'Tornarem · Lotes de devoluciones',
    isset($tienda['contacto']['direccion']) ? $tienda['contacto']['direccion'] : '',
    'Liquidador independiente. Amazon es una marca registrada de Amazon.com, Inc.; no existe afiliación ni respaldo por su parte.',
]));

$cabeceras = function ($replyTo) use ($REMITENTE, $REMITENTE_NOMBRE) {
    return implode("\r\n", [
        'From: ' . mb_encode_mimeheader($REMITENTE_NOMBRE) . ' <' . $REMITENTE . '>',
        'Reply-To: ' . $replyTo,
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
        'X-Mailer: tornarem-tienda',
    ]);
};

$enviadoTienda  = @mail($DESTINO, mb_encode_mimeheader('Pedido ' . $numero . ' · ' . $cliente['nombre'] . ' · ' . eur($total)), $cuerpoTienda, $cabeceras($cliente['email']), '-f' . $REMITENTE);
$enviadoCliente = @mail($cliente['email'], mb_encode_mimeheader('Tu pedido ' . $numero . ' en Tornarem'), $cuerpoCliente, $cabeceras($DESTINO), '-f' . $REMITENTE);

/* ---- Registro en disco: nunca se pierde un pedido ---- */
if ($REGISTRO !== '') {
    $linea = json_encode([
        'fecha' => date('c'), 'pedido' => $numero, 'pago' => $estadoPago, 'total' => $total, 'subtotal' => $subtotal, 'recargo' => $recargo,
        'cliente' => $cliente, 'lineas' => $lineas, 'correo_tienda' => $enviadoTienda ? 'ok' : 'FALLO', 'correo_cliente' => $enviadoCliente ? 'ok' : 'FALLO',
        'stripe' => $urlPago ? 'sesion creada' : $errorStripe,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    @file_put_contents($REGISTRO, $linea . "\n", FILE_APPEND | LOCK_EX);
}

responder([
    'ok'     => true,
    'pedido' => $numero,
    'pago'   => $estadoPago,
    'total'  => $total,
    'url'    => $urlPago,
    'correo' => $enviadoCliente ? 'enviado' : 'no enviado',
]);
