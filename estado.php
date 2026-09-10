<?php
/* =============================================================
   TORNAREM — estado público del catálogo

   Sólo lectura y sin sesión: devuelve el precio, el stock y si está
   activo cada lote, ya con los cambios hechos desde el panel.

   Lo pide la portada al cargar (initEstado en main.js) para que el
   cliente vea el stock de verdad y no el que quedó escrito en el HTML
   el día que se subió. Si esto no responde —abriendo el index con doble
   clic, o en un hosting sin PHP— la tienda se queda con lo que hay en
   el HTML y no se rompe nada.

   No sale de aquí ningún dato de cliente: sólo tres números por lote.
   ============================================================= */

require_once __DIR__ . '/lib/tienda.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'HEAD') {
    tienda_responder(array('ok' => false, 'mensaje' => 'Método no permitido.'), 405);
}

$lotes = array();
try {
    foreach (tienda_lotes() as $id => $l) {
        $lotes[$id] = array(
            'precio' => round((float) $l['precio'], 2),
            'stock'  => (int) $l['stock'],
            'activo' => !empty($l['activo']),
        );
    }
} catch (Exception $e) {
    /* Sin catálogo no hay nada que contar. El mensaje es genérico: esta
       respuesta la ve cualquiera. */
    tienda_responder(array('ok' => false, 'mensaje' => 'El catálogo no está disponible.'), 500);
}

/* Cuándo cambió por última vez lo que se devuelve: el catálogo o los
   cambios del panel, lo que sea más reciente. */
$sellos = array();
$overrides = tienda_ruta_overrides();
if (is_file($overrides)) {
    $t = @filemtime($overrides);
    if ($t !== false) $sellos[] = $t;
}
$catalogo = __DIR__ . '/lib/catalogo.js';
if (is_file($catalogo)) {
    $t = @filemtime($catalogo);
    if ($t !== false) $sellos[] = $t;
}
$actualizado = count($sellos) ? date('c', max($sellos)) : tienda_ahora();

tienda_responder(array(
    'ok'          => true,
    'lotes'       => $lotes,
    'actualizado' => $actualizado,
));
