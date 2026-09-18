<?php
/* =============================================================
   Páginas de aterrizaje por búsqueda.

   Cada una responde a una forma distinta de buscar lo mismo:
   «comprar devoluciones de amazon», «palets de devoluciones»,
   «cajas misteriosas», «liquidación de stock», «al por mayor».
   No son la misma página con las palabras cambiadas: quien busca
   «palet» quiere saber cuánto pesa y dónde lo descarga, y quien
   busca «caja misteriosa» quiere saber si le van a timar.
   ============================================================= */

$TODOS = array();
foreach ($CAT['lotes'] as $l) { $TODOS[] = $l['id']; }

$CAJAS = array('lote-juguetes', 'lote-belleza', 'lote-electronica', 'lote-hogar-cocina', 'lote-moda', 'lote-herramientas', 'lote-informatica');
$PALES = array('lote-pale-mixto', 'lote-deporte', 'lote-bebe');

/* Enlaces que aparecen desde varias páginas */
$L_GUIA   = array('k' => 'Guía', 't' => 'Cómo comprar devoluciones de Amazon', 'u' => 'blog/como-comprar-devoluciones-de-amazon.html', 'd' => 'Los pasos, los precios reales y los errores que se pagan caros la primera vez.');
$L_PRECIO = array('k' => 'Guía', 't' => 'Cuánto cuesta un palé de devoluciones', 'u' => 'blog/cuanto-cuesta-un-palet-de-devoluciones.html', 'd' => 'Precios por categoría, qué encarece un palé y cuándo un precio bajo es mala señal.');
$L_GRADOS = array('k' => 'Guía', 't' => 'Grados A, B y C: qué significan', 'u' => 'blog/grados-a-b-c-devoluciones.html', 'd' => 'La clasificación que decide el precio, explicada sin marketing.');
$L_RENTA  = array('k' => 'Guía', 't' => '¿Es rentable revender devoluciones?', 'u' => 'blog/es-rentable-revender-devoluciones-de-amazon.html', 'd' => 'Los números con los que sale y los números con los que no sale.');
$L_DENTRO = array('k' => 'Guía', 't' => 'Qué hay dentro de un palé', 'u' => 'blog/que-hay-dentro-de-un-palet-de-devoluciones.html', 'd' => 'El reparto real de un palé sin clasificar, abierto y contado.');


/* ---------------------------------------------------------------- 1 */
$PAGINAS[] = array(
  'ruta' => 'comprar-devoluciones-de-amazon.html',
  'titulo' => 'Comprar devoluciones de Amazon · Lotes desde 319 €',
  'desc' => 'Compra devoluciones de Amazon por lotes cerrados, revisados y clasificados por grados. Desde 319 € con IVA y envío 24 h. Contrarreembolso o tarjeta.',
  'kicker' => 'Liquidación de devoluciones · Stock propio · Nave en Girona',
  'h1' => 'Comprar devoluciones de Amazon',
  'entradilla' => 'Compramos camiones enteros de devoluciones, los abrimos, los clasificamos por grados y los vendemos en lotes cerrados con el contenido publicado. <b>Desde 319 €</b>, con IVA y envío de 24 h incluidos, y pagando al recibirlo si lo prefieres.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Pasillo de la nave con estanterías llenas de palés de devoluciones clasificadas',
  'respuesta' => 'Las devoluciones de Amazon se compran a <b>liquidadores</b>, no a Amazon: Amazon vende su mercancía devuelta en camiones completos a empresas que la clasifican y la revenden. En Tornarem un lote cerrado cuesta <b>desde 319 €</b> (64 unidades de juguetes, a 5 € la pieza) y un palé completo <b>1.290 €</b> (unas 210 referencias). El precio lleva IVA y transporte incluidos, se paga contrarreembolso o con tarjeta y llega en 24 horas en península.',
  'respuestaDatos' => array(
            array('Desde', '319<span class="u"> €</span>'),
            array('Lotes distintos', '10'),
            array('Entrega', '24<span class="u"> h</span>'),
            array('Pago', 'Contrarreembolso'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Comprar devoluciones de Amazon', 'u' => null)),
  'datos' => array(
    array('<span data-count="10" data-cifra="lotes">10</span>', 'Lotes distintos en venta'),
    array('319<span class="u"> €</span>', 'El lote más barato'),
    array('−<span data-count="79" data-cifra="descuento">79</span><span class="u"> %</span>', 'Descuento medio sobre PVP'),
    array('24<span class="u"> h</span>', 'Entrega en península'),
  ),
  'bloques' => array(
    array('h2' => 'Qué es exactamente una devolución de Amazon', 'id' => 'que-es', 'html' =>
'    <p>Cuando alguien devuelve un producto a Amazon, en la mayoría de los casos no vuelve a la estantería. Revisar unidad por unidad, reembalar y volver a catalogar cuesta más de lo que vale el producto, así que se retira. Esa mercancía sale en camiones completos, por peso y categoría, hacia empresas que se dedican a liquidarla. Nosotros somos una de ellas.</p>
    <p>La palabra «devolución» esconde cosas muy distintas. Una devolución de talla es una prenda sin estrenar, con la etiqueta puesta. Una devolución de «no era lo que esperaba» es un aparato que se ha sacado de la caja, se ha enchufado y se ha vuelto a meter. Y una devolución por avería es lo que parece. Por eso todo lo que vendemos lleva un grado: sin el grado, el precio no significa nada.</p>'),
    array('h2' => 'Cómo lo compramos y qué hacemos antes de venderlo', 'id' => 'circuito', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Entra el camión.</b> Cada semana descargamos un tráiler con unos 24 palés sin clasificar. Se compra a ciegas, por peso y categoría. Ese riesgo es nuestro y es de donde sale tu descuento.</li>
      <li><b>Se abre todo.</b> Cada unidad pasa por la mesa: se enciende, se comprueba que esté completa y se etiqueta con un grado. Lo que no funciona no entra en ningún lote clasificado.</li>
      <li><b>Se cierran lotes por categoría.</b> Electrónica con electrónica, juguete con juguete. Se cuenta, se fotografía, se publica el contenido y se precinta.</li>
      <li><b>Sale en 24 horas.</b> Si confirmas antes de las 14:00 de un día laborable, la agencia lo recoge esa tarde.</li>
    </ol>
    <p>Hay liquidadores que venden el camión tal cual llega, sin abrirlo. Es más barato y es legítimo: nosotros también lo hacemos con el palé mixto, y lo decimos en la ficha. Pero un lote clasificado y uno sin abrir no son el mismo producto, y quien te los venda al mismo precio te está vendiendo humo.</p>'),
    array('h2' => 'Cuánto cuesta y qué llevas por ese dinero', 'id' => 'precios', 'html' =>
'    <p>Los precios del catálogo van de 319 € el lote de juguetes a 1.290 € el palé mixto de unas 210 referencias. Todos llevan IVA y envío incluidos: el precio que ves es el que pagas.</p>
    <table class="tabla">
      <thead><tr><th>Lote</th><th>Unidades</th><th>Precio</th><th>Por unidad</th></tr></thead>
      <tbody>
        <tr><td>Juguetes y juegos</td><td>64</td><td>319 €</td><td>5,00 €</td></tr>
        <tr><td>Belleza y cuidado personal</td><td>52</td><td>389 €</td><td>7,50 €</td></tr>
        <tr><td>Moda y calzado</td><td>120</td><td>590 €</td><td>4,90 €</td></tr>
        <tr><td>Electrónica de consumo</td><td>42</td><td>549 €</td><td>13,10 €</td></tr>
        <tr><td>Palé mixto sin clasificar</td><td>~210</td><td>1.290 €</td><td>6,10 €</td></tr>
      </tbody>
    </table>
    <p>El precio por unidad no lo es todo: 4,90 € por prenda suena mejor que 13 € por aparato de electrónica, pero una sudadera se revende por 15 € y unos auriculares por 40 €. Lo que importa es el margen, y eso depende de dónde vendas tú. En <a href="blog/como-calcular-el-margen-de-un-lote.html">cómo calcular el margen de un lote</a> están las cuentas hechas.</p>'),
    array('h2' => 'Cómo se paga', 'id' => 'pago', 'html' =>
'    <p><b>Contrarreembolso.</b> Haces el pedido sin pagar nada. Cuando llega el transportista, pagas en efectivo o con tarjeta en su datáfono y te quedas el lote. La agencia cobra un 3 % por gestionar el cobro (mínimo 5 €), que se suma al total. Es la opción que elige la mayoría de quien compra por primera vez, y es razonable: no conoces a quien te vende.</p>
    <p><b>Tarjeta.</b> Pagas al hacer el pedido, en una pasarela segura. No se guarda ningún dato de la tarjeta en nuestro servidor. Te ahorras el 3 % del contrarreembolso.</p>
    <p>En los dos casos va factura con IVA desglosado. Si compras como empresa o autónomo, pon el CIF o NIF en el pedido y la factura sale a ese nombre.</p>'),
    array('h2' => 'Cuidado con esto', 'id' => 'cuidado', 'html' =>
'    <p>El sector tiene mucho vendedor honesto y bastante estafador. Las señales de alarma son siempre las mismas:</p>
    <ul>
      <li><b>Precios imposibles.</b> Un palé de electrónica por 99 € no existe. Lo que existe es el cobro por adelantado y la desaparición.</li>
      <li><b>Sólo aceptan transferencia o Bizum.</b> Si no hay contrarreembolso ni pasarela, no hay a quién reclamar.</li>
      <li><b>Se presentan como «portal oficial de Amazon».</b> Amazon no vende sus devoluciones al público. Cualquiera que diga lo contrario miente. Nosotros somos un liquidador independiente y no tenemos ninguna relación con Amazon.</li>
      <li><b>No hay dirección física.</b> Si no puedes ir a verlo, piénsalo dos veces.</li>
      <li><b>Fotos de catálogo en lugar de fotos del almacén.</b> Si no enseñan su nave, probablemente no tengan.</li>
    </ul>'),
  ),
  'lotes' => $TODOS,
  'lotesTitulo' => 'Los diez lotes que hay hoy en la nave',
  'lotesLead' => 'Precio final con IVA y envío incluido. El stock se actualiza solo con los pedidos del día.',
  'faq' => array(
    array('p' => '¿Se pueden comprar devoluciones de Amazon siendo particular?', 'r' => 'Sí. No hace falta ser empresa ni autónomo para comprar. Otra cosa es revender: si vas a vender de forma habitual y con ánimo de lucro, Hacienda te va a pedir que te des de alta. Lo contamos sin adornos en <a href="blog/necesito-ser-autonomo-para-revender.html">¿necesito ser autónomo para revender?</a>.'),
    array('p' => '¿Cuál es el pedido mínimo?', 'r' => 'Un lote. El más barato son 319 €. No hay mínimo de compra ni cantidad obligatoria.'),
    array('p' => '¿Sabré qué marcas vienen antes de pagar?', 'r' => 'Sabrás el reparto por tipo de producto, las unidades y el grado, porque está publicado en cada ficha. Las marcas concretas varían de un lote a otro porque cada camión trae lo que trae. Si necesitas marcas concretas, llámanos antes y te decimos qué hay en el que saldría.'),
    array('p' => '¿Esto es un portal oficial de Amazon?', 'r' => 'No. Tornarem es un liquidador independiente. Amazon es una marca registrada de Amazon.com, Inc. o sus filiales, y no hay ninguna afiliación, patrocinio ni respaldo por su parte. Desconfía de quien te diga lo contrario.'),
    array('p' => '¿Hacéis envíos a Canarias o Baleares?', 'r' => 'A Baleares y Canarias, con presupuesto aparte: el transporte marítimo y los trámites de aduana cambian mucho el precio. Escríbenos con el lote que quieres y el código postal y te lo cerramos antes de que pidas nada.'),
    array('p' => '¿Y si el lote llega roto?', 'r' => 'Se cambia o se devuelve el dinero, y el transporte lo pagamos nosotros. Haz fotos antes de retirar el precinto, que es lo que pide la agencia. En 14 días tienes derecho de desistimiento como en cualquier compra a distancia, salvo el palé mixto, que se vende cerrado y lo avisamos en su ficha.'),
  ),
  'relacionados' => array($L_GUIA, $L_PRECIO, $L_GRADOS, $L_RENTA),
  'relTitulo' => 'Antes de comprar, léete esto',
  'ctaTitulo' => 'El camión de esta semana ya está clasificado',
  'prioridad' => '1.0', 'frecuencia' => 'daily',
);


/* ---------------------------------------------------------------- 2 */
$PAGINAS[] = array(
  'ruta' => 'palets-de-devoluciones-de-amazon.html',
  'titulo' => 'Palés de devoluciones de Amazon desde 519 €',
  'desc' => 'Palés de devoluciones de Amazon con porte incluido: mixtos sin clasificar y por categoría. Desde 519 € con IVA, entrega en 24-48 h en península.',
  'kicker' => 'Palé completo · Transporte especializado · 24-48 h',
  'h1' => 'Palés de devoluciones de Amazon',
  'entradilla' => 'Un palé es la unidad de compra de quien ya revende: más volumen, menos euros por referencia y el transporte incluido en el precio. Tenemos <b>palés por categoría</b> y el <b>palé mixto sin clasificar</b>, tal cual baja del camión.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Descarga de palés retractilados desde un tráiler en el muelle de la nave',
  'respuesta' => 'Un palé de devoluciones de Amazon en España cuesta <b>entre 500 y 1.500 €</b> según categoría y grado. En Tornarem, el palé por categoría empieza en <b>519 €</b> y el <b>palé mixto sin clasificar son 1.290 €</b> por unas 210 referencias, a 6 € cada una. Pesan entre 58 y 210 kg, viajan con transporte paletizado incluido y llegan en 24-48 horas en península. Si no tienes muelle, hay que pedir plataforma elevadora al hacer el pedido.',
  'respuestaDatos' => array(
            array('Palé por categoría', '519<span class="u"> €</span>'),
            array('Palé mixto', '1.290<span class="u"> €</span>'),
            array('Referencias', '~210'),
            array('Porte', 'Incluido'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Palés de devoluciones', 'u' => null)),
  'datos' => array(
    array('519<span class="u"> €</span>', 'Palé por categoría desde'),
    array('1.290<span class="u"> €</span>', 'Palé mixto (~210 refs)'),
    array('6<span class="u"> €</span>', 'Por referencia en el mixto'),
    array('24-48<span class="u"> h</span>', 'Entrega con porte incluido'),
  ),
  'bloques' => array(
    array('h2' => 'Qué es un palé de devoluciones y en qué se diferencia de un lote', 'id' => 'que-es', 'html' =>
'    <p>Un lote es una caja: entre 14 y 120 unidades, sale por agencia normal y lo recibes en 24 horas en la puerta de casa. Un palé es un europalé de 120×80 retractilado, de entre 58 y 210 kg, que viaja con transporte especializado y que alguien tiene que descargar.</p>
    <p>La diferencia real no es el tamaño: es el precio por referencia. En un lote pagas entre 5 y 13 € por unidad. En el palé mixto pagas 6 € por referencia con un PVP de catálogo que ronda los 6.500 €. A cambio, asumes que parte de lo que abras no sirva.</p>'),
    array('h2' => 'Los dos tipos de palé que vendemos', 'id' => 'tipos', 'html' =>
'    <h3>Palé por categoría (clasificado)</h3>
    <p>Deporte y fitness, bebé y puericultura. Van en palé porque pesan, no porque estén sin clasificar: cada unidad ha pasado por la mesa de revisión y lleva grado. Sabes lo que compras.</p>
    <h3>Palé mixto sin clasificar</h3>
    <p>Unas 210 referencias mezcladas, retractiladas, tal cual bajan del camión. Reparto habitual: 40 % hogar, 25 % electrónica, 15 % juguete, 20 % varios. No lo abrimos ni lo revisamos, y por eso cuesta 1.290 € en lugar de los 3.000 € que valdría clasificado. Puede haber unidades defectuosas. Se vende cerrado y no admite devolución.</p>
    <p>Si es tu primera compra, empieza por un lote clasificado. El palé mixto es para quien ya sabe cuánto tarda en clasificar 210 referencias y tiene dónde ponerlas.</p>'),
    array('h2' => 'Dónde lo vas a descargar', 'id' => 'descarga', 'html' =>
'    <p>Esta es la pregunta que más gente se salta y la que más problemas da. Un palé de 210 kg no se baja a mano de un camión.</p>
    <ul>
      <li><b>Si tienes muelle o transpaleta:</b> nada que hacer, el camión llega y lo dejas en el suelo.</li>
      <li><b>Si no tienes nada:</b> pide entrega con plataforma elevadora. Lo dejan a pie de calle y desde ahí lo mueves tú. Dilo al hacer el pedido: añadirlo después cuesta más.</li>
      <li><b>Si vives en un piso:</b> no pidas un palé. Pide lotes en caja, que suben por la escalera.</li>
      <li><b>Recogida en nave:</b> gratis. Vienes a Girona con una furgoneta y te lo cargamos con la carretilla.</li>
    </ul>'),
    array('h2' => 'Cuánto tarda y cuánto cuesta el porte', 'id' => 'porte', 'html' =>
'    <p>El porte está incluido en el precio para toda la península. Un palé tarda entre 24 y 48 horas, un poco más que una caja, porque va por transporte paletizado y no por agencia exprés.</p>
    <p>Baleares y Canarias: presupuesto aparte, siempre antes de que pagues nada. El transporte marítimo de un palé cambia mucho según el destino y no queremos darte una cifra que luego no se sostenga.</p>'),
  ),
  'lotes' => $PALES,
  'lotesTitulo' => 'Palés disponibles ahora',
  'lotesLead' => 'Porte incluido en península. El peso está en la ficha: míralo antes de pedir.',
  'faq' => array(
    array('p' => '¿Cuánto pesa un palé de devoluciones?', 'r' => 'Los nuestros van de 58 kg (bebé y puericultura) a 210 kg (palé mixto). El peso exacto está en la ficha de cada uno, junto con las medidas.'),
    array('p' => '¿Puedo elegir lo que viene en el palé mixto?', 'r' => 'No. Es su razón de ser: no se abre, no se clasifica y no se elige. Si quieres elegir, coge un palé por categoría o un lote clasificado.'),
    array('p' => '¿Me mandáis el manifiesto antes de comprar?', 'r' => 'Del palé mixto te mandamos el manifiesto de referencias por correo después del pedido, porque es lo que nos llega del camión. De los palés clasificados, el contenido está publicado en la ficha antes de que compres.'),
    array('p' => '¿Hay descuento si compro varios palés?', 'r' => 'Sí, a partir de tres. Llámanos o escríbenos por WhatsApp con lo que necesitas y te pasamos precio cerrado con el porte.'),
    array('p' => '¿Qué porcentaje del palé mixto suele no servir?', 'r' => 'Entre un 15 y un 20 % por nuestra experiencia abriendo camiones. No es una garantía: es lo que nos sale a nosotros. Métele ese número en tus cuentas antes de comprar.'),
  ),
  'relacionados' => array($L_DENTRO, $L_PRECIO, $L_RENTA, array('k' => 'Comprar', 't' => 'Lotes de devoluciones en caja', 'u' => 'lotes-de-devoluciones-de-amazon.html', 'd' => 'Si no tienes dónde descargar un palé, esto es lo tuyo.')),
  'relTitulo' => 'Sobre palés',
  'ctaTitulo' => 'El palé mixto es el que antes se agota',
  'prioridad' => '0.9', 'frecuencia' => 'daily',
);


/* ---------------------------------------------------------------- 3 */
$PAGINAS[] = array(
  'ruta' => 'lotes-de-devoluciones-de-amazon.html',
  'titulo' => 'Lotes de devoluciones de Amazon · 10 en venta hoy',
  'desc' => 'Lotes de devoluciones de Amazon clasificados por categoría y grado, con el contenido publicado antes de comprar. Desde 319 € con IVA y envío 24 h.',
  'kicker' => 'Catálogo completo · Contenido publicado · Grados A, B y C',
  'h1' => 'Lotes de devoluciones de Amazon',
  'entradilla' => 'Diez lotes cerrados, uno por categoría, con las unidades contadas y el contenido publicado <b>antes</b> de que compres. Desde 319 €, con IVA y envío de 24 h incluidos.',
  'img' => 'assets/img/clasificacion.webp',
  'imgAlt' => 'Mesa de revisión de la nave con productos devueltos clasificándose por grados',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Lotes de devoluciones', 'u' => null)),
  'datos' => array(
    array('<span data-count="10" data-cifra="lotes">10</span>', 'Lotes en venta'),
    array('<span data-count="3322" data-cifra="unidades">3.322</span>', 'Unidades en la nave'),
    array('319<span class="u"> €</span>', 'Desde'),
    array('24<span class="u"> h</span>', 'Entrega en península'),
  ),
  'bloques' => array(
    array('h2' => 'Qué es un lote cerrado', 'id' => 'que-es', 'html' =>
'    <p>Un lote cerrado es una caja con un número fijo de unidades de una misma categoría, revisadas una a una y etiquetadas con un grado. No es una selección que hagas tú: es un paquete que se precinta y se vende entero. Por eso sale a cinco euros la unidad en lugar de a veinte.</p>
    <p>Lo que sí sabes antes de pagar: cuántas unidades hay, de qué tipo, con qué grado, cuánto pesa, cuánto mide la caja y cuál es el PVP estimado del contenido. Está todo en la ficha. Lo que no puedes saber es la marca y el modelo exactos de cada pieza, porque cambian con cada camión.</p>'),
    array('h2' => 'Los diez lotes, por categoría', 'id' => 'categorias', 'html' =>
'    <p>Cada uno tiene su ficha con el contenido, el grado, dónde se revende y qué margen sale:</p>
    <ul class="lista-enlaces">
      <li><a href="lotes/electronica.html">Electrónica de consumo</a> — 42 uds, 549 €. Auriculares, altavoces, smartwatches, tablets.</li>
      <li><a href="lotes/hogar-cocina.html">Pequeño electrodoméstico</a> — 14 uds, 429 €. Freidoras de aire, batidoras, cafeteras.</li>
      <li><a href="lotes/juguetes.html">Juguetes y juegos</a> — 64 uds, 319 €. Construcción, peluches, juegos de mesa.</li>
      <li><a href="lotes/herramientas.html">Herramientas y bricolaje</a> — 18 uds, 489 €. Taladros, atornilladores, maletines.</li>
      <li><a href="lotes/moda.html">Moda y calzado</a> — 120 uds, 590 €. Zapatillas, sudaderas, vaqueros.</li>
      <li><a href="lotes/informatica.html">Informática y periféricos</a> — 26 uds, 699 €. Monitores, teclados, SSD.</li>
      <li><a href="lotes/deporte.html">Deporte y fitness</a> — 22 uds, 519 €. Mancuernas, bici estática, patinete.</li>
      <li><a href="lotes/bebe.html">Bebé y puericultura</a> — 15 uds, 559 €. Sillas de coche, carrito, tronas.</li>
      <li><a href="lotes/belleza.html">Belleza y cuidado personal</a> — 52 uds, 389 €. Secadores, planchas, IPL.</li>
      <li><a href="lotes/pale-mixto.html">Palé mixto sin clasificar</a> — ~210 refs, 1.290 €. Tal cual baja del camión.</li>
    </ul>'),
    array('h2' => 'Cuál te conviene según lo que vayas a hacer', 'id' => 'cual', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Si eres…</th><th>Empieza por</th><th>Por qué</th></tr></thead>
      <tbody>
        <tr><td>Primera vez, sin experiencia</td><td>Juguetes (319 €)</td><td>Entrada baja, muchas unidades, se vende solo</td></tr>
        <tr><td>Vendes en Vinted</td><td>Moda (590 €)</td><td>120 prendas con etiqueta, envío barato</td></tr>
        <tr><td>Vendes en Wallapop</td><td>Electrónica (549 €)</td><td>Piezas pequeñas y con demanda constante</td></tr>
        <tr><td>Tienes tienda física</td><td>Hogar o Herramientas</td><td>Ticket medio alto y rotación buena</td></tr>
        <tr><td>Ya revendes a volumen</td><td>Palé mixto (1.290 €)</td><td>El precio por referencia más bajo</td></tr>
      </tbody>
    </table>'),
  ),
  'lotes' => $TODOS,
  'lotesTitulo' => 'Catálogo completo',
  'lotesLead' => 'Lo que ves es lo que queda: el stock baja solo a medida que entran pedidos.',
  'faq' => array(
    array('p' => '¿Puedo mezclar productos de varios lotes?', 'r' => 'No. Los lotes se venden cerrados y precintados; es lo que permite el precio. Si necesitas una selección concreta, llámanos y hablamos de un lote a medida a otro precio.'),
    array('p' => '¿Cuántos lotes puedo comprar de una vez?', 'r' => 'Los que haya en stock. Si te llevas tres o más, escríbenos antes: normalmente sale mejor precio y agrupamos el transporte.'),
    array('p' => '¿Cada cuánto entra género nuevo?', 'r' => 'Un tráiler por semana, los jueves. La categoría cambia: la de la semana que viene está anunciada en la portada con la cuenta atrás.'),
    array('p' => '¿Qué pasa si se agota el lote que quiero?', 'r' => 'Escríbenos por WhatsApp o correo y te avisamos en cuanto vuelva a haber. Suele ser cuestión de días, no de semanas.'),
  ),
  'relacionados' => array($L_GRADOS, $L_GUIA, array('k' => 'Comprar', 't' => 'Palés completos', 'u' => 'palets-de-devoluciones-de-amazon.html', 'd' => 'Más volumen y menos euros por referencia, si tienes dónde descargarlo.'), $L_RENTA),
  'relTitulo' => 'Para decidir mejor',
  'ctaTitulo' => 'Diez lotes, stock real, entrega mañana',
  'prioridad' => '0.9', 'frecuencia' => 'daily',
);


/* ---------------------------------------------------------------- 4 */
$PAGINAS[] = array(
  'ruta' => 'cajas-misteriosas-amazon.html',
  'titulo' => 'Cajas misteriosas de Amazon: qué llevan de verdad',
  'desc' => 'Qué hay realmente en una caja misteriosa de Amazon, por qué casi todas decepcionan y qué comprar en su lugar. Lotes con el contenido publicado desde 319 €.',
  'kicker' => 'Sin misterio · Contenido publicado · Desde 319 €',
  'h1' => 'Cajas misteriosas de Amazon',
  'entradilla' => 'La mayoría de «cajas misteriosas» que se venden por internet son mercancía de devolución sin clasificar, vendida a peso y con un envoltorio de marketing. <b>No hay magia dentro.</b> Lo que sí hay es una forma honesta de comprar lo mismo: sabiendo qué llevas.',
  'img' => 'assets/img/lote-pale-mixto.webp',
  'imgAlt' => 'Palé mixto retractilado con referencias mezcladas sin clasificar',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Cajas misteriosas', 'u' => null)),
  'bloques' => array(
    array('h2' => 'De dónde sale una caja misteriosa', 'id' => 'origen', 'html' =>
'    <p>Sale del mismo sitio que nuestros lotes: de camiones de devoluciones y excedentes que Amazon y otras plataformas venden por peso a empresas liquidadoras. La diferencia está en lo que hace el vendedor después.</p>
    <p>Un liquidador serio abre la mercancía, la clasifica, le pone un grado y publica lo que hay. Un vendedor de cajas misteriosas coge lo mismo sin abrirlo, le llama «mystery box», le pone un precio redondo y vende la emoción. A veces sale bien y a veces te llega una caja de cables USB.</p>'),
    array('h2' => 'Las tres versiones que circulan', 'id' => 'tipos', 'html' =>
'    <h3>1. La caja de sobres perdidos</h3>
    <p>«Paquetes no entregados». Suele ser mercancía de bajo valor comprada al peso, mezclada con relleno. El vídeo de la apertura vale más que el contenido.</p>
    <h3>2. La caja temática cara</h3>
    <p>«Caja de electrónica premium, valor 800 €, tuya por 150 €». Ese valor casi siempre es la suma de PVP de catálogo de productos que nunca se vendieron a ese precio. Cuando hay un valor declarado sin listado de referencias, desconfía.</p>
    <h3>3. El palé sin clasificar</h3>
    <p>Esta sí es real, y es la que vendemos nosotros: un palé tal cual baja del camión, con su manifiesto y su precio bajo justificado por el riesgo. La diferencia es que se llama por su nombre y se explica lo que puede salir mal.</p>'),
    array('h2' => 'Lo que sí puedes comprar sin jugártela', 'id' => 'alternativa', 'html' =>
'    <p>Si lo que te atrae es la sorpresa, el <a href="lotes/pale-mixto.html">palé mixto sin clasificar</a> es exactamente eso, pero con las cartas boca arriba: 1.290 €, unas 210 referencias, un reparto por categorías publicado, manifiesto por correo y un aviso claro de que puede haber unidades defectuosas y no admite devolución.</p>
    <p>Si lo que quieres es que las cuentas salgan, cualquiera de los lotes clasificados es mejor negocio: sabes cuántas unidades hay, de qué son y en qué estado están. La sorpresa es cara.</p>'),
    array('h2' => 'Cómo saber si te están timando', 'id' => 'timos', 'html' =>
'    <ul>
      <li>No dicen ni cuántas unidades hay ni cuánto pesa.</li>
      <li>El «valor estimado» es un número redondo y grande, sin listado detrás.</li>
      <li>Sólo aceptan Bizum o transferencia, nunca contrarreembolso.</li>
      <li>Las fotos son de stock y no hay ninguna del almacén.</li>
      <li>Dicen ser «oficiales de Amazon». Amazon no vende sus devoluciones al público: es falso siempre.</li>
      <li>No hay dirección física ni CIF en ninguna parte del sitio.</li>
    </ul>'),
  ),
  'lotes' => $CAJAS,
  'lotesTitulo' => 'Lo mismo, pero sabiendo qué llevas',
  'lotesLead' => 'Cada caja lleva el contenido publicado, las unidades contadas y el grado etiquetado.',
  'faq' => array(
    array('p' => '¿Vendéis cajas misteriosas?', 'r' => 'No con ese nombre. Vendemos un palé mixto sin clasificar, que es el producto real detrás de casi todas las cajas misteriosas, con su precio, su manifiesto y sus avisos. Y vendemos lotes clasificados, que es lo que recomendamos si quieres que las cuentas salgan.'),
    array('p' => '¿Merecen la pena las cajas misteriosas baratas de 20 o 30 €?', 'r' => 'Como entretenimiento, puede. Como negocio, no: a ese precio el vendedor está colocando material de muy bajo valor y el margen se lo lleva él.'),
    array('p' => '¿Amazon vende cajas misteriosas oficialmente?', 'r' => 'No. Amazon liquida su mercancía devuelta a empresas por camiones completos; no vende cajas sorpresa al público. Quien diga que vende «cajas oficiales de Amazon» está mintiendo.'),
    array('p' => '¿Puedo devolver un palé mixto si no me gusta lo que sale?', 'r' => 'No. Se vende cerrado, sin abrir y sin revisar, y eso es precisamente lo que permite el precio. Está avisado en la ficha antes de comprar.'),
  ),
  'relacionados' => array($L_DENTRO, array('k' => 'Comprar', 't' => 'Palé mixto sin clasificar', 'u' => 'lotes/pale-mixto.html', 'd' => 'La versión honesta de la caja misteriosa: ~210 referencias por 1.290 €.'), $L_RENTA, $L_GUIA),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Mejor saber qué compras',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
);


/* ---------------------------------------------------------------- 5 */
$PAGINAS[] = array(
  'ruta' => 'liquidacion-de-stock-amazon.html',
  'titulo' => 'Liquidación de stock y excedentes de Amazon',
  'desc' => 'Liquidación de stock procedente de devoluciones y excedentes de Amazon: lotes por categoría y palés completos, con IVA y transporte incluidos. Desde 319 €.',
  'kicker' => 'Excedentes y devoluciones · Stock propio · Factura con IVA',
  'h1' => 'Liquidación de stock de Amazon',
  'entradilla' => 'Mercancía que salió del catálogo de Amazon por devolución, cambio de temporada o exceso de inventario, y que ya no vuelve a la estantería. La compramos por camiones y la liquidamos <b>por lotes y palés con factura</b>.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Estanterías de la nave con cajas y palés de stock clasificado',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Liquidación de stock', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Por qué existe el stock de liquidación', 'id' => 'por-que', 'html' =>
'    <p>Para una plataforma como Amazon, el coste de procesar una devolución (recibirla, revisarla, reembalarla, volver a catalogarla y almacenarla) supera muchas veces el margen del producto. A eso se suman los excedentes: temporadas que no se vendieron, empaquetados que cambiaron, referencias descatalogadas.</p>
    <p>Todo eso se agrupa y se vende en camiones completos, por peso y categoría, a empresas liquidadoras. No es mercancía defectuosa por definición: es mercancía que ha dejado de ser rentable de gestionar. Es una diferencia importante y es de donde sale el descuento.</p>'),
    array('h2' => 'Qué tipo de stock manejamos', 'id' => 'tipos', 'html' =>
'    <ul>
      <li><b>Devoluciones de cliente.</b> Lo más habitual. Talla equivocada, «no era lo que esperaba», compra impulsiva arrepentida. Buena parte está sin estrenar.</li>
      <li><b>Producto con embalaje dañado.</b> Funciona perfectamente; la caja se golpeó en almacén o en transporte.</li>
      <li><b>Excedente de temporada.</b> Producto nuevo que no se vendió a tiempo. Es el mejor material que pasa por la nave.</li>
      <li><b>Devolución por avería.</b> No entra en lotes clasificados. O se aparta o va al palé mixto, que se vende con ese aviso.</li>
    </ul>'),
    array('h2' => 'Cómo se compra y qué documentación va', 'id' => 'como', 'html' =>
'    <p>Se compra por unidades de venta cerradas: lote en caja o palé. No vendemos por unidades sueltas ni hacemos selección a medida dentro de un lote.</p>
    <p>Con cada pedido va <b>factura con el IVA desglosado</b>. Si compras como empresa o autónomo, escribe el CIF o NIF al hacer el pedido y la factura sale a ese nombre, lista para tu contabilidad. Para compras repetidas de varios palés al mes, llámanos: se trabaja con precio cerrado y calendario de descarga.</p>'),
    array('h2' => 'Qué margen deja el stock de liquidación', 'id' => 'margen', 'html' =>
'    <p>El descuento medio de nuestro catálogo sobre el PVP estimado ronda el 79 %. Eso no es tu margen: es el punto de partida. De ahí tienes que restar lo que no se venda, lo que se venda por debajo de lo previsto, tu tiempo de clasificar y fotografiar, y el transporte de tus ventas.</p>
    <p>Con las cuentas hechas, un lote clasificado bien trabajado suele dejar entre un 40 % y un 120 % sobre lo invertido. Un palé mixto puede dejar más o puede dejar menos, porque el riesgo lo asumes tú. Las cuentas completas, con números y sin adornos, están en <a href="blog/es-rentable-revender-devoluciones-de-amazon.html">¿es rentable revender devoluciones de Amazon?</a>.</p>'),
  ),
  'lotes' => $TODOS,
  'lotesTitulo' => 'Stock disponible hoy',
  'lotesLead' => 'Precios con IVA y transporte incluidos. Factura con cada pedido.',
  'faq' => array(
    array('p' => '¿Vendéis a empresas y autónomos?', 'r' => 'Sí, y es buena parte de lo que hacemos. Pon el CIF o NIF en el pedido y la factura sale a nombre de la empresa con el IVA desglosado.'),
    array('p' => '¿Hay precio especial por volumen?', 'r' => 'A partir de tres palés o cinco lotes, sí. Escríbenos con lo que necesitas y con cada cuánto, y te pasamos precio cerrado.'),
    array('p' => '¿El stock es siempre de Amazon?', 'r' => 'La mayor parte sí, porque es el origen de los camiones que compramos. También entra excedente de otros distribuidores. En la ficha de cada lote está la categoría y el grado; el origen exacto de cada unidad no se puede certificar pieza a pieza y no vamos a decir que sí.'),
    array('p' => '¿Puedo ver el stock antes de comprar?', 'r' => 'Sí. Nave 14, Polígono Mas Xirgu, Girona, de lunes a viernes de 8:00 a 18:00. Avisa antes de venir y te tenemos preparado lo que quieras ver abierto.'),
  ),
  'relacionados' => array($L_RENTA, array('k' => 'Comprar', 't' => 'Venta al por mayor', 'u' => 'devoluciones-de-amazon-al-por-mayor.html', 'd' => 'Volumen recurrente, precio cerrado y calendario de descarga.'), $L_PRECIO, $L_GRADOS),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Stock nuevo cada jueves',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
);


/* ---------------------------------------------------------------- 6 */
$PAGINAS[] = array(
  'ruta' => 'devoluciones-de-amazon-al-por-mayor.html',
  'titulo' => 'Devoluciones de Amazon al por mayor · Venta B2B',
  'desc' => 'Venta al por mayor de devoluciones de Amazon: varios palés al mes, precio cerrado, factura con IVA y calendario de descarga. Nave propia en Girona.',
  'kicker' => 'B2B · Volumen recurrente · Factura con IVA',
  'h1' => 'Devoluciones de Amazon al por mayor',
  'entradilla' => 'Si revendes de forma habitual, no necesitas un lote: necesitas <b>volumen constante, precio cerrado y saber cuándo llega</b>. Eso se habla por teléfono y se cierra por escrito.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Muelle de la nave con varios palés preparados para cargar',
  'respuesta' => 'Para comprar devoluciones de Amazon al por mayor en Tornarem el umbral son <b>tres palés o cinco lotes</b> en un mismo pedido, o un compromiso de compra mensual. A partir de ahí hay precio cerrado con porte incluido, reserva de categoría del camión del jueves antes de que salga a la web, y <b>factura recapitulativa mensual</b> a nombre de la empresa. No se garantizan marcas concretas: sí categoría, grado y volumen.',
  'respuestaDatos' => array(
            array('Umbral', '3 palés'),
            array('Camiones', '1 por semana'),
            array('Palés por camión', '24'),
            array('Factura', 'Mensual'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Venta al por mayor', 'u' => null)),
  'datos' => array(
    array('24', 'Palés por camión'),
    array('1', 'Camión por semana'),
    array('3', 'Palés para precio cerrado'),
    array('48<span class="u"> h</span>', 'Entrega paletizada'),
  ),
  'bloques' => array(
    array('h2' => 'Para quién es', 'id' => 'para-quien', 'html' =>
'    <p>Para tiendas físicas que necesitan reponer todas las semanas, para puestos de mercadillo con varios días de venta, para quien vende online a volumen y para quien revende a otros revendedores. Si compras menos de un palé al mes, te sale mejor el catálogo normal.</p>'),
    array('h2' => 'Cómo trabajamos el volumen', 'id' => 'como', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Nos dices qué categorías y qué ritmo.</b> Por ejemplo: dos palés de hogar y uno de electrónica cada quince días.</li>
      <li><b>Te damos precio cerrado.</b> Por palé, con el porte incluido y sin sorpresas. Si una semana el camión no trae tu categoría, te lo decimos antes, no después.</li>
      <li><b>Reservamos al descargar.</b> El jueves entra el tráiler y lo tuyo se aparta antes de publicarse en la web.</li>
      <li><b>Se factura y se envía.</b> Factura con IVA desglosado a nombre de tu empresa, transporte paletizado o recogida en nave.</li>
    </ol>'),
    array('h2' => 'Lo que no hacemos', 'id' => 'no', 'html' =>
'    <p>Para que no perdamos ninguno de los dos el tiempo:</p>
    <ul>
      <li><b>No vendemos por unidades sueltas.</b> Ni al por mayor ni al por menor. La unidad mínima es el lote.</li>
      <li><b>No garantizamos marcas concretas.</b> Podemos garantizar categoría, grado y volumen. La marca depende del camión y no vamos a prometer lo que no controlamos.</li>
      <li><b>No exportamos fuera de la UE.</b> Península y Baleares con normalidad, Canarias con presupuesto y trámites aparte.</li>
      <li><b>No damos exclusividad territorial.</b> Vendemos a quien compre, y eso incluye a quien vende cerca de ti.</li>
    </ul>'),
    array('h2' => 'Hablarlo', 'id' => 'contacto', 'html' =>
'    <p>Lo más rápido es el teléfono: <a href="tel:+34900000000">900 000 000</a>, de lunes a viernes de 8:00 a 18:00. También por <a href="https://wa.me/34600000000" target="_blank" rel="noopener">WhatsApp</a> o en <a href="mailto:pedidos@tornarem.cat">pedidos@tornarem.cat</a>.</p>
    <p>Si escribes, dinos: categorías que te interesan, cuántos palés y con qué frecuencia, provincia de entrega y si tienes muelle o necesitas plataforma elevadora. Con eso te damos precio el mismo día.</p>'),
  ),
  'lotes' => array('lote-pale-mixto', 'lote-moda', 'lote-juguetes'),
  'lotesTitulo' => 'Lo que más se pide a volumen',
  'lotesLead' => 'Estos precios son de unidad suelta. A partir de tres palés, hablamos.',
  'faq' => array(
    array('p' => '¿Cuál es el volumen mínimo para precio de mayorista?', 'r' => 'Tres palés o cinco lotes en un mismo pedido, o un compromiso de compra recurrente mensual. Por debajo de eso, el precio del catálogo ya es el bueno.'),
    array('p' => '¿Puedo pagar a plazos o a 30 días?', 'r' => 'En la primera compra no: contrarreembolso o tarjeta, como todo el mundo. A partir de la tercera compra y con la documentación de la empresa, se puede hablar de pago aplazado.'),
    array('p' => '¿Emitís factura recapitulativa?', 'r' => 'Sí, mensual si compras varias veces al mes. Dilo al cerrar el acuerdo y se hace así desde el principio.'),
    array('p' => '¿Podéis reservar una categoría concreta del próximo camión?', 'r' => 'Sí, con acuerdo previo y señal. Es lo habitual con los clientes recurrentes: se aparta al descargar, antes de que salga a la web.'),
  ),
  'relacionados' => array(array('k' => 'Comprar', 't' => 'Liquidación de stock', 'u' => 'liquidacion-de-stock-amazon.html', 'd' => 'De dónde sale el stock y qué tipos manejamos.'), array('k' => 'Comprar', 't' => 'Palés completos', 'u' => 'palets-de-devoluciones-de-amazon.html', 'd' => 'Pesos, medidas y cómo se descarga un palé.'), $L_RENTA, $L_PRECIO),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Cuéntanos qué volumen necesitas',
  'ctaTexto' => 'Con las categorías, el ritmo y la provincia te damos precio cerrado el mismo día.',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
);
