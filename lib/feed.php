<?php
/* =============================================================
   TORNAREM — catálogo de productos para ChatGPT y otros agentes

   OpenAI publica una especificación de «product feed»: un fichero
   con una fila por artículo que ChatGPT usa para enseñar productos
   en sus respuestas de compra. Nueve campos son obligatorios
   (item_id, title, description, url, brand, seller_name, image_url,
   availability y price) y el resto ayudan a que el producto se
   entienda bien.

   Esto lo construye a partir del catálogo REAL, con el stock y el
   precio del momento, porque un feed que dice «disponible» de algo
   agotado es peor que no tener feed.

   Lo usan dos sitios:
     · feed.php          lo sirve por web, siempre al día
     · tools/generar.php lo deja escrito en feed/ para subirlo

   IMPORTANTE: tener el fichero no basta. Hay que darse de alta en
   el portal de comerciantes de OpenAI y que aprueben la cuenta.
   Está explicado en el README.
   ============================================================= */

require_once __DIR__ . '/tienda.php';

if (!defined('TORNAREM_SITIO')) {
    define('TORNAREM_SITIO', 'https://www.tornarem.cat');
}

/* «Caja 60×40×40 cm» → array(60, 40, 40). Devuelve null si no cuadra. */
function tienda_feed_medidas($formato) {
    if (preg_match('/(\d+)\s*[×x]\s*(\d+)\s*[×x]\s*(\d+)/u', (string) $formato, $m)) {
        return array((int) $m[1], (int) $m[2], (int) $m[3]);
    }
    return null;
}

/* «19 kg» → 19.0 */
function tienda_feed_peso($peso) {
    if (preg_match('/([\d.,]+)/', (string) $peso, $m)) {
        return (float) str_replace(',', '.', $m[1]);
    }
    return null;
}

/* La descripción: lo que un agente necesita para contar qué es esto
   sin inventarse nada. Máximo 5.000 caracteres por especificación. */
function tienda_feed_descripcion($l) {
    $partes = array();
    $partes[] = rtrim($l['resumen'], '.') . '.';
    $partes[] = 'Lote cerrado de ' . (int) $l['uds'] . ' unidades procedentes de devoluciones y excedentes, '
        . 'clasificadas y revisadas una a una en nuestra nave de Girona. Grado ' . $l['grado'] . '.';
    if (!empty($l['contenido']) && is_array($l['contenido'])) {
        $partes[] = 'Contenido: ' . implode('; ', $l['contenido']) . '.';
    }
    if (!empty($l['nota'])) {
        $partes[] = $l['nota'];
    }
    $partes[] = 'Formato ' . $l['formato'] . ', ' . $l['peso'] . '. '
        . 'Precio final con IVA y transporte incluidos en península. '
        . 'Se paga contrarreembolso o con tarjeta. Entrega en 24 horas en península '
        . '(24-48 h en los que viajan en palé).';
    $partes[] = 'Tornarem es un liquidador independiente. Amazon es una marca registrada de '
        . 'Amazon.com, Inc. o sus filiales; no existe afiliación, patrocinio ni respaldo por su parte.';
    $texto = implode(' ', $partes);
    return mb_substr($texto, 0, 5000, 'UTF-8');
}

/* Una fila por lote, con los nombres de campo exactos de la
   especificación. Los lotes desactivados no salen: no están a la
   venta y no tienen que aparecer en ningún sitio. */
function tienda_feed_filas() {
    $lotes = tienda_lotes();
    $filas = array();

    foreach ($lotes as $l) {
        if (empty($l['activo'])) {
            continue;
        }
        $slug = preg_replace('/^lote-/', '', $l['id']);
        $med = tienda_feed_medidas($l['formato']);
        $peso = tienda_feed_peso($l['peso']);
        $esPale = !empty($l['es_pale']);
        /* El palé mixto se vende cerrado y sin devolución: está avisado
           en su ficha y tiene que estar avisado aquí también. */
        $admiteDevolucion = ($l['id'] !== 'lote-pale-mixto');

        $fila = array(
            /* --- los nueve obligatorios --- */
            'item_id'      => $l['ref'],
            'title'        => mb_substr($l['nombre'] . ' · Lote de devoluciones de Amazon, '
                                . (int) $l['uds'] . ' unidades', 0, 150, 'UTF-8'),
            'description'  => tienda_feed_descripcion($l),
            'url'          => TORNAREM_SITIO . '/lotes/' . $slug . '.html',
            'brand'        => 'Tornarem',
            'seller_name'  => 'Tornarem',
            'image_url'    => TORNAREM_SITIO . '/' . $l['img'],
            'availability' => ((int) $l['stock'] > 0) ? 'in_stock' : 'out_of_stock',
            'price'        => number_format((float) $l['precio'], 2, '.', '') . ' EUR',

            /* --- los que ayudan --- */
            'condition'        => ($l['grado'] === 'A') ? 'new' : 'used',
            'product_category' => $l['categoria'],
            'mpn'              => $l['ref'],
            'seller_url'       => TORNAREM_SITIO . '/',
            'shipping_price'   => '0.00 EUR',
            'accepts_returns'  => $admiteDevolucion ? 'true' : 'false',
            'target_countries' => 'ES',
            'store_country'    => 'ES',
            'is_digital'       => 'false',
            'seller_tos'       => TORNAREM_SITIO . '/legal.html#condiciones',
            'seller_privacy_policy' => TORNAREM_SITIO . '/legal.html#privacidad',
        );
        if ($admiteDevolucion) {
            $fila['return_deadline_in_days'] = '14';
            $fila['return_policy'] = TORNAREM_SITIO . '/legal.html#garantia';
        }
        if ($med) {
            $fila['length'] = (string) $med[0];
            $fila['width']  = (string) $med[1];
            $fila['height'] = (string) $med[2];
            $fila['dimensions_unit'] = 'cm';
        }
        if ($peso !== null) {
            $fila['weight'] = (string) $peso;
            $fila['item_weight_unit'] = 'kg';
        }
        $fila['shipping'] = $esPale
            ? 'ES::Transporte paletizado:0.00 EUR'
            : 'ES::Agencia 24 h:0.00 EUR';

        $filas[] = $fila;
    }
    return $filas;
}

/* JSONL: una línea de JSON por producto. Es el formato que
   recomienda OpenAI y el que menos se rompe al editarlo. */
function tienda_feed_jsonl() {
    $out = '';
    foreach (tienda_feed_filas() as $f) {
        $out .= json_encode($f, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n";
    }
    return $out;
}

/* CSV con todas las columnas, aunque una fila no use alguna: un CSV
   con filas de distinto ancho no lo lee nadie. */
function tienda_feed_csv() {
    $filas = tienda_feed_filas();
    if (!$filas) {
        return '';
    }
    $columnas = array();
    foreach ($filas as $f) {
        foreach (array_keys($f) as $k) {
            if (!in_array($k, $columnas, true)) {
                $columnas[] = $k;
            }
        }
    }
    $celda = function ($v) {
        $s = (string) $v;
        if (strpbrk($s, ",\"\n\r") !== false) {
            $s = '"' . str_replace('"', '""', $s) . '"';
        }
        return $s;
    };
    $lineas = array(implode(',', $columnas));
    foreach ($filas as $f) {
        $fila = array();
        foreach ($columnas as $c) {
            $fila[] = $celda(isset($f[$c]) ? $f[$c] : '');
        }
        $lineas[] = implode(',', $fila);
    }
    return implode("\n", $lineas) . "\n";
}
