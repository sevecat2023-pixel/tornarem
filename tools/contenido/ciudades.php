<?php
/* =============================================================
   Una página por provincia grande: /donde/madrid.html, etc.

   Regla que no se salta: la nave está en Girona y sólo en Girona.
   Estas páginas no inventan almacenes ni direcciones que no
   existen; dicen desde dónde sale el envío, cuánto tarda hasta
   allí de verdad y qué salidas de reventa hay en la zona. Una
   página local que miente sobre su dirección es la forma más
   rápida de que Google te deje de enseñar.
   ============================================================= */

$CIUDADES = array(

array(
  'slug' => 'madrid', 'ciudad' => 'Madrid', 'gentilicio' => 'madrileño',
  'km' => 700, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Madrid es la provincia a la que más lotes mandamos. Sale de Girona por la tarde y está allí al día siguiente, con la misma tarifa que el resto de la península: cero.',
  'reventa' => 'Madrid tiene la salida de reventa más fácil de España, y también la más competida. El Rastro los domingos sigue siendo el sitio con más paso, pero el volumen de verdad está en la venta online: Wallapop en Madrid mueve más que en ninguna otra provincia, y la entrega en mano evita el coste de envío, que es lo que se come el margen en los productos de menos de 20 €.',
  'consejo' => 'Si vendes en mano por Madrid capital, los lotes pequeños y de mucha unidad (juguetes, belleza, moda) funcionan mejor que el palé: rotas rápido y no necesitas almacenar. Si tienes nave en Getafe, Fuenlabrada o el corredor del Henares, entonces sí compensa el palé.',
  'lotes' => array('lote-electronica', 'lote-moda', 'lote-juguetes', 'lote-belleza'),
  'descarga' => 'Si pides palé y no tienes muelle, marca la entrega con plataforma elevadora al hacer el pedido. En el centro de Madrid, además, conviene avisar de la franja horaria: hay calles con restricción de carga y descarga.',
),

array(
  'slug' => 'barcelona', 'ciudad' => 'Barcelona', 'gentilicio' => 'barcelonés',
  'km' => 100, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Barcelona está a cien kilómetros de la nave. Es la provincia donde el envío llega antes y la única, junto con Girona, donde mucha gente prefiere venir a buscarlo con la furgoneta.',
  'reventa' => 'Els Encants, en Glòries, es el mercado de segunda mano con más historia de la ciudad y sigue siendo una salida real para quien tiene parada. Fuera de ahí, la reventa fuerte es online y en los mercadillos de barrio y de los pueblos del Vallès y el Maresme, que llenan el calendario todos los fines de semana.',
  'consejo' => 'Al estar tan cerca, la recogida en nave te sale gratis y te ahorras esperar al transportista. Vienes a Girona, te lo cargamos con la carretilla y vuelves el mismo día. Es la opción que eligen casi todos los que compran palé desde Barcelona.',
  'lotes' => array('lote-pale-mixto', 'lote-moda', 'lote-hogar-cocina', 'lote-electronica'),
  'descarga' => 'Recogida gratis en la nave de Girona, a una hora por la AP-7. Si prefieres que vaya el transporte, un palé llega al día siguiente sin recargo.',
),

array(
  'slug' => 'valencia', 'ciudad' => 'Valencia', 'gentilicio' => 'valenciano',
  'km' => 500, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Valencia entra en la ruta de la AP-7 y tiene entrega al día siguiente con el mismo precio que el resto de la península. Los palés, entre 24 y 48 horas.',
  'reventa' => 'La Comunidad Valenciana tiene una red de mercadillos semanales muy densa: casi cada pueblo tiene el suyo un día fijo. Para quien compra lotes de mucha unidad y precio bajo, ese circuito es más rentable que la venta online, porque no pagas envío ni pierdes tiempo respondiendo mensajes.',
  'consejo' => 'Los lotes de moda y juguetes son los que mejor se mueven en mercadillo: precio de impulso y mucha pieza por caja. Si vas a hacer varios mercados a la semana, compensa el palé mixto y clasificar en casa.',
  'lotes' => array('lote-moda', 'lote-juguetes', 'lote-belleza', 'lote-pale-mixto'),
  'descarga' => 'Para palé, marca plataforma elevadora si descargas en calle. En polígono con muelle no hace falta.',
),

array(
  'slug' => 'sevilla', 'ciudad' => 'Sevilla', 'gentilicio' => 'sevillano',
  'km' => 1100, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Sevilla está a mil cien kilómetros de la nave, así que seamos honestos con los plazos: los lotes en caja suelen llegar en 24 horas, pero pueden irse a 48, y los palés van a 48 horas casi siempre. El precio del transporte sigue incluido.',
  'reventa' => 'El Jueves, en la calle Feria, es el mercadillo más antiguo de la ciudad y una salida clásica para material de segunda mano. Además, Sevilla y su área metropolitana tienen mercadillos semanales repartidos por casi todos los municipios, y una comunidad de venta online muy activa.',
  'consejo' => 'Al estar lejos, agrupa: sale mucho mejor pedir dos o tres lotes de una vez que ir pidiendo de uno en uno. El transporte lo ponemos nosotros, pero el plazo se te acumula y el ritmo de venta se resiente.',
  'lotes' => array('lote-juguetes', 'lote-moda', 'lote-hogar-cocina', 'lote-belleza'),
  'descarga' => 'Palé a 48 horas con transporte paletizado. Si no tienes muelle, plataforma elevadora: en Andalucía es donde más nos lo piden.',
),

array(
  'slug' => 'zaragoza', 'ciudad' => 'Zaragoza', 'gentilicio' => 'zaragozano',
  'km' => 400, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Zaragoza está a cuatro horas de la nave por la AP-2 y es de las provincias donde el plazo de 24 horas se cumple con más regularidad, palés incluidos.',
  'reventa' => 'El rastro dominical de Zaragoza es la referencia de la ciudad, y alrededor hay un circuito de mercadillos comarcales que funciona todo el año. Al ser una plaza menos saturada que Madrid o Barcelona, los precios de reventa aguantan mejor: se vende algo más despacio, pero más caro.',
  'consejo' => 'Es buena plaza para el palé: hay espacio de almacén barato en los polígonos y la competencia online es menor. Si estás empezando y tienes garaje, el mixto sale más a cuenta aquí que en una capital grande.',
  'lotes' => array('lote-pale-mixto', 'lote-herramientas', 'lote-hogar-cocina', 'lote-deporte'),
  'descarga' => 'Ruta directa por la AP-2. Palé en 24-48 horas con porte incluido.',
),

array(
  'slug' => 'bilbao', 'ciudad' => 'Bilbao', 'gentilicio' => 'bilbaíno',
  'km' => 600, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Bilbao y todo el País Vasco entran en la ruta del norte. Lote en caja al día siguiente, palé entre 24 y 48 horas, con el transporte incluido en el precio.',
  'reventa' => 'El rastro dominical del Casco Viejo y los mercadillos de las tres provincias son la salida tradicional. Pero en el norte funciona especialmente bien la venta a tienda: hay mucho comercio pequeño de barrio que compra lotes enteros para reponer sin pasar por distribuidor.',
  'consejo' => 'Si tienes contacto con tiendas de barrio, los lotes de electrodoméstico pequeño y herramienta son los que mejor se colocan enteros, sin que tengas que vender unidad por unidad.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-informatica', 'lote-electronica'),
  'descarga' => 'Transporte paletizado hasta Bizkaia, Gipuzkoa y Álava con porte incluido.',
),

array(
  'slug' => 'malaga', 'ciudad' => 'Málaga', 'gentilicio' => 'malagueño',
  'km' => 1100, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Málaga está en el extremo opuesto de la península y el plazo lo nota: los lotes en caja llegan normalmente en 24 horas, a veces en 48, y los palés en 48. Lo decimos antes de que pidas, no después.',
  'reventa' => 'La Costa del Sol tiene una particularidad que no tiene ninguna otra plaza española: población extranjera con mucha rotación. Eso significa demanda constante de menaje, pequeño electrodoméstico y mobiliario ligero para pisos que se montan y se desmontan cada temporada.',
  'consejo' => 'Los lotes de hogar y cocina y los de electrónica funcionan aquí mejor que en ningún sitio. Si publicas también en inglés, el mismo producto se te vende antes y a mejor precio.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-belleza', 'lote-moda'),
  'descarga' => 'Palé a 48 horas. Plataforma elevadora disponible: indícalo al pedir.',
),

array(
  'slug' => 'girona', 'ciudad' => 'Girona', 'gentilicio' => 'gironí',
  'km' => 0, 'plazo' => 'el mismo día', 'plazoPale' => 'el mismo día',
  'intro' => 'Aquí es donde está la nave. Nave 14 del Polígono Mas Xirgu, 17005 Girona, de lunes a viernes de 8:00 a 18:00. Si estás en la provincia, puedes venir, ver los lotes abiertos y llevártelo el mismo día sin pagar envío.',
  'reventa' => 'Girona tiene mercados semanales en casi todos los municipios y una temporada turística que dispara la demanda de mayo a septiembre en toda la Costa Brava. Para quien vende en mercado, la ventaja de estar al lado de la nave es que puedes reponer el mismo día en lugar de esperar al transportista.',
  'consejo' => 'Ven a verlo antes de comprar. Es lo que recomendamos a todo el mundo que puede: abrimos lotes de la categoría que te interese, miras el estado real de la mercancía y decides con la pieza en la mano. No hay mejor forma de quitarse las dudas.',
  'lotes' => array('lote-pale-mixto', 'lote-moda', 'lote-juguetes', 'lote-electronica'),
  'descarga' => 'Recogida gratis con cita previa. Te lo cargamos con la carretilla; trae furgoneta si es palé.',
  'esCasa' => true,
),

);

foreach ($CIUDADES as $c) {
    $esCasa = !empty($c['esCasa']);
    $otras = array();
    foreach ($CIUDADES as $o) {
        if ($o['slug'] === $c['slug']) { continue; }
        $otras[] = array(
            'k' => 'Envíos',
            't' => 'Devoluciones de Amazon en ' . $o['ciudad'],
            'u' => 'donde/' . $o['slug'] . '.html',
            'd' => 'Plazos, dónde revender en la zona y qué lotes funcionan mejor allí.',
        );
    }
    shuffle_estable($otras, $c['slug']);
    $otras = array_slice($otras, 0, 3);
    $otras[] = array('k' => 'Guía', 't' => 'Cómo comprar devoluciones de Amazon', 'u' => 'blog/como-comprar-devoluciones-de-amazon.html', 'd' => 'Los pasos, los precios reales y los errores de la primera compra.');

    $PAGINAS[] = array(
      'ruta' => 'donde/' . $c['slug'] . '.html',
      'titulo' => 'Devoluciones de Amazon en ' . $c['ciudad'] . ' · Entrega en ' . $c['plazo'],
      'desc' => 'Lotes y palés de devoluciones de Amazon con entrega en ' . $c['ciudad'] . ' en ' . $c['plazo'] . ', transporte incluido. Contrarreembolso o tarjeta. Desde 319 €.',
      'kicker' => 'Envíos a ' . $c['ciudad'] . ' · Transporte incluido · ' . ucfirst($c['plazo']),
      'h1' => 'Devoluciones de Amazon en ' . $c['ciudad'],
      'entradilla' => e($c['intro']),
      'img' => $esCasa ? 'assets/img/hero-almacen.webp' : 'assets/img/camion-descarga.webp',
      'imgAlt' => $esCasa
        ? 'Interior de la nave de Tornarem en el Polígono Mas Xirgu de Girona'
        : 'Palés cargándose en el muelle para salir de ruta',
      'migas' => array(
        array('t' => 'Inicio', 'u' => 'index.html'),
        array('t' => 'Dónde enviamos', 'u' => 'donde/index.html'),
        array('t' => $c['ciudad'], 'u' => null),
      ),
      'datos' => array(
        array(e($c['plazo'] === 'el mismo día' ? 'Hoy' : $c['plazo']), 'Lote en caja'),
        array(e($c['plazoPale'] === 'el mismo día' ? 'Hoy' : $c['plazoPale']), 'Palé completo'),
        array('0<span class="u"> €</span>', 'Transporte'),
        array('319<span class="u"> €</span>', 'Lote más barato'),
      ),
      'bloques' => array(
        array('h2' => 'Desde dónde sale y cuánto tarda hasta ' . $c['ciudad'], 'id' => 'envio', 'html' =>
          '    <p>Todo sale de la misma nave: Nave 14, Polígono Mas Xirgu, 17005 Girona. <b>No tenemos almacén en ' . e($c['ciudad']) . '</b> ni en ninguna otra ciudad, y preferimos decirlo a fingir una dirección local que no existe.</p>
    <p>Hasta ' . e($c['ciudad']) . ' son unos ' . (int) $c['km'] . ' km. Un lote en caja llega en ' . e($c['plazo']) . ' si confirmas antes de las 14:00 de un día laborable; un palé, en ' . e($c['plazoPale']) . '. El transporte está incluido en el precio, sin recargo por distancia.</p>
    <p>' . e($c['descarga']) . '</p>'),
        array('h2' => 'Dónde se revende en ' . $c['ciudad'], 'id' => 'reventa', 'html' =>
          '    <p>' . e($c['reventa']) . "</p>\n" .
          '    <p>' . e($c['consejo']) . "</p>\n" .
          '    <p class="aviso-honesto"><b>Con honestidad:</b> esto es lo que nos cuentan los clientes de la zona y lo que vemos repetirse, no un estudio de mercado. Lo que funcione para ti depende de cómo vendas tú.</p>'),
        array('h2' => 'Cómo se paga desde ' . $c['ciudad'], 'id' => 'pago', 'html' =>
          '    <p>Contrarreembolso: haces el pedido sin pagar, y pagas en efectivo o con tarjeta al transportista cuando llega. La agencia cobra un 3 % por el servicio (mínimo 5 €). O con tarjeta al hacer el pedido, y te ahorras ese recargo. Factura con IVA en los dos casos.</p>'),
      ),
      'lotes' => $c['lotes'],
      'lotesTitulo' => 'Lo que mejor funciona en ' . $c['ciudad'],
      'lotesLead' => 'Precio final con IVA y transporte incluido hasta ' . $c['ciudad'] . '.',
      'faq' => array(
        array('p' => '¿Tenéis almacén en ' . $c['ciudad'] . '?', 'r' => 'No. La única nave es la de Girona, en el Polígono Mas Xirgu. Todo lo que compres sale de ahí. Si alguien te vende devoluciones diciendo que tiene almacenes en media España, pídele la dirección.'),
        array('p' => '¿Cuánto cuesta el envío a ' . $c['ciudad'] . '?', 'r' => 'Nada. Está incluido en el precio del lote, igual que el IVA. No hay recargo por distancia dentro de la península.'),
        array('p' => '¿Puedo pagar al recibirlo en ' . $c['ciudad'] . '?', 'r' => 'Sí, contrarreembolso en efectivo o con tarjeta en el datáfono del transportista. La agencia añade un 3 % por gestionar el cobro, con un mínimo de 5 €.'),
        array('p' => '¿Y si no estoy en casa cuando llega?', 'r' => 'La agencia deja aviso e intenta una segunda entrega, y puedes cambiar la franja horaria con el número de seguimiento que te mandamos por correo al salir el pedido.'),
      ),
      'relacionados' => $otras,
      'relTitulo' => 'Enviamos a toda la península',
      'ctaTitulo' => 'Pídelo hoy y sale hoy',
      'ctaTexto' => 'Confirma antes de las 14:00 y el paquete sale esta tarde camino de ' . $c['ciudad'] . '.',
      'prioridad' => '0.7', 'frecuencia' => 'weekly',
      'aviso' => true,
      'schema' => $esCasa ? array(array(
        '@type' => 'LocalBusiness',
        'name' => 'Tornarem',
        'description' => 'Liquidador independiente de devoluciones y excedentes: venta de lotes y palés con factura.',
        'url' => SITIO . '/',
        'image' => SITIO . '/assets/img/hero-almacen.webp',
        'telephone' => '+34900000000',
        'email' => 'pedidos@tornarem.cat',
        'priceRange' => '€€',
        'address' => array(
          '@type' => 'PostalAddress',
          'streetAddress' => 'Nave 14, Polígono Mas Xirgu',
          'postalCode' => '17005',
          'addressLocality' => 'Girona',
          'addressRegion' => 'Girona',
          'addressCountry' => 'ES',
        ),
        'openingHoursSpecification' => array(array(
          '@type' => 'OpeningHoursSpecification',
          'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
          'opens' => '08:00', 'closes' => '18:00',
        )),
      )) : array(array(
        '@type' => 'Service',
        'serviceType' => 'Venta de lotes de devoluciones con entrega en ' . $c['ciudad'],
        'provider' => array('@type' => 'Organization', 'name' => 'Tornarem', 'url' => SITIO . '/'),
        'areaServed' => array('@type' => 'City', 'name' => $c['ciudad']),
      )),
    );
}

/* Índice de ciudades */
$listaCiudades = '';
foreach ($CIUDADES as $c) {
    $listaCiudades .= '      <a class="enlace-card" href="' . $c['slug'] . '.html">
        <span class="enlace-kicker">' . e($c['plazo'] === 'el mismo día' ? 'Recogida y envío' : 'Entrega en ' . $c['plazo']) . '</span>
        <h3>' . e($c['ciudad']) . '</h3>
        <p>' . e(mb_substr($c['intro'], 0, 120, 'UTF-8')) . '…</p>
      </a>
';
}

$PAGINAS[] = array(
  'ruta' => 'donde/index.html',
  'titulo' => 'Dónde enviamos · Devoluciones de Amazon en toda España',
  'desc' => 'Enviamos lotes y palés de devoluciones de Amazon a toda la península con el transporte incluido. Plazos reales por provincia y recogida gratis en la nave de Girona.',
  'kicker' => 'Península y Baleares · Transporte incluido',
  'h1' => 'Dónde enviamos',
  'entradilla' => 'Una sola nave, en Girona, y envíos a toda la península con el transporte incluido en el precio. Aquí están los <b>plazos reales</b> por provincia, sin redondear a favor.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Camión cargando palés en el muelle de la nave de Girona',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Dónde enviamos', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Provincias con página propia', 'id' => 'provincias', 'html' =>
      "    <div class=\"enlaces enlaces--prosa\">\n" . $listaCiudades . "    </div>\n"),
    array('h2' => 'El resto de España', 'id' => 'resto', 'html' =>
'    <p>Enviamos a toda la península con el mismo precio y sin recargo por distancia. Si tu provincia no tiene página propia es porque todavía no nos han preguntado lo suficiente por ella, no porque no lleguemos.</p>
    <p><b>Baleares y Canarias:</b> presupuesto aparte, siempre antes de que pagues nada. El transporte marítimo y, en Canarias, los trámites de aduana cambian bastante el precio y no queremos dar una cifra que luego no se sostenga. Escríbenos con el lote y el código postal y te lo cerramos.</p>
    <p><b>Ceuta, Melilla y fuera de España:</b> de momento no servimos.</p>'),
  ),
  'faq' => array(
    array('p' => '¿El envío es gratis de verdad?', 'r' => 'Está incluido en el precio, que no es lo mismo que gratis: lo pagas dentro del lote. Pero no hay sorpresas al final del pedido ni recargo por vivir lejos.'),
    array('p' => '¿Cuándo sale mi pedido?', 'r' => 'Si confirmas antes de las 14:00 de un día laborable, sale esa misma tarde. Después de esa hora, al día siguiente.'),
    array('p' => '¿Me dais número de seguimiento?', 'r' => 'Sí, por correo en cuanto la agencia recoge el paquete.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Comprar devoluciones de Amazon', 'u' => 'comprar-devoluciones-de-amazon.html', 'd' => 'Cómo funciona, qué cuesta y qué mirar antes de pagar.'),
    array('k' => 'Comprar', 't' => 'Palés completos', 'u' => 'palets-de-devoluciones-de-amazon.html', 'd' => 'Pesos, medidas y cómo se descarga un palé sin muelle.'),
    array('k' => 'Guía', 't' => 'Cómo comprar devoluciones de Amazon', 'u' => 'blog/como-comprar-devoluciones-de-amazon.html', 'd' => 'La guía completa, paso a paso.'),
  ),
  'ctaTitulo' => 'Llegamos mañana a casi toda España',
  'prioridad' => '0.6', 'frecuencia' => 'monthly',
);
