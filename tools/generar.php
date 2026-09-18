<?php
/* =============================================================
   TORNAREM — generador de páginas estáticas (SEO)

   Qué hace: lee el catálogo (lib/catalogo.js) y los ficheros de
   contenido de tools/contenido/, y escribe HTML plano en la raíz
   del sitio. El resultado no necesita PHP para verse: son páginas
   estáticas normales, igual que index.html.

   Por qué existe: son casi cuarenta páginas que comparten cinta,
   menú, pie, carrito y ficha de lote. Copiar ese armazón a mano
   cuarenta veces es garantía de que un día el menú del blog deje
   de parecerse al de la portada.

   Cómo se usa:      php tools/generar.php
   Sólo mirar:       php tools/generar.php --listar

   Después de tocar cualquier contenido hay que volver a lanzarlo.
   ============================================================= */

if (PHP_SAPI !== 'cli') {
    header('HTTP/1.1 403 Forbidden');
    exit('Este fichero sólo se ejecuta por consola.');
}

$RAIZ = dirname(__DIR__);
require_once $RAIZ . '/lib/tienda.php';

define('SITIO', 'https://www.tornarem.cat');
define('VER', '20260918');          /* rompe la caché de css/js */
define('HOY', date('Y-m-d'));

$CAT = tienda_catalogo_base();
$LOTES = array();
foreach ($CAT['lotes'] as $l) { $LOTES[$l['id']] = $l; }
$MARCA = isset($CAT['marca']) ? $CAT['marca'] : 'Tornarem';
$CONTACTO = isset($CAT['contacto']) ? $CAT['contacto'] : array();


/* =============================================================
   1. UTILIDADES
   ============================================================= */

function e($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }

/* Prefijo para volver a la raíz desde una página en subcarpeta:
   "blog/x.html" → "../"  ·  "x.html" → "" */
function base_de($ruta) {
    $hondo = substr_count($ruta, '/');
    return str_repeat('../', $hondo);
}

/* URL absoluta y canónica de una página. La portada es el dominio a
   secas: index.html y / son la misma página y Google tiene que verlo. */
function url_de($ruta) {
    if ($ruta === 'index.html') { return SITIO . '/'; }
    return SITIO . '/' . $ruta;
}

function eur($n) {
    $s = number_format((float) $n, 0, ',', '.');
    return $s . ' €';
}

function dto($l) { return (int) round((1 - $l['precio'] / $l['pvp']) * 100); }

/* JSON-LD: sin barras escapadas (quedan feas en las URL) y sin que
   una cadena pueda cerrar el <script> por sorpresa. */
function jsonld($datos) {
    $j = json_encode($datos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    return str_replace('</', '<\/', $j);
}


/* =============================================================
   2. TROZOS COMPARTIDOS (cinta, menú, pie, carrito)
   ============================================================= */

function bloque_cinta($items) {
    $h = "<div class=\"ticker\" aria-hidden=\"true\">\n  <div class=\"ticker-track\" data-ticker>\n";
    foreach ($items as $t) { $h .= '    <span class="ticker-item">' . e($t) . "</span>\n"; }
    return $h . "  </div>\n</div>\n";
}

/* Los enlaces del menú. Se escriben una vez y valen para las cuarenta. */
function menu_principal($b) {
    return array(
        array('Lotes',        $b . 'index.html#lotes'),
        array('Cómo funciona', $b . 'index.html#como'),
        array('Grados',       $b . 'index.html#grados'),
        array('Guías',        $b . 'blog/index.html'),
        array('Preguntas',    $b . 'index.html#faq'),
    );
}

function bloque_nav($b) {
    $links = '';
    foreach (menu_principal($b) as $l) {
        $links .= '      <a href="' . e($l[1]) . '">' . e($l[0]) . "</a>\n";
    }
    $movil = $links
        . '  <a href="' . e($b) . 'comprar-devoluciones-de-amazon.html">Comprar devoluciones</a>' . "\n"
        . '  <a href="' . e($b) . 'palets-de-devoluciones-de-amazon.html">Palés</a>' . "\n"
        . '  <a href="' . e($b) . 'index.html#pago">Pago y envío</a>' . "\n"
        . '  <a href="' . e($b) . 'checkout.html">Tramitar pedido</a>' . "\n";

    return '<header class="nav">
  <div class="wrap nav-inner">
    <a class="brand" href="' . e($b) . 'index.html" aria-label="Tornarem, inicio">
      <svg class="brand-mark" viewBox="0 0 64 64" aria-hidden="true"><rect width="64" height="64" fill="#111111"/><path d="M14 26h26v-8l12 12-12 12v-8H14z" fill="#ff4d00"/><rect x="12" y="44" width="40" height="6" fill="#ffffff"/></svg>
      <span>Tornarem</span>
      <small>Lotes de devoluciones</small>
    </a>

    <nav class="nav-links" aria-label="Principal">
' . $links . '    </nav>

    <div class="nav-right">
      <button class="btn btn-solid nav-cart" type="button" data-cart-open aria-controls="carrito" aria-expanded="false">
        Carrito <span class="nav-cart-count" data-cart-count>0</span>
      </button>
      <button class="nav-burger" type="button" data-menu-toggle aria-label="Abrir menú" aria-expanded="false" aria-controls="menu-movil"><span></span></button>
    </div>
  </div>
</header>
<nav class="nav-menu" id="menu-movil" data-menu aria-label="Menú móvil">
' . $movil . '</nav>
';
}

/* Migas de pan visibles. Las de datos estructurados se montan aparte
   con la misma lista, para que no se puedan contradecir. */
function bloque_migas($migas) {
    $partes = array();
    foreach ($migas as $m) {
        $partes[] = isset($m['u']) && $m['u'] !== null
            ? '<a href="' . e($m['u']) . '">' . e($m['t']) . '</a>'
            : e($m['t']);
    }
    return '<p class="crumbs">' . implode(' › ', $partes) . '</p>';
}

function schema_migas($migas, $b) {
    $items = array();
    $i = 1;
    foreach ($migas as $m) {
        $nodo = array('@type' => 'ListItem', 'position' => $i, 'name' => $m['t']);
        if (isset($m['u']) && $m['u'] !== null) {
            /* El enlace del menú es relativo a la página; el dato
               estructurado tiene que ser absoluto. */
            $rel = preg_replace('#^(\.\./)+#', '', $m['u']);
            $nodo['item'] = ($rel === 'index.html') ? SITIO . '/' : SITIO . '/' . $rel;
        }
        $items[] = $nodo;
        $i++;
    }
    return array('@type' => 'BreadcrumbList', 'itemListElement' => $items);
}

function bloque_pie($b, $extra) {
    $guias = '';
    foreach ($extra as $l) {
        $guias .= '          <li><a href="' . e($b . $l[1]) . '">' . e($l[0]) . "</a></li>\n";
    }
    return '<footer class="footer" id="contacto">
  <div class="wrap">
    <div class="footer-grid">
      <div>
        <a class="brand" href="' . e($b) . 'index.html" aria-label="Tornarem, inicio">
          <svg class="brand-mark" viewBox="0 0 64 64" aria-hidden="true"><rect width="64" height="64" fill="#ffffff"/><path d="M14 26h26v-8l12 12-12 12v-8H14z" fill="#ff4d00"/><rect x="12" y="44" width="40" height="6" fill="#111111"/></svg>
          <span>Tornarem</span>
        </a>
        <p class="footer-disclaimer">Tornarem es un liquidador independiente de excedentes y devoluciones. Amazon es una marca registrada de Amazon.com, Inc. o sus filiales. No existe ninguna afiliación, patrocinio ni respaldo por su parte.</p>
      </div>
      <div>
        <h4>Comprar</h4>
        <ul>
' . $guias . '        </ul>
      </div>
      <div>
        <h4>Pedidos</h4>
        <ul>
          <li><a href="tel:+34900000000">900 000 000</a></li>
          <li><a href="https://wa.me/34600000000" target="_blank" rel="noopener">WhatsApp</a></li>
          <li><a href="mailto:pedidos@tornarem.cat">pedidos@tornarem.cat</a></li>
          <li><a href="' . e($b) . 'blog/index.html">Guías y blog</a></li>
        </ul>
      </div>
      <div>
        <h4>La nave</h4>
        <p>Nave 14 · Polígono Mas Xirgu<br>17005 Girona</p>
        <p>Lunes a viernes<br>8:00–18:00</p>
      </div>
      <div>
        <h4>Legal</h4>
        <ul>
          <li><a href="' . e($b) . 'legal.html#aviso">Aviso legal</a></li>
          <li><a href="' . e($b) . 'legal.html#privacidad">Privacidad</a></li>
          <li><a href="' . e($b) . 'legal.html#condiciones">Condiciones de venta</a></li>
          <li><a href="' . e($b) . 'legal.html#garantia">Garantía y reclamaciones</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© ' . date('Y') . ' Tornarem · Girona · Precios con IVA · Fotografías ilustrativas</span>
      <span>Actualizado ' . date('d/m/Y') . ' · <a class="footer-panel" href="' . e($b) . 'admin/index.html" rel="nofollow">Panel</a></span>
    </div>
  </div>
</footer>
';
}

function bloque_carrito($b) {
    return '<div class="drawer-backdrop" data-cart-backdrop></div>
<aside class="drawer" id="carrito" data-cart aria-label="Carrito" aria-hidden="true">
  <div class="drawer-head">
    <h2>Tu carrito <span class="mono" data-cart-count-2>(0)</span></h2>
    <button class="drawer-close" type="button" data-cart-close aria-label="Cerrar carrito">×</button>
  </div>
  <div class="drawer-items" data-cart-items>
    <div class="drawer-empty">
      <span>Todavía no hay ningún lote.</span>
      <a class="btn btn-solid" href="' . e($b) . 'index.html#lotes">Ver los lotes</a>
    </div>
  </div>
  <div class="drawer-foot">
    <div class="drawer-row"><span>Subtotal</span><b data-cart-subtotal>0 €</b></div>
    <p class="drawer-note">IVA y envío 24 h incluidos · Contrarreembolso +3 % al tramitar</p>
    <a class="btn btn-accent btn-block" href="' . e($b) . 'checkout.html" data-cart-checkout>Tramitar pedido</a>
  </div>
</aside>

<dialog class="lote-dialog" data-lote-dialog aria-labelledby="dlg-title">
  <button class="dlg-close" type="button" data-dialog-close aria-label="Cerrar ficha">×</button>
  <div class="dlg-grid">
    <figure class="dlg-fig"><img data-dlg-img src="" alt=""></figure>
    <div class="dlg-body">
      <p class="lote-meta" data-dlg-meta></p>
      <h2 id="dlg-title" data-dlg-title></h2>
      <p data-dlg-resumen></p>
      <ul data-dlg-contenido></ul>
      <p class="dlg-nota" data-dlg-nota></p>
      <div class="dlg-price">
        <span class="precio" data-dlg-precio></span>
        <span class="off" data-dlg-off></span>
        <span class="pvp" data-dlg-pvp></span>
      </div>
      <p class="lote-stock" data-dlg-stock></p>
      <div class="dlg-actions">
        <button class="btn btn-accent" type="button" data-dlg-add>Añadir al carrito</button>
        <button class="btn btn-line" type="button" data-dialog-close>Seguir mirando</button>
      </div>
    </div>
  </div>
</dialog>

<div class="toast" data-toast role="status" aria-live="polite"></div>
';
}


/* =============================================================
   3. TARJETAS DE LOTE

   Mismo marcado que la portada a propósito: main.js engancha el
   carrito, la ficha y el stock real por [data-lote] y [data-add],
   así que una tarjeta generada aquí funciona igual que la de casa.
   ============================================================= */

function tarjeta_lote($l, $b, $i) {
    global $LOTES;
    $esPale = preg_match('/pal[eé]/i', $l['formato']) === 1;
    $palabra = $esPale ? 'palé' : 'lote';
    $casillas = 6;
    $llenas = max(0, min((int) $l['stock'], $casillas));
    $barras = '';
    for ($k = 0; $k < $casillas; $k++) { $barras .= ($k < $llenas) ? '<i></i>' : '<i class="off"></i>'; }
    $texto = $l['stock'] > 0
        ? ($l['stock'] === 1 ? 'Queda 1 ' . $palabra : 'Quedan ' . $l['stock'] . ' ' . $palabra . 's')
        : 'Agotado';
    $bajo = $l['stock'] <= 2 ? ' is-low' : '';
    $gradoClase = ($l['grado'] === 'B') ? ' sticker--yellow' : (($l['grado'] === 'Sin clasificar') ? ' sticker--ink' : '');
    $ficha = $b . 'lotes/' . slug_de_lote($l['id']) . '.html';

    $apagado = $l['stock'] > 0 ? '' : ' disabled';
    $textoBoton = $l['stock'] > 0 ? 'Añadir al carrito' : 'Agotado';

    return '      <article class="lote rv" data-lote="' . e($l['id']) . '" data-precio="' . (int) $l['precio'] . '" data-pvp="' . (int) $l['pvp'] . '" data-uds="' . (int) $l['uds'] . '" data-index="' . (int) $i . '">
        <a class="lote-fig" href="' . e($ficha) . '" aria-label="Ver la ficha del lote ' . e($l['nombre']) . '">
          <img src="' . e($b . $l['img']) . '" width="1536" height="1024" alt="' . e('Lote de ' . mb_strtolower($l['nombre'], 'UTF-8') . ': ' . rtrim($l['resumen'], '.')) . '" loading="lazy" decoding="async">
          <span class="sticker' . $gradoClase . '">Grado ' . e($l['grado']) . '</span>
        </a>
        <div class="lote-body">
          <p class="lote-meta">Ref ' . e($l['ref']) . ' · ' . (int) $l['uds'] . ' uds · ' . e($l['formato']) . ' · ' . e($l['peso']) . '</p>
          <h3 class="lote-title"><a href="' . e($ficha) . '">' . e($l['nombre']) . '</a></h3>
          <p class="lote-desc">' . e($l['resumen']) . '</p>
          <div class="lote-price"><span class="pvp">PVP estimado <s>' . e(eur($l['pvp'])) . '</s></span><span class="precio">' . e(eur($l['precio'])) . '</span><span class="off">−' . dto($l) . ' %</span><span class="iva">IVA y envío incl.</span></div>
          <p class="lote-stock' . $bajo . '"><span class="stock-bar" aria-hidden="true">' . $barras . '</span>' . e($texto) . '</p>
        </div>
        <div class="lote-actions">
          <button class="btn btn-accent" type="button" data-add="' . e($l['id']) . '"' . $apagado . '>' . e($textoBoton) . '</button>
          <a class="btn btn-line" href="' . e($ficha) . '">Ver ficha</a>
        </div>
        <div class="barcode" aria-hidden="true"></div>
      </article>
';
}

/* El identificador del lote ya es un slug; se le quita el prefijo para
   que la URL quede /lotes/electronica.html y no /lotes/lote-electronica.html */
function slug_de_lote($id) { return preg_replace('/^lote-/', '', $id); }

function rejilla_lotes($ids, $b, $titulo, $lead) {
    global $LOTES;
    $cards = '';
    $i = 1;
    foreach ($ids as $id) {
        if (!isset($LOTES[$id])) { continue; }
        $cards .= tarjeta_lote($LOTES[$id], $b, $i);
        $i++;
    }
    if ($cards === '') { return ''; }
    $cab = '';
    if ($titulo !== '') {
        $cab = '    <header class="sec-head rv">
      <p class="sec-num">En venta hoy</p>
      <h2 class="sec-title">' . e($titulo) . '</h2>
      <p class="sec-lead">' . e($lead) . '</p>
    </header>
';
    }
    return '<section class="sec sec--concrete" id="lotes">
  <div class="wrap">
' . $cab . '    <div class="grid12 lotes" data-lotes>
' . $cards . '    </div>
    <p class="lotes-pie"><a class="btn btn-line" href="' . e($b) . 'index.html#lotes">Ver el catálogo completo</a></p>
  </div>
</section>
';
}


/* =============================================================
   4. PREGUNTAS FRECUENTES
   ============================================================= */

function bloque_faq($faq) {
    if (!$faq) { return ''; }
    $items = '';
    foreach ($faq as $f) {
        $items .= '        <details class="faq-item">
          <summary>' . e($f['p']) . '</summary>
          <p>' . $f['r'] . '</p>
        </details>
';
    }
    return '<section class="sec" id="faq">
  <div class="wrap">
    <header class="sec-head rv">
      <p class="sec-num">Preguntas</p>
      <h2 class="sec-title">Lo que nos preguntáis</h2>
    </header>
    <div class="faq-cols rv">
      <div class="faq">
' . $items . '      </div>
    </div>
  </div>
</section>
';
}

function schema_faq($faq) {
    $items = array();
    foreach ($faq as $f) {
        $items[] = array(
            '@type' => 'Question',
            'name' => $f['p'],
            'acceptedAnswer' => array('@type' => 'Answer', 'text' => trim(strip_tags($f['r']))),
        );
    }
    return array('@type' => 'FAQPage', 'mainEntity' => $items);
}


/* =============================================================
   5. ENLACES RELACIONADOS Y LLAMADA FINAL
   ============================================================= */

function bloque_relacionados($rels, $b, $titulo) {
    if (!$rels) { return ''; }
    $items = '';
    foreach ($rels as $r) {
        $items .= '      <a class="enlace-card" href="' . e($b . $r['u']) . '">
        <span class="enlace-kicker">' . e(isset($r['k']) ? $r['k'] : 'Seguir leyendo') . '</span>
        <h3>' . e($r['t']) . '</h3>
        <p>' . e($r['d']) . '</p>
      </a>
';
    }
    return '<section class="sec sec--kraft">
  <div class="wrap">
    <header class="sec-head rv">
      <p class="sec-num">Más</p>
      <h2 class="sec-title">' . e($titulo) . '</h2>
    </header>
    <div class="enlaces rv">
' . $items . '    </div>
  </div>
</section>
';
}

/* Formulario de avisos. Va en las páginas donde la gente llega
   leyendo (blog, ciudades, fichas) y no necesariamente a comprar hoy:
   si no se lleva un lote, que al menos deje el correo. Lo recoge
   aviso.php y sale en el panel, en Almacén → Avisos. */
function bloque_aviso($p, $b) {
    global $CAT;
    $opciones = '<option value="Cualquier categoría">Cualquier categoría</option>';
    foreach ($CAT['lotes'] as $l) {
        $sel = (!empty($p['avisoInteres']) && $p['avisoInteres'] === $l['categoria']) ? ' selected' : '';
        $opciones .= '<option value="' . e($l['categoria']) . '"' . $sel . '>' . e($l['categoria']) . '</option>';
    }
    $pc = isset($CAT['proximoCamion']['titulo']) ? $CAT['proximoCamion']['titulo'] : 'una categoría nueva';

    return '<section class="sec aviso" id="aviso">
  <div class="wrap aviso-grid">
    <div class="rv">
      <p class="kicker">Lista de avisos</p>
      <h2>¿No está lo que buscas?</h2>
      <p>Cada jueves descarga un camión nuevo y la categoría cambia. El siguiente trae <b>' . e($pc) . '</b>. Déjanos el correo y te escribimos el día que entre lo tuyo o vuelva a haber stock de un lote agotado.</p>
      <p class="aviso-nota">Un correo cuando hay novedad, y para de contar. Ni spam, ni venta de datos, ni nada raro. Te borras contestando «baja».</p>
    </div>
    <form class="aviso-form rv" data-aviso method="post" action="' . e($b) . 'aviso.php" novalidate>
      <label for="aviso-email">Tu correo</label>
      <input id="aviso-email" type="email" name="email" required autocomplete="email" inputmode="email" placeholder="tucorreo@ejemplo.com">

      <label for="aviso-interes">Qué te interesa</label>
      <select id="aviso-interes" name="interes">' . $opciones . '</select>

      <div class="aviso-trampa" aria-hidden="true">
        <label for="aviso-web">No rellenes esto</label>
        <input id="aviso-web" type="text" name="web" tabindex="-1" autocomplete="off">
      </div>
      <input type="hidden" name="origen" value="' . e($p['ruta']) . '">

      <button class="btn btn-solid" type="submit" data-aviso-enviar>Avísame cuando entre</button>
      <p class="aviso-ok" data-aviso-mensaje hidden role="status" aria-live="polite"></p>
    </form>
  </div>
</section>
';
}

function bloque_cta($b, $titulo, $texto) {
    return '<section class="sec cta-final">
  <div class="wrap cta-grid">
    <div>
      <p class="kicker">Stock de hoy</p>
      <h2 class="sec-title">' . e($titulo) . '</h2>
      <p class="sec-lead">' . e($texto) . '</p>
    </div>
    <div class="cta-acciones">
      <a class="btn btn-accent" href="' . e($b) . 'index.html#lotes">Ver los lotes en venta</a>
      <a class="btn btn-line" href="https://wa.me/34600000000?text=Hola%2C%20quiero%20informaci%C3%B3n%20sobre%20los%20lotes" target="_blank" rel="noopener">Preguntar por WhatsApp</a>
      <p class="cta-nota">Contrarreembolso o tarjeta · Entrega en 24 h en península · Factura con IVA</p>
    </div>
  </div>
</section>
';
}


/* =============================================================
   6. LA PLANTILLA COMPLETA
   ============================================================= */

function render($p) {
    global $LOTES;
    $b = base_de($p['ruta']);
    $url = url_de($p['ruta']);
    $img = isset($p['img']) ? $p['img'] : 'assets/img/hero-almacen.webp';

    /* --- datos estructurados --- */
    $grafo = array();
    if (isset($p['migas'])) { $grafo[] = schema_migas($p['migas'], $b); }
    if (!empty($p['faq'])) { $grafo[] = schema_faq($p['faq']); }
    if (!empty($p['schema'])) { foreach ($p['schema'] as $s) { $grafo[] = $s; } }
    $ld = '';
    if ($grafo) {
        $ld = '<script type="application/ld+json">' . jsonld(array('@context' => 'https://schema.org', '@graph' => $grafo)) . "</script>\n";
    }

    /* --- cuerpo ---
       Los bloques normales van dentro de una columna de texto; los
       que traen HTML propio ('crudo') salen fuera, porque son
       secciones enteras con su propio ancho. */
    $prosa = '';
    $cuerpo = '';
    $cerrar = function () use (&$cuerpo, &$prosa) {
        if ($cuerpo === '') { return; }
        $prosa .= '<section class="sec sec--articulo">
  <div class="wrap">
    <div class="prose rv">
' . $cuerpo . '    </div>
  </div>
</section>
';
        $cuerpo = '';
    };
    foreach ((isset($p['bloques']) ? $p['bloques'] : array()) as $s) {
        if (isset($s['crudo'])) { $cerrar(); $prosa .= $s['crudo']; continue; }
        $id = isset($s['id']) ? ' id="' . e($s['id']) . '"' : '';
        $cuerpo .= '    <h2' . $id . '>' . e($s['h2']) . "</h2>\n" . $s['html'] . "\n";
    }
    $cerrar();

    $lotes = !empty($p['lotes'])
        ? rejilla_lotes($p['lotes'], $b, isset($p['lotesTitulo']) ? $p['lotesTitulo'] : 'Lotes disponibles ahora mismo',
            isset($p['lotesLead']) ? $p['lotesLead'] : 'Precio final con IVA y envío incluido. El stock se actualiza solo: lo que ves es lo que queda en la nave.')
        : '';

    $cinta = isset($p['cinta']) ? $p['cinta'] : array(
        'Entrega en 24 h en península', 'Contrarreembolso o tarjeta', 'Lotes cerrados desde 319 €',
        'Camión nuevo cada semana', 'Factura con IVA', 'Recogida gratis en nave',
    );

    $pieEnlaces = array(
        array('Comprar devoluciones de Amazon', 'comprar-devoluciones-de-amazon.html'),
        array('Palés de devoluciones', 'palets-de-devoluciones-de-amazon.html'),
        array('Lotes de devoluciones', 'lotes-de-devoluciones-de-amazon.html'),
        array('Cajas misteriosas', 'cajas-misteriosas-amazon.html'),
        array('Liquidación de stock', 'liquidacion-de-stock-amazon.html'),
        array('Venta al por mayor', 'devoluciones-de-amazon-al-por-mayor.html'),
    );

    $hero = isset($p['hero']) ? $p['hero'] : bloque_cabecera($p, $b);

    $extraHead = isset($p['head']) ? $p['head'] : '';
    $noindex = !empty($p['noindex']) ? '<meta name="robots" content="noindex, follow">' . "\n" : '';

    return '<!DOCTYPE html>
<html lang="es" data-base="' . e($b) . '">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>' . e($p['titulo']) . '</title>
<meta name="description" content="' . e($p['desc']) . '">
<meta name="theme-color" content="#111111">
' . $noindex . '<link rel="canonical" href="' . e($url) . '">

<meta property="og:type" content="' . e(isset($p['ogTipo']) ? $p['ogTipo'] : 'website') . '">
<meta property="og:title" content="' . e(isset($p['ogTitulo']) ? $p['ogTitulo'] : $p['h1']) . '">
<meta property="og:description" content="' . e($p['desc']) . '">
<meta property="og:image" content="' . e(SITIO . '/' . $img) . '">
<meta property="og:url" content="' . e($url) . '">
<meta property="og:locale" content="es_ES">
<meta property="og:site_name" content="Tornarem">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="' . e(isset($p['ogTitulo']) ? $p['ogTitulo'] : $p['h1']) . '">
<meta name="twitter:description" content="' . e($p['desc']) . '">
<meta name="twitter:image" content="' . e(SITIO . '/' . $img) . '">

<link rel="icon" href="' . e($b) . 'assets/favicon.svg" type="image/svg+xml">
<link rel="preload" as="font" type="font/woff2" href="' . e($b) . 'assets/fonts/archivo-black-400-latin.woff2" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="' . e($b) . 'assets/fonts/ibm-plex-mono-400-latin.woff2" crossorigin>
<link rel="stylesheet" href="' . e($b) . 'styles.css?v=' . VER . '">
' . $ld . $extraHead . '</head>

<body>
<a class="skip-link" href="#main">Saltar al contenido</a>

' . bloque_cinta($cinta) . '
' . bloque_nav($b) . '
<main id="main">

' . $hero . $prosa . $lotes . bloque_faq(isset($p['faq']) ? $p['faq'] : array())
    . bloque_relacionados(isset($p['relacionados']) ? $p['relacionados'] : array(), $b, isset($p['relTitulo']) ? $p['relTitulo'] : 'Sigue por aquí')
    . (!empty($p['aviso']) ? bloque_aviso($p, $b) : '')
    . bloque_cta($b, isset($p['ctaTitulo']) ? $p['ctaTitulo'] : 'Hoy hay lotes en la nave',
        isset($p['ctaTexto']) ? $p['ctaTexto'] : 'Confirma antes de las 14:00 y sale hoy mismo. Pagas al recibirlo o con tarjeta, como prefieras.') . '
</main>

' . bloque_pie($b, $pieEnlaces) . '
' . bloque_carrito($b) . '
<script defer src="' . e($b) . 'lib/catalogo.js?v=' . VER . '"></script>
<script defer src="' . e($b) . 'main.js?v=' . VER . '"></script>
</body>
</html>
';
}

/* Cabecera estándar: migas, kicker, h1, entradilla y foto. */
function bloque_cabecera($p, $b) {
    $migas = isset($p['migas']) ? bloque_migas(array_map(function ($m) use ($b) {
        if (isset($m['u']) && $m['u'] !== null) { $m['u'] = $b . $m['u']; }
        return $m;
    }, $p['migas'])) : '';

    $fig = '';
    if (!empty($p['img'])) {
        $fig = '    <figure class="page-fig">
      <img src="' . e($b . $p['img']) . '" width="1536" height="1024" alt="' . e(isset($p['imgAlt']) ? $p['imgAlt'] : $p['h1']) . '" fetchpriority="high" loading="eager" decoding="sync">
      <figcaption><span>Nave 14 · Pol. Mas Xirgu · Girona</span><span>Stock propio</span></figcaption>
    </figure>
';
    }

    $datos = '';
    if (!empty($p['datos'])) {
        $celdas = '';
        foreach ($p['datos'] as $d) {
            $celdas .= '      <div><div class="stat-num">' . $d[0] . '</div><div class="stat-label">' . e($d[1]) . '</div></div>' . "\n";
        }
        $datos = '  <div class="wrap">
    <div class="grid12 stats">
' . $celdas . '    </div>
  </div>
';
    }

    return '<section class="page-head page-head--seo">
  <div class="wrap page-head-grid">
    <div>
      ' . $migas . '
      <p class="kicker">' . e(isset($p['kicker']) ? $p['kicker'] : 'Tornarem') . '</p>
      <h1>' . e($p['h1']) . '</h1>
      <p class="page-lead">' . $p['entradilla'] . '</p>
      <div class="hero-cta">
        <a class="btn btn-accent" href="' . e($b) . 'index.html#lotes">Ver lotes en venta</a>
        <a class="btn btn-line" href="' . e($b) . 'index.html#como">Cómo funciona</a>
      </div>
    </div>
' . $fig . '  </div>
' . $datos . '</section>
';
}


/* =============================================================
   7. ESCRIBIR
   ============================================================= */

$PAGINAS = array();
require $RAIZ . '/tools/contenido/categorias.php';
require $RAIZ . '/tools/contenido/landings.php';
require $RAIZ . '/tools/contenido/ciudades.php';
require $RAIZ . '/tools/contenido/blog.php';

$soloListar = in_array('--listar', $argv, true);
$escritas = 0;

foreach ($PAGINAS as $p) {
    $destino = $RAIZ . '/' . $p['ruta'];
    if ($soloListar) { echo '  ' . $p['ruta'] . "\n"; continue; }
    $dir = dirname($destino);
    if (!is_dir($dir)) { mkdir($dir, 0755, true); }
    file_put_contents($destino, render($p));
    $escritas++;
}

/* --- sitemap --- */
if (!$soloListar) {
    $urls = array(array('u' => SITIO . '/', 'p' => '1.0', 'f' => 'daily'));
    foreach ($PAGINAS as $p) {
        if (!empty($p['noindex'])) { continue; }
        $urls[] = array(
            'u' => url_de($p['ruta']),
            'p' => isset($p['prioridad']) ? $p['prioridad'] : '0.6',
            'f' => isset($p['frecuencia']) ? $p['frecuencia'] : 'weekly',
        );
    }
    $x = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
       . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $x .= "  <url>\n    <loc>" . htmlspecialchars($u['u'], ENT_XML1) . "</loc>\n"
            . '    <lastmod>' . HOY . "</lastmod>\n"
            . '    <changefreq>' . $u['f'] . "</changefreq>\n"
            . '    <priority>' . $u['p'] . "</priority>\n  </url>\n";
    }
    $x .= "</urlset>\n";
    file_put_contents($RAIZ . '/sitemap.xml', $x);

    /* --- robots.txt --- */
    $robots = "# Tornarem\n"
        . "User-agent: *\n"
        . "Allow: /\n"
        . "Disallow: /admin/\n"
        . "Disallow: /datos/\n"
        . "Disallow: /checkout.html\n"
        . "Disallow: /gracias.html\n"
        . "Disallow: /pedido.php\n"
        . "Disallow: /aviso.php\n"
        . "Disallow: /estado.php\n"
        . "\n"
        . "Sitemap: " . SITIO . "/sitemap.xml\n";
    file_put_contents($RAIZ . '/robots.txt', $robots);

    /* --- datos estructurados de la portada ---
       index.html se mantiene a mano, pero los precios y el stock viven
       en el catálogo. En vez de copiarlos (y que se queden viejos), se
       reescribe el bloque entre las dos marcas cada vez que se genera. */
    $home = $RAIZ . '/index.html';
    $html = @file_get_contents($home);
    if ($html !== false && strpos($html, 'datos-estructurados:inicio') !== false) {
        $items = array();
        $n = 1;
        foreach ($CAT['lotes'] as $l) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $n,
                'url' => SITIO . '/lotes/' . slug_de_lote($l['id']) . '.html',
                'name' => $l['nombre'],
            );
            $n++;
        }

        /* Las preguntas de la portada, leídas del propio HTML para que no
           puedan decir una cosa en pantalla y otra en el dato estructurado. */
        $faq = array();
        if (preg_match_all('#<details class="faq-item">\s*<summary>(.*?)</summary>\s*<p>(.*?)</p>#s', $html, $m, PREG_SET_ORDER)) {
            foreach ($m as $par) {
                $faq[] = array(
                    '@type' => 'Question',
                    'name' => html_entity_decode(trim(strip_tags($par[1])), ENT_QUOTES, 'UTF-8'),
                    'acceptedAnswer' => array('@type' => 'Answer',
                        'text' => html_entity_decode(trim(strip_tags($par[2])), ENT_QUOTES, 'UTF-8')),
                );
            }
        }

        $grafo = array(
            array(
                '@type' => 'Organization',
                '@id' => SITIO . '/#organizacion',
                'name' => 'Tornarem',
                'url' => SITIO . '/',
                'logo' => SITIO . '/assets/favicon.svg',
                'image' => SITIO . '/assets/img/hero-almacen.webp',
                'description' => 'Liquidador independiente de devoluciones y excedentes. Venta de lotes y palés con factura, contrarreembolso o tarjeta y entrega en 24 h.',
                'email' => isset($CONTACTO['email']) ? $CONTACTO['email'] : '',
                'telephone' => '+34900000000',
                'address' => array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Nave 14, Polígono Mas Xirgu',
                    'postalCode' => '17005',
                    'addressLocality' => 'Girona',
                    'addressRegion' => 'Girona',
                    'addressCountry' => 'ES',
                ),
                'areaServed' => array('@type' => 'Country', 'name' => 'España'),
                'disambiguatingDescription' => 'Tornarem no está afiliada, patrocinada ni respaldada por Amazon.com, Inc. ni por sus filiales.',
            ),
            array(
                '@type' => 'WebSite',
                '@id' => SITIO . '/#web',
                'url' => SITIO . '/',
                'name' => 'Tornarem',
                'inLanguage' => 'es-ES',
                'publisher' => array('@id' => SITIO . '/#organizacion'),
            ),
            array(
                '@type' => 'ItemList',
                'name' => 'Lotes de devoluciones de Amazon en venta',
                'numberOfItems' => count($items),
                'itemListElement' => $items,
            ),
        );
        if ($faq) { $grafo[] = array('@type' => 'FAQPage', 'mainEntity' => $faq); }

        $bloque = "<!-- datos-estructurados:inicio · los reescribe tools/generar.php con los precios del catálogo -->\n"
            . '<script type="application/ld+json">' . jsonld(array('@context' => 'https://schema.org', '@graph' => $grafo)) . "</script>\n"
            . '<!-- datos-estructurados:fin -->';
        $nuevo = preg_replace('#<!-- datos-estructurados:inicio.*?datos-estructurados:fin -->#s', $bloque, $html, 1);
        if ($nuevo !== null && $nuevo !== $html) {
            file_put_contents($home, $nuevo);
            echo "Datos estructurados de index.html actualizados (" . count($faq) . " preguntas).\n";
        }
    }

    echo "Generadas " . $escritas . " páginas + sitemap.xml (" . count($urls) . " URL) + robots.txt.\n";
}
