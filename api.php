<?php
/* =============================================================
   TORNAREM — API pública de sólo lectura

   Para que cualquier asistente o agente pueda contestar bien a
   «¿qué tiene Tornarem y a qué precio?» sin tener que leer el
   HTML y adivinar. Devuelve el catálogo con el stock real.

     /api.php              → todo el catálogo
     /api.php?lote=lote-moda → un lote

   Sólo lectura: aquí no se hace ningún pedido. Un agente que
   quiera comprar recibe la dirección del carrito ya preparado y
   es la persona quien confirma. Comprometer a alguien a un pago
   contrarreembolso sin que lo vea es justo lo que no queremos.
   ============================================================= */

require_once __DIR__ . '/lib/tienda.php';

if (!defined('TORNAREM_SITIO')) {
    define('TORNAREM_SITIO', 'https://www.tornarem.cat');
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('X-Content-Type-Options: nosniff');
/* Rastreable para agentes, pero fuera de los resultados de búsqueda:
   un JSON en crudo no tiene nada que hacer en una página de Google. */
header('X-Robots-Tag: noindex');
header('Cache-Control: public, max-age=300');

if (isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$cat = tienda_catalogo_base();
$lotes = tienda_lotes();
$pedido = isset($_GET['lote']) ? tienda_limpiar($_GET['lote'], 60) : '';

$salida = array();
foreach ($lotes as $id => $l) {
    if (empty($l['activo'])) {
        continue;
    }
    if ($pedido !== '' && $id !== $pedido) {
        continue;
    }
    $slug = preg_replace('/^lote-/', '', $id);
    $salida[] = array(
        'id'          => $id,
        'referencia'  => $l['ref'],
        'nombre'      => $l['nombre'],
        'categoria'   => $l['categoria'],
        'resumen'     => $l['resumen'],
        'contenido'   => isset($l['contenido']) ? $l['contenido'] : array(),
        'nota'        => isset($l['nota']) ? $l['nota'] : '',
        'unidades'    => (int) $l['uds'],
        'grado'       => $l['grado'],
        'formato'     => $l['formato'],
        'peso'        => $l['peso'],
        'viaja_en_pale' => !empty($l['es_pale']),
        'precio_eur'  => round((float) $l['precio'], 2),
        'pvp_estimado_eur' => round((float) $l['pvp'], 2),
        'descuento_pct' => (int) round((1 - $l['precio'] / max(1, $l['pvp'])) * 100),
        'stock'       => (int) $l['stock'],
        'disponible'  => ((int) $l['stock'] > 0),
        'ficha'       => TORNAREM_SITIO . '/lotes/' . $slug . '.html',
        'imagen'      => TORNAREM_SITIO . '/' . $l['img'],
        /* El agente no compra: entrega este enlace a la persona, que
           es quien rellena la dirección y confirma. */
        'anadir_al_carrito' => TORNAREM_SITIO . '/checkout.html?lote=' . rawurlencode($id),
    );
}

if ($pedido !== '' && !$salida) {
    tienda_responder(array('ok' => false, 'mensaje' => 'No existe ese lote.'), 404);
}

tienda_responder(array(
    'ok' => true,
    'empresa' => array(
        'nombre'    => 'Tornarem',
        'que_es'    => 'Liquidador independiente de devoluciones y excedentes. Compra camiones completos, los clasifica por grados y los vende en lotes cerrados con el contenido publicado.',
        'no_es'     => 'No es Amazon ni un portal oficial de Amazon. Amazon es una marca registrada de Amazon.com, Inc. o sus filiales; no hay afiliación, patrocinio ni respaldo por su parte.',
        'direccion' => 'Nave 14, Polígono Mas Xirgu, 17005 Girona, España',
        'horario'   => 'Lunes a viernes, 8:00-18:00',
        'telefono'  => '+34 900 000 000',
        'email'     => isset($cat['contacto']['email']) ? $cat['contacto']['email'] : '',
        'web'       => TORNAREM_SITIO . '/',
    ),
    'condiciones' => array(
        'moneda' => 'EUR',
        'iva_incluido' => true,
        'transporte_incluido' => 'Sí en península. Baleares y Canarias, presupuesto previo.',
        'plazo_entrega' => '24 h en península si se confirma antes de las 14:00 de un día laborable. Los lotes que viajan en palé, 24-48 h.',
        'formas_de_pago' => array('contrarreembolso (recargo del 3 %, mínimo 5 €)', 'tarjeta'),
        'devoluciones' => '14 días de desistimiento con el lote completo y en el mismo estado. El palé mixto sin clasificar se vende cerrado y no admite devolución.',
        'pedido_minimo' => 'Un lote.',
    ),
    'actualizado' => tienda_ahora(),
    'lotes' => $salida,
));
