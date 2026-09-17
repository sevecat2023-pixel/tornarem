<?php
/* =============================================================
   TORNAREM — lista de avisos de camión

   Guarda el correo de quien quiere que le avisemos cuando entre
   género de una categoría, o cuando vuelva a haber stock de un
   lote agotado. Es el otro lado del embudo: la gente que llega
   leyendo una guía y todavía no va a comprar hoy.

   Devuelve JSON. La página que lo llama es cualquiera de las
   generadas por tools/generar.php, que llevan el formulario.
   ============================================================= */

require_once __DIR__ . '/lib/tienda.php';

header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

if (!isset($_SERVER['REQUEST_METHOD']) || strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    tienda_responder(array('ok' => false, 'mensaje' => 'Aquí sólo se envían formularios.'), 405);
}

$entrada = tienda_entrada_json();
if (!$entrada) {
    $entrada = $_POST;
}

/* Trampa para robots: el campo 'web' está escondido por CSS y una
   persona nunca lo rellena. Si viene lleno, se contesta que sí y no se
   guarda nada: el robot se va contento y la lista queda limpia. */
if (isset($entrada['web']) && trim((string) $entrada['web']) !== '') {
    tienda_responder(array('ok' => true, 'mensaje' => 'Apuntado.'));
}

/* Mismo freno que los pedidos, algo más holgado: apuntarse es más
   barato que comprar, pero tampoco hace falta que nadie meta cien
   correos desde el mismo sitio en una hora. */
$espera = tienda_freno('avisos', 8, 200, 3600);
if ($espera > 0) {
    tienda_responder(array(
        'ok' => false,
        'mensaje' => 'Has enviado varios avisos seguidos. Prueba dentro de un rato o escríbenos a pedidos@tornarem.cat.',
    ), 429);
}

$r = tienda_aviso_crear($entrada);

/* Con JavaScript, JSON. Sin JavaScript (el formulario enviado a pelo),
   una página sencilla: nadie tiene que ver un JSON en crudo. */
$quiereJson =
    (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
    (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false);

if ($quiereJson) {
    tienda_responder($r, $r['ok'] ? 200 : 400);
}

http_response_code($r['ok'] ? 200 : 400);
header('Content-Type: text/html; charset=utf-8');
$m = htmlspecialchars($r['mensaje'], ENT_QUOTES, 'UTF-8');
echo '<!DOCTYPE html><html lang="es"><head><meta charset="utf-8">'
   . '<meta name="viewport" content="width=device-width,initial-scale=1">'
   . '<meta name="robots" content="noindex"><title>Tornarem</title>'
   . '<link rel="stylesheet" href="styles.css?v=20260917"></head><body>'
   . '<main style="min-height:70vh;display:grid;place-items:center;padding:2rem;text-align:center">'
   . '<div><h1 style="font-family:var(--display);text-transform:uppercase">' . ($r['ok'] ? 'Apuntado' : 'Vaya') . '</h1>'
   . '<p style="margin:1rem 0 1.5rem">' . $m . '</p>'
   . '<a class="btn btn-solid" href="index.html">Volver a la tienda</a></div></main></body></html>';
exit;
