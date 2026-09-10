<?php
/* =============================================================
   TORNAREM — albarán de entrega de un pedido

   Se abre desde la ficha del pedido en el panel: admin/albaran.php?numero=TR-...
   Es una página pensada para el papel, no para la pantalla: A4, blanco y
   negro, y el importe a cobrar en grande cuando el pedido va
   contrarreembolso, que es el dato que mira el transportista.

   Pide sesión igual que el resto del panel: dentro van los datos
   personales del cliente.
   ============================================================= */

ini_set('display_errors', '0');
error_reporting(E_ALL);

mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Madrid');

header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');
header('Referrer-Policy: same-origin');
header('X-Robots-Tag: noindex, nofollow');

$rutaDatos = dirname(__DIR__) . '/lib/tienda.php';
if (!is_file($rutaDatos)) {
    http_response_code(500);
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Albarán</title></head>'
       . '<body><p>Falta la capa de datos en el servidor.</p></body></html>';
    exit;
}
require_once $rutaDatos;

function alb_e($v) {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/* Página mínima para cuando no hay nada que imprimir. */
function alb_aviso($titulo, $texto, $codigo) {
    http_response_code($codigo);
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="utf-8">'
       . '<meta name="viewport" content="width=device-width,initial-scale=1">'
       . '<meta name="robots" content="noindex">'
       . '<title>' . alb_e($titulo) . ' · Tornarem</title>'
       . '<style>body{margin:0;padding:3rem 1.5rem;background:#f1f0ec;color:#111;'
       . 'font-family:"IBM Plex Sans",system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}'
       . 'div{max-width:34rem;margin:0 auto;background:#fff;border:1px solid #dcdad3;padding:1.5rem}'
       . 'h1{margin:0 0 .5rem;font-size:1.25rem;text-transform:uppercase;letter-spacing:.04em}'
       . 'a{color:#111}</style></head><body><div><h1>' . alb_e($titulo) . '</h1>'
       . '<p>' . alb_e($texto) . '</p><p><a href="index.html">Volver al panel</a></p></div></body></html>';
    exit;
}

/* La etiqueta de un estado puede venir como texto o como array con
   etiqueta y color: aquí sólo hace falta el texto. */
function alb_etiqueta($mapa, $clave, $porDefecto) {
    if (!is_array($mapa) || !isset($mapa[$clave])) return $porDefecto;
    $v = $mapa[$clave];
    if (is_array($v)) {
        if (isset($v['etiqueta'])) return (string) $v['etiqueta'];
        if (isset($v['label'])) return (string) $v['label'];
        return $porDefecto;
    }
    return (string) $v;
}

function alb_fecha($iso, $conHora) {
    $iso = trim((string) $iso);
    if ($iso === '') return '';
    $t = strtotime($iso);
    if ($t === false) return $iso;
    return date($conHora ? 'd/m/Y \a \l\a\s H:i' : 'd/m/Y', $t);
}

try {
    tienda_asegurar_datos();
    tienda_sesion();
    /* session_start() pisa la cabecera de caché: se vuelve a poner. */
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    if (!tienda_sesion_activa()) {
        alb_aviso('Sesión caducada', 'Entra otra vez en el panel para imprimir el albarán.', 401);
    }

    $numero = isset($_GET['numero']) ? strtoupper(trim((string) $_GET['numero'])) : '';
    /* Se comprueba el formato ANTES de buscar el fichero. */
    if (!preg_match('/^TR-\d{6}-[A-Z0-9]{4}$/', $numero)) {
        alb_aviso('Número no válido', 'Ese número de pedido no tiene el formato de Tornarem.', 400);
    }

    $pedido = tienda_pedido($numero);
    if (!is_array($pedido) || !count($pedido)) {
        alb_aviso('Pedido no encontrado', 'No hay ningún pedido con el número ' . $numero . '.', 404);
    }
} catch (Throwable $e) {
    error_log('[albaran] ' . $e->getMessage());
    alb_aviso('Error', 'No se ha podido preparar el albarán.', 500);
}

/* ---- Datos del pedido, con valores por defecto: la ficha viene del
       disco y nunca damos por hecho que están todas las claves ---- */
$cliente  = isset($pedido['cliente']) && is_array($pedido['cliente']) ? $pedido['cliente'] : [];
$lineas   = isset($pedido['lineas']) && is_array($pedido['lineas']) ? $pedido['lineas'] : [];
$importes = isset($pedido['importes']) && is_array($pedido['importes']) ? $pedido['importes'] : [];
$pago     = isset($pedido['pago']) && is_array($pedido['pago']) ? $pedido['pago'] : [];
$envio    = isset($pedido['envio']) && is_array($pedido['envio']) ? $pedido['envio'] : [];

$cval = function ($k) use ($cliente) { return isset($cliente[$k]) ? (string) $cliente[$k] : ''; };

$subtotal = isset($importes['subtotal']) ? (float) $importes['subtotal'] : 0;
$recargo  = isset($importes['recargo']) ? (float) $importes['recargo'] : 0;
$total    = isset($importes['total']) ? (float) $importes['total'] : 0;

$metodoPago = isset($pago['metodo']) ? (string) $pago['metodo'] : 'contrarreembolso';
$estadoPago = isset($pago['estado']) ? (string) $pago['estado'] : 'pendiente';
$refPago    = isset($pago['referencia']) ? (string) $pago['referencia'] : '';

$esContrarreembolso = ($metodoPago === 'contrarreembolso');
$cobrado = ($estadoPago === 'pagado' || $estadoPago === 'cobrado_entrega');

$estados     = tienda_estados();
$estadosPago = tienda_estados_pago();
$estadoPedido = isset($pedido['estado']) ? (string) $pedido['estado'] : '';
$etiquetaEstado = alb_etiqueta($estados, $estadoPedido, $estadoPedido);
$etiquetaPago   = alb_etiqueta($estadosPago, $estadoPago, $estadoPago);

$catalogo = tienda_catalogo_base();
$contacto = (is_array($catalogo) && isset($catalogo['contacto']) && is_array($catalogo['contacto'])) ? $catalogo['contacto'] : [];
$marca    = (is_array($catalogo) && isset($catalogo['marca'])) ? (string) $catalogo['marca'] : 'Tornarem';
$tval = function ($k) use ($contacto) { return isset($contacto[$k]) ? (string) $contacto[$k] : ''; };

$unidades = 0;
foreach ($lineas as $ln) {
    if (is_array($ln) && isset($ln['qty'])) $unidades += (int) $ln['qty'];
}

$esPale = !empty($envio['es_pale']);
$transportista = isset($envio['transportista']) ? (string) $envio['transportista'] : '';
$seguimiento   = isset($envio['seguimiento']) ? (string) $envio['seguimiento'] : '';
$prevista      = isset($envio['fecha_prevista']) ? (string) $envio['fecha_prevista'] : '';

$direccion = trim($cval('direccion'));
$poblacion = trim($cval('cp') . ' ' . $cval('poblacion'));
if ($cval('provincia') !== '') $poblacion = trim($poblacion) . ' (' . $cval('provincia') . ')';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Albarán <?php echo alb_e($numero); ?> · <?php echo alb_e($marca); ?></title>
<link rel="icon" href="../assets/favicon.svg" type="image/svg+xml">
<style>
/* Tipografías del proyecto, servidas desde la propia carpeta assets:
   el albarán se imprime igual aunque el equipo no tenga internet. */
@font-face{font-family:'Archivo Black';font-style:normal;font-weight:400;font-display:swap;
  src:url(../assets/fonts/archivo-black-400-latin.woff2) format('woff2');
  unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;}
@font-face{font-family:'Archivo Black';font-style:normal;font-weight:400;font-display:swap;
  src:url(../assets/fonts/archivo-black-400-latin-ext.woff2) format('woff2');
  unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF;}
@font-face{font-family:'IBM Plex Sans';font-style:normal;font-weight:400 600;font-display:swap;
  src:url(../assets/fonts/ibm-plex-sans-latin.woff2) format('woff2');
  unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;}
@font-face{font-family:'IBM Plex Sans';font-style:normal;font-weight:400 600;font-display:swap;
  src:url(../assets/fonts/ibm-plex-sans-latin-ext.woff2) format('woff2');
  unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF;}
@font-face{font-family:'IBM Plex Mono';font-style:normal;font-weight:400;font-display:swap;
  src:url(../assets/fonts/ibm-plex-mono-400-latin.woff2) format('woff2');
  unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;}
@font-face{font-family:'IBM Plex Mono';font-style:normal;font-weight:600;font-display:swap;
  src:url(../assets/fonts/ibm-plex-mono-600-latin.woff2) format('woff2');
  unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;}

*,*::before,*::after{box-sizing:border-box}
:root{
  --tinta:#111111; --acento:#ff4d00; --papel:#ffffff; --hormigon:#f1f0ec;
  --linea:#dcdad3; --apagado:#6a6862;
  --sans:'IBM Plex Sans',system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;
  --mono:'IBM Plex Mono',ui-monospace,'SFMono-Regular',Menlo,Consolas,monospace;
  --titular:'Archivo Black','Arial Black',Impact,sans-serif;
}
html{-webkit-text-size-adjust:100%}
body{margin:0;padding:1.5rem 1rem 3rem;background:var(--hormigon);color:var(--tinta);
  font-family:var(--sans);font-size:11pt;line-height:1.45;}
.hoja{width:210mm;max-width:100%;margin:0 auto;background:var(--papel);
  border:1px solid var(--linea);padding:14mm;}

/* Barra de botones: en pantalla sí, en papel no */
.mando{width:210mm;max-width:100%;margin:0 auto 1rem;display:flex;gap:.5rem;flex-wrap:wrap;align-items:center}
.mando .hueco{flex:1 1 auto}
.boton{font-family:var(--mono);font-size:.8rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.06em;padding:.55rem 1rem;border:1px solid var(--tinta);background:var(--papel);
  color:var(--tinta);cursor:pointer;text-decoration:none;display:inline-block;border-radius:0}
.boton:hover{background:var(--tinta);color:var(--papel)}
.boton--acento{background:var(--acento);border-color:var(--acento);color:#fff}
.boton--acento:hover{background:var(--tinta);border-color:var(--tinta)}
.boton:focus-visible{outline:3px solid var(--acento);outline-offset:2px}

/* Cabecera */
.cab{display:flex;gap:1rem;justify-content:space-between;align-items:flex-start;
  border-bottom:3px solid var(--tinta);padding-bottom:.75rem}
.cab-marca{font-family:var(--titular);font-size:1.6rem;line-height:1;text-transform:uppercase;letter-spacing:.01em;margin:0}
.cab-claim{font-family:var(--mono);font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:var(--apagado);margin:.35rem 0 0}
.cab-doc{text-align:right}
.cab-tipo{font-family:var(--mono);font-size:.72rem;text-transform:uppercase;letter-spacing:.14em;margin:0 0 .2rem}
.cab-num{font-family:var(--titular);font-size:1.35rem;line-height:1;margin:0;letter-spacing:.02em}
.cab-fecha{font-family:var(--mono);font-size:.78rem;color:var(--apagado);margin:.35rem 0 0}

.estado{display:inline-block;font-family:var(--mono);font-size:.7rem;font-weight:600;
  text-transform:uppercase;letter-spacing:.08em;border:1px solid var(--tinta);padding:.15rem .45rem;margin-top:.4rem}

/* Bloques de direcciones */
.cajas{display:flex;gap:0;margin-top:1rem;border:1px solid var(--linea)}
.caja{flex:1 1 50%;padding:.85rem 1rem;min-width:0}
.caja + .caja{border-left:1px solid var(--linea)}
.caja h2{font-family:var(--mono);font-size:.68rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.12em;color:var(--apagado);margin:0 0 .4rem}
.caja p{margin:0 0 .15rem}
.caja .fuerte{font-weight:600;font-size:1.05rem}
.mono{font-family:var(--mono)}

.datos{display:flex;flex-wrap:wrap;gap:0;margin-top:-1px;border:1px solid var(--linea)}
.dato{flex:1 1 25%;min-width:9rem;padding:.6rem .8rem;border-left:1px solid var(--linea)}
.dato:first-child{border-left:0}
.dato dt{font-family:var(--mono);font-size:.62rem;text-transform:uppercase;letter-spacing:.1em;color:var(--apagado);margin:0}
.dato dd{margin:.15rem 0 0;font-family:var(--mono);font-size:.9rem}

/* Tabla de líneas. En una pantalla estrecha rueda la tabla, no la
   página: así el albarán se puede consultar desde el móvil del almacén. */
.tabla-wrap{overflow-x:auto;margin-top:1.1rem}
table{width:100%;min-width:30rem;border-collapse:collapse}
caption{text-align:left;font-family:var(--mono);font-size:.68rem;text-transform:uppercase;
  letter-spacing:.12em;color:var(--apagado);padding-bottom:.35rem}
th,td{padding:.5rem .5rem;border-bottom:1px solid var(--linea);vertical-align:top;text-align:left}
thead th{font-family:var(--mono);font-size:.66rem;text-transform:uppercase;letter-spacing:.09em;
  border-bottom:2px solid var(--tinta);white-space:nowrap}
.num{text-align:right;font-family:var(--mono);white-space:nowrap}
.lote-nombre{font-weight:600}
.lote-detalle{font-size:.8rem;color:var(--apagado)}
tfoot td{border-bottom:0;padding-top:.4rem}
tfoot .etiqueta{text-align:right;font-family:var(--mono);font-size:.78rem;text-transform:uppercase;letter-spacing:.06em}
tfoot .total .etiqueta,tfoot .total .num{font-size:1.05rem;font-weight:600;border-top:2px solid var(--tinta);padding-top:.5rem}

/* Cobro: lo primero que mira el transportista */
.cobro{margin-top:1.2rem;border:3px solid var(--tinta);padding:.9rem 1rem;display:flex;
  gap:1rem;justify-content:space-between;align-items:center;flex-wrap:wrap}
.cobro--cobrar{border-color:var(--acento)}
.cobro-txt h2{font-family:var(--mono);font-size:.7rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.12em;margin:0 0 .2rem;color:var(--apagado)}
.cobro-txt p{margin:0;font-size:.9rem}
.cobro-cifra{text-align:right}
.cobro-rotulo{font-family:var(--mono);font-size:.66rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.12em;color:var(--apagado);margin-bottom:.15rem}
.cobro-importe{font-family:var(--titular);font-size:2.1rem;line-height:1;white-space:nowrap}
.cobro--cobrar .cobro-importe{color:var(--acento)}
.cobro-nada{font-family:var(--titular);font-size:1.35rem;line-height:1.1;text-transform:uppercase}

.nota{margin-top:1rem;border-left:3px solid var(--tinta);padding:.5rem 0 .5rem .75rem;font-size:.92rem;white-space:pre-line}

/* Firma */
.firmas{display:flex;gap:1.5rem;margin-top:2.2rem;page-break-inside:avoid}
.firma{flex:1 1 50%}
.firma-linea{border-bottom:1px solid var(--tinta);height:3.2rem}
.firma-pie{font-family:var(--mono);font-size:.66rem;text-transform:uppercase;letter-spacing:.09em;
  color:var(--apagado);padding-top:.35rem}
.pie{margin-top:1.5rem;border-top:1px solid var(--linea);padding-top:.6rem;
  font-size:.72rem;color:var(--apagado)}
.pie p{margin:0 0 .2rem}

@media (max-width:640px){
  body{padding:1rem .6rem 2rem}
  .hoja{padding:1rem}
  .cab{flex-direction:column}
  .cab-doc{text-align:left}
  .cajas{flex-direction:column}
  .caja + .caja{border-left:0;border-top:1px solid var(--linea)}
  .dato{flex:1 1 50%}
}

@page{size:A4;margin:12mm}
@media print{
  body{background:#fff;padding:0;font-size:10.5pt}
  .hoja{width:auto;border:0;padding:0;margin:0}
  .mando{display:none}
  .tabla-wrap{overflow:visible}
  table{min-width:0}
  .cobro{border-color:#111}
  .cobro--cobrar .cobro-importe{color:#111;text-decoration:underline}
  tr{page-break-inside:avoid}
  a[href]::after{content:''}
}
</style>
</head>
<body>

<div class="mando">
  <button type="button" class="boton boton--acento" data-imprimir>Imprimir</button>
  <a class="boton" href="index.html#pedidos">Volver al panel</a>
  <span class="hueco"></span>
  <span class="mono" style="font-size:.75rem;color:#6a6862">Albarán de entrega</span>
</div>

<main class="hoja">

  <header class="cab">
    <div>
      <h1 class="cab-marca"><?php echo alb_e($marca); ?></h1>
      <p class="cab-claim"><?php echo alb_e($tval('direccion')); ?></p>
      <p class="cab-claim"><?php echo alb_e($tval('telefono')); ?> · <?php echo alb_e($tval('email')); ?></p>
    </div>
    <div class="cab-doc">
      <p class="cab-tipo">Albarán de entrega</p>
      <p class="cab-num"><?php echo alb_e($numero); ?></p>
      <p class="cab-fecha">Pedido del <?php echo alb_e(alb_fecha(isset($pedido['creado']) ? $pedido['creado'] : '', true)); ?></p>
      <span class="estado"><?php echo alb_e($etiquetaEstado); ?></span>
    </div>
  </header>

  <div class="cajas">
    <section class="caja">
      <h2>Entregar a</h2>
      <p class="fuerte"><?php echo alb_e($cval('nombre')); ?></p>
      <?php if ($cval('empresa') !== '') { ?><p><?php echo alb_e($cval('empresa')); ?></p><?php } ?>
      <p><?php echo alb_e($direccion); ?></p>
      <p><?php echo alb_e($poblacion); ?></p>
      <p class="mono"><?php echo alb_e($cval('telefono')); ?></p>
      <p class="mono"><?php echo alb_e($cval('email')); ?></p>
      <?php if ($cval('nif') !== '') { ?><p class="mono">NIF/CIF <?php echo alb_e($cval('nif')); ?></p><?php } ?>
    </section>
    <section class="caja">
      <h2>Remite</h2>
      <p class="fuerte"><?php echo alb_e($marca); ?></p>
      <p><?php echo alb_e($tval('direccion')); ?></p>
      <p class="mono"><?php echo alb_e($tval('telefono')); ?></p>
      <p class="mono"><?php echo alb_e($tval('email')); ?></p>
      <p><?php echo alb_e($tval('horario')); ?></p>
    </section>
  </div>

  <dl class="datos">
    <div class="dato">
      <dt>Bultos</dt>
      <dd><?php echo (int) $unidades; ?> <?php echo $esPale ? '· palé' : '· caja'; ?></dd>
    </div>
    <div class="dato">
      <dt>Transportista</dt>
      <dd><?php echo alb_e($transportista !== '' ? $transportista : '—'); ?></dd>
    </div>
    <div class="dato">
      <dt>Seguimiento</dt>
      <dd><?php echo alb_e($seguimiento !== '' ? $seguimiento : '—'); ?></dd>
    </div>
    <div class="dato">
      <dt>Entrega prevista</dt>
      <dd><?php echo alb_e($prevista !== '' ? alb_fecha($prevista, false) : '—'); ?></dd>
    </div>
  </dl>

  <div class="tabla-wrap">
  <table>
    <caption>Contenido del envío</caption>
    <thead>
      <tr>
        <th scope="col">Ref.</th>
        <th scope="col">Lote</th>
        <th scope="col">Grado</th>
        <th scope="col" class="num">Uds.</th>
        <th scope="col" class="num">Cant.</th>
        <th scope="col" class="num">Precio</th>
        <th scope="col" class="num">Total</th>
      </tr>
    </thead>
    <tbody>
<?php
if (!count($lineas)) {
    echo '      <tr><td colspan="7">Este pedido no tiene líneas.</td></tr>' . "\n";
}
foreach ($lineas as $ln) {
    if (!is_array($ln)) continue;
    $lnRef     = isset($ln['ref']) ? (string) $ln['ref'] : '';
    $lnNombre  = isset($ln['nombre']) ? (string) $ln['nombre'] : '';
    $lnFormato = isset($ln['formato']) ? (string) $ln['formato'] : '';
    $lnGrado   = isset($ln['grado']) ? (string) $ln['grado'] : '';
    $lnUds     = isset($ln['uds']) ? (string) $ln['uds'] : '';
    $lnQty     = isset($ln['qty']) ? (int) $ln['qty'] : 0;
    $lnPrecio  = isset($ln['precio']) ? (float) $ln['precio'] : 0;
    $lnTotal   = isset($ln['total']) ? (float) $ln['total'] : ($lnQty * $lnPrecio);
    ?>
      <tr>
        <td class="mono"><?php echo alb_e($lnRef); ?></td>
        <td>
          <span class="lote-nombre"><?php echo alb_e($lnNombre); ?></span>
          <?php if ($lnFormato !== '') { ?><br><span class="lote-detalle"><?php echo alb_e($lnFormato); ?></span><?php } ?>
        </td>
        <td class="mono"><?php echo alb_e($lnGrado); ?></td>
        <td class="num"><?php echo alb_e($lnUds); ?></td>
        <td class="num"><?php echo (int) $lnQty; ?></td>
        <td class="num"><?php echo alb_e(tienda_eur($lnPrecio)); ?></td>
        <td class="num"><?php echo alb_e(tienda_eur($lnTotal)); ?></td>
      </tr>
    <?php
}
?>
    </tbody>
    <tfoot>
      <tr>
        <td class="etiqueta" colspan="6">Subtotal (IVA incluido)</td>
        <td class="num"><?php echo alb_e(tienda_eur($subtotal)); ?></td>
      </tr>
      <tr>
        <td class="etiqueta" colspan="6">Recargo contrarreembolso</td>
        <td class="num"><?php echo alb_e(tienda_eur($recargo)); ?></td>
      </tr>
      <tr class="total">
        <td class="etiqueta" colspan="6">Total</td>
        <td class="num"><?php echo alb_e(tienda_eur($total)); ?></td>
      </tr>
    </tfoot>
  </table>
  </div>

  <section class="cobro<?php echo ($esContrarreembolso && !$cobrado) ? ' cobro--cobrar' : ''; ?>">
    <div class="cobro-txt">
      <h2>Forma de pago</h2>
<?php if ($esContrarreembolso && !$cobrado) { ?>
      <p><strong>Contrarreembolso.</strong> Cobrar al entregar, en efectivo o con tarjeta.
         El total ya incluye el recargo de la agencia.</p>
<?php } elseif ($esContrarreembolso) { ?>
      <p><strong>Contrarreembolso ya cobrado</strong> (<?php echo alb_e($etiquetaPago); ?>). No cobrar nada en la entrega.</p>
<?php } elseif ($cobrado) { ?>
      <p><strong>Pagado con tarjeta.</strong> No cobrar nada en la entrega.<?php echo $refPago !== '' ? ' Referencia ' . alb_e($refPago) . '.' : ''; ?></p>
<?php } else { ?>
      <p><strong>Tarjeta: <?php echo alb_e($etiquetaPago); ?>.</strong> No entregar sin confirmar el cobro.<?php echo $refPago !== '' ? ' Referencia ' . alb_e($refPago) . '.' : ''; ?></p>
<?php } ?>
    </div>
<?php if ($esContrarreembolso && !$cobrado) { ?>
    <div class="cobro-cifra">
      <div class="cobro-rotulo">A cobrar en la entrega</div>
      <div class="cobro-importe"><?php echo alb_e(tienda_eur($total)); ?></div>
    </div>
<?php } else { ?>
    <div class="cobro-nada">No cobrar</div>
<?php } ?>
  </section>

<?php if ($cval('notas') !== '') { ?>
  <div class="nota"><strong>Notas del cliente:</strong>
<?php echo alb_e($cval('notas')); ?></div>
<?php } ?>

  <div class="firmas">
    <div class="firma">
      <div class="firma-linea"></div>
      <div class="firma-pie">Firma y DNI de quien recibe</div>
    </div>
    <div class="firma">
      <div class="firma-linea"></div>
      <div class="firma-pie">Fecha y hora de la entrega</div>
    </div>
  </div>

  <footer class="pie">
    <p>Recibí conforme el material descrito. Dispones de 14 días desde la entrega para reclamar
       cualquier unidad de un lote clasificado que no funcione como se describe.</p>
    <p>Albarán impreso el <?php echo alb_e(date('d/m/Y \a \l\a\s H:i')); ?> · <?php echo alb_e($marca); ?> ·
       Liquidador independiente. Amazon es una marca registrada de Amazon.com, Inc.; no existe afiliación ni respaldo por su parte.</p>
  </footer>

</main>

<script>
/* Lo único que hace falta en esta página: el botón de imprimir. */
(function () {
  "use strict";
  var b = document.querySelector("[data-imprimir]");
  if (b) b.addEventListener("click", function () { window.print(); });
})();
</script>
</body>
</html>
