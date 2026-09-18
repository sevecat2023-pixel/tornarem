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
  'slug' => 'tarragona', 'ciudad' => 'Tarragona', 'gentilicio' => 'tarraconense',
  'km' => 190, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Tarragona está a hora y media de la nave por la AP-7. Es de las provincias donde el plazo de 24 horas se cumple siempre, palés incluidos, y donde más gente viene a recoger con furgoneta.',
  'reventa' => 'La costa manda: de mayo a septiembre, Salou, Cambrils y toda la Costa Daurada multiplican la demanda de todo lo que tenga que ver con playa, ventilación y menaje de apartamento. Fuera de temporada, el circuito de mercadillos comarcales del Camp de Tarragona y las Terres de l\'Ebre funciona todo el año.',
  'consejo' => 'Si vendes en zona turística, compra en marzo o abril y ten el stock clasificado antes de Semana Santa. En julio ya no te da tiempo a fotografiar nada.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-electronica', 'lote-juguetes'),
  'descarga' => 'Recogida gratis en Girona, a hora y media por la AP-7. Con transporte, el palé llega al día siguiente sin recargo.',
),

array(
  'slug' => 'lleida', 'ciudad' => 'Lleida', 'gentilicio' => 'lleidatà',
  'km' => 200, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Lleida está a dos horas por la A-2. Entrega al día siguiente, palés incluidos, y sin recargo por distancia.',
  'reventa' => 'Es una provincia de mercados semanales muy arraigados: casi todos los pueblos del Segrià, la Noguera y el Urgell tienen el suyo un día fijo, y son mercados de compra real, no de paseo. La ventaja para quien revende es que puedes hacer cuatro o cinco mercados distintos a la semana sin salir de la provincia.',
  'consejo' => 'Para circuito de mercados, el palé mixto compensa: clasificas en casa y llenas la parada semana tras semana. Lo que mejor se mueve es menaje, juguete y textil de precio bajo.',
  'lotes' => array('lote-pale-mixto', 'lote-juguetes', 'lote-moda', 'lote-hogar-cocina'),
  'descarga' => 'Palé en 24 horas. Si descargas en calle, marca plataforma elevadora al hacer el pedido.',
),

array(
  'slug' => 'huesca', 'ciudad' => 'Huesca', 'gentilicio' => 'oscense',
  'km' => 300, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Huesca entra por la A-22 y la N-240. Tres horas de camino y entrega al día siguiente con el transporte incluido.',
  'reventa' => 'El Pirineo cambia la demanda: material de montaña, ropa técnica y equipamiento de exterior se venden aquí a precios que no aguantarían en la costa. La temporada de nieve y la de senderismo reparten el año en dos mitades con productos distintos.',
  'consejo' => 'El lote de deporte y fitness es el que mejor encaja en esta provincia, sobre todo antes del invierno. Mochilas, tiendas y material de exterior tienen salida todo el año.',
  'lotes' => array('lote-deporte', 'lote-herramientas', 'lote-hogar-cocina', 'lote-electronica'),
  'descarga' => 'Palé en 24 horas por carretera. Zona de montaña: avisa si el acceso es estrecho.',
),

array(
  'slug' => 'teruel', 'ciudad' => 'Teruel', 'gentilicio' => 'turolense',
  'km' => 400, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Teruel está a unas cuatro horas y media. Los lotes en caja llegan al día siguiente; los palés, entre 24 y 48 horas por ser ruta menos frecuentada.',
  'reventa' => 'Poca competencia y mercado pequeño: lo contrario de Madrid. Aquí se vende más despacio pero los precios aguantan mucho mejor, porque no hay veinte anuncios iguales del mismo producto. La venta a tiendas de pueblo y el mercadillo comarcal son los canales serios.',
  'consejo' => 'Es buena plaza para probar precios altos antes de bajar. Y para vender a tiendas: hay comercio de proximidad que no tiene proveedor de saldos cerca.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-juguetes', 'lote-moda'),
  'descarga' => 'Ruta menos frecuente: los palés pueden ir a 48 horas. Se avisa al confirmar.',
),

array(
  'slug' => 'castellon', 'ciudad' => 'Castellón', 'gentilicio' => 'castellonense',
  'km' => 380, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Castellón está en plena ruta de la AP-7, a cuatro horas. Entrega al día siguiente para todo, lotes y palés, con el porte incluido.',
  'reventa' => 'La costa de Castellón vive de la temporada, y eso marca el calendario: de junio a septiembre se vende de todo en Benicàssim, Peñíscola y Oropesa. El resto del año, los mercados semanales de la Plana y el interior sostienen el volumen.',
  'consejo' => 'Compra en primavera lo que vayas a vender en verano. Y ten en cuenta el público extranjero de temporada: publicar también en inglés sube el precio medio.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-electronica', 'lote-belleza'),
  'descarga' => 'Ruta directa por la AP-7. Palé en 24 horas con porte incluido.',
),

array(
  'slug' => 'alicante', 'ciudad' => 'Alicante', 'gentilicio' => 'alicantino',
  'km' => 560, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Alicante está a unos 560 km por la AP-7. Lote en caja al día siguiente; palé, entre 24 y 48 horas. Transporte incluido.',
  'reventa' => 'Alicante tiene una particularidad que sólo comparte con Málaga: población extranjera residente con mucha rotación. Pisos que se montan y se desmontan cada temporada significan demanda constante de menaje, pequeño electrodoméstico y mobiliario ligero. A eso se suma el circuito de mercadillos de la Vega Baja, de los más grandes de España.',
  'consejo' => 'Publica también en inglés: el mismo producto se vende antes y a mejor precio. El lote de hogar y cocina es el que mejor funciona aquí.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-moda', 'lote-belleza'),
  'descarga' => 'Palé a 24-48 horas. Plataforma elevadora disponible: indícalo al pedir.',
),

array(
  'slug' => 'murcia', 'ciudad' => 'Murcia', 'gentilicio' => 'murciano',
  'km' => 630, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Murcia está a unos 630 km. Lote en caja en 24 horas si confirmas antes de las 14:00; palé, de 24 a 48 horas.',
  'reventa' => 'Murcia es tierra de mercados semanales grandes y muy frecuentados, con el de Murcia capital y los de Cartagena y Lorca como referencia. Es una plaza donde el precio manda y donde el volumen a precio bajo funciona mejor que la pieza cara.',
  'consejo' => 'Lotes de mucha unidad y precio de impulso: juguetes, moda y belleza. El palé mixto también sale a cuenta si haces varios mercados a la semana.',
  'lotes' => array('lote-moda', 'lote-juguetes', 'lote-belleza', 'lote-pale-mixto'),
  'descarga' => 'Palé a 24-48 horas con porte incluido. Marca plataforma si descargas en calle.',
),

array(
  'slug' => 'navarra', 'ciudad' => 'Navarra', 'gentilicio' => 'navarro',
  'km' => 470, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Navarra entra por la AP-15 y la A-15, a unas cinco horas. Es de las rutas más fiables: el plazo de 24 horas se cumple también con palé.',
  'reventa' => 'En el norte funciona especialmente bien la venta a tienda: hay mucho comercio pequeño de barrio y de pueblo que compra lotes enteros para reponer sin pasar por distribuidor. El rastro y los mercados de Pamplona y de la Ribera completan el circuito.',
  'consejo' => 'Si tienes contacto con comercio local, los lotes de electrodoméstico pequeño y herramienta se colocan enteros con una sola conversación. Sale menos por pieza y muchísimo más por hora.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-informatica', 'lote-electronica'),
  'descarga' => 'Ruta del norte, palé en 24 horas con porte incluido.',
),

array(
  'slug' => 'la-rioja', 'ciudad' => 'La Rioja', 'gentilicio' => 'riojano',
  'km' => 520, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'La Rioja está a unos 520 km por la AP-2 y la AP-68. Entrega al día siguiente, también en palé.',
  'reventa' => 'Provincia pequeña y muy concentrada: casi todo pasa por Logroño y el corredor del Ebro. Eso tiene una ventaja poco obvia para quien revende: la entrega en mano cubre prácticamente toda la población sin desplazamientos largos, y la entrega en mano es donde está el margen.',
  'consejo' => 'Prioriza la venta en mano y las piezas de 10 a 30 €, que es donde el envío se come el beneficio. Electrónica y herramienta son las categorías más agradecidas.',
  'lotes' => array('lote-electronica', 'lote-herramientas', 'lote-hogar-cocina', 'lote-juguetes'),
  'descarga' => 'Palé en 24 horas por la AP-68.',
),

array(
  'slug' => 'gipuzkoa', 'ciudad' => 'Gipuzkoa', 'gentilicio' => 'guipuzcoano',
  'km' => 540, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'intro' => 'Gipuzkoa entra por la AP-8, a unas cinco horas y media. Entrega al día siguiente para lotes y palés, con el transporte incluido.',
  'reventa' => 'Comercio de proximidad muy fuerte y clientes dispuestos a pagar por buen producto: es una plaza donde el precio medio de reventa aguanta mejor que en el arco mediterráneo. Los mercados de Donostia y del interior funcionan, pero el canal que más sorprende es la venta a tiendas de barrio.',
  'consejo' => 'Calidad por encima de cantidad: lotes de informática, herramienta y electrodoméstico. Aquí una pieza buena bien fotografiada se paga.',
  'lotes' => array('lote-informatica', 'lote-herramientas', 'lote-hogar-cocina', 'lote-bebe'),
  'descarga' => 'Ruta del Cantábrico. Palé en 24 horas con porte incluido.',
),

array(
  'slug' => 'alava', 'ciudad' => 'Álava', 'gentilicio' => 'alavés',
  'km' => 570, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Álava está a unos 570 km, con Vitoria-Gasteiz como destino principal. Lote en caja al día siguiente; palé, de 24 a 48 horas.',
  'reventa' => 'Vitoria concentra casi toda la población de la provincia, lo que hace que la venta en mano sea muy eficiente: poco desplazamiento y mucho alcance. Alrededor, la Llanada y la Rioja Alavesa tienen mercados semanales de tamaño medio.',
  'consejo' => 'Al estar la población concentrada, funciona muy bien publicar con entrega en mano en punto fijo y horario fijo. Ahorra tiempo y cierra más ventas de las que parece.',
  'lotes' => array('lote-electronica', 'lote-hogar-cocina', 'lote-herramientas', 'lote-informatica'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'cantabria', 'ciudad' => 'Cantabria', 'gentilicio' => 'cántabro',
  'km' => 800, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Cantabria está a unos 800 km por la ruta del norte. Los lotes en caja suelen llegar en 24 horas y pueden irse a 48; los palés, a 48 horas.',
  'reventa' => 'Santander y Torrelavega concentran el grueso del mercado, con un verano que dispara la demanda en toda la costa. El resto del año el ritmo es más pausado, con mercados semanales en los valles y comercio de proximidad muy fiel.',
  'consejo' => 'Agrupa los pedidos: al estar lejos, sale mucho mejor pedir dos o tres lotes de una vez que ir de uno en uno. El transporte lo ponemos nosotros, pero el plazo se te acumula.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-juguetes', 'lote-deporte'),
  'descarga' => 'Palé a 48 horas. Zona de valles: avisa si el acceso es estrecho.',
),

array(
  'slug' => 'guadalajara', 'ciudad' => 'Guadalajara', 'gentilicio' => 'alcarreño',
  'km' => 620, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Guadalajara está a unos 620 km por la A-2 y es, logísticamente, una de las provincias mejor conectadas de España: el corredor del Henares concentra media logística del país.',
  'reventa' => 'El corredor del Henares tiene naves de almacenaje a precios que no existen en Madrid capital, y está a media hora del mercado madrileño. Para quien quiere comprar palés y no tiene sitio, es la provincia donde primero deberías mirar.',
  'consejo' => 'Si vives aquí, compra palés en lugar de lotes: tienes espacio barato y el cliente de Madrid a un paso. El palé mixto sale a 6 € la referencia.',
  'lotes' => array('lote-pale-mixto', 'lote-hogar-cocina', 'lote-electronica', 'lote-herramientas'),
  'descarga' => 'Ruta directa por la A-2. Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'toledo', 'ciudad' => 'Toledo', 'gentilicio' => 'toledano',
  'km' => 760, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Toledo está a unos 760 km. Los lotes en caja llegan normalmente en 24 horas y pueden irse a 48; los palés, a 48 horas.',
  'reventa' => 'La provincia se reparte entre el área de influencia de Madrid, al norte, y la Mancha toledana, con mercados semanales grandes en Talavera, Illescas y Torrijos. La cercanía a Madrid da salida a lo que en la provincia se vende despacio.',
  'consejo' => 'Si estás en la comarca de La Sagra, tienes el mercado madrileño a tiro. Merece la pena publicar con entrega en mano en Madrid un día fijo a la semana.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-juguetes', 'lote-herramientas'),
  'descarga' => 'Palé a 48 horas con porte incluido. Plataforma elevadora si descargas en calle.',
),

array(
  'slug' => 'cuenca', 'ciudad' => 'Cuenca', 'gentilicio' => 'conquense',
  'km' => 630, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Cuenca está a unos 630 km. Lote en caja al día siguiente; palé, de 24 a 48 horas, con el transporte incluido.',
  'reventa' => 'Provincia poco poblada y con poca competencia online: se vende despacio pero a buen precio, porque no hay veinte anuncios iguales. El canal fuerte es el comercio de proximidad y el mercado comarcal.',
  'consejo' => 'Es buena plaza para vender lotes enteros a tiendas de pueblo, que aquí no tienen proveedor de saldos cerca. Una conversación vale más que treinta anuncios.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-juguetes', 'lote-moda'),
  'descarga' => 'Palé a 24-48 horas. Avisa si el acceso es por casco antiguo.',
),

array(
  'slug' => 'albacete', 'ciudad' => 'Albacete', 'gentilicio' => 'albaceteño',
  'km' => 660, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Albacete está a unos 660 km y es un nudo de carretera importante: la ruta es directa y el plazo de 24 horas se cumple con regularidad en caja.',
  'reventa' => 'Albacete capital concentra el mercado y tiene uno de los mercadillos semanales más grandes de Castilla-La Mancha. Alrededor, Hellín, Villarrobledo y Almansa sostienen un circuito comarcal que funciona todo el año.',
  'consejo' => 'Volumen y precio de impulso: juguete, textil y menaje. Con dos lotes distintos llenas un puesto y te sobra para reponer.',
  'lotes' => array('lote-juguetes', 'lote-moda', 'lote-hogar-cocina', 'lote-belleza'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'ciudad-real', 'ciudad' => 'Ciudad Real', 'gentilicio' => 'ciudadrealeño',
  'km' => 780, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Ciudad Real está a unos 780 km. Lote en caja entre 24 y 48 horas; palé, a 48. El transporte va incluido igual que en el resto de la península.',
  'reventa' => 'Puertollano, Valdepeñas, Tomelloso y Alcázar de San Juan tienen mercados con mucho arraigo, y la provincia entera funciona más por comercio local que por venta online. Es una plaza de ticket bajo y rotación alta.',
  'consejo' => 'Agrupa pedidos para compensar la distancia, y prioriza lotes de muchas unidades. Lo que se mueve aquí es lo de 3, 5 y 10 €.',
  'lotes' => array('lote-juguetes', 'lote-moda', 'lote-belleza', 'lote-hogar-cocina'),
  'descarga' => 'Palé a 48 horas. Marca plataforma elevadora si no tienes muelle.',
),

array(
  'slug' => 'burgos', 'ciudad' => 'Burgos', 'gentilicio' => 'burgalés',
  'km' => 660, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Burgos está a unos 660 km por la AP-2 y la A-1. Entrega al día siguiente en caja y de 24 a 48 horas en palé.',
  'reventa' => 'Burgos capital concentra el mercado y tiene un tejido industrial que sostiene el consumo todo el año. El invierno es largo, lo que dispara la demanda de ropa de abrigo, calefacción y menaje de casa.',
  'consejo' => 'La estacionalidad aquí es real: compra abrigo y hogar en verano, cuando nadie lo quiere, y véndelo de octubre a febrero.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-herramientas', 'lote-electronica'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'soria', 'ciudad' => 'Soria', 'gentilicio' => 'soriano',
  'km' => 570, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'intro' => 'Soria está a unos 570 km. Lote en caja al día siguiente; palé, de 24 a 48 horas, con el transporte incluido.',
  'reventa' => 'Es la provincia menos poblada de España, y eso define el negocio: mercado pequeño, competencia casi nula y precios que aguantan. Vender online con envío a toda España desde aquí funciona mejor que depender del mercado local.',
  'consejo' => 'Si vives en Soria, monta el negocio pensando en envío, no en entrega en mano. Y prioriza piezas de más de 25 €, donde el envío no se come el margen.',
  'lotes' => array('lote-informatica', 'lote-electronica', 'lote-herramientas', 'lote-bebe'),
  'descarga' => 'Palé a 24-48 horas. Ruta de montaña en invierno: puede haber retraso por nieve.',
),

array(
  'slug' => 'valladolid', 'ciudad' => 'Valladolid', 'gentilicio' => 'vallisoletano',
  'km' => 780, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Valladolid está a unos 780 km. Caja entre 24 y 48 horas, palé a 48, con el porte incluido en el precio.',
  'reventa' => 'Es el mercado más grande de Castilla y León y el que tiene más movimiento de segunda mano online de toda la comunidad. Con el rastro dominical y varios mercadillos semanales, hay circuito para quien quiera parada.',
  'consejo' => 'Al ser la plaza más grande de la comunidad, es donde más compensa la venta en mano. Electrónica y puericultura son las categorías con más demanda.',
  'lotes' => array('lote-electronica', 'lote-bebe', 'lote-hogar-cocina', 'lote-moda'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'segovia', 'ciudad' => 'Segovia', 'gentilicio' => 'segoviano',
  'km' => 700, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Segovia está a unos 700 km. Caja entre 24 y 48 horas y palé a 48, con transporte incluido.',
  'reventa' => 'Provincia pequeña con mucho movimiento de fin de semana por la cercanía a Madrid. Eso hace que el mercadillo y el rastro funcionen mejor de lo que correspondería a su población.',
  'consejo' => 'Aprovecha el fin de semana: es cuando hay gente. Y si te mueves a Madrid, el mercado está a una hora larga por la AP-6.',
  'lotes' => array('lote-hogar-cocina', 'lote-juguetes', 'lote-moda', 'lote-belleza'),
  'descarga' => 'Palé a 48 horas. Casco antiguo con accesos estrechos: avísanos.',
),

array(
  'slug' => 'avila', 'ciudad' => 'Ávila', 'gentilicio' => 'abulense',
  'km' => 720, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Ávila está a unos 720 km. Caja de 24 a 48 horas, palé a 48, con el porte incluido.',
  'reventa' => 'Mercado pequeño y muy estacional: el verano y los fines de semana concentran casi toda la actividad, con mucha segunda residencia. La sierra marca la demanda de material de exterior y abrigo.',
  'consejo' => 'Juega con la estacionalidad: abrigo y hogar de octubre a marzo, exterior y deporte de mayo a septiembre. Fuera de eso, vende con envío a toda España.',
  'lotes' => array('lote-moda', 'lote-deporte', 'lote-hogar-cocina', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas. Zona de sierra: puede haber retraso por nieve en invierno.',
),

array(
  'slug' => 'palencia', 'ciudad' => 'Palencia', 'gentilicio' => 'palentino',
  'km' => 730, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Palencia está a unos 730 km. Caja de 24 a 48 horas y palé a 48, con el transporte incluido.',
  'reventa' => 'Provincia de mercado reducido y poca competencia. Palencia capital y Venta de Baños concentran el consumo; el resto son núcleos pequeños con mercado semanal.',
  'consejo' => 'Poca competencia significa que puedes mantener precios. Aprovéchalo: no entres en guerra de precios con nadie porque aquí no hace falta.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-moda', 'lote-electronica'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'leon', 'ciudad' => 'León', 'gentilicio' => 'leonés',
  'km' => 830, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'León está a unos 830 km. Lote en caja entre 24 y 48 horas; palé, a 48 horas, con el porte incluido.',
  'reventa' => 'León capital y Ponferrada son dos mercados separados y con carácter propio. El Bierzo funciona casi como provincia aparte. El invierno es duro y largo, lo que sostiene la demanda de abrigo, calefacción y menaje.',
  'consejo' => 'Si estás en el Bierzo, cuenta con que el plazo se va a 48 horas casi siempre. Agrupa pedidos y compra con antelación para la temporada de frío.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-herramientas', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas. Zona de montaña en invierno: puede haber retraso.',
),

array(
  'slug' => 'salamanca', 'ciudad' => 'Salamanca', 'gentilicio' => 'salmantino',
  'km' => 850, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Salamanca está a unos 850 km. Caja de 24 a 48 horas, palé a 48, transporte incluido.',
  'reventa' => 'La población universitaria cambia el mercado por completo: de septiembre a junio hay demanda constante de informática, menaje básico de piso y textil barato. En verano la ciudad se vacía y el ritmo cae en seco.',
  'consejo' => 'Septiembre es tu mes: pisos que se montan, estudiantes que necesitan monitor, silla, microondas y menaje. Compra informática y hogar en julio para tenerlo listo.',
  'lotes' => array('lote-informatica', 'lote-hogar-cocina', 'lote-electronica', 'lote-moda'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'zamora', 'ciudad' => 'Zamora', 'gentilicio' => 'zamorano',
  'km' => 850, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Zamora está a unos 850 km. Caja entre 24 y 48 horas y palé a 48 horas, con el porte incluido.',
  'reventa' => 'Mercado pequeño, población dispersa y competencia mínima. Como en Soria, el negocio serio aquí es vender online con envío a toda España en lugar de depender del consumo local.',
  'consejo' => 'Piezas de más de 25 €, donde el envío no se come el margen, y paciencia con los plazos. Agrupa los pedidos: la distancia se nota.',
  'lotes' => array('lote-informatica', 'lote-herramientas', 'lote-electronica', 'lote-hogar-cocina'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'almeria', 'ciudad' => 'Almería', 'gentilicio' => 'almeriense',
  'km' => 900, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Almería está a unos 900 km por la costa. Lote en caja entre 24 y 48 horas; palé, a 48 horas, con el transporte incluido.',
  'reventa' => 'Dos mercados muy distintos conviven aquí: el del Poniente, con población trabajadora de la agricultura intensiva y demanda constante de producto básico y barato, y el de la costa turística de Roquetas y Mojácar, con temporada y público extranjero.',
  'consejo' => 'Para el Poniente, volumen y precio bajo: textil, menaje y juguete. Para la costa, hogar y pequeño electrodoméstico, y publica también en inglés.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-juguetes', 'lote-belleza'),
  'descarga' => 'Palé a 48 horas. Plataforma elevadora disponible: indícalo al pedir.',
),

array(
  'slug' => 'granada', 'ciudad' => 'Granada', 'gentilicio' => 'granadino',
  'km' => 950, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Granada está a unos 950 km. Caja de 24 a 48 horas y palé a 48, con el porte incluido en el precio.',
  'reventa' => 'La población universitaria marca el calendario: de septiembre a junio hay demanda fuerte de informática, menaje de piso y textil barato. A eso se suma el turismo de todo el año y la temporada de nieve de Sierra Nevada, que mueve material de montaña.',
  'consejo' => 'Septiembre es el mes: pisos de estudiantes que se montan de cero. Compra informática y hogar en julio para llegar con el stock listo.',
  'lotes' => array('lote-informatica', 'lote-hogar-cocina', 'lote-deporte', 'lote-moda'),
  'descarga' => 'Palé a 48 horas. Casco antiguo con accesos difíciles: avísanos al pedir.',
),

array(
  'slug' => 'cordoba', 'ciudad' => 'Córdoba', 'gentilicio' => 'cordobés',
  'km' => 950, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Córdoba está a unos 950 km. Lote en caja entre 24 y 48 horas; palé, a 48 horas, con transporte incluido.',
  'reventa' => 'Córdoba capital concentra el mercado y tiene mercadillos semanales de buen tamaño. La campiña y el Alto Guadalquivir funcionan con circuito comarcal, con Lucena, Puente Genil y Montilla como plazas con movimiento propio.',
  'consejo' => 'Es plaza de ticket bajo y rotación: juguete, textil y belleza. Agrupa pedidos porque la distancia penaliza el ir de uno en uno.',
  'lotes' => array('lote-moda', 'lote-juguetes', 'lote-belleza', 'lote-hogar-cocina'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'jaen', 'ciudad' => 'Jaén', 'gentilicio' => 'jiennense',
  'km' => 850, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Jaén está a unos 850 km. Caja de 24 a 48 horas, palé a 48, con el porte incluido.',
  'reventa' => 'Provincia muy repartida en núcleos medianos: Linares, Úbeda, Andújar y Martos tienen cada uno su mercado. Eso favorece a quien hace circuito de mercadillos y perjudica a quien depende de una sola ciudad.',
  'consejo' => 'Si haces circuito, el palé mixto compensa: mucho volumen a 6 € la referencia para llenar la parada semana tras semana.',
  'lotes' => array('lote-pale-mixto', 'lote-moda', 'lote-juguetes', 'lote-hogar-cocina'),
  'descarga' => 'Palé a 48 horas. Marca plataforma elevadora si descargas en calle.',
),

array(
  'slug' => 'cadiz', 'ciudad' => 'Cádiz', 'gentilicio' => 'gaditano',
  'km' => 1150, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Cádiz es de los destinos más lejanos de la península: unos 1.150 km. Caja entre 24 y 48 horas, palé a 48, y el transporte sigue incluido.',
  'reventa' => 'La bahía (Cádiz, San Fernando, Puerto Real, El Puerto) concentra población y consumo, y la costa de Chiclana y Conil dispara la demanda en verano. Jerez funciona como mercado aparte, con mucho movimiento propio.',
  'consejo' => 'Pide dos o tres lotes de una vez: con esta distancia, ir de uno en uno te deja sin stock cada dos semanas. Y compra para verano en marzo.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-belleza', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas. Plataforma elevadora recomendable si no tienes muelle.',
),

array(
  'slug' => 'huelva', 'ciudad' => 'Huelva', 'gentilicio' => 'onubense',
  'km' => 1100, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Huelva está a unos 1.100 km. Caja de 24 a 48 horas y palé a 48 horas, con el porte incluido.',
  'reventa' => 'Mercado de tamaño medio muy marcado por la temporada de costa (Punta Umbría, Isla Cristina, Matalascañas) y por la campaña agrícola, que trae población temporera con demanda de producto básico y barato.',
  'consejo' => 'Volumen y precio bajo para la campaña; hogar y playa para el verano. Agrupa pedidos por la distancia.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-juguetes', 'lote-belleza'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'badajoz', 'ciudad' => 'Badajoz', 'gentilicio' => 'pacense',
  'km' => 1000, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Badajoz está a unos 1.000 km. Caja de 24 a 48 horas y palé a 48, con transporte incluido en el precio.',
  'reventa' => 'Badajoz, Mérida y Don Benito reparten el mercado, y la frontera con Portugal añade un flujo de compradores que busca precio. Los mercadillos semanales son grandes y muy concurridos.',
  'consejo' => 'Precio de impulso y volumen. Y ojo con la frontera: hay demanda portuguesa que compra a este lado buscando saldo, sobre todo textil y menaje.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-juguetes', 'lote-belleza'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'caceres', 'ciudad' => 'Cáceres', 'gentilicio' => 'cacereño',
  'km' => 900, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Cáceres está a unos 900 km. Caja entre 24 y 48 horas, palé a 48 horas, con el porte incluido.',
  'reventa' => 'Provincia grande y poco poblada, con Cáceres capital, Plasencia y Navalmoral como plazas principales. Poca competencia online, lo que permite sostener precios mejor que en zonas saturadas.',
  'consejo' => 'Vende con envío a toda España en lugar de depender del mercado local, y prioriza piezas de más de 25 € para que el envío no te coma el margen.',
  'lotes' => array('lote-herramientas', 'lote-electronica', 'lote-hogar-cocina', 'lote-informatica'),
  'descarga' => 'Palé a 48 horas. Núcleos dispersos: confirma el acceso al pedir.',
),

array(
  'slug' => 'asturias', 'ciudad' => 'Asturias', 'gentilicio' => 'asturiano',
  'km' => 880, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Asturias está a unos 880 km por la ruta del Cantábrico. Caja de 24 a 48 horas y palé a 48, con el transporte incluido.',
  'reventa' => 'El triángulo Oviedo-Gijón-Avilés concentra casi toda la población y el consumo, lo que hace muy eficiente la venta en mano. El comercio de proximidad es fuerte y compra lotes enteros con facilidad.',
  'consejo' => 'La venta a tiendas funciona especialmente bien aquí. Electrodoméstico pequeño, herramienta e informática se colocan enteros con una conversación.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-informatica', 'lote-electronica'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'a-coruna', 'ciudad' => 'A Coruña', 'gentilicio' => 'coruñés',
  'km' => 1200, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'A Coruña está a unos 1.200 km, de los destinos peninsulares más lejanos. Caja de 24 a 48 horas y palé a 48, con el porte incluido.',
  'reventa' => 'A Coruña y Santiago son dos mercados con carácter propio, y el área de Ferrol funciona como tercero. La población universitaria de Santiago marca el ritmo de septiembre, con mucha demanda de menaje de piso e informática.',
  'consejo' => 'Agrupa pedidos, que la distancia pesa. Y aprovecha septiembre en Santiago: es la ventana más clara del año.',
  'lotes' => array('lote-informatica', 'lote-hogar-cocina', 'lote-electronica', 'lote-moda'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'pontevedra', 'ciudad' => 'Pontevedra', 'gentilicio' => 'pontevedrés',
  'km' => 1250, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Pontevedra es el destino peninsular más lejano de nuestra ruta: unos 1.250 km. Caja de 24 a 48 horas, palé a 48, transporte incluido.',
  'reventa' => 'Vigo concentra el mercado más grande de Galicia, con Pontevedra capital y las Rías Baixas alrededor. El verano dispara la costa y la frontera con Portugal añade movimiento de compradores que buscan precio.',
  'consejo' => 'Vigo es la plaza. Si vendes en mano allí, los lotes de piezas pequeñas y precio medio son los que mejor rotan.',
  'lotes' => array('lote-electronica', 'lote-moda', 'lote-hogar-cocina', 'lote-belleza'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'lugo', 'ciudad' => 'Lugo', 'gentilicio' => 'lucense',
  'km' => 1100, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Lugo está a unos 1.100 km. Caja de 24 a 48 horas y palé a 48 horas, con el porte incluido.',
  'reventa' => 'Provincia extensa y con población repartida: Lugo capital, Monforte y la costa de A Mariña. Los mercados semanales tienen mucho arraigo y son el canal más directo.',
  'consejo' => 'Poca competencia online: los precios aguantan. Vende con envío a toda España y usa los mercados locales para lo que no se mueve.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-moda', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas. Núcleos dispersos: confirma el acceso.',
),

array(
  'slug' => 'ourense', 'ciudad' => 'Ourense', 'gentilicio' => 'ourensano',
  'km' => 1150, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'intro' => 'Ourense está a unos 1.150 km. Caja entre 24 y 48 horas y palé a 48, con transporte incluido.',
  'reventa' => 'Mercado concentrado en la capital y poco competido. La cercanía a Portugal aporta movimiento, y el verano trae de vuelta a mucha población emigrada que consume durante unas semanas.',
  'consejo' => 'Julio y agosto son meses fuertes aquí al contrario que en casi toda España. Ten stock preparado para entonces.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-electronica', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'baleares', 'ciudad' => 'Baleares', 'gentilicio' => 'balear',
  'km' => 0, 'plazo' => 'presupuesto', 'plazoPale' => 'presupuesto',
  'islas' => true,
  'intro' => 'A Baleares llegamos, pero no con la tarifa de península: el transporte va por barco y se presupuesta antes de que pagues nada. Escríbenos con el lote y el código postal y te lo cerramos en el día.',
  'reventa' => 'La temporada turística marca el año entero: de mayo a octubre, Mallorca, Ibiza, Menorca y Formentera multiplican la demanda de menaje, pequeño electrodoméstico y todo lo que equipe un apartamento. Fuera de temporada, el mercado se reduce a la población residente.',
  'consejo' => 'Compra en marzo y abril para tener el stock en la isla antes de que arranque la temporada. En julio, el transporte está saturado y todo tarda más.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-moda', 'lote-belleza'),
  'descarga' => 'Transporte marítimo con presupuesto previo. Los palés salen por puerto de Barcelona o Valencia según destino.',
),

array(
  'slug' => 'las-palmas', 'ciudad' => 'Las Palmas', 'gentilicio' => 'canario',
  'km' => 0, 'plazo' => 'presupuesto', 'plazoPale' => 'presupuesto',
  'islas' => true,
  'intro' => 'A Canarias servimos con presupuesto aparte: además del transporte marítimo hay trámites de aduana y el régimen fiscal es distinto. Todo se cierra antes de que pagues nada.',
  'reventa' => 'Gran Canaria, Lanzarote y Fuerteventura viven del turismo todo el año, no sólo en verano, lo que da una demanda más estable que en la península. Hay mucha rotación de apartamentos y de personal de temporada.',
  'consejo' => 'Calcula el coste puesto en la isla antes de decidir, no el precio del lote: con aduana y barco, la cuenta cambia bastante. Te lo damos por escrito antes de pedir.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-belleza', 'lote-moda'),
  'descarga' => 'Transporte marítimo y trámites de aduana. Presupuesto cerrado antes del pedido.',
),

array(
  'slug' => 'santa-cruz-de-tenerife', 'ciudad' => 'Santa Cruz de Tenerife', 'gentilicio' => 'tinerfeño',
  'km' => 0, 'plazo' => 'presupuesto', 'plazoPale' => 'presupuesto',
  'islas' => true,
  'intro' => 'Igual que en Las Palmas: servimos con presupuesto aparte, porque hay transporte marítimo y trámites de aduana. Escríbenos con el lote y el destino y te lo cerramos por escrito.',
  'reventa' => 'Tenerife, La Palma, La Gomera y El Hierro con demanda turística sostenida todo el año en el sur de Tenerife y más estacional en el resto. El comercio de proximidad es fuerte y compra lotes enteros con facilidad.',
  'consejo' => 'Pide presupuesto de varios lotes a la vez: el transporte marítimo se optimiza muchísimo agrupando, y la diferencia por unidad es grande.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-electronica', 'lote-juguetes'),
  'descarga' => 'Transporte marítimo y aduana. Presupuesto cerrado antes del pedido.',
),

array(
  'slug' => 'vigo', 'ciudad' => 'Vigo', 'gentilicio' => '',
  'km' => 1250, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Vigo es el mercado más grande de Galicia y la ciudad a la que más pedidos mandamos del noroeste. Está a unos 1.250 km: caja entre 24 y 48 horas, palé a 48.',
  'reventa' => 'Ciudad industrial y portuaria, con poder adquisitivo medio-alto y una comunidad de segunda mano online muy activa. La entrega en mano funciona muy bien porque la población está concentrada y bien comunicada por el eje Vigo-Porriño.',
  'consejo' => 'Prioriza la venta en mano y las piezas de 20 a 60 €, que es donde Vigo paga bien. Electrónica e informática son las categorías con más demanda.',
  'lotes' => array('lote-electronica', 'lote-informatica', 'lote-hogar-cocina', 'lote-moda'),
  'descarga' => 'Palé a 48 horas con porte incluido. Casco urbano con calles empinadas: confirma el acceso.',
),

array(
  'slug' => 'santiago-de-compostela', 'ciudad' => 'Santiago de Compostela', 'gentilicio' => '',
  'km' => 1200, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Santiago está a unos 1.200 km. Caja de 24 a 48 horas y palé a 48, con el transporte incluido.',
  'reventa' => 'La universidad manda: de septiembre a junio hay demanda constante de menaje de piso, informática y textil barato. El turismo del Camino añade movimiento todo el año, con mucho comprador de paso que no vuelve.',
  'consejo' => 'Septiembre es la ventana del año: pisos de estudiantes que se montan de cero. Ten el stock de informática y hogar clasificado en agosto.',
  'lotes' => array('lote-informatica', 'lote-hogar-cocina', 'lote-electronica', 'lote-moda'),
  'descarga' => 'Palé a 48 horas. Zona monumental con restricciones: avisa al pedir.',
),

array(
  'slug' => 'gijon', 'ciudad' => 'Gijón', 'gentilicio' => '',
  'km' => 900, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Gijón está a unos 900 km por la ruta del Cantábrico. Caja de 24 a 48 horas, palé a 48, transporte incluido.',
  'reventa' => 'Es la ciudad más poblada de Asturias y concentra buena parte del consumo de la región. Comercio de proximidad fuerte, rastro dominical con tradición y mucha venta en mano por lo compacto de la ciudad.',
  'consejo' => 'La venta a tiendas de barrio funciona aquí especialmente bien: electrodoméstico pequeño y herramienta se colocan enteros con una conversación.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-electronica', 'lote-informatica'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'aviles', 'ciudad' => 'Avilés', 'gentilicio' => '',
  'km' => 900, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Avilés está a unos 900 km. Caja entre 24 y 48 horas, palé a 48, con el porte incluido.',
  'reventa' => 'Ciudad industrial de tamaño medio, con mercado local fiel y poca competencia online comparada con Gijón u Oviedo. Eso permite sostener precios mejor de lo que correspondería a su tamaño.',
  'consejo' => 'Poca competencia significa que no hace falta entrar en guerra de precios. Publica también con envío a toda España para no depender sólo del mercado local.',
  'lotes' => array('lote-herramientas', 'lote-hogar-cocina', 'lote-electronica', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'sabadell', 'ciudad' => 'Sabadell', 'gentilicio' => '',
  'km' => 120, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'esCiudad' => true,
  'intro' => 'Sabadell está a hora y media de la nave. Entrega al día siguiente para todo, y muchos clientes prefieren venir a recoger con furgoneta.',
  'reventa' => 'El Vallès Occidental es una de las zonas con más densidad de mercadillos semanales de Cataluña, y Sabadell tiene además un mercado de segunda mano con público fiel. La cercanía a Barcelona amplía la salida sin salir de casa.',
  'consejo' => 'Al estar tan cerca, la recogida en nave te ahorra esperar al transportista. Y si vendes en mano, tienes el área metropolitana entera a media hora.',
  'lotes' => array('lote-pale-mixto', 'lote-moda', 'lote-electronica', 'lote-hogar-cocina'),
  'descarga' => 'Recogida gratis en Girona, a hora y media. Con transporte, palé al día siguiente.',
),

array(
  'slug' => 'terrassa', 'ciudad' => 'Terrassa', 'gentilicio' => '',
  'km' => 130, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'esCiudad' => true,
  'intro' => 'Terrassa está a unos 130 km de la nave. Entrega al día siguiente, palés incluidos, sin recargo.',
  'reventa' => 'Ciudad grande con mucho comercio de proximidad y un circuito de mercados semanales que se solapa con el de Sabadell y Rubí. Buena plaza para quien quiere hacer varios mercados sin desplazamientos largos.',
  'consejo' => 'Para circuito de mercados, el palé mixto compensa: clasificas en casa y llenas la parada varias semanas seguidas.',
  'lotes' => array('lote-pale-mixto', 'lote-juguetes', 'lote-moda', 'lote-hogar-cocina'),
  'descarga' => 'Palé en 24 horas. Recogida gratis en Girona si tienes furgoneta.',
),

array(
  'slug' => 'mataro', 'ciudad' => 'Mataró', 'gentilicio' => '',
  'km' => 80, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'esCiudad' => true,
  'intro' => 'Mataró es de los destinos más cercanos a la nave: unos 80 km por la C-32. Entrega al día siguiente y recogida el mismo día si vienes.',
  'reventa' => 'El Maresme tiene mercado propio todo el año y se dispara en verano con la costa. Tradición textil en la comarca, lo que hace que el público entienda de género y valore la prenda con etiqueta.',
  'consejo' => 'El lote de moda es el que mejor encaja aquí. Y por cercanía, la recogida en nave es casi siempre la opción más cómoda.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-belleza', 'lote-electronica'),
  'descarga' => 'Recogida gratis en Girona, a menos de una hora. Palé al día siguiente con transporte.',
),

array(
  'slug' => 'reus', 'ciudad' => 'Reus', 'gentilicio' => '',
  'km' => 180, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'esCiudad' => true,
  'intro' => 'Reus está a unas dos horas por la AP-7 y la AP-2. Entrega al día siguiente para lotes y palés.',
  'reventa' => 'Capital comercial del Baix Camp, con mercado semanal grande y área de influencia amplia. El turismo de la Costa Daurada añade demanda de temporada en menaje y todo lo de apartamento.',
  'consejo' => 'Compra en marzo lo que vayas a vender en temporada alta. Y aprovecha la cercanía: la recogida en nave sale a cuenta si tienes furgoneta.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-juguetes', 'lote-electronica'),
  'descarga' => 'Palé en 24 horas. Recogida gratis en Girona.',
),

array(
  'slug' => 'manresa', 'ciudad' => 'Manresa', 'gentilicio' => '',
  'km' => 140, 'plazo' => '24 horas', 'plazoPale' => '24 horas',
  'esCiudad' => true,
  'intro' => 'Manresa está a unos 140 km. Entrega al día siguiente, también en palé, con el porte incluido.',
  'reventa' => 'Capital del Bages y centro comercial de una comarca amplia con muchos municipios pequeños alrededor. El mercado semanal es de los grandes de la Cataluña central.',
  'consejo' => 'Buena plaza para vender a tiendas de los pueblos del entorno, que no tienen proveedor de saldos cerca. Una ruta de visitas al mes vacía bastante stock.',
  'lotes' => array('lote-hogar-cocina', 'lote-herramientas', 'lote-juguetes', 'lote-moda'),
  'descarga' => 'Palé en 24 horas con porte incluido.',
),

array(
  'slug' => 'alcala-de-henares', 'ciudad' => 'Alcalá de Henares', 'gentilicio' => '',
  'km' => 680, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Alcalá está en el corredor del Henares, a unos 680 km por la A-2. Caja al día siguiente, palé de 24 a 48 horas.',
  'reventa' => 'Doble mercado: población universitaria de septiembre a junio y tejido logístico e industrial todo el año. La cercanía a Madrid capital amplía la salida sin pagar precios de Madrid.',
  'consejo' => 'Si tienes espacio en el corredor, compra palés: naves y trasteros son mucho más baratos que en Madrid y el mercado está a media hora.',
  'lotes' => array('lote-pale-mixto', 'lote-informatica', 'lote-electronica', 'lote-hogar-cocina'),
  'descarga' => 'Ruta directa por la A-2. Palé a 24-48 horas.',
),

array(
  'slug' => 'mostoles', 'ciudad' => 'Móstoles', 'gentilicio' => '',
  'km' => 700, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Móstoles está a unos 700 km. Caja al día siguiente si confirmas antes de las 14:00; palé, de 24 a 48 horas.',
  'reventa' => 'Una de las ciudades más pobladas del sur de Madrid, con mercado propio y mucha venta en mano. El público busca precio, lo que favorece los lotes de mucha unidad y ticket bajo.',
  'consejo' => 'Volumen y precio de impulso: juguete, textil y belleza. La entrega en mano en el sur de Madrid cubre muchísima población sin desplazarte apenas.',
  'lotes' => array('lote-juguetes', 'lote-moda', 'lote-belleza', 'lote-electronica'),
  'descarga' => 'Palé a 24-48 horas. Plataforma elevadora si descargas en calle.',
),

array(
  'slug' => 'getafe', 'ciudad' => 'Getafe', 'gentilicio' => '',
  'km' => 700, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Getafe está a unos 700 km por la A-2 y la M-45. Caja al día siguiente, palé de 24 a 48 horas.',
  'reventa' => 'Ciudad industrial del sur de Madrid con buena conexión y polígonos donde el espacio de almacén es asequible para lo que es el área metropolitana. Mercado local fuerte y acceso rápido al resto del sur.',
  'consejo' => 'Es de las mejores zonas del área de Madrid para comprar palés: tienes espacio a precio razonable y el mercado madrileño entero a tiro.',
  'lotes' => array('lote-pale-mixto', 'lote-hogar-cocina', 'lote-electronica', 'lote-herramientas'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'fuenlabrada', 'ciudad' => 'Fuenlabrada', 'gentilicio' => '',
  'km' => 710, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Fuenlabrada está a unos 710 km. Caja al día siguiente, palé de 24 a 48 horas, transporte incluido.',
  'reventa' => 'Tiene uno de los polígonos industriales más grandes de la Comunidad de Madrid y un mercadillo semanal de los mayores del sur. Es zona de mucho comercio mayorista y de mucha reventa.',
  'consejo' => 'Si vas a hacer volumen, esta es la zona: espacio de nave, mercadillo grande y clientes que ya compran saldo. El palé mixto es el formato natural aquí.',
  'lotes' => array('lote-pale-mixto', 'lote-moda', 'lote-juguetes', 'lote-hogar-cocina'),
  'descarga' => 'Palé a 24-48 horas. Muelle o plataforma elevadora, indícalo al pedir.',
),

array(
  'slug' => 'cartagena', 'ciudad' => 'Cartagena', 'gentilicio' => '',
  'km' => 650, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Cartagena está a unos 650 km. Caja al día siguiente y palé de 24 a 48 horas, con el porte incluido.',
  'reventa' => 'Ciudad portuaria con mercado propio bien diferenciado del de Murcia capital, y con la Manga y el Mar Menor añadiendo temporada fuerte de mayo a septiembre.',
  'consejo' => 'Compra en primavera para la temporada de costa. Hogar, menaje y todo lo de apartamento son lo que más se mueve en verano.',
  'lotes' => array('lote-hogar-cocina', 'lote-moda', 'lote-belleza', 'lote-electronica'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'lorca', 'ciudad' => 'Lorca', 'gentilicio' => '',
  'km' => 700, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Lorca está a unos 700 km. Caja al día siguiente, palé de 24 a 48 horas.',
  'reventa' => 'Centro comercial de una comarca agrícola amplia, con mercado semanal grande y mucha población temporera que busca producto básico y barato.',
  'consejo' => 'Volumen y precio bajo: textil, menaje y juguete. Aquí lo de 3 y 5 € rota mucho mejor que la pieza de 40 €.',
  'lotes' => array('lote-moda', 'lote-juguetes', 'lote-hogar-cocina', 'lote-belleza'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'jerez-de-la-frontera', 'ciudad' => 'Jerez de la Frontera', 'gentilicio' => '',
  'km' => 1120, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Jerez está a unos 1.120 km. Caja de 24 a 48 horas, palé a 48, con el transporte incluido.',
  'reventa' => 'Ciudad grande con mercado propio, separado del de la bahía de Cádiz, y con un circuito de mercadillos y rastros de mucha tradición. Feria y temporada marcan picos claros de consumo.',
  'consejo' => 'Agrupa pedidos por la distancia y compra con antelación para los picos de feria y verano. El lote de moda es el que mejor encaja.',
  'lotes' => array('lote-moda', 'lote-belleza', 'lote-juguetes', 'lote-hogar-cocina'),
  'descarga' => 'Palé a 48 horas. Plataforma elevadora recomendable.',
),

array(
  'slug' => 'algeciras', 'ciudad' => 'Algeciras', 'gentilicio' => '',
  'km' => 1200, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Algeciras está a unos 1.200 km, en el extremo sur. Caja de 24 a 48 horas, palé a 48 horas.',
  'reventa' => 'Puerto y frontera: mucho movimiento de personas y un mercado con demanda constante de producto básico. El Campo de Gibraltar funciona como área propia, con La Línea y San Roque alrededor.',
  'consejo' => 'Pide dos o tres lotes de una vez: con esta distancia, ir de uno en uno te deja sin stock cada dos semanas.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-electronica', 'lote-juguetes'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'elche', 'ciudad' => 'Elche', 'gentilicio' => '',
  'km' => 580, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Elche está a unos 580 km por la AP-7. Caja al día siguiente, palé de 24 a 48 horas.',
  'reventa' => 'Capital española del calzado, con un tejido industrial y comercial que entiende de género textil como en pocos sitios. Mercado semanal grande y comercio de proximidad fuerte.',
  'consejo' => 'Ojo con el calzado: aquí el público sabe distinguir. Eso es bueno si vendes producto honesto y bien descrito, y malo si intentas colar algo.',
  'lotes' => array('lote-moda', 'lote-hogar-cocina', 'lote-belleza', 'lote-juguetes'),
  'descarga' => 'Palé a 24-48 horas con porte incluido.',
),

array(
  'slug' => 'torrevieja', 'ciudad' => 'Torrevieja', 'gentilicio' => '',
  'km' => 620, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Torrevieja está a unos 620 km. Caja al día siguiente, palé de 24 a 48 horas, transporte incluido.',
  'reventa' => 'Una de las ciudades con mayor proporción de residentes extranjeros de España, con mucha rotación de viviendas. Eso significa demanda constante de menaje, pequeño electrodoméstico y mobiliario ligero durante todo el año, no sólo en verano.',
  'consejo' => 'Publica también en inglés: el mismo producto se vende antes y a mejor precio. Hogar y cocina es la categoría reina aquí.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-moda', 'lote-belleza'),
  'descarga' => 'Palé a 24-48 horas. Plataforma elevadora si descargas en calle.',
),

array(
  'slug' => 'benidorm', 'ciudad' => 'Benidorm', 'gentilicio' => '',
  'km' => 600, 'plazo' => '24 horas', 'plazoPale' => '24-48 horas',
  'esCiudad' => true,
  'intro' => 'Benidorm está a unos 600 km. Caja al día siguiente, palé de 24 a 48 horas.',
  'reventa' => 'Turismo durante todo el año, no sólo en verano, y un parque enorme de apartamentos que se equipan y se reequipan sin parar. Demanda estable de menaje, electrónica pequeña y textil.',
  'consejo' => 'El apartamento turístico es tu cliente: menaje, pequeño electrodoméstico y todo lo que se rompe o desaparece cada temporada. Y publica en inglés.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-belleza', 'lote-moda'),
  'descarga' => 'Palé a 24-48 horas. Casco urbano denso: avisa del acceso.',
),

array(
  'slug' => 'marbella', 'ciudad' => 'Marbella', 'gentilicio' => '',
  'km' => 1050, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Marbella está a unos 1.050 km. Caja de 24 a 48 horas, palé a 48, con el porte incluido.',
  'reventa' => 'Costa del Sol con población extranjera residente de poder adquisitivo variado y mucha rotación de vivienda. Conviven el mercado de gama alta y el mercadillo de precio, y los dos funcionan.',
  'consejo' => 'Segmenta: lo bueno del lote, fotografiado con cuidado y en inglés, se paga mucho mejor aquí que en la media española. El resto, a mercadillo.',
  'lotes' => array('lote-hogar-cocina', 'lote-electronica', 'lote-belleza', 'lote-moda'),
  'descarga' => 'Palé a 48 horas con porte incluido.',
),

array(
  'slug' => 'ponferrada', 'ciudad' => 'Ponferrada', 'gentilicio' => '',
  'km' => 900, 'plazo' => '24-48 horas', 'plazoPale' => '48 horas',
  'esCiudad' => true,
  'intro' => 'Ponferrada está a unos 900 km. Caja de 24 a 48 horas, palé a 48 horas.',
  'reventa' => 'El Bierzo funciona casi como una provincia aparte, con Ponferrada como centro comercial de toda la comarca. Poca competencia online y mercado local fiel.',
  'consejo' => 'Aprovecha que hay poca competencia para sostener precios, y usa el envío a toda España para lo que no se mueva en la comarca.',
  'lotes' => array('lote-herramientas', 'lote-hogar-cocina', 'lote-electronica', 'lote-moda'),
  'descarga' => 'Palé a 48 horas. Zona de montaña: puede haber retraso en invierno.',
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
    /* Baleares y Canarias no entran en la tarifa de península: el
       transporte va por barco y se presupuesta. Decir «envío incluido»
       ahí sería mentir, así que estas páginas cambian el titular, las
       cifras y las preguntas. */
    $esIsla = !empty($c['islas']);
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
      'titulo' => $esIsla
        ? 'Devoluciones de Amazon en ' . $c['ciudad'] . ' · Envío con presupuesto'
        : 'Devoluciones de Amazon en ' . $c['ciudad'] . ' · Entrega en ' . $c['plazo'],
      'desc' => $esIsla
        ? 'Lotes y palés de devoluciones de Amazon con envío a ' . $c['ciudad'] . ': transporte marítimo presupuestado antes de pagar. Lotes desde 319 € con IVA.'
        : 'Lotes y palés de devoluciones de Amazon con entrega en ' . $c['ciudad'] . ' en ' . $c['plazo'] . ', transporte incluido. Contrarreembolso o tarjeta. Desde 319 €.',
      'kicker' => $esIsla
        ? 'Envíos a ' . $c['ciudad'] . ' · Transporte presupuestado · Sin sorpresas'
        : 'Envíos a ' . $c['ciudad'] . ' · Transporte incluido · ' . ucfirst($c['plazo']),
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
      'datos' => $esIsla ? array(
        array('Barco', 'Cómo viaja'),
        array('Antes', 'Cuándo se cierra el precio'),
        array('0<span class="u"> €</span>', 'De sorpresas al final'),
        array('319<span class="u"> €</span>', 'Lote más barato'),
      ) : array(
        array(e($c['plazo'] === 'el mismo día' ? 'Hoy' : $c['plazo']), 'Lote en caja'),
        array(e($c['plazoPale'] === 'el mismo día' ? 'Hoy' : $c['plazoPale']), 'Palé completo'),
        array('0<span class="u"> €</span>', 'Transporte'),
        array('319<span class="u"> €</span>', 'Lote más barato'),
      ),
      'bloques' => array(
        array('h2' => 'Desde dónde sale y cómo llega a ' . $c['ciudad'], 'id' => 'envio', 'html' =>
          '    <p>Todo sale de la misma nave: Nave 14, Polígono Mas Xirgu, 17005 Girona. <b>No tenemos almacén en ' . e($c['ciudad']) . '</b> ni en ninguna otra ciudad, y preferimos decirlo a fingir una dirección local que no existe.</p>
    <p>' . ($esIsla
            ? 'El transporte a ' . e($c['ciudad']) . ' <b>no entra en la tarifa de península</b>: va por barco y, en Canarias, con trámites de aduana. Por eso se presupuesta antes, nunca después: nos escribes con el lote y el código postal y te damos el precio cerrado el mismo día. Si no te cuadra, no has pagado nada.'
            : 'Hasta ' . e($c['ciudad']) . ' son unos ' . (int) $c['km'] . ' km. Un lote en caja llega en ' . e($c['plazo']) . ' si confirmas antes de las 14:00 de un día laborable; un palé, en ' . e($c['plazoPale']) . '. El transporte está incluido en el precio, sin recargo por distancia.') . '</p>
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
      'lotesLead' => $esIsla
        ? 'Precio del lote con IVA. El transporte hasta ' . $c['ciudad'] . ' se presupuesta aparte, antes de pagar.'
        : 'Precio final con IVA y transporte incluido hasta ' . $c['ciudad'] . '.',
      'faq' => $esIsla ? array(
        array('p' => '¿Tenéis almacén en ' . $c['ciudad'] . '?', 'r' => 'No. La única nave es la de Girona, en el Polígono Mas Xirgu. Todo sale de ahí.'),
        array('p' => '¿Cuánto cuesta el envío a ' . $c['ciudad'] . '?', 'r' => 'Depende del lote y del destino concreto, por eso se presupuesta. Lo que no vamos a hacer es darte una cifra redonda que luego no se sostenga. Escríbenos con el lote y el código postal y te lo cerramos el mismo día.'),
        array('p' => '¿Puedo pagar contrarreembolso?', 'r' => 'En islas no: el transporte marítimo se contrata aparte y se paga con el pedido. Tarjeta o transferencia con el presupuesto aceptado por escrito.'),
        array('p' => '¿Cuánto tarda?', 'r' => 'Depende de la frecuencia del barco y del destino. Va en el presupuesto, junto con el precio, antes de que pagues nada.'),
      ) : array(
        array('p' => '¿Tenéis almacén en ' . $c['ciudad'] . '?', 'r' => 'No. La única nave es la de Girona, en el Polígono Mas Xirgu. Todo lo que compres sale de ahí. Si alguien te vende devoluciones diciendo que tiene almacenes en media España, pídele la dirección.'),
        array('p' => '¿Cuánto cuesta el envío a ' . $c['ciudad'] . '?', 'r' => 'Nada. Está incluido en el precio del lote, igual que el IVA. No hay recargo por distancia dentro de la península.'),
        array('p' => '¿Puedo pagar al recibirlo en ' . $c['ciudad'] . '?', 'r' => 'Sí, contrarreembolso en efectivo o con tarjeta en el datáfono del transportista. La agencia añade un 3 % por gestionar el cobro, con un mínimo de 5 €.'),
        array('p' => '¿Y si no estoy en casa cuando llega?', 'r' => 'La agencia deja aviso e intenta una segunda entrega, y puedes cambiar la franja horaria con el número de seguimiento que te mandamos por correo al salir el pedido.'),
      ),
      'relacionados' => $otras,
      'relTitulo' => 'Enviamos a toda la península',
      'ctaTitulo' => 'Pídelo hoy y sale hoy',
      'ctaTexto' => $esIsla
        ? 'Escríbenos con el lote y el código postal y te damos el precio puesto en ' . $c['ciudad'] . ' el mismo día.'
        : 'Confirma antes de las 14:00 y el paquete sale esta tarde camino de ' . $c['ciudad'] . '.',
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

/* Índice: provincias por un lado y ciudades por otro. Juntas son
   setenta y dos tarjetas seguidas, que no hay quien las lea. */
function tarjeta_lugar($c) {
    return '      <a class="enlace-card" href="' . $c['slug'] . '.html">
        <span class="enlace-kicker">' . e(!empty($c['islas']) ? 'Con presupuesto' : ($c['plazo'] === 'el mismo día' ? 'Recogida y envío' : 'Entrega en ' . $c['plazo'])) . '</span>
        <h3>' . e($c['ciudad']) . '</h3>
        <p>' . e(mb_substr($c['intro'], 0, 110, 'UTF-8')) . '…</p>
      </a>
';
}
$listaProvincias = '';
$listaSoloCiudades = '';
$nProv = 0; $nCiu = 0;
foreach ($CIUDADES as $c) {
    if (!empty($c['esCiudad'])) { $listaSoloCiudades .= tarjeta_lugar($c); $nCiu++; }
    else { $listaProvincias .= tarjeta_lugar($c); $nProv++; }
}

$PAGINAS[] = array(
  'ruta' => 'donde/index.html',
  'titulo' => 'Dónde enviamos · Devoluciones de Amazon en toda España',
  'desc' => 'Enviamos lotes y palés de devoluciones de Amazon a toda la península con el transporte incluido. Plazos reales por provincia y recogida gratis en la nave de Girona.',
  'kicker' => 'Península y Baleares · Transporte incluido',
  'h1' => 'Dónde enviamos',
  'entradilla' => 'Una sola nave, en Girona, y envíos a toda la península con el transporte incluido en el precio. Aquí están los <b>plazos reales</b> de las ' . $nProv . ' provincias y de ' . $nCiu . ' ciudades más, sin redondear a favor.',
  'img' => 'assets/img/camion-descarga.webp',
  'imgAlt' => 'Camión cargando palés en el muelle de la nave de Girona',
  'migas' => array(array('t' => 'Inicio', 'u' => 'index.html'), array('t' => 'Dónde enviamos', 'u' => null)),
  'bloques' => array(
    array('h2' => 'Las ' . $nProv . ' provincias', 'id' => 'provincias', 'html' =>
      "    <div class=\"enlaces enlaces--prosa\">\n" . $listaProvincias . "    </div>\n"),
    array('h2' => 'Y ' . $nCiu . ' ciudades con página propia', 'id' => 'ciudades', 'html' =>
      "    <p>Ciudades grandes que no son capital de provincia y tienen mercado propio: otros plazos, otros mercadillos y otro tipo de comprador.</p>\n    <div class=\"enlaces enlaces--prosa\">\n" . $listaSoloCiudades . "    </div>\n"),
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
    array('k' => 'Comprar', 't' => 'Lotes de devoluciones', 'u' => 'lotes-de-devoluciones-de-amazon.html', 'd' => 'Los diez lotes del catálogo, con su contenido publicado.'),
    array('k' => 'Guía', 't' => 'Cómo comprar devoluciones de Amazon', 'u' => 'blog/como-comprar-devoluciones-de-amazon.html', 'd' => 'La guía completa, paso a paso.'),
  ),
  'ctaTitulo' => 'Llegamos mañana a casi toda España',
  'prioridad' => '0.6', 'frecuencia' => 'monthly',
);
