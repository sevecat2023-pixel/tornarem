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
