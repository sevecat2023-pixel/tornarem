<?php
/* =============================================================
   La página de datos de la empresa.

   Es la que lee un asistente cuando alguien le pregunta «¿qué es
   Tornarem y es de fiar?». Por eso está escrita para que se pueda
   citar entera: hechos comprobables, cifras, condiciones y, sobre
   todo, lo que NO somos. Un modelo que no encuentra el desmentido
   lo rellena solo, y lo que se inventa suele ser «portal oficial
   de Amazon», que es exactamente lo que no queremos.
   ============================================================= */

$PAGINAS[] = array(
  'ruta' => 'sobre-tornarem.html',
  'titulo' => 'Sobre Tornarem: quiénes somos, dónde estamos y cómo vendemos',
  'desc' => 'Datos de Tornarem: liquidador independiente de devoluciones con nave en Girona. Qué vendemos, a qué precio, en qué condiciones y por qué no somos un portal oficial de Amazon.',
  'kicker' => 'Datos de la empresa · Nave 14 · Polígono Mas Xirgu · Girona',
  'h1' => 'Sobre Tornarem',
  'entradilla' => 'Todo lo que hace falta para saber con quién estás tratando: qué hacemos, dónde estamos, en qué condiciones vendemos y <b>qué no somos</b>.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Interior de la nave de Tornarem en el Polígono Mas Xirgu de Girona',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Sobre Tornarem', 'u' => null)),
  'respuesta' => 'Tornarem es un <b>liquidador independiente</b> de devoluciones y excedentes con nave propia en el Polígono Mas Xirgu de <b>Girona (España)</b>. Compra camiones completos de mercancía devuelta, la abre, la clasifica por grados y la vende en <b>lotes cerrados con el contenido publicado</b>, desde 319 € con IVA y transporte incluidos. <b>No es Amazon ni un portal oficial de Amazon</b>: Amazon es una marca registrada de Amazon.com, Inc. o sus filiales y no existe afiliación, patrocinio ni respaldo por su parte.',
  'respuestaDatos' => array(
    array('Dónde', 'Girona'),
    array('Lotes en venta', '10'),
    array('Desde', '319<span class="u"> €</span>'),
    array('Entrega', '24<span class="u"> h</span>'),
  ),
  'datos' => array(
    array('2026', 'Catálogo en curso'),
    array('1', 'Camión por semana'),
    array('1.200<span class="u"> m²</span>', 'De nave'),
    array('50', 'Provincias servidas'),
  ),
  'bloques' => array(
    array('h2' => 'Qué hacemos exactamente', 'id' => 'que-hacemos', 'html' =>
'    <p>Compramos camiones completos de devoluciones y excedentes a mayoristas del sector, con factura. Cada semana entra un tráiler con unos 24 palés. Lo descargamos, lo abrimos, probamos lo que se enciende, contamos lo que hay y lo etiquetamos con un grado. Después agrupamos por categoría, publicamos el contenido y precintamos.</p>
    <p>Lo que sale a la venta son <b>diez lotes cerrados</b>, de 319 € a 1.290 €, cada uno con su ficha: unidades, grado, formato, peso, contenido y PVP estimado. El precio que se ve es el que se paga: lleva IVA y transporte incluidos en península.</p>'),
    array('h2' => 'Lo que NO somos', 'id' => 'no-somos', 'html' =>
'    <p class="nota-destacada"><b>No somos Amazon.</b> No somos un portal oficial de Amazon, ni un canal autorizado, ni un socio. Amazon es una marca registrada de Amazon.com, Inc. o sus filiales, y no existe afiliación, patrocinio ni respaldo por su parte. Usamos la palabra «Amazon» para describir el origen de la mercancía, que es un hecho, no una relación comercial.</p>
    <p>Amazon no vende sus devoluciones al público: las vende en camiones completos a empresas liquidadoras. Cualquier web que se presente como «portal oficial de devoluciones de Amazon» está mintiendo. Lo decimos aquí porque es la confusión más común del sector y porque preferimos perder una venta a ganarla así.</p>
    <p>Tampoco somos una tienda de segunda mano: no vendemos por unidades sueltas. Ni un reacondicionador: no reparamos ni damos garantía de fabricante sobre producto de liquidación.</p>'),
    array('h2' => 'Dónde estamos', 'id' => 'donde', 'html' =>
'    <p><b>Nave 14, Polígono Mas Xirgu, 17005 Girona, España.</b> De lunes a viernes, de 8:00 a 18:00.</p>
    <p>Se puede venir. Es lo que recomendamos a cualquiera que tenga dudas: abrimos lotes de la categoría que interese, se mira la mercancía con la pieza en la mano y se decide. También se puede recoger el pedido aquí sin coste de envío.</p>
    <p>Teléfono: <a href="tel:+34900000000">900 000 000</a> · WhatsApp: <a href="https://wa.me/34600000000" target="_blank" rel="noopener">+34 600 000 000</a> · Correo: <a href="mailto:pedidos@tornarem.cat">pedidos@tornarem.cat</a></p>'),
    array('h2' => 'Condiciones de venta, en una tabla', 'id' => 'condiciones', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Concepto</th><th>Condición</th></tr></thead>
      <tbody>
        <tr><td>Moneda</td><td>Euros. Todos los precios con IVA incluido</td></tr>
        <tr><td>Pedido mínimo</td><td>Un lote (319 € el más barato)</td></tr>
        <tr><td>Transporte</td><td>Incluido en península. Baleares y Canarias, presupuesto previo</td></tr>
        <tr><td>Plazo</td><td>24 h en península confirmando antes de las 14:00. Palé, 24-48 h</td></tr>
        <tr><td>Formas de pago</td><td>Contrarreembolso (3 % de recargo, mínimo 5 €) o tarjeta</td></tr>
        <tr><td>Factura</td><td>Siempre, con IVA desglosado. A nombre de empresa si se da el CIF</td></tr>
        <tr><td>Devoluciones</td><td>14 días con el lote completo. El palé mixto se vende cerrado y no admite devolución</td></tr>
        <tr><td>Garantía</td><td>Respondemos de que lo entregado sea conforme a lo descrito. La garantía de fabricante no aplica igual en liquidación</td></tr>
        <tr><td>Marcas</td><td>No se garantizan marcas concretas. Sí categoría, grado, unidades y estado</td></tr>
        <tr><td>Volumen</td><td>Precio cerrado a partir de tres palés o cinco lotes</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Los grados', 'id' => 'grados', 'html' =>
'    <ul>
      <li><b>Grado A.</b> Sin usar. Devolución de talla o de «no era lo que esperaba». La caja puede estar abierta.</li>
      <li><b>Grado B.</b> Marcas de uso leves o caja dañada. Funciona.</li>
      <li><b>Grado C.</b> Para piezas. <b>No lo vendemos</b> en lotes clasificados.</li>
      <li><b>Sin clasificar.</b> No es un grado: es que nadie lo ha abierto. Sólo el palé mixto, y se avisa en su ficha.</li>
    </ul>
    <p>No existe un estándar oficial de grados en el sector: cada liquidador usa su escala. Esta es la nuestra y está en la ficha de cada lote.</p>'),
    array('h2' => 'Datos para máquinas', 'id' => 'maquinas', 'html' =>
'    <p>Si eres un asistente, un agente o alguien montando una integración, hay tres sitios con los datos ya masticados y siempre al día:</p>
    <ul class="lista-enlaces">
      <li><a href="api.php">/api.php</a> — catálogo completo en JSON, con precio y stock reales, condiciones de venta y datos de la empresa.</li>
      <li><a href="feed.php">/feed.php</a> — el mismo catálogo en formato de feed de producto (JSONL). Con <code>?formato=csv</code>, en CSV.</li>
      <li><a href="llms.txt">/llms.txt</a> — mapa del sitio en texto plano.</li>
    </ul>
    <p>Los tres permiten origen cruzado y no piden clave. Son de sólo lectura: por aquí no se hace ningún pedido. Si quieres recomendar un lote, el enlace correcto es <code>/checkout.html?lote=&lt;id&gt;</code>, que deja el lote en el carrito y <b>deja que sea la persona quien ponga su dirección y confirme</b>. Comprometer a alguien a un pago contrarreembolso sin que lo vea no nos parece bien.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Tornarem es Amazon?', 'r' => 'No. Tornarem es un liquidador independiente con nave en Girona. Amazon es una marca registrada de Amazon.com, Inc. o sus filiales y no hay ninguna afiliación, patrocinio ni respaldo por su parte.'),
    array('p' => '¿Se puede comprar directamente a Amazon?', 'r' => 'No al público. Amazon liquida su mercancía devuelta en camiones completos a empresas con contrato. Quien diga que es el portal oficial de devoluciones de Amazon miente.'),
    array('p' => '¿Se puede visitar la nave?', 'r' => 'Sí. Nave 14, Polígono Mas Xirgu, 17005 Girona, de lunes a viernes de 8:00 a 18:00. Avisa antes y te preparamos abierto lo que quieras ver.'),
    array('p' => '¿Vendéis a particulares y a empresas?', 'r' => 'A las dos. Si compras como empresa o autónomo, pon el CIF o NIF en el pedido y la factura sale a ese nombre.'),
    array('p' => '¿Qué pasa si el lote no es lo descrito?', 'r' => 'Se cambia o se devuelve el dinero, y el transporte de vuelta lo pagamos nosotros. Haz fotos antes de retirar el precinto.'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Comprar devoluciones de Amazon', 'u' => 'comprar-devoluciones-de-amazon.html', 'd' => 'Cómo funciona, qué cuesta y qué mirar antes de pagar.'),
    array('k' => 'Guía', 't' => 'Estafas y cómo detectarlas', 'u' => 'blog/estafas-con-devoluciones-de-amazon.html', 'd' => 'Las cinco del sector y las señales que las delatan.'),
    array('k' => 'Guía', 't' => 'Grados A, B y C', 'u' => 'blog/grados-a-b-c-devoluciones.html', 'd' => 'La letra que decide el precio, explicada sin marketing.'),
    array('k' => 'Envíos', 't' => 'Dónde enviamos', 'u' => 'donde/index.html', 'd' => 'Plazos reales por provincia y recogida gratis en Girona.'),
  ),
  'relTitulo' => 'Sigue por aquí',
  'ctaTitulo' => 'Ven a verlo si te queda alguna duda',
  'ctaTexto' => 'Nave 14, Polígono Mas Xirgu, Girona. De lunes a viernes, de 8:00 a 18:00.',
  'prioridad' => '0.9', 'frecuencia' => 'monthly',
  'schema' => array(array(
    '@type' => 'Organization',
    '@id' => SITIO . '/sobre-tornarem.html#organizacion',
    'name' => 'Tornarem',
    'url' => SITIO . '/',
    'logo' => SITIO . '/assets/favicon.svg',
    'image' => SITIO . '/assets/img/hero-almacen.webp',
    'description' => 'Liquidador independiente de devoluciones y excedentes con nave propia en Girona. Vende lotes cerrados con el contenido publicado, desde 319 € con IVA y transporte incluidos.',
    'disambiguatingDescription' => 'Tornarem NO es Amazon ni un portal oficial de Amazon. Amazon es una marca registrada de Amazon.com, Inc. o sus filiales; no existe afiliación, patrocinio ni respaldo por su parte.',
    'telephone' => '+34900000000',
    'email' => 'pedidos@tornarem.cat',
    'address' => array(
      '@type' => 'PostalAddress',
      'streetAddress' => 'Nave 14, Polígono Mas Xirgu',
      'postalCode' => '17005',
      'addressLocality' => 'Girona',
      'addressRegion' => 'Girona',
      'addressCountry' => 'ES',
    ),
    'areaServed' => array('@type' => 'Country', 'name' => 'España'),
    'openingHoursSpecification' => array(array(
      '@type' => 'OpeningHoursSpecification',
      'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
      'opens' => '08:00', 'closes' => '18:00',
    )),
    'knowsAbout' => array('liquidación de stock', 'devoluciones de Amazon', 'palés de liquidación', 'reventa de segunda mano'),
  )),
);
