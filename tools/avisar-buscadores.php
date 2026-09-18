<?php
/* =============================================================
   TORNAREM — avisar a los buscadores de que hay páginas nuevas

   Usa IndexNow, que es el aviso que aceptan Bing y Yandex (y que
   comparten con otros). Sirve para que una página nueva se indexe
   en horas en lugar de en semanas.

   Por qué importa aquí: buena parte de la búsqueda con IA se
   apoya en el índice de Bing. Si Bing no te tiene, ChatGPT no te
   encuentra por mucho contenido que escribas.

   Google no usa IndexNow. Para Google, el sitemap y Search
   Console; está explicado en el README.

   Uso:
     php tools/avisar-buscadores.php            → avisa de todo el sitemap
     php tools/avisar-buscadores.php --clave    → sólo crea/enseña la clave
   ============================================================= */

if (PHP_SAPI !== 'cli') {
    header('HTTP/1.1 403 Forbidden');
    exit('Este fichero sólo se ejecuta por consola.');
}

$RAIZ = dirname(__DIR__);
$SITIO = 'https://www.tornarem.cat';
$HOST = parse_url($SITIO, PHP_URL_HOST);

/* --- la clave ---
   IndexNow pide una clave y que esa misma clave esté publicada en
   un fichero de texto en la raíz del sitio. Así demuestras que el
   dominio es tuyo. Se crea una vez y no se toca más. */
$rutaClave = $RAIZ . '/tools/indexnow.clave';
if (is_file($rutaClave)) {
    $clave = trim((string) file_get_contents($rutaClave));
} else {
    $clave = bin2hex(random_bytes(16));
    file_put_contents($rutaClave, $clave . "\n");
    echo "Clave nueva creada en tools/indexnow.clave\n";
}
if (!preg_match('/^[a-f0-9]{8,128}$/', $clave)) {
    exit("La clave de tools/indexnow.clave no es válida.\n");
}

/* El fichero público que demuestra que el dominio es tuyo. */
$ficheroClave = $RAIZ . '/' . $clave . '.txt';
if (!is_file($ficheroClave)) {
    /* Se borra cualquier clave anterior para no dejar basura por la raíz */
    foreach (glob($RAIZ . '/*.txt') as $viejo) {
        $nombre = basename($viejo, '.txt');
        if ($nombre !== $clave && preg_match('/^[a-f0-9]{16,}$/', $nombre)) {
            unlink($viejo);
        }
    }
    file_put_contents($ficheroClave, $clave);
    echo "Fichero de clave publicado: /" . $clave . ".txt\n";
}

if (in_array('--clave', $argv, true)) {
    echo "Clave: " . $clave . "\n";
    echo "Tiene que estar accesible en " . $SITIO . "/" . $clave . ".txt\n";
    exit(0);
}

/* --- las direcciones, sacadas del sitemap --- */
$sitemap = $RAIZ . '/sitemap.xml';
if (!is_file($sitemap)) {
    exit("No hay sitemap.xml. Lanza antes: php tools/generar.php\n");
}
$xml = file_get_contents($sitemap);
preg_match_all('#<loc>(.*?)</loc>#', $xml, $m);
$urls = array_values(array_unique($m[1]));
if (!$urls) {
    exit("El sitemap no tiene ninguna dirección.\n");
}

/* IndexNow admite hasta 10.000 por envío; vamos de mil en mil por
   no mandar peticiones enormes. */
$lotes = array_chunk($urls, 1000);
echo count($urls) . " direcciones en " . count($lotes) . " envío(s).\n";

foreach ($lotes as $i => $lote) {
    $cuerpo = json_encode(array(
        'host' => $HOST,
        'key' => $clave,
        'keyLocation' => $SITIO . '/' . $clave . '.txt',
        'urlList' => $lote,
    ), JSON_UNESCAPED_SLASHES);

    $ch = curl_init('https://api.indexnow.org/indexnow');
    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $cuerpo,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json; charset=utf-8'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
    ));
    $resp = curl_exec($ch);
    $codigo = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error !== '') {
        echo "  Envío " . ($i + 1) . ": error de red — " . $error . "\n";
        continue;
    }
    /* 200 y 202 son «recibido». 422 suele ser que la clave publicada
       no coincide con la enviada. */
    $texto = array(
        200 => 'recibido',
        202 => 'recibido, pendiente de comprobar la clave',
        400 => 'petición mal formada',
        403 => 'la clave no es válida',
        422 => 'la clave no coincide con la publicada, o las URL no son de este dominio',
        429 => 'demasiados envíos seguidos',
    );
    echo "  Envío " . ($i + 1) . ": " . $codigo . " — "
        . (isset($texto[$codigo]) ? $texto[$codigo] : 'respuesta ' . $codigo) . "\n";
}

echo "\nRecuerda: Google no usa IndexNow. Para Google, manda el sitemap\n";
echo "desde Search Console: " . $SITIO . "/sitemap.xml\n";
