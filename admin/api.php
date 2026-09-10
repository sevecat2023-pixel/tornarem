<?php
/* =============================================================
   TORNAREM — API del panel de administración

   Un único punto de entrada. El panel (admin/app.js) habla con este
   fichero por POST con cuerpo JSON: dentro va la clave «accion» y sus
   parámetros. La respuesta siempre es JSON.

   Sólo dos cosas salen por GET, porque el navegador las abre en una
   pestaña y no puede mandar cuerpo: la acción «exportar» (descarga el
   CSV) y el albarán, que vive en su propio fichero.

   Aquí NO hay lógica de negocio: los datos los pone y los guarda
   lib/tienda.php. Este fichero se encarga de tres cosas y nada más:
   dejar pasar sólo a quien tiene sesión, limpiar y validar lo que
   llega del navegador, y traducir los fallos a códigos HTTP.
   ============================================================= */

/* El cliente sólo debe ver los mensajes que escribimos a mano: si PHP
   suelta un aviso, se queda en el registro del servidor y no se cuela
   en el JSON (rompería el formato y enseñaría rutas del hosting). */
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Madrid');

/* Estas tres van antes que nada: valen para el JSON y para el CSV.
   no-store porque en el panel hay datos personales de clientes y no
   queremos copias en la caché del navegador ni en proxies. */
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');
header('Referrer-Policy: same-origin');

/* La misma marca de versión que el cache-buster del HTML: así el panel
   puede avisar si el navegador se ha quedado con ficheros viejos. */
define('PANEL_VERSION', '20260910');

/* Quién firma los cambios en el historial de cada pedido. */
define('PANEL_AUTOR', 'panel');

/* Formato del número de pedido. Se comprueba SIEMPRE antes de tocar el
   disco: nunca se concatena lo que llega del navegador en una ruta. */
define('PANEL_RE_PEDIDO', '/^TR-\d{6}-[A-Z0-9]{4}$/');

/* -------------------------------------------------------------
   Capa de datos
   ------------------------------------------------------------- */
$panelRutaDatos = dirname(__DIR__) . '/lib/tienda.php';
if (!is_file($panelRutaDatos)) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        ['ok' => false, 'mensaje' => 'Falta la capa de datos en el servidor.'],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    exit;
}
require_once $panelRutaDatos;

/* -------------------------------------------------------------
   Ayudas: respuesta, lectura y limpieza de parámetros
   ------------------------------------------------------------- */

/* Todo lo que sale mal pasa por aquí, con el mismo formato siempre. */
function panel_fallo($mensaje, $codigo = 422, $extra = []) {
    $datos = ['ok' => false, 'mensaje' => $mensaje];
    foreach ($extra as $k => $v) $datos[$k] = $v;
    tienda_responder($datos, $codigo);
}

/* Valor bruto de la entrada, sin adivinar tipos. */
function panel_valor($in, $clave, $porDefecto = '') {
    return (isset($in[$clave]) && !is_array($in[$clave])) ? $in[$clave] : $porDefecto;
}

/* Texto de una sola línea: sin saltos, sin espacios repetidos y cortado. */
function panel_texto($v, $max = 200) {
    $v = is_array($v) ? '' : (string) $v;
    $v = str_replace(["\r", "\n", "\t", "\0"], ' ', $v);
    $v = preg_replace('/ {2,}/u', ' ', $v);
    return mb_substr(trim((string) $v), 0, $max);
}

/* Texto largo (notas): conserva los saltos de línea, quita el resto. */
function panel_parrafo($v, $max = 2000) {
    $v = is_array($v) ? '' : (string) $v;
    $v = str_replace(["\r\n", "\r", "\0"], ["\n", "\n", ''], $v);
    return mb_substr(trim($v), 0, $max);
}

/* Fecha del rango: AAAA-MM-DD o vacío (sin límite por ese lado).
   Cualquier otra cosa es un error del que llama, no una fecha rara. */
function panel_fecha($v) {
    $v = panel_texto($v, 32);
    if ($v === '') return '';
    if (strlen($v) > 10) $v = substr($v, 0, 10);   /* por si llega con hora */
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $v, $m)) {
        panel_fallo('Las fechas tienen que ir en formato AAAA-MM-DD.', 422);
    }
    if (!checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
        panel_fallo('Esa fecha no existe en el calendario.', 422);
    }
    return $v;
}

function panel_entero($v, $min, $max, $porDefecto) {
    if (is_array($v) || $v === '' || $v === null || !is_numeric($v)) return $porDefecto;
    $n = (int) $v;
    if ($n < $min) $n = $min;
    if ($n > $max) $n = $max;
    return $n;
}

function panel_booleano($v) {
    if (is_bool($v)) return $v;
    if (is_numeric($v)) return ((float) $v) != 0;
    $v = strtolower(trim((string) $v));
    return ($v === 'true' || $v === 'si' || $v === 'sí' || $v === 'on' || $v === '1');
}

/* Número de pedido validado. Sin esto no se abre ningún fichero. */
function panel_numero($v) {
    $n = strtoupper(panel_texto($v, 20));
    if (!preg_match(PANEL_RE_PEDIDO, $n)) panel_fallo('El número de pedido no es válido.', 422);
    return $n;
}

/* Ficha completa o 404. Devuelve el array del pedido. */
function panel_pedido($v) {
    $numero = panel_numero($v);
    $pedido = tienda_pedido($numero);
    if (!is_array($pedido) || !count($pedido)) panel_fallo('No existe el pedido ' . $numero . '.', 404);
    return $pedido;
}

/* Los filtros de la lista de pedidos, del CSV y de los clientes.
   Se validan contra listas cerradas: lo que no está, no pasa. */
function panel_filtros($in, $conOrden) {
    $estados = tienda_estados();
    $f = [];
    $f['desde'] = panel_fecha(panel_valor($in, 'desde'));
    $f['hasta'] = panel_fecha(panel_valor($in, 'hasta'));
    /* Si vienen del revés se cambian: es más útil que devolver un error. */
    if ($f['desde'] !== '' && $f['hasta'] !== '' && $f['desde'] > $f['hasta']) {
        $t = $f['desde']; $f['desde'] = $f['hasta']; $f['hasta'] = $t;
    }
    $estado = panel_texto(panel_valor($in, 'estado'), 24);
    $f['estado'] = (is_array($estados) && isset($estados[$estado])) ? $estado : '';
    $pago = panel_texto(panel_valor($in, 'pago'), 24);
    $f['pago'] = ($pago === 'contrarreembolso' || $pago === 'tarjeta') ? $pago : '';
    $f['q'] = panel_texto(panel_valor($in, 'q'), 120);
    if ($conOrden) {
        $orden = panel_texto(panel_valor($in, 'orden'), 20);
        $f['orden'] = in_array($orden, ['creado', 'total', 'nombre', 'estado'], true) ? $orden : 'creado';
        $dir = strtolower(panel_texto(panel_valor($in, 'direccion'), 8));
        $f['direccion'] = ($dir === 'asc') ? 'asc' : 'desc';
        $f['pagina'] = panel_entero(panel_valor($in, 'pagina'), 1, 100000, 1);
        $f['por_pagina'] = panel_entero(panel_valor($in, 'por_pagina'), 1, 200, 25);
    }
    return $f;
}

/* Unidades vendidas de cada lote, contadas de las fichas reales.
   La línea del índice sólo guarda el total de unidades del pedido, así
   que para saber cuántas se han vendido DE CADA lote hay que abrir las
   fichas. Los cancelados no cuentan: su stock vuelve al almacén. */
function panel_vendidos() {
    $vendidos = [];
    /* Si la capa de datos ya lo cuenta, mejor: lleva su propio tope de
       fichas leídas para no quedarse colgada con miles de pedidos. */
    if (function_exists('tienda_vendidos')) {
        $filas = tienda_vendidos('', '');
        if (is_array($filas)) {
            foreach ($filas as $id => $fila) {
                if (is_array($fila)) $vendidos[(string) $id] = isset($fila['qty']) ? (int) $fila['qty'] : 0;
                else $vendidos[(string) $id] = (int) $fila;
            }
        }
        return $vendidos;
    }
    $indice = tienda_indice();
    if (!is_array($indice)) return $vendidos;
    foreach ($indice as $linea) {
        if (!is_array($linea) || !isset($linea['numero'])) continue;
        if (isset($linea['estado']) && $linea['estado'] === 'cancelado') continue;
        $numero = (string) $linea['numero'];
        if (!preg_match(PANEL_RE_PEDIDO, $numero)) continue;
        $pedido = tienda_pedido($numero);
        if (!is_array($pedido) || !isset($pedido['lineas']) || !is_array($pedido['lineas'])) continue;
        foreach ($pedido['lineas'] as $ln) {
            if (!is_array($ln) || !isset($ln['id'])) continue;
            $id = (string) $ln['id'];
            if ($id === '') continue;
            if (!isset($vendidos[$id])) $vendidos[$id] = 0;
            $vendidos[$id] += isset($ln['qty']) ? (int) $ln['qty'] : 0;
        }
    }
    return $vendidos;
}

/* Marca la sesión como entrada. La capa de datos tiene su propia forma
   de abrirla (y de caducarla a las horas), así que si está, manda ella;
   si no, se marca a mano. Identificador nuevo en los dos casos: si
   alguien había fijado el de la cookie antes de que se escribiera la
   contraseña, ese ya no vale para nada. */
function panel_entrar() {
    if (function_exists('tienda_sesion_abrir')) {
        tienda_sesion_abrir();
        return;
    }
    if (session_status() === PHP_SESSION_ACTIVE) session_regenerate_id(true);
    $_SESSION['admin'] = true;
    $_SESSION['visto'] = time();
}

/* Cierra la sesión y borra la cookie: al salir no queda nada. */
function panel_salir() {
    if (function_exists('tienda_sesion_cerrar')) {
        tienda_sesion_cerrar();
        return;
    }
    $_SESSION = [];
    if (!headers_sent() && ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            isset($p['path']) ? $p['path'] : '/',
            isset($p['domain']) ? $p['domain'] : '',
            isset($p['secure']) ? $p['secure'] : false,
            isset($p['httponly']) ? $p['httponly'] : true
        );
    }
    if (session_status() === PHP_SESSION_ACTIVE) session_destroy();
}

/* -------------------------------------------------------------
   Entrada: método, cuerpo y acción
   ------------------------------------------------------------- */
try {
    tienda_asegurar_datos();
    tienda_sesion();
    /* session_start() manda su propia cabecera de caché y pisa la de
       arriba: la volvemos a poner para que no quede nada guardado. */
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

    $metodo = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';

    if ($metodo === 'POST') {
        $in = tienda_entrada_json();
        /* Si alguien manda un formulario clásico también lo entendemos. */
        if (!is_array($in) || !count($in)) $in = is_array($_POST) ? $_POST : [];
    } else {
        $in = is_array($_GET) ? $_GET : [];
    }

    $accion = panel_texto(panel_valor($in, 'accion'), 40);
    if ($accion === '') panel_fallo('Petición mal formada: falta la acción.', 400);

    /* Por GET sólo se descarga el CSV; todo lo demás va por POST. */
    if ($metodo !== 'POST' && $accion !== 'exportar') {
        panel_fallo('Esta acción sólo se atiende por POST.', 400);
    }

    /* ---- Acciones abiertas: las tres que se usan sin sesión ---- */
    if ($accion === 'estado_sesion') {
        $catalogo = tienda_catalogo_base();
        $marca = (is_array($catalogo) && isset($catalogo['marca'])) ? (string) $catalogo['marca'] : 'Tornarem';
        tienda_responder([
            'ok'              => true,
            'autenticado'     => tienda_sesion_activa(),
            'setup_pendiente' => !tienda_admin_existe(),
            'csrf'            => tienda_csrf(),
            'marca'           => $marca,
            'version'         => PANEL_VERSION,
            'bloqueo'         => tienda_intentos_bloqueado(),
        ]);
    }

    if ($accion === 'crear_admin') {
        /* Sólo la primera vez. Después, la contraseña se cambia desde
           Ajustes con la actual delante. */
        if (tienda_admin_existe()) panel_fallo('Ya hay una contraseña creada: entra con ella.', 403);
        $password = (string) panel_valor($in, 'password');
        if (mb_strlen($password) < 8) panel_fallo('La contraseña necesita ocho caracteres como mínimo.', 422);
        if (!tienda_admin_crear($password)) panel_fallo('No se ha podido guardar la contraseña.', 500);
        panel_entrar();
        tienda_responder(['ok' => true, 'autenticado' => tienda_sesion_activa(), 'csrf' => tienda_csrf()]);
    }

    if ($accion === 'entrar') {
        $espera = tienda_intentos_bloqueado();
        if ($espera > 0) {
            panel_fallo(
                'Demasiados intentos fallidos. Vuelve a probar dentro de ' . ceil($espera / 60) . ' min.',
                429,
                ['segundos' => $espera]
            );
        }
        if (!tienda_admin_existe()) panel_fallo('Todavía no hay contraseña: crea una para entrar.', 422, ['setup_pendiente' => true]);
        $password = (string) panel_valor($in, 'password');
        if ($password === '') panel_fallo('Escribe la contraseña.', 422);
        if (!tienda_admin_verificar($password)) {
            $espera = tienda_intentos_bloqueado();
            if ($espera > 0) {
                panel_fallo(
                    'Demasiados intentos fallidos. Vuelve a probar dentro de ' . ceil($espera / 60) . ' min.',
                    429,
                    ['segundos' => $espera]
                );
            }
            panel_fallo('La contraseña no es correcta.', 401);
        }
        panel_entrar();
        tienda_responder(['ok' => true, 'autenticado' => tienda_sesion_activa(), 'csrf' => tienda_csrf()]);
    }

    if ($accion === 'salir') {
        panel_salir();
        tienda_responder(['ok' => true, 'autenticado' => false]);
    }

    /* ---- De aquí para abajo hace falta sesión ---- */
    if (!tienda_sesion_activa()) {
        tienda_responder(['ok' => false, 'mensaje' => 'Sesión caducada.', 'sesion' => false], 401);
    }

    /* ---- Y para escribir, además, el testigo CSRF ----
       Con la sesión abierta, cualquier página podría hacer que el
       navegador enviara una petición al panel. El testigo va en una
       cabecera propia: sólo lo pone quien ha leído la página. */
    $escriben = [
        'cambiar_estado', 'cambiar_pago', 'guardar_envio', 'guardar_cliente',
        'anadir_nota', 'estado_lote', 'guardar_lote', 'cambiar_password',
    ];
    if (in_array($accion, $escriben, true)) {
        $token = null;
        if (isset($_SERVER['HTTP_X_CSRF'])) $token = (string) $_SERVER['HTTP_X_CSRF'];
        elseif (isset($in['csrf']) && !is_array($in['csrf'])) $token = (string) $in['csrf'];
        if (!tienda_csrf_valido($token)) {
            tienda_responder(['ok' => false, 'mensaje' => 'La sesión no coincide. Recarga el panel y repite el cambio.'], 403);
        }
    }

    switch ($accion) {

        /* ---- Inicio ---- */
        case 'resumen': {
            $f = panel_filtros($in, false);
            tienda_responder([
                'ok'      => true,
                'desde'   => $f['desde'],
                'hasta'   => $f['hasta'],
                'resumen' => tienda_resumen($f['desde'], $f['hasta']),
            ]);
            break;
        }

        /* ---- Lista de pedidos ---- */
        case 'pedidos': {
            $f = panel_filtros($in, true);
            $r = tienda_buscar_pedidos($f);
            if (!is_array($r)) $r = [];
            tienda_responder([
                'ok'         => true,
                'total'      => isset($r['total']) ? (int) $r['total'] : 0,
                'paginas'    => isset($r['paginas']) ? (int) $r['paginas'] : 1,
                'pagina'     => isset($r['pagina']) ? (int) $r['pagina'] : $f['pagina'],
                'pedidos'    => isset($r['pedidos']) && is_array($r['pedidos']) ? array_values($r['pedidos']) : [],
                'suma'       => isset($r['suma']) ? (float) $r['suma'] : 0,
                'unidades'   => isset($r['unidades']) ? (int) $r['unidades'] : 0,
                'por_pagina' => $f['por_pagina'],
            ]);
            break;
        }

        /* ---- Ficha de un pedido ---- */
        case 'pedido': {
            $pedido = panel_pedido(panel_valor($in, 'numero'));
            tienda_responder([
                'ok'     => true,
                'pedido' => $pedido,
                'lotes'  => (object) tienda_lotes(),
            ]);
            break;
        }

        /* ---- Estado del pedido (mueve el stock en la capa de datos) ---- */
        case 'cambiar_estado': {
            $numero = panel_numero(panel_valor($in, 'numero'));
            $estado = panel_texto(panel_valor($in, 'estado'), 24);
            $estados = tienda_estados();
            if (!is_array($estados) || !isset($estados[$estado])) panel_fallo('Ese estado no existe.', 422);
            $actual = tienda_pedido($numero);
            if (!is_array($actual) || !count($actual)) panel_fallo('No existe el pedido ' . $numero . '.', 404);
            $nota = panel_parrafo(panel_valor($in, 'nota'), 500);
            $pedido = tienda_cambiar_estado($numero, $estado, $nota, PANEL_AUTOR);
            tienda_responder(['ok' => true, 'pedido' => $pedido]);
            break;
        }

        /* ---- Estado del cobro ---- */
        case 'cambiar_pago': {
            $pedido = panel_pedido(panel_valor($in, 'numero'));
            $estado = panel_texto(panel_valor($in, 'estado'), 24);
            $estadosPago = tienda_estados_pago();
            if (!is_array($estadosPago) || !isset($estadosPago[$estado])) panel_fallo('Ese estado de pago no existe.', 422);
            $referencia = panel_texto(panel_valor($in, 'referencia'), 80);

            if (!isset($pedido['pago']) || !is_array($pedido['pago'])) $pedido['pago'] = [];
            $antes = isset($pedido['pago']['estado']) ? (string) $pedido['pago']['estado'] : '';
            $pedido['pago']['estado'] = $estado;
            $pedido['pago']['referencia'] = $referencia;
            if ($antes !== $estado) {
                tienda_historial($pedido, 'Cobro: ' . $antes . ' → ' . $estado, PANEL_AUTOR);
            } else {
                tienda_historial($pedido, 'Referencia de cobro actualizada.', PANEL_AUTOR);
            }
            if (!tienda_guardar_pedido($pedido)) panel_fallo('No se ha podido guardar el pedido.', 500);
            tienda_responder(['ok' => true, 'pedido' => $pedido]);
            break;
        }

        /* ---- Transportista y seguimiento ---- */
        case 'guardar_envio': {
            $pedido = panel_pedido(panel_valor($in, 'numero'));
            $transportista = panel_texto(panel_valor($in, 'transportista'), 60);
            $seguimiento = panel_texto(panel_valor($in, 'seguimiento'), 60);

            if (!isset($pedido['envio']) || !is_array($pedido['envio'])) $pedido['envio'] = [];
            $pedido['envio']['transportista'] = $transportista;
            $pedido['envio']['seguimiento'] = $seguimiento;
            $texto = 'Envío: ' . ($transportista !== '' ? $transportista : 'sin transportista');
            if ($seguimiento !== '') $texto .= ' · seguimiento ' . $seguimiento;
            tienda_historial($pedido, $texto, PANEL_AUTOR);
            if (!tienda_guardar_pedido($pedido)) panel_fallo('No se ha podido guardar el pedido.', 500);
            tienda_responder(['ok' => true, 'pedido' => $pedido]);
            break;
        }

        /* ---- Datos del cliente (una dirección mal escrita se corrige aquí) ---- */
        case 'guardar_cliente': {
            $pedido = panel_pedido(panel_valor($in, 'numero'));
            $c = (isset($in['cliente']) && is_array($in['cliente'])) ? $in['cliente'] : [];
            $antes = (isset($pedido['cliente']) && is_array($pedido['cliente'])) ? $pedido['cliente'] : [];

            /* Sólo se toca lo que llega. Si el formulario del panel no
               trae un campo (las notas del cliente, por ejemplo), se
               queda como estaba en vez de borrarse sin querer. */
            $largos = ['nombre' => 120, 'email' => 160, 'telefono' => 40, 'direccion' => 200,
                       'cp' => 10, 'poblacion' => 120, 'provincia' => 80, 'nif' => 24, 'empresa' => 160];
            $cliente = [];
            foreach ($largos as $campo => $max) {
                if (array_key_exists($campo, $c)) $cliente[$campo] = panel_texto(panel_valor($c, $campo), $max);
                else $cliente[$campo] = isset($antes[$campo]) ? (string) $antes[$campo] : '';
            }
            if (array_key_exists('notas', $c)) $cliente['notas'] = panel_parrafo(panel_valor($c, 'notas'), 2000);
            else $cliente['notas'] = isset($antes['notas']) ? (string) $antes['notas'] : '';

            if ($cliente['nombre'] === '') panel_fallo('El cliente necesita un nombre.', 422);
            if ($cliente['email'] === '' || !filter_var($cliente['email'], FILTER_VALIDATE_EMAIL)) {
                panel_fallo('El correo no parece válido.', 422);
            }
            if ($cliente['cp'] !== '' && !preg_match('/^\d{5}$/', $cliente['cp'])) {
                panel_fallo('El código postal debe tener cinco dígitos.', 422);
            }

            $pedido['cliente'] = $cliente;
            tienda_historial($pedido, 'Datos del cliente corregidos.', PANEL_AUTOR);
            if (!tienda_guardar_pedido($pedido)) panel_fallo('No se ha podido guardar el pedido.', 500);
            tienda_responder(['ok' => true, 'pedido' => $pedido]);
            break;
        }

        /* ---- Nota interna: lo que se habló por teléfono ---- */
        case 'anadir_nota': {
            $pedido = panel_pedido(panel_valor($in, 'numero'));
            $texto = panel_parrafo(panel_valor($in, 'texto'), 2000);
            if ($texto === '') panel_fallo('La nota está vacía.', 422);

            if (!isset($pedido['notas_internas']) || !is_array($pedido['notas_internas'])) $pedido['notas_internas'] = [];
            $pedido['notas_internas'][] = ['ts' => date('c'), 'texto' => $texto, 'autor' => PANEL_AUTOR];
            tienda_historial($pedido, 'Nota interna añadida.', PANEL_AUTOR);
            if (!tienda_guardar_pedido($pedido)) panel_fallo('No se ha podido guardar el pedido.', 500);
            tienda_responder(['ok' => true, 'pedido' => $pedido]);
            break;
        }

        /* ---- Cambio de estado en bloque desde la lista ---- */
        case 'estado_lote': {
            $numeros = (isset($in['numeros']) && is_array($in['numeros'])) ? $in['numeros'] : [];
            if (!count($numeros)) panel_fallo('No hay ningún pedido seleccionado.', 422);
            if (count($numeros) > 200) panel_fallo('Demasiados pedidos de una vez: selecciona 200 como mucho.', 422);

            $estado = panel_texto(panel_valor($in, 'estado'), 24);
            $estados = tienda_estados();
            if (!is_array($estados) || !isset($estados[$estado])) panel_fallo('Ese estado no existe.', 422);
            $nota = panel_parrafo(panel_valor($in, 'nota'), 500);

            $cambiados = 0;
            $hechos = [];
            $errores = [];
            foreach ($numeros as $bruto) {
                if (is_array($bruto)) continue;
                $numero = strtoupper(panel_texto($bruto, 20));
                if (!preg_match(PANEL_RE_PEDIDO, $numero)) {
                    $errores[] = ['numero' => $numero, 'mensaje' => 'Número no válido.'];
                    continue;
                }
                $actual = tienda_pedido($numero);
                if (!is_array($actual) || !count($actual)) {
                    $errores[] = ['numero' => $numero, 'mensaje' => 'No existe.'];
                    continue;
                }
                try {
                    tienda_cambiar_estado($numero, $estado, $nota, PANEL_AUTOR);
                    $cambiados++;
                    $hechos[] = $numero;
                } catch (RuntimeException $e) {
                    /* Un pedido que falla (por ejemplo, sin stock para volver
                       a descontar) no debe cortar el resto de la tanda. */
                    $errores[] = ['numero' => $numero, 'mensaje' => $e->getMessage()];
                }
            }
            tienda_responder([
                'ok'        => true,
                'cambiados' => $cambiados,
                'numeros'   => $hechos,
                'errores'   => $errores,
            ]);
            break;
        }

        /* ---- Clientes agregados por correo ---- */
        case 'clientes': {
            $f = panel_filtros($in, false);
            $clientes = tienda_clientes(['desde' => $f['desde'], 'hasta' => $f['hasta'], 'q' => $f['q']]);
            tienda_responder([
                'ok'       => true,
                'desde'    => $f['desde'],
                'hasta'    => $f['hasta'],
                'clientes' => is_array($clientes) ? array_values($clientes) : [],
            ]);
            break;
        }

        /* ---- Almacén ---- */
        case 'catalogo': {
            tienda_responder([
                'ok'       => true,
                'lotes'    => (object) tienda_lotes(),
                'vendidos' => (object) panel_vendidos(),
            ]);
            break;
        }

        case 'guardar_lote': {
            $id = panel_texto(panel_valor($in, 'id'), 60);
            $lotes = tienda_lotes();
            if ($id === '' || !is_array($lotes) || !isset($lotes[$id])) panel_fallo('Ese lote no está en el catálogo.', 404);

            $campos = [];
            if (array_key_exists('precio', $in) && !is_array($in['precio'])) {
                $precio = str_replace(',', '.', trim((string) $in['precio']));
                if ($precio === '' || !is_numeric($precio)) panel_fallo('El precio tiene que ser un número.', 422);
                $precio = (float) $precio;
                if ($precio < 0 || $precio > 1000000) panel_fallo('El precio está fuera de rango.', 422);
                $campos['precio'] = round($precio, 2);
            }
            if (array_key_exists('stock', $in) && !is_array($in['stock'])) {
                $stock = trim((string) $in['stock']);
                if ($stock === '' || !is_numeric($stock)) panel_fallo('El stock tiene que ser un número entero.', 422);
                $stock = (int) $stock;
                if ($stock < 0 || $stock > 99999) panel_fallo('El stock está fuera de rango.', 422);
                $campos['stock'] = $stock;
            }
            if (array_key_exists('activo', $in)) {
                $campos['activo'] = panel_booleano($in['activo']);
            }
            if (!count($campos)) panel_fallo('No hay nada que guardar.', 422);

            $lote = tienda_guardar_override($id, $campos);
            tienda_responder(['ok' => true, 'lote' => $lote]);
            break;
        }

        /* ---- Ajustes ---- */
        case 'cambiar_password': {
            $actual = (string) panel_valor($in, 'actual');
            $nueva  = (string) panel_valor($in, 'nueva');
            if ($actual === '') panel_fallo('Escribe la contraseña actual.', 422);
            if (mb_strlen($nueva) < 8) panel_fallo('La contraseña nueva necesita ocho caracteres como mínimo.', 422);
            if ($nueva === $actual) panel_fallo('La contraseña nueva es igual que la actual.', 422);
            if (!tienda_admin_cambiar($actual, $nueva)) panel_fallo('La contraseña actual no es correcta.', 401);
            tienda_responder(['ok' => true, 'mensaje' => 'Contraseña cambiada.']);
            break;
        }

        /* ---- Descarga del CSV (por GET: la abre el navegador) ---- */
        case 'exportar': {
            $f = panel_filtros($in, false);
            $csv = tienda_csv($f);
            if (!is_string($csv)) $csv = '';
            $nombre = 'tornarem-pedidos-' . date('Y-m-d') . '.csv';
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $nombre . '"');
            header('Content-Length: ' . strlen($csv));
            echo $csv;
            exit;
        }

        default:
            panel_fallo('Acción desconocida.', 400);
    }

} catch (RuntimeException $e) {
    /* La capa de datos avisa así de lo que no cuadra (stock, catálogo,
       datos del pedido). El mensaje ya viene escrito en español y para
       leerlo una persona, así que se pasa tal cual. */
    tienda_responder(['ok' => false, 'mensaje' => $e->getMessage()], 422);
} catch (Throwable $e) {
    /* Cualquier otra cosa es un fallo nuestro: se registra en el
       servidor y al navegador va un mensaje sin rutas ni trazas. */
    error_log('[panel] ' . $e->getMessage());
    tienda_responder(['ok' => false, 'mensaje' => 'Error interno del servidor.'], 500);
}
