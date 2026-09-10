<?php
/* =============================================================
   TORNAREM — capa de datos compartida (tienda pública y panel)

   La incluyen con require_once: pedido.php, estado.php,
   admin/api.php y admin/albaran.php. No imprime nada al incluirse.

   Por qué existe: el catálogo vive en lib/catalogo.js (lo lee el
   navegador) y los pedidos viven en disco, en datos/. Este fichero
   es el único sitio donde se juntan las dos cosas, para que el
   precio, el stock y los totales se calculen siempre igual venga la
   petición de la tienda o del panel. El navegador nunca decide un
   precio: se recalcula aquí.

   Todo lo que escribe va por fichero temporal + rename(), y las
   lecturas-modificaciones-escrituras van con flock() sobre un
   fichero de bloqueo aparte. Si el hosting corta a mitad, el
   fichero anterior sigue entero.

   Carpeta de datos: la variable de entorno TORNAREM_DATOS si está
   definida; si no, la carpeta datos/ junto a la raíz del sitio.
   ============================================================= */

if (!defined('TORNAREM_VERSION')) {
    define('TORNAREM_VERSION', '1.0');
}
/* Minutos de inactividad tras los que la sesión del panel caduca. */
if (!defined('TORNAREM_SESION_MAX')) {
    define('TORNAREM_SESION_MAX', 8 * 3600);
}
/* Control de intentos de acceso: 5 fallos seguidos, 5 minutos parado. */
if (!defined('TORNAREM_INTENTOS_MAX')) {
    define('TORNAREM_INTENTOS_MAX', 5);
}
if (!defined('TORNAREM_BLOQUEO_SEG')) {
    define('TORNAREM_BLOQUEO_SEG', 300);
}
/* Por encima de estos días, la serie del resumen se agrupa por semanas. */
if (!defined('TORNAREM_SERIE_MAX_DIAS')) {
    define('TORNAREM_SERIE_MAX_DIAS', 120);
}

mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Madrid');


/* =============================================================
   1. RUTAS Y UTILIDADES DE FICHERO
   ============================================================= */

/* Carpeta donde viven los pedidos. Se puede mover con la variable de
   entorno TORNAREM_DATOS (las pruebas lanzan varios servidores a la
   vez, cada uno con la suya). */
function tienda_datos_dir() {
    $env = getenv('TORNAREM_DATOS');
    if (is_string($env) && trim($env) !== '') {
        return rtrim(str_replace('\\', '/', trim($env)), '/');
    }
    return dirname(__DIR__) . '/datos';
}

function tienda_pedidos_dir() {
    return tienda_datos_dir() . '/pedidos';
}

function tienda_ruta_indice() {
    return tienda_datos_dir() . '/indice.jsonl';
}

function tienda_ruta_overrides() {
    return tienda_datos_dir() . '/overrides.json';
}

function tienda_ruta_admin() {
    return tienda_datos_dir() . '/admin.json';
}

function tienda_ruta_intentos() {
    return tienda_datos_dir() . '/intentos.json';
}

/* Contenido del .htaccess de datos/. Sirve para Apache 2.2 y 2.4:
   dentro del sitio hay datos personales de clientes y nadie los
   tiene que poder pedir por el navegador. */
function tienda_htaccess_datos() {
    return "# Datos de clientes: nunca accesibles desde el navegador.\n"
         . "<IfModule mod_authz_core.c>\n"
         . "  Require all denied\n"
         . "</IfModule>\n"
         . "<IfModule !mod_authz_core.c>\n"
         . "  Order allow,deny\n"
         . "  Deny from all\n"
         . "</IfModule>\n"
         . "Options -Indexes\n";
}

/* Crea datos/, datos/pedidos/ y el .htaccess si faltan. */
function tienda_asegurar_datos() {
    $dir = tienda_datos_dir();
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    $pedidos = tienda_pedidos_dir();
    if (!is_dir($pedidos)) {
        @mkdir($pedidos, 0755, true);
    }
    $htaccess = $dir . '/.htaccess';
    if (is_dir($dir) && !file_exists($htaccess)) {
        @file_put_contents($htaccess, tienda_htaccess_datos());
    }
}

/* Escritura atómica: fichero temporal en la MISMA carpeta (para que
   rename() no cruce sistemas de ficheros) y rename por encima. */
function tienda_escribir_atomico($ruta, $contenido) {
    $dir = dirname($ruta);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    if (!is_dir($dir)) {
        return false;
    }
    $tmp = @tempnam($dir, 'tmp');
    if ($tmp === false) {
        return false;
    }
    $bytes = @file_put_contents($tmp, $contenido);
    if ($bytes === false || $bytes !== strlen($contenido)) {
        @unlink($tmp);
        return false;
    }
    @chmod($tmp, 0644);
    if (!@rename($tmp, $ruta)) {
        @unlink($tmp);
        return false;
    }
    return true;
}

/* Bloqueo exclusivo con un fichero .lock propio. Lo usan el índice y
   los overrides: como el .lock nunca se renombra, dos procesos que
   pidan el mismo nombre se serializan de verdad. */
function tienda_bloquear($nombre) {
    tienda_asegurar_datos();
    $ruta = tienda_datos_dir() . '/' . $nombre . '.lock';
    $fh = @fopen($ruta, 'cb');
    if ($fh === false) {
        return null;
    }
    if (!@flock($fh, LOCK_EX)) {
        fclose($fh);
        return null;
    }
    return $fh;
}

function tienda_desbloquear($fh) {
    if (is_resource($fh)) {
        @flock($fh, LOCK_UN);
        @fclose($fh);
    }
}

function tienda_leer_json($ruta) {
    if (!is_file($ruta)) {
        return array();
    }
    $raw = @file_get_contents($ruta);
    if ($raw === false || trim($raw) === '') {
        return array();
    }
    $datos = json_decode($raw, true);
    return is_array($datos) ? $datos : array();
}

function tienda_json($datos, $bonito = true) {
    $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    if ($bonito) {
        $flags = $flags | JSON_PRETTY_PRINT;
    }
    $txt = json_encode($datos, $flags);
    return $txt === false ? '' : $txt;
}


/* =============================================================
   2. TEXTO, FECHAS Y NÚMEROS
   ============================================================= */

function tienda_ahora() {
    return date('c');
}

function tienda_hoy() {
    return date('Y-m-d');
}

/* Una línea: sin saltos ni espacios repetidos, y recortada. */
function tienda_limpiar($v, $max = 200) {
    $v = is_array($v) ? '' : (string) $v;
    $v = str_replace(array("\r", "\n", "\0"), ' ', $v);
    $v = preg_replace('/[ \t]+/u', ' ', $v);
    return mb_substr(trim((string) $v), 0, $max);
}

/* Varias líneas: conserva los saltos, quita los retornos de carro. */
function tienda_limpiar_texto($v, $max = 2000) {
    $v = is_array($v) ? '' : (string) $v;
    $v = str_replace(array("\r\n", "\r", "\0"), array("\n", "\n", ''), $v);
    return mb_substr(trim($v), 0, $max);
}

/* Para buscar: minúsculas y sin acentos, así «González» encuentra
   «gonzalez» y al revés. */
function tienda_normaliza($texto) {
    $t = mb_strtolower(trim((string) $texto), 'UTF-8');
    $de = array('á', 'à', 'ä', 'â', 'ã', 'é', 'è', 'ë', 'ê', 'í', 'ì', 'ï', 'î',
                'ó', 'ò', 'ö', 'ô', 'õ', 'ú', 'ù', 'ü', 'û', 'ñ', 'ç');
    $a  = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'n', 'c');
    return str_replace($de, $a, $t);
}

/* Devuelve la fecha si es AAAA-MM-DD de verdad; si no, cadena vacía
   (cadena vacía = sin límite por ese lado). */
function tienda_fecha_valida($fecha) {
    $fecha = trim((string) $fecha);
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $fecha, $m)) {
        return '';
    }
    if (!checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
        return '';
    }
    return $fecha;
}

function tienda_suma_dias($fecha, $n) {
    $ts = strtotime($fecha . ' 12:00:00');
    if ($ts === false) {
        return $fecha;
    }
    return date('Y-m-d', $ts + ($n * 86400));
}

/* Días de diferencia entre dos fechas AAAA-MM-DD (b - a). */
function tienda_dias_entre($a, $b) {
    $ta = strtotime($a . ' 12:00:00');
    $tb = strtotime($b . ' 12:00:00');
    if ($ta === false || $tb === false) {
        return 0;
    }
    return (int) round(($tb - $ta) / 86400);
}

/* Formato español: punto de millar siempre, coma decimal sólo si hay
   céntimos. Igual que la función eur() de la tienda. */
function tienda_eur($n) {
    $n = (float) $n;
    $decimales = (round($n * 100) % 100) ? 2 : 0;
    return number_format($n, $decimales, ',', '.') . ' €';
}

/* Próxima fecha de entrega: corte a las 14:00 (o la hora que diga el
   catálogo), sólo días laborables, y un día más si va un palé. */
function tienda_fecha_entrega($es_pale) {
    $cat = tienda_catalogo_base();
    $corte = 14;
    if (isset($cat['envio']['horaCorte']) && (int) $cat['envio']['horaCorte'] > 0) {
        $corte = (int) $cat['envio']['horaCorte'];
    }
    $laborable = function ($ts) {
        $d = (int) date('N', $ts);
        return $d >= 1 && $d <= 5;
    };
    $siguiente = function ($ts) use ($laborable) {
        do {
            $ts = $ts + 86400;
        } while (!$laborable($ts));
        return $ts;
    };
    $ahora = time();
    $salida = ($laborable($ahora) && (int) date('G', $ahora) < $corte) ? $ahora : $siguiente($ahora);
    $entrega = $siguiente($salida);
    if ($es_pale) {
        $entrega = $siguiente($entrega);
    }
    return date('Y-m-d', $entrega);
}

/* Un lote es palé si lo dice su formato o su categoría. */
function tienda_es_pale($lote) {
    if (!is_array($lote)) {
        return false;
    }
    $formato = isset($lote['formato']) ? (string) $lote['formato'] : '';
    $categoria = isset($lote['categoria']) ? (string) $lote['categoria'] : '';
    return preg_match('/pal[eé]/iu', $formato . ' ' . $categoria) ? true : false;
}


/* =============================================================
   3. CATÁLOGO Y OVERRIDES
   ============================================================= */

/* Lee lib/catalogo.js y devuelve el objeto entero. El JSON empieza en
   la primera llave después de la marca __TIENDA__ y acaba en la última
   llave del fichero. Es la misma fuente que carga el navegador: así no
   hay dos catálogos que puedan discrepar. */
function tienda_catalogo_base() {
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $ruta = __DIR__ . '/catalogo.js';
    $raw = @file_get_contents($ruta);
    if ($raw === false) {
        throw new RuntimeException('No se encuentra lib/catalogo.js en el servidor.');
    }
    $marca = strpos($raw, '__TIENDA__');
    $ini = ($marca !== false) ? strpos($raw, '{', $marca) : false;
    $fin = strrpos($raw, '}');
    $datos = null;
    if ($ini !== false && $fin !== false && $fin > $ini) {
        $datos = json_decode(substr($raw, $ini, $fin - $ini + 1), true);
    }
    if (!is_array($datos) || !isset($datos['lotes']) || !is_array($datos['lotes'])) {
        throw new RuntimeException('El catálogo no es JSON válido: revisa lib/catalogo.js (comillas dobles, sin comas finales).');
    }
    $cache = $datos;
    return $cache;
}

/* Lo que el panel ha cambiado a mano: precio, stock y activo por lote. */
function tienda_overrides() {
    return tienda_leer_json(tienda_ruta_overrides());
}

/* Catálogo ya fusionado con los overrides. Es LO QUE MANDA: todo el
   resto del código (tienda, checkout, panel) mira esto, nunca el JS
   pelado. No se cachea porque el stock cambia dentro de la propia
   petición al crear un pedido. */
function tienda_lotes() {
    $cat = tienda_catalogo_base();
    $ov = tienda_overrides();
    $lotes = array();
    foreach ($cat['lotes'] as $l) {
        if (!is_array($l) || !isset($l['id'])) {
            continue;
        }
        $id = (string) $l['id'];
        $l['id'] = $id;
        $l['precio'] = isset($l['precio']) ? round((float) $l['precio'], 2) : 0.0;
        $l['stock'] = isset($l['stock']) ? (int) $l['stock'] : 0;
        $l['activo'] = true;
        $l['es_pale'] = tienda_es_pale($l);
        if (isset($ov[$id]) && is_array($ov[$id])) {
            $o = $ov[$id];
            if (isset($o['precio']) && $o['precio'] !== '') {
                $l['precio'] = round((float) $o['precio'], 2);
            }
            if (isset($o['stock']) && $o['stock'] !== '') {
                $l['stock'] = max(0, (int) $o['stock']);
            }
            if (isset($o['activo'])) {
                $l['activo'] = $o['activo'] ? true : false;
            }
        }
        $lotes[$id] = $l;
    }
    return $lotes;
}

/* Guarda precio, stock y activo de un lote. Sólo escribe las claves
   que vengan en $campos: así el panel puede tocar sólo el stock sin
   congelar el precio del catálogo. */
function tienda_guardar_override($id, $campos) {
    $id = (string) $id;
    $lotes = tienda_lotes();
    if (!isset($lotes[$id])) {
        throw new RuntimeException('Ese lote no está en el catálogo.');
    }
    if (!is_array($campos)) {
        $campos = array();
    }
    $fh = tienda_bloquear('overrides');
    try {
        $ov = tienda_overrides();
        $actual = (isset($ov[$id]) && is_array($ov[$id])) ? $ov[$id] : array();

        if (array_key_exists('precio', $campos) && $campos['precio'] !== '' && $campos['precio'] !== null) {
            $precio = round((float) $campos['precio'], 2);
            if ($precio < 0) {
                throw new RuntimeException('El precio no puede ser negativo.');
            }
            if ($precio > 999999) {
                throw new RuntimeException('Ese precio no parece real.');
            }
            $actual['precio'] = $precio;
        }
        if (array_key_exists('stock', $campos) && $campos['stock'] !== '' && $campos['stock'] !== null) {
            $stock = (int) $campos['stock'];
            if ($stock < 0) {
                throw new RuntimeException('El stock no puede ser negativo.');
            }
            if ($stock > 99999) {
                throw new RuntimeException('Ese stock no parece real.');
            }
            $actual['stock'] = $stock;
        }
        if (array_key_exists('activo', $campos)) {
            $actual['activo'] = $campos['activo'] ? true : false;
        }
        $actual['actualizado'] = tienda_ahora();
        $ov[$id] = $actual;

        if (!tienda_escribir_atomico(tienda_ruta_overrides(), tienda_json($ov))) {
            throw new RuntimeException('No se ha podido guardar el lote: revisa los permisos de la carpeta datos.');
        }
    } catch (Exception $e) {
        tienda_desbloquear($fh);
        throw $e;
    }
    tienda_desbloquear($fh);

    $lotes = tienda_lotes();
    return $lotes[$id];
}

/* Mueve el stock de varias líneas a la vez. $signo -1 descuenta (venta)
   y +1 devuelve (cancelación). Con $comprobar en true, si no llega el
   stock lanza excepción y no toca nada; con false, deja el lote a cero
   y devuelve la lista de lotes que se han quedado cortos, para poder
   avisar en el historial. */
function tienda_stock_mover($lineas, $signo, $comprobar) {
    $cortos = array();
    if (!is_array($lineas) || !count($lineas)) {
        return $cortos;
    }
    $fh = tienda_bloquear('overrides');
    try {
        $lotes = tienda_lotes();
        $ov = tienda_overrides();
        $cambios = array();

        foreach ($lineas as $ln) {
            $id = isset($ln['id']) ? (string) $ln['id'] : '';
            $qty = isset($ln['qty']) ? (int) $ln['qty'] : 0;
            if ($id === '' || $qty < 1 || !isset($lotes[$id])) {
                continue; /* lote retirado del catálogo: no hay stock que tocar */
            }
            $nuevo = (int) $lotes[$id]['stock'] + ($signo * $qty);
            if ($nuevo < 0) {
                if ($comprobar) {
                    throw new RuntimeException('Ya no queda stock suficiente de «' . $lotes[$id]['nombre'] . '».');
                }
                $cortos[] = $lotes[$id]['nombre'];
                $nuevo = 0;
            }
            $lotes[$id]['stock'] = $nuevo; /* por si el mismo lote sale dos veces */
            $cambios[$id] = $nuevo;
        }
        if (count($cambios)) {
            foreach ($cambios as $id => $nuevo) {
                $o = (isset($ov[$id]) && is_array($ov[$id])) ? $ov[$id] : array();
                $o['stock'] = $nuevo;
                $o['actualizado'] = tienda_ahora();
                $ov[$id] = $o;
            }
            if (!tienda_escribir_atomico(tienda_ruta_overrides(), tienda_json($ov))) {
                throw new RuntimeException('No se ha podido actualizar el stock: revisa los permisos de la carpeta datos.');
            }
        }
    } catch (Exception $e) {
        tienda_desbloquear($fh);
        throw $e;
    }
    tienda_desbloquear($fh);
    return $cortos;
}


/* =============================================================
   4. ESTADOS
   ============================================================= */

/* Cada estado lleva etiqueta y color. El color acompaña, nunca
   sustituye al texto. */
function tienda_estados() {
    return array(
        'nuevo'      => array('etiqueta' => 'Nuevo',      'color' => '#ff4d00'),
        'preparando' => array('etiqueta' => 'Preparando', 'color' => '#ffd400'),
        'enviado'    => array('etiqueta' => 'Enviado',    'color' => '#2b6cb0'),
        'entregado'  => array('etiqueta' => 'Entregado',  'color' => '#1f7a3d'),
        'incidencia' => array('etiqueta' => 'Incidencia', 'color' => '#b3261e'),
        'cancelado'  => array('etiqueta' => 'Cancelado',  'color' => '#6a6862'),
    );
}

function tienda_estados_pago() {
    return array(
        'pendiente'       => array('etiqueta' => 'Pendiente',           'color' => '#ffd400'),
        'pagado'          => array('etiqueta' => 'Pagado',              'color' => '#1f7a3d'),
        'cobrado_entrega' => array('etiqueta' => 'Cobrado en entrega',  'color' => '#2b6cb0'),
        'fallido'         => array('etiqueta' => 'Fallido',             'color' => '#b3261e'),
    );
}


/* =============================================================
   5. PEDIDOS: CREAR, LEER, GUARDAR
   ============================================================= */

function tienda_numero_valido($numero) {
    return preg_match('/^TR-\d{6}-[A-Z0-9]{4}$/', (string) $numero) ? true : false;
}

function tienda_ruta_pedido($numero) {
    return tienda_pedidos_dir() . '/' . $numero . '.json';
}

/* Reserva un número libre creando el fichero en exclusiva: si dos
   pedidos entran a la vez, sólo uno se queda con el número. */
function tienda_numero_nuevo() {
    tienda_asegurar_datos();
    $alfabeto = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; /* sin letras que se confunden con cifras */
    $largo = strlen($alfabeto);
    for ($intento = 0; $intento < 80; $intento++) {
        $sufijo = '';
        for ($i = 0; $i < 4; $i++) {
            $sufijo .= $alfabeto[random_int(0, $largo - 1)];
        }
        $numero = 'TR-' . date('ymd') . '-' . $sufijo;
        $fh = @fopen(tienda_ruta_pedido($numero), 'xb');
        if ($fh !== false) {
            fclose($fh);
            return $numero;
        }
    }
    throw new RuntimeException('No se ha podido generar el número de pedido. Vuelve a intentarlo.');
}

/* Línea compacta del índice: lo justo para listar, filtrar y sumar sin
   abrir cien ficheros. */
function tienda_linea_indice($pedido) {
    $ids = array();
    $unidades = 0;
    if (isset($pedido['lineas']) && is_array($pedido['lineas'])) {
        foreach ($pedido['lineas'] as $ln) {
            $id = isset($ln['id']) ? (string) $ln['id'] : '';
            if ($id !== '' && !in_array($id, $ids, true)) {
                $ids[] = $id;
            }
            $unidades += isset($ln['qty']) ? (int) $ln['qty'] : 0;
        }
    }
    $c = isset($pedido['cliente']) && is_array($pedido['cliente']) ? $pedido['cliente'] : array();
    return array(
        'numero'      => isset($pedido['numero']) ? (string) $pedido['numero'] : '',
        'creado'      => isset($pedido['creado']) ? (string) $pedido['creado'] : '',
        'estado'      => isset($pedido['estado']) ? (string) $pedido['estado'] : 'nuevo',
        'pago'        => isset($pedido['pago']['metodo']) ? (string) $pedido['pago']['metodo'] : 'contrarreembolso',
        'pago_estado' => isset($pedido['pago']['estado']) ? (string) $pedido['pago']['estado'] : 'pendiente',
        'total'       => isset($pedido['importes']['total']) ? round((float) $pedido['importes']['total'], 2) : 0.0,
        'unidades'    => $unidades,
        'nombre'      => isset($c['nombre']) ? (string) $c['nombre'] : '',
        'email'       => isset($c['email']) ? (string) $c['email'] : '',
        'telefono'    => isset($c['telefono']) ? (string) $c['telefono'] : '',
        'poblacion'   => isset($c['poblacion']) ? (string) $c['poblacion'] : '',
        'provincia'   => isset($c['provincia']) ? (string) $c['provincia'] : '',
        'lotes'       => $ids,
        'es_pale'     => (isset($pedido['envio']['es_pale']) && $pedido['envio']['es_pale']) ? true : false,
    );
}

/* Añade una línea al final del índice. */
function tienda_indice_anadir($linea) {
    tienda_asegurar_datos();
    $fh = tienda_bloquear('indice');
    $ok = false;
    try {
        $txt = tienda_json($linea, false);
        if ($txt !== '') {
            $ok = @file_put_contents(tienda_ruta_indice(), $txt . "\n", FILE_APPEND) !== false;
        }
    } catch (Exception $e) {
        tienda_desbloquear($fh);
        throw $e;
    }
    tienda_desbloquear($fh);
    return $ok;
}

/* Reescribe la línea de un pedido (o la añade si no estaba). Se
   reescribe el fichero entero de forma atómica: con unos miles de
   pedidos sigue siendo instantáneo y no se puede quedar a medias. */
function tienda_indice_actualizar($linea) {
    tienda_asegurar_datos();
    $numero = isset($linea['numero']) ? (string) $linea['numero'] : '';
    if ($numero === '') {
        return false;
    }
    $fh = tienda_bloquear('indice');
    $ok = false;
    try {
        $salida = array();
        $encontrada = false;
        $nueva = tienda_json($linea, false);
        $raw = is_file(tienda_ruta_indice()) ? @file_get_contents(tienda_ruta_indice()) : '';
        if (is_string($raw) && $raw !== '') {
            $lineas = explode("\n", $raw);
            foreach ($lineas as $l) {
                $l = trim($l);
                if ($l === '') {
                    continue;
                }
                $d = json_decode($l, true);
                if (is_array($d) && isset($d['numero']) && (string) $d['numero'] === $numero) {
                    $salida[] = $nueva;
                    $encontrada = true;
                } else {
                    $salida[] = $l;
                }
            }
        }
        if (!$encontrada) {
            $salida[] = $nueva;
        }
        $ok = tienda_escribir_atomico(tienda_ruta_indice(), implode("\n", $salida) . "\n");
    } catch (Exception $e) {
        tienda_desbloquear($fh);
        throw $e;
    }
    tienda_desbloquear($fh);
    return $ok;
}

/* Deja una línea del índice con todas sus claves y del tipo que toca.
   Así, si alguien edita indice.jsonl a mano por FTP, el panel sigue
   funcionando y no salta ni un aviso de PHP. */
function tienda_linea_normal($d) {
    $texto = array('numero', 'creado', 'estado', 'pago', 'pago_estado', 'nombre', 'email',
                   'telefono', 'poblacion', 'provincia');
    foreach ($texto as $k) {
        $d[$k] = isset($d[$k]) ? (string) $d[$k] : '';
    }
    if ($d['estado'] === '') {
        $d['estado'] = 'nuevo';
    }
    if ($d['pago'] === '') {
        $d['pago'] = 'contrarreembolso';
    }
    if ($d['pago_estado'] === '') {
        $d['pago_estado'] = 'pendiente';
    }
    $d['total'] = isset($d['total']) ? round((float) $d['total'], 2) : 0.0;
    $d['unidades'] = isset($d['unidades']) ? (int) $d['unidades'] : 0;
    $d['lotes'] = (isset($d['lotes']) && is_array($d['lotes'])) ? array_values($d['lotes']) : array();
    $d['es_pale'] = (isset($d['es_pale']) && $d['es_pale']) ? true : false;
    return $d;
}

/* Todas las líneas del índice, en el orden en que se escribieron. */
function tienda_indice() {
    $ruta = tienda_ruta_indice();
    if (!is_file($ruta)) {
        return array();
    }
    $raw = @file_get_contents($ruta);
    if ($raw === false || trim($raw) === '') {
        return array();
    }
    $salida = array();
    $lineas = explode("\n", $raw);
    foreach ($lineas as $l) {
        $l = trim($l);
        if ($l === '') {
            continue;
        }
        $d = json_decode($l, true);
        if (is_array($d) && isset($d['numero'])) {
            $salida[] = tienda_linea_normal($d);
        }
    }
    return $salida;
}

/* Crea un pedido de verdad: valida, recalcula precios desde el
   catálogo, comprueba y descuenta stock, y lo deja escrito en disco.
   Lanza RuntimeException con el motivo si algo no cuadra. */
function tienda_crear_pedido($entrada) {
    tienda_asegurar_datos();
    if (!is_array($entrada)) {
        $entrada = array();
    }
    $cat = tienda_catalogo_base();
    $lotes = tienda_lotes();

    /* ---- Cliente ---- */
    $c = (isset($entrada['cliente']) && is_array($entrada['cliente'])) ? $entrada['cliente'] : array();
    $g = function ($k) use ($c) { return isset($c[$k]) ? $c[$k] : ''; };
    $cliente = array(
        'nombre'    => tienda_limpiar($g('nombre'), 120),
        'email'     => tienda_limpiar($g('email'), 160),
        'telefono'  => tienda_limpiar($g('telefono'), 40),
        'direccion' => tienda_limpiar($g('direccion'), 200),
        'cp'        => tienda_limpiar($g('cp'), 10),
        'poblacion' => tienda_limpiar($g('poblacion'), 120),
        'provincia' => tienda_limpiar($g('provincia'), 80),
        'nif'       => tienda_limpiar($g('nif'), 24),
        'empresa'   => tienda_limpiar($g('empresa'), 160),
        'notas'     => tienda_limpiar_texto($g('notas'), 2000),
    );
    $etiquetas = array(
        'nombre' => 'el nombre', 'email' => 'el correo', 'telefono' => 'el teléfono',
        'direccion' => 'la dirección', 'cp' => 'el código postal',
        'poblacion' => 'la población', 'provincia' => 'la provincia',
    );
    $faltan = array();
    foreach ($etiquetas as $k => $et) {
        if ($cliente[$k] === '') {
            $faltan[] = $et;
        }
    }
    if (count($faltan)) {
        throw new RuntimeException('Falta ' . implode(', ', $faltan) . '.');
    }
    if (!filter_var($cliente['email'], FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('El correo no parece válido.');
    }
    if (preg_match_all('/\d/', $cliente['telefono']) < 9) {
        throw new RuntimeException('El teléfono no parece completo.');
    }
    if (!preg_match('/^\d{5}$/', $cliente['cp'])) {
        throw new RuntimeException('El código postal debe tener cinco dígitos.');
    }

    /* ---- Líneas: el precio sale del catálogo, no del navegador ---- */
    $items = (isset($entrada['items']) && is_array($entrada['items'])) ? $entrada['items'] : array();
    if (!count($items)) {
        throw new RuntimeException('El carrito está vacío.');
    }
    $lineas = array();
    $subtotal = 0.0;
    $es_pale = false;
    foreach ($items as $it) {
        if (!is_array($it)) {
            continue;
        }
        $id = isset($it['id']) ? (string) $it['id'] : '';
        $qty = isset($it['qty']) ? (int) $it['qty'] : 0;
        if ($id === '' || !isset($lotes[$id])) {
            throw new RuntimeException('Uno de los lotes ya no está en el catálogo (' . tienda_limpiar($id, 40) . ').');
        }
        if ($qty < 1) {
            continue;
        }
        $l = $lotes[$id];
        if (!$l['activo']) {
            throw new RuntimeException('«' . $l['nombre'] . '» ya no está a la venta.');
        }
        if ($qty > (int) $l['stock']) {
            /* Con cero no se dice "quedan 0": se dice que se ha agotado, que es
               lo que el cliente necesita entender. Con uno, singular. */
            $quedan = (int) $l['stock'];
            if ($quedan === 0) {
                throw new RuntimeException('«' . $l['nombre'] . '» se ha agotado mientras comprabas. Quítalo del carrito para seguir.');
            }
            throw new RuntimeException($quedan === 1
                ? 'Sólo queda 1 lote de «' . $l['nombre'] . '».'
                : 'Sólo quedan ' . $quedan . ' lotes de «' . $l['nombre'] . '».');
        }
        $precio = (float) $l['precio'];
        $lineas[] = array(
            'id'      => $id,
            'ref'     => isset($l['ref']) ? (string) $l['ref'] : '',
            'nombre'  => isset($l['nombre']) ? (string) $l['nombre'] : $id,
            'uds'     => isset($l['uds']) ? (int) $l['uds'] : 0,
            'grado'   => isset($l['grado']) ? (string) $l['grado'] : '',
            'formato' => isset($l['formato']) ? (string) $l['formato'] : '',
            'qty'     => $qty,
            'precio'  => round($precio, 2),
            'total'   => round($qty * $precio, 2),
        );
        $subtotal += $qty * $precio;
        if ($l['es_pale']) {
            $es_pale = true;
        }
    }
    if (!count($lineas)) {
        throw new RuntimeException('El carrito está vacío.');
    }
    $subtotal = round($subtotal, 2);

    /* ---- Recargo del contrarreembolso: porcentaje y mínimo del catálogo ---- */
    $metodo = (isset($entrada['pago']) && $entrada['pago'] === 'tarjeta') ? 'tarjeta' : 'contrarreembolso';
    $recargo = 0.0;
    if ($metodo === 'contrarreembolso') {
        $porcentaje = isset($cat['contrarreembolso']['porcentaje']) ? (float) $cat['contrarreembolso']['porcentaje'] : 0.0;
        $minimo = isset($cat['contrarreembolso']['minimo']) ? (float) $cat['contrarreembolso']['minimo'] : 0.0;
        $recargo = max($minimo, round($subtotal * $porcentaje / 100, 2));
    }
    $total = round($subtotal + $recargo, 2);

    $pagos = tienda_estados_pago();
    $pago_estado = 'pendiente';
    if (isset($entrada['pago_estado']) && isset($pagos[(string) $entrada['pago_estado']])) {
        $pago_estado = (string) $entrada['pago_estado'];
    }

    $o = (isset($entrada['origen']) && is_array($entrada['origen'])) ? $entrada['origen'] : array();
    $origen = array(
        'ip'     => tienda_limpiar(isset($o['ip']) ? $o['ip'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''), 60),
        'agente' => tienda_limpiar(isset($o['agente']) ? $o['agente'] : (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''), 250),
        'url'    => tienda_limpiar(isset($o['url']) ? $o['url'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''), 250),
    );

    /* ---- Primero el stock: es lo que puede fallar por otro pedido ---- */
    tienda_stock_mover($lineas, -1, true);

    $numero = '';
    try {
        $numero = tienda_numero_nuevo();
        $ahora = tienda_ahora();
        $pedido = array(
            'numero'           => $numero,
            'creado'           => $ahora,
            'actualizado'      => $ahora,
            'estado'           => 'nuevo',
            'stock_descontado' => true,
            'pago' => array(
                'metodo'     => $metodo,
                'estado'     => $pago_estado,
                'recargo'    => $recargo,
                'referencia' => tienda_limpiar(isset($entrada['referencia']) ? $entrada['referencia'] : '', 120),
            ),
            'cliente'  => $cliente,
            'lineas'   => $lineas,
            'importes' => array('subtotal' => $subtotal, 'recargo' => $recargo, 'total' => $total),
            'envio' => array(
                'es_pale'        => $es_pale,
                'transportista'  => '',
                'seguimiento'    => '',
                'fecha_prevista' => tienda_fecha_entrega($es_pale),
            ),
            'historial'      => array(),
            'notas_internas' => array(),
            'origen'         => $origen,
        );
        tienda_historial($pedido, 'Pedido recibido en la tienda. Stock descontado.', 'tienda');

        if (!tienda_escribir_atomico(tienda_ruta_pedido($numero), tienda_json($pedido))) {
            throw new RuntimeException('No se ha podido guardar el pedido: revisa los permisos de la carpeta datos.');
        }
        if (!tienda_indice_anadir(tienda_linea_indice($pedido))) {
            @unlink(tienda_ruta_pedido($numero));
            throw new RuntimeException('No se ha podido guardar el pedido en el índice: revisa los permisos de la carpeta datos.');
        }
    } catch (Exception $e) {
        /* Si no ha llegado a escribirse, el stock vuelve a su sitio. */
        tienda_stock_mover($lineas, 1, false);
        if ($numero !== '' && is_file(tienda_ruta_pedido($numero)) && filesize(tienda_ruta_pedido($numero)) === 0) {
            @unlink(tienda_ruta_pedido($numero));
        }
        throw $e;
    }
    return $pedido;
}

/* Ficha completa de un pedido, o null si no existe. El número se
   valida ANTES de tocar el disco: nunca se concatena entrada del
   usuario en una ruta sin filtrar. */
function tienda_pedido($numero) {
    $numero = (string) $numero;
    if (!tienda_numero_valido($numero)) {
        return null;
    }
    $ruta = tienda_ruta_pedido($numero);
    if (!is_file($ruta)) {
        return null;
    }
    $datos = tienda_leer_json($ruta);
    if (!count($datos) || !isset($datos['numero'])) {
        return null;
    }
    return $datos;
}

/* Reescribe la ficha y deja el índice en hora. */
function tienda_guardar_pedido($pedido) {
    if (!is_array($pedido) || !isset($pedido['numero']) || !tienda_numero_valido($pedido['numero'])) {
        return false;
    }
    tienda_asegurar_datos();
    $pedido['actualizado'] = tienda_ahora();
    if (!tienda_escribir_atomico(tienda_ruta_pedido($pedido['numero']), tienda_json($pedido))) {
        return false;
    }
    return tienda_indice_actualizar(tienda_linea_indice($pedido));
}

/* Apunta una línea en el historial del pedido. */
function tienda_historial(&$pedido, $texto, $autor) {
    if (!is_array($pedido)) {
        return;
    }
    if (!isset($pedido['historial']) || !is_array($pedido['historial'])) {
        $pedido['historial'] = array();
    }
    $pedido['historial'][] = array(
        'ts'    => tienda_ahora(),
        'texto' => tienda_limpiar_texto($texto, 600),
        'autor' => tienda_limpiar($autor, 60),
    );
}

/* Cambia el estado y ajusta el stock en consecuencia: al cancelar, las
   unidades vuelven al almacén; al sacar el pedido de cancelado, se
   vuelven a descontar. El campo stock_descontado impide contar dos
   veces aunque se pulse el botón dos veces. */
function tienda_cambiar_estado($numero, $estado, $nota, $autor) {
    $estados = tienda_estados();
    $estado = (string) $estado;
    if (!isset($estados[$estado])) {
        throw new RuntimeException('Ese estado no existe.');
    }
    $pedido = tienda_pedido($numero);
    if ($pedido === null) {
        throw new RuntimeException('Ese pedido no existe.');
    }
    $autor = tienda_limpiar($autor, 60);
    if ($autor === '') {
        $autor = 'panel';
    }
    $nota = tienda_limpiar_texto($nota, 600);
    $anterior = isset($pedido['estado']) ? (string) $pedido['estado'] : 'nuevo';
    $lineas = (isset($pedido['lineas']) && is_array($pedido['lineas'])) ? $pedido['lineas'] : array();
    $descontado = (isset($pedido['stock_descontado']) && $pedido['stock_descontado']) ? true : false;

    if ($estado === $anterior) {
        /* Sin cambio de estado: si trae nota, se apunta igual. */
        if ($nota !== '') {
            tienda_historial($pedido, $nota, $autor);
            if (!tienda_guardar_pedido($pedido)) {
                throw new RuntimeException('No se ha podido guardar el pedido.');
            }
        }
        return $pedido;
    }

    $aviso = '';
    if ($estado === 'cancelado' && $descontado) {
        tienda_stock_mover($lineas, 1, false);
        $pedido['stock_descontado'] = false;
        $aviso = ' Stock devuelto al almacén.';
    } elseif ($anterior === 'cancelado' && !$descontado) {
        $cortos = tienda_stock_mover($lineas, -1, false);
        $pedido['stock_descontado'] = true;
        $aviso = ' Stock descontado de nuevo.';
        if (count($cortos)) {
            $aviso .= ' Sin stock suficiente de: ' . implode(', ', $cortos) . '. Revisa el almacén.';
        }
    }

    $pedido['estado'] = $estado;
    $texto = 'Estado: ' . $estados[$anterior]['etiqueta'] . ' → ' . $estados[$estado]['etiqueta'] . '.' . $aviso;
    if ($nota !== '') {
        $texto .= ' ' . $nota;
    }
    tienda_historial($pedido, $texto, $autor);

    if (!tienda_guardar_pedido($pedido)) {
        throw new RuntimeException('No se ha podido guardar el pedido.');
    }
    return $pedido;
}


/* =============================================================
   6. BÚSQUEDA, RESUMEN, CLIENTES Y CSV
   ============================================================= */

/* Una línea entra en el rango si la parte de fecha de creado está
   entre desde y hasta, los dos incluidos. creado ya va en hora de
   Madrid, así que basta con comparar los diez primeros caracteres. */
function tienda_en_rango($linea, $desde, $hasta) {
    $fecha = substr((string) (isset($linea['creado']) ? $linea['creado'] : ''), 0, 10);
    if ($fecha === '') {
        return false;
    }
    if ($desde !== '' && $fecha < $desde) {
        return false;
    }
    if ($hasta !== '' && $fecha > $hasta) {
        return false;
    }
    return true;
}

/* Filtra el índice con los criterios del panel y lo ordena. */
function tienda_filtrar_indice($f) {
    if (!is_array($f)) {
        $f = array();
    }
    $desde  = tienda_fecha_valida(isset($f['desde']) ? $f['desde'] : '');
    $hasta  = tienda_fecha_valida(isset($f['hasta']) ? $f['hasta'] : '');
    if ($desde !== '' && $hasta !== '' && $desde > $hasta) {
        $intercambio = $desde; $desde = $hasta; $hasta = $intercambio;
    }
    $estados = tienda_estados();
    $estado = tienda_limpiar(isset($f['estado']) ? $f['estado'] : '', 20);
    if ($estado !== '' && !isset($estados[$estado])) {
        $estado = '';
    }
    $pago = tienda_limpiar(isset($f['pago']) ? $f['pago'] : '', 20);
    if ($pago !== 'contrarreembolso' && $pago !== 'tarjeta') {
        $pago = '';
    }
    $q = tienda_normaliza(isset($f['q']) ? $f['q'] : '');

    $salida = array();
    foreach (tienda_indice() as $l) {
        if (!tienda_en_rango($l, $desde, $hasta)) {
            continue;
        }
        if ($estado !== '' && (string) $l['estado'] !== $estado) {
            continue;
        }
        if ($pago !== '' && (string) $l['pago'] !== $pago) {
            continue;
        }
        if ($q !== '') {
            $lotes = (isset($l['lotes']) && is_array($l['lotes'])) ? implode(' ', $l['lotes']) : '';
            $pajar = tienda_normaliza(
                $l['numero'] . ' ' . $l['nombre'] . ' ' . $l['email'] . ' ' . $l['telefono'] . ' '
                . $l['poblacion'] . ' ' . $l['provincia'] . ' ' . $lotes
            );
            if (strpos($pajar, $q) === false) {
                continue;
            }
        }
        $salida[] = $l;
    }

    $orden = tienda_limpiar(isset($f['orden']) ? $f['orden'] : '', 20);
    if (!in_array($orden, array('creado', 'total', 'nombre', 'estado'), true)) {
        $orden = 'creado';
    }
    $direccion = (isset($f['direccion']) && strtolower((string) $f['direccion']) === 'asc') ? 'asc' : 'desc';
    $signo = ($direccion === 'asc') ? 1 : -1;
    $peso = array_keys($estados);

    usort($salida, function ($a, $b) use ($orden, $signo, $peso) {
        if ($orden === 'total') {
            $x = (float) $a['total'];
            $y = (float) $b['total'];
            $c = ($x < $y) ? -1 : (($x > $y) ? 1 : 0);
        } elseif ($orden === 'nombre') {
            $c = strcmp(tienda_normaliza($a['nombre']), tienda_normaliza($b['nombre']));
        } elseif ($orden === 'estado') {
            $x = array_search((string) $a['estado'], $peso, true);
            $y = array_search((string) $b['estado'], $peso, true);
            $x = ($x === false) ? 99 : $x;
            $y = ($y === false) ? 99 : $y;
            $c = ($x < $y) ? -1 : (($x > $y) ? 1 : 0);
        } else {
            $c = strcmp((string) $a['creado'], (string) $b['creado']);
        }
        if ($c === 0) {
            $c = strcmp((string) $a['creado'], (string) $b['creado']);
        }
        return $c * $signo;
    });

    return $salida;
}

/* Listado paginado. suma y unidades son de TODO lo que cumple el
   filtro, no sólo de la página que se ve. */
function tienda_buscar_pedidos($f) {
    if (!is_array($f)) {
        $f = array();
    }
    $lineas = tienda_filtrar_indice($f);
    $suma = 0.0;
    $unidades = 0;
    foreach ($lineas as $l) {
        $suma += (float) $l['total'];
        $unidades += (int) $l['unidades'];
    }
    $total = count($lineas);
    $por_pagina = isset($f['por_pagina']) ? (int) $f['por_pagina'] : 25;
    if ($por_pagina < 1) {
        $por_pagina = 25;
    }
    if ($por_pagina > 500) {
        $por_pagina = 500;
    }
    $paginas = ($total > 0) ? (int) ceil($total / $por_pagina) : 1;
    $pagina = isset($f['pagina']) ? (int) $f['pagina'] : 1;
    if ($pagina < 1) {
        $pagina = 1;
    }
    if ($pagina > $paginas) {
        $pagina = $paginas;
    }
    return array(
        'total'      => $total,
        'paginas'    => $paginas,
        'pagina'     => $pagina,
        'por_pagina' => $por_pagina,
        'pedidos'    => array_slice($lineas, ($pagina - 1) * $por_pagina, $por_pagina),
        'suma'       => round($suma, 2),
        'unidades'   => $unidades,
    );
}

/* Unidades e importe vendidos por lote. Hay que abrir las fichas
   porque el índice sólo guarda qué lotes lleva cada pedido, no cuántos
   de cada uno. Los cancelados no cuentan. */
function tienda_vendidos($desde = '', $hasta = '') {
    $desde = tienda_fecha_valida($desde);
    $hasta = tienda_fecha_valida($hasta);
    $salida = array();
    $leidos = 0;
    foreach (tienda_indice() as $l) {
        if (!tienda_en_rango($l, $desde, $hasta)) {
            continue;
        }
        if ((string) $l['estado'] === 'cancelado') {
            continue;
        }
        if ($leidos >= 3000) {
            break; /* tope de seguridad: ningún panel necesita más de una vez */
        }
        $pedido = tienda_pedido($l['numero']);
        $leidos++;
        if ($pedido === null || !isset($pedido['lineas']) || !is_array($pedido['lineas'])) {
            continue;
        }
        foreach ($pedido['lineas'] as $ln) {
            $id = isset($ln['id']) ? (string) $ln['id'] : '';
            if ($id === '') {
                continue;
            }
            if (!isset($salida[$id])) {
                $salida[$id] = array(
                    'id'     => $id,
                    'nombre' => isset($ln['nombre']) ? (string) $ln['nombre'] : $id,
                    'qty'    => 0,
                    'ventas' => 0.0,
                );
            }
            $salida[$id]['qty'] += isset($ln['qty']) ? (int) $ln['qty'] : 0;
            $salida[$id]['ventas'] = round($salida[$id]['ventas'] + (isset($ln['total']) ? (float) $ln['total'] : 0.0), 2);
        }
    }
    return $salida;
}

/* Suma un tramo de fechas: ventas y pedidos, sin contar cancelados. */
function tienda_totales_rango($lineas, $desde, $hasta) {
    $ventas = 0.0;
    $pedidos = 0;
    $unidades = 0;
    foreach ($lineas as $l) {
        if (!tienda_en_rango($l, $desde, $hasta)) {
            continue;
        }
        if ((string) $l['estado'] === 'cancelado') {
            continue;
        }
        $ventas += (float) $l['total'];
        $pedidos++;
        $unidades += (int) $l['unidades'];
    }
    return array('ventas' => round($ventas, 2), 'pedidos' => $pedidos, 'unidades' => $unidades);
}

function tienda_variacion($actual, $anterior) {
    $actual = (float) $actual;
    $anterior = (float) $anterior;
    if ($anterior <= 0) {
        return ($actual > 0) ? 100.0 : 0.0;
    }
    return round((($actual - $anterior) / $anterior) * 100, 1);
}

/* Todo lo que pinta la pantalla de Inicio, ya calculado. */
function tienda_resumen($desde, $hasta) {
    $desde = tienda_fecha_valida($desde);
    $hasta = tienda_fecha_valida($hasta);
    if ($desde !== '' && $hasta !== '' && $desde > $hasta) {
        $intercambio = $desde; $desde = $hasta; $hasta = $intercambio;
    }
    $indice = tienda_indice();
    $estados = tienda_estados();

    /* ---- Totales del periodo ---- */
    $tot = tienda_totales_rango($indice, $desde, $hasta);
    $ventas = $tot['ventas'];
    $pedidos = $tot['pedidos'];
    $unidades = $tot['unidades'];
    $ticket = ($pedidos > 0) ? round($ventas / $pedidos, 2) : 0.0;

    /* ---- Reparto por estado y por forma de pago ---- */
    $por_estado = array();
    foreach ($estados as $k => $e) {
        $por_estado[$k] = array(
            'estado'   => $k,
            'etiqueta' => $e['etiqueta'],
            'color'    => $e['color'],
            'pedidos'  => 0,
            'total'    => 0.0,
        );
    }
    $por_pago = array(
        'contrarreembolso' => array('metodo' => 'contrarreembolso', 'etiqueta' => 'Contrarreembolso', 'pedidos' => 0, 'total' => 0.0),
        'tarjeta'          => array('metodo' => 'tarjeta',          'etiqueta' => 'Tarjeta',          'pedidos' => 0, 'total' => 0.0),
    );
    foreach ($indice as $l) {
        if (!tienda_en_rango($l, $desde, $hasta)) {
            continue;
        }
        $e = (string) $l['estado'];
        if (isset($por_estado[$e])) {
            $por_estado[$e]['pedidos']++;
            $por_estado[$e]['total'] = round($por_estado[$e]['total'] + (float) $l['total'], 2);
        }
        if ($e === 'cancelado') {
            continue; /* los cancelados no cuentan como venta por forma de pago */
        }
        $p = (string) $l['pago'];
        if (isset($por_pago[$p])) {
            $por_pago[$p]['pedidos']++;
            $por_pago[$p]['total'] = round($por_pago[$p]['total'] + (float) $l['total'], 2);
        }
    }

    /* ---- Serie: un punto por día del rango, aunque no haya ventas ----
       Si el rango es «todo», se toma desde el primer pedido hasta hoy.
       Y si eso pasa de 120 días, se agrupa por semanas para que el
       gráfico siga siendo legible (mismas claves). */
    $primera = '';
    $ultima = '';
    foreach ($indice as $l) {
        $f = substr((string) $l['creado'], 0, 10);
        if ($f === '') {
            continue;
        }
        if ($primera === '' || $f < $primera) {
            $primera = $f;
        }
        if ($ultima === '' || $f > $ultima) {
            $ultima = $f;
        }
    }
    $hoy = tienda_hoy();
    $fin = ($hasta !== '') ? $hasta : (($ultima !== '' && $ultima > $hoy) ? $ultima : $hoy);
    $ini = ($desde !== '') ? $desde : (($primera !== '') ? $primera : $fin);
    if ($ini > $fin) {
        $ini = $fin;
    }
    $dias = tienda_dias_entre($ini, $fin) + 1;
    $por_semana = ($dias > TORNAREM_SERIE_MAX_DIAS);

    $serie = array();
    $posicion = array();
    $cursor = $ini;
    $vueltas = 0;
    while ($cursor <= $fin && $vueltas < 4000) {
        $clave = $por_semana ? tienda_lunes($cursor) : $cursor;
        if (!isset($posicion[$clave])) {
            $posicion[$clave] = count($serie);
            $serie[] = array('fecha' => $clave, 'pedidos' => 0, 'ventas' => 0.0);
        }
        $cursor = tienda_suma_dias($cursor, 1);
        $vueltas++;
    }
    foreach ($indice as $l) {
        if (!tienda_en_rango($l, $ini, $fin)) {
            continue;
        }
        if ((string) $l['estado'] === 'cancelado') {
            continue;
        }
        $f = substr((string) $l['creado'], 0, 10);
        $clave = $por_semana ? tienda_lunes($f) : $f;
        if (!isset($posicion[$clave])) {
            continue;
        }
        $i = $posicion[$clave];
        $serie[$i]['pedidos']++;
        $serie[$i]['ventas'] = round($serie[$i]['ventas'] + (float) $l['total'], 2);
    }

    /* ---- Lotes más vendidos del periodo ---- */
    $vendidos = tienda_vendidos($desde, $hasta);
    $top = array_values($vendidos);
    usort($top, function ($a, $b) {
        if ($a['ventas'] === $b['ventas']) {
            return ($a['qty'] < $b['qty']) ? 1 : (($a['qty'] > $b['qty']) ? -1 : 0);
        }
        return ($a['ventas'] < $b['ventas']) ? 1 : -1;
    });
    $top_lotes = array_slice($top, 0, 10);

    /* ---- Periodo anterior de la misma duración ---- */
    $comparable = ($desde !== '' && $hasta !== '');
    $anterior = array('ventas' => 0.0, 'pedidos' => 0, 'desde' => '', 'hasta' => '');
    $variacion = array('ventas' => 0.0, 'pedidos' => 0.0);
    if ($comparable) {
        $largo = tienda_dias_entre($desde, $hasta) + 1;
        $ant_hasta = tienda_suma_dias($desde, -1);
        $ant_desde = tienda_suma_dias($ant_hasta, -($largo - 1));
        $ant = tienda_totales_rango($indice, $ant_desde, $ant_hasta);
        $anterior = array(
            'ventas'  => $ant['ventas'],
            'pedidos' => $ant['pedidos'],
            'desde'   => $ant_desde,
            'hasta'   => $ant_hasta,
        );
        $variacion = array(
            'ventas'  => tienda_variacion($ventas, $ant['ventas']),
            'pedidos' => tienda_variacion($pedidos, $ant['pedidos']),
        );
    }

    /* ---- Pendientes de preparar: sin filtrar por fecha, los más viejos primero ---- */
    $pendientes = array();
    foreach ($indice as $l) {
        $e = (string) $l['estado'];
        if ($e === 'nuevo' || $e === 'preparando') {
            $pendientes[] = $l;
        }
    }
    usort($pendientes, function ($a, $b) {
        return strcmp((string) $a['creado'], (string) $b['creado']);
    });

    /* ---- Stock bajo: dos unidades o menos ---- */
    $stock_bajo = array();
    foreach (tienda_lotes() as $id => $l) {
        if ((int) $l['stock'] <= 2) {
            $stock_bajo[] = array(
                'id'     => $id,
                'nombre' => isset($l['nombre']) ? (string) $l['nombre'] : $id,
                'stock'  => (int) $l['stock'],
                'activo' => $l['activo'] ? true : false,
            );
        }
    }
    usort($stock_bajo, function ($a, $b) {
        if ($a['stock'] === $b['stock']) {
            return strcmp($a['nombre'], $b['nombre']);
        }
        return ($a['stock'] < $b['stock']) ? -1 : 1;
    });

    return array(
        'desde'        => $desde,
        'hasta'        => $hasta,
        'dias'         => $dias,
        'ventas'       => $ventas,
        'pedidos'      => $pedidos,
        'unidades'     => $unidades,
        'ticket_medio' => $ticket,
        'por_estado'   => $por_estado,
        'por_pago'     => $por_pago,
        'serie'        => $serie,
        'agrupado'     => $por_semana ? 'semana' : 'dia',
        'top_lotes'    => $top_lotes,
        'anterior'     => $anterior,
        'variacion'    => $variacion,
        'comparable'   => $comparable,
        'pendientes'   => $pendientes,
        'stock_bajo'   => $stock_bajo,
    );
}

/* Lunes de la semana de una fecha AAAA-MM-DD. */
function tienda_lunes($fecha) {
    $ts = strtotime($fecha . ' 12:00:00');
    if ($ts === false) {
        return $fecha;
    }
    $dia = (int) date('N', $ts); /* 1 lunes ... 7 domingo */
    return date('Y-m-d', $ts - (($dia - 1) * 86400));
}

/* Clientes agregados por correo: un cliente es un correo. Se queda con
   los datos del pedido más reciente, que son los que valen. */
function tienda_clientes($f) {
    if (!is_array($f)) {
        $f = array();
    }
    $lineas = tienda_filtrar_indice(array(
        'desde' => isset($f['desde']) ? $f['desde'] : '',
        'hasta' => isset($f['hasta']) ? $f['hasta'] : '',
        'q'     => isset($f['q']) ? $f['q'] : '',
    ));
    $clientes = array();
    foreach ($lineas as $l) {
        $email = mb_strtolower(trim((string) $l['email']), 'UTF-8');
        if ($email === '') {
            $email = '(sin correo)';
        }
        if (!isset($clientes[$email])) {
            $clientes[$email] = array(
                'nombre'     => (string) $l['nombre'],
                'email'      => (string) $l['email'],
                'telefono'   => (string) $l['telefono'],
                'poblacion'  => (string) $l['poblacion'],
                'provincia'  => (string) $l['provincia'],
                'pedidos'    => 0,
                'cancelados' => 0,
                'gastado'    => 0.0,
                'primero'    => (string) $l['creado'],
                'ultimo'     => (string) $l['creado'],
            );
        }
        $c = $clientes[$email];
        $c['pedidos']++;
        if ((string) $l['estado'] === 'cancelado') {
            $c['cancelados']++;
        } else {
            $c['gastado'] = round($c['gastado'] + (float) $l['total'], 2);
        }
        if ((string) $l['creado'] < $c['primero']) {
            $c['primero'] = (string) $l['creado'];
        }
        if ((string) $l['creado'] >= $c['ultimo']) {
            $c['ultimo'] = (string) $l['creado'];
            $c['nombre'] = (string) $l['nombre'];
            $c['telefono'] = (string) $l['telefono'];
            $c['poblacion'] = (string) $l['poblacion'];
            $c['provincia'] = (string) $l['provincia'];
        }
        $clientes[$email] = $c;
    }
    $salida = array_values($clientes);
    usort($salida, function ($a, $b) {
        if ($a['gastado'] === $b['gastado']) {
            return strcmp((string) $b['ultimo'], (string) $a['ultimo']);
        }
        return ($a['gastado'] < $b['gastado']) ? 1 : -1;
    });
    return $salida;
}

/* CSV para Excel español: BOM UTF-8, punto y coma, fin de línea CRLF y
   los importes con coma decimal. */
function tienda_csv($f) {
    $lineas = tienda_filtrar_indice($f);
    $estados = tienda_estados();
    $pagos = tienda_estados_pago();
    $columnas = array('Numero', 'Fecha', 'Hora', 'Estado', 'Pago', 'Estado del pago', 'Cliente',
                      'Correo', 'Telefono', 'Poblacion', 'Provincia', 'Lotes', 'Unidades', 'Total');
    $celda = function ($v) {
        return '"' . str_replace('"', '""', (string) $v) . '"';
    };
    $filas = array();
    $filas[] = implode(';', array_map($celda, $columnas));
    foreach ($lineas as $l) {
        $e = (string) $l['estado'];
        $p = (string) $l['pago_estado'];
        $filas[] = implode(';', array_map($celda, array(
            $l['numero'],
            substr((string) $l['creado'], 0, 10),
            substr((string) $l['creado'], 11, 5),
            isset($estados[$e]) ? $estados[$e]['etiqueta'] : $e,
            ((string) $l['pago'] === 'tarjeta') ? 'Tarjeta' : 'Contrarreembolso',
            isset($pagos[$p]) ? $pagos[$p]['etiqueta'] : $p,
            $l['nombre'],
            $l['email'],
            $l['telefono'],
            $l['poblacion'],
            $l['provincia'],
            (isset($l['lotes']) && is_array($l['lotes'])) ? implode(' | ', $l['lotes']) : '',
            (int) $l['unidades'],
            number_format((float) $l['total'], 2, ',', ''),
        )));
    }
    return "\xEF\xBB\xBF" . implode("\r\n", $filas) . "\r\n";
}


/* =============================================================
   7. ACCESO AL PANEL
   ============================================================= */

function tienda_admin_existe() {
    $datos = tienda_leer_json(tienda_ruta_admin());
    return (isset($datos['hash']) && is_string($datos['hash']) && $datos['hash'] !== '');
}

/* Primera contraseña. No se guarda nunca en claro: sólo el hash. */
function tienda_admin_crear($password) {
    $password = (string) $password;
    if (mb_strlen($password) < 8) {
        return false;
    }
    if (tienda_admin_existe()) {
        return false;
    }
    tienda_asegurar_datos();
    $datos = array(
        'hash'        => password_hash($password, PASSWORD_DEFAULT),
        'creado'      => tienda_ahora(),
        'actualizado' => tienda_ahora(),
    );
    if (!tienda_escribir_atomico(tienda_ruta_admin(), tienda_json($datos))) {
        return false;
    }
    tienda_intentos_limpiar();
    tienda_sesion_abrir();
    return true;
}

/* Comprueba la contraseña y, si es buena, abre la sesión del panel.
   Si falla, apunta el intento (cinco seguidos bloquean cinco minutos). */
function tienda_admin_verificar($password) {
    $password = (string) $password;
    if (tienda_intentos_bloqueado() > 0) {
        return false;
    }
    $datos = tienda_leer_json(tienda_ruta_admin());
    $hash = isset($datos['hash']) ? (string) $datos['hash'] : '';
    if ($hash === '' || $password === '') {
        tienda_intentos_fallo();
        return false;
    }
    if (!password_verify($password, $hash)) {
        tienda_intentos_fallo();
        return false;
    }
    tienda_intentos_limpiar();
    tienda_sesion_abrir();
    return true;
}

/* Cambio de contraseña desde Ajustes. La actual se comprueba sin
   contar intentos: quien ya está dentro no se puede autobloquear. */
function tienda_admin_cambiar($actual, $nuevo) {
    $actual = (string) $actual;
    $nuevo = (string) $nuevo;
    if (mb_strlen($nuevo) < 8) {
        return false;
    }
    $datos = tienda_leer_json(tienda_ruta_admin());
    $hash = isset($datos['hash']) ? (string) $datos['hash'] : '';
    if ($hash === '' || !password_verify($actual, $hash)) {
        return false;
    }
    $datos['hash'] = password_hash($nuevo, PASSWORD_DEFAULT);
    $datos['actualizado'] = tienda_ahora();
    if (!tienda_escribir_atomico(tienda_ruta_admin(), tienda_json($datos))) {
        return false;
    }
    tienda_intentos_limpiar();
    return true;
}

/* Segundos que faltan para poder volver a intentarlo. 0 = adelante. */
function tienda_intentos_bloqueado() {
    $datos = tienda_leer_json(tienda_ruta_intentos());
    $hasta = isset($datos['bloqueo_hasta']) ? (int) $datos['bloqueo_hasta'] : 0;
    $faltan = $hasta - time();
    return ($faltan > 0) ? $faltan : 0;
}

function tienda_intentos_fallo() {
    tienda_asegurar_datos();
    $fh = tienda_bloquear('intentos');
    $datos = tienda_leer_json(tienda_ruta_intentos());
    $fallos = isset($datos['fallos']) ? (int) $datos['fallos'] : 0;
    $ultimo = isset($datos['ultimo']) ? (int) $datos['ultimo'] : 0;
    /* Un fallo suelto de hace un cuarto de hora ya no cuenta. */
    if ($ultimo > 0 && (time() - $ultimo) > 900) {
        $fallos = 0;
    }
    $fallos++;
    $bloqueo = isset($datos['bloqueo_hasta']) ? (int) $datos['bloqueo_hasta'] : 0;
    if ($fallos >= TORNAREM_INTENTOS_MAX) {
        $bloqueo = time() + TORNAREM_BLOQUEO_SEG;
        $fallos = 0;
    }
    tienda_escribir_atomico(tienda_ruta_intentos(), tienda_json(array(
        'fallos'        => $fallos,
        'ultimo'        => time(),
        'bloqueo_hasta' => $bloqueo,
    )));
    tienda_desbloquear($fh);
}

function tienda_intentos_limpiar() {
    tienda_asegurar_datos();
    $fh = tienda_bloquear('intentos');
    tienda_escribir_atomico(tienda_ruta_intentos(), tienda_json(array(
        'fallos'        => 0,
        'ultimo'        => 0,
        'bloqueo_hasta' => 0,
    )));
    tienda_desbloquear($fh);
}


/* =============================================================
   8. SESIÓN, CSRF Y RESPUESTAS
   ============================================================= */

/* Arranca la sesión del panel con la cookie bien puesta: sólo HTTP
   (el JavaScript no la puede leer) y SameSite Lax. */
function tienda_sesion() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        tienda_sesion_token();
        return;
    }
    if (headers_sent()) {
        return;
    }
    $seguro = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '' && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    session_name('tornarem_panel');
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params(array(
            'lifetime' => 0,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $seguro,
            'httponly' => true,
            'samesite' => 'Lax',
        ));
    } else {
        session_set_cookie_params(0, '/; samesite=Lax', '', $seguro, true);
    }
    @session_start();
    tienda_sesion_token();
}

function tienda_sesion_token() {
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        return;
    }
    if (!isset($_SESSION['csrf']) || !is_string($_SESSION['csrf']) || $_SESSION['csrf'] === '') {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
}

/* Marca la sesión como autenticada. La llaman tienda_admin_verificar y
   tienda_admin_crear: quien las use no tiene que saber cómo se guarda. */
function tienda_sesion_abrir() {
    tienda_sesion();
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        return;
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        @session_regenerate_id(true);
    }
    $_SESSION['admin'] = true;
    $_SESSION['visto'] = time();
    tienda_sesion_token();
}

function tienda_sesion_cerrar() {
    tienda_sesion();
    $_SESSION = array();
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (!headers_sent() && ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        @session_destroy();
    }
}

/* Hay sesión si está marcada y no lleva ocho horas parada. */
function tienda_sesion_activa() {
    tienda_sesion();
    if (!isset($_SESSION) || !is_array($_SESSION) || empty($_SESSION['admin'])) {
        return false;
    }
    $visto = isset($_SESSION['visto']) ? (int) $_SESSION['visto'] : 0;
    if ($visto > 0 && (time() - $visto) > TORNAREM_SESION_MAX) {
        $_SESSION['admin'] = false;
        return false;
    }
    $_SESSION['visto'] = time();
    return true;
}

function tienda_csrf() {
    tienda_sesion();
    if (!isset($_SESSION) || !is_array($_SESSION) || !isset($_SESSION['csrf'])) {
        return '';
    }
    return (string) $_SESSION['csrf'];
}

function tienda_csrf_valido($token) {
    if ($token === null || !is_string($token) || $token === '') {
        return false;
    }
    $bueno = tienda_csrf();
    if ($bueno === '') {
        return false;
    }
    return hash_equals($bueno, $token);
}

/* Cuerpo JSON de la petición. Array vacío si no viene o no es JSON. */
function tienda_entrada_json() {
    $raw = @file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') {
        return array();
    }
    $datos = json_decode($raw, true);
    return is_array($datos) ? $datos : array();
}

/* Respuesta JSON y punto final. */
function tienda_responder($datos, $codigo = 200) {
    if (!headers_sent()) {
        http_response_code((int) $codigo);
        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: no-store');
        header('Referrer-Policy: same-origin');
    }
    echo tienda_json($datos, false);
    exit;
}
