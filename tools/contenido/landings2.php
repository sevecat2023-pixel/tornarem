<?php
/* =============================================================
   Segunda tanda de páginas de aterrizaje.

   La regla que no se salta aquí: cada página responde a una
   búsqueda real Y vende algo que de verdad tenemos. Hay
   búsquedas con muchísimo volumen («comprar iPhone barato»,
   «televisión 50 pulgadas oferta») que no se tocan: quien las
   escribe quiere ese producto, no un palé, y una página que le
   promete lo primero para enseñarle lo segundo es una puerta
   falsa. Google las llama doorway pages, las penaliza, y de paso
   se lleva por delante el resto del dominio.

   Lo que sí se hace es entrar por el lado honesto de esas mismas
   búsquedas: «cómo salir barato de electrónica comprando
   devoluciones», «qué móviles aparecen en un lote». Misma gente,
   respuesta verdadera, y la venta se cierra sola.
   ============================================================= */

$L2_GUIA   = array('k' => 'Guía', 't' => 'Cómo comprar devoluciones de Amazon', 'u' => 'blog/como-comprar-devoluciones-de-amazon.html', 'd' => 'Los pasos, los precios reales y los errores de la primera compra.');
$L2_RENTA  = array('k' => 'Guía', 't' => '¿Es rentable revender devoluciones?', 'u' => 'blog/es-rentable-revender-devoluciones-de-amazon.html', 'd' => 'Las cuentas con el tiempo dentro, y cuándo la respuesta es que no.');
$L2_GRADOS = array('k' => 'Guía', 't' => 'Grados A, B y C', 'u' => 'blog/grados-a-b-c-devoluciones.html', 'd' => 'La letra que decide el precio, explicada sin marketing.');
$L2_PRECIO = array('k' => 'Guía', 't' => 'Cuánto cuesta un palé', 'u' => 'blog/cuanto-cuesta-un-palet-de-devoluciones.html', 'd' => 'Precios de mercado y por qué un precio muy bajo es mala señal.');
$L2_COMPRAR = array('k' => 'Comprar', 't' => 'Comprar devoluciones de Amazon', 'u' => 'comprar-devoluciones-de-amazon.html', 'd' => 'La página madre: cómo funciona, qué cuesta y qué mirar.');
$L2_PALES  = array('k' => 'Comprar', 't' => 'Palés completos', 'u' => 'palets-de-devoluciones-de-amazon.html', 'd' => 'Más volumen y menos euros por referencia, si tienes dónde descargar.');


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'cajas-sorpresa-amazon.html',
  'titulo' => 'Cajas sorpresa de Amazon: qué son y cuáles valen la pena',
  'desc' => 'Qué hay de verdad dentro de una caja sorpresa de Amazon, cuánto cuestan y por qué un lote con el contenido publicado sale mejor. Desde 319 € con IVA y envío.',
  'kicker' => 'Sorpresa sí, timo no · Contenido publicado · Desde 319 €',
  'h1' => 'Cajas sorpresa de Amazon',
  'entradilla' => 'La caja sorpresa que se vende por internet es, casi siempre, mercancía de devolución sin clasificar con un nombre bonito. <b>Nosotros vendemos lo mismo, pero contándote lo que llevas</b>: unidades, categoría, grado y qué puede salir mal.',
  'img' => 'assets/img/lote-pale-mixto.webp',
  'imgAlt' => 'Palé mixto sin clasificar, retractilado, tal cual baja del camión',
  'respuesta' => 'Casi todas las «cajas sorpresa de Amazon» que se venden por internet son <b>mercancía de devolución sin clasificar</b> con un nombre comercial. No hay caja oficial de Amazon: Amazon no vende cajas sorpresa al público. Lo real detrás es el palé sin clasificar, que en Tornarem cuesta <b>1.290 €</b> por unas 210 referencias, con manifiesto y con el aviso de que puede haber unidades defectuosas. Si prefieres saber qué llevas, un lote clasificado empieza en <b>319 €</b> con el contenido publicado.',
  'respuestaDatos' => array(
            array('Lote clasificado', '319<span class="u"> €</span>'),
            array('Palé sin clasificar', '1.290<span class="u"> €</span>'),
            array('Contenido', 'Publicado'),
            array('Sorpresa oficial', 'No existe'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Cajas sorpresa', 'u' => null)),
  'datos' => array(
    array('319<span class="u"> €</span>', 'La caja más barata'),
    array('64', 'Unidades en esa caja'),
    array('5<span class="u"> €</span>', 'Por unidad'),
    array('0<span class="u"> €</span>', 'De sorpresa en el precio'),
  ),
  'bloques' => array(
    array('h2' => 'Qué es una caja sorpresa, sin el envoltorio', 'id' => 'que-es', 'html' =>
'    <p>Una caja sorpresa es una caja de mercancía que el vendedor no ha abierto, no ha clasificado y no te describe. El atractivo es la emoción de abrirla. El problema es que la emoción la cobras tú una vez y el vendedor cobra siempre.</p>
    <p>El origen es el mismo que el de nuestros lotes: camiones de devoluciones y excedentes que las plataformas venden por peso a empresas liquidadoras. Lo que cambia es lo que hace cada uno después. Abrirlo, contarlo y etiquetarlo cuesta horas de persona; no abrirlo cuesta cero y se vende igual de rápido si le pones un nombre con gancho.</p>'),
    array('h2' => 'Los precios que se ven y lo que hay detrás', 'id' => 'precios', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Lo que se anuncia</th><th>Precio típico</th><th>Lo que suele ser</th></tr></thead>
      <tbody>
        <tr><td>Caja sorpresa pequeña</td><td>20 - 40 €</td><td>Accesorio de bajo valor comprado a peso, con relleno</td></tr>
        <tr><td>Caja sorpresa «premium»</td><td>100 - 200 €</td><td>Lo mismo, con un par de piezas caras de gancho</td></tr>
        <tr><td>Caja de «paquetes perdidos»</td><td>30 - 80 €</td><td>Mercancía suelta sin trazabilidad</td></tr>
        <tr><td>Palé sin clasificar (real)</td><td>1.000 - 1.500 €</td><td>Lo que dice: un palé del camión, con manifiesto</td></tr>
      </tbody>
    </table>
    <p>Las tres primeras filas tienen en común que el «valor estimado» que anuncian no viene acompañado de ninguna lista. Cuando hay una cifra grande y ninguna referencia detrás, la cifra es el producto.</p>'),
    array('h2' => 'La versión honesta de la sorpresa', 'id' => 'honesta', 'html' =>
'    <p>Si lo que te gusta es abrir sin saber qué hay, el <a href="lotes/pale-mixto.html">palé mixto sin clasificar</a> es exactamente eso y lo vendemos con las cartas boca arriba: 1.290 €, unas 210 referencias, reparto habitual publicado, manifiesto por correo tras el pedido y un aviso claro de que puede haber unidades defectuosas y de que no admite devolución.</p>
    <p>Si lo que quieres es que las cuentas salgan, cualquier lote clasificado es mejor negocio. Sabes cuántas unidades hay, de qué son y en qué estado. La sorpresa, en este sector, se paga con margen.</p>'),
    array('h2' => 'Cómo distinguir una caja sorpresa seria', 'id' => 'senales', 'html' =>
'    <ul>
      <li>Dice cuántas unidades hay y cuánto pesa. Si no, no la han abierto ni pesado.</li>
      <li>Acepta contrarreembolso o tarjeta. Sólo Bizum es la señal más clara de todas.</li>
      <li>Tiene CIF y dirección física que existen de verdad en un mapa.</li>
      <li>Las fotos son de su almacén, no de catálogo.</li>
      <li>No dice ser «oficial de Amazon». Amazon no vende cajas sorpresa al público: eso es falso siempre.</li>
    </ul>'),
  ),
  'lotes' => array('lote-juguetes', 'lote-belleza', 'lote-pale-mixto'),
  'lotesTitulo' => 'Sorpresa con lista de la compra',
  'lotesLead' => 'Lo que hay dentro está publicado antes de que pagues. El precio ya lleva IVA y envío.',
  'faq' => array(
    array('p' => '¿Vendéis cajas sorpresa?', 'r' => 'Con ese nombre, no. Vendemos un palé mixto sin clasificar, que es el producto real detrás de casi todas, y lotes clasificados con el contenido publicado.'),
    array('p' => '¿Merece la pena una caja sorpresa de 30 €?', 'r' => 'Como entretenimiento, puede. Como negocio, no: a ese precio el vendedor coloca material de muy poco valor y el margen se queda con él.'),
    array('p' => '¿Puedo devolver una caja si no me gusta lo que sale?', 'r' => 'En nuestros lotes clasificados sí, 14 días como en cualquier compra a distancia. En el palé mixto no: se vende cerrado y sin revisar, y eso es lo que permite el precio.'),
    array('p' => '¿Salen productos de marca?', 'r' => 'Sí, mezclados con marca blanca. En mercancía sin clasificar no se puede garantizar ninguna marca concreta, y quien te la garantice no sabe lo que lleva dentro.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Cajas misteriosas', 'u' => 'cajas-misteriosas-amazon.html', 'd' => 'El mismo asunto con el otro nombre que se usa, y las cinco estafas del sector.'),
    array('k' => 'Comprar', 't' => 'Palé mixto sin clasificar', 'u' => 'lotes/pale-mixto.html', 'd' => '~210 referencias por 1.290 €, con manifiesto y sus avisos.'),
    array('k' => 'Guía', 't' => 'Qué hay dentro de un palé', 'u' => 'blog/que-hay-dentro-de-un-palet-de-devoluciones.html', 'd' => 'Abrimos uno y contamos lo que sale, incluido lo que no sirve.'),
    $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Mejor saber qué compras',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'comprar-electronica-barata-devoluciones.html',
  'titulo' => 'Comprar electrónica barata: lotes de devoluciones desde 549 €',
  'desc' => 'Cómo salir barato de electrónica comprando lotes de devoluciones: auriculares, altavoces, smartwatches y tablets revisados, a 13 € la unidad. IVA y envío incluidos.',
  'kicker' => 'Electrónica revisada · 13 € por unidad · Entrega 24 h',
  'h1' => 'Electrónica barata por lotes',
  'entradilla' => 'La forma más barata de conseguir electrónica de consumo no es esperar al Black Friday: es comprar el lote entero de devoluciones. <b>42 aparatos por 549 €</b>, revisados uno a uno, con IVA y envío incluidos.',
  'img' => 'assets/img/lote-electronica.webp',
  'imgAlt' => 'Auriculares, altavoces, smartwatches y tablets de un lote de electrónica sobre la mesa de revisión',
  'respuesta' => 'La forma más barata de comprar electrónica de consumo es el <b>lote de devoluciones</b>: 42 aparatos por <b>549 €</b>, a 13 € la unidad, con auriculares, altavoces Bluetooth, smartwatches y tablets, todos probados. <b>No salen iPhone ni consolas de última generación</b>: ese material se reacondiciona y se revende aparte, y quien te lo prometa en un palé te está vendiendo la promesa. El precio lleva IVA y envío de 24 h incluidos.',
  'respuestaDatos' => array(
            array('Aparatos', '42'),
            array('Precio', '549<span class="u"> €</span>'),
            array('Por unidad', '13<span class="u"> €</span>'),
            array('iPhone dentro', 'No'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Electrónica barata', 'u' => null)),
  'datos' => array(
    array('42', 'Aparatos por lote'),
    array('13<span class="u"> €</span>', 'Por unidad'),
    array('−<span>79</span><span class="u"> %</span>', 'Sobre el PVP estimado'),
    array('24<span class="u"> h</span>', 'En tu casa'),
  ),
  'bloques' => array(
    array('h2' => 'Por qué sale tan barata', 'id' => 'por-que', 'html' =>
'    <p>Una devolución de electrónica casi nunca vuelve al catálogo. Comprobar que el aparato funciona, limpiarlo, reembalarlo y volver a listarlo cuesta más que el margen del producto, así que se retira y se vende por peso a liquidadores. Ahí es donde entramos: compramos el camión, abrimos, probamos y agrupamos por categoría.</p>
    <p>Lo que pagas no es un producto rebajado: es un lote entero a precio de mayorista de saldo. Por eso salen a 13 € piezas cuyo PVP ronda los 60.</p>'),
    array('h2' => 'Qué hay en un lote de electrónica', 'id' => 'contenido', 'html' =>
'    <ul>
      <li>12 auriculares inalámbricos, de diadema y true wireless</li>
      <li>6 altavoces Bluetooth portátiles</li>
      <li>5 smartwatches y pulseras de actividad</li>
      <li>3 tablets de 10 pulgadas</li>
      <li>8 cargadores rápidos y baterías externas</li>
      <li>8 accesorios: cables, hubs USB-C y soportes</li>
    </ul>
    <p class="nota-destacada">Todo probado: enciende, carga y empareja. El 70 % conserva su caja original. Lo que no funciona no entra en el lote.</p>'),
    array('h2' => 'Para consumo propio o para revender', 'id' => 'para-quien', 'html' =>
'    <p><b>Para ti.</b> Si necesitas unos auriculares, un altavoz y un cargador, un lote es caro para una persona sola: se compra entre dos o tres, se reparte y sale a precio de risa. Mucha gente lo hace así.</p>
    <p><b>Para revender.</b> Es el lote que más rápido se mueve. Son piezas pequeñas, de enviar por cuatro euros, muy buscadas y fáciles de fotografiar. Con vender la mitad recuperas lo invertido; lo contamos con números en <a href="blog/como-calcular-el-margen-de-un-lote.html">cómo calcular el margen</a>.</p>'),
    array('h2' => 'Lo que no vas a encontrar', 'id' => 'ojo', 'html' =>
'    <p>Seamos claros, porque esta es la pregunta que más llega: <b>en un lote de devoluciones no salen iPhone nuevos, ni consolas de última generación, ni televisores de 65 pulgadas</b>. Ese material tiene salida propia y no llega a los camiones de liquidación, o llega roto.</p>
    <p>Lo que sale es electrónica de consumo de precio medio: marcas conocidas de audio, tablets de gama de entrada, accesorios. Buen producto, comprado muy por debajo de su precio, y nada más. Quien te prometa otra cosa está vendiendo la promesa, no el lote.</p>
    <p>Las baterías de tablets y smartwatches llevan uso. Se comprueba que cargan y que aguantan el ciclo, pero no son baterías nuevas: dilo cuando revendas y te ahorras la devolución.</p>'),
  ),
  'lotes' => array('lote-electronica', 'lote-informatica', 'lote-pale-mixto'),
  'lotesTitulo' => 'Electrónica en la nave ahora',
  'lotesLead' => 'Precio final con IVA y envío. El stock baja solo con los pedidos del día.',
  'faq' => array(
    array('p' => '¿Salen móviles en los lotes?', 'r' => 'De vez en cuando aparece alguno en el palé mixto, casi siempre de gama de entrada y sin garantía de nada. En los lotes clasificados de electrónica no entran móviles: lo decimos porque es la pregunta número uno y la respuesta honesta es no.'),
    array('p' => '¿Los aparatos tienen garantía?', 'r' => 'Como vendedor profesional respondemos de que lo entregado sea conforme a lo descrito, y tienes 14 días de desistimiento. La garantía del fabricante no aplica igual en producto de liquidación, y por eso el precio es el que es.'),
    array('p' => '¿Vienen con cargador y cable?', 'r' => 'La mayoría sí, porque son devoluciones con su caja. Alguna unidad llega sin un accesorio menor; cuando lo detectamos, va etiquetado.'),
    array('p' => '¿Puedo comprar sólo dos o tres aparatos?', 'r' => 'No, los lotes se venden cerrados. Es lo que permite el precio por unidad. Si quieres piezas sueltas, el sitio es una tienda de segunda mano, no un liquidador.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Informática y periféricos', 'u' => 'lotes/informatica.html', 'd' => 'Monitores, teclados mecánicos y discos SSD, 26 piezas por 699 €.'),
    array('k' => 'Comprar', 't' => 'Móviles y tablets', 'u' => 'comprar-moviles-y-tablets-de-devoluciones.html', 'd' => 'Qué aparece de verdad y qué no, sin promesas.'),
    $L2_RENTA, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Quedan pocos lotes de electrónica',
  'prioridad' => '0.9', 'frecuencia' => 'daily',
  'aviso' => true, 'avisoInteres' => 'Electrónica',
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'comprar-moviles-y-tablets-de-devoluciones.html',
  'titulo' => 'Móviles y tablets de devoluciones: qué sale de verdad',
  'desc' => 'Qué móviles y tablets aparecen realmente en los lotes de devoluciones de Amazon, qué no aparece nunca y qué comprar si buscas electrónica barata de verdad.',
  'kicker' => 'Sin promesas · Lo que sale y lo que no',
  'h1' => 'Móviles y tablets de devolución',
  'entradilla' => 'Es la pregunta que más nos llega y la vamos a contestar de frente: <b>en un lote de devoluciones no vas a encontrar el último iPhone</b>. Lo que sí sale, y a qué precio, está aquí abajo.',
  'img' => 'assets/img/lote-informatica.webp',
  'imgAlt' => 'Tablets, discos y periféricos de un lote de informática, revisados y etiquetados',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Móviles y tablets', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Lo que NO sale, y por qué', 'id' => 'no-sale', 'html' =>
'    <p>Los móviles de gama alta no llegan a los camiones de liquidación. Tienen mercado propio de segunda mano, valen demasiado para venderlos a peso y las plataformas los reacondicionan y los revenden ellas mismas. Cuando un móvil de gama alta acaba en un palé de liquidación, suele ser porque está roto.</p>
    <p>Lo mismo con consolas de última generación, televisores grandes y portátiles gaming. Si ves un anuncio de «palé con iPhone garantizados», el producto que se vende ahí es tu ilusión.</p>'),
    array('h2' => 'Lo que sí sale', 'id' => 'si-sale', 'html' =>
'    <ul>
      <li><b>Tablets de gama de entrada y media</b>, de 8 a 10 pulgadas. En nuestro lote de electrónica entran tres por caja.</li>
      <li><b>Smartwatches y pulseras de actividad</b>, de marcas conocidas de deporte y de marca blanca.</li>
      <li><b>Accesorios de móvil</b>: fundas, cargadores rápidos, baterías externas, cables. Mucho volumen y poco valor unitario.</li>
      <li><b>Algún móvil suelto</b> en el palé mixto sin clasificar, normalmente de gama de entrada y sin garantía de estado.</li>
    </ul>
    <p>Las baterías son el punto que hay que mirar. Llevan ciclos. Nosotros comprobamos que cargan y que aguantan el ciclo completo antes de que entren en un lote clasificado, pero no son baterías nuevas.</p>'),
    array('h2' => 'Qué comprar si buscabas electrónica barata', 'id' => 'alternativa', 'html' =>
'    <p>El <a href="lotes/electronica.html">lote de electrónica de consumo</a>: 42 aparatos por 549 €, con auriculares, altavoces, smartwatches y tablets. Sale a 13 € la unidad y es el que más rápido se revende.</p>
    <p>Si lo tuyo es informática, el <a href="lotes/informatica.html">lote de informática y periféricos</a> lleva dos monitores, seis teclados mecánicos, discos SSD y una impresora por 699 €. Los monitores se verifican en mesa, sin píxeles muertos, y los discos se entregan formateados.</p>'),
    array('h2' => 'Datos personales: lo que hacemos con ellos', 'id' => 'datos', 'html' =>
'    <p>Todo lo que tiene memoria se formatea antes de salir de la nave: tablets, discos, cualquier cosa que pueda llevar datos del cliente anterior. No es sólo decencia, es obligación legal de quien manipula el aparato.</p>
    <p>Si compras material con memoria a otro liquidador y llega sin formatear, fórmatealo tú antes de revenderlo. Y si llega con datos dentro, ya sabes el cuidado que le pone quien te lo vendió.</p>'),
  ),
  'lotes' => array('lote-electronica', 'lote-informatica'),
  'lotesTitulo' => 'Lo que sí tenemos',
  'lotesLead' => 'Aparatos revisados uno a uno, con el contenido publicado antes de comprar.',
  'faq' => array(
    array('p' => '¿Puedo pedir un lote sólo de móviles?', 'r' => 'No, y desconfía de quien te lo ofrezca a precio de liquidación. No existe ese material en volumen y en buen estado a precio de saldo.'),
    array('p' => '¿Las tablets vienen con cargador?', 'r' => 'La mayoría sí, con su caja original. Alguna llega sin él y va etiquetada.'),
    array('p' => '¿Están bloqueadas por cuenta?', 'r' => 'No. Lo que llega bloqueado por cuenta del usuario anterior no entra en ningún lote: es inservible y lo apartamos.'),
    array('p' => '¿Qué autonomía tienen las baterías?', 'r' => 'La de una batería con uso. Se comprueba que carga y aguanta un ciclo completo, no que esté al 100 % de su capacidad original.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Electrónica barata por lotes', 'u' => 'comprar-electronica-barata-devoluciones.html', 'd' => '42 aparatos por 549 €, a 13 € la unidad.'),
    array('k' => 'Comprar', 't' => 'Monitores y pantallas', 'u' => 'monitores-y-pantallas-de-devolucion.html', 'd' => 'Lo que sí hay en pantallas, verificado sin píxeles muertos.'),
    $L2_GRADOS, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Electrónica de verdad, a precio de lote',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true, 'avisoInteres' => 'Electrónica',
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'monitores-y-pantallas-de-devolucion.html',
  'titulo' => 'Monitores y pantallas de devolución: 26 piezas por 699 €',
  'desc' => 'Lote de informática con dos monitores de 27 pulgadas verificados sin píxeles muertos, teclados mecánicos, webcams y discos SSD. 699 € con IVA y envío.',
  'kicker' => 'Verificados en mesa · Sin píxeles muertos · 699 €',
  'h1' => 'Monitores y pantallas de devolución',
  'entradilla' => 'Un monitor devuelto por «no me cabía en la mesa» es un monitor nuevo con la caja abierta. <b>Dos monitores de 27 pulgadas y 24 piezas más por 699 €</b>, verificados uno a uno antes de precintar la caja.',
  'img' => 'assets/img/lote-informatica.webp',
  'imgAlt' => 'Monitores, teclados mecánicos, webcams y discos SSD de un lote de informática',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Monitores y pantallas', 'u' => null)),
  'datos' => array(
    array('2', 'Monitores de 27"'),
    array('26', 'Piezas por lote'),
    array('699<span class="u"> €</span>', 'Precio final'),
    array('0', 'Píxeles muertos'),
  ),
  'bloques' => array(
    array('h2' => 'Por qué hay tantos monitores devueltos', 'id' => 'por-que', 'html' =>
'    <p>Los monitores son de lo que más se devuelve en electrónica, y casi nunca por avería. Se devuelven porque no caben, porque la persona esperaba otro tamaño, porque compró dos y se quedó uno, o porque el soporte no encajaba en su mesa. Producto perfecto, caja abierta.</p>
    <p>Para la plataforma es material caro de reprocesar: pesa, es frágil y ocupa. Para un liquidador que lo verifica en mesa, es de lo mejor que pasa por la nave.</p>'),
    array('h2' => 'Cómo los verificamos', 'id' => 'verificacion', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Se enciende y se deja media hora.</b> Los defectos de panel salen con el aparato caliente, no en frío.</li>
      <li><b>Prueba de píxeles a pantalla completa</b> en rojo, verde, azul, blanco y negro. Un píxel muerto y el monitor no entra en el lote.</li>
      <li><b>Se comprueban las entradas</b>: HDMI y DisplayPort, una a una.</li>
      <li><b>Se monta el soporte</b> para confirmar que están todas las piezas y los tornillos.</li>
    </ol>
    <p>Es el material que más tiempo de revisión nos lleva, y por eso el stock de este lote siempre es corto.</p>'),
    array('h2' => 'Qué más viene en la caja', 'id' => 'contenido', 'html' =>
'    <ul>
      <li>2 monitores de 27 pulgadas, uno de ellos curvo</li>
      <li>6 teclados mecánicos y 6 ratones</li>
      <li>4 webcams Full HD</li>
      <li>4 discos SSD externos de 1 y 2 TB, entregados formateados</li>
      <li>1 router Wi-Fi 6 y 1 impresora multifunción</li>
      <li>2 soportes de monitor</li>
    </ul>
    <p>A 699 € por 26 piezas sale a 27 € la unidad. Un monitor de 27 pulgadas se revende entre 90 y 180 €, un SSD de 2 TB entre 70 y 120 €: con las dos pantallas y los cuatro discos ya vas por encima de la mitad de lo invertido.</p>'),
  ),
  'lotes' => array('lote-informatica', 'lote-electronica'),
  'lotesTitulo' => 'Informática en la nave',
  'lotesLead' => 'Precio final con IVA y envío. Los monitores viajan con embalaje reforzado.',
  'faq' => array(
    array('p' => '¿Qué marca son los monitores?', 'r' => 'Cambia con cada camión. Suelen ser marcas conocidas de gama media. Si necesitas una marca o un modelo concreto, llámanos antes de pedir y te decimos qué hay en el lote que saldría.'),
    array('p' => '¿Y si llega un monitor roto por el transporte?', 'r' => 'Se cambia o se devuelve el dinero, y el transporte lo pagamos nosotros. Haz fotos del embalaje antes de abrirlo: es lo que pide la agencia.'),
    array('p' => '¿Los SSD llevan datos del usuario anterior?', 'r' => 'No. Todo lo que tiene memoria se formatea antes de salir de la nave.'),
    array('p' => '¿Puedo comprar sólo los monitores?', 'r' => 'No, el lote se vende cerrado. Es lo que permite que la pieza salga a 27 €.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Electrónica barata por lotes', 'u' => 'comprar-electronica-barata-devoluciones.html', 'd' => 'Auriculares, altavoces y tablets a 13 € la unidad.'),
    array('k' => 'Comprar', 't' => 'Móviles y tablets', 'u' => 'comprar-moviles-y-tablets-de-devoluciones.html', 'd' => 'Qué aparece de verdad y qué no aparece nunca.'),
    $L2_GRADOS, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'De informática queda poco',
  'prioridad' => '0.8', 'frecuencia' => 'daily',
  'aviso' => true, 'avisoInteres' => 'Informática',
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'lotes-de-ropa-al-por-mayor.html',
  'titulo' => 'Lotes de ropa al por mayor: 120 prendas por 590 €',
  'desc' => 'Lotes de ropa de devolución al por mayor: 120 prendas con etiqueta, surtido de tallas, a 4,90 € la prenda. IVA y envío incluidos, entrega en 24 h.',
  'kicker' => 'Prenda con etiqueta · 4,90 € la unidad · Grado A',
  'h1' => 'Lotes de ropa al por mayor',
  'entradilla' => 'La mayor parte de lo que se devuelve en moda es por talla: prenda sin estrenar, doblada en bolsa y con la etiqueta puesta. <b>120 prendas por 590 €</b>, a 4,90 € la unidad, con IVA y envío incluidos.',
  'img' => 'assets/img/lote-moda.webp',
  'imgAlt' => 'Caja gaylord con prendas embolsadas y etiquetadas junto a cajas de zapatillas',
  'respuesta' => 'Un lote de ropa de devolución al por mayor son <b>120 prendas por 590 €</b> en Tornarem, a 4,90 € la prenda: es el precio por unidad más bajo del catálogo. Son devoluciones de talla, <b>sin estrenar, dobladas en bolsa y con la etiqueta puesta</b> (grado A). No se pueden elegir tallas ni colores: viene el surtido del camión. IVA y envío de 24 h incluidos.',
  'respuestaDatos' => array(
            array('Prendas', '120'),
            array('Precio', '590<span class="u"> €</span>'),
            array('Por prenda', '4,90<span class="u"> €</span>'),
            array('Grado', 'A'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Ropa al por mayor', 'u' => null)),
  'datos' => array(
    array('120', 'Prendas por lote'),
    array('4,90<span class="u"> €</span>', 'Por prenda'),
    array('A', 'Grado de la mercancía'),
    array('46<span class="u"> kg</span>', 'Peso de la caja'),
  ),
  'bloques' => array(
    array('h2' => 'Por qué la moda es la categoría con más margen', 'id' => 'margen', 'html' =>
'    <p>En moda online se devuelve entre el 25 y el 40 % de lo que se vende, según la prenda. Casi siempre por talla: la gente pide dos tallas para quedarse una. La prenda que vuelve está sin usar, pero ha salido del circuito y volver a meterla cuesta más de lo que vale.</p>
    <p>Para ti eso significa comprar prenda con etiqueta a 4,90 €. Una sudadera se revende entre 12 y 25 €, un par de zapatillas entre 25 y 60. Es el lote con el margen porcentual más alto del catálogo, y por eso es el que más recomendamos a quien empieza en Vinted.</p>'),
    array('h2' => 'Qué viene en la caja', 'id' => 'contenido', 'html' =>
'    <ul>
      <li>28 pares de zapatillas de la talla 36 a la 46, en su caja</li>
      <li>30 sudaderas y camisetas con etiqueta</li>
      <li>24 vaqueros y pantalones</li>
      <li>18 chaquetas y cortavientos</li>
      <li>20 mochilas, riñoneras y gorras</li>
    </ul>
    <p class="aviso-honesto"><b>Con honestidad:</b> el surtido de tallas y colores no se elige. Si necesitas tallas concretas o una temporada concreta, este lote no es para ti. Lo que sí está garantizado es el número de prendas y que vienen con etiqueta.</p>'),
    array('h2' => 'Dónde se vende y a qué ritmo', 'id' => 'donde', 'html' =>
'    <p><b>Vinted</b> es el sitio natural: el comprador paga el envío y la comisión, y el público está buscando exactamente esto. Foto sobre fondo liso, talla en el título y marca en el título. Sin eso no te encuentra nadie.</p>
    <p><b>Wallapop</b> funciona mejor para las zapatillas, sobre todo con la caja original y entrega en mano.</p>
    <p><b>Mercadillo</b> para lo que no se mueva en dos meses. A precio de saldo, pero cobras en el momento y liberas espacio, que también vale dinero.</p>
    <p>Con 120 prendas, cuenta entre uno y tres meses para colocar el lote con dedicación regular. Las primeras veinte se van en días; la cola es lo que tarda.</p>'),
  ),
  'lotes' => array('lote-moda', 'lote-belleza', 'lote-juguetes'),
  'lotesTitulo' => 'Moda y complementos en la nave',
  'lotesLead' => 'Precio final con IVA y envío. Se envía en caja gaylord por agencia.',
  'faq' => array(
    array('p' => '¿Puedo elegir tallas?', 'r' => 'No. Viene el surtido que trae el camión, con el reparto habitual de tallas del mercado: más 38-42 que extremos.'),
    array('p' => '¿Es ropa de marca?', 'r' => 'Mezclada: marcas conocidas de gran distribución y marca blanca de plataforma. No garantizamos ninguna marca concreta porque cambia con cada camión.'),
    array('p' => '¿Está usada?', 'r' => 'No. Son devoluciones de talla, sin estrenar, dobladas en bolsa y con etiqueta. Es lo que hace que este lote sea grado A.'),
    array('p' => '¿Se vende por kilos?', 'r' => 'No. Se vende por lote cerrado con el número de prendas contado, que es más justo para ti: al peso te pueden colar cuarenta camisetas iguales.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Lotes para vender en Vinted', 'u' => 'lotes-para-vender-en-vinted.html', 'd' => 'Qué comprar y cómo publicarlo para que se mueva.'),
    array('k' => 'Guía', 't' => 'Revender en Wallapop y Vinted', 'u' => 'blog/como-revender-en-wallapop-y-vinted.html', 'd' => 'Fotos, títulos, precios y cómo llevar el regateo.'),
    $L2_RENTA, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'La moda es lo que antes se agota',
  'prioridad' => '0.9', 'frecuencia' => 'daily',
  'aviso' => true, 'avisoInteres' => 'Moda',
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'saldos-y-restos-de-serie.html',
  'titulo' => 'Saldos y restos de serie: lotes con factura desde 319 €',
  'desc' => 'Saldos, restos de serie y excedentes de temporada en lotes cerrados con factura e IVA desglosado. Desde 319 € con transporte incluido en península.',
  'kicker' => 'Saldos con factura · Stock propio · Península',
  'h1' => 'Saldos y restos de serie',
  'entradilla' => 'Saldo, resto de serie, excedente, liquidación: nombres distintos para lo mismo, mercancía que salió del circuito comercial y ya no vuelve. <b>Nosotros la compramos por camiones y la vendemos por lotes con factura.</b>',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Estanterías de la nave con lotes de saldo clasificados por categoría',
  'respuesta' => '«Saldo», «resto de serie» y «excedente» no son lo mismo: la devolución es producto que el cliente devolvió, el resto de serie es lo que quedó de una producción y el excedente es lo que no se vendió a tiempo. Tornarem vende sobre todo <b>devoluciones clasificadas por grados</b>, en lotes desde <b>319 €</b>, con <b>factura e IVA desglosado</b> y transporte incluido en península.',
  'respuestaDatos' => array(
            array('Desde', '319<span class="u"> €</span>'),
            array('Factura', 'Siempre'),
            array('IVA', 'Desglosado'),
            array('Transporte', 'Incluido'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Saldos y restos de serie', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Qué es cada cosa, que no son lo mismo', 'id' => 'glosario', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Nombre</th><th>Qué es</th><th>Estado típico</th></tr></thead>
      <tbody>
        <tr><td>Devolución</td><td>Producto que el cliente devolvió</td><td>Sin estrenar o con uso leve</td></tr>
        <tr><td>Resto de serie</td><td>Lo que quedó de una producción</td><td>Nuevo, a estrenar</td></tr>
        <tr><td>Excedente de temporada</td><td>Lo que no se vendió a tiempo</td><td>Nuevo, embalaje de temporada</td></tr>
        <tr><td>Embalaje dañado</td><td>Producto correcto, caja golpeada</td><td>Nuevo, caja fea</td></tr>
        <tr><td>Saldo genérico</td><td>Mezcla de todo lo anterior</td><td>Depende: pregunta siempre</td></tr>
      </tbody>
    </table>
    <p>Cuando alguien te ofrece «saldos» sin especificar, está usando la palabra más ancha del sector. Pregunta cuál de las cinco filas es. Si no sabe contestar, no lo ha abierto.</p>'),
    array('h2' => 'Lo que manejamos nosotros', 'id' => 'nuestro', 'html' =>
'    <p>Compramos camiones de devoluciones y excedentes con factura a mayoristas identificados. Lo abrimos, lo clasificamos por categoría, le ponemos un grado y lo vendemos en lotes cerrados con el contenido publicado.</p>
    <p>El resultado son diez lotes que van de 319 € (juguetes, 64 unidades) a 1.290 € (palé mixto, unas 210 referencias). Todos con IVA y transporte incluidos en el precio, y todos con factura.</p>'),
    array('h2' => 'Por qué la factura importa más de lo que parece', 'id' => 'factura', 'html' =>
'    <p>Una factura con IVA desglosado y un CIF real es la diferencia entre un negocio y un apaño. Te sirve para tres cosas:</p>
    <ul>
      <li><b>Deducir la compra</b> si estás dado de alta, y recuperar el IVA soportado.</li>
      <li><b>Demostrar el origen</b> de la mercancía si alguien te lo pide. En segunda mano profesional se pide.</li>
      <li><b>Reclamar</b> si algo sale mal. Sin factura no hay a quién reclamar.</li>
    </ul>
    <p>Si compras saldos sin factura, el precio bajo que te están haciendo es exactamente el IVA que no van a declarar, y el riesgo lo asumes tú.</p>'),
    array('h2' => 'Volumen y recurrencia', 'id' => 'volumen', 'html' =>
'    <p>A partir de tres palés o cinco lotes se trabaja con precio cerrado y calendario. Nos dices qué categorías y con qué ritmo, apartamos al descargar el camión del jueves y facturamos mensual si compras varias veces al mes. Está contado en <a href="devoluciones-de-amazon-al-por-mayor.html">venta al por mayor</a>.</p>'),
  ),
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-moda'),
  'lotesTitulo' => 'Saldos disponibles hoy',
  'lotesLead' => 'Todos con factura, IVA desglosado y transporte incluido en península.',
  'faq' => array(
    array('p' => '¿Vendéis a particulares o sólo a empresas?', 'r' => 'A los dos. Si compras como empresa o autónomo, pon el CIF o NIF en el pedido y la factura sale a ese nombre.'),
    array('p' => '¿El saldo es producto defectuoso?', 'r' => 'No por definición. Es producto que ha dejado de ser rentable de gestionar. En los lotes clasificados lo que no funciona no entra; el palé mixto se vende sin abrir y lo avisamos.'),
    array('p' => '¿Puedo ver el stock antes de comprar?', 'r' => 'Sí. Nave 14, Polígono Mas Xirgu, Girona, de lunes a viernes de 8:00 a 18:00. Avisa antes y te lo tenemos preparado abierto.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Liquidación de stock', 'u' => 'liquidacion-de-stock-amazon.html', 'd' => 'De dónde sale el stock y qué tipos manejamos.'),
    array('k' => 'Comprar', 't' => 'Proveedor para tiendas', 'u' => 'proveedor-de-saldos-para-tiendas.html', 'd' => 'Volumen recurrente, precio cerrado y calendario de descarga.'),
    $L2_PRECIO, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Camión nuevo cada jueves',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'lotes-para-vender-en-wallapop.html',
  'titulo' => 'Lotes para vender en Wallapop: qué comprar y cuánto sacas',
  'desc' => 'Qué lotes de devoluciones funcionan mejor en Wallapop, cuánto se saca por pieza y cómo publicar para que se venda. Desde 319 € con IVA y envío.',
  'kicker' => 'Venta en mano sin comisión · Piezas de rotación alta',
  'h1' => 'Lotes para vender en Wallapop',
  'entradilla' => 'Wallapop premia dos cosas: producto fácil de entender y venta en mano. <b>Eso descarta la ropa y favorece la electrónica, la herramienta y la puericultura</b>, que es justo lo que mejor sale en un lote de devoluciones.',
  'img' => 'assets/img/lote-electronica.webp',
  'imgAlt' => 'Auriculares, altavoces y accesorios listos para fotografiar y publicar',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Lotes para Wallapop', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Qué lote comprar según lo que quieras vender', 'id' => 'cual', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Lote</th><th>Precio</th><th>Por qué va bien en Wallapop</th></tr></thead>
      <tbody>
        <tr><td>Electrónica</td><td>549 €</td><td>Piezas pequeñas, envío barato, demanda constante</td></tr>
        <tr><td>Herramientas</td><td>489 €</td><td>Taladros y atornilladores: nunca sobran</td></tr>
        <tr><td>Informática</td><td>699 €</td><td>Monitores y SSD, los que más margen dejan</td></tr>
        <tr><td>Bebé</td><td>559 €</td><td>Sillas y carritos: la gente compra usado sin reparo</td></tr>
        <tr><td>Juguetes</td><td>319 €</td><td>Entrada baja para empezar y aprender</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'La venta en mano es donde está el margen', 'id' => 'mano', 'html' =>
'    <p>En piezas de menos de 20 €, el envío se come el beneficio. La entrega en mano no tiene comisión ni coste y es lo que hace que un lote de juguetes a 5 € la pieza tenga sentido.</p>
    <p>Eso significa que tu ciudad importa. En Madrid y Barcelona se vende en mano casi todo; en una localidad pequeña hay que combinar con envío o con mercadillo. Lo contamos por provincia en <a href="donde/index.html">dónde enviamos</a>.</p>'),
    array('h2' => 'Cómo publicar para que se venda', 'id' => 'publicar', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Título con marca, modelo y qué es.</b> «Auriculares» no lo encuentra nadie; «Auriculares inalámbricos JBL Tune 510BT azules» sí.</li>
      <li><b>Cuatro fotos mínimo</b> con luz natural y fondo liso: el producto, la marca, el defecto si lo hay y todo lo que incluye junto.</li>
      <li><b>Di que es devolución</b> y por qué está a ese precio. La transparencia vende en segunda mano.</li>
      <li><b>Sal un 10-15 % por encima</b> de lo que quieres cobrar: se regatea siempre.</li>
      <li><b>Publica 10-15 al día</b>, no las 42 de golpe. Se hunden entre ellas.</li>
      <li><b>Responde en menos de una hora.</b> Es lo que más vende de todo.</li>
    </ol>'),
    array('h2' => 'Cuentas reales de un lote', 'id' => 'cuentas', 'html' =>
'    <p>Lote de electrónica, 549 €, 42 piezas. Vendiendo 32 a una media de 32 € salen 1.024 €. Menos el lote y menos unos 40 € de material de envío: <b>435 € de beneficio</b>, con diez piezas todavía en casa.</p>
    <p class="aviso-honesto"><b>Con honestidad:</b> eso son unas 25 horas entre fotografiar, publicar, responder y quedar. Salen a 17 € la hora, que está bien, pero no es dinero fácil ni pasivo.</p>'),
  ),
  'lotes' => array('lote-electronica', 'lote-herramientas', 'lote-bebe'),
  'lotesTitulo' => 'Lo que mejor rota en Wallapop',
  'lotesLead' => 'Precio final con IVA y envío incluido hasta tu puerta.',
  'faq' => array(
    array('p' => '¿Hace falta ser autónomo para vender en Wallapop?', 'r' => 'Vender lo tuyo, no. Comprar para revender de forma habitual, sí: es actividad económica. Lo explicamos en <a href="blog/necesito-ser-autonomo-para-revender.html">esta guía</a>, y lo de siempre: consúltalo con un gestor.'),
    array('p' => '¿Cuántas piezas se venden al mes?', 'r' => 'Con 60-80 anuncios activos y constancia, entre 15 y 40. Depende mucho de la categoría y de la época.'),
    array('p' => '¿Merece la pena pagar por destacar?', 'r' => 'En piezas de más de 40 €, a veces. En piezas de 10 €, nunca: te comes el margen.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Lotes para vender en Vinted', 'u' => 'lotes-para-vender-en-vinted.html', 'd' => 'Lo mismo para ropa y calzado, que es otro juego.'),
    array('k' => 'Guía', 't' => 'Dónde vender un lote', 'u' => 'blog/donde-vender-los-productos-de-un-lote.html', 'd' => 'Todos los canales, con lo que se lleva cada uno.'),
    $L2_RENTA, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Empieza con un lote y mide',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'lotes-para-vender-en-vinted.html',
  'titulo' => 'Lotes para vender en Vinted: 120 prendas por 590 €',
  'desc' => 'Qué lote comprar para vender en Vinted, cuánto se saca por prenda y cómo publicar para que rote. 120 prendas con etiqueta por 590 €, IVA y envío incluidos.',
  'kicker' => 'Textil con etiqueta · El comprador paga el envío',
  'h1' => 'Lotes para vender en Vinted',
  'entradilla' => 'Vinted tiene una ventaja que no tiene ningún otro canal: <b>el envío y la comisión los paga el comprador</b>. Lo que tú pones es la prenda y el tiempo. Por eso el lote de moda es el que mejor funciona ahí.',
  'img' => 'assets/img/lote-moda.webp',
  'imgAlt' => 'Prendas embolsadas con etiqueta, listas para fotografiar',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Lotes para Vinted', 'u' => null)),
  'datos' => array(
    array('120', 'Prendas por lote'),
    array('4,90<span class="u"> €</span>', 'Te cuesta cada una'),
    array('12-25<span class="u"> €</span>', 'Se revende cada una'),
    array('0<span class="u"> €</span>', 'De comisión para ti'),
  ),
  'bloques' => array(
    array('h2' => 'Por qué el lote de moda y no otro', 'id' => 'por-que', 'html' =>
'    <p>Vinted es de ropa, calzado y complementos. Punto. Publicar ahí una freidora de aire es perder la tarde. A cambio, para textil no hay nada mejor: el público está buscando exactamente eso y el coste de la operación no lo pagas tú.</p>
    <p>Nuestro <a href="lotes/moda.html">lote de moda y calzado</a> son 120 prendas por 590 €: sudaderas, camisetas, vaqueros, chaquetas, mochilas y 28 pares de zapatillas de la talla 36 a la 46. Devoluciones de talla, sin estrenar, en bolsa y con etiqueta.</p>'),
    array('h2' => 'Las cuentas, prenda a prenda', 'id' => 'cuentas', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Prenda</th><th>Te cuesta</th><th>Se revende</th></tr></thead>
      <tbody>
        <tr><td>Sudadera con etiqueta</td><td>4,90 €</td><td>12 - 25 €</td></tr>
        <tr><td>Vaquero</td><td>4,90 €</td><td>10 - 20 €</td></tr>
        <tr><td>Chaqueta / cortavientos</td><td>4,90 €</td><td>15 - 35 €</td></tr>
        <tr><td>Zapatillas con caja</td><td>4,90 €</td><td>25 - 60 €</td></tr>
        <tr><td>Mochila o gorra</td><td>4,90 €</td><td>8 - 18 €</td></tr>
      </tbody>
    </table>
    <p>Colocando 85 de las 120 prendas a una media de 14 € salen 1.190 €. Menos los 590 del lote: <b>600 € de beneficio</b> y 35 prendas todavía en casa para el mercadillo.</p>'),
    array('h2' => 'Cómo se publica en Vinted para que rote', 'id' => 'publicar', 'html' =>
'    <ul>
      <li><b>La talla, en el título.</b> Es el primer filtro que usa todo el mundo.</li>
      <li><b>Marca correcta en el desplegable.</b> Si la pones mal, no apareces en las búsquedas de esa marca.</li>
      <li><b>Foto sobre fondo liso y con luz natural.</b> Una sábana blanca al lado de la ventana basta.</li>
      <li><b>Cinco fotos:</b> prenda entera, etiqueta de marca, etiqueta de talla, detalle del tejido y, si hay defecto, el defecto.</li>
      <li><b>Sube en tandas de 10-15 al día</b> y usa el «subir anuncio» cuando esté disponible. La novedad manda.</li>
      <li><b>Responde rápido y acepta ofertas razonables.</b> En Vinted se negocia menos que en Wallapop, pero se negocia.</li>
    </ul>'),
    array('h2' => 'Lo que hay que decir', 'id' => 'honestidad', 'html' =>
'    <p>Di siempre que es prenda nueva procedente de devolución, con etiqueta. Es verdad, suena bien y evita la reclamación de quien esperaba otra cosa. Las valoraciones son la moneda de Vinted: una mala por no describir bien cuesta más que la venta.</p>
    <p>Y no inventes la talla. Si la etiqueta dice M y la prenda tira a pequeña, dilo. Ese comentario vende más de lo que crees.</p>'),
  ),
  'lotes' => array('lote-moda', 'lote-belleza', 'lote-juguetes'),
  'lotesTitulo' => 'Lo que se mueve en Vinted',
  'lotesLead' => 'Precio final con IVA y envío incluido hasta tu puerta.',
  'faq' => array(
    array('p' => '¿Puedo vender en Vinted comprando para revender?', 'r' => 'Vinted permite vender artículos propios; si revendes de forma habitual estás haciendo actividad económica y Hacienda lo va a tratar como tal. Habla con un gestor antes de montarlo en serio.'),
    array('p' => '¿Qué hago con las tallas que no salen?', 'r' => 'Packs de tres a precio de dos, y lo que quede a los dos meses, a un puesto de mercadillo. El stock parado ocupa sitio y el sitio cuesta.'),
    array('p' => '¿Se puede vender calzado de devolución?', 'r' => 'Sí, y es lo que más margen deja del lote. Con la caja original se paga bastante mejor.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Lotes de ropa al por mayor', 'u' => 'lotes-de-ropa-al-por-mayor.html', 'd' => '120 prendas por 590 €, con el contenido detallado.'),
    array('k' => 'Comprar', 't' => 'Lotes para Wallapop', 'u' => 'lotes-para-vender-en-wallapop.html', 'd' => 'El otro canal, con otras categorías y otras reglas.'),
    array('k' => 'Guía', 't' => 'Revender en Wallapop y Vinted', 'u' => 'blog/como-revender-en-wallapop-y-vinted.html', 'd' => 'Fotos, títulos y precios, paso a paso.'),
    $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => '120 prendas esperando foto',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true, 'avisoInteres' => 'Moda',
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'lotes-para-mercadillo.html',
  'titulo' => 'Lotes para mercadillo: qué comprar para vender en el puesto',
  'desc' => 'Qué lotes de devoluciones funcionan en un puesto de mercadillo, cuánto ocupan y cómo montar el puesto para que rote. Desde 319 € con IVA y transporte.',
  'kicker' => 'Mucha unidad · Precio de impulso · Cobro inmediato',
  'h1' => 'Lotes para mercadillo',
  'entradilla' => 'En un puesto mandan dos cosas: <b>volumen de piezas y precio de impulso</b>. Nada de esperar a que alguien te escriba: cobras en el momento, no hay devoluciones y vacías stock a un ritmo que ningún canal online iguala.',
  'img' => 'assets/img/lote-juguetes.webp',
  'imgAlt' => 'Juguetes clasificados y separados por tipo, listos para el puesto',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Lotes para mercadillo', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Los tres lotes que mejor funcionan en un puesto', 'id' => 'cual', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Lote</th><th>Unidades</th><th>Precio</th><th>Por qué funciona</th></tr></thead>
      <tbody>
        <tr><td>Juguetes</td><td>64</td><td>319 €</td><td>Precio de impulso, se vende solo en otoño</td></tr>
        <tr><td>Moda y calzado</td><td>120</td><td>590 €</td><td>El mayor número de piezas por euro</td></tr>
        <tr><td>Belleza</td><td>52</td><td>389 €</td><td>Pieza pequeña, ticket medio de 10-20 €</td></tr>
      </tbody>
    </table>
    <p>Lo que no funciona en mercadillo es la electrónica de cierto valor: nadie se gasta 60 € en un puesto sin garantía por muy bueno que sea el producto.</p>'),
    array('h2' => 'Cuánto ocupa y cómo se transporta', 'id' => 'espacio', 'html' =>
'    <p>El lote de juguetes es una caja de 80×60×60 y 27 kg: cabe en el maletero de un coche normal. El de moda es una gaylord de 120×80×80 y 46 kg: necesitas furgoneta o dos viajes.</p>
    <p>Si haces varios mercados a la semana, compensa el <a href="lotes/pale-mixto.html">palé mixto</a> y clasificar en casa: sale a 6 € la referencia y da para llenar un puesto entero. A cambio son entre 8 y 15 horas de clasificar, y necesitas dónde descargar 210 kg.</p>'),
    array('h2' => 'Cómo montar el puesto', 'id' => 'puesto', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Precios redondos y visibles.</b> 3 €, 5 €, 10 €. Un cartel grande vende más que veinte etiquetas pequeñas.</li>
      <li><b>Por categorías, no por precio.</b> La gente busca «juguetes», no «cosas de 5 €».</li>
      <li><b>Lo bueno a la altura de los ojos</b>, lo de saldo en cajas al suelo para rebuscar. Rebuscar es parte de la compra.</li>
      <li><b>Deja probar lo eléctrico.</b> Una batería externa y un enchufe cierran ventas.</li>
      <li><b>Cambio suficiente y datáfono.</b> Perder una venta de 20 € por no tener cambio pasa más de lo que parece.</li>
    </ol>'),
    array('h2' => 'Lo que hay que saber antes', 'id' => 'ojo', 'html' =>
'    <p>Vender en mercadillo exige alta en Hacienda, licencia municipal de venta ambulante y, en la mayoría de municipios, estar al corriente con la Seguridad Social. No es un trámite raro ni caro, pero no es opcional. Habla con tu ayuntamiento y con un gestor antes de comprar el primer lote.</p>'),
  ),
  'lotes' => array('lote-juguetes', 'lote-moda', 'lote-belleza'),
  'lotesTitulo' => 'Para llenar el puesto',
  'lotesLead' => 'Precio final con IVA y transporte incluido. Recogida gratis en Girona si te pilla cerca.',
  'faq' => array(
    array('p' => '¿Cuánto stock necesito para un puesto?', 'r' => 'Con dos lotes de categorías distintas llenas un puesto de tamaño medio y te sobra para reponer un par de fines de semana.'),
    array('p' => '¿Puedo recoger en la nave y ahorrarme el envío?', 'r' => 'El envío ya está incluido en el precio, así que no te ahorras dinero, pero sí tiempo: vienes a Girona con la furgoneta y te lo llevas el mismo día.'),
    array('p' => '¿Hay descuento si compro varios lotes?', 'r' => 'A partir de cinco lotes o tres palés, sí. Escríbenos con lo que necesitas y con qué frecuencia.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Palé mixto sin clasificar', 'u' => 'lotes/pale-mixto.html', 'd' => '~210 referencias a 6 € cada una, para quien tiene dónde clasificar.'),
    array('k' => 'Guía', 't' => 'Dónde vender un lote', 'u' => 'blog/donde-vender-los-productos-de-un-lote.html', 'd' => 'Todos los canales y lo que se lleva cada uno.'),
    $L2_RENTA, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Para el mercado del domingo',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'devoluciones-de-amazon-baratas.html',
  'titulo' => 'Devoluciones de Amazon baratas: desde 319 € el lote',
  'desc' => 'Las devoluciones de Amazon más baratas del catálogo, a 5 € la unidad, y por qué un precio demasiado bajo es siempre mala señal. IVA y envío incluidos.',
  'kicker' => 'Lo más barato que tenemos · 5 € la unidad',
  'h1' => 'Devoluciones de Amazon baratas',
  'entradilla' => 'El lote más barato del catálogo son <b>319 € por 64 unidades</b>: cinco euros la pieza. Aquí está lo que entra por ese precio, y también dónde está el suelo por debajo del cual un anuncio deja de ser una ganga.',
  'img' => 'assets/img/lote-juguetes.webp',
  'imgAlt' => 'Caja de juguetes de devolución clasificados por tipo',
  'respuesta' => 'El lote de devoluciones más barato de Tornarem son <b>319 € por 64 unidades</b> (5 € la pieza) y el precio por unidad más bajo es el de moda: <b>4,90 € la prenda</b>. Por debajo de unos 300 € no hay lote real con transporte incluido: el coste de origen, el porte y la manipulación marcan un suelo. Si ves un palé de electrónica por 99 €, no es una ganga, es un anzuelo.',
  'respuestaDatos' => array(
            array('Lote más barato', '319<span class="u"> €</span>'),
            array('Por unidad, desde', '4,90<span class="u"> €</span>'),
            array('Envío', '0<span class="u"> €</span>'),
            array('Suelo real', '~300<span class="u"> €</span>'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Devoluciones baratas', 'u' => null)),
  'datos' => array(
    array('319<span class="u"> €</span>', 'El lote más barato'),
    array('5<span class="u"> €</span>', 'Por unidad'),
    array('64', 'Unidades'),
    array('0<span class="u"> €</span>', 'De envío'),
  ),
  'bloques' => array(
    array('h2' => 'Lo más barato del catálogo, por orden', 'id' => 'ranking', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Lote</th><th>Precio</th><th>Unidades</th><th>Por unidad</th></tr></thead>
      <tbody>
        <tr><td>Juguetes y juegos</td><td>319 €</td><td>64</td><td>5,00 €</td></tr>
        <tr><td>Belleza y cuidado personal</td><td>389 €</td><td>52</td><td>7,50 €</td></tr>
        <tr><td>Pequeño electrodoméstico</td><td>429 €</td><td>14</td><td>30,60 €</td></tr>
        <tr><td>Herramientas</td><td>489 €</td><td>18</td><td>27,20 €</td></tr>
        <tr><td>Moda y calzado</td><td>590 €</td><td>120</td><td>4,90 €</td></tr>
        <tr><td>Palé mixto</td><td>1.290 €</td><td>~210</td><td>6,10 €</td></tr>
      </tbody>
    </table>
    <p>Fíjate en que «barato» tiene dos lecturas. El lote más barato de entrada es el de juguetes (319 €); el más barato por pieza es el de moda (4,90 €). Cuál te conviene depende de cuánto dinero puedes poner y de dónde vendes.</p>'),
    array('h2' => 'Dónde está el suelo del precio', 'id' => 'suelo', 'html' =>
'    <p>Un lote cuesta dinero en origen, cuesta transporte y cuesta manipulación. Por debajo de ciertos precios no hay negocio posible, sólo hay una de estas tres cosas:</p>
    <ol class="pasos-lista">
      <li><b>No existe el lote.</b> El objetivo es el pago por adelantado y la desaparición.</li>
      <li><b>Existe, pero es grado C:</b> material para piezas vendido como aprovechable.</li>
      <li><b>Existe y es real, pero sin transporte.</b> Al confirmar aparecen 120 € de porte.</li>
    </ol>
    <p class="nota-destacada">Regla práctica: si el precio está más de un 40 % por debajo de la tabla de arriba, pide fotos del lote concreto con la fecha del día escrita en un papel y pregunta si acepta contrarreembolso. Las dos preguntas juntas espantan a casi todo el que no tiene mercancía.</p>'),
    array('h2' => 'Barato de verdad: lo que cuesta además del lote', 'id' => 'coste-real', 'html' =>
'    <p>El precio de la etiqueta no es tu coste. Súmale el material de envío si vendes online (entre 0,80 y 1,50 € por pieza), tu tiempo de clasificar y fotografiar, y el porcentaje que no se venda.</p>
    <p>Con todo dentro, un lote de 319 € viene a costarte unos 450 € reales. Sigue siendo barato: son 64 piezas. Pero haz las cuentas con ese número, no con el de la etiqueta. Está desarrollado en <a href="blog/como-calcular-el-margen-de-un-lote.html">cómo calcular el margen de un lote</a>.</p>'),
  ),
  'lotes' => array('lote-juguetes', 'lote-belleza', 'lote-moda'),
  'lotesTitulo' => 'Lo más barato que hay hoy',
  'lotesLead' => 'Precio final con IVA y envío. Sin sorpresas al confirmar.',
  'faq' => array(
    array('p' => '¿Cuál es el pedido mínimo?', 'r' => 'Un lote, 319 € el más barato. No hay mínimo de compra ni cantidad obligatoria.'),
    array('p' => '¿Hay lotes por menos de 300 €?', 'r' => 'No, y preferimos decirlo: por debajo de ahí el transporte y la manipulación se comen el lote. Quien los vende más baratos, o no los envía o no los ha abierto.'),
    array('p' => '¿El precio incluye el IVA?', 'r' => 'Sí, y el transporte en península. El precio que ves es el que pagas, salvo el 3 % del contrarreembolso si eliges pagar al recibirlo.'),
  ),
  'relacionados' => array(
    array('k' => 'Guía', 't' => 'Cuánto cuesta un palé', 'u' => 'blog/cuanto-cuesta-un-palet-de-devoluciones.html', 'd' => 'Precios de mercado y qué encarece un palé.'),
    array('k' => 'Guía', 't' => 'Estafas y cómo detectarlas', 'u' => 'blog/estafas-con-devoluciones-de-amazon.html', 'd' => 'Las cinco que se repiten y las señales que las delatan.'),
    array('k' => 'Comprar', 't' => 'Empezar con 500 €', 'u' => 'empezar-a-revender-con-500-euros.html', 'd' => 'El plan completo con el dinero contado.'),
    $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Desde 319 €, envío incluido',
  'prioridad' => '0.8', 'frecuencia' => 'daily',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'outlet-de-liquidacion.html',
  'titulo' => 'Outlet de liquidación: lotes de stock con factura',
  'desc' => 'Outlet de liquidación por lotes: devoluciones y excedentes clasificados por grados, con factura e IVA. Desde 319 €, transporte incluido en península.',
  'kicker' => 'Outlet por lotes · No por unidades · Con factura',
  'h1' => 'Outlet de liquidación',
  'entradilla' => 'Un outlet normal te vende una pieza con descuento. Esto es el paso anterior: <b>el lote entero al precio al que se abastece un outlet</b>. Más barato por unidad, y a cambio te llevas la caja completa.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Pasillo de la nave con lotes de liquidación clasificados en estanterías',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Outlet de liquidación', 'u' => null)),
  'bloques' => array(
    array('h2' => 'En qué se diferencia de un outlet', 'id' => 'diferencia', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Outlet de tienda</th><th>Esto</th></tr></thead>
      <tbody>
        <tr><td>Se vende</td><td>Por unidades</td><td>Por lotes cerrados</td></tr>
        <tr><td>Eliges</td><td>La pieza concreta</td><td>La categoría y el grado</td></tr>
        <tr><td>Descuento</td><td>30 - 60 % sobre PVP</td><td>70 - 85 % sobre PVP estimado</td></tr>
        <tr><td>Para quién</td><td>Consumidor final</td><td>Quien revende, tiendas, grupos</td></tr>
      </tbody>
    </table>
    <p>Por eso un outlet compra aquí y vende allí. El margen del outlet es exactamente la diferencia entre las dos filas del descuento.</p>'),
    array('h2' => 'Los grados, que es lo que de verdad marca el precio', 'id' => 'grados', 'html' =>
'    <ul>
      <li><b>Grado A.</b> Sin usar. Devolución de talla o de «no era lo que pensaba». Es lo que se revende como nuevo con caja abierta.</li>
      <li><b>Grado B.</b> Marcas de uso leves o caja golpeada. Funciona. Es la mayor parte del mercado.</li>
      <li><b>Grado C.</b> Para piezas. No lo vendemos en lotes clasificados.</li>
      <li><b>Sin clasificar.</b> No es un grado: es que nadie lo ha abierto. Se vende por su nombre y a precio de riesgo.</li>
    </ul>
    <p>No existe una norma oficial de grados: cada liquidador usa su escala. Lo que sí puedes exigir es que te expliquen qué entienden por cada letra. Lo desarrollamos en <a href="blog/grados-a-b-c-devoluciones.html">grados A, B y C</a>.</p>'),
    array('h2' => 'Cómo se compra', 'id' => 'como', 'html' =>
'    <p>Eliges el lote, pagas contrarreembolso o con tarjeta y lo recibes en 24 horas en península. No hace falta cuenta, ni registro, ni cantidad mínima más allá de un lote. Factura con IVA desglosado siempre, y a nombre de tu empresa si pones el CIF.</p>
    <p>Si compras a volumen, a partir de tres palés o cinco lotes se trabaja con precio cerrado y con reserva del camión del jueves antes de que salga a la web.</p>'),
  ),
  'lotes' => array('lote-belleza', 'lote-hogar-cocina', 'lote-moda'),
  'lotesTitulo' => 'Outlet disponible hoy',
  'lotesLead' => 'Precio final con IVA y transporte. El stock se actualiza solo.',
  'faq' => array(
    array('p' => '¿Puedo comprar una sola pieza?', 'r' => 'No. La unidad de venta es el lote, y es justo lo que permite el precio por unidad. Para piezas sueltas, un outlet normal.'),
    array('p' => '¿Qué grado tiene lo que vendéis?', 'r' => 'A y A/B en los lotes clasificados, B donde lo decimos en la ficha. Grado C no lo vendemos. El palé mixto va sin clasificar y lo avisamos.'),
    array('p' => '¿Tenéis tienda física?', 'r' => 'Tenemos nave, no tienda: Nave 14, Polígono Mas Xirgu, Girona. Puedes venir a ver lotes abiertos y recoger, de lunes a viernes de 8:00 a 18:00.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Saldos y restos de serie', 'u' => 'saldos-y-restos-de-serie.html', 'd' => 'Qué es cada cosa y por qué la factura importa.'),
    array('k' => 'Comprar', 't' => 'Liquidación de stock', 'u' => 'liquidacion-de-stock-amazon.html', 'd' => 'De dónde sale el stock y qué tipos hay.'),
    $L2_GRADOS, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Precio de origen, no de outlet',
  'prioridad' => '0.7', 'frecuencia' => 'weekly',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'lotes-de-juguetes-al-por-mayor.html',
  'titulo' => 'Lotes de juguetes al por mayor: 64 unidades por 319 €',
  'desc' => 'Lotes de juguetes de devolución al por mayor: construcción, peluches, juegos de mesa y teledirigidos. 64 unidades por 319 €, a 5 € la pieza, con IVA y envío.',
  'kicker' => 'El lote de entrada · 5 € la pieza · Grado A/B',
  'h1' => 'Lotes de juguetes al por mayor',
  'entradilla' => 'Es el lote por el que empieza casi todo el mundo, y con razón: <b>64 juguetes por 319 €</b>, cinco euros la pieza, revisados pieza a pieza y con el contenido publicado antes de comprar.',
  'img' => 'assets/img/lote-juguetes.webp',
  'imgAlt' => 'Caja gaylord llena de juguetes: construcción, peluches, juegos de mesa y teledirigidos',
  'respuesta' => 'Un lote de juguetes de devolución son <b>64 unidades por 319 €</b>, a 5 € la pieza: construcción, peluches, juegos de mesa, teledirigidos, muñecas y puzles. Es el lote con la entrada más baja del catálogo y por el que empieza casi todo el mundo. Los sets de construcción se cuentan pieza a pieza antes de entrar. <b>De septiembre a diciembre se agota</b>: si compras para campaña, hazlo en verano.',
  'respuestaDatos' => array(
            array('Juguetes', '64'),
            array('Precio', '319<span class="u"> €</span>'),
            array('Por pieza', '5<span class="u"> €</span>'),
            array('Grado', 'A/B'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Juguetes al por mayor', 'u' => null)),
  'datos' => array(
    array('64', 'Juguetes por lote'),
    array('5<span class="u"> €</span>', 'Por pieza'),
    array('319<span class="u"> €</span>', 'Precio final'),
    array('−<span>81</span><span class="u"> %</span>', 'Sobre el PVP'),
  ),
  'bloques' => array(
    array('h2' => 'Qué entra en el lote', 'id' => 'contenido', 'html' =>
'    <ul>
      <li>14 sets de construcción por piezas</li>
      <li>12 peluches y muñecos blandos</li>
      <li>10 juegos de mesa familiares</li>
      <li>6 coches y drones teledirigidos</li>
      <li>8 muñecas y figuras con accesorios</li>
      <li>14 puzles de 500 a 1.500 piezas</li>
    </ul>
    <p class="nota-destacada">Los sets de construcción se cuentan pieza a pieza antes de entrar. Si a uno le falta algo, sale etiquetado. Aun así, revisa antes de vender: un set incompleto vendido como completo es una reclamación segura.</p>'),
    array('h2' => 'La estacionalidad manda', 'id' => 'temporada', 'html' =>
'    <p>El juguete tiene el calendario más marcado de todo el sector. De septiembre a diciembre se vende solo: la gente compra para Reyes con tres meses de antelación y el precio aguanta. De enero a mayo cuesta más y hay que bajar expectativas.</p>
    <p>Si vas a comprar para la campaña, compra en septiembre u octubre. En noviembre ya está todo el mundo comprando y nuestro stock de juguetes es el primero que se agota.</p>'),
    array('h2' => 'Dónde se coloca', 'id' => 'donde', 'html' =>
'    <p><b>Mercadillo y ferias del juguete de segunda mano.</b> Precio de impulso, cobro inmediato, sin devoluciones. Es donde más rápido rota.</p>
    <p><b>Wallapop, en mano.</b> Los juegos de mesa y los sets de construcción se venden bien. Los coches teledirigidos, de uno en uno y con las pilas puestas para que el comprador lo vea moverse.</p>
    <p><b>Peluches, por packs.</b> Sueltos valen poco y ocupan tiempo; de tres en tres se van.</p>
    <p><b>Tiendas y papelerías de barrio.</b> El canal más rápido para vaciar el lote de golpe, aunque a menos por pieza.</p>'),
    array('h2' => 'Las cuentas', 'id' => 'cuentas', 'html' =>
'    <p>319 € por 64 piezas. Vendiendo 50 a una media de 14 € salen 700 €; diez más en packs a 5 €, otros 50 €. Menos el lote y menos unos 60 € de material de envío: <b>371 € de beneficio</b> con cuatro piezas sin colocar.</p>
    <p class="aviso-honesto"><b>Con honestidad:</b> eso son unas 22 horas de trabajo entre clasificar, fotografiar, publicar, responder y empaquetar. Salen a 16,80 € la hora. Está bien, pero es trabajo, no un ingreso pasivo.</p>'),
  ),
  'lotes' => array('lote-juguetes', 'lote-bebe', 'lote-moda'),
  'lotesTitulo' => 'Juguetes y familia',
  'lotesLead' => 'Precio final con IVA y envío de 24 h incluido.',
  'faq' => array(
    array('p' => '¿Los juguetes cumplen la normativa CE?', 'r' => 'Son productos que estaban a la venta en el mercado europeo, con su marcado. Lo que llega sin marcado o sin identificación de fabricante no entra en el lote.'),
    array('p' => '¿Vienen en su caja?', 'r' => 'La mayoría sí, porque son devoluciones. Alguna caja viene golpeada o abierta, y va indicado.'),
    array('p' => '¿Hay juguetes de marcas conocidas?', 'r' => 'Mezclados con marca blanca. No garantizamos marcas concretas porque cambian con cada camión.'),
    array('p' => '¿Puedo pedir varios lotes para la campaña?', 'r' => 'Sí, y a partir de cinco hay precio cerrado. Para la campaña de Navidad, pídelo en septiembre: en noviembre volamos.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Lotes para mercadillo', 'u' => 'lotes-para-mercadillo.html', 'd' => 'Qué comprar y cómo montar el puesto.'),
    array('k' => 'Comprar', 't' => 'Bebé y puericultura', 'u' => 'lotes/bebe.html', 'd' => 'Sillas de coche, carrito y tronas revisadas una a una.'),
    $L2_RENTA, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'El lote con el que empieza todo el mundo',
  'prioridad' => '0.9', 'frecuencia' => 'daily',
  'aviso' => true, 'avisoInteres' => 'Juguetes',
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'empezar-a-revender-con-500-euros.html',
  'titulo' => 'Empezar a revender devoluciones con 500 €: el plan',
  'desc' => 'Plan completo para empezar a revender devoluciones con 500 €: qué lote comprar, qué material necesitas, cuánto tardas en recuperarlo y qué esperar de verdad.',
  'kicker' => 'Con el dinero contado · Sin humo',
  'h1' => 'Empezar a revender con 500 €',
  'entradilla' => 'Quinientos euros dan para empezar bien, si se reparten con cabeza. <b>Aquí está el reparto, el calendario y lo que se puede esperar de verdad</b>, incluidos los meses en los que no vas a ganar nada.',
  'img' => 'assets/img/clasificacion.webp',
  'imgAlt' => 'Mesa de clasificación con productos separados por categorías y etiquetas',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Empezar con 500 €', 'u' => null)),
  'bloques' => array(
    array('h2' => 'El reparto de los 500 €', 'id' => 'reparto', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Concepto</th><th>Importe</th><th>Por qué</th></tr></thead>
      <tbody>
        <tr><td>Lote de juguetes</td><td>319 €</td><td>64 piezas, entrada baja, se vende solo</td></tr>
        <tr><td>Material de envío</td><td>60 €</td><td>Cajas de tres tamaños, burbuja, precinto, etiquetas</td></tr>
        <tr><td>Báscula y metro</td><td>25 €</td><td>Calcular el envío mal se come una venta entera</td></tr>
        <tr><td>Reserva</td><td>96 €</td><td>Para NO tener que malvender con prisa</td></tr>
      </tbody>
    </table>
    <p>La cuarta fila es la que más gente se salta y la que más caro sale. Sin reserva, la primera semana floja te empuja a bajar precios, y bajar precios el primer mes es lo que mata el margen.</p>'),
    array('h2' => 'Por qué juguetes y no otra cosa', 'id' => 'por-que', 'html' =>
'    <p>Porque son 64 piezas por 319 €: te permite equivocarte muchas veces mientras aprendes. Porque no hay que probar nada eléctrico. Porque las fotos son fáciles. Y porque el público es amplio: todo el mundo entiende lo que es un juego de mesa.</p>
    <p>Lo que NO comprar con 500 €: un palé mixto. Suena mejor por el precio por referencia, pero son 210 piezas que clasificar, 210 kg que descargar y entre 8 y 15 horas antes de poder vender la primera. Es el segundo paso, no el primero.</p>'),
    array('h2' => 'El calendario realista', 'id' => 'calendario', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Días 1-2.</b> Llega la caja. Cuentas, clasificas en tres montones (vende solo / necesita trabajo / no sirve) y fotografías en tandas.</li>
      <li><b>Semana 1.</b> Publicas 10-15 al día. Caen las primeras tres o cuatro ventas, siempre las piezas buenas.</li>
      <li><b>Semanas 2-4.</b> El grueso. Aquí se decide el resultado: responder rápido y no bajar precios.</li>
      <li><b>Mes 2.</b> Lo que no se ha movido, en packs. Revisas foto y título de lo que no tiene ni una visita.</li>
      <li><b>Mes 3.</b> El resto, a mercadillo o a una tienda, aunque sea a precio de coste. El stock parado ocupa sitio.</li>
    </ol>
    <p>Al final del mes 3, suma lo cobrado, resta el lote y el material, divide por las horas. Ese número es tu punto de partida real, y la segunda compra va a ir mejor.</p>'),
    array('h2' => 'Lo que no te va a pasar', 'id' => 'expectativas', 'html' =>
'    <p class="aviso-honesto">No vas a duplicar los 500 € en dos semanas. No vas a vender el lote entero. No vas a encontrar un iPhone dentro. Y no vas a poder dejar tu trabajo el mes que viene.</p>
    <p>Lo que sí suele pasar, con constancia: recuperar la inversión en tres o cuatro semanas y acabar el tercer mes con entre un 40 % y un 120 % sobre lo puesto, con tu tiempo ya pagado. Eso es un negocio decente. Cualquiera que te prometa más te está vendiendo otra cosa.</p>'),
  ),
  'lotes' => array('lote-juguetes', 'lote-belleza', 'lote-moda'),
  'lotesTitulo' => 'Lotes para empezar',
  'lotesLead' => 'Precio final con IVA y envío. Sin mínimo de compra más allá de un lote.',
  'faq' => array(
    array('p' => '¿Puedo empezar con menos de 500 €?', 'r' => 'Con 380-400 € llegas: el lote de 319 € más lo básico de envío. Lo que pierdes es la reserva, y la reserva es lo que te evita malvender.'),
    array('p' => '¿Tengo que darme de alta antes de la primera compra?', 'r' => 'Comprar puede cualquier particular. Revender de forma habitual es actividad económica y ahí sí. Está explicado en <a href="blog/necesito-ser-autonomo-para-revender.html">esta guía</a>; consúltalo con un gestor.'),
    array('p' => '¿Cuánto tiempo hay que dedicarle?', 'r' => 'De 10 a 15 horas semanales el primer mes. Con menos, el lote se eterniza y las cuentas dejan de salir.'),
  ),
  'relacionados' => array(
    array('k' => 'Guía', 't' => 'Tu primera compra, paso a paso', 'u' => 'blog/primera-compra-lista-de-comprobacion.html', 'd' => 'Lista para imprimir: antes de pedir, al recibir y las dos primeras semanas.'),
    array('k' => 'Guía', 't' => 'Calcular el margen de un lote', 'u' => 'blog/como-calcular-el-margen-de-un-lote.html', 'd' => 'La fórmula y el ejemplo hecho.'),
    $L2_RENTA, $L2_COMPRAR,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'El primer lote, hoy',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
);


/* ---------------------------------------------------------------- */
$PAGINAS[] = array(
  'ruta' => 'proveedor-de-saldos-para-tiendas.html',
  'titulo' => 'Proveedor de saldos para tiendas: volumen con factura',
  'desc' => 'Proveedor de saldos y liquidaciones para tiendas: varios palés al mes, precio cerrado, factura recapitulativa y calendario de descarga. Nave propia en Girona.',
  'kicker' => 'B2B · Precio cerrado · Factura mensual',
  'h1' => 'Proveedor de saldos para tiendas',
  'entradilla' => 'Si tienes tienda, lo que necesitas no es un lote: es <b>saber qué llega, cuándo llega y a qué precio</b>, todas las semanas. Eso se cierra por teléfono y se pone por escrito.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Muelle de la nave con palés preparados para cargar en ruta',
  'respuesta' => 'Tornarem abastece a tiendas con <b>lotes y palés de devoluciones</b> desde su nave de Girona, con un camión de 24 palés por semana. Para precio cerrado hacen falta <b>tres palés o cinco lotes</b> por pedido, o compra recurrente mensual; a partir de ahí se reserva categoría al descargar y se factura mensualmente. Comprando a un 20 % del PVP y vendiendo a un 40-60 %, el margen bruto en tienda ronda el 50-65 %.',
  'respuestaDatos' => array(
            array('Umbral', '3 palés'),
            array('Entrega', '48<span class="u"> h</span>'),
            array('Margen típico', '50-65<span class="u"> %</span>'),
            array('Factura', 'Recapitulativa'),
  ),
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Proveedor para tiendas', 'u' => null)),
  'datos' => array(
    array('1', 'Camión por semana'),
    array('24', 'Palés por camión'),
    array('3', 'Palés para precio cerrado'),
    array('48<span class="u"> h</span>', 'Entrega paletizada'),
  ),
  'bloques' => array(
    array('h2' => 'Para qué tipo de tienda funciona', 'id' => 'para-quien', 'html' =>
'    <ul>
      <li><b>Bazares y tiendas de todo a precio único.</b> Volumen, rotación alta y ticket bajo: el palé mixto es su formato.</li>
      <li><b>Tiendas de menaje y regalo.</b> Hogar y cocina, belleza, pequeño electrodoméstico.</li>
      <li><b>Ferreterías y suministro.</b> Herramienta a batería, que es lo que nunca sobra.</li>
      <li><b>Jugueterías y papelerías.</b> Campaña de septiembre a diciembre, reservada en verano.</li>
      <li><b>Tiendas de segunda mano y compraventa.</b> Categorías mezcladas y reposición constante.</li>
    </ul>
    <p>Si compras menos de un palé al mes, te sale mejor el catálogo normal de la web: el precio ya es bueno y no tienes que comprometerte a nada.</p>'),
    array('h2' => 'Cómo se cierra un acuerdo', 'id' => 'como', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Nos dices categorías y ritmo.</b> Por ejemplo: dos palés de hogar y uno de electrónica cada quince días.</li>
      <li><b>Te damos precio cerrado por palé</b>, con el porte incluido. Si una semana el camión no trae tu categoría, te lo decimos antes, no después.</li>
      <li><b>Reservamos al descargar.</b> El jueves entra el tráiler y lo tuyo se aparta antes de publicarse en la web.</li>
      <li><b>Facturamos.</b> Con IVA desglosado, a nombre de tu empresa, y recapitulativa mensual si compras varias veces al mes.</li>
    </ol>'),
    array('h2' => 'Lo que no hacemos', 'id' => 'no', 'html' =>
'    <ul>
      <li><b>No garantizamos marcas concretas.</b> Categoría, grado y volumen sí. La marca depende del camión.</li>
      <li><b>No vendemos por unidades sueltas.</b> La unidad mínima es el lote.</li>
      <li><b>No damos exclusividad territorial.</b> Vendemos a quien compre, y eso incluye a quien vende cerca de ti.</li>
      <li><b>No exportamos fuera de la UE.</b> Península y Baleares con normalidad; Canarias con presupuesto y trámites aparte.</li>
      <li><b>No hay pago aplazado en la primera compra.</b> A partir de la tercera y con documentación, se habla.</li>
    </ul>'),
    array('h2' => 'Hablarlo', 'id' => 'contacto', 'html' =>
'    <p>Lo más rápido es el teléfono: <a href="tel:+34900000000">900 000 000</a>, de lunes a viernes de 8:00 a 18:00. También por <a href="https://wa.me/34600000000" target="_blank" rel="noopener">WhatsApp</a> o en <a href="mailto:pedidos@tornarem.cat">pedidos@tornarem.cat</a>.</p>
    <p>Si escribes, dinos: categorías, cuántos palés, con qué frecuencia, provincia de entrega y si tienes muelle o necesitas plataforma elevadora. Con eso te damos precio el mismo día.</p>'),
  ),
  'lotes' => array('lote-pale-mixto', 'lote-hogar-cocina', 'lote-herramientas'),
  'lotesTitulo' => 'Lo que más se pide a volumen',
  'lotesLead' => 'Estos son precios de unidad suelta. A partir de tres palés, hablamos.',
  'faq' => array(
    array('p' => '¿Cuál es el volumen mínimo para precio de mayorista?', 'r' => 'Tres palés o cinco lotes en un mismo pedido, o compromiso de compra recurrente mensual.'),
    array('p' => '¿Emitís factura recapitulativa?', 'r' => 'Sí, mensual si compras varias veces al mes. Dilo al cerrar el acuerdo y se hace así desde el principio.'),
    array('p' => '¿Podéis reservar una categoría del próximo camión?', 'r' => 'Sí, con acuerdo previo y señal. Es lo habitual con clientes recurrentes: se aparta al descargar.'),
    array('p' => '¿Hacéis dropshipping?', 'r' => 'No. Vendemos mercancía física que sale de nuestra nave; no enviamos en nombre de terceros.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Venta al por mayor', 'u' => 'devoluciones-de-amazon-al-por-mayor.html', 'd' => 'Cómo trabajamos el volumen recurrente.'),
    array('k' => 'Comprar', 't' => 'Saldos y restos de serie', 'u' => 'saldos-y-restos-de-serie.html', 'd' => 'Qué es cada cosa y por qué la factura importa.'),
    $L2_PALES, $L2_PRECIO,
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Cuéntanos qué necesitas reponer',
  'ctaTexto' => 'Con las categorías, el ritmo y la provincia te damos precio cerrado el mismo día.',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
);
