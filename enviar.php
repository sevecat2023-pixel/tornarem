<?php
/* =============================================================
   TORNAREM TELECOM — recepción de los formularios de la web

   Funciona en cualquier hosting con PHP (Hostinger lo trae de serie).
   No necesita librerías ni composer: se sube y ya está.

   Responde de dos maneras según quién pregunte:
   - Con JavaScript, el navegador pide JSON y se queda en la página.
   - Sin JavaScript, el formulario se envía a pelo y aterriza en
     gracias.html (o vuelve al formulario con el error en la URL).
   ============================================================= */

/* -------------------------------------------------------------
   1. CONFIGURACIÓN — lo único que hay que tocar
   ------------------------------------------------------------- */

/* A dónde llegan los avisos. Puedes poner varias separadas por coma. */
$DESTINO           = 'hola@tornarem.cat';
$DESTINO_EMPRESAS  = 'hola@tornarem.cat';

/* Desde qué dirección sale el correo.
   IMPORTANTE: tiene que ser una cuenta del propio dominio o los
   servidores lo tirarán a spam. Créala en hPanel → Correos. */
$REMITENTE         = 'web@tornarem.cat';
$REMITENTE_NOMBRE  = 'Web de Tornarem';

/* Copia de seguridad en disco por si el correo falla.
   Deja la cadena vacía para desactivarlo. */
$REGISTRO          = __DIR__ . '/solicitudes.log';

/* -------------------------------------------------------------
   2. De aquí para abajo no hace falta tocar nada
   ------------------------------------------------------------- */

mb_internal_encoding('UTF-8');

/* ¿Nos están pidiendo JSON? (fetch desde main.js) */
$quiereJson =
  (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) ||
  (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'fetch');

function responder($ok, $mensaje, $codigo = 200) {
    global $quiereJson;

    if ($quiereJson) {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'mensaje' => $mensaje], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* Sin JavaScript: acierto → página de gracias; error → una página
       propia con el motivo, porque un redirect con el error en la URL
       no se vería sin JavaScript que lo pinte. */
    if ($ok) {
        header('Location: gracias.html', true, 303);
        exit;
    }

    http_response_code($codigo);
    header('Content-Type: text/html; charset=utf-8');
    $m = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>No hemos podido enviarlo · Tornarem Telecom</title>
<link rel="icon" href="assets/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="styles.css?v=20260810">
</head>
<body>
<main class="section" style="min-height:70vh;display:grid;place-items:center">
  <div class="wrap" style="max-width:34rem;text-align:center">
    <p class="eyebrow" style="justify-content:center">No ha salido</p>
    <h1 class="h2" style="margin-inline:auto">$m</h1>
    <p class="lead" style="margin-top:1.2rem">
      Vuelve atrás y revísalo, o llámanos al
      <a href="tel:+34900000000" style="text-decoration:underline">900 000 000</a>.
      También puedes escribirnos a
      <a href="mailto:hola@tornarem.cat" style="text-decoration:underline">hola@tornarem.cat</a>.
    </p>
    <p style="margin-top:2rem"><a class="btn btn--primary" href="index.html#contacto">Volver al formulario</a></p>
  </div>
</main>
</body>
</html>
HTML;
    exit;
}

/* Sólo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método no permitido.', 405);
}

/* Limpia un valor: recorta, quita saltos de línea (evita inyección de
   cabeceras en el correo) y limita la longitud. */
function limpiar($clave, $max = 400) {
    if (!isset($_POST[$clave])) return '';
    $v = is_array($_POST[$clave]) ? '' : (string) $_POST[$clave];
    $v = str_replace(["\r", "\n", "\0"], ' ', $v);
    $v = trim(preg_replace('/[ \t]+/u', ' ', $v));
    return mb_substr($v, 0, $max);
}

/* El mensaje libre sí puede llevar saltos de línea: nunca va en cabecera. */
function limpiarTexto($clave, $max = 3000) {
    if (!isset($_POST[$clave])) return '';
    $v = is_array($_POST[$clave]) ? '' : (string) $_POST[$clave];
    $v = str_replace(["\r\n", "\r", "\0"], ["\n", "\n", ''], $v);
    return mb_substr(trim($v), 0, $max);
}

/* Cazabobos: un campo escondido que las personas no ven y los robots
   rellenan. Si viene con algo, fingimos que todo ha ido bien. */
if (limpiar('empresa_web') !== '') {
    responder(true, 'Recibido.');
}

$origen    = limpiar('origen') === 'empresas' ? 'empresas' : 'portada';
$esEmpresa = $origen === 'empresas';

$nombre    = limpiar('nombre', 120);
$telefono  = limpiar('telefono', 40);
$municipio = limpiar('municipio', 120);
$email     = limpiar('email', 160);
$empresa   = limpiar('empresa', 160);
$interes   = limpiar($esEmpresa ? 'servicio' : 'interes', 80);
$mensaje   = limpiarTexto('mensaje');

/* Validación mínima, la misma que pide el HTML */
$faltan = [];
if ($nombre === '')                       $faltan[] = 'el nombre';
if ($telefono === '')                     $faltan[] = 'el teléfono';
if ($municipio === '')                    $faltan[] = 'el municipio';
if ($esEmpresa && $empresa === '')        $faltan[] = 'la empresa';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'La dirección de correo no parece válida.', 422);
}
if ($faltan) {
    responder(false, 'Falta ' . implode(', ', $faltan) . '.', 422);
}
/* Un teléfono debe tener dígitos suficientes para serlo */
if (preg_match_all('/\d/', $telefono) < 9) {
    responder(false, 'El teléfono no parece completo.', 422);
}

/* ---- Montamos el correo ---- */
$asunto = $esEmpresa
    ? 'Presupuesto de empresa · ' . ($empresa !== '' ? $empresa : $nombre)
    : 'Solicitud desde la web · ' . $nombre . ' (' . $municipio . ')';

$lineas = [];
$lineas[] = $esEmpresa ? 'PETICIÓN DE PRESUPUESTO (empresas)' : 'SOLICITUD DE ALTA (particulares)';
$lineas[] = str_repeat('-', 46);
if ($empresa !== '')   $lineas[] = 'Empresa:    ' . $empresa;
$lineas[] = 'Nombre:     ' . $nombre;
$lineas[] = 'Teléfono:   ' . $telefono;
if ($email !== '')     $lineas[] = 'Correo:     ' . $email;
$lineas[] = 'Municipio:  ' . $municipio;
if ($interes !== '')   $lineas[] = ($esEmpresa ? 'Servicio:   ' : 'Interés:    ') . $interes;
$lineas[] = '';
$lineas[] = 'Mensaje:';
$lineas[] = $mensaje !== '' ? $mensaje : '(no ha escrito nada)';
$lineas[] = '';
$lineas[] = str_repeat('-', 46);
$lineas[] = 'Recibido el ' . date('d/m/Y \a \l\a\s H:i');
$lineas[] = 'Página:      ' . ($esEmpresa ? 'empresas.html' : 'index.html');
$lineas[] = 'IP:          ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'desconocida');

$cuerpo = implode("\n", $lineas);

$cabeceras = [];
$cabeceras[] = 'From: ' . mb_encode_mimeheader($REMITENTE_NOMBRE) . ' <' . $REMITENTE . '>';
$cabeceras[] = 'Reply-To: ' . ($email !== '' ? $email : $REMITENTE);
$cabeceras[] = 'Content-Type: text/plain; charset=UTF-8';
$cabeceras[] = 'Content-Transfer-Encoding: 8bit';
$cabeceras[] = 'X-Mailer: tornarem-web';

$para = $esEmpresa ? $DESTINO_EMPRESAS : $DESTINO;

$enviado = @mail(
    $para,
    mb_encode_mimeheader($asunto),
    $cuerpo,
    implode("\r\n", $cabeceras),
    '-f' . $REMITENTE
);

/* Guardamos siempre una copia: si el correo falla, la solicitud no se pierde */
if ($REGISTRO !== '') {
    @file_put_contents(
        $REGISTRO,
        "===== " . date('c') . ($enviado ? " [enviado]" : " [FALLO DE ENVÍO]") . " =====\n" . $cuerpo . "\n\n",
        FILE_APPEND | LOCK_EX
    );
}

if (!$enviado) {
    responder(false, 'No hemos podido enviar el aviso por correo. Llámanos y lo resolvemos al momento.', 500);
}

responder(true, 'Recibido.');
