<?php
/* =============================================================
   TornaBox — pedido.php
   Recibe el formulario del checkout, envía el pedido por email
   y guarda una copia en pedidos.log (protegido por .htaccess).

   CONFIGURA ESTAS DOS LÍNEAS ANTES DE PUBLICAR:
   ============================================================= */
$PARA   = 'pedidos@tornabox.eu';   // ← email donde recibirás los pedidos
$DESDE  = 'web@tornabox.eu';       // ← remitente (un buzón de tu dominio)

/* Precios autoritativos: el total se calcula aquí, nunca se confía
   en lo que venga del navegador. Si cambias precios, cámbialos
   también en index.html y lib/manifest.js. */
$CAJAS = [
  'inicio' => ['nombre' => 'Caja Inicio',       'precio' => 34.95, 'envio_gratis' => false],
  'grande' => ['nombre' => 'Caja Grande',       'precio' => 59.95, 'envio_gratis' => true],
  'tech'   => ['nombre' => 'Caja Tech',         'precio' => 89.95, 'envio_gratis' => true],
  'xxl'    => ['nombre' => 'Caja XXL Reventa',  'precio' => 149.95,'envio_gratis' => true],
];
$ENVIO        = 4.95;   // gastos de envío cuando no toca gratis
$GRATIS_DESDE = 50.00;  // envío gratis a partir de este subtotal
$RECARGO_COD  = 4.95;   // gestión del contra reembolso (tarjeta: sin recargo)
$SEGURO       = 4.95;   // seguro de devolución opcional

/* Escalera de mejora: subir un escalón cuesta lo que dice «precio».
   Debe coincidir con lib/manifest.js → mejoras. */
$MEJORAS = [
  'inicio' => ['a' => 'grande', 'precio' => 19.95],
  'grande' => ['a' => 'tech',   'precio' => 22.95],
  'tech'   => ['a' => 'xxl',    'precio' => 44.95],
];

/* ------------------------------------------------------------- */
header('X-Content-Type-Options: nosniff');

function limpiar($v) {
  $v = trim((string) $v);
  $v = str_replace(["\r", "\n"], ' ', $v);      // sin inyección de cabeceras
  return mb_substr($v, 0, 300);
}
function responder($ok, $num, $ajax, $pago) {
  if ($ajax) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => $ok, 'num' => $num]);
  } else {
    header('Location: gracias.html?p=' . rawurlencode($num) . '&pago=' . rawurlencode($pago), true, 303);
  }
  exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
  http_response_code(405);
  exit('Método no permitido');
}

/* Señuelo antispam: los bots rellenan el campo oculto «web». */
if (!empty($_POST['web'])) {
  responder(true, 'TB-' . date('Y') . '-' . random_int(10000, 99999), !empty($_POST['ajax']), 'reembolso');
}

$ajax      = !empty($_POST['ajax']);
$cajaId    = $_POST['caja'] ?? '';
$caja      = $CAJAS[$cajaId] ?? null;
$nombre    = limpiar($_POST['nombre']    ?? '');
$telefono  = limpiar($_POST['telefono']  ?? '');
$email     = limpiar($_POST['email']     ?? '');
$direccion = limpiar($_POST['direccion'] ?? '');
$numero    = limpiar($_POST['numero']    ?? '');
$piso      = limpiar($_POST['piso']      ?? '');
$cp        = limpiar($_POST['cp']        ?? '');
$poblacion = limpiar($_POST['poblacion'] ?? '');
$provincia = limpiar($_POST['provincia'] ?? '');
$notas     = limpiar($_POST['notas']     ?? '');
$pago      = ($_POST['pago'] ?? '') === 'reembolso' ? 'reembolso' : 'tarjeta';
$mejoraId  = $_POST['mejora'] ?? '';
$conSeguro = !empty($_POST['seguro']);
$num       = limpiar($_POST['num'] ?? '');

if (!$caja || $nombre === '' || $telefono === '' || $direccion === '' || $cp === '' || $poblacion === ''
    || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  if ($ajax) {
    http_response_code(422);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Faltan datos del pedido']);
  } else {
    http_response_code(422);
    echo 'Faltan datos del pedido. Vuelve atrás y revisa el formulario.';
  }
  exit;
}

if (!preg_match('/^TB-\d{4}-\d{5}$/', $num)) {
  $num = 'TB-' . date('Y') . '-' . random_int(10000, 99999);
}

/* Recorremos la escalera desde la caja pedida hasta la mejorada, sumando
   el precio de cada escalón. Si la mejora no es alcanzable, se ignora. */
$subtotal = $caja['precio'];
$cajaFinal = $cajaId;
if ($mejoraId !== '' && isset($CAJAS[$mejoraId]) && $mejoraId !== $cajaId) {
  $paso = $cajaId; $extra = 0.0; $guarda = 0;
  while ($paso !== $mejoraId && isset($MEJORAS[$paso]) && $guarda++ < 6) {
    $extra += $MEJORAS[$paso]['precio'];
    $paso = $MEJORAS[$paso]['a'];
  }
  if ($paso === $mejoraId) {          // escalera válida
    $subtotal += $extra;
    $cajaFinal = $mejoraId;
    $caja = $CAJAS[$cajaFinal];
  }
}
$envio    = ($caja['envio_gratis'] || $subtotal >= $GRATIS_DESDE) ? 0.0 : $ENVIO;
$recargo  = $pago === 'reembolso' ? $RECARGO_COD : 0.0;
$seguro   = $conSeguro ? $SEGURO : 0.0;
$total    = $subtotal + $envio + $recargo + $seguro;
$e       = fn($n) => number_format($n, 2, ',', '.') . ' €';

$cuerpo = "NUEVO PEDIDO {$num}\n"
        . str_repeat('=', 46) . "\n\n"
        . "Caja:       {$caja['nombre']}" . ($cajaFinal !== $cajaId ? "  (mejorada desde {$CAJAS[$cajaId]['nombre']})" : '') . "\n"
        . "Precio:     {$e($subtotal)}\n"
        . "Envío:      " . ($envio > 0 ? $e($envio) : 'Gratis') . "\n"
        . ($seguro > 0 ? "Seguro dev: {$e($seguro)}  (30 días + recogida a domicilio)\n" : '')
        . ($recargo > 0 ? "Reembolso:  {$e($recargo)}\n" : '')
        . "TOTAL:      {$e($total)}\n"
        . "Pago:       " . ($pago === 'tarjeta'
              ? "TARJETA → envía el enlace de pago al cliente si no usaste pasarela automática"
              : "CONTRA REEMBOLSO → cobra el repartidor") . "\n\n"
        . "Cliente:    {$nombre}\n"
        . "Teléfono:   {$telefono}\n"
        . "Email:      {$email}\n"
        . "Dirección:  {$direccion} {$numero}" . ($piso !== '' ? ", {$piso}" : '') . "\n"
        . "CP/Ciudad:  {$cp} {$poblacion} ({$provincia})\n"
        . ($notas !== '' ? "Notas:      {$notas}\n" : '')
        . "\nFecha:      " . date('d/m/Y H:i') . "\n";

/* Copia local de seguridad (por si el correo falla). El acceso web
   a pedidos.log está bloqueado en .htaccess. */
@file_put_contents(__DIR__ . '/pedidos.log', $cuerpo . "\n" . str_repeat('-', 46) . "\n", FILE_APPEND | LOCK_EX);

$asunto = "📦 Pedido {$num} · {$caja['nombre']} · {$e($total)} · " . ($pago === 'tarjeta' ? 'Tarjeta' : 'Reembolso');
$cab  = "From: TornaBox <{$DESDE}>\r\n"
      . "Reply-To: {$nombre} <{$email}>\r\n"
      . "Content-Type: text/plain; charset=UTF-8\r\n";
@mail($PARA, '=?UTF-8?B?' . base64_encode($asunto) . '?=', $cuerpo, $cab);

responder(true, $num, $ajax, $pago);
