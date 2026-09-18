<?php
/* =============================================================
   El blog: guías que responden a lo que la gente escribe en
   Google antes de comprar. Cada artículo entra por una búsqueda
   distinta y sale hacia una ficha o una página de compra.

   Lo que no hacemos aquí: rellenar con palabras clave. Un texto
   que no le sirve a quien lo lee tampoco acaba sirviendo para
   posicionar, y encima quema la confianza del que sí llega.
   ============================================================= */

$ART = array();

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-comprar-devoluciones-de-amazon',
  'titulo' => 'Cómo comprar devoluciones de Amazon: guía completa 2026',
  'h1' => 'Cómo comprar devoluciones de Amazon',
  'desc' => 'Guía paso a paso para comprar devoluciones de Amazon en España: dónde se compran, cuánto cuestan de verdad, qué grados existen y los errores que se pagan caros.',
  'entradilla' => 'Todo lo que hay que saber antes de gastarte el primer euro: de dónde sale la mercancía, qué precios son reales, qué significa cada grado y en qué momento conviene decir que no.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Nave con palés de devoluciones clasificados en estanterías',
  'fecha' => '2026-09-17', 'minutos' => 11,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => '1. De dónde sale la mercancía', 'html' =>
'    <p>Cuando devuelves algo a Amazon, casi nunca vuelve a la estantería. Revisar unidad por unidad, reembalar y volver a catalogar cuesta más que el margen del producto. Esa mercancía se agrupa y se vende en camiones completos, por peso y categoría, a empresas liquidadoras.</p>
    <p>Eso significa dos cosas importantes. La primera: <b>Amazon no vende sus devoluciones al público</b>. Cualquier web que se presente como «portal oficial de devoluciones de Amazon» está mintiendo, y eso incluye a quien lo diga con el logo puesto. La segunda: entre Amazon y tú siempre hay un intermediario, y la pregunta relevante es qué hace ese intermediario con la mercancía antes de vendértela.</p>'),
    array('h2' => '2. Las tres formas de comprar', 'html' =>
'    <h3>Camión completo</h3>
    <p>24 palés, decenas de miles de euros, subasta o contrato directo con el liquidador mayorista. No es una opción si estás leyendo esta guía, pero conviene saber que existe: es el origen de todo lo demás.</p>
    <h3>Palé</h3>
    <p>Entre 58 y 210 kg de mercancía retractilada. Puede venir clasificado por categoría o mixto tal cual baja del camión. Precio típico en España: entre 500 y 1.500 € según categoría y grado. Necesitas sitio donde descargarlo y tiempo para clasificarlo.</p>
    <h3>Lote en caja</h3>
    <p>De 14 a 120 unidades de una misma categoría, revisadas y etiquetadas. Entre 300 y 700 € normalmente. Llega por agencia a la puerta de casa. Es por donde empieza casi todo el mundo, y con razón.</p>'),
    array('h2' => '3. Cuánto cuesta de verdad', 'html' =>
'    <p>Los precios que se ven en España, con IVA y transporte incluidos:</p>
    <table class="tabla">
      <thead><tr><th>Formato</th><th>Precio habitual</th><th>Por unidad</th><th>Riesgo</th></tr></thead>
      <tbody>
        <tr><td>Lote clasificado en caja</td><td>300 - 700 €</td><td>5 - 13 €</td><td>Bajo</td></tr>
        <tr><td>Palé por categoría</td><td>500 - 900 €</td><td>20 - 40 €</td><td>Medio</td></tr>
        <tr><td>Palé mixto sin clasificar</td><td>1.000 - 1.500 €</td><td>5 - 8 €</td><td>Alto</td></tr>
      </tbody>
    </table>
    <p>Si ves un palé de electrónica por 99 €, no es una ganga: es un anzuelo. La mercancía tiene un coste de origen y un coste de transporte que no bajan de ahí ni queriendo.</p>
    <p>Ojo también con el «valor estimado». Un lote con PVP de catálogo de 2.600 € no vale 2.600 €: vale lo que consigas venderlo, que será bastante menos. El PVP sirve para comparar lotes entre sí, no para calcular tu beneficio.</p>'),
    array('h2' => '4. Los grados, que es lo que de verdad decide el precio', 'html' =>
'    <ul>
      <li><b>Grado A.</b> Sin usar. Devolución de talla, de color o de «no era lo que pensaba». Caja abierta como mucho. Es lo que se revende como nuevo.</li>
      <li><b>Grado B.</b> Marcas de uso leves, caja golpeada o abierta, a veces falta un accesorio menor. Funciona. Es la mayor parte del mercado.</li>
      <li><b>Grado C.</b> Para piezas o reparación. No debería venderse en lotes clasificados y nosotros no lo hacemos.</li>
      <li><b>Sin clasificar.</b> No es un grado: es la ausencia de grado. Significa que nadie lo ha abierto. Puede haber de todo, incluido lo que no funciona.</li>
    </ul>
    <p>No hay un estándar oficial: cada liquidador usa su escala. Lo que sí puedes exigir es que te digan qué entiende él por cada letra. Si no te lo sabe explicar, la clasificación no existe. <a href="grados-a-b-c-devoluciones.html">Aquí lo desarrollamos con ejemplos</a>.</p>'),
    array('h2' => '5. Cómo se paga y por qué importa', 'html' =>
'    <p>En la primera compra, con alguien que no conoces, <b>el contrarreembolso es tu red de seguridad</b>. Pagas cuando el paquete está delante de ti. Si el vendedor no ofrece contrarreembolso ni pasarela de tarjeta y sólo acepta Bizum o transferencia, ya sabes lo que hay.</p>
    <p>Con tarjeta a través de pasarela también estás cubierto: si el producto no llega o no es lo descrito, tienes el proceso de reclamación del banco. Una transferencia a una cuenta personal no tiene ninguna protección.</p>
    <p>Y pide factura. Siempre. Una factura con IVA desglosado y un CIF real es la prueba de que hay una empresa detrás.</p>'),
    array('h2' => '6. La primera compra: qué pedir', 'html' =>
'    <p>Un lote clasificado, de una categoría que sepas vender, de entre 300 y 600 €. No un palé mixto por muy bien que suene el precio por unidad.</p>
    <p>Razón: el palé mixto exige clasificar 210 referencias, tener dónde ponerlas y aguantar que un 15-20 % no sirva. Si nunca has vendido de segunda mano, vas a descubrir a la vez que clasificar lleva un fin de semana entero y que vender lleva más tiempo del que pensabas. Mejor descubrirlo con 64 juguetes que con un palé.</p>
    <p>Elige la categoría por dónde vas a vender, no por lo que te guste: moda si vendes en Vinted, electrónica o informática si vendes en Wallapop, hogar y herramienta si tienes tienda o haces mercadillo.</p>'),
    array('h2' => '7. Errores que se pagan caros', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Comprar por el PVP estimado.</b> Calcula siempre con precios de reventa reales, mirando qué se está pidiendo hoy por ese producto usado.</li>
      <li><b>No contar tu tiempo.</b> Clasificar, fotografiar, publicar y responder mensajes son horas. Si te salen 3 € la hora, el negocio no es negocio.</li>
      <li><b>Comprar sin sitio donde almacenar.</b> Un palé no cabe en un piso. Parece obvio hasta que llega el camión.</li>
      <li><b>Pagar por adelantado a un desconocido.</b> La estafa más común del sector, y la más fácil de evitar.</li>
      <li><b>Malvender por prisa.</b> El error más caro de todos: bajar el precio a la semana porque no se vende. La mayoría de las piezas tardan entre dos y seis semanas.</li>
    </ol>'),
  ),
  'faq' => array(
    array('p' => '¿Se puede comprar devoluciones de Amazon siendo particular?', 'r' => 'Sí, comprar puede cualquiera. Revender de forma habitual y con ánimo de lucro ya es otra cosa: ahí Hacienda te va a pedir que te des de alta. Lo explicamos en <a href="necesito-ser-autonomo-para-revender.html">esta guía</a>.'),
    array('p' => '¿Cuánto dinero hace falta para empezar?', 'r' => 'Con 300-400 € tienes un lote clasificado de entrada. Añade lo que cueste el material de envío si vas a vender online y algo de margen para no tener que malvender con prisa.'),
    array('p' => '¿Qué porcentaje de un lote suele estar roto?', 'r' => 'En un lote clasificado, muy poco: lo que no funciona no debería haber entrado. En un palé mixto sin clasificar, cuenta con un 15-20 % por nuestra experiencia abriendo camiones.'),
    array('p' => '¿Se puede vivir de esto?', 'r' => 'Hay gente que vive de esto, y también mucha gente que lo probó un mes y lo dejó. Es un negocio de volumen y de constancia: márgenes buenos por pieza, pero muchas piezas y mucho trabajo manual. Como complemento funciona mejor que como sustituto de un sueldo, al menos el primer año.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'cuanto-cuesta-un-palet-de-devoluciones',
  'titulo' => 'Cuánto cuesta un palé de devoluciones de Amazon en España',
  'h1' => 'Cuánto cuesta un palé de devoluciones',
  'desc' => 'Precios reales de palés de devoluciones de Amazon en España por categoría y grado, qué encarece un palé y por qué un precio demasiado bajo es mala señal.',
  'entradilla' => 'Precios de mercado por categoría y grado, qué hace que un palé cueste el doble que otro y en qué punto un precio barato deja de ser una oportunidad para ser un aviso.',
  'img' => 'assets/img/lote-pale-mixto.webp',
  'imgAlt' => 'Palé mixto retractilado con referencias mezcladas',
  'fecha' => '2026-09-15', 'minutos' => 7,
  'tema' => 'Precios',
  'bloques' => array(
    array('h2' => 'Precios de mercado en España', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Tipo de palé</th><th>Precio habitual</th><th>Referencias</th></tr></thead>
      <tbody>
        <tr><td>Mixto sin clasificar</td><td>1.000 - 1.500 €</td><td>180 - 250</td></tr>
        <tr><td>Hogar y menaje, grado B</td><td>600 - 900 €</td><td>60 - 120</td></tr>
        <tr><td>Moda y textil, grado A</td><td>500 - 800 €</td><td>150 - 300</td></tr>
        <tr><td>Electrónica clasificada, grado A/B</td><td>900 - 1.800 €</td><td>40 - 90</td></tr>
        <tr><td>Deporte y voluminoso, grado B</td><td>450 - 700 €</td><td>20 - 40</td></tr>
      </tbody>
    </table>
    <p>Son horquillas de lo que se ve en el mercado español con IVA y transporte incluidos. Un palé idéntico puede variar 300 € según la época del año: en octubre y noviembre todo sube porque todo el mundo compra para Navidad.</p>'),
    array('h2' => 'Qué encarece un palé', 'html' =>
'    <ul>
      <li><b>Que esté clasificado.</b> Abrir, probar y etiquetar cuesta horas de persona. Un palé clasificado vale entre un 40 % y un 80 % más que el mismo sin abrir, y lo vale.</li>
      <li><b>El grado.</b> Grado A frente a grado B pueden ser 400 € de diferencia en el mismo palé.</li>
      <li><b>La categoría.</b> La electrónica es lo más caro por peso; el textil, lo más barato por unidad.</li>
      <li><b>El manifiesto.</b> Un palé con listado de referencias y PVP vale más que uno a ciegas, porque puedes calcular antes de comprar.</li>
      <li><b>El transporte.</b> Si el precio no lo incluye, súmale entre 60 y 120 € en península.</li>
    </ul>'),
    array('h2' => 'Cuándo un precio bajo es mala señal', 'html' =>
'    <p>Hay un suelo que no se puede romper. Un palé cuesta dinero en origen, cuesta transporte y cuesta manipulación. Cuando alguien ofrece un palé de electrónica por 150 € está pasando una de estas tres cosas:</p>
    <ol class="pasos-lista">
      <li>No existe el palé, y el objetivo es el pago por adelantado.</li>
      <li>Existe, pero es grado C: material para piezas vendido como aprovechable.</li>
      <li>Existe y es real, pero el precio no incluye el transporte, que te va a costar 120 € más y te enterarás al final.</li>
    </ol>
    <p>La regla práctica: si el precio está más de un 40 % por debajo de la horquilla de la tabla, pide fotos del palé concreto con la fecha del día y pregunta si acepta contrarreembolso. Las dos preguntas juntas espantan a casi todos los que no tienen mercancía.</p>'),
    array('h2' => 'Lo que cuesta de más', 'html' =>
'    <p>El precio del palé no es tu coste real. Súmale:</p>
    <ul>
      <li><b>Tu tiempo.</b> Clasificar un palé mixto son entre 8 y 15 horas. Póntelo a un precio por hora, aunque sea bajo.</li>
      <li><b>Lo que no se vende.</b> Entre un 15 y un 20 % del mixto. Es coste hundido.</li>
      <li><b>Material de envío</b> si vendes online: cajas, plástico de burbujas, etiquetas. Unos 0,80-1,50 € por pieza.</li>
      <li><b>Comisiones de plataforma</b> cuando las hay, y los envíos que te comes en devoluciones.</li>
    </ul>
    <p>Con todo dentro, un palé de 1.290 € viene a costarte entre 1.600 y 1.800 € de verdad. Haz las cuentas con ese número, no con el de la etiqueta.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto pesa un palé de devoluciones?', 'r' => 'Entre 58 y 250 kg según la categoría. El textil pesa poco y ocupa mucho; la herramienta y el deporte pesan mucho y ocupan menos.'),
    array('p' => '¿El transporte suele estar incluido?', 'r' => 'Depende del vendedor. Nosotros lo incluimos en península. Pregunta siempre antes de comparar precios: dos palés al mismo precio no son lo mismo si uno lleva 120 € de porte por detrás.'),
    array('p' => '¿Hay descuento por comprar varios palés?', 'r' => 'Normalmente sí, a partir de tres. También se agrupa el transporte, que es donde más se nota.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'que-hay-dentro-de-un-palet-de-devoluciones',
  'titulo' => 'Qué hay dentro de un palé de devoluciones de Amazon',
  'h1' => 'Qué hay dentro de un palé',
  'desc' => 'Abrimos un palé mixto sin clasificar y contamos el reparto real: qué categorías salen, qué porcentaje funciona y qué acaba en el contenedor.',
  'entradilla' => 'Abrimos un palé mixto de los que entran en la nave y contamos lo que sale: categorías, estado real y el porcentaje que no llega a venderse. Sin selección de fotos favorables.',
  'img' => 'assets/img/clasificacion.webp',
  'imgAlt' => 'Mesa de clasificación con productos devueltos separados por categorías',
  'fecha' => '2026-09-12', 'minutos' => 8,
  'tema' => 'Dentro de la nave',
  'bloques' => array(
    array('h2' => 'El reparto habitual', 'html' =>
'    <p>Un palé mixto de los que compramos trae del orden de 210 referencias. Abriendo palés durante meses, el reparto que se repite es este:</p>
    <table class="tabla">
      <thead><tr><th>Categoría</th><th>% del palé</th><th>Qué suele salir</th></tr></thead>
      <tbody>
        <tr><td>Hogar y menaje</td><td>~40 %</td><td>Utensilios, textil de casa, pequeño electrodoméstico, decoración</td></tr>
        <tr><td>Electrónica y accesorios</td><td>~25 %</td><td>Cables, cargadores, auriculares, fundas, algún aparato mayor</td></tr>
        <tr><td>Juguete y ocio</td><td>~15 %</td><td>Juegos, peluches, material de manualidades</td></tr>
        <tr><td>Varios</td><td>~20 %</td><td>Papelería, mascotas, salud, herramienta suelta, libros</td></tr>
      </tbody>
    </table>
    <p>Ese «~» es importante. Un palé puede venir con el 60 % de textil y otro con media docena de aspiradoras. La media se cumple en el conjunto del camión, no en cada palé.</p>'),
    array('h2' => 'El estado real de lo que sale', 'html' =>
'    <p>De cada 100 referencias que abrimos de un mixto:</p>
    <ul>
      <li><b>Unas 45</b> están sin estrenar o prácticamente: devoluciones de talla, de color o de compra arrepentida. Son las que pagan el palé.</li>
      <li><b>Unas 35</b> están usadas pero funcionan: caja abierta, marcas leves, falta un accesorio menor.</li>
      <li><b>Unas 12</b> están incompletas o no funcionan. Se apartan.</li>
      <li><b>Unas 8</b> no tienen salida a ningún precio: material de un solo uso ya usado, higiene abierta, cosas que no se pueden revender por higiene o por seguridad.</li>
    </ul>
    <p>Ese 20 % de los dos últimos grupos es el número que casi nadie menciona cuando vende palés. Si tus cuentas no lo incluyen, tus cuentas están mal.</p>'),
    array('h2' => 'Lo que sorprende al abrirlo', 'html' =>
'    <p><b>Hay muchísimo accesorio pequeño.</b> Cables, fundas, adaptadores. Vale poco por unidad y ocupa la mitad del tiempo de clasificación. La forma de rentabilizarlo es agruparlo en packs, nunca venderlo suelto.</p>
    <p><b>Las piezas grandes son pocas pero deciden el resultado.</b> Un robot aspirador o una freidora de aire pueden valer lo que cincuenta cables. En un palé bueno salen tres o cuatro; en uno malo, ninguna.</p>
    <p><b>Hay producto con datos personales.</b> Discos, tablets, algún móvil. Se formatean antes de vender, siempre. Si compras a alguien que no lo hace, hazlo tú antes de revender: no es sólo decencia, es tu responsabilidad legal.</p>
    <p><b>El embalaje engaña.</b> Una caja perfecta puede llevar dentro un aparato roto y una caja destrozada un producto impecable. Por eso se abre todo.</p>'),
    array('h2' => 'Cuánto se tarda en clasificarlo', 'html' =>
'    <p>Entre 8 y 15 horas por palé, en serio. Y eso es con mesa, cúter, etiquetas y sitio para hacer montones. En el salón de casa, el doble.</p>
    <p>El orden que funciona: primero sacar todo del palé y hacer cuatro montones por categoría. Después, dentro de cada montón, separar en «vende solo», «necesita foto buena» y «pack». Al final, lo que no funciona, aparte y fuera. Fotografiar en tandas por categoría, no pieza a pieza.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Vienen productos de marca?', 'r' => 'Sí, mezclados con marca blanca y marcas de plataforma. En un palé mixto no puedes elegir ni te lo pueden garantizar: depende del camión.'),
    array('p' => '¿Puede venir un palé entero de basura?', 'r' => 'Puede venir un palé malo, sí: es el riesgo que estás comprando y por eso el precio por referencia es de 6 €. Un palé entero inservible es raro, pero un palé por debajo de la media pasa.'),
    array('p' => '¿Se puede ver el manifiesto antes de comprar?', 'r' => 'En el mixto, no: nos llega con el camión y te lo pasamos después del pedido. En los palés clasificados, el contenido está publicado en la ficha antes de comprar.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'grados-a-b-c-devoluciones',
  'titulo' => 'Grados A, B y C en devoluciones: qué significa cada uno',
  'h1' => 'Grados A, B y C',
  'desc' => 'Qué significan los grados A, B y C en lotes de devoluciones, qué te puedes encontrar en cada uno y cómo detectar a quien usa la escala para inflar el precio.',
  'entradilla' => 'La letra que decide el precio. Qué hay detrás de cada grado, qué puedes esperar al abrir la caja y cómo saber si el vendedor está usando la escala para inflar.',
  'img' => 'assets/img/lote-electronica.webp',
  'imgAlt' => 'Auriculares, altavoces y tablets de un lote de electrónica, revisados uno a uno',
  'fecha' => '2026-09-10', 'minutos' => 6,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'No hay estándar oficial', 'html' =>
'    <p>Empecemos por lo incómodo: no existe ninguna norma que diga qué es grado A. Cada liquidador usa su escala, y algunos la usan con generosidad interesada. Lo que sí es común en el sector es esto.</p>'),
    array('h2' => 'Grado A', 'html' =>
'    <p><b>Producto sin usar.</b> La devolución de talla, de color o de «no era lo que esperaba». El precinto puede estar abierto porque alguien miró la caja, pero el producto no se ha usado.</p>
    <p>Qué esperar al abrirlo: el artículo completo, con sus accesorios, a veces con la caja algo marcada del transporte. En textil, la etiqueta puesta. Es lo que se revende como «nuevo, caja abierta» sin mentir.</p>
    <p>Precio: el más alto del mercado, y también el que menos sorpresas da.</p>'),
    array('h2' => 'Grado B', 'html' =>
'    <p><b>Usado pero funcionando.</b> Marcas leves, caja golpeada o abierta, a veces falta un accesorio menor: una cuchara medidora, un cable de repuesto, el manual.</p>
    <p>Qué esperar: que encienda, que cargue y que haga lo que tiene que hacer. Que no parezca nuevo. Es la mayor parte del mercado de devoluciones y, bien comprado, donde está el margen: se compra con descuento de usado y se vende con precio de «como nuevo» cuando el estado acompaña.</p>
    <p>El riesgo del grado B es la interpretación. «Marcas de uso leves» significa cosas muy distintas para dos vendedores. Pide fotos.</p>'),
    array('h2' => 'Grado C', 'html' =>
'    <p><b>Para piezas o reparación.</b> No funciona, está incompleto o está roto. Tiene mercado propio (talleres, gente que repara), pero no debería venderse dentro de un lote clasificado sin decirlo con todas las letras.</p>
    <p>Si compras un lote «grado B/C» sin más detalle, cuenta con que la C sea la mitad.</p>'),
    array('h2' => 'Sin clasificar', 'html' =>
'    <p>No es un grado: es la ausencia de clasificación. Nadie lo ha abierto, así que nadie sabe qué hay. Es una categoría legítima y honesta siempre que se venda por su nombre y con un precio que refleje el riesgo. Deja de serlo cuando alguien le llama «grado A sin abrir», que es una contradicción en sus propios términos.</p>'),
    array('h2' => 'Cómo saber si te están inflando el grado', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Pregunta qué entiende él por cada letra.</b> Si no sabe contestarte concretamente, no clasifica nada.</li>
      <li><b>Pide fotos del lote concreto</b>, no de catálogo. Un liquidador con mercancía real las tiene en dos minutos.</li>
      <li><b>Desconfía del grado A barato.</b> Grado A de verdad no se regala.</li>
      <li><b>Mira si hay mezcla declarada.</b> «A/B» es honesto. «A» a secas en un palé de 200 referencias es poco creíble.</li>
      <li><b>Pregunta qué hacen con lo que no funciona.</b> La respuesta te dice más que el resto de la conversación.</li>
    </ol>'),
  ),
  'faq' => array(
    array('p' => '¿Qué grado me conviene si estoy empezando?', 'r' => 'A/B clasificado. El A puro sale caro para aprender y el sin clasificar te va a enseñar a clasificar antes que a vender.'),
    array('p' => '¿Se puede vender grado B como nuevo?', 'r' => 'No. Es publicidad engañosa y es la vía más rápida a una reclamación. Se vende como lo que es, con fotos del estado real, y se vende igual de bien.'),
    array('p' => '¿Qué grado vendéis vosotros?', 'r' => 'A y A/B en los lotes clasificados, B donde lo decimos en la ficha. Grado C no lo vendemos en lotes: lo que no funciona no entra. El palé mixto va sin clasificar y lo avisamos.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'es-rentable-revender-devoluciones-de-amazon',
  'titulo' => '¿Es rentable revender devoluciones de Amazon? Las cuentas',
  'h1' => '¿Es rentable revender devoluciones?',
  'desc' => 'Las cuentas reales de revender devoluciones de Amazon: margen por lote, tiempo invertido, qué se lleva cada plataforma y cuándo no sale rentable.',
  'entradilla' => 'Con números en la mano: lo que entra, lo que sale, lo que se lleva cada plataforma y las horas que hay debajo. Incluye los casos en los que la respuesta es que no.',
  'img' => 'assets/img/lote-informatica.webp',
  'imgAlt' => 'Monitores, teclados y discos de un lote de informática, contados sobre la mesa',
  'fecha' => '2026-09-08', 'minutos' => 9,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Un ejemplo completo, de principio a fin', 'html' =>
'    <p>Lote de juguetes: 64 unidades, 319 € con IVA y transporte.</p>
    <table class="tabla">
      <thead><tr><th>Concepto</th><th>Importe</th></tr></thead>
      <tbody>
        <tr><td>Coste del lote</td><td>−319 €</td></tr>
        <tr><td>Material de envío (50 piezas × 1,20 €)</td><td>−60 €</td></tr>
        <tr><td>Venta: 50 piezas a 14 € de media</td><td>+700 €</td></tr>
        <tr><td>10 piezas vendidas en pack a 5 €</td><td>+50 €</td></tr>
        <tr><td>4 piezas que no se venden</td><td>0 €</td></tr>
        <tr><td><b>Resultado</b></td><td><b>+371 €</b></td></tr>
      </tbody>
    </table>
    <p>Un 116 % sobre lo invertido. Suena espectacular hasta que cuentas las horas: unas 6 de clasificar y fotografiar, unas 10 de publicar y responder, unas 6 de empaquetar y llevar a correos. 22 horas. Salen <b>16,8 € la hora</b>, que está bien pero no es dinero fácil.</p>'),
    array('h2' => 'Los tres números que deciden', 'html' =>
'    <ul>
      <li><b>Porcentaje de venta.</b> Cuántas piezas colocas de verdad. Por debajo del 70 % las cuentas se tuercen rápido.</li>
      <li><b>Precio medio real.</b> No el que pides: el que cobras después de negociar. Réstale un 15 % a lo que tenías en la cabeza.</li>
      <li><b>Velocidad.</b> Un lote vendido en un mes rinde el triple, en términos anuales, que el mismo lote vendido en tres.</li>
    </ul>'),
    array('h2' => 'Qué se lleva cada plataforma', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Canal</th><th>Coste</th><th>Ventaja</th></tr></thead>
      <tbody>
        <tr><td>Wallapop, venta en mano</td><td>0 %</td><td>Sin comisión ni envío. Lo más rentable.</td></tr>
        <tr><td>Wallapop con envío</td><td>Gastos de gestión del comprador</td><td>Mucho más alcance</td></tr>
        <tr><td>Vinted</td><td>Lo paga el comprador</td><td>El mejor sitio para textil</td></tr>
        <tr><td>Mercadillo</td><td>Coste del puesto</td><td>Rotación alta, cobro inmediato</td></tr>
        <tr><td>Marketplaces grandes</td><td>8-15 % + cuota</td><td>Volumen, pero el margen se estrecha</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Cuándo NO es rentable', 'html' =>
'    <p>Con honestidad, porque nos interesa que la segunda compra también la hagas:</p>
    <ul>
      <li><b>Si no tienes tiempo.</b> Es un negocio de horas manuales. Sin 10-15 horas semanales, no sale.</li>
      <li><b>Si no tienes espacio.</b> Alquilar trastero se come el margen entero de un lote pequeño.</li>
      <li><b>Si compras la categoría equivocada.</b> Vender textil sin saber de tallas o electrónica sin saber probarla acaba en stock parado.</li>
      <li><b>Si te da apuro negociar.</b> En segunda mano se regatea siempre. Quien no aguanta el regateo, malvende.</li>
      <li><b>Si necesitas el dinero ya.</b> Entre que compras y cobras pasan semanas. Esto no es liquidez.</li>
    </ul>'),
    array('h2' => 'Qué esperar de forma realista', 'html' =>
'    <p>Un lote clasificado bien trabajado deja entre un <b>40 % y un 120 %</b> sobre lo invertido, en un plazo de uno a tres meses. Un palé mixto puede dejar más, o puede dejar bastante menos: el riesgo es tuyo.</p>
    <p>Nadie te puede garantizar un beneficio, y quien te lo garantice te está vendiendo otra cosa. Lo que sí es cierto es que el descuento de origen es real: comprar a un 20 % del PVP te deja margen suficiente para equivocarte unas cuantas veces mientras aprendes.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto se tarda en vender un lote entero?', 'r' => 'Entre uno y tres meses con dedicación regular. Las primeras piezas se van en días; la cola larga es lo que tarda.'),
    array('p' => '¿Cuál es la categoría más rentable?', 'r' => 'En margen porcentual, moda. En euros por pieza, electrónica e informática. En facilidad para empezar, juguetes.'),
    array('p' => '¿Hay que pagar impuestos por revender?', 'r' => 'Si lo haces de forma habitual y con ánimo de lucro, sí. Lo explicamos en <a href="necesito-ser-autonomo-para-revender.html">esta guía</a>, y lo de siempre: consulta con un gestor antes de montarlo.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-revender-en-wallapop-y-vinted',
  'titulo' => 'Cómo revender un lote de devoluciones en Wallapop y Vinted',
  'h1' => 'Revender en Wallapop y Vinted',
  'desc' => 'Guía práctica para revender productos de un lote de devoluciones en Wallapop y Vinted: fotos, títulos, precios, envíos y cómo tratar el regateo.',
  'entradilla' => 'Lo que de verdad mueve una publicación: la foto, el título y el precio de salida. Y cómo llevar el regateo sin regalar el margen.',
  'img' => 'assets/img/lote-moda.webp',
  'imgAlt' => 'Prendas embolsadas con etiqueta listas para fotografiar y publicar',
  'fecha' => '2026-09-05', 'minutos' => 8,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Qué va a cada plataforma', 'html' =>
'    <p><b>Vinted</b> es de ropa, calzado y complementos. Punto. Meter ahí una freidora de aire es perder el tiempo. A cambio, para textil no hay nada mejor: el comprador paga el envío y la comisión, y el público está buscando exactamente eso.</p>
    <p><b>Wallapop</b> es de todo lo demás, y especialmente bueno para electrónica, informática, herramienta, deporte y puericultura. La venta en mano no tiene comisión, que es donde está el margen de verdad en piezas de menos de 30 €.</p>'),
    array('h2' => 'Las fotos, que es el 80 % del trabajo', 'html' =>
'    <ul>
      <li><b>Luz natural y fondo liso.</b> Una sábana blanca sobre la mesa y al lado de la ventana. No hace falta nada más.</li>
      <li><b>Cuatro fotos mínimo:</b> el producto entero, la marca o etiqueta, el detalle del defecto si lo hay, y todo lo que incluye junto.</li>
      <li><b>Enseña el defecto.</b> Parece que vende menos y vende más: evita devoluciones y genera confianza.</li>
      <li><b>Nada de fotos de catálogo.</b> Se nota, y la gente lo lee como que no tienes el producto.</li>
      <li><b>La primera foto decide.</b> Es la única que se ve en el listado. Que sea la más clara.</li>
    </ul>'),
    array('h2' => 'Títulos y descripciones que se encuentran', 'html' =>
'    <p>El título tiene que llevar <b>marca + modelo + lo que es + talla o medida</b>. «Auriculares» no lo encuentra nadie. «Auriculares inalámbricos JBL Tune 510BT azules» lo encuentra quien lo está buscando.</p>
    <p>En la descripción, tres líneas bastan: qué es, en qué estado está y qué incluye. Di siempre si es devolución de tienda y por qué está a ese precio. La transparencia vende en segunda mano.</p>'),
    array('h2' => 'Precio de salida y regateo', 'html' =>
'    <p>Mira qué piden otros por el mismo producto usado, no el PVP. Sal un 10-15 % por encima de lo que quieres cobrar: en segunda mano se regatea siempre, y si sales justo, acabas por debajo.</p>
    <p>Sobre las ofertas bajas: contesta siempre, aunque sea que no. Un «no, pero te lo dejo en X» cierra bastantes ventas. Y si algo lleva tres semanas sin una sola visita, no es el precio: es la foto o el título.</p>'),
    array('h2' => 'Ritmo de publicación', 'html' =>
'    <p>No publiques las 64 piezas el mismo día. Se hunden entre ellas y pierdes el impulso de la novedad. Diez o quince al día, y renueva las antiguas cuando la plataforma te lo permita.</p>
    <p>Los mejores momentos para publicar son por la tarde-noche entre semana y el domingo por la tarde. No es magia: es cuando la gente mira el móvil sin prisa.</p>'),
    array('h2' => 'Envíos sin perder dinero', 'html' =>
'    <p>Pesa y mide antes de publicar, y ten cajas de tres tamaños preparadas. Un envío mal calculado se come la venta entera de una pieza barata.</p>
    <p>Empaqueta bien: un producto que llega roto es una devolución, una valoración mala y el tiempo perdido de las dos partes. Y guarda el justificante hasta que el comprador confirme.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Puedo vender productos de devolución como nuevos?', 'r' => 'Sólo si están sin usar, y aun así di que vienen de devolución con caja abierta. Es lo honesto y además reduce las reclamaciones.'),
    array('p' => '¿Cuántas piezas se venden al mes?', 'r' => 'Con 60-80 anuncios activos y dedicación regular, entre 15 y 40. Depende muchísimo de la categoría y de la época del año.'),
    array('p' => '¿Merece la pena pagar por destacar anuncios?', 'r' => 'En piezas de más de 40 €, a veces. En piezas de 10 €, nunca: te comes el margen entero.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'errores-al-comprar-lotes-de-liquidacion',
  'titulo' => '10 errores al comprar lotes de liquidación (y cómo evitarlos)',
  'h1' => '10 errores al comprar lotes',
  'desc' => 'Los diez errores más habituales al comprar lotes de liquidación y devoluciones, por qué se cometen y cómo evitarlos antes de pagar.',
  'entradilla' => 'Los fallos que vemos repetirse en quien compra por primera vez. Ninguno es difícil de evitar: lo difícil es acordarse de mirarlos cuando tienes el lote delante.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Palés recién descargados esperando en el muelle',
  'fecha' => '2026-09-03', 'minutos' => 7,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Los diez', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Calcular con el PVP.</b> El PVP de catálogo no es lo que vas a cobrar. Calcula con precios de reventa reales del mismo producto usado, mirando lo que se pide hoy.</li>
      <li><b>Empezar por el palé mixto.</b> El precio por referencia es tentador y el trabajo por detrás es enorme. Empieza clasificado.</li>
      <li><b>Comprar una categoría que no sabes vender.</b> Si no distingues un taladro bueno de uno malo, no compres herramienta por mucho que salga barata.</li>
      <li><b>No preguntar por el transporte.</b> Dos lotes al mismo precio no cuestan lo mismo si uno lleva 120 € de porte detrás.</li>
      <li><b>Pagar por adelantado a un desconocido.</b> Contrarreembolso o pasarela. Bizum a un particular, jamás.</li>
      <li><b>No mirar dónde vas a descargar.</b> Un palé de 200 kg no se sube por una escalera.</li>
      <li><b>No contar tu tiempo.</b> Clasificar, fotografiar y enviar son horas. Si no las pones en la cuenta, el margen que calculas es ficticio.</li>
      <li><b>Malvender por impaciencia.</b> Bajar el precio a los cinco días porque «no se vende». La mayoría de piezas tardan de dos a seis semanas.</li>
      <li><b>Ignorar lo que no se vende.</b> Un 15-20 % en el mixto. Métele ese número a las cuentas desde el principio.</li>
      <li><b>Creerse lo de «portal oficial de Amazon».</b> No existe. Amazon no vende sus devoluciones al público.</li>
    </ol>'),
    array('h2' => 'El error que más caro sale', 'html' =>
'    <p>De todos, el peor es el quinto. Los demás te cuestan margen; ese te cuesta el dinero entero.</p>
    <p>El patrón de la estafa es siempre igual: precio muy por debajo del mercado, urgencia («me quedan dos palés»), sólo transferencia o Bizum, y fotos de catálogo. Cuando pagas, desaparecen. No hay nada que reclamar porque no hay empresa, ni factura, ni dirección.</p>
    <p>La vacuna cabe en una frase: <b>si no puedes pagar al recibirlo o con tarjeta, no compres</b>.</p>'),
    array('h2' => 'Una lista para antes de dar al botón', 'html' =>
'    <ul>
      <li>¿Sé cuántas unidades hay y de qué tipo?</li>
      <li>¿Sé qué grado tienen y qué entiende el vendedor por ese grado?</li>
      <li>¿El precio incluye IVA y transporte?</li>
      <li>¿Puedo pagar contrarreembolso o con tarjeta?</li>
      <li>¿Hay dirección física y CIF en algún sitio de la web?</li>
      <li>¿Tengo dónde ponerlo cuando llegue?</li>
      <li>¿Sé dónde voy a vender esto y a qué precio?</li>
    </ul>
    <p>Siete preguntas. Si alguna se queda sin respuesta, no es el lote.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cómo compruebo que un vendedor es real?', 'r' => 'Busca el CIF y la dirección en el aviso legal, comprueba que la dirección existe, pide fotos del almacén con fecha del día y propón contrarreembolso. Quien tiene mercancía dice que sí a las tres cosas.'),
    array('p' => '¿Qué hago si el lote no es lo que pedí?', 'r' => 'Fotos nada más abrirlo, reclamación por escrito al vendedor y, si pagaste con tarjeta, reclamación al banco. Con contrarreembolso, rechaza la entrega si ves el bulto dañado antes de pagar.'),
    array('p' => '¿Se puede negociar el precio de un lote?', 'r' => 'En una unidad suelta, poco. A partir de tres lotes o palés, casi siempre.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'necesito-ser-autonomo-para-revender',
  'titulo' => '¿Necesito ser autónomo para revender devoluciones?',
  'h1' => '¿Hace falta ser autónomo?',
  'desc' => 'Qué dice la normativa española sobre revender productos de segunda mano: cuándo hace falta darse de alta en Hacienda y en autónomos, y qué pasa si no lo haces.',
  'entradilla' => 'La pregunta que nos hacen más veces. La respuesta corta es «depende de si es habitual»; la larga está aquí, con la diferencia entre el alta en Hacienda y el alta en autónomos, que no son lo mismo.',
  'img' => 'assets/img/lote-herramientas.webp',
  'imgAlt' => 'Maletines y herramienta de un lote, etiquetados y listos para facturar',
  'fecha' => '2026-09-01', 'minutos' => 7,
  'tema' => 'Legal',
  'bloques' => array(
    array('h2' => 'Antes de nada', 'html' =>
'    <p class="aviso-honesto"><b>Esto no es asesoramiento fiscal.</b> Somos un liquidador, no una gestoría. Lo que sigue es el marco general y lo que nos cuentan los clientes que ya están dados de alta. Antes de montar nada, habla con un gestor: cuesta poco y te ahorra sustos.</p>'),
    array('h2' => 'Vender lo tuyo no es lo mismo que revender', 'html' =>
'    <p>Vaciar el armario en Wallapop no es una actividad económica: vendes bienes usados propios, normalmente por debajo de lo que te costaron, y no hay ánimo de lucro. Nadie te va a pedir nada por eso.</p>
    <p>Comprar un lote para venderlo por piezas sí es otra cosa. Hay compra para revender, hay margen buscado y, si lo haces todos los meses, hay habitualidad. Eso es una actividad económica en toda regla.</p>'),
    array('h2' => 'Dos altas distintas que se confunden', 'html' =>
'    <h3>Alta en Hacienda (modelo 036 o 037)</h3>
    <p>Es la declaración censal: le dices a Hacienda que vas a ejercer una actividad y en qué epígrafe. A partir de ahí, facturas con IVA, presentas las declaraciones trimestrales que te correspondan y deduces tus gastos, incluida la compra de los lotes. Si hay actividad económica, esta alta se da, sin discusión.</p>
    <h3>Alta en autónomos (RETA)</h3>
    <p>Es la cotización a la Seguridad Social. Aquí es donde está el debate: la ley pide alta cuando la actividad es habitual, personal y directa, y ha habido sentencias que han considerado que por debajo de ciertos ingresos no hay habitualidad. Pero no es una regla escrita ni automática, y no te protege de una inspección por sí sola.</p>
    <p>La lectura prudente: si esto va a ser un ingreso recurrente, cuenta con las dos altas. Y si sólo vas a hacer una compra puntual para probar, habla con un gestor antes de decidir.</p>'),
    array('h2' => 'Qué te da estar dado de alta', 'html' =>
'    <ul>
      <li><b>Deduces la compra.</b> El lote, el material de envío, parte del móvil y del coche si los usas para esto.</li>
      <li><b>Recuperas el IVA soportado</b> de tus compras, que en un lote de 600 € no es poca cosa.</li>
      <li><b>Puedes facturar a empresas</b>, que es donde están los pedidos grandes.</li>
      <li><b>Cotizas.</b> Suena a gasto y es un gasto, pero es paro, baja y jubilación.</li>
      <li><b>Duermes tranquilo.</b> Que no es un argumento menor.</li>
    </ul>'),
    array('h2' => 'Qué pasa si no te das de alta', 'html' =>
'    <p>El riesgo real es una sanción con recargo y el pago de las cuotas atrasadas. Las plataformas de venta, además, comunican a la Administración los datos de los vendedores que superan ciertos umbrales de operaciones al año: la idea de que «esto no lo ve nadie» ya no se sostiene.</p>
    <p>No lo decimos para asustar. Lo decimos porque la gente que planta el negocio bien desde el principio es la que sigue en pie al segundo año.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Puedo comprar un lote sin ser autónomo?', 'r' => 'Sí. Comprar puede cualquier particular. La obligación aparece por revender de forma habitual, no por comprar.'),
    array('p' => '¿Me hacéis factura si soy particular?', 'r' => 'Sí, siempre, con el IVA desglosado. Si luego te das de alta, esa factura te sirve para deducir la compra.'),
    array('p' => '¿Qué epígrafe de IAE corresponde?', 'r' => 'Depende de qué vendas y cómo. Suele ir por comercio al por menor de artículos varios o por comercio a distancia, pero eso te lo tiene que decir un gestor mirando tu caso.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-calcular-el-margen-de-un-lote',
  'titulo' => 'Cómo calcular el margen de un lote antes de comprarlo',
  'h1' => 'Calcular el margen de un lote',
  'desc' => 'Método paso a paso para calcular si un lote de devoluciones va a ser rentable antes de pagarlo, con la fórmula y un ejemplo completo.',
  'entradilla' => 'Un método de quince minutos para saber si un lote sale a cuenta antes de pagarlo. Con la fórmula, el ejemplo hecho y los tres números que casi todo el mundo se deja fuera.',
  'img' => 'assets/img/lote-belleza.webp',
  'imgAlt' => 'Secadores, planchas y depiladoras de un lote de belleza, contados sobre la mesa',
  'fecha' => '2026-08-28', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'La fórmula', 'html' =>
'    <p class="formula">Margen = (Unidades × % que se vende × Precio medio real) − Coste total</p>
    <p>Donde <b>coste total</b> es el precio del lote más el material de envío más tu tiempo valorado a un precio por hora. Los tres factores de la izquierda son estimaciones tuyas, y ahí está todo el arte.</p>'),
    array('h2' => 'Paso 1: el precio medio real', 'html' =>
'    <p>No mires el PVP. Abre la plataforma donde vayas a vender, busca cinco productos parecidos a los del lote y mira <b>lo que se está pidiendo hoy por ellos usados</b>. Quédate con la mediana, no con la media: un anuncio disparatado te distorsiona el número.</p>
    <p>Después réstale un 15 %. Ese es el descuento del regateo, y se lo van a pedir.</p>'),
    array('h2' => 'Paso 2: el porcentaje que se vende', 'html' =>
'    <ul>
      <li>Lote clasificado de categoría que dominas: <b>80-85 %</b></li>
      <li>Lote clasificado de categoría nueva para ti: <b>65-75 %</b></li>
      <li>Palé mixto sin clasificar: <b>60-70 %</b></li>
    </ul>
    <p>Si te sale rentable con el número bajo de la horquilla, el lote es bueno. Si sólo sale con el alto, es un lote ajustado y cualquier imprevisto te lo come.</p>'),
    array('h2' => 'Paso 3: los costes que se olvidan', 'html' =>
'    <ul>
      <li><b>Material de envío:</b> 0,80-1,50 € por pieza si vendes online.</li>
      <li><b>Tu tiempo:</b> entre 15 y 25 horas por lote de 60 unidades. Ponle un precio, aunque sea 10 € la hora.</li>
      <li><b>Comisiones</b> de plataforma donde las haya.</li>
      <li><b>Devoluciones:</b> cuenta un 5 % de las ventas online.</li>
      <li><b>Almacenaje</b> si lo pagas.</li>
    </ul>'),
    array('h2' => 'Ejemplo completo', 'html' =>
'    <p>Lote de belleza: 52 unidades, 389 €.</p>
    <table class="tabla">
      <thead><tr><th>Concepto</th><th>Cálculo</th><th>Importe</th></tr></thead>
      <tbody>
        <tr><td>Ingresos previstos</td><td>52 × 75 % × 22 €</td><td>+858 €</td></tr>
        <tr><td>Coste del lote</td><td>—</td><td>−389 €</td></tr>
        <tr><td>Material de envío</td><td>39 × 1,20 €</td><td>−47 €</td></tr>
        <tr><td>Tiempo</td><td>18 h × 10 €</td><td>−180 €</td></tr>
        <tr><td>Devoluciones</td><td>5 % de 858 €</td><td>−43 €</td></tr>
        <tr><td><b>Margen</b></td><td></td><td><b>+199 €</b></td></tr>
      </tbody>
    </table>
    <p>199 € de beneficio limpio sobre 389 € invertidos, con el tiempo ya pagado. Un 51 %. Sin contar el tiempo serían 379 € y un 97 %, que es el número que suele enseñarse por ahí. Los dos son ciertos; sólo uno es honesto.</p>'),
    array('h2' => 'La regla rápida', 'html' =>
'    <p>Si no quieres hacer la tabla: <b>un lote sale a cuenta si el precio medio de reventa multiplicado por la mitad de las unidades supera el doble del precio del lote.</b> Es conservador a propósito. Si pasa ese filtro, haz la tabla. Si no lo pasa, no la hagas.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Qué margen es aceptable?', 'r' => 'Por debajo del 40 % sobre lo invertido, con el tiempo contado, no compensa el trabajo. Entre 40 % y 120 % es lo normal en un lote bien trabajado.'),
    array('p' => '¿Y si no sé a cuánto se vende lo que hay dentro?', 'r' => 'Entonces todavía no compres ese lote. Quince minutos buscando precios de reventa te ahorran cientos de euros parados en el salón.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'donde-vender-los-productos-de-un-lote',
  'titulo' => 'Dónde vender los productos de un lote de devoluciones',
  'h1' => 'Dónde vender un lote',
  'desc' => 'Los canales para vender productos de un lote de devoluciones en España: Wallapop, Vinted, mercadillos, tiendas y marketplaces, con sus pros y sus contras.',
  'entradilla' => 'Cada canal tiene su producto y su ritmo. Aquí están todos, con lo que se lleva cada uno y qué tipo de pieza coloca mejor.',
  'img' => 'assets/img/lote-juguetes.webp',
  'imgAlt' => 'Juguetes clasificados y separados por tipo para fotografiar',
  'fecha' => '2026-08-25', 'minutos' => 7,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Resumen rápido', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Canal</th><th>Mejor para</th><th>Coste</th><th>Ritmo</th></tr></thead>
      <tbody>
        <tr><td>Wallapop</td><td>Electrónica, herramienta, deporte, bebé</td><td>0 % en mano</td><td>Medio</td></tr>
        <tr><td>Vinted</td><td>Ropa, calzado, complementos</td><td>Lo paga el comprador</td><td>Medio-alto</td></tr>
        <tr><td>Mercadillo</td><td>Volumen, precio bajo, juguete y textil</td><td>Puesto</td><td>Alto</td></tr>
        <tr><td>Tiendas de barrio</td><td>Lotes enteros de una categoría</td><td>0 %</td><td>Muy alto</td></tr>
        <tr><td>Marketplaces grandes</td><td>Producto con marca y modelo claros</td><td>8-15 % + cuota</td><td>Alto</td></tr>
        <tr><td>Grupos locales</td><td>Voluminoso que no quieres enviar</td><td>0 %</td><td>Bajo</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'La estrategia que mejor funciona', 'html' =>
'    <p>No es elegir un canal: es <b>escalonarlos</b>.</p>
    <ol class="pasos-lista">
      <li><b>Primero, lo bueno al canal que mejor paga.</b> Las piezas de más valor a Wallapop o al marketplace, con foto cuidada y precio firme.</li>
      <li><b>Después, el grueso al canal de volumen.</b> Lo de precio medio, a la plataforma que corresponda por categoría.</li>
      <li><b>Al mes, lo que no se ha movido, en packs.</b> Tres piezas a precio de dos.</li>
      <li><b>A los dos meses, al mercadillo o a una tienda.</b> Aunque sea a precio de coste: el stock parado ocupa sitio y ya te dio el margen el resto del lote.</li>
    </ol>
    <p>El error clásico es aguantar el precio de lo que no se vende. Lo que no se vendió en dos meses no se va a vender en seis al mismo precio.</p>'),
    array('h2' => 'Vender a tiendas: el canal olvidado', 'html' =>
'    <p>Es el que menos gente usa y el que más rápido vacía un lote. Una tienda de barrio, una juguetería pequeña, una ferretería: gente que compra lotes enteros de una categoría con una sola conversación.</p>
    <p>Pagan menos por pieza, obviamente. Pero no fotografías, no publicas, no respondes mensajes, no empaquetas y no gestionas devoluciones. Si valoras tu tiempo a 10 € la hora, muchas veces sale mejor que vender unidad por unidad.</p>
    <p>Cómo se hace: te presentas con una caja de muestra, un precio por lote y la factura de tu compra para que vean que hay origen. No con un correo.</p>'),
    array('h2' => 'Mercadillos', 'html' =>
'    <p>Para volumen y precio bajo no hay nada mejor: cobras en el momento, no hay devoluciones y vacías stock rápido. A cambio, madrugas, montas, aguantas el día y pagas el puesto.</p>
    <p>Funciona muy bien con juguete, textil y menaje. Funciona mal con electrónica de cierto valor: la gente no se gasta 60 € en un puesto sin garantía.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Puedo vender en varios sitios a la vez?', 'r' => 'Sí, y es lo recomendable. Lo único: lleva la cuenta de lo que se vende para no cobrar dos veces la misma pieza.'),
    array('p' => '¿Cómo vendo lo que nadie quiere?', 'r' => 'En packs por categoría a precio de saldo, o de golpe a un puesto de mercadillo. Lo que no tiene salida a ningún precio, a punto limpio: ocupar sitio también cuesta dinero.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'estafas-con-devoluciones-de-amazon',
  'titulo' => 'Estafas con devoluciones de Amazon: cómo detectarlas',
  'h1' => 'Estafas con devoluciones',
  'desc' => 'Las estafas más habituales al comprar devoluciones y palés de Amazon en España, las señales de alarma y qué hacer si ya has pagado.',
  'entradilla' => 'Las cinco estafas que se repiten en el sector, las señales que las delatan antes de pagar y qué se puede hacer cuando ya se ha pagado.',
  'img' => 'assets/img/lote-deporte.webp',
  'imgAlt' => 'Palé de material deportivo precintado en el muelle, con su etiqueta a la vista',
  'fecha' => '2026-08-20', 'minutos' => 6,
  'tema' => 'Seguridad',
  'bloques' => array(
    array('h2' => 'Las cinco que se repiten', 'html' =>
'    <h3>1. El palé que no existe</h3>
    <p>Precio muy por debajo del mercado, urgencia, pago por transferencia o Bizum, y silencio después. Es la más común y la más difícil de recuperar.</p>
    <h3>2. El falso «portal oficial de Amazon»</h3>
    <p>Web con logo, tipografía y colores de Amazon, y un dominio que no es amazon.es. <b>Amazon no vende sus devoluciones al público.</b> Si alguien dice ser el portal oficial, ya sabes lo que es.</p>
    <h3>3. El grado inflado</h3>
    <p>Se vende como grado A lo que es grado C. Llega mercancía rota. Esta no siempre es estafa penal, a veces es publicidad engañosa, pero el dinero se pierde igual.</p>
    <h3>4. El porte sorpresa</h3>
    <p>Precio atractivo, y al confirmar aparecen 150 € de transporte «por el peso». Pregúntalo siempre antes.</p>
    <h3>5. La suscripción de acceso</h3>
    <p>Te cobran una cuota mensual por «acceso a subastas exclusivas de liquidación». Lo que hay detrás son enlaces públicos. El producto que venden es la cuota.</p>'),
    array('h2' => 'Señales de alarma', 'html' =>
'    <ul>
      <li>No hay CIF ni dirección física en el aviso legal.</li>
      <li>Sólo aceptan transferencia o Bizum, nunca contrarreembolso ni tarjeta.</li>
      <li>Todas las fotos son de catálogo; ninguna del almacén.</li>
      <li>El precio está más de un 40 % por debajo del mercado.</li>
      <li>Meten prisa: «quedan dos», «hoy acaba la oferta».</li>
      <li>El dominio se registró hace tres semanas.</li>
      <li>Usan marcas ajenas como si fueran suyas.</li>
      <li>No tienen teléfono, sólo un formulario.</li>
    </ul>
    <p>Una sola señal no condena a nadie. Tres juntas, sí.</p>'),
    array('h2' => 'Cómo comprobarlo en cinco minutos', 'html' =>
'    <ol class="pasos-lista">
      <li>Busca el CIF en el aviso legal y comprueba que la empresa existe.</li>
      <li>Mira la dirección en un mapa. ¿Es una nave o es un piso?</li>
      <li>Llama por teléfono. Que conteste alguien ya dice mucho.</li>
      <li>Pide una foto del palé concreto con la fecha del día escrita en un papel.</li>
      <li>Propón contrarreembolso. La respuesta te lo aclara todo.</li>
    </ol>'),
    array('h2' => 'Si ya has pagado', 'html' =>
'    <ul>
      <li><b>Con tarjeta:</b> reclama al banco cuanto antes. Es la vía con más posibilidades.</li>
      <li><b>Con Bizum o transferencia:</b> avisa a tu banco igualmente, aunque la recuperación es difícil.</li>
      <li><b>Denuncia</b> en Policía Nacional o Guardia Civil con todas las capturas, el anuncio y el justificante de pago.</li>
      <li><b>Reclama en consumo</b> si el vendedor es una empresa identificable.</li>
      <li><b>Cuéntalo.</b> En foros y grupos del sector. Es lo que evita que le pase al siguiente.</li>
    </ul>'),
    array('h2' => 'Y de nosotros, ¿cómo te fías?', 'html' =>
'    <p>Con las mismas preguntas. Nuestro aviso legal tiene CIF y dirección. La nave está en el Polígono Mas Xirgu de Girona y puedes venir a verla de lunes a viernes de 8:00 a 18:00. Aceptamos contrarreembolso, que es pagar cuando el paquete ya está delante de ti. Las fotos son de nuestro almacén. Y decimos en cada ficha lo que puede salir mal, incluido que el palé mixto no admite devolución.</p>
    <p>No somos un portal oficial de Amazon ni lo hemos dicho nunca: somos un liquidador independiente. Si alguna vez leyeras lo contrario en esta web, sería un error nuestro y habría que corregirlo.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Amazon tiene un portal oficial de devoluciones?', 'r' => 'No para el público. Amazon liquida su mercancía a empresas por camiones completos. Cualquier web que se presente como portal oficial no lo es.'),
    array('p' => '¿Es seguro el contrarreembolso?', 'r' => 'Es la forma más segura de comprar a alguien que no conoces: pagas con el bulto delante y puedes rechazarlo si llega dañado. Lo que no cubre es el contenido, así que abre y revisa nada más pagar.'),
    array('p' => '¿Puedo pedir factura antes de pagar?', 'r' => 'Puedes pedir los datos fiscales del vendedor antes de comprar, y un vendedor legítimo te los da sin problema.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'primera-compra-lista-de-comprobacion',
  'titulo' => 'Tu primera compra de devoluciones: lista de comprobación',
  'h1' => 'Tu primera compra, paso a paso',
  'desc' => 'Lista de comprobación para la primera compra de un lote de devoluciones: antes de pedir, al recibirlo y las dos primeras semanas de venta.',
  'entradilla' => 'Una lista para imprimir y tachar: qué mirar antes de pedir, qué hacer el día que llega la caja y cómo organizar las dos primeras semanas.',
  'img' => 'assets/img/lote-bebe.webp',
  'imgAlt' => 'Sillas de coche, carrito y trona de un lote de puericultura ya revisado',
  'fecha' => '2026-08-15', 'minutos' => 5,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Antes de pedir', 'html' =>
'    <ul class="lista-check">
      <li>Tengo claro <b>dónde voy a vender</b> y he mirado precios de reventa reales.</li>
      <li>He elegido una categoría que <b>sé valorar</b>.</li>
      <li>El precio incluye <b>IVA y transporte</b>, y lo he confirmado.</li>
      <li>Puedo pagar <b>contrarreembolso o con tarjeta</b>.</li>
      <li>Sé <b>cuántas unidades</b> vienen y de qué grado.</li>
      <li>Tengo <b>sitio</b> para lo que llega (y para lo que no se venda el primer mes).</li>
      <li>He hecho la <a href="como-calcular-el-margen-de-un-lote.html">cuenta del margen</a> con el escenario pesimista.</li>
      <li>Empiezo por un <b>lote clasificado</b>, no por un palé mixto.</li>
    </ul>'),
    array('h2' => 'El día que llega', 'html' =>
'    <ul class="lista-check">
      <li><b>Revisa el bulto antes de pagar</b> si es contrarreembolso. Si está reventado, recházalo.</li>
      <li><b>Haz fotos del embalaje cerrado</b> antes de abrirlo. Dos minutos que valen oro si hay reclamación.</li>
      <li><b>Cuenta las unidades</b> y contrástalas con lo que decía la ficha.</li>
      <li><b>Separa en tres montones:</b> vende solo / necesita trabajo / no sirve.</li>
      <li><b>Prueba lo eléctrico</b> antes de fotografiar nada.</li>
      <li><b>Formatea</b> cualquier cosa con memoria.</li>
      <li>Si algo no cuadra, <b>reclama esa misma semana</b>. Después es tarde.</li>
    </ul>'),
    array('h2' => 'Las dos primeras semanas', 'html' =>
'    <ul class="lista-check">
      <li><b>Fotografía en tandas</b> por categoría, todo del tirón, con la misma luz.</li>
      <li><b>Publica 10-15 al día</b>, no todo el primer día.</li>
      <li><b>Empieza por las piezas de más valor</b>, con mejor foto y descripción.</li>
      <li><b>Responde en menos de una hora.</b> Es lo que más vende de todo.</li>
      <li><b>Apunta lo que vendes y a cuánto.</b> Vale una libreta.</li>
      <li><b>No bajes precios la primera semana.</b> Ten paciencia.</li>
      <li>A los 15 días, <b>revisa lo que no tiene visitas</b>: es la foto o el título, casi nunca el precio.</li>
    </ul>'),
    array('h2' => 'Al mes: las cuentas de verdad', 'html' =>
'    <p>Suma lo cobrado, resta el lote y el material, divide por las horas que le has metido. Ese número, por bajo que salga, es tu punto de partida real. La segunda compra va a ir mejor: sabes qué se vende, cuánto tardas y a qué precio.</p>
    <p>Y si el número sale mal, ya sabes lo que hay que cambiar: la categoría, el canal o el precio de salida. Casi nunca es el lote.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto tardo en recuperar la inversión?', 'r' => 'Entre tres y seis semanas de venta constante en un lote clasificado. Las primeras piezas caen en días.'),
    array('p' => '¿Y si me arrepiento nada más abrirlo?', 'r' => 'Tienes 14 días de desistimiento en compras a distancia, con el lote completo y en el mismo estado, salvo en el palé mixto, que se vende cerrado y lo avisamos en la ficha.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'liquidacion-de-stock-que-es',
  'titulo' => 'Qué es la liquidación de stock y por qué existe',
  'h1' => 'Qué es la liquidación de stock',
  'desc' => 'Qué es el stock de liquidación, de dónde sale, por qué las plataformas prefieren venderlo con descuento y qué papel juegan los liquidadores.',
  'entradilla' => 'La cadena completa: del cliente que devuelve al camión que acaba en una nave de Girona. Entender por qué existe este mercado ayuda a comprar mejor dentro de él.',
  'img' => 'assets/img/lote-hogar-cocina.webp',
  'imgAlt' => 'Freidoras, batidoras y cafeteras de un lote de pequeño electrodoméstico',
  'fecha' => '2026-08-10', 'minutos' => 6,
  'tema' => 'Sector',
  'bloques' => array(
    array('h2' => 'La cadena, de principio a fin', 'html' =>
'    <ol class="pasos-lista">
      <li><b>El cliente devuelve.</b> Entre un 15 y un 30 % de lo que se compra online se devuelve, según la categoría. En moda, más.</li>
      <li><b>Llega al centro logístico.</b> Se comprueba que es lo que dice ser y se le da salida.</li>
      <li><b>Se decide qué hacer con ello.</b> Y aquí está la clave: revisar, reembalar y recatalogar cuesta más que el margen del producto en buena parte de los casos.</li>
      <li><b>Se agrupa y se vende por peso.</b> Camiones completos a empresas liquidadoras, por categoría y grado aproximado.</li>
      <li><b>El liquidador lo abre o no lo abre.</b> Ahí se separa el que clasifica del que revende el camión tal cual.</li>
      <li><b>Llega al comprador final.</b> Lote, palé o unidad suelta.</li>
    </ol>'),
    array('h2' => 'Por qué no se revende sin más', 'html' =>
'    <p>Parece absurdo tirar valor. No lo es, y la razón es puramente económica: el coste de manipular una unidad devuelta (recibirla, abrirla, probarla, limpiarla, reembalarla, fotografiarla, catalogarla, almacenarla) puede rondar varios euros. En productos con margen estrecho, ese coste se come el producto entero.</p>
    <p>Para la plataforma es más rentable venderlo a 20 céntimos el kilo y olvidarse. Para el liquidador, que tiene una estructura de costes muy distinta, sí compensa hacer ese trabajo. Esa diferencia de estructura es todo el negocio.</p>'),
    array('h2' => 'Qué no es stock de liquidación', 'html' =>
'    <ul>
      <li><b>No es producto defectuoso por definición.</b> Buena parte está sin estrenar.</li>
      <li><b>No es falsificación.</b> Es producto original que pasó por el catálogo.</li>
      <li><b>No es robado.</b> Se compra con factura a mayoristas identificados, y esa factura tiene que existir.</li>
      <li><b>No es caducado.</b> No trabajamos con alimentación ni con cosmética abierta.</li>
    </ul>
    <p>Si alguien te ofrece stock sin factura ni trazabilidad, no es liquidación: es otra cosa, y no te conviene.</p>'),
    array('h2' => 'Dónde encaja quien compra', 'html' =>
'    <p>Al final de la cadena hay tres perfiles: el que revende por piezas (la mayoría), la tienda que repone stock barato, y el particular que compra para uso propio porque le sale a mitad de precio.</p>
    <p>Los tres compran lo mismo y les sirve por motivos distintos. Lo único que no funciona es comprar sin saber a cuál de los tres perteneces: de ahí salen los lotes parados en el salón.</p>'),
  ),
  'faq' => array(
    array('p' => '¿El stock de liquidación tiene garantía?', 'r' => 'Como vendedor profesional respondemos de que lo entregado sea conforme a lo descrito. La garantía del fabricante no aplica igual en producto de liquidación, y por eso el precio es el que es. Lo que sí tienes es el derecho de desistimiento de 14 días, salvo en el palé mixto.'),
    array('p' => '¿De dónde sale exactamente vuestro stock?', 'r' => 'De camiones de devoluciones y excedentes que compramos con factura a mayoristas del sector. La mayor parte tiene origen Amazon; también entra excedente de otros distribuidores. El origen pieza a pieza no se puede certificar y no vamos a decir que sí.'),
  ),
);


/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'cuanto-se-gana-revendiendo-devoluciones',
  'titulo' => 'Cuánto se gana revendiendo devoluciones: cifras reales',
  'h1' => 'Cuánto se gana revendiendo',
  'desc' => 'Cuánto se gana de verdad revendiendo devoluciones: beneficio por lote, por hora y al mes, con los tres escenarios y los gastos que casi nadie cuenta.',
  'entradilla' => 'Tres escenarios con números: el que dedica cinco horas a la semana, el que dedica veinte y el que vive de esto. Con los gastos dentro, incluido el tiempo.',
  'img' => 'assets/img/lote-jardin.webp',
  'imgAlt' => 'Palé de jardín y exterior recién descargado, pendiente de clasificar',
  'fecha' => '2026-09-16', 'minutos' => 9,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Los tres escenarios', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Ocasional</th><th>En serio</th><th>A tiempo completo</th></tr></thead>
      <tbody>
        <tr><td>Horas a la semana</td><td>5</td><td>20</td><td>45</td></tr>
        <tr><td>Lotes al mes</td><td>0,5</td><td>2</td><td>6</td></tr>
        <tr><td>Invertido al mes</td><td>200 €</td><td>800 €</td><td>2.800 €</td></tr>
        <tr><td>Ingresos al mes</td><td>420 €</td><td>1.750 €</td><td>6.000 €</td></tr>
        <tr><td>Gastos (envío, comisiones)</td><td>−60 €</td><td>−240 €</td><td>−900 €</td></tr>
        <tr><td><b>Beneficio antes de impuestos</b></td><td><b>160 €</b></td><td><b>710 €</b></td><td><b>2.300 €</b></td></tr>
        <tr><td>Por hora</td><td>8 €</td><td>8,90 €</td><td>12,80 €</td></tr>
      </tbody>
    </table>
    <p>Lo primero que salta a la vista: el beneficio por hora apenas mejora hasta que entras en volumen. Esto es un negocio de escala, no de margen por pieza.</p>'),
    array('h2' => 'De dónde sale cada número', 'html' =>
'    <p><b>Ingresos.</b> Un lote de 400 € bien trabajado devuelve entre 700 y 900 € vendiendo el 75-80 % de las piezas. Hemos usado 875 € por lote, que es la parte media de la horquilla.</p>
    <p><b>Gastos.</b> Material de envío a 1,20 € por pieza enviada, más comisiones donde las hay. No incluye el alquiler de espacio: si pagas trastero, réstale entre 60 y 120 € al mes.</p>
    <p><b>Impuestos.</b> Los números son ANTES de impuestos. Si estás dado de alta, réstale la cuota de autónomos y el IRPF que te corresponda. Esa diferencia se nota mucho en la columna «ocasional» y poco en la de tiempo completo.</p>'),
    array('h2' => 'Por qué el escenario ocasional casi nunca compensa', 'html' =>
'    <p>160 € al mes por cinco horas semanales suena razonable hasta que sumas la cuota de autónomos. Si tienes que darte de alta para ingresar eso, el negocio se queda en nada o en negativo.</p>
    <p>Por eso lo honesto es decirlo: esto funciona como complemento cuando ya estás dado de alta por otra cosa, o cuando subes a la columna del medio. Entre medias hay una zona muerta que es donde la gente lo deja.</p>'),
    array('h2' => 'Lo que cambia el resultado de verdad', 'html' =>
'    <ol class="pasos-lista">
      <li><b>La velocidad de venta.</b> Un lote colocado en un mes rinde el triple, en términos anuales, que el mismo lote en tres.</li>
      <li><b>El porcentaje que se vende.</b> Pasar del 70 % al 85 % es más de 100 € por lote sin invertir un euro más.</li>
      <li><b>El canal.</b> Vender en mano no tiene comisión ni envío. En piezas de menos de 20 €, es la diferencia entre ganar y no ganar.</li>
      <li><b>La categoría.</b> El margen porcentual más alto es la moda; los euros por pieza más altos, la informática.</li>
      <li><b>La época.</b> Septiembre a diciembre vale por los otros ocho meses en juguete y regalo.</li>
    </ol>'),
    array('h2' => 'Los gastos que casi nadie cuenta', 'html' =>
'    <ul>
      <li><b>Tu tiempo.</b> Si no lo pones en la cuenta, el beneficio que calculas no existe.</li>
      <li><b>Lo que no se vende.</b> Entre el 15 y el 30 % según lote y categoría.</li>
      <li><b>Las devoluciones.</b> Un 5 % de las ventas online, con el envío de vuelta a tu cargo si el motivo no es culpa del comprador.</li>
      <li><b>El espacio.</b> Un trastero pequeño son 60-100 € al mes. Un lote de moda ocupa media habitación.</li>
      <li><b>Los desplazamientos.</b> Correos, punto de recogida, entregas en mano. Gasolina y tiempo.</li>
    </ul>'),
  ),
  'faq' => array(
    array('p' => '¿Se puede vivir de revender devoluciones?', 'r' => 'Hay gente que vive de esto, con volumen, local y varios canales a la vez. Como sustituto de un sueldo el primer año, no. Como complemento, funciona mejor.'),
    array('p' => '¿Cuánto se tarda en recuperar la inversión de un lote?', 'r' => 'Entre tres y seis semanas de venta constante en un lote clasificado.'),
    array('p' => '¿Y si solo quiero comprar para mí?', 'r' => 'Entonces el cálculo es otro y mucho más simple: si el contenido del lote vale para ti más de lo que pagas, ya has ganado. Mucha gente lo compra entre dos o tres y se lo reparte.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'donde-comprar-palets-de-devoluciones-en-espana',
  'titulo' => 'Dónde comprar palés de devoluciones en España',
  'h1' => 'Dónde comprar palés en España',
  'desc' => 'Los cuatro sitios donde se compran palés de devoluciones en España, qué pedir a cada uno y cómo comprobar que un proveedor es real antes de pagar.',
  'entradilla' => 'Los cuatro caminos que hay, con sus precios y sus riesgos, y la lista de cinco comprobaciones que separa a un liquidador real de un anuncio.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Nave de liquidación con palés clasificados en estanterías',
  'fecha' => '2026-09-14', 'minutos' => 7,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Los cuatro caminos', 'html' =>
'    <h3>1. Liquidadores con nave propia</h3>
    <p>Compran camiones, clasifican y venden lotes y palés. Precio medio, riesgo bajo, y puedes ir a verlo. Es lo que somos nosotros y lo que recomendamos para empezar.</p>
    <h3>2. Plataformas de subasta B2B</h3>
    <p>Subastas de lotes de grandes distribuidores. Precios que pueden ser muy buenos, pero necesitas CIF, sumar el transporte aparte y saber pujar. No es un sitio para la primera compra.</p>
    <h3>3. Mayoristas de importación</h3>
    <p>Grandes volúmenes, a veces contenedores. Precio por kilo muy bajo y mercancía sin clasificar de origen variado. Para quien ya mueve palés al mes.</p>
    <h3>4. Anuncios sueltos en redes y portales</h3>
    <p>Donde están las gangas y también casi todas las estafas. Si compras aquí, exige contrarreembolso y fotos con fecha del día. Sin las dos cosas, no compres.</p>'),
    array('h2' => 'Precios de referencia en España', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Origen</th><th>Precio por palé</th><th>Transporte</th><th>Riesgo</th></tr></thead>
      <tbody>
        <tr><td>Liquidador con nave</td><td>500 - 1.500 €</td><td>Suele ir incluido</td><td>Bajo</td></tr>
        <tr><td>Subasta B2B</td><td>300 - 1.200 €</td><td>Aparte, 80-150 €</td><td>Medio</td></tr>
        <tr><td>Mayorista importación</td><td>250 - 900 €</td><td>Aparte</td><td>Alto</td></tr>
        <tr><td>Anuncio suelto</td><td>100 - 600 €</td><td>Depende</td><td>Muy alto</td></tr>
      </tbody>
    </table>
    <p>Ojo con comparar precios sin el transporte dentro. Dos palés «al mismo precio» no lo están si uno lleva 120 € de porte por detrás.</p>'),
    array('h2' => 'Las cinco comprobaciones antes de pagar', 'html' =>
'    <ol class="pasos-lista">
      <li><b>CIF y dirección en el aviso legal.</b> Y que la dirección exista en un mapa y sea una nave, no un piso.</li>
      <li><b>Teléfono que descuelga.</b> Parece poco y filtra muchísimo.</li>
      <li><b>Foto del palé concreto con la fecha del día</b> escrita en un papel. Quien tiene mercancía la manda en dos minutos.</li>
      <li><b>Contrarreembolso o tarjeta.</b> Si sólo aceptan Bizum o transferencia, no hay a quién reclamar.</li>
      <li><b>Factura con IVA.</b> Pídela antes de comprar, no después.</li>
    </ol>'),
    array('h2' => 'Comprar fuera de España', 'html' =>
'    <p>Hay palés más baratos en Alemania, Países Bajos y Polonia, que es donde están los grandes centros logísticos. El precio compensa a partir de camión completo; para un palé suelto, el transporte internacional se come la diferencia.</p>
    <p>Súmale que las devoluciones de esos mercados vienen con manuales y enchufes de su país, y que la reclamación a distancia es mucho más complicada. Para empezar, España.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Se puede comprar directamente a Amazon?', 'r' => 'No. Amazon liquida por camiones completos a empresas con contrato; no vende palés sueltos al público. Quien diga lo contrario miente.'),
    array('p' => '¿Qué es un palé manifestado?', 'r' => 'Uno que viene con listado de referencias y PVP. Vale más que uno a ciegas porque puedes calcular antes de comprar, pero el manifiesto tampoco garantiza el estado.'),
    array('p' => '¿Puedo ir a recoger el palé yo mismo?', 'r' => 'Con nosotros sí, gratis, en Girona. Con otros proveedores, pregunta: algunos sólo trabajan con agencia.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'salen-iphone-en-los-lotes-de-devoluciones',
  'titulo' => '¿Salen iPhone en los lotes de devoluciones? La verdad',
  'h1' => '¿Salen iPhone en los lotes?',
  'desc' => 'Por qué los móviles de gama alta no aparecen en los lotes de devoluciones, qué electrónica sí aparece y cómo reconocer un anuncio que promete lo que no hay.',
  'entradilla' => 'La respuesta corta es no, y conviene saber por qué: entenderlo te ahorra caer en el anuncio que sí te lo promete.',
  'img' => 'assets/img/lote-pale-mixto.webp',
  'imgAlt' => 'Palé mixto sin clasificar con referencias mezcladas de varias categorías',
  'fecha' => '2026-09-13', 'minutos' => 6,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Por qué no llegan', 'html' =>
'    <p>Un móvil de gama alta devuelto tiene tres salidas antes de acercarse a un palé de liquidación:</p>
    <ol class="pasos-lista">
      <li><b>Reacondicionado por la propia plataforma</b> y revendido con garantía. Es lo más rentable para ellos.</li>
      <li><b>Vendido a un reacondicionador especializado</b>, que paga bastante más de lo que pagaría un liquidador por kilo.</li>
      <li><b>Despiece</b>, si está roto. Una pantalla y una batería valen más sueltas que el aparato entero a peso.</li>
    </ol>
    <p>Sólo cuando ninguna de las tres compensa acaba en un lote genérico, y eso significa que está bastante mal.</p>'),
    array('h2' => 'Qué sí aparece', 'html' =>
'    <ul>
      <li>Tablets de gama de entrada y media, de 8 a 10 pulgadas.</li>
      <li>Smartwatches y pulseras de actividad.</li>
      <li>Auriculares inalámbricos, de diadema y true wireless.</li>
      <li>Muchísimo accesorio: fundas, cargadores, cables, baterías externas.</li>
      <li>Algún móvil suelto de gama de entrada en el palé mixto, sin garantía de estado.</li>
    </ul>
    <p>Es buen producto y sale muy barato, pero no es lo mismo que lo que promete el anuncio. La diferencia entre las dos cosas es donde vive el timo.</p>'),
    array('h2' => 'Cómo reconocer el anuncio que te lo promete', 'html' =>
'    <ul>
      <li>Habla de «palés con iPhone garantizados» o enseña una foto con móviles apilados.</li>
      <li>Da un «valor estimado» enorme sin ninguna lista de referencias detrás.</li>
      <li>Mete prisa: quedan dos, hoy acaba.</li>
      <li>Sólo acepta transferencia o Bizum.</li>
      <li>No tiene dirección física ni CIF.</li>
    </ul>
    <p>El producto que venden ahí no es un palé: es la ilusión de encontrar un iPhone por 30 €. Y esa ilusión es lo que hace que la gente pague por adelantado a un desconocido, que es como acaban casi todas las estafas del sector.</p>'),
    array('h2' => 'Qué comprar si lo que querías era electrónica barata', 'html' =>
'    <p>El <a href="../lotes/electronica.html">lote de electrónica de consumo</a>: 42 aparatos por 549 €, a 13 € la pieza, todo probado. O el <a href="../lotes/informatica.html">de informática</a>, con dos monitores de 27 pulgadas verificados sin píxeles muertos y cuatro SSD, por 699 €.</p>
    <p>No hay iPhone, pero hay margen de verdad, y las cuentas salen sin necesidad de que aparezca un unicornio dentro de la caja.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Nunca ha aparecido un móvil bueno en un palé?', 'r' => 'Aparece muy de vez en cuando, casi siempre con la pantalla rota o bloqueado por cuenta. Contar con ello para hacer números es la forma más rápida de equivocarse.'),
    array('p' => '¿Y los reacondicionados que se venden con garantía?', 'r' => 'Ese es otro mercado, con otros proveedores y otros precios. Es un negocio legítimo, pero no es comprar devoluciones a peso.'),
    array('p' => '¿Qué hago si un vendedor me promete móviles?', 'r' => 'Pídele el manifiesto con IMEI. Si no lo tiene, no los tiene. Y no pagues por adelantado.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-fotografiar-productos-para-vender',
  'titulo' => 'Cómo fotografiar productos para vender de segunda mano',
  'h1' => 'Fotografiar para vender',
  'desc' => 'Cómo hacer fotos que vendan en Wallapop y Vinted con el móvil: luz, fondo, encuadre, cuántas fotos y qué enseñar del defecto.',
  'entradilla' => 'La foto es el 80 % de la venta y no necesitas cámara. Montaje de dos minutos, cinco encuadres fijos y una regla que casi nadie sigue: enseña el defecto.',
  'img' => 'assets/img/clasificacion.webp',
  'imgAlt' => 'Productos clasificados sobre la mesa, preparados para fotografiar',
  'fecha' => '2026-09-11', 'minutos' => 6,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'El montaje, que cuesta cero', 'html' =>
'    <ul>
      <li><b>Una mesa al lado de una ventana.</b> Luz natural, de día, nunca a mediodía en verano con el sol de frente.</li>
      <li><b>Una sábana o cartulina blanca</b> como fondo, subiendo por la pared para que no se vea la línea de la mesa.</li>
      <li><b>Nada más.</b> Ni flash, ni lámpara de escritorio, ni filtros. El flash del móvil aplana el producto y le mete brillos.</li>
    </ul>
    <p>Si sólo puedes fotografiar de noche, una lámpara de pie con bombilla cálida detrás de una tela blanca hace el apaño. Pero la ventana gana siempre.</p>'),
    array('h2' => 'Los cinco encuadres', 'html' =>
'    <ol class="pasos-lista">
      <li><b>El producto entero</b>, centrado, llenando el marco. Esta es la que se ve en el listado y la que decide si te abren el anuncio.</li>
      <li><b>La marca y el modelo</b>, legibles. La etiqueta, el logo, la serigrafía.</li>
      <li><b>Todo lo que incluye</b>, junto: cables, mando, manual, caja.</li>
      <li><b>El defecto</b>, si lo hay, de cerca y sin disimular.</li>
      <li><b>Una foto de contexto</b>: el producto en uso o con algo al lado que dé idea del tamaño.</li>
    </ol>'),
    array('h2' => 'Enseña el defecto', 'html' =>
'    <p>Parece que vende menos y vende más. Quien compra de segunda mano da por hecho que hay algo; si no se lo enseñas, se lo imagina peor de lo que es. Y si lo descubre al abrir la caja, tienes una devolución y una valoración mala.</p>
    <p>La foto del arañazo, con una frase que diga «arañazo en la esquina, no afecta al uso», cierra ventas. Lo hemos visto mil veces.</p>'),
    array('h2' => 'Errores que se repiten', 'html' =>
'    <ul>
      <li><b>Foto de catálogo.</b> Se nota y la gente lo lee como que no tienes el producto.</li>
      <li><b>Fondo con la cocina detrás.</b> Resta más de lo que parece.</li>
      <li><b>Una sola foto.</b> Menos de cuatro y la mayoría pasa de largo.</li>
      <li><b>Producto sucio.</b> Un paño antes de disparar sube el precio percibido más que cualquier filtro.</li>
      <li><b>Foto vertical recortada.</b> Comprueba cómo queda el recorte cuadrado del listado antes de publicar.</li>
    </ul>'),
    array('h2' => 'Fotografiar en tandas', 'html' =>
'    <p>Con 60 piezas no fotografíes de una en una: monta el fondo, coloca todas las de una categoría al lado y ve disparando. Se tarda un tercio y todas quedan con la misma luz, que además hace que tu perfil parezca serio.</p>
    <p>Dedica una tarde a fotografiar el lote entero y otra a publicar. Mezclarlo es lo que hace que la gente abandone a las dos semanas.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Hace falta cámara o vale el móvil?', 'r' => 'Vale cualquier móvil de los últimos cinco años. La diferencia la hace la luz, no la cámara.'),
    array('p' => '¿Se pueden usar fotos del fabricante?', 'r' => 'Como foto de apoyo, sí. Como foto principal, no: además de que se nota, en segunda mano genera desconfianza inmediata.'),
    array('p' => '¿Cuántas fotos son demasiadas?', 'r' => 'Más de ocho cansa. Cinco bien hechas ganan a diez regulares.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'que-precio-poner-a-un-producto-de-segunda-mano',
  'titulo' => 'Qué precio poner a un producto de segunda mano',
  'h1' => 'Qué precio poner',
  'desc' => 'Cómo fijar el precio de un producto de segunda mano: el método de los cinco anuncios, el margen para el regateo y cuándo bajar y cuánto.',
  'entradilla' => 'El método que usamos: cinco anuncios, la mediana, un 15 % arriba para el regateo, y un calendario de bajadas que evita malvender por impaciencia.',
  'img' => 'assets/img/lote-electronica.webp',
  'imgAlt' => 'Aparatos de electrónica etiquetados con su precio sobre la mesa',
  'fecha' => '2026-09-09', 'minutos' => 6,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'El método de los cinco anuncios', 'html' =>
'    <ol class="pasos-lista">
      <li>Busca tu producto exacto en la plataforma donde vas a vender.</li>
      <li>Apunta el precio de <b>cinco anuncios parecidos</b> en estado similar.</li>
      <li>Quédate con la <b>mediana</b>, no con la media: un anuncio disparatado te distorsiona la media entera.</li>
      <li>Mira si alguno está <b>vendido</b>. El precio de lo vendido vale diez veces más que el de lo que sigue publicado.</li>
      <li>Súmale un <b>10-15 %</b> a lo que quieres cobrar. Ese es el margen del regateo.</li>
    </ol>
    <p>Quince minutos por categoría, no por pieza. Una vez sabes a cuánto va una sudadera con etiqueta, ya lo sabes para las treinta.</p>'),
    array('h2' => 'Nunca calcules sobre el PVP', 'html' =>
'    <p>El PVP de catálogo no es lo que vas a cobrar. Es lo que costaba en tienda cuando estaba a la venta, y en segunda mano no manda. Un producto con PVP de 80 € puede moverse a 25 € o a 45 € según la marca, el momento y tu ciudad.</p>
    <p>Poner «PVP 80 €, lo dejo en 60 €» es la forma más rápida de que nadie te escriba.</p>'),
    array('h2' => 'Cuándo bajar y cuánto', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Tiempo publicado</th><th>Qué hacer</th></tr></thead>
      <tbody>
        <tr><td>Semana 1</td><td>Nada. Ni tocarlo.</td></tr>
        <tr><td>Semana 2-3</td><td>Renovar el anuncio. Si no tiene visitas, cambiar foto y título.</td></tr>
        <tr><td>Semana 4</td><td>Bajar un 10 %.</td></tr>
        <tr><td>Semana 8</td><td>Bajar otro 15 % o meterlo en un pack.</td></tr>
        <tr><td>Mes 3</td><td>Mercadillo, tienda o lote de saldo. Fuera.</td></tr>
      </tbody>
    </table>
    <p class="nota-destacada">Si un anuncio no tiene ni una visita, el problema no es el precio: es la foto o el título. Bajar el precio de algo que nadie ve no sirve de nada.</p>'),
    array('h2' => 'El regateo', 'html' =>
'    <p>Se regatea siempre. Contesta a todas las ofertas, aunque sea para decir que no: un «no, pero te lo dejo en X» cierra bastantes ventas. Las ofertas ridículas también merecen respuesta educada; a veces la segunda oferta de esa misma persona es buena.</p>
    <p>Y marca tu suelo antes de publicar. Si lo decides en caliente, con el comprador escribiendo, lo vas a bajar más de lo que querías.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Precios redondos o con decimales?', 'r' => 'Redondos en segunda mano. El 9,99 € funciona en retail, no aquí: aquí transmite que estás jugando.'),
    array('p' => '¿Pongo «precio negociable»?', 'r' => 'No hace falta, se da por hecho. Lo que sí funciona es «no bajo más» cuando de verdad no vas a bajar: filtra las ofertas absurdas.'),
    array('p' => '¿Vender en packs sale a cuenta?', 'r' => 'Para lo que lleva parado un mes, sí. Tres piezas a precio de dos mueve lo que suelto no se mueve.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-empaquetar-y-enviar-sin-perder-dinero',
  'titulo' => 'Cómo empaquetar y enviar sin perder dinero',
  'h1' => 'Empaquetar y enviar',
  'desc' => 'Cómo calcular el envío, qué material comprar, cómo empaquetar para que no llegue roto y qué hacer si el paquete se pierde o llega dañado.',
  'entradilla' => 'Un envío mal calculado se come la venta entera de una pieza barata. Material, medidas, cómo empaquetar y qué hacer cuando algo sale mal.',
  'img' => 'assets/img/lote-informatica.webp',
  'imgAlt' => 'Cajas y material de embalaje preparados junto a productos por enviar',
  'fecha' => '2026-09-07', 'minutos' => 6,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Pesa y mide ANTES de publicar', 'html' =>
'    <p>El error más caro y el más fácil de evitar. Las plataformas calculan el envío por tramos de peso y volumen; pasarte 200 gramos puede subir un tramo entero y comerte el margen.</p>
    <p>Una báscula de cocina de 15 € y un metro resuelven esto para siempre. Pesa el producto ya empaquetado, no desnudo: el embalaje pesa.</p>'),
    array('h2' => 'El material que hace falta', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Material</th><th>Para qué</th><th>Coste aproximado</th></tr></thead>
      <tbody>
        <tr><td>Cajas de 3 tamaños</td><td>El 90 % de lo que envías</td><td>0,40 - 0,90 € por caja</td></tr>
        <tr><td>Sobres acolchados</td><td>Textil y cosas planas</td><td>0,25 € cada uno</td></tr>
        <tr><td>Plástico de burbujas</td><td>Todo lo frágil</td><td>0,15 € por envío</td></tr>
        <tr><td>Precinto ancho</td><td>Cerrar bien</td><td>0,05 € por envío</td></tr>
        <tr><td>Etiquetas adhesivas</td><td>Que no se despegue la dirección</td><td>0,03 € cada una</td></tr>
      </tbody>
    </table>
    <p>Total realista: entre 0,80 y 1,50 € por envío. Mételo en las cuentas del lote desde el principio.</p>'),
    array('h2' => 'Cómo empaquetar para que llegue entero', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Nada toca la pared de la caja.</b> Dos dedos de relleno por todos los lados.</li>
      <li><b>Lo frágil, doble.</b> Burbuja alrededor y relleno alrededor de la burbuja.</li>
      <li><b>Que no suene al agitar.</b> Si se mueve dentro, llega roto.</li>
      <li><b>Precinto en H</b>: las dos juntas y los dos laterales.</li>
      <li><b>Quita etiquetas viejas</b> si reutilizas una caja. Un código de barras antiguo desvía paquetes.</li>
      <li><b>Foto del paquete cerrado</b> con la etiqueta visible antes de entregarlo. Dos segundos que valen oro si hay reclamación.</li>
    </ol>'),
    array('h2' => 'Cuando algo sale mal', 'html' =>
'    <p><b>Llega roto.</b> Pide fotos al comprador del embalaje y del producto. Si empaquetaste bien y hay foto del paquete cerrado, la reclamación a la agencia es viable.</p>
    <p><b>Se pierde.</b> Abre incidencia con el número de seguimiento cuanto antes. Los plazos para reclamar son cortos.</p>
    <p><b>El comprador dice que no ha llegado.</b> Con seguimiento entregado y firma, la plataforma suele darte la razón. Sin seguimiento, no tienes nada: nunca envíes por tu cuenta sin él.</p>'),
    array('h2' => 'Cuándo NO enviar', 'html' =>
'    <p>En piezas de menos de 10 €, el envío y el tiempo se comen todo. Esas van en mano, en pack con otras o al mercadillo. Enviar una pieza de 6 € es trabajar gratis.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Dónde compro cajas barato?', 'r' => 'Al por mayor en tiendas de embalaje; sale la mitad que comprarlas de una en una. También sirven las cajas de tus propios lotes.'),
    array('p' => '¿Puedo reutilizar cajas?', 'r' => 'Sí, si están enteras y sin etiquetas antiguas. Es lo normal en segunda mano y nadie se queja.'),
    array('p' => '¿Merece la pena el seguro del envío?', 'r' => 'En piezas de más de 100 €, sí. Por debajo, el coste acumulado supera lo que te ahorras.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'calendario-del-revendedor-mes-a-mes',
  'titulo' => 'Calendario del revendedor: qué comprar y vender cada mes',
  'h1' => 'Calendario mes a mes',
  'desc' => 'Qué comprar y qué vender cada mes del año revendiendo devoluciones: las temporadas altas, los meses muertos y cuándo hay que tener el stock comprado.',
  'entradilla' => 'Este negocio tiene calendario, y el que lo ignora compra juguetes en febrero. Mes a mes: qué se vende, qué comprar y cuándo hay que tenerlo ya en casa.',
  'img' => 'assets/img/lote-moda.webp',
  'imgAlt' => 'Prendas y calzado de temporada clasificados en la nave',
  'fecha' => '2026-09-06', 'minutos' => 7,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'El año de un vistazo', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Mes</th><th>Se vende</th><th>Compra para…</th></tr></thead>
      <tbody>
        <tr><td>Enero</td><td>Deporte y fitness, organización del hogar</td><td>Reponer lo de Navidad</td></tr>
        <tr><td>Febrero</td><td>Flojo. Belleza por San Valentín</td><td>Primavera: moda ligera</td></tr>
        <tr><td>Marzo</td><td>Bricolaje, jardín, limpieza</td><td>Herramienta y exterior</td></tr>
        <tr><td>Abril-Mayo</td><td>Jardín, deporte de exterior, moda</td><td>Verano: playa y camping</td></tr>
        <tr><td>Junio-Julio</td><td>Verano, viaje, ventilación</td><td>Vuelta al cole</td></tr>
        <tr><td>Agosto</td><td>El mes más muerto del año</td><td>Campaña: juguete y regalo</td></tr>
        <tr><td>Septiembre</td><td>Vuelta al cole, informática</td><td>Navidad (última llamada barata)</td></tr>
        <tr><td>Octubre</td><td>Arranca el juguete y el regalo</td><td>Reponer para noviembre</td></tr>
        <tr><td>Noviembre</td><td>El mejor mes. Black Friday</td><td>Ya no: los precios están altos</td></tr>
        <tr><td>Diciembre</td><td>Juguete, regalo, electrónica</td><td>Enero: deporte y hogar</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'La regla de los tres meses', 'html' =>
'    <p>Compra el stock <b>tres meses antes</b> de la temporada en la que lo vas a vender. Dos motivos: tienes tiempo de clasificar y fotografiar sin agobio, y lo compras antes de que suba el precio.</p>
    <p>El juguete en octubre ya está un 20-30 % más caro que en julio, porque todo el sector está comprando a la vez. En noviembre, directamente no hay. Nuestro lote de juguetes es el primero que se agota cada año, y siempre por las mismas fechas.</p>'),
    array('h2' => 'El efecto enero', 'html' =>
'    <p>Después de Navidad llega la mayor oleada de devoluciones del año: regalos que no gustaron, tallas equivocadas, duplicados. Eso significa dos cosas opuestas y las dos ciertas.</p>
    <p>Para ti como comprador, <b>enero y febrero son los meses con más material y mejor precio</b> en los camiones. Para ti como vendedor, enero es un mes flojo salvo en deporte (propósitos de año nuevo) y organización del hogar.</p>
    <p>La jugada: comprar en enero-febrero, vender de marzo en adelante.</p>'),
    array('h2' => 'Agosto', 'html' =>
'    <p>Es el peor mes para vender y el mejor para trabajar. La gente está fuera, los anuncios no se mueven y responder mensajes es deprimente.</p>
    <p>Úsalo para lo que no haces el resto del año: clasificar el palé que tienes parado, fotografiar el stock entero, rehacer los anuncios que nunca tuvieron visitas y preparar la campaña. En septiembre sales con todo listo mientras los demás empiezan.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuándo es más barato comprar lotes?', 'r' => 'De enero a marzo, por la avalancha de devoluciones de Navidad, y en julio-agosto, cuando baja la demanda. Octubre y noviembre son los meses caros.'),
    array('p' => '¿Merece la pena guardar stock de un año para otro?', 'r' => 'En juguete y regalo, sí, si tienes espacio. En moda, no: la temporada manda y lo que no se vende se queda viejo.'),
    array('p' => '¿Cuándo entra el camión de cada categoría?', 'r' => 'Uno por semana, los jueves, y la categoría cambia. La siguiente está anunciada en la portada con su cuenta atrás, y puedes apuntarte a la lista de avisos.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'devoluciones-de-amazon-o-liquidaciones-de-otras-tiendas',
  'titulo' => 'Devoluciones de Amazon o liquidaciones de otras tiendas',
  'h1' => 'Amazon u otras tiendas',
  'desc' => 'Diferencias reales entre comprar devoluciones de Amazon y liquidaciones de otras cadenas: qué llega en cada caso, qué precio tiene y cuál conviene según qué vendas.',
  'entradilla' => 'No es lo mismo un camión de devoluciones de una plataforma online que el excedente de una cadena física. Qué llega en cada caso, a qué precio y para qué sirve cada uno.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Descarga de palés de distintos orígenes en el muelle de la nave',
  'fecha' => '2026-09-04', 'minutos' => 6,
  'tema' => 'Sector',
  'bloques' => array(
    array('h2' => 'Las dos fuentes, comparadas', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Devolución de plataforma online</th><th>Excedente de cadena física</th></tr></thead>
      <tbody>
        <tr><td>Origen</td><td>Cliente que devuelve</td><td>Temporada que no se vendió</td></tr>
        <tr><td>Estado</td><td>Sin estrenar o uso leve</td><td>Nuevo, a estrenar</td></tr>
        <tr><td>Variedad</td><td>Altísima, mezcla de todo</td><td>Baja: mismas referencias repetidas</td></tr>
        <tr><td>Tallas / surtido</td><td>Aleatorio</td><td>Los extremos, que son lo que sobra</td></tr>
        <tr><td>Precio por unidad</td><td>Más bajo</td><td>Algo más alto</td></tr>
        <tr><td>Riesgo</td><td>Que algo no funcione</td><td>Que no se venda por temporada</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Cuándo conviene cada una', 'html' =>
'    <p><b>Devoluciones</b> si vendes por piezas en segunda mano. La variedad es una ventaja: cada anuncio es distinto, no compites contigo mismo y el público es amplio.</p>
    <p><b>Excedente de cadena</b> si tienes tienda o puesto fijo. Tener treinta unidades de la misma referencia te permite montar un expositor, poner un cartel y vender a volumen. En segunda mano online, en cambio, treinta anuncios iguales se hunden entre ellos.</p>'),
    array('h2' => 'Lo que casi nadie cuenta del excedente', 'html' =>
'    <p>Lo que sobra de una temporada sobra por algo. En textil suele ser talla XS y XXL, porque las intermedias se vendieron. En calzado, el 36 y el 46. En electrónica, el color raro.</p>
    <p>No es mala mercancía, es mercancía difícil. Si compras excedente, pregunta el desglose de tallas o colores antes de pagar. Si no te lo dan, cuenta con el escenario malo.</p>'),
    array('h2' => 'Lo que casi nadie cuenta de las devoluciones', 'html' =>
'    <p>Que el porcentaje que no sirve es real. En un lote clasificado es bajo porque alguien ha pagado a una persona para abrirlo y apartarlo. En uno sin clasificar, entre un 15 y un 20 %.</p>
    <p>Cuando compares precios entre las dos fuentes, compara el precio por unidad VENDIBLE, no por unidad. Es otra cifra.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Qué vendéis vosotros?', 'r' => 'Sobre todo devoluciones, que es el origen de los camiones que compramos. También entra excedente de otros distribuidores. La categoría y el grado están en la ficha de cada lote.'),
    array('p' => '¿Se pueden mezclar las dos cosas?', 'r' => 'Sí, y es lo que hace casi todo el que tiene tienda: excedente para el expositor y devoluciones para la mesa de gangas.'),
    array('p' => '¿Cuál tiene más margen?', 'r' => 'Las devoluciones, en porcentaje. El excedente vende más rápido por unidad porque es producto nuevo y se puede enseñar como tal.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'que-hacer-con-lo-que-no-se-vende',
  'titulo' => 'Qué hacer con lo que no se vende de un lote',
  'h1' => 'Lo que no se vende',
  'desc' => 'Qué hacer con el stock parado de un lote: packs, bajadas escalonadas, venta a tiendas, mercadillo y cuándo asumir que hay que tirarlo.',
  'entradilla' => 'Entre el 15 y el 30 % de un lote se queda sin vender. No es un fallo tuyo: está en las cuentas desde el principio. Lo que sí es un fallo es dejarlo ocupando sitio dos años.',
  'img' => 'assets/img/lote-herramientas.webp',
  'imgAlt' => 'Herramientas y piezas sueltas apartadas en la mesa de clasificación',
  'fecha' => '2026-09-02', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Primero: por qué no se vende', 'html' =>
'    <p>Antes de bajar el precio, mira las visitas. Son tres diagnósticos distintos:</p>
    <ul>
      <li><b>Cero visitas.</b> No es el precio: es el título o la foto. Nadie ha llegado a verlo.</li>
      <li><b>Visitas y ningún mensaje.</b> Es el precio, o la descripción no resuelve la duda obvia.</li>
      <li><b>Mensajes que no cierran.</b> Es la logística: el envío sale caro o no cuadráis para quedar.</li>
    </ul>
    <p>Bajar el precio de algo que nadie ve es tirar margen sin ganar nada.</p>'),
    array('h2' => 'La escalera de salida', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Mes 1: arreglar el anuncio.</b> Foto nueva, título con marca y modelo, renovar.</li>
      <li><b>Mes 2: packs.</b> Tres piezas a precio de dos. Funciona muy bien en textil, accesorios y juguete.</li>
      <li><b>Mes 2-3: bajada del 20 %.</b> De golpe, no de cinco en cinco. Las bajadas pequeñas no mueven nada.</li>
      <li><b>Mes 3: canal de volumen.</b> Mercadillo, puesto de amigo, grupo local de compraventa.</li>
      <li><b>Mes 4: a una tienda, en bloque.</b> Aunque sea a precio de coste: recuperas dinero y espacio.</li>
      <li><b>Lo que no tiene salida:</b> donación o punto limpio. Guardarlo cuesta más que tirarlo.</li>
    </ol>'),
    array('h2' => 'Vender el resto en bloque', 'html' =>
'    <p>Es la salida que menos gente usa y la que más rápido limpia. Coges lo que queda, lo fotografías junto, y lo ofreces como «lote de 40 piezas variadas» a un precio que sea claramente un chollo para quien tiene puesto.</p>
    <p>Vas a cobrar poco por pieza. A cambio: una conversación, una entrega y se acabó. Si valoras tu tiempo a 10 € la hora, casi siempre sale mejor que vender veinte piezas de 4 € una a una.</p>'),
    array('h2' => 'El coste de no decidir', 'html' =>
'    <p class="aviso-honesto">El stock parado no es neutro: ocupa espacio, te desmotiva, y cada mes que pasa vale menos, sobre todo en moda y electrónica. Un lote que llevas un año «casi vendido» es un lote que perdió dinero.</p>
    <p>Ponle fecha a cada compra desde el día que llega. A los cuatro meses, lo que quede sale como sea. Esa regla sola mejora las cuentas del año más que cualquier truco de venta.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Qué porcentaje es normal que no se venda?', 'r' => 'En un lote clasificado, entre el 15 y el 20 %. En un palé mixto sin clasificar, hasta el 30 % contando lo que directamente no funciona.'),
    array('p' => '¿Se puede devolver al proveedor lo que no se vende?', 'r' => 'No. Se vende cerrado y ese es el trato. El derecho de desistimiento de 14 días es para el lote entero y sin abrir, no para las sobras.'),
    array('p' => '¿Dónde dono lo que no tiene salida?', 'r' => 'Asociaciones locales, roperos solidarios y bancos de material infantil aceptan producto en buen estado. Lo que no funciona, a punto limpio.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-montar-un-puesto-de-mercadillo',
  'titulo' => 'Cómo montar un puesto de mercadillo con lotes',
  'h1' => 'Montar un puesto',
  'desc' => 'Qué hace falta para montar un puesto de mercadillo con lotes de devoluciones: permisos, material, cómo colocar, qué precios poner y cuánto se saca en un día.',
  'entradilla' => 'Permisos, material, cómo se coloca la mesa y qué se saca de verdad en un domingo. Contado por quien ve pasar por la nave a los que lo hacen cada semana.',
  'img' => 'assets/img/lote-belleza.webp',
  'imgAlt' => 'Productos de belleza clasificados y agrupados por tipo para el puesto',
  'fecha' => '2026-08-31', 'minutos' => 7,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Lo primero: los permisos', 'html' =>
'    <p>No es opcional y se comprueba. Necesitas, como mínimo:</p>
    <ul>
      <li><b>Alta en Hacienda</b> en el epígrafe de comercio al por menor que corresponda.</li>
      <li><b>Alta en autónomos</b> si la actividad es habitual.</li>
      <li><b>Licencia municipal de venta ambulante</b> del ayuntamiento donde esté el mercadillo. Cada uno tiene su plazo y su sorteo de puestos.</li>
      <li><b>Seguro de responsabilidad civil</b>, que muchos ayuntamientos exigen.</li>
    </ul>
    <p class="aviso-honesto">Esto no es asesoramiento legal: es el marco general. Habla con tu ayuntamiento y con un gestor antes de comprar el primer lote, porque las condiciones cambian bastante de un municipio a otro.</p>'),
    array('h2' => 'El material', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Qué</th><th>Para qué</th><th>Coste</th></tr></thead>
      <tbody>
        <tr><td>Mesa plegable 1,80 m</td><td>La base del puesto</td><td>40 - 70 €</td></tr>
        <tr><td>Carpa 3×3</td><td>Sol y lluvia. En muchos sitios, obligatoria</td><td>80 - 150 €</td></tr>
        <tr><td>Cajas de plástico apilables</td><td>Transportar y exponer a la vez</td><td>5 € cada una</td></tr>
        <tr><td>Carteles de precio grandes</td><td>Venden más que veinte etiquetas</td><td>10 €</td></tr>
        <tr><td>Cambio y datáfono</td><td>No perder ventas</td><td>Datáfono desde 30 €</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Cómo se coloca', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Por categorías, no por precio.</b> La gente busca «juguetes», no «cosas de 5 €».</li>
      <li><b>Lo bueno a la altura de los ojos.</b> Lo de saldo, en cajas al suelo para rebuscar: rebuscar es parte de la compra.</li>
      <li><b>Altura y volumen.</b> Una mesa plana no llama; apila cajas detrás para dar fondo.</li>
      <li><b>Deja probar lo eléctrico.</b> Una batería externa cargada cierra ventas de auriculares.</li>
      <li><b>Reponer durante el día.</b> Un puesto que se vacía deja de parar gente a media mañana.</li>
    </ol>'),
    array('h2' => 'Qué se saca en un día', 'html' =>
'    <p>Con un puesto medio bien surtido, en un mercadillo de tamaño normal: entre 150 y 400 € de venta en una jornada. Menos el puesto (entre 15 y 40 €), la gasolina y el desayuno.</p>
    <p>Lo bueno no es la cifra: es que cobras en el momento, no hay devoluciones y vacías stock a un ritmo que ningún canal online iguala. Lo malo es que madrugas, montas, aguantas el día y desmontas.</p>
    <p>La combinación que mejor funciona: online para lo que vale más de 25 €, mercadillo para todo lo demás.</p>'),
    array('h2' => 'Qué lote comprar para empezar', 'html' =>
'    <p><a href="../lotes/juguetes.html">Juguetes</a> (64 piezas, 319 €) y <a href="../lotes/moda.html">moda</a> (120 prendas, 590 €) son los dos que mejor llenan una mesa. Belleza funciona muy bien como complemento porque el ticket medio sube.</p>
    <p>Lo que no funciona en puesto: electrónica de más de 40 €. Nadie se gasta eso sin garantía en un mercadillo.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto cuesta un puesto?', 'r' => 'Entre 15 y 40 € por jornada según el municipio y el tamaño. Algunos cobran por metro lineal.'),
    array('p' => '¿Hace falta factura de la mercancía?', 'r' => 'Sí, y te la pueden pedir en una inspección. Guarda las facturas de tus lotes.'),
    array('p' => '¿Se puede vender ropa de segunda mano en cualquier mercadillo?', 'r' => 'Depende de la ordenanza municipal: algunos separan mercadillo de venta nueva y rastro de segunda mano. Pregunta antes.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'vender-a-tiendas-en-lugar-de-por-piezas',
  'titulo' => 'Vender a tiendas en lugar de por piezas: el canal olvidado',
  'h1' => 'Vender a tiendas',
  'desc' => 'Cómo vender un lote entero a tiendas de barrio en lugar de por piezas: a quién ofrecerlo, qué precio poner, cómo presentarse y cuándo compensa.',
  'entradilla' => 'Es el canal que menos gente usa y el que más rápido vacía un lote. Cobras menos por pieza y te ahorras fotografiar, publicar, responder, empaquetar y gestionar devoluciones.',
  'img' => 'assets/img/lote-juguetes.webp',
  'imgAlt' => 'Caja de juguetes preparada para ofrecer entera a una tienda',
  'fecha' => '2026-08-29', 'minutos' => 6,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Las cuentas que hacen que compense', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Por piezas</th><th>A una tienda</th></tr></thead>
      <tbody>
        <tr><td>Lote de juguetes</td><td>319 €</td><td>319 €</td></tr>
        <tr><td>Ingresos</td><td>750 €</td><td>520 €</td></tr>
        <tr><td>Material de envío</td><td>−60 €</td><td>0 €</td></tr>
        <tr><td>Horas</td><td>22 h</td><td>3 h</td></tr>
        <tr><td><b>Beneficio</b></td><td><b>371 €</b></td><td><b>201 €</b></td></tr>
        <tr><td><b>Por hora</b></td><td><b>16,80 €</b></td><td><b>67 €</b></td></tr>
      </tbody>
    </table>
    <p>Ganas menos en total y muchísimo más por hora. Si tienes poco tiempo, este canal gana. Si tienes tiempo y poco dinero, gana el otro.</p>'),
    array('h2' => 'A quién ofrecerlo', 'html' =>
'    <ul>
      <li><b>Jugueterías y papelerías de barrio</b>, para juguete y material.</li>
      <li><b>Bazares y tiendas de precio único</b>, para casi todo.</li>
      <li><b>Ferreterías pequeñas</b>, para herramienta a batería.</li>
      <li><b>Tiendas de segunda mano y compraventa</b>, para electrónica e informática.</li>
      <li><b>Puestos de mercadillo con parada fija</b>, que compran para revender igual que tú.</li>
    </ul>'),
    array('h2' => 'Cómo presentarse', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Ve en persona.</b> Un correo frío no lo abre nadie. Entra a media mañana, cuando no hay cola.</li>
      <li><b>Lleva una caja de muestra</b> con diez piezas representativas, no las diez mejores. Si le enseñas lo mejor y luego le llega la media, no repite.</li>
      <li><b>Lleva tu factura de compra.</b> Que vea que hay origen y que eres alguien con quien se puede trabajar.</li>
      <li><b>Da un precio por lote, cerrado.</b> Nada de «según lo que elijas»: eso es hacerle trabajo a él.</li>
      <li><b>Ofrece entrega.</b> Es lo que cierra el trato cuando duda.</li>
    </ol>'),
    array('h2' => 'Qué precio poner', 'html' =>
'    <p>Entre el 60 y el 70 % de lo que sacarías vendiendo por piezas. Por debajo del 50 % no compensa; por encima del 75 % la tienda no tiene margen y dirá que no.</p>
    <p>Piénsalo desde su lado: tiene que poder multiplicar por dos o por tres para que le salgan las cuentas con local, luz y personal. Si le dejas ese margen, repite. Y un cliente que repite vale más que una venta buena.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Puedo vender a tiendas siendo particular?', 'r' => 'Una venta puntual de cosas tuyas, sí. Comprar para revender a comercios de forma habitual es actividad económica con todas las letras: hace falta alta y factura.'),
    array('p' => '¿Y si la tienda quiere elegir sólo lo bueno?', 'r' => 'Es lo normal que lo intente. Tú decides: o lote cerrado a precio de lote, o selección a precio de selección. Lo que no funciona es lote cerrado a precio de selección.'),
    array('p' => '¿Cuántas tiendas hay que visitar?', 'r' => 'De diez visitas salen una o dos compras la primera vez. A partir de ahí, las que repiten son la base del negocio.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'cuanto-espacio-necesito-para-revender',
  'titulo' => 'Cuánto espacio necesito para revender devoluciones',
  'h1' => 'Cuánto espacio hace falta',
  'desc' => 'Cuánto espacio ocupa un lote y un palé de devoluciones, cómo organizar el almacenamiento en casa y cuándo compensa alquilar un trastero o una nave.',
  'entradilla' => 'Un lote cabe en un armario; un palé no cabe en un piso. Medidas reales, cómo organizar lo que llega y en qué momento el trastero deja de ser un gasto y pasa a ser necesario.',
  'img' => 'assets/img/lote-deporte.webp',
  'imgAlt' => 'Palé de material deportivo, que ocupa el espacio de un europalé completo',
  'fecha' => '2026-08-27', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Lo que ocupa cada cosa', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Formato</th><th>Medidas</th><th>Peso</th><th>Dónde cabe</th></tr></thead>
      <tbody>
        <tr><td>Caja 60×40×40</td><td>0,1 m³</td><td>19 - 41 kg</td><td>Un armario</td></tr>
        <tr><td>Caja 80×60×60</td><td>0,29 m³</td><td>27 - 38 kg</td><td>Un rincón de habitación</td></tr>
        <tr><td>Gaylord 120×80×80</td><td>0,77 m³</td><td>46 kg</td><td>Media habitación pequeña</td></tr>
        <tr><td>Palé EUR 120×80×110</td><td>1,06 m³</td><td>58 - 96 kg</td><td>Garaje o trastero</td></tr>
        <tr><td>Palé alto 120×80×180</td><td>1,73 m³</td><td>210 kg</td><td>Nave o garaje con acceso</td></tr>
      </tbody>
    </table>
    <p>Y ojo: eso es lo que ocupa <b>cerrado</b>. En cuanto lo abres y lo clasificas en montones, multiplica por dos o por tres hasta que empieces a vender.</p>'),
    array('h2' => 'Organizarlo en casa', 'html' =>
'    <ul>
      <li><b>Tres zonas, siempre las mismas:</b> pendiente de fotografiar, publicado, vendido y por enviar. Si se mezclan, acabas vendiendo algo que ya vendiste.</li>
      <li><b>Cajas de plástico apilables</b> numeradas. En el anuncio, apunta el número de caja. Buscar una pieza entre sesenta sin sistema son veinte minutos cada vez.</li>
      <li><b>Lo vendido, fuera del montón.</b> En cuanto se vende, a la zona de envíos.</li>
      <li><b>En alto.</b> Estanterías baratas de metal multiplican el espacio útil de un garaje por tres.</li>
    </ul>'),
    array('h2' => 'Cuándo alquilar trastero', 'html' =>
'    <p>Un trastero pequeño son 60-110 € al mes según ciudad. Eso equivale a la mitad del beneficio de un lote pequeño, así que sólo compensa cuando ya mueves dos o más lotes al mes de forma estable.</p>
    <p>Antes de eso, lo barato es ordenar mejor. Después de eso, el trastero se paga solo porque puedes comprar palés, que es donde está el precio por referencia bajo.</p>
    <p class="nota-destacada">Atajo: si vives cerca de la nave, puedes comprar el palé y venir a por él por partes. No es lo habitual, pero se hace.</p>'),
    array('h2' => 'El error que se paga caro', 'html' =>
'    <p>Comprar un palé sin haber mirado dónde va a caber. Llega un camión con 210 kg retractilados, el transportista no sube escaleras y tú no tienes transpaleta. Lo hemos visto: acaba en la acera.</p>
    <p>Antes de pedir palé: mira el peso en la ficha, mira si tienes muelle o necesitas plataforma elevadora, y mira por dónde va a entrar. Si vives en un piso, pide lotes en caja.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto ocupa un lote una vez clasificado?', 'r' => 'Entre dos y tres veces la caja original hasta que empieces a vender. Cuenta con ello.'),
    array('p' => '¿Puedo guardar mercancía en casa si estoy dado de alta?', 'r' => 'Para volúmenes pequeños es lo normal. Si declaras la vivienda como lugar de actividad hay implicaciones fiscales: pregunta a tu gestor.'),
    array('p' => '¿Qué hago si el palé no me cabe?', 'r' => 'Pide la entrega con plataforma elevadora y descárgalo a pie de calle, o ven a recogerlo a la nave por partes. Decidirlo antes de pedir sale mucho más barato.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'impuestos-y-facturas-al-revender',
  'titulo' => 'Impuestos y facturas al revender: lo básico ordenado',
  'h1' => 'Impuestos y facturas',
  'desc' => 'Qué facturas guardar, qué gastos se deducen y qué declaraciones toca presentar si revendes devoluciones estando dado de alta. Marco general, no asesoramiento.',
  'entradilla' => 'Lo que hay que guardar, lo que se deduce y lo que toca presentar, ordenado para que puedas ir al gestor sabiendo de qué habla.',
  'img' => 'assets/img/lote-bebe.webp',
  'imgAlt' => 'Etiquetas, albaranes y documentación junto a un lote preparado',
  'fecha' => '2026-08-25', 'minutos' => 7,
  'tema' => 'Legal',
  'bloques' => array(
    array('h2' => 'Antes de nada', 'html' =>
'    <p class="aviso-honesto"><b>Esto no es asesoramiento fiscal.</b> Somos un liquidador, no una gestoría. Lo que sigue es el marco general para que la conversación con tu gestor empiece más arriba. Antes de montar nada, esa conversación hay que tenerla.</p>'),
    array('h2' => 'Lo que hay que guardar', 'html' =>
'    <ul>
      <li><b>Facturas de compra</b> de cada lote, con IVA desglosado y tu CIF o NIF.</li>
      <li><b>Facturas de gastos</b>: material de embalaje, envíos, la parte del móvil y del coche que uses para esto.</li>
      <li><b>Registro de ventas.</b> Fecha, plataforma, producto, importe cobrado y comisión.</li>
      <li><b>Justificantes de cobro</b> de las plataformas. Las descargas desde tu panel de vendedor.</li>
      <li><b>Facturas que emites tú</b> cuando vendes a empresas o a quien te la pida.</li>
    </ul>
    <p>Una hoja de cálculo bien llevada vale. Lo que no vale es llegar a fin de trimestre con una caja de papeles.</p>'),
    array('h2' => 'Qué se deduce', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Gasto</th><th>Deducible</th><th>Nota</th></tr></thead>
      <tbody>
        <tr><td>Compra de lotes</td><td>Sí, entero</td><td>Es tu mercancía</td></tr>
        <tr><td>Embalaje y envíos</td><td>Sí</td><td>Guarda los tickets</td></tr>
        <tr><td>Trastero o nave</td><td>Sí</td><td>Con contrato a tu nombre</td></tr>
        <tr><td>Móvil e internet</td><td>Parcial</td><td>Porcentaje de uso profesional</td></tr>
        <tr><td>Coche y gasolina</td><td>Discutido</td><td>Difícil de justificar si es tu coche particular</td></tr>
        <tr><td>Gestoría</td><td>Sí</td><td>Y suele pagarse sola</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'El IVA de segunda mano', 'html' =>
'    <p>Hay un régimen especial para bienes usados (REBU) que permite tributar por el margen en lugar de por el importe total de la venta. En reventa de segunda mano puede cambiar bastante las cuentas.</p>
    <p>No todos los casos encajan ni a todo el mundo le conviene, y aplicarlo mal se corrige con recargo. Es exactamente el tipo de cosa que hay que preguntar a un gestor, con tus números delante, antes del primer trimestre.</p>'),
    array('h2' => 'Lo que comunican las plataformas', 'html' =>
'    <p>Las plataformas de venta comunican a la Administración los datos de los vendedores que superan ciertos umbrales de operaciones o de importe al año. La idea de que «esto no lo ve nadie» hace tiempo que no se sostiene.</p>
    <p>No lo decimos para asustar, sino porque la gente que monta esto bien desde el principio es la que sigue en pie al segundo año. El que va por detrás acaba pagando lo mismo más recargo.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Me hacéis factura si soy particular?', 'r' => 'Sí, siempre, con el IVA desglosado. Si luego te das de alta, esa factura te sirve para deducir la compra.'),
    array('p' => '¿Qué epígrafe de IAE corresponde?', 'r' => 'Depende de qué vendas y cómo. Suele ir por comercio al por menor de artículos varios o por comercio a distancia, pero eso te lo tiene que decir un gestor mirando tu caso.'),
    array('p' => '¿Hace falta llevar libros de contabilidad?', 'r' => 'Como autónomo en estimación directa simplificada, libros de ingresos, gastos y bienes de inversión. Tu gestor te dirá exactamente cuáles.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-leer-un-manifiesto-de-palet',
  'titulo' => 'Cómo leer un manifiesto de palé antes de comprar',
  'h1' => 'Leer un manifiesto',
  'desc' => 'Qué es un manifiesto de palé, qué columnas mirar, cómo calcular el valor real y cómo detectar un manifiesto inflado o que no corresponde a la mercancía.',
  'entradilla' => 'El manifiesto es la lista de lo que trae un palé. Sabiendo leerlo se decide en diez minutos si un palé vale su precio; sin saberlo, es un papel que tranquiliza y nada más.',
  'img' => 'assets/img/lote-hogar-cocina.webp',
  'imgAlt' => 'Pequeño electrodoméstico clasificado y contado sobre la mesa de revisión',
  'fecha' => '2026-08-23', 'minutos' => 7,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Qué columnas trae y cuáles importan', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Columna</th><th>Qué dice</th><th>Cuánto importa</th></tr></thead>
      <tbody>
        <tr><td>Referencia / SKU</td><td>El código del producto</td><td>Alta: permite buscarlo</td></tr>
        <tr><td>Descripción</td><td>Qué es</td><td>Alta</td></tr>
        <tr><td>Cantidad</td><td>Cuántas unidades</td><td>Alta</td></tr>
        <tr><td>PVP unitario</td><td>Precio de catálogo</td><td>Baja: no es lo que vas a cobrar</td></tr>
        <tr><td>Valor total</td><td>Cantidad × PVP</td><td>Muy baja: es el número que se infla</td></tr>
        <tr><td>Categoría</td><td>Familia de producto</td><td>Media</td></tr>
        <tr><td>Estado / grado</td><td>En qué condiciones</td><td>Alta, si está</td></tr>
      </tbody>
    </table>
    <p>La columna que todo el mundo mira es la del valor total, y es justo la que menos dice. Un palé «valorado en 6.500 €» sólo significa que alguien sumó precios de catálogo.</p>'),
    array('h2' => 'Cómo calcular el valor de verdad', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Coge las diez referencias con más peso</b> en el valor total. Suelen ser el 40-60 % del palé.</li>
      <li><b>Busca cada una</b> en la plataforma donde venderías, de segunda mano, y apunta la <b>mediana</b> de lo que se pide.</li>
      <li><b>Multiplica por la cantidad</b> del manifiesto.</li>
      <li><b>Aplica un 70 %</b> de porcentaje de venta y réstale un 20 % de lo que no servirá.</li>
      <li><b>Extrapola al resto</b> del palé por proporción de valor.</li>
    </ol>
    <p>Si ese número no es al menos el doble de lo que te piden por el palé, no lo compres. Es conservador a propósito: las cuentas optimistas se pagan caras.</p>'),
    array('h2' => 'Señales de un manifiesto que no vale nada', 'html' =>
'    <ul>
      <li><b>Sin referencias, sólo descripciones genéricas.</b> «Electrónica varia, 40 uds» no es un manifiesto.</li>
      <li><b>PVP redondos y repetidos.</b> Veinte productos distintos a 49,99 € significa que los ha puesto a ojo.</li>
      <li><b>No corresponde al peso.</b> Si el manifiesto suma 40 kg de producto y el palé pesa 210, faltan 170 kg de algo.</li>
      <li><b>Sin columna de estado.</b> Un manifiesto sin grado no te dice si eso funciona.</li>
      <li><b>Fecha vieja o sin fecha.</b> El manifiesto es de ese palé, no de uno parecido del mes pasado.</li>
    </ul>'),
    array('h2' => 'Manifestado no es garantizado', 'html' =>
'    <p>Un manifiesto dice lo que se supone que hay. No dice que funcione, no dice que esté completo y, si el palé no se ha abierto, nadie lo ha comprobado.</p>
    <p>Por eso un palé manifestado sin clasificar vale más que uno a ciegas, pero bastante menos que uno clasificado con grado. Son tres productos distintos y tres precios distintos.</p>
    <p class="nota-destacada">Nuestro palé mixto se vende sin clasificar y con manifiesto por correo tras el pedido. Los lotes clasificados no llevan manifiesto porque llevan algo mejor: el contenido publicado en la ficha antes de que compres, con el grado puesto.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Me pueden dar el manifiesto antes de pagar?', 'r' => 'En muchos proveedores sí, y es razonable pedirlo. En el palé mixto nuestro llega con el camión y te lo pasamos tras el pedido, que es cuando lo tenemos.'),
    array('p' => '¿El manifiesto incluye marcas?', 'r' => 'Los buenos sí, en la descripción. Es la información más útil de todo el documento.'),
    array('p' => '¿Y si lo que llega no coincide con el manifiesto?', 'r' => 'Fotos nada más abrir y reclamación por escrito esa misma semana. Con un desvío pequeño hay que contar; con uno grande, no.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'el-efecto-enero-por-que-sobran-devoluciones',
  'titulo' => 'El efecto enero: por qué sobran devoluciones después de Navidad',
  'h1' => 'El efecto enero',
  'desc' => 'Por qué enero es el mes con más devoluciones del año, qué llega en los camiones de esas semanas y cómo aprovecharlo comprando en el momento adecuado.',
  'entradilla' => 'La mayor oleada de devoluciones del año llega en las dos semanas siguientes a Reyes. Qué trae, por qué es el mejor momento para comprar y el peor para vender.',
  'img' => 'assets/img/lote-jardin.webp',
  'imgAlt' => 'Palé recién descargado esperando turno en la mesa de clasificación',
  'fecha' => '2026-08-21', 'minutos' => 6,
  'tema' => 'Sector',
  'bloques' => array(
    array('h2' => 'De dónde sale la avalancha', 'html' =>
'    <p>En noviembre y diciembre se concentra una parte enorme de las compras online del año. Con los plazos de devolución ampliados por campaña, todo lo que no gustó vuelve entre el 7 de enero y mediados de febrero, casi de golpe.</p>
    <p>A eso se le suman tres cosas que sólo pasan en enero: regalos duplicados, tallas compradas a ojo para otra persona y compras de impulso del Black Friday de las que uno se arrepiente seis semanas después.</p>'),
    array('h2' => 'Qué llega en esos camiones', 'html' =>
'    <ul>
      <li><b>Mucho textil y calzado.</b> Tallas regaladas mal, sin estrenar y con etiqueta. Es el mejor material del año.</li>
      <li><b>Electrónica de regalo.</b> Auriculares, altavoces, smartwatches. Cajas abiertas y poco más.</li>
      <li><b>Juguete duplicado.</b> Lo mismo dos veces en la misma casa.</li>
      <li><b>Pequeño electrodoméstico.</b> La freidora que no cabía en la cocina.</li>
      <li><b>Deporte.</b> Empieza en enero por los propósitos, pero el que vuelve lo hace en marzo.</li>
    </ul>'),
    array('h2' => 'La jugada', 'html' =>
'    <p><b>Compra en enero y febrero.</b> Es cuando hay más material, de mejor grado y a mejor precio, porque los almacenes están saturados y hay prisa por mover.</p>
    <p><b>No esperes vender mucho en enero.</b> La gente acaba de gastar y está en cuesta. Salvo deporte y organización del hogar, el mes es flojo.</p>
    <p><b>Vende de marzo en adelante.</b> Para entonces tienes el stock comprado barato, clasificado y fotografiado, y el mercado ha vuelto.</p>
    <p class="nota-destacada">Dicho de otra forma: enero y febrero son meses de almacén, no de caja. Quien lo entiende compra bien una vez al año.</p>'),
    array('h2' => 'El otro efecto: la calidad', 'html' =>
'    <p>Lo que vuelve en enero está, de media, en mejor estado que lo que vuelve el resto del año. Casi todo son regalos sin abrir o abiertos y vueltos a cerrar, no productos usados y devueltos por fallo.</p>
    <p>Por eso los lotes que salen de los camiones de enero tienen más grado A de lo habitual. Si te interesa ese material concreto, apúntate a la lista de avisos y te escribimos cuando descarguemos.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Los precios bajan en enero?', 'r' => 'Sí, en origen. Hay más oferta y prisa por mover volumen. Es el mejor momento del año para comprar palés.'),
    array('p' => '¿Merece la pena guardar stock de enero hasta Navidad?', 'r' => 'En juguete y regalo, sí, si tienes espacio. En moda no: la temporada manda.'),
    array('p' => '¿Cuándo llegan esos camiones a vuestra nave?', 'r' => 'Entre mediados de enero y finales de febrero. Se anuncia en la portada con la cuenta atrás del jueves.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'garantia-y-devoluciones-al-revender',
  'titulo' => 'Garantía y devoluciones cuando revendes: qué te toca',
  'h1' => 'Garantía al revender',
  'desc' => 'Qué obligaciones tienes al revender productos de devolución: garantía legal, derecho de desistimiento, qué hay que decir en el anuncio y cómo evitar reclamaciones.',
  'entradilla' => 'Vender de segunda mano no te libra de responder. Qué te toca según vendas como particular o como profesional, qué hay que decir en el anuncio y cómo no acabar en una reclamación.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Nave con producto clasificado y etiquetado por grados',
  'fecha' => '2026-08-19', 'minutos' => 7,
  'tema' => 'Legal',
  'bloques' => array(
    array('h2' => 'Antes de nada', 'html' =>
'    <p class="aviso-honesto"><b>Esto no es asesoramiento legal.</b> Es el marco general para que sepas por dónde van los tiros. Para tu caso concreto, un profesional.</p>'),
    array('h2' => 'Particular o profesional: no es lo mismo', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Vendes como particular</th><th>Vendes como profesional</th></tr></thead>
      <tbody>
        <tr><td>Garantía legal</td><td>No aplica como tal</td><td>Sí, con plazos reducidos posibles en bienes de segunda mano si se pacta</td></tr>
        <tr><td>Desistimiento 14 días</td><td>No</td><td>Sí, en venta a distancia</td></tr>
        <tr><td>Responder de lo descrito</td><td>Sí</td><td>Sí, y más estrictamente</td></tr>
        <tr><td>Factura</td><td>No obligatoria</td><td>Obligatoria a quien la pida</td></tr>
      </tbody>
    </table>
    <p>Y aquí está la trampa en la que cae mucha gente: si compras para revender de forma habitual, eres profesional aunque vendas desde una cuenta personal. La etiqueta de la plataforma no decide tu condición jurídica.</p>'),
    array('h2' => 'Qué hay que decir en el anuncio', 'html' =>
'    <ul>
      <li><b>Que es producto de devolución o liquidación.</b> Es verdad, suena bien y evita la sorpresa.</li>
      <li><b>El estado real</b>, con foto del defecto si lo hay.</li>
      <li><b>Qué incluye y qué no.</b> Cables, manual, caja, accesorios.</li>
      <li><b>Si la garantía del fabricante no aplica</b>, dilo. En liquidación es lo normal.</li>
      <li><b>Nunca «nuevo» si está abierto.</b> «Nuevo, caja abierta» es honesto; «nuevo» a secas, no.</li>
    </ul>
    <p>Casi todas las reclamaciones que acaban mal vienen de una descripción optimista, no de un producto malo.</p>'),
    array('h2' => 'Cómo se evitan las reclamaciones', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Prueba antes de publicar.</b> Todo lo eléctrico, enchufado.</li>
      <li><b>Fotografía el defecto</b> y descríbelo con palabras, no sólo con la foto.</li>
      <li><b>Empaqueta bien.</b> La mitad de los «llegó roto» son embalaje, no producto.</li>
      <li><b>Guarda el justificante</b> de envío y una foto del paquete cerrado.</li>
      <li><b>Responde rápido cuando hay problema.</b> Un cambio resuelto en 24 horas no acaba en reclamación; uno ignorado tres días, sí.</li>
    </ol>'),
    array('h2' => 'Lo que nosotros respondemos', 'html' =>
'    <p>Como vendedor profesional respondemos de que lo entregado sea conforme a lo descrito. Tienes 14 días de desistimiento en compra a distancia, con el lote completo y en el mismo estado, salvo el palé mixto, que se vende cerrado y lo avisamos en su ficha antes de comprar.</p>
    <p>Si algo llega roto o no era lo descrito, el transporte de vuelta lo pagamos nosotros. Haz fotos antes de retirar el precinto: es lo que pide la agencia.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Tengo que dar garantía si revendo?', 'r' => 'Si vendes como profesional, sí, respondes de la conformidad del producto. En bienes de segunda mano el plazo puede pactarse más corto que el general, pero no desaparece.'),
    array('p' => '¿Puedo poner «no se admiten devoluciones»?', 'r' => 'Como profesional en venta a distancia, no: el desistimiento de 14 días es un derecho del comprador y una cláusula así no lo elimina.'),
    array('p' => '¿Y si el comprador rompe el producto y dice que llegó así?', 'r' => 'Pasa. Por eso las fotos antes de enviar y el empaquetado cuidado no son manías: son tu prueba.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'de-hobby-a-negocio-cuando-dar-el-salto',
  'titulo' => 'De hobby a negocio: cuándo dar el salto revendiendo',
  'h1' => 'De hobby a negocio',
  'desc' => 'Las señales de que revender ha dejado de ser un hobby, qué cambia cuando das el salto y los números que hay que tener antes de dejar otra cosa.',
  'entradilla' => 'Hay un punto en el que esto deja de ser vender lo que sobra y pasa a ser una actividad. Las señales, lo que cambia y los números que conviene tener antes de decidir.',
  'img' => 'assets/img/lote-pale-mixto.webp',
  'imgAlt' => 'Palé mixto completo, el formato de quien ya compra a volumen',
  'fecha' => '2026-08-17', 'minutos' => 7,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Las señales', 'html' =>
'    <ul>
      <li><b>Compras para vender</b>, no vendes lo que te sobra. Esta sola ya cambia tu situación legal.</li>
      <li><b>Repites cada mes.</b> La habitualidad es el criterio que mira la Administración.</li>
      <li><b>Llevas cuentas</b> porque ya no te caben en la cabeza.</li>
      <li><b>El espacio se te ha quedado pequeño</b> y estás mirando trasteros.</li>
      <li><b>Te escriben para preguntarte si tienes más</b> de algo. Eso es demanda, y es la señal más valiosa.</li>
    </ul>
    <p>Con tres de las cinco, ya estás dentro aunque no lo hayas decidido.</p>'),
    array('h2' => 'Qué cambia al dar el salto', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Antes</th><th>Después</th></tr></thead>
      <tbody>
        <tr><td>Compra</td><td>Un lote cuando puedes</td><td>Palés y precio cerrado</td></tr>
        <tr><td>Precio por referencia</td><td>5 - 13 €</td><td>6 € o menos</td></tr>
        <tr><td>Gastos fijos</td><td>Casi ninguno</td><td>Cuota, gestoría, espacio</td></tr>
        <tr><td>IVA</td><td>Lo pagas y ya</td><td>Lo recuperas</td></tr>
        <tr><td>Clientes</td><td>Particulares</td><td>También tiendas y puestos</td></tr>
      </tbody>
    </table>
    <p>Lo importante de esa tabla es la fila del IVA y la del precio por referencia. Juntas compensan buena parte de los gastos fijos si el volumen acompaña.</p>'),
    array('h2' => 'Los números antes de decidir', 'html' =>
'    <p>Antes de dar el salto conviene tener, sostenido tres meses seguidos:</p>
    <ol class="pasos-lista">
      <li><b>Un margen mensual que cubra los gastos fijos</b> y sobre. Cuota, gestoría y espacio son unos 400-500 € al mes.</li>
      <li><b>Un porcentaje de venta por encima del 75 %.</b> Si vendes el 60 % de lo que compras, más volumen sólo significa más stock parado.</li>
      <li><b>Un canal que funcione sin ti mirándolo cada hora.</b> Tiendas, puesto fijo o una plataforma donde ya tengas valoraciones.</li>
      <li><b>Dinero para dos compras por delante.</b> Sin colchón, la primera semana floja te obliga a malvender.</li>
    </ol>'),
    array('h2' => 'Lo que nadie cuenta del salto', 'html' =>
'    <p class="aviso-honesto">Que el trabajo cambia. Cuando esto era un hobby, la parte divertida era abrir cajas y encontrar cosas. Cuando es un negocio, la mayor parte del tiempo es fotografiar, responder mensajes repetidos, empaquetar y llevar paquetes. La parte divertida se reduce a una mañana al mes.</p>
    <p>Mucha gente que da el salto por los números lo deja por esto otro. Conviene saberlo antes, no después de firmar el alquiler del trastero.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto hay que facturar para que compense darse de alta?', 'r' => 'Con los gastos fijos habituales, el punto suele estar entre 700 y 1.000 € de margen mensual sostenido. Por debajo, la cuota se lo come.'),
    array('p' => '¿Se puede compaginar con un trabajo?', 'r' => 'Es lo más habitual y suele ser la mejor forma de empezar: los gastos fijos los cubre el sueldo mientras el negocio coge volumen.'),
    array('p' => '¿Qué comprar cuando ya haces volumen?', 'r' => 'Palés en lugar de lotes, y precio cerrado con reserva del camión. Está en <a href="../devoluciones-de-amazon-al-por-mayor.html">venta al por mayor</a>.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'glosario-de-la-liquidacion',
  'titulo' => 'Glosario de la liquidación: 40 términos explicados',
  'h1' => 'Glosario de la liquidación',
  'desc' => 'Los cuarenta términos que se usan al comprar devoluciones y liquidaciones, explicados en una línea cada uno: grados, manifiesto, gaylord, REBU, mermas y más.',
  'entradilla' => 'Todas las palabras raras del sector, en una línea cada una. Para tener abierto mientras lees un anuncio y saber si quien lo escribe sabe de qué habla.',
  'img' => 'assets/img/clasificacion.webp',
  'imgAlt' => 'Etiquetas de grado y referencias sobre la mesa de clasificación',
  'fecha' => '2026-08-15', 'minutos' => 8,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Mercancía y estado', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Término</th><th>Qué significa</th></tr></thead>
      <tbody>
        <tr><td>Devolución</td><td>Producto que el cliente devolvió. Puede estar sin estrenar.</td></tr>
        <tr><td>Excedente</td><td>Lo que no se vendió a tiempo. Producto nuevo.</td></tr>
        <tr><td>Resto de serie</td><td>Lo que quedó de una producción. Nuevo.</td></tr>
        <tr><td>Grado A</td><td>Sin usar. Caja abierta como mucho.</td></tr>
        <tr><td>Grado B</td><td>Marcas de uso leves o caja dañada. Funciona.</td></tr>
        <tr><td>Grado C</td><td>Para piezas o reparación.</td></tr>
        <tr><td>Sin clasificar</td><td>Nadie lo ha abierto. No es un grado.</td></tr>
        <tr><td>Caja abierta</td><td>Producto nuevo cuyo precinto se rompió.</td></tr>
        <tr><td>Embalaje dañado</td><td>Producto correcto, caja golpeada.</td></tr>
        <tr><td>Merma</td><td>Lo que no se puede vender. Entre el 15 y el 30 % en sin clasificar.</td></tr>
        <tr><td>Reacondicionado</td><td>Revisado y reparado con garantía. Otro mercado, otro precio.</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Formatos y logística', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Término</th><th>Qué significa</th></tr></thead>
      <tbody>
        <tr><td>Lote</td><td>Caja cerrada con un número fijo de unidades de una categoría.</td></tr>
        <tr><td>Palé</td><td>Europalé retractilado. De 58 a 250 kg.</td></tr>
        <tr><td>Europalé (EUR)</td><td>El estándar europeo: 120×80 cm de base.</td></tr>
        <tr><td>Gaylord</td><td>Caja grande de cartón sobre palé, típica de textil.</td></tr>
        <tr><td>Retractilado</td><td>Envuelto en film plástico para que no se mueva.</td></tr>
        <tr><td>Camión completo / FTL</td><td>Tráiler entero, unos 24 palés.</td></tr>
        <tr><td>Grupaje</td><td>Tu palé viaja con los de otros. Más barato y más lento.</td></tr>
        <tr><td>Plataforma elevadora</td><td>El camión baja el palé a la calle. Pídela si no tienes muelle.</td></tr>
        <tr><td>Transpaleta</td><td>Carretilla manual para mover palés.</td></tr>
        <tr><td>Muelle</td><td>Plataforma a la altura del camión. Si lo tienes, no necesitas nada más.</td></tr>
        <tr><td>Albarán</td><td>Papel que acompaña la mercancía con lo que va dentro.</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Compra y documentación', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Término</th><th>Qué significa</th></tr></thead>
      <tbody>
        <tr><td>Manifiesto</td><td>Listado de referencias, cantidades y PVP de un palé.</td></tr>
        <tr><td>SKU / referencia</td><td>El código que identifica un producto concreto.</td></tr>
        <tr><td>PVP estimado</td><td>Suma de precios de catálogo. No es lo que vas a cobrar.</td></tr>
        <tr><td>A ciegas</td><td>Sin manifiesto y sin abrir. El formato más barato y más arriesgado.</td></tr>
        <tr><td>Liquidador</td><td>Empresa que compra excedentes por camiones y los revende.</td></tr>
        <tr><td>Contrarreembolso</td><td>Pagas al transportista cuando llega. Tu red de seguridad.</td></tr>
        <tr><td>Desistimiento</td><td>Los 14 días para devolver una compra a distancia.</td></tr>
        <tr><td>REBU</td><td>Régimen especial de bienes usados: se tributa por el margen. Pregunta a tu gestor.</td></tr>
        <tr><td>Factura recapitulativa</td><td>Una factura mensual que agrupa varias compras.</td></tr>
        <tr><td>Epígrafe IAE</td><td>La clasificación de tu actividad ante Hacienda.</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Reventa', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Término</th><th>Qué significa</th></tr></thead>
      <tbody>
        <tr><td>Rotación</td><td>Lo rápido que se vende el stock. Manda más que el margen.</td></tr>
        <tr><td>Ticket medio</td><td>Lo que gasta de media cada comprador.</td></tr>
        <tr><td>Margen bruto</td><td>Venta menos coste de la mercancía. Sin contar tu tiempo.</td></tr>
        <tr><td>Margen neto</td><td>Lo anterior menos TODOS los gastos, tu tiempo incluido.</td></tr>
        <tr><td>Stock muerto</td><td>Lo que lleva meses sin moverse. Ocupa y pierde valor.</td></tr>
        <tr><td>Pack</td><td>Varias piezas juntas a precio de menos. La salida del stock parado.</td></tr>
        <tr><td>Venta en mano</td><td>Sin envío ni comisión. Donde está el margen en piezas baratas.</td></tr>
        <tr><td>Doorway page</td><td>Página que promete algo para enseñarte otra cosa. Google las penaliza.</td></tr>
      </tbody>
    </table>'),
  ),
  'faq' => array(
    array('p' => '¿Hay un estándar oficial de grados?', 'r' => 'No. Cada liquidador usa su escala. Lo que sí puedes exigir es que te expliquen qué entienden por cada letra; si no saben, no clasifican.'),
    array('p' => '¿Qué término debería preocuparme más al leer un anuncio?', 'r' => '«Valor estimado» sin lista detrás, y «grado A» en un palé de doscientas referencias sin abrir. Las dos cosas son contradicciones.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'los-productos-que-mas-se-devuelven',
  'titulo' => 'Los productos que más se devuelven (y por qué importa)',
  'h1' => 'Lo que más se devuelve',
  'desc' => 'Qué categorías tienen más devoluciones en el comercio online, por qué se devuelven y qué significa eso para quien compra lotes de liquidación.',
  'entradilla' => 'La tasa de devolución explica por qué unos lotes son baratos y otros no existen. Categoría a categoría, con el motivo real detrás de cada una.',
  'img' => 'assets/img/lote-moda.webp',
  'imgAlt' => 'Prendas devueltas en bolsa con su etiqueta, el caso más habitual de devolución',
  'fecha' => '2026-08-13', 'minutos' => 6,
  'tema' => 'Sector',
  'bloques' => array(
    array('h2' => 'El ranking, con el motivo', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Categoría</th><th>Devolución</th><th>Motivo principal</th></tr></thead>
      <tbody>
        <tr><td>Moda y calzado</td><td>Muy alta</td><td>Talla. Se piden dos para quedarse una</td></tr>
        <tr><td>Electrónica de consumo</td><td>Alta</td><td>«No era lo que esperaba» y regalo duplicado</td></tr>
        <tr><td>Pequeño electrodoméstico</td><td>Media-alta</td><td>Tamaño: no cabía donde se pensaba</td></tr>
        <tr><td>Monitores y pantallas</td><td>Media-alta</td><td>Tamaño y soporte incompatible</td></tr>
        <tr><td>Juguete</td><td>Media</td><td>Duplicado en Navidad, edad equivocada</td></tr>
        <tr><td>Puericultura</td><td>Media</td><td>Regalo repetido, no encaja con el coche</td></tr>
        <tr><td>Herramienta</td><td>Baja</td><td>Compra meditada, pocas sorpresas</td></tr>
        <tr><td>Consumibles y droguería</td><td>Muy baja</td><td>No se devuelve casi nunca</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Por qué esto te importa', 'html' =>
'    <p>La tasa de devolución de una categoría determina dos cosas: <b>cuánta mercancía hay</b> en el mercado de liquidación y <b>en qué estado llega</b>.</p>
    <p>Moda tiene mucha devolución y de muy buena calidad (prenda sin estrenar), por eso el lote de moda es grado A y sale a 4,90 € la prenda. Herramienta tiene poca devolución, por eso los lotes son más caros por unidad y más difíciles de encontrar.</p>
    <p>Y por eso no existen los lotes baratos de consumibles: no se devuelven.</p>'),
    array('h2' => 'Devolución no es avería', 'html' =>
'    <p>Es la confusión que más dinero le cuesta a la gente que empieza. En las categorías de arriba, el motivo dominante no es que el producto falle: es talla, tamaño, duplicado o arrepentimiento.</p>
    <p>Eso significa que la mayor parte de lo que llega en un camión de devoluciones <b>funciona perfectamente</b>. El porcentaje que no sirve existe, y en un palé sin clasificar ronda el 15-20 %, pero no es la norma: es la excepción que hay que meter en las cuentas.</p>'),
    array('h2' => 'Lo que sí llega roto', 'html' =>
'    <ul>
      <li><b>Lo frágil y voluminoso.</b> Cristal, cerámica, pantallas grandes: se rompe en el transporte de vuelta.</li>
      <li><b>Lo que se devolvió por avería real.</b> Es minoría, y es lo que se aparta al clasificar.</li>
      <li><b>Lo que lleva batería con muchos ciclos.</b> Funciona, pero no como nuevo.</li>
      <li><b>Lo que ya volvió una vez</b> y se volvió a vender: cada ciclo lo desgasta.</li>
    </ul>
    <p>En un lote clasificado, todo eso debería haberse apartado antes de precintar. Si te llega, reclama esa misma semana con fotos.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Qué categoría tiene mejor relación precio-estado?', 'r' => 'Moda, sin discusión: mucha devolución, casi toda sin estrenar y el precio por unidad más bajo del catálogo.'),
    array('p' => '¿Por qué no hay lotes de alimentación o droguería?', 'r' => 'Porque no se devuelven, y porque la caducidad y la cadena de frío hacen que no sea un producto de liquidación al uso.'),
    array('p' => '¿La tasa de devolución sube en Navidad?', 'r' => 'Muchísimo. Entre el 7 de enero y mediados de febrero llega la mayor oleada del año. Lo contamos en <a href="el-efecto-enero-por-que-sobran-devoluciones.html">el efecto enero</a>.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-negociar-el-precio-de-un-palet',
  'titulo' => 'Cómo negociar el precio de un palé sin quedar mal',
  'h1' => 'Negociar un palé',
  'desc' => 'Qué se puede negociar al comprar palés de liquidación y qué no, cuándo hay margen de verdad y las frases que funcionan con un proveedor serio.',
  'entradilla' => 'Qué tiene margen de verdad, qué no lo tiene nunca, y cómo pedirlo sin que el proveedor te apunte en la lista de los que hacen perder el tiempo.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Palés en el muelle esperando a ser cargados en ruta',
  'fecha' => '2026-08-11', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Lo que tiene margen y lo que no', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Concepto</th><th>¿Se negocia?</th><th>Cuánto</th></tr></thead>
      <tbody>
        <tr><td>Precio de un lote suelto</td><td>Casi nunca</td><td>0 %</td></tr>
        <tr><td>Precio a partir de 3 palés</td><td>Sí</td><td>5 - 15 %</td></tr>
        <tr><td>Compra recurrente mensual</td><td>Sí</td><td>10 - 20 %</td></tr>
        <tr><td>Transporte agrupado</td><td>Sí</td><td>Bastante</td></tr>
        <tr><td>Reserva del próximo camión</td><td>Sí, con señal</td><td>Prioridad, no precio</td></tr>
        <tr><td>Pago aplazado</td><td>A partir de la tercera compra</td><td>—</td></tr>
        <tr><td>Que te dejen elegir piezas</td><td>No</td><td>Es otro producto</td></tr>
      </tbody>
    </table>
    <p>La fila que más gente intenta y menos funciona es la última. Pedir lote cerrado a precio de lote pero eligiendo lo bueno es pedir dos cosas incompatibles.</p>'),
    array('h2' => 'Cuándo hay margen de verdad', 'html' =>
'    <ul>
      <li><b>Cuando compras volumen.</b> Es el único argumento que mueve el precio siempre.</li>
      <li><b>Cuando te comprometes a repetir.</b> Un cliente mensual vale más que tres compras sueltas.</li>
      <li><b>Cuando recoges tú.</b> Si te ahorras el porte al proveedor, parte de ese ahorro es negociable.</li>
      <li><b>Al final de una categoría.</b> Cuando queda poco de un camión y va a entrar otro, hay prisa por mover.</li>
      <li><b>Cuando pagas al momento.</b> En este sector la liquidez pesa.</li>
    </ul>'),
    array('h2' => 'Cómo pedirlo', 'html' =>
'    <p>Lo que funciona es concreto y con compromiso detrás:</p>
    <p class="nota-destacada">«Quiero tres palés de hogar este mes y, si va bien, dos al mes. ¿Qué precio me haces por los tres, con el porte incluido?»</p>
    <p>Lo que no funciona, y te apunta en la lista de los pesados:</p>
    <ul>
      <li>«¿Es tu mejor precio?» sin decir qué vas a comprar.</li>
      <li>«En otro sitio lo tengo más barato», sin enseñar cuál.</li>
      <li>Regatear un lote suelto de 319 €.</li>
      <li>Pedir descuento y luego no comprar. Se recuerda.</li>
    </ul>'),
    array('h2' => 'Negocia otras cosas, no solo el precio', 'html' =>
'    <p>Muchas veces hay más valor fuera del precio: que te aparten la categoría del camión antes de publicarla, que te agrupen el transporte de tres pedidos, que te manden fotos del palé antes de cargarlo, que te hagan factura recapitulativa mensual.</p>
    <p>Eso cuesta poco al proveedor y a ti te resuelve problemas reales. Y se concede antes que un descuento.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Se negocia el primer pedido?', 'r' => 'Poco. La confianza se construye con la segunda y la tercera compra, y ahí es donde el precio se mueve de verdad.'),
    array('p' => '¿Y si no me hacen descuento?', 'r' => 'Pregunta por el transporte agrupado o por la reserva de categoría. Casi siempre hay algo que sí pueden darte.'),
    array('p' => '¿Cuánto es un descuento razonable por volumen?', 'r' => 'Entre un 5 y un 15 % a partir de tres palés. Por encima del 25 %, sospecha: o el precio de partida estaba inflado o el material no es el que dicen.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'que-hacer-al-recibir-un-palet',
  'titulo' => 'Qué hacer al recibir un palé: las dos primeras horas',
  'h1' => 'Al recibir un palé',
  'desc' => 'Qué comprobar antes de firmar, cómo descargar sin romper nada, cómo abrir un palé retractilado y qué hacer en las dos primeras horas.',
  'entradilla' => 'Lo que se hace en las dos primeras horas decide si una reclamación es posible o no. Antes de firmar, al descargar y al abrir.',
  'img' => 'assets/img/lote-herramientas.webp',
  'imgAlt' => 'Palé recién descargado, todavía retractilado, junto a la mesa de trabajo',
  'fecha' => '2026-08-09', 'minutos' => 6,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Antes de firmar', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Mira el bulto entero</b> con el transportista delante. Film roto, esquinas aplastadas, cajas abiertas.</li>
      <li><b>Haz fotos ahí mismo</b>, con el palé todavía en el camión o en el suelo, sin tocar.</li>
      <li><b>Si ves daño, escríbelo en el albarán</b> antes de firmar. «Recibido con reservas por film roto y caja superior aplastada». Firmar limpio un palé dañado te deja sin reclamación.</li>
      <li><b>Cuenta los bultos.</b> Si el albarán dice dos y hay uno, no firmes por dos.</li>
      <li><b>Si el daño es grave, recházalo.</b> Es tu derecho y es más limpio que discutirlo después.</li>
    </ol>
    <p class="nota-destacada">Con contrarreembolso, esta es tu mejor baza: miras antes de pagar. Es justo para lo que sirve.</p>'),
    array('h2' => 'La descarga', 'html' =>
'    <ul>
      <li><b>Con muelle:</b> transpaleta y adentro. Nada que explicar.</li>
      <li><b>Sin muelle:</b> tienes que haber pedido plataforma elevadora al hacer el pedido. Si no la pediste, el transportista no está obligado a bajarlo.</li>
      <li><b>A mano, nunca.</b> Un palé de 200 kg no se descarga entre dos personas. Se desmonta por capas desde arriba, con el palé todavía en el suelo.</li>
      <li><b>Sitio despejado antes de que llegue.</b> Mover un palé ya descargado es lo que rompe cosas y espaldas.</li>
    </ul>'),
    array('h2' => 'Abrirlo', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Corta el film de arriba abajo</b>, por un lateral, con cúter de hoja corta. Hoja larga corta lo de dentro.</li>
      <li><b>Por capas, desde arriba.</b> Nunca tires del centro: se te viene encima.</li>
      <li><b>Cuatro montones desde el principio:</b> vende solo, necesita trabajo, no sirve, y dudas.</li>
      <li><b>Prueba lo eléctrico según sale</b>, no al final. Es cuando tienes espacio.</li>
      <li><b>Formatea todo lo que tenga memoria.</b> Antes de venderlo, sin excepción.</li>
    </ol>'),
    array('h2' => 'Las dos primeras horas', 'html' =>
'    <p>Cuenta las referencias y compáralas con el manifiesto si lo hay. Fotografía cualquier cosa que no cuadre. Si vas a reclamar, hazlo esa misma semana: los plazos con las agencias son cortos y con el proveedor, cuanto antes, más fácil.</p>
    <p>Y no empieces a fotografiar producto el mismo día. Clasificar y fotografiar son dos tareas distintas: mezclarlas es lo que hace que la gente acabe agotada y con el palé a medio abrir durante un mes.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Puedo abrir el palé delante del transportista?', 'r' => 'No suele haber tiempo ni es lo habitual. Lo que sí puedes es revisar el exterior y firmar con reservas si hay daño.'),
    array('p' => '¿Qué hago si falta mercancía?', 'r' => 'Anótalo en el albarán, haz fotos y avisa al proveedor el mismo día. Sin la anotación en el albarán, la reclamación es mucho más difícil.'),
    array('p' => '¿Cuánto tarda en clasificarse un palé?', 'r' => 'Entre 8 y 15 horas un mixto de 210 referencias. Un palé clasificado por categoría, bastante menos.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-hacer-inventario-de-un-lote',
  'titulo' => 'Cómo hacer inventario de un lote sin volverte loco',
  'h1' => 'Inventario de un lote',
  'desc' => 'Un método simple para inventariar un lote de devoluciones: qué columnas necesitas, cómo numerar las cajas y cómo saber en todo momento qué te queda.',
  'entradilla' => 'Sin inventario, a las tres semanas no sabes qué te queda ni dónde está. Con una hoja de cálculo de seis columnas, sí. Aquí están las seis.',
  'img' => 'assets/img/lote-belleza.webp',
  'imgAlt' => 'Productos contados y agrupados por tipo sobre la mesa de clasificación',
  'fecha' => '2026-08-07', 'minutos' => 5,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Las seis columnas', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Columna</th><th>Para qué</th></tr></thead>
      <tbody>
        <tr><td>Nº</td><td>Un número por pieza. Es su nombre para siempre.</td></tr>
        <tr><td>Qué es</td><td>Marca y modelo. Lo que pondrás en el título del anuncio.</td></tr>
        <tr><td>Caja</td><td>En qué caja está. Sin esto, buscar una pieza son veinte minutos.</td></tr>
        <tr><td>Estado</td><td>A, B o «falta X». Para escribir la descripción sin volver a mirarla.</td></tr>
        <tr><td>Precio de salida</td><td>El que decidiste al inventariar, en frío.</td></tr>
        <tr><td>Vendido por</td><td>Se rellena al vender. Es lo que te dice si tus precios eran buenos.</td></tr>
      </tbody>
    </table>
    <p>Seis columnas. Ni una más el primer año. Las hojas de cálculo con veinte columnas se abandonan a la tercera semana.</p>'),
    array('h2' => 'El sistema de cajas', 'html' =>
'    <p>Cajas de plástico apilables, numeradas por fuera con rotulador grande. Cada pieza va a una caja y el número de caja va en la hoja. En el anuncio, cuando lo publicas, escribe el número de pieza en un campo interno o en tus notas.</p>
    <p>Cuando se vende, abres la hoja, buscas el número y sabes exactamente en qué caja está. Diez segundos en lugar de veinte minutos rebuscando.</p>'),
    array('h2' => 'Cuándo se hace', 'html' =>
'    <p>Al clasificar, no después. Es el único momento en que tienes todo fuera y a la vista. Hacerlo luego significa volver a sacarlo todo.</p>
    <p>Un lote de 64 piezas son unos 40 minutos de inventario si lo haces mientras clasificas. Hecho después, dos horas.</p>'),
    array('h2' => 'Para qué sirve de verdad', 'html' =>
'    <p>Más allá de encontrar cosas, el inventario te da el dato que decide tus compras futuras: <b>qué porcentaje del lote vendiste y a qué precio medio real</b>.</p>
    <p>Con dos lotes inventariados ya sabes si tu estimación de precios era optimista, qué categoría te funciona y cuánto tardas de verdad. Esa información vale más que el margen del primer lote.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Hoja de cálculo o aplicación?', 'r' => 'Hoja de cálculo. Las aplicaciones de inventario están pensadas para catálogos estables, y aquí cada pieza es distinta.'),
    array('p' => '¿Hay que inventariar un palé mixto entero?', 'r' => 'Las piezas de valor, sí. El accesorio de dos euros que vas a vender en packs, por grupos: «caja 7, 30 cables variados».'),
    array('p' => '¿Y si vendo en varios sitios a la vez?', 'r' => 'Añade una séptima columna con dónde está publicado. Es la única ampliación que merece la pena.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'limpiar-y-preparar-producto-de-devolucion',
  'titulo' => 'Limpiar y preparar producto de devolución para vender',
  'h1' => 'Limpiar y preparar',
  'desc' => 'Cómo limpiar y preparar producto de devolución antes de venderlo: qué usar en cada material, qué no hacer nunca y cuánto sube el precio.',
  'entradilla' => 'Media hora de limpieza sube el precio percibido de un lote entero. Qué usar en cada material, qué no tocar nunca y dónde está el límite.',
  'img' => 'assets/img/lote-juguetes.webp',
  'imgAlt' => 'Juguetes limpios y agrupados, listos para fotografiar',
  'fecha' => '2026-08-05', 'minutos' => 5,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Material a material', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Material</th><th>Con qué</th><th>Cuidado con</th></tr></thead>
      <tbody>
        <tr><td>Plástico</td><td>Paño de microfibra y agua con jabón neutro</td><td>El alcohol borra serigrafías</td></tr>
        <tr><td>Pantallas</td><td>Microfibra apenas húmeda</td><td>Productos con amoniaco</td></tr>
        <tr><td>Metal</td><td>Paño seco, y desengrasante suave si hace falta</td><td>Estropajo: raya</td></tr>
        <tr><td>Textil</td><td>Cepillo de ropa y vapor para las arrugas</td><td>Lavar lo que lleva etiqueta puesta</td></tr>
        <tr><td>Calzado</td><td>Cepillo suave y gamuza</td><td>Lavadora</td></tr>
        <tr><td>Adhesivo de etiquetas</td><td>Alcohol isopropílico en el borde</td><td>Empapar la superficie</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Lo que sube el precio', 'html' =>
'    <ul>
      <li><b>Quitar el polvo del transporte.</b> Lo más simple y lo que más se nota en la foto.</li>
      <li><b>Despegar etiquetas de almacén</b> que no son del producto.</li>
      <li><b>Ordenar los cables</b> y meterlos en bolsita. Un cable enredado en la foto resta cinco euros.</li>
      <li><b>Cargar lo eléctrico</b> antes de fotografiar: así puedes enseñarlo encendido.</li>
      <li><b>Planchar o dar vapor</b> a la prenda antes de la foto.</li>
    </ul>'),
    array('h2' => 'Lo que NO hay que hacer', 'html' =>
'    <p class="aviso-honesto">No disimules defectos. Pulir un arañazo para que no salga en la foto es lo que convierte una venta en una reclamación. El arañazo, fotografiado y descrito, no impide la venta: descubrirlo al abrir la caja, sí.</p>
    <ul>
      <li>No laves ropa con la etiqueta puesta: pierde el argumento de «sin estrenar».</li>
      <li>No metas en lavadora calzado ni mochilas técnicas.</li>
      <li>No abras producto precintado para «comprobar»: el precinto vale dinero.</li>
      <li>No uses disolventes en plástico: mata el acabado.</li>
      <li>No vendas producto de higiene usado, por mucho que se pueda limpiar.</li>
    </ul>'),
    array('h2' => 'Cuánto tiempo dedicarle', 'html' =>
'    <p>Un par de minutos por pieza en piezas de más de 20 €. Treinta segundos en las de menos. Si le dedicas diez minutos a un producto de 8 €, estás trabajando gratis.</p>
    <p>Lo eficiente es hacerlo en tanda, igual que las fotos: todas las piezas de una categoría seguidas, con el material ya montado en la mesa.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Merece la pena comprar productos de limpieza específicos?', 'r' => 'Microfibra, jabón neutro y alcohol isopropílico cubren el 95 % de los casos. El resto es marketing.'),
    array('p' => '¿Y el olor a almacén?', 'r' => 'Airear 24 horas resuelve casi todo. En textil, vapor. No uses ambientador: se nota y genera desconfianza.'),
    array('p' => '¿Puedo reembalar en caja nueva?', 'r' => 'Sí, y mejora la percepción, pero no lo vendas como «precintado de fábrica». Eso es otra cosa.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-armar-packs-que-se-venden',
  'titulo' => 'Cómo armar packs que se venden de verdad',
  'h1' => 'Armar packs',
  'desc' => 'Cómo agrupar productos en packs para vender lo que suelto no se mueve: qué juntar, qué precio poner y los errores que hacen que un pack no funcione.',
  'entradilla' => 'El pack es la salida del stock parado y la forma de subir el ticket medio. Qué se junta con qué, a qué precio y por qué la mayoría de los packs no se venden.',
  'img' => 'assets/img/lote-deporte.webp',
  'imgAlt' => 'Bandas, esterillas y accesorios agrupados en conjuntos para vender',
  'fecha' => '2026-08-03', 'minutos' => 5,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Los tres packs que funcionan', 'html' =>
'    <h3>El pack de uso</h3>
    <p>Cosas que se usan juntas: esterilla + bandas + cuerda. El comprador entiende de un vistazo para qué sirve y por qué está junto. Es el que mejor convierte.</p>
    <h3>El pack de cantidad</h3>
    <p>Lo mismo repetido: cinco fundas, diez pares de calcetines, tres peluches. Funciona con producto barato y para quien compra para revender o para regalar.</p>
    <h3>El pack de talla o de edad</h3>
    <p>En textil y juguete: «lote de 8 prendas talla 4 años». Es el que más se busca en Vinted, y resuelve el problema de quien viste a un niño que crece.</p>'),
    array('h2' => 'Lo que no funciona', 'html' =>
'    <ul>
      <li><b>El cajón de sastre.</b> «Lote variado de 12 cosas» no lo compra nadie: no sabe qué está comprando.</li>
      <li><b>Meter lo malo con lo bueno.</b> Se nota, y te tiran el precio del conjunto al nivel de lo peor.</li>
      <li><b>Packs enormes.</b> Más de diez piezas asusta por precio y por envío.</li>
      <li><b>Packs sin foto de todo junto.</b> Si no se ve el conjunto, no se entiende.</li>
    </ul>'),
    array('h2' => 'El precio', 'html' =>
'    <p>La regla que funciona: <b>el pack cuesta lo que costarían dos tercios de las piezas sueltas</b>. Tres piezas de 10 € → pack a 20 €. Suficiente descuento para que compense y suficiente margen para que a ti te salgan las cuentas.</p>
    <p>Y dilo en el anuncio: «suelto serían 30 €, en pack 20 €». Hacer la cuenta por el comprador vende.</p>'),
    array('h2' => 'Cuándo armarlos', 'html' =>
'    <p>No al principio. El primer mes vende suelto, que es donde está el margen. A partir del segundo mes, lo que no tenga movimiento se agrupa.</p>
    <p>Excepción: el accesorio de poco valor (cables, fundas, calcetines) va en pack desde el día uno. Suelto no compensa ni el tiempo de publicarlo.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Se puede mezclar categorías en un pack?', 'r' => 'Sólo si comparten uso o destinatario. Juguete y papelería para un regalo, sí. Un taladro con una crema, no.'),
    array('p' => '¿Cuántas piezas por pack?', 'r' => 'Entre tres y ocho. Por debajo no hay sensación de lote; por encima, el envío y el precio asustan.'),
    array('p' => '¿Y si me piden una pieza suelta del pack?', 'r' => 'Véndesela, si el precio suelto te cuadra. Luego rearmas el pack con otra cosa.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'atencion-al-cliente-al-revender',
  'titulo' => 'Atención al cliente al revender: lo que sí mueve ventas',
  'h1' => 'Atención al cliente',
  'desc' => 'Cómo responder mensajes al vender de segunda mano: tiempos, plantillas, cómo llevar las quejas y por qué responder rápido vende más que bajar el precio.',
  'entradilla' => 'Responder en menos de una hora vende más que bajar el precio un 20 %. Tiempos, respuestas tipo y cómo llevar una queja para que no acabe en valoración negativa.',
  'img' => 'assets/img/lote-bebe.webp',
  'imgAlt' => 'Producto de puericultura preparado y etiquetado para enviar',
  'fecha' => '2026-08-01', 'minutos' => 5,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'El tiempo de respuesta', 'html' =>
'    <p>Es la variable que más influye y la que menos cuesta. Quien pregunta por un producto de segunda mano está preguntando por cuatro a la vez; el que contesta primero se lleva la venta.</p>
    <table class="tabla">
      <thead><tr><th>Respondes en</th><th>Qué pasa</th></tr></thead>
      <tbody>
        <tr><td>Menos de 1 hora</td><td>La mayoría de las ventas se cierran aquí</td></tr>
        <tr><td>1 - 6 horas</td><td>Todavía se cierra bastante</td></tr>
        <tr><td>Más de 24 horas</td><td>Ya ha comprado otra cosa</td></tr>
      </tbody>
    </table>
    <p>No hace falta estar pendiente todo el día: dos o tres pasadas fijas (mañana, tarde, noche) cubren casi todo.</p>'),
    array('h2' => 'Las cuatro respuestas que vas a escribir mil veces', 'html' =>
'    <ul>
      <li><b>«¿Sigue disponible?»</b> → «Sí, disponible. Lo tengo en [tu zona], puedo enviarlo o entregarlo en mano.» Y añade algo que no esté en el anuncio: da conversación.</li>
      <li><b>«¿Lo dejas en X?»</b> (oferta baja) → «Por X no puedo, pero te lo dejo en Y.» Nunca un no seco.</li>
      <li><b>«¿Está nuevo?»</b> → Di exactamente lo que es: «Procede de devolución, sin usar, la caja está abierta.» Nunca «como nuevo» si no lo está.</li>
      <li><b>«¿Cuánto es el envío?»</b> → Tenlo calculado antes de publicar. Dudar aquí pierde ventas.</li>
    </ul>'),
    array('h2' => 'Cuando hay queja', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Responde el mismo día.</b> Una queja ignorada 48 horas se convierte en valoración negativa, siempre.</li>
      <li><b>Pide fotos</b> antes de opinar. Sin acusar a nadie.</li>
      <li><b>Si tienes razón, explícalo con el anuncio delante.</b> «En la foto 4 se veía el arañazo y estaba en la descripción.»</li>
      <li><b>Si no la tienes, resuelve rápido.</b> Devolución o descuento parcial. Discutir por 8 € cuesta más que los 8 €.</li>
      <li><b>No te lo tomes personal.</b> Es el coste de hacer volumen.</li>
    </ol>'),
    array('h2' => 'Las valoraciones son tu capital', 'html' =>
'    <p>En segunda mano, las valoraciones son lo único que te distingue de los otros cuarenta anuncios iguales. Cuestan meses de construir y una tarde de perder.</p>
    <p>Por eso la regla es: describir peor de lo que está, empaquetar mejor de lo necesario y responder antes de lo esperado. Las tres cosas son gratis.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Hay que responder a las ofertas ridículas?', 'r' => 'Sí, educadamente. A veces la segunda oferta de esa misma persona es buena, y contestar siempre te sube la tasa de respuesta del perfil.'),
    array('p' => '¿Y si el comprador desaparece tras reservar?', 'r' => 'Dale 24 horas, avisa y vuelve a publicar. No guardes un producto tres días por una promesa.'),
    array('p' => '¿Se puede automatizar?', 'r' => 'Ten las cuatro respuestas tipo guardadas en el móvil y personaliza una línea. Automatizar del todo se nota y resta.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-elegir-tu-primera-categoria',
  'titulo' => 'Cómo elegir tu primera categoría de reventa',
  'h1' => 'Elegir tu categoría',
  'desc' => 'Cómo elegir con qué categoría empezar a revender según tu tiempo, tu espacio, tu ciudad y lo que sabes valorar. Con una tabla de decisión.',
  'entradilla' => 'La categoría equivocada es el error más caro del principio, y no depende de lo que más te guste: depende de tu tiempo, tu espacio y lo que sabes valorar.',
  'img' => 'assets/img/lote-hogar-cocina.webp',
  'imgAlt' => 'Pequeño electrodoméstico clasificado por tipo en la nave',
  'fecha' => '2026-07-30', 'minutos' => 6,
  'tema' => 'Guía',
  'bloques' => array(
    array('h2' => 'Las cuatro preguntas', 'html' =>
'    <ol class="pasos-lista">
      <li><b>¿Cuánto espacio tienes?</b> Un armario descarta palés y voluminosos.</li>
      <li><b>¿Cuántas horas a la semana?</b> Menos de diez descarta lotes de 120 piezas.</li>
      <li><b>¿Qué sabes valorar?</b> Si no distingues un taladro bueno de uno malo, no empieces por herramienta.</li>
      <li><b>¿Dónde vas a vender?</b> Vinted es textil. Wallapop en mano es todo lo demás. Mercadillo es volumen barato.</li>
    </ol>'),
    array('h2' => 'La tabla de decisión', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Si tú…</th><th>Empieza por</th><th>Por qué</th></tr></thead>
      <tbody>
        <tr><td>No tienes experiencia</td><td>Juguetes (319 €)</td><td>Entrada baja, nada que probar, público amplio</td></tr>
        <tr><td>Vendes en Vinted</td><td>Moda (590 €)</td><td>120 prendas con etiqueta, el comprador paga envío</td></tr>
        <tr><td>Vendes en Wallapop en mano</td><td>Electrónica (549 €)</td><td>Piezas pequeñas y con demanda constante</td></tr>
        <tr><td>Tienes poco espacio</td><td>Belleza (389 €)</td><td>52 piezas pequeñas, cabe en un armario</td></tr>
        <tr><td>Sabes de bricolaje</td><td>Herramientas (489 €)</td><td>Sabes valorar, y eso aquí vale dinero</td></tr>
        <tr><td>Tienes tienda o puesto</td><td>Hogar (429 €)</td><td>Ticket medio alto y rotación buena</td></tr>
        <tr><td>Ya revendes y tienes nave</td><td>Palé mixto (1.290 €)</td><td>El precio por referencia más bajo</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'El error de elegir por gusto', 'html' =>
'    <p>Mucha gente empieza por lo que le gusta: el aficionado a la informática compra el lote de informática. A veces funciona, porque sabe valorar. Pero también es quien se queda las piezas buenas para sí mismo y vende sólo las sobras.</p>
    <p class="aviso-honesto">Si al abrir el lote lo primero que piensas es «esto me lo quedo», has elegido mal la categoría para hacer negocio. Elegirla bien significa que te da igual el producto y te importa el margen.</p>'),
    array('h2' => 'Cuándo cambiar', 'html' =>
'    <p>Después de dos lotes de la misma categoría ya tienes datos: porcentaje vendido, precio medio real y horas invertidas. Si el porcentaje de venta está por debajo del 65 % o el precio medio quedó muy por debajo de tu estimación, cambia.</p>
    <p>No cambies por una mala semana. Cambia por dos lotes seguidos con números malos.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Puedo comprar dos categorías a la vez?', 'r' => 'Puedes, pero el primer mes es mejor una sola: mezclar te impide saber cuál funciona y cuál no.'),
    array('p' => '¿Cuál es la categoría más fácil?', 'r' => 'Juguetes, por entrada baja y por no tener que probar nada. Moda es la de más margen pero exige más tiempo por el volumen de prendas.'),
    array('p' => '¿Y si me equivoco de categoría?', 'r' => 'Se vende igualmente, sólo que más despacio y con menos margen. El lote no se pierde: se aprende.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'el-coste-real-de-tu-tiempo',
  'titulo' => 'El coste real de tu tiempo revendiendo',
  'h1' => 'El coste de tu tiempo',
  'desc' => 'Cómo contar tu tiempo al revender devoluciones, cuántas horas lleva cada tarea de verdad y cómo saber si tu negocio paga tu hora.',
  'entradilla' => 'Casi todas las cuentas que se ven por ahí ignoran el tiempo, y por eso salen espectaculares. Aquí están las horas medidas, tarea a tarea.',
  'img' => 'assets/img/lote-jardin.webp',
  'imgAlt' => 'Palé a medio clasificar, con el trabajo por delante',
  'fecha' => '2026-07-28', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'Las horas de un lote de 64 piezas', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Tarea</th><th>Horas</th><th>Nota</th></tr></thead>
      <tbody>
        <tr><td>Recibir y clasificar</td><td>2 - 3 h</td><td>Cuatro montones y a probar lo eléctrico</td></tr>
        <tr><td>Limpiar y preparar</td><td>1 - 2 h</td><td>En tanda, no pieza a pieza</td></tr>
        <tr><td>Fotografiar</td><td>2 - 3 h</td><td>Todo del tirón con el mismo montaje</td></tr>
        <tr><td>Inventariar</td><td>0,5 - 1 h</td><td>Si lo haces mientras clasificas</td></tr>
        <tr><td>Publicar</td><td>3 - 4 h</td><td>Repartido en varios días</td></tr>
        <tr><td>Responder mensajes</td><td>6 - 8 h</td><td>A lo largo de todo el ciclo</td></tr>
        <tr><td>Empaquetar y enviar</td><td>5 - 6 h</td><td>Incluye desplazamientos</td></tr>
        <tr><td><b>Total</b></td><td><b>20 - 27 h</b></td><td>Por lote</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Ponle un precio', 'html' =>
'    <p>Aunque sea bajo. Diez euros la hora es un buen número de partida: es lo que cobra mucho trabajo manual y te obliga a ser honesto contigo.</p>
    <p>Un lote de 319 € con 22 horas dentro tiene un coste real de 319 + 220 = <b>539 €</b>. Si lo vendes por 750 €, el beneficio no son 431 €: son 211 €. Sigue siendo bueno, pero es otro número.</p>'),
    array('h2' => 'Dónde se va el tiempo de verdad', 'html' =>
'    <p>Mira la tabla otra vez: responder mensajes y empaquetar son la mitad de las horas, y son las dos tareas que nadie cuenta cuando calcula.</p>
    <ul>
      <li><b>Responder</b> se reduce con respuestas tipo y con descripciones que contesten la duda obvia antes de que la pregunten.</li>
      <li><b>Empaquetar</b> se reduce con material preparado y un día fijo de envíos a la semana.</li>
      <li><b>Fotografiar</b> se reduce a la mitad haciéndolo en tanda.</li>
      <li><b>Desplazamientos</b>: acumula y ve una vez, no cada vez.</li>
    </ul>'),
    array('h2' => 'La pregunta que hay que hacerse', 'html' =>
'    <p class="nota-destacada">¿Tu negocio paga tu hora mejor que la alternativa que tienes delante?</p>
    <p>Si la respuesta es no y no va a cambiar con volumen, tienes un hobby rentable, que también está bien, pero conviene llamarlo por su nombre. Si la respuesta es sí, el siguiente paso es comprar más volumen para que la curva mejore: el precio por hora sube con la escala, no con el esfuerzo.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuántas horas por palé mixto?', 'r' => 'Entre 8 y 15 sólo de clasificar, más el resto del ciclo. Cuenta 45-60 horas por palé completo.'),
    array('p' => '¿Se puede reducir mucho ese tiempo?', 'r' => 'Un 30-40 % con método: tandas, respuestas tipo, día fijo de envíos. Del resto no se escapa nadie.'),
    array('p' => '¿Compensa contratar a alguien?', 'r' => 'A partir de cuatro o cinco lotes al mes, para empaquetar y enviar, que es lo más mecánico. Antes de eso, no.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'ferias-y-rastros-el-circuito-espanol',
  'titulo' => 'Ferias y rastros: el circuito de venta en España',
  'h1' => 'Ferias y rastros',
  'desc' => 'Cómo funciona el circuito de rastros, mercadillos y ferias de segunda mano en España, qué se vende en cada uno y cómo entrar.',
  'entradilla' => 'Rastros, mercadillos semanales, ferias de ocasión y mercados de intercambio: cuatro circuitos distintos, con públicos y reglas distintas.',
  'img' => 'assets/img/hero-almacen.webp',
  'imgAlt' => 'Mercancía preparada en cajas para llevar al circuito de mercados',
  'fecha' => '2026-07-26', 'minutos' => 6,
  'tema' => 'Reventa',
  'bloques' => array(
    array('h2' => 'Los cuatro circuitos', 'html' =>
'    <h3>Rastro urbano</h3>
    <p>Dominical, en el centro de las grandes ciudades. Mucho paso, mucha competencia y puestos con años de antigüedad. Entrar cuesta: suele haber lista de espera o sorteo.</p>
    <h3>Mercadillo semanal de pueblo o barrio</h3>
    <p>El circuito más accesible y el que sostiene a la mayoría. Un día fijo por municipio, lo que permite hacer cuatro o cinco a la semana sin repetir público.</p>
    <h3>Feria de ocasión y stock</h3>
    <p>Varias veces al año, en pabellones o plazas, organizadas por asociaciones de comercio. Público que va a comprar, no a pasear. Ticket medio más alto.</p>
    <h3>Mercado de segunda mano temático</h3>
    <p>Juguete, vinilo, ropa vintage, puericultura. Público experto que paga bien lo bueno y no compra saldo. Requiere seleccionar.</p>'),
    array('h2' => 'Qué se vende en cada uno', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Circuito</th><th>Funciona</th><th>No funciona</th></tr></thead>
      <tbody>
        <tr><td>Rastro urbano</td><td>Variado, curiosidad, precio bajo</td><td>Producto caro sin garantía</td></tr>
        <tr><td>Mercadillo semanal</td><td>Textil, menaje, juguete</td><td>Electrónica de más de 40 €</td></tr>
        <tr><td>Feria de stock</td><td>Marca reconocible, hogar, herramienta</td><td>Saldo mezclado sin orden</td></tr>
        <tr><td>Mercado temático</td><td>Piezas seleccionadas del tema</td><td>Todo lo demás</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Cómo entrar', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Ayuntamiento primero.</b> La licencia de venta ambulante es municipal y cada uno tiene su plazo.</li>
      <li><b>Documentación lista:</b> alta en Hacienda, alta en autónomos si procede, seguro de responsabilidad civil y facturas de la mercancía.</li>
      <li><b>Ve antes como cliente.</b> Un domingo mirando te dice qué se vende, a qué precio y qué falta.</li>
      <li><b>Empieza por uno.</b> Montar circuito de cinco mercados con el primer lote es la forma más rápida de quemarse.</li>
    </ol>'),
    array('h2' => 'El stock que hace falta', 'html' =>
'    <p>Para un puesto medio, dos lotes de categorías distintas llenan la mesa y dejan para reponer un par de fines de semana. Para circuito de varios mercados a la semana, el <a href="../lotes/pale-mixto.html">palé mixto</a> sale a cuenta: 6 € la referencia y volumen para aguantar.</p>
    <p>Lo que no falta nunca en un puesto que funciona: juguete, textil y menaje. Son las tres categorías que compra todo el mundo.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuánto cuesta un puesto?', 'r' => 'Entre 15 y 40 € por jornada según municipio y metros. Las ferias de stock son más caras pero venden más.'),
    array('p' => '¿Hace falta carpa?', 'r' => 'En muchos mercadillos es obligatoria. Y aunque no lo sea, en verano sin sombra no aguantas la jornada.'),
    array('p' => '¿Se puede vender sin licencia?', 'r' => 'No. Se inspecciona y se sanciona. Es el trámite más aburrido y el menos opcional.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'devoluciones-para-tiendas-de-barrio',
  'titulo' => 'Devoluciones para tiendas de barrio: cómo usarlas bien',
  'h1' => 'Para tiendas de barrio',
  'desc' => 'Cómo puede una tienda de barrio usar lotes de devoluciones para subir margen: qué comprar, cómo exponerlo y qué decir al cliente.',
  'entradilla' => 'Una tienda pequeña compite mal en precio contra las grandes. Los lotes de liquidación son una de las pocas formas de tener margen de verdad, si se usan bien.',
  'img' => 'assets/img/lote-electronica.webp',
  'imgAlt' => 'Producto clasificado y etiquetado, listo para mostrador',
  'fecha' => '2026-07-24', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'El problema de la tienda pequeña', 'html' =>
'    <p>Comprando a distribuidor, una tienda de barrio paga más caro que una cadena y vende al mismo precio o más. El margen se estrecha hasta que el local no se paga.</p>
    <p>Un lote de liquidación rompe esa ecuación: compras a un 20 % del PVP y vendes a un 40-60 %. Sigues siendo más barato que la cadena y te queda margen de verdad.</p>'),
    array('h2' => 'Qué comprar según la tienda', 'html' =>
'    <table class="tabla">
      <thead><tr><th>Tipo de tienda</th><th>Lote</th><th>Cómo usarlo</th></tr></thead>
      <tbody>
        <tr><td>Bazar</td><td>Palé mixto</td><td>Mesa de gangas rotativa</td></tr>
        <tr><td>Menaje y regalo</td><td>Hogar y cocina</td><td>Escaparate con precio tachado</td></tr>
        <tr><td>Juguetería / papelería</td><td>Juguetes</td><td>Campaña de septiembre a Reyes</td></tr>
        <tr><td>Ferretería</td><td>Herramientas</td><td>Expositor de batería junto a caja</td></tr>
        <tr><td>Informática / reparación</td><td>Informática</td><td>Monitores y periféricos de ocasión</td></tr>
        <tr><td>Ropa multimarca</td><td>Moda</td><td>Rack de oportunidades al fondo</td></tr>
      </tbody>
    </table>'),
    array('h2' => 'Cómo exponerlo sin dañar la tienda', 'html' =>
'    <ul>
      <li><b>Zona propia y señalizada.</b> «Oportunidades» o «Liquidación», separado del producto normal.</li>
      <li><b>Precio visible y tachado.</b> El contraste es lo que vende.</li>
      <li><b>No lo mezcles con el catálogo habitual.</b> Confunde al cliente y devalúa lo demás.</li>
      <li><b>Rota la mesa cada semana.</b> Aunque sea reordenando: el cliente habitual vuelve a mirar.</li>
      <li><b>Lo mejor del lote, al escaparate.</b> Es lo que hace entrar gente nueva.</li>
    </ul>'),
    array('h2' => 'Qué decirle al cliente', 'html' =>
'    <p>La verdad, que además es un buen argumento: «es producto de liquidación, viene de devoluciones, está revisado y por eso está a este precio». Funciona mucho mejor que el silencio, porque el cliente que ve un precio raro se pregunta por qué.</p>
    <p class="aviso-honesto">Lo que no se puede hacer es venderlo como producto nuevo de catálogo con garantía de fabricante. Ni es verdad ni hace falta: el precio ya es el argumento.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Qué margen deja un lote en tienda?', 'r' => 'Comprando a 20 % del PVP y vendiendo a 40-60 %, el margen bruto ronda el 50-65 %. Muy por encima del que deja el distribuidor habitual.'),
    array('p' => '¿Puedo comprar con factura a nombre de la empresa?', 'r' => 'Sí, pon el CIF en el pedido. Y si compras varias veces al mes, factura recapitulativa mensual.'),
    array('p' => '¿Hay compromiso de volumen?', 'r' => 'Ninguno para comprar del catálogo. El compromiso sólo aparece si quieres precio cerrado y reserva de camión.'),
  ),
);

/* --------------------------------------------------------------- */
$ART[] = array(
  'slug' => 'como-crecer-de-un-lote-a-un-palet',
  'titulo' => 'Cómo crecer de un lote a un palé sin atragantarte',
  'h1' => 'De un lote a un palé',
  'desc' => 'Cuándo dar el paso de comprar lotes a comprar palés, qué hace falta antes, cómo cambia el trabajo y qué números conviene tener.',
  'entradilla' => 'El palé es donde está el precio por referencia bajo, pero también donde se atasca mucha gente. Las cuatro cosas que hay que tener antes de dar el paso.',
  'img' => 'assets/img/lote-pale-mixto.webp',
  'imgAlt' => 'Palé mixto completo, retractilado, el siguiente escalón después del lote',
  'fecha' => '2026-07-22', 'minutos' => 6,
  'tema' => 'Negocio',
  'bloques' => array(
    array('h2' => 'La diferencia en números', 'html' =>
'    <table class="tabla">
      <thead><tr><th></th><th>Lote clasificado</th><th>Palé mixto</th></tr></thead>
      <tbody>
        <tr><td>Inversión</td><td>319 - 699 €</td><td>1.290 €</td></tr>
        <tr><td>Referencias</td><td>14 - 120</td><td>~210</td></tr>
        <tr><td>Por referencia</td><td>5 - 30 €</td><td>6 €</td></tr>
        <tr><td>Horas de clasificar</td><td>2 - 3 h</td><td>8 - 15 h</td></tr>
        <tr><td>Lo que no sirve</td><td>Muy poco</td><td>15 - 20 %</td></tr>
        <tr><td>Espacio</td><td>Un rincón</td><td>Garaje o trastero</td></tr>
      </tbody>
    </table>
    <p>Fíjate en que el precio por referencia del palé (6 €) no es mucho mejor que el del lote de moda (4,90 €). El palé gana en volumen y en variedad, no siempre en precio unitario.</p>'),
    array('h2' => 'Las cuatro cosas que hay que tener antes', 'html' =>
'    <ol class="pasos-lista">
      <li><b>Espacio para 1 m³ retractilado</b> y el triple una vez abierto y clasificado.</li>
      <li><b>Un fin de semana entero libre.</b> Clasificar 210 referencias no se hace en ratos sueltos.</li>
      <li><b>Dos lotes vendidos con números buenos.</b> Si no has pasado del 70 % de venta con 64 piezas, con 210 tampoco.</li>
      <li><b>Canal para lo que no encaje.</b> Un palé mixto trae de todo, incluidas categorías que tú no vendes. Sin una salida (mercadillo, tienda, grupo local), se te queda medio palé parado.</li>
    </ol>'),
    array('h2' => 'Cómo cambia el trabajo', 'html' =>
'    <p>Con lotes, el trabajo es vender. Con palés, la mitad del trabajo es <b>clasificar y decidir</b>: qué va a online, qué va a mercadillo, qué va a pack y qué va fuera.</p>
    <p>Esa decisión, tomada rápido y sin sentimentalismos, es lo que separa un palé rentable de un palé que ocupa el garaje seis meses. La regla que funciona: si no sabes en treinta segundos por qué canal sale una pieza, va al montón de packs.</p>'),
    array('h2' => 'El paso intermedio que casi nadie da', 'html' =>
'    <p>Antes del palé mixto hay un escalón que se salta mucha gente: el <b>palé por categoría</b>. Deporte o puericultura, por ejemplo, van en palé por peso, no por estar sin clasificar.</p>
    <p>Te da el volumen y la logística del palé (descarga, espacio, transporte especializado) con la certeza del lote clasificado. Es la forma sensata de probar si puedes con un palé antes de comprar uno a ciegas.</p>'),
  ),
  'faq' => array(
    array('p' => '¿Cuándo sé que estoy listo para un palé?', 'r' => 'Cuando hayas vendido dos lotes por encima del 70 %, tengas el espacio y tengas una salida para lo que no sea tu categoría.'),
    array('p' => '¿Puedo comprar medio palé?', 'r' => 'No. La unidad es el palé. Lo que sí puedes es empezar por un palé por categoría, que es más previsible que el mixto.'),
    array('p' => '¿Y si el palé sale malo?', 'r' => 'Puede pasar: es el riesgo que estás comprando y por eso cuesta lo que cuesta. Con uno malo no se juzga el formato; con tres, sí.'),
  ),
);

/* =============================================================
   Montaje de las páginas del blog
   ============================================================= */

$INDICE = array();

foreach ($ART as $i => $a) {
    /* Los otros artículos, para enlazar dentro del blog */
    $otros = array();
    foreach ($ART as $o) {
        if ($o['slug'] === $a['slug']) { continue; }
        $otros[] = array('k' => $o['tema'], 't' => $o['h1'], 'u' => 'blog/' . $o['slug'] . '.html', 'd' => $o['entradilla']);
    }
    shuffle_estable($otros, $a['slug']);
    $otros = array_slice($otros, 0, 3);
    $otros[] = array('k' => 'Comprar', 't' => 'Ver los lotes en venta', 'u' => 'comprar-devoluciones-de-amazon.html', 'd' => 'Diez lotes clasificados, desde 319 € con IVA y envío incluidos.');

    $PAGINAS[] = array(
      'ruta' => 'blog/' . $a['slug'] . '.html',
      'titulo' => $a['titulo'],
      'desc' => $a['desc'],
      'kicker' => $a['tema'] . ' · ' . $a['minutos'] . ' min de lectura · Actualizado ' . date('d/m/Y', strtotime($a['fecha'])),
      'h1' => $a['h1'],
      'entradilla' => e($a['entradilla']),
      'img' => $a['img'],
      'imgAlt' => $a['imgAlt'],
      'ogTipo' => 'article',
      'ogTitulo' => $a['titulo'],
      'migas' => array(
        array('t' => 'Inicio', 'u' => 'index.html'),
        array('t' => 'Guías', 'u' => 'blog/index.html'),
        array('t' => $a['h1'], 'u' => null),
      ),
      'bloques' => $a['bloques'],
      'faq' => isset($a['faq']) ? $a['faq'] : array(),
      'relacionados' => $otros,
      'relTitulo' => 'Sigue leyendo',
      'ctaTitulo' => 'De la teoría al palé',
      'ctaTexto' => 'Todo lo que cuenta esta guía sale de abrir camiones cada semana. Los lotes que salen de ahí están en venta ahora mismo.',
      'prioridad' => '0.7', 'frecuencia' => 'monthly',
      'aviso' => true,
      'schema' => array(array(
        '@type' => 'Article',
        'headline' => $a['titulo'],
        'description' => $a['desc'],
        'image' => SITIO . '/' . $a['img'],
        'datePublished' => $a['fecha'],
        'dateModified' => $a['fecha'],
        'author' => array('@type' => 'Organization', 'name' => 'Tornarem', 'url' => SITIO . '/'),
        'publisher' => array('@type' => 'Organization', 'name' => 'Tornarem',
          'logo' => array('@type' => 'ImageObject', 'url' => SITIO . '/assets/favicon.svg')),
        'mainEntityOfPage' => array('@type' => 'WebPage', '@id' => SITIO . '/blog/' . $a['slug'] . '.html'),
        'inLanguage' => 'es-ES',
      )),
    );

    $INDICE[] = $a;
}

/* --- índice del blog --- */
$tarjetas = '';
$listaLD = array();
$n = 1;
foreach ($INDICE as $a) {
    /* La primera va a lo ancho: es la guía por la que hay que empezar y,
       de paso, deja doce tarjetas para la rejilla, que cuadran exactas
       a dos y a tres columnas. */
    $clase = ($n === 1) ? 'post-card post-card--destacada rv' : 'post-card rv';
    $tarjetas .= '      <article class="' . $clase . '">
        <a class="post-fig" href="' . e($a['slug']) . '.html" tabindex="-1" aria-hidden="true">
          <img src="../' . e($a['img']) . '" width="1536" height="1024" alt="" loading="' . ($n === 1 ? 'eager' : 'lazy') . '" decoding="async">
        </a>
        <div class="post-body">
          <p class="post-meta">' . e($a['tema']) . ' · ' . (int) $a['minutos'] . ' min · ' . e(date('d/m/Y', strtotime($a['fecha']))) . '</p>
          <h3><a href="' . e($a['slug']) . '.html">' . e($a['h1']) . '</a></h3>
          <p>' . e($a['entradilla']) . '</p>
          <span class="post-mas">Leer la guía →</span>
        </div>
      </article>
';
    $listaLD[] = array('@type' => 'ListItem', 'position' => $n, 'url' => SITIO . '/blog/' . $a['slug'] . '.html', 'name' => $a['titulo']);
    $n++;
}

$PAGINAS[] = array(
  'ruta' => 'blog/index.html',
  'titulo' => 'Guías sobre devoluciones de Amazon y liquidación de stock',
  'desc' => 'Guías prácticas sobre comprar y revender devoluciones de Amazon: precios reales, grados, márgenes, dónde vender y cómo no caer en una estafa.',
  'kicker' => 'Guías · Escritas desde la nave',
  'h1' => 'Guías sobre devoluciones',
  'entradilla' => 'Todo lo que hemos aprendido abriendo camiones, escrito para quien está pensando en comprar su primer lote. <b>Con los números reales</b>, incluidos los que no nos favorecen.',
  'img' => 'assets/img/clasificacion.webp',
  'imgAlt' => 'Mesa de clasificación con productos devueltos separándose por categorías',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Guías', 'u' => null)),
  'bloques' => array(
    array('crudo' => '<section class="sec">
  <div class="wrap">
    <header class="sec-head rv">
      <p class="sec-num">' . count($INDICE) . ' guías</p>
      <h2 class="sec-title">Todo lo que preguntáis antes de comprar</h2>
      <p class="sec-lead">Ordenadas de la más general a la más concreta. Si es tu primera vez, empieza por la de arriba.</p>
    </header>
    <div class="posts">
' . $tarjetas . '    </div>
  </div>
</section>
'),
  ),
  'relacionados' => array(
    array('k' => 'Comprar', 't' => 'Comprar devoluciones de Amazon', 'u' => 'comprar-devoluciones-de-amazon.html', 'd' => 'Cómo funciona, qué cuesta y qué mirar antes de pagar.'),
    array('k' => 'Comprar', 't' => 'Lotes de devoluciones', 'u' => 'lotes-de-devoluciones-de-amazon.html', 'd' => 'Los diez lotes del catálogo, con su contenido publicado.'),
    array('k' => 'Comprar', 't' => 'Palés completos', 'u' => 'palets-de-devoluciones-de-amazon.html', 'd' => 'Más volumen y menos euros por referencia, si tienes dónde descargar.'),
    array('k' => 'Envíos', 't' => 'Dónde enviamos', 'u' => 'donde/index.html', 'd' => 'Plazos reales por provincia y recogida gratis en Girona.'),
  ),
  'relTitulo' => 'Ir a comprar',
  'ctaTitulo' => 'Los lotes de los que habla el blog',
  'prioridad' => '0.8', 'frecuencia' => 'weekly',
  'aviso' => true,
  'schema' => array(
    array('@type' => 'Blog', 'name' => 'Guías de Tornarem', 'url' => SITIO . '/blog/index.html',
          'description' => 'Guías prácticas sobre comprar y revender devoluciones de Amazon.',
          'inLanguage' => 'es-ES',
          'publisher' => array('@type' => 'Organization', 'name' => 'Tornarem')),
    array('@type' => 'ItemList', 'itemListElement' => $listaLD),
  ),
);
