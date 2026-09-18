<?php
/* =============================================================
   Una ficha por lote del catálogo: /lotes/electronica.html, etc.

   Es el hueco más grande que tenía la web: los diez lotes vivían
   dentro de la portada, sin dirección propia. Una página no puede
   salir en Google para «comprar lote de devoluciones de juguetes»
   si esa página no existe.

   Lo que cambia de un lote a otro (a quién le sirve, dónde se
   revende, qué margen sale) se escribe aquí. Lo que ya está en el
   catálogo (precio, stock, contenido, ref) se lee de allí y no se
   repite, para que no puedan contradecirse.
   ============================================================= */

$EXTRA = array(

'lote-electronica' => array(
  'busqueda' => 'lote de devoluciones de electrónica',
  'paraQuien' => 'Es el lote que más rápido se vende y el que más gente pregunta. Sirve para puestos de mercadillo, tiendas de barrio de informática y telefonía, y para quien revende en Wallapop o Vinted con envío: son piezas pequeñas, de enviar por 4 € y que se buscan solas.',
  'dondeRevender' => 'Los auriculares y los altavoces se colocan en horas en Wallapop. Los smartwatches y las tablets piden foto buena y descripción honesta, pero se pagan bien. Los cables y cargadores no se venden sueltos: se hacen packs de tres o cuatro y se venden como lote.',
  'margen' => 'Con 549 € puestos y 42 unidades, cada pieza te sale a 13 €. Un auricular inalámbrico de marca conocida se revende entre 25 y 60 €; una tablet, entre 60 y 120 €. Aunque falle el 15 % y regales los cables, el lote se paga con menos de la mitad de las unidades.',
  'ojo' => 'Las baterías de las tablets y los smartwatches llevan uso. Se comprueba que cargan y que aguantan el ciclo, pero no son baterías nuevas: dilo cuando revendas y te ahorras la devolución.',
),

'lote-hogar-cocina' => array(
  'busqueda' => 'lote de electrodomésticos devueltos',
  'paraQuien' => 'Para tiendas de menaje, bazares y gente que vende en ferias y mercados de fin de semana. También para quien monta pisos de alquiler turístico y necesita equipar cocinas sin pagar precio de tienda.',
  'dondeRevender' => 'Las freidoras de aire son el producto estrella: se venden antes de acabar de subir la foto. Las cafeteras de cápsulas piden que digas qué cápsula usan. El robot aspirador vale más si lo enseñas funcionando en un vídeo de diez segundos.',
  'margen' => '429 € por 14 aparatos son 31 € por unidad. Una freidora de aire de 5 litros se revende entre 45 y 80 €, una cafetera entre 30 y 60 €, el robot aspirador entre 90 y 150 €. Con cinco o seis unidades recuperas lo puesto.',
  'ojo' => 'Grado B: hay cajas abiertas, alguna raya y algún aparato al que le falta un accesorio menor (una cuchara medidora, un filtro de repuesto). Todos encienden y funcionan, pero no los vendas como precintados.',
),

'lote-juguetes' => array(
  'busqueda' => 'lote de juguetes devueltos',
  'paraQuien' => 'Jugueterías pequeñas, papelerías, tiendas de regalo y puestos de mercadillo. En noviembre y diciembre es el lote que se agota primero: la gente compra para Reyes con tres meses de antelación.',
  'dondeRevender' => 'Los sets de construcción y los juegos de mesa se venden bien en Wallapop y en ferias del juguete de segunda mano. Los peluches, por packs. Los coches teledirigidos, de uno en uno y con las pilas puestas para que el comprador lo vea moverse.',
  'margen' => '319 € por 64 unidades salen a 5 € la pieza. Un juego de mesa familiar se revende entre 12 y 30 €, un set de construcción entre 15 y 45 €. Es el lote con la barrera de entrada más baja y el que mejor funciona para empezar.',
  'ojo' => 'Los sets de construcción se cuentan pieza a pieza antes de entrar. Si a uno le falta algo, va etiquetado. Aun así, revisa antes de vender: un set incompleto vendido como completo es una reclamación segura.',
),

'lote-herramientas' => array(
  'busqueda' => 'lote de herramientas devueltas',
  'paraQuien' => 'Ferreterías, tiendas de suministro industrial y profesionales de la reforma que quieren tener repuesto sin pagar precio de catálogo. También es el lote favorito de quien vende en mercados de herramienta los domingos.',
  'dondeRevender' => 'Los taladros y atornilladores a batería son el producto que nunca sobra. Se venden en Wallapop, en Milanuncios y en grupos locales de reformas. Los maletines de herramienta manual se colocan enteros, sin desmontar.',
  'margen' => '489 € por 18 herramientas son 27 € por unidad. Un taladro percutor a batería con cargador se revende entre 55 y 110 €. Con cinco taladros ya has recuperado la compra y te quedan trece herramientas.',
  'ojo' => 'Las baterías se prueban una a una: cargan y aguantan el ciclo completo. Es lo primero que pregunta el comprador y lo primero que comprobamos nosotros.',
),

'lote-moda' => array(
  'busqueda' => 'lote de ropa devuelta',
  'paraQuien' => 'Tiendas de ropa multimarca, puestos de mercadillo textil y quien vende en Vinted a volumen. Es el lote con más unidades por euro: 120 prendas por 590 €.',
  'dondeRevender' => 'Vinted es el sitio natural: prenda con etiqueta, foto sobre fondo liso y talla en el título. Las zapatillas se venden mejor en Wallapop con la caja. Lo que no se mueva en dos meses, a kilo en un puesto de mercadillo.',
  'margen' => '590 € por 120 prendas son 4,90 € por prenda. Una sudadera con etiqueta se revende entre 12 y 25 €, un par de zapatillas entre 25 y 60 €. Es el lote con el margen porcentual más alto del catálogo.',
  'ojo' => 'Son devoluciones de talla: prenda sin usar, doblada en bolsa y con etiqueta. Lo que no puedes elegir es el surtido. Si necesitas tallas concretas, este lote no es para ti.',
),

'lote-informatica' => array(
  'busqueda' => 'lote de informática devuelta',
  'paraQuien' => 'Tiendas de informática, servicios técnicos y gente que monta puestos de trabajo para oficinas pequeñas. También para quien revende en foros de PC y en grupos de segunda mano especializados.',
  'dondeRevender' => 'Los monitores son lo que más margen deja y lo que más rápido se va, sobre todo el curvo. Los teclados mecánicos tienen su propio público que paga bien. Los SSD se venden en horas si dices la marca y la capacidad.',
  'margen' => '699 € por 26 piezas son 27 € por unidad. Un monitor de 27 pulgadas se revende entre 90 y 180 €, un SSD de 2 TB entre 70 y 120 €, un teclado mecánico entre 35 y 80 €. Con los dos monitores y los cuatro discos ya vas por encima de la mitad.',
  'ojo' => 'Los monitores se verifican en mesa: sin píxeles muertos. Los SSD se entregan formateados, sin datos del cliente anterior. Es el lote que más tiempo de revisión nos lleva y por eso el stock es corto.',
),

'lote-deporte' => array(
  'busqueda' => 'palé de material deportivo devuelto',
  'paraQuien' => 'Tiendas de deporte, gimnasios pequeños que montan sala y quien vende material de fitness en enero, que es cuando se dispara. Viaja en palé, así que necesitas sitio donde descargarlo.',
  'dondeRevender' => 'Las mancuernas ajustables y las kettlebells se venden solas en enero y en septiembre. La bicicleta estática y el patinete piden foto funcionando. Las esterillas y las bandas, por packs de tres.',
  'margen' => '519 € por 22 piezas salen a 23 € por unidad. Una bicicleta estática plegable se revende entre 90 y 170 €, un patinete eléctrico entre 120 y 250 €, un juego de mancuernas ajustables entre 40 y 90 €. Las dos piezas grandes ya cubren medio palé.',
  'ojo' => 'Grado B honesto: hay marcas de uso y embalajes abiertos. La batería del patinete está probada, pero es una batería con ciclos. Y pesa 96 kg: mira dónde lo vas a descargar antes de pedirlo.',
),

'lote-bebe' => array(
  'busqueda' => 'lote de puericultura devuelta',
  'paraQuien' => 'Tiendas de puericultura, bancos de material infantil y quien revende artículos de bebé, que es un mercado donde la gente compra de segunda mano sin ningún reparo si el producto está revisado.',
  'dondeRevender' => 'Las sillas de coche y los carritos son lo que más se busca. Los vigilabebés y las tronas se venden en grupos locales de padres. El truco es enseñar la etiqueta de homologación en la foto: eso es lo que mira el comprador.',
  'margen' => '559 € por 15 artículos son 37 € por unidad. Una silla de coche homologada se revende entre 80 y 200 €, un carrito plegable entre 100 y 220 €, una trona evolutiva entre 50 y 110 €. Con las dos sillas y el carrito ya lo has pagado.',
  'ojo' => 'Las sillas de coche se revisan una a una: sin golpes, con todas las piezas y con la etiqueta de homologación legible. La que no pasa, no sale de la nave. Es el único lote donde tiramos producto en lugar de bajarlo de grado.',
),

'lote-belleza' => array(
  'busqueda' => 'lote de belleza y cuidado personal devuelto',
  'paraQuien' => 'Peluquerías y centros de estética que quieren aparato de reserva, perfumerías pequeñas, bazares y quien revende en Wallapop: son piezas ligeras, fáciles de enviar y muy buscadas.',
  'dondeRevender' => 'Los secadores profesionales y las planchas son lo que más margen deja. Las depiladoras de luz pulsada se pagan muy bien si enseñas que el cabezal está precintado. Los cepillos eléctricos se venden con sus cabezales de repuesto.',
  'margen' => '389 € por 52 unidades son 7,50 € por pieza. Un secador iónico profesional se revende entre 30 y 70 €, una depiladora IPL entre 60 y 130 €, una plancha de pelo entre 20 y 45 €. Las seis depiladoras ya cubren el lote entero.',
  'ojo' => 'Higiene: aquí sólo entran unidades sin usar o con el cabezal precintado. Lo que ha tocado piel o pelo no entra, aunque funcione. Es la única categoría con esa regla y por eso el lote es más corto de lo que podría ser.',
),

'lote-pale-mixto' => array(
  'busqueda' => 'palé de devoluciones de Amazon sin clasificar',
  'paraQuien' => 'Para quien ya revende y quiere volumen al precio más bajo posible. No es un lote para empezar: es el lote de quien tiene sitio donde clasificar, tiempo para hacerlo y estómago para asumir que parte de lo que abra no sirva.',
  'dondeRevender' => 'Un palé mixto se clasifica primero y se vende después por categorías: lo que vale, a Wallapop y Vinted; lo mediano, a puesto de mercadillo; lo que no funciona, a piezas o a punto limpio. Contar con que un 15-20 % no se vende es parte del cálculo.',
  'margen' => '1.290 € por unas 210 referencias son 6 € por pieza, con un PVP de catálogo que ronda los 6.500 €. Es el precio por unidad más bajo del catálogo. A cambio, el trabajo de clasificar lo pones tú.',
  'ojo' => 'Se vende cerrado, sin abrir y sin revisar, y no admite devolución. Puede haber unidades defectuosas y las hay: por eso el precio está por debajo del 20 % del PVP. Te mandamos el manifiesto de referencias por correo tras el pedido, pero el contenido exacto no se garantiza pieza a pieza.',
),

);

foreach ($CAT['lotes'] as $l) {
    $id = $l['id'];
    $x = isset($EXTRA[$id]) ? $EXTRA[$id] : array();
    $slug = slug_de_lote($id);
    $esPale = preg_match('/pal[eé]/i', $l['formato']) === 1;
    $palabra = $esPale ? 'palé' : 'lote';
    $ahorro = $l['pvp'] - $l['precio'];
    $porUnidad = $l['precio'] / max(1, (int) $l['uds']);

    $contenido = '';
    foreach ($l['contenido'] as $c) { $contenido .= '        <li>' . e($c) . "</li>\n"; }

    /* Los otros lotes, para enlazar entre fichas */
    $otros = array();
    foreach ($CAT['lotes'] as $o) {
        if ($o['id'] === $id) { continue; }
        $otros[] = array(
            'k' => $o['categoria'],
            't' => $o['nombre'],
            'u' => 'lotes/' . slug_de_lote($o['id']) . '.html',
            'd' => $o['resumen'],
        );
    }
    shuffle_estable($otros, $id);
    $otros = array_slice($otros, 0, 3);
    $otros[] = array(
        'k' => 'Guía',
        't' => 'Cómo comprar devoluciones de Amazon',
        'u' => 'blog/como-comprar-devoluciones-de-amazon.html',
        'd' => 'Los pasos, los precios reales y los errores que se pagan caros la primera vez.',
    );

    $PAGINAS[] = array(
        'ruta' => 'lotes/' . $slug . '.html',
        /* Sin «| Tornarem» a propósito: el nombre del lote y la palabra
           clave ya no caben en los 60 caracteres que enseña Google. */
        'titulo' => $l['nombre'] . ' · ' . ucfirst($palabra) . ' de devoluciones de Amazon · ' . eur($l['precio']),
        'desc' => ucfirst($palabra) . ' de ' . mb_strtolower($l['nombre'], 'UTF-8') . ' de devoluciones de Amazon: ' . $l['uds'] . ' unidades, grado ' . $l['grado'] . ', ' . eur($l['precio']) . ' con IVA y envío 24 h. Contrarreembolso o tarjeta.',
        'kicker' => 'Ref ' . $l['ref'] . ' · ' . $l['categoria'] . ' · Grado ' . $l['grado'],
        'h1' => $l['nombre'] . ' por ' . $palabra . 's',
        'entradilla' => e($l['resumen']) . ' <b>' . e($l['uds']) . ' unidades por ' . e(eur($l['precio'])) . '</b>, con IVA y envío de 24 h incluidos. PVP estimado del contenido: ' . e(eur($l['pvp'])) . '.',
        'img' => $l['img'],
        'imgAlt' => 'Lote de ' . mb_strtolower($l['nombre'], 'UTF-8') . ' preparado en la nave: ' . rtrim($l['resumen'], '.'),
        'respuesta' => 'Un ' . e($palabra) . ' de ' . e(mb_strtolower($l['nombre'], 'UTF-8')) . ' de devoluciones de Amazon cuesta <b>'
            . e(eur($l['precio'])) . '</b> en Tornarem e incluye <b>' . (int) $l['uds'] . ' unidades</b> de grado '
            . e($l['grado']) . ', revisadas una a una. Salen a ' . e(number_format($porUnidad, 2, ',', '.')) . ' € la unidad, frente a un PVP estimado de '
            . e(eur($l['pvp'])) . '. El precio lleva IVA y transporte incluidos, se paga contrarreembolso o con tarjeta y llega en '
            . ($esPale ? '24-48 horas' : '24 horas') . ' en península.',
        'respuestaDatos' => array(
            array('Precio final', e(eur($l['precio']))),
            array('Unidades', (int) $l['uds']),
            array('Por unidad', e(number_format($porUnidad, 2, ',', '.')) . ' €'),
            array('Grado', e($l['grado'])),
        ),
        'ogTipo' => 'product',
        'migas' => array(
            array('t' => 'Inicio', 'u' => 'index.html'),
            array('t' => 'Lotes', 'u' => 'lotes-de-devoluciones-de-amazon.html'),
            array('t' => $l['nombre'], 'u' => null),
        ),
        'datos' => array(
            array((int) $l['uds'], 'Unidades por ' . $palabra),
            array(e(eur($l['precio'])), 'Precio final con IVA'),
            array('−' . dto($l) . '<span class="u"> %</span>', 'Sobre el PVP estimado'),
            array(e($l['grado']), 'Grado de la mercancía'),
        ),
        'bloques' => array(
            array('h2' => 'Qué lleva dentro', 'id' => 'contenido', 'html' =>
                '    <p>El contenido se publica antes de vender, no después. Esto es lo que hay en un ' . e($palabra) . ' de ' . e(mb_strtolower($l['nombre'], 'UTF-8')) . ':</p>' . "\n" .
                "    <ul>\n" . $contenido . "    </ul>\n" .
                '    <p class="nota-destacada">' . e($l['nota']) . "</p>\n"),
            array('h2' => 'Para quién es este ' . $palabra, 'id' => 'para-quien', 'html' =>
                '    <p>' . e(isset($x['paraQuien']) ? $x['paraQuien'] : '') . "</p>\n"),
            array('h2' => 'Cuánto se saca revendiéndolo', 'id' => 'margen', 'html' =>
                '    <p>' . e(isset($x['margen']) ? $x['margen'] : '') . "</p>\n" .
                '    <p>' . e(isset($x['dondeRevender']) ? $x['dondeRevender'] : '') . "</p>\n" .
                '    <p class="aviso-honesto"><b>Con honestidad:</b> son precios de reventa reales de mercado, no una promesa. Lo que saques depende de cómo lo fotografíes, de lo rápido que respondas y de la paciencia que tengas para no malvender. Nadie te puede garantizar un beneficio.</p>' . "\n"),
            array('h2' => 'Lo que tienes que saber antes de pedirlo', 'id' => 'ojo', 'html' =>
                '    <p>' . e(isset($x['ojo']) ? $x['ojo'] : '') . "</p>\n" .
                '    <h3>Envío y pago</h3>' . "\n" .
                '    <p>' . ($esPale
                    ? 'Este lote viaja en palé con transporte especializado: entre 24 y 48 horas en península. Necesitas un sitio donde descargarlo (' . e($l['peso']) . ').'
                    : 'Sale en caja por agencia. Si confirmas antes de las 14:00 de un día laborable, lo tienes mañana en península.') . '
      Pagas contrarreembolso (en efectivo o con tarjeta al transportista, con un 3 % de recargo de la agencia, mínimo 5 €) o con tarjeta al hacer el pedido. Factura con IVA siempre.</p>' . "\n"),
        ),
        'lotes' => array($id),
        'lotesTitulo' => 'Pídelo ahora',
        'lotesLead' => 'Stock real de la nave, actualizado solo. Si aquí dice que quedan dos, quedan dos.',
        'faq' => array(
            array('p' => '¿El contenido es exactamente el que aparece en la lista?',
                  'r' => $id === 'lote-pale-mixto'
                    ? 'No. Este palé se vende cerrado y sin revisar: la lista es el reparto habitual, no un inventario cerrado. Tras el pedido te mandamos el manifiesto de referencias que viene del camión.'
                    : 'El reparto por tipo de producto sí; la marca y el modelo concretos varían de un ' . $palabra . ' a otro, porque cada camión trae lo que trae. Si necesitas saber exactamente qué marcas van en el que te tocaría, llámanos antes de pedirlo y te lo miramos.'),
            array('p' => '¿Qué significa el grado ' . $l['grado'] . '?',
                  'r' => 'Grado A es producto sin usar, normalmente una devolución de talla o de «no me gustó». Grado B lleva marcas de uso leves o la caja abierta, pero funciona. Grado C es para piezas o reparación, y no lo vendemos en lotes clasificados. <a href="../blog/grados-a-b-c-devoluciones.html">Aquí está explicado con fotos</a>.'),
            array('p' => '¿Puedo devolverlo si no me convence?',
                  'r' => $id === 'lote-pale-mixto'
                    ? 'Este palé no admite devolución: se vende cerrado, sin abrir y a precio de riesgo. Es la contrapartida de pagar 6 € por referencia.'
                    : 'Sí, tienes 14 días como cualquier compra a distancia, siempre que el lote vuelva completo y en el mismo estado. El transporte de vuelta lo pones tú. Si algo llegó roto o no era lo descrito, lo pagamos nosotros.'),
            array('p' => '¿Hacéis factura?',
                  'r' => 'Siempre, con el IVA desglosado. Si compras como empresa o autónomo, escribe el CIF o NIF en el pedido y la factura sale a ese nombre.'),
            array('p' => '¿Puedo verlo antes de comprarlo?',
                  'r' => 'Sí. Estamos en Girona, de lunes a viernes de 8:00 a 18:00. Puedes ver lotes abiertos de la misma categoría, recoger sin coste de envío y, si te llevas varios, hablarlo en persona.'),
        ),
        'relacionados' => $otros,
        'relTitulo' => 'Otros lotes en la nave',
        'ctaTitulo' => 'Quedan ' . $l['stock'] . ' en la nave',
        'ctaTexto' => 'Confirma antes de las 14:00 y sale hoy. Contrarreembolso o tarjeta, como prefieras.',
        'prioridad' => '0.9',
        'frecuencia' => 'daily',
        'aviso' => true,
        'avisoInteres' => $l['categoria'],
        'schema' => array(
            array(
                '@type' => 'Product',
                'name' => $l['nombre'] . ' — ' . $palabra . ' de devoluciones de Amazon',
                'sku' => $l['ref'],
                'category' => $l['categoria'],
                'image' => SITIO . '/' . $l['img'],
                'description' => $l['resumen'] . ' ' . $l['uds'] . ' unidades, grado ' . $l['grado'] . ', ' . $l['formato'] . ', ' . $l['peso'] . '.',
                'brand' => array('@type' => 'Brand', 'name' => 'Tornarem'),
                'itemCondition' => ($l['grado'] === 'A') ? 'https://schema.org/NewCondition' : 'https://schema.org/UsedCondition',
                'offers' => array(
                    '@type' => 'Offer',
                    'url' => SITIO . '/lotes/' . $slug . '.html',
                    'price' => (string) $l['precio'],
                    'priceCurrency' => 'EUR',
                    'availability' => $l['stock'] > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'itemCondition' => ($l['grado'] === 'A') ? 'https://schema.org/NewCondition' : 'https://schema.org/UsedCondition',
                    'seller' => array('@type' => 'Organization', 'name' => 'Tornarem'),
                    'priceValidUntil' => date('Y-m-d', strtotime('+3 months')),
                    'shippingDetails' => array(
                        '@type' => 'OfferShippingDetails',
                        'shippingRate' => array('@type' => 'MonetaryAmount', 'value' => '0', 'currency' => 'EUR'),
                        'shippingDestination' => array('@type' => 'DefinedRegion', 'addressCountry' => 'ES'),
                        'deliveryTime' => array(
                            '@type' => 'ShippingDeliveryTime',
                            'handlingTime' => array('@type' => 'QuantitativeValue', 'minValue' => 0, 'maxValue' => 1, 'unitCode' => 'DAY'),
                            'transitTime' => array('@type' => 'QuantitativeValue', 'minValue' => 1, 'maxValue' => $esPale ? 2 : 1, 'unitCode' => 'DAY'),
                        ),
                    ),
                ),
            ),
        ),
    );
}

/* Baraja siempre igual para el mismo lote: así el HTML generado no
   cambia de una ejecución a otra y el git diff sólo enseña lo que
   de verdad has tocado. */
function shuffle_estable(&$lista, $semilla) {
    $n = 0;
    for ($i = 0; $i < strlen($semilla); $i++) { $n += ord($semilla[$i]); }
    $orden = array();
    foreach ($lista as $k => $v) { $orden[] = array(($n * ($k + 7)) % 101, $k, $v); }
    usort($orden, function ($a, $b) { return $a[0] === $b[0] ? $a[1] - $b[1] : $a[0] - $b[0]; });
    $lista = array_map(function ($x) { return $x[2]; }, $orden);
}
