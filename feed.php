<?php
/* =============================================================
   TORNAREM — el catálogo de productos, servido por web

   Lo que pide OpenAI para enseñar productos en ChatGPT. Aquí se
   sirve siempre con el stock y el precio del momento, así que
   nunca dice «disponible» de algo que se acaba de agotar.

     /feed.php              → JSONL (el formato recomendado)
     /feed.php?formato=csv  → CSV

   No es público para personas: es para máquinas. Por eso va con
   cabeceras de no-caché y permiso de origen cruzado.
   ============================================================= */

require_once __DIR__ . '/lib/feed.php';

$formato = isset($_GET['formato']) ? strtolower(trim((string) $_GET['formato'])) : 'jsonl';

header('Access-Control-Allow-Origin: *');
header('X-Content-Type-Options: nosniff');
/* Rastreable para agentes, pero fuera de los resultados de búsqueda:
   un JSON en crudo no tiene nada que hacer en una página de Google. */
header('X-Robots-Tag: noindex');
header('Cache-Control: public, max-age=900');   /* 15 minutos, como el ritmo de actualización que admite OpenAI */

if ($formato === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: inline; filename="tornarem-productos.csv"');
    echo tienda_feed_csv();
    exit;
}

header('Content-Type: application/jsonl; charset=utf-8');
header('Content-Disposition: inline; filename="tornarem-productos.jsonl"');
echo tienda_feed_jsonl();
