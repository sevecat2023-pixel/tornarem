# Tornarem — tienda de lotes de devoluciones

Tienda estática (HTML + CSS + JavaScript) con un pequeño PHP que recibe los
pedidos. No necesita Node, ni npm, ni compilación: se sube la carpeta tal
cual por FTP y funciona.

**Qué vende:** 10 lotes cerrados de devoluciones de Amazon (electrónica,
hogar, juguetes, herramientas, moda, informática, deporte, bebé, belleza y un
palé mixto sin clasificar), con carrito, pago contrarreembolso o con tarjeta
y entrega en 24 horas.

**Y trae panel propio.** En `tudominio.com/admin/` tienes el CRM: los pedidos
que entran por la web aparecen ahí solos, con sus estados, el historial, los
clientes y el stock. Sin cuentas de terceros ni integraciones: todo se guarda
en tu propio servidor.

> Tornarem es un liquidador independiente. La web lo dice en el pie, en las
> preguntas frecuentes y en el aviso legal: no es un «portal oficial» de
> Amazon ni puede presentarse como tal. Amazon es una marca registrada y usar
> su nombre para sugerir afiliación es motivo de reclamación.

---

## Cómo publicarla en Hostinger

1. Entra en **hPanel → Administrador de archivos** (o conéctate por FTP).
2. Abre la carpeta `public_html`.
3. Arrastra **todo el contenido** de esta carpeta dentro, incluido el
   archivo `.htaccess` (empieza por punto; si tu cliente FTP no lo muestra,
   activa «ver archivos ocultos»).
4. Abre `pedido.php` y cambia las cuatro primeras líneas de configuración
   (ver más abajo).
5. Listo. `index.html` es la portada.

Sirve igual para cualquier hosting con PHP. En Netlify, Cloudflare Pages o
GitHub Pages no hay PHP: la web se ve entera, pero al confirmar el pedido el
cliente verá el aviso de «no hemos podido registrarlo» con dos botones para
enviarlo por correo o WhatsApp. Funciona, pero es menos cómodo.

---

## Qué hay dentro

```
index.html          Portada: hero, cómo funciona, los 10 lotes, grados, pago, FAQ, próximo camión
checkout.html       Tramitar pedido: datos, dirección, forma de pago, resumen
gracias.html        Confirmación del pedido (lee el número y el pago de la URL)
legal.html          Aviso legal, privacidad, condiciones de venta, garantía, cookies
pedido.php          ← RECEPCIÓN DE PEDIDOS: configúralo (ver abajo)
estado.php          Stock y precios reales que lee la portada (solo lectura)
styles.css          Toda la hoja de estilo (incluye las tipografías)
main.js             Carrito, fichas de lote, checkout, contadores, efectos
.htaccess           Caché, tipos MIME y protección de la carpeta de datos
admin/              ← EL PANEL: pedidos, clientes, almacén
  index.html        La aplicación del panel
  app.js            Todo su comportamiento
  admin.css         Su estilo (tipografías incluidas)
  api.php           La API que lee y escribe los pedidos
  albaran.php       Albarán imprimible de un pedido
lib/
  catalogo.js       ← LOS LOTES: nombres, contenido, precios, stock, contacto
  tienda.php        Capa de datos compartida: pedidos, stock, resúmenes, acceso
  gsap.min.js       Animación del hero (local, no se carga de ningún CDN)
  ScrollTrigger.min.js
datos/              Se crea sola en el servidor. AQUÍ VIVEN TUS PEDIDOS
  pedidos/          Una ficha por pedido
  indice.jsonl.php  Índice compacto para listar y sumar rápido
  overrides.json.php  Precios y stock que has cambiado desde el panel
  admin.json.php    La contraseña del panel, cifrada
  codigo-de-alta.txt  Sólo hasta que creas la contraseña (ver abajo)
assets/
  img/              Fotografías en WebP (hero, muelle, mesa de revisión y un lote por ficha)
  fonts/            Archivo Black, IBM Plex Sans e IBM Plex Mono alojadas aquí
  favicon.svg
```

---

## Los lotes: cómo cambiar precios, stock o contenido

Todo está en **`lib/catalogo.js`**. Cada lote tiene:

| Campo | Qué es |
|---|---|
| `id` | Identificador interno. Tiene que coincidir con el `data-lote` de su tarjeta en `index.html` |
| `ref` | Referencia visible (TR-2609-01…) |
| `nombre`, `categoria`, `resumen` | Textos de la tarjeta |
| `uds`, `grado`, `formato`, `peso` | Datos de la etiqueta |
| `pvp` | Valor estimado de venta al público (sirve para calcular el descuento) |
| `precio` | **Lo que cobras**, IVA y envío incluidos |
| `stock` | Cuántos lotes iguales tienes. A 0 el carrito no deja añadirlo |
| `img` | Foto, en `assets/img/` |
| `contenido` | Listado que se ve al abrir la ficha |
| `nota` | Aclaración que sale destacada en la ficha |

`pedido.php` lee **este mismo archivo** para poner precio al pedido: el
navegador nunca decide cuánto se cobra. Por eso el bloque entre `{` y `}`
tiene que ser JSON puro: comillas dobles, sin comentarios dentro y sin coma
después del último elemento. Si lo rompes, la web sigue funcionando pero al
confirmar un pedido saldrá el error «el catálogo no es JSON válido».

**Las tarjetas de la portada están escritas a mano en `index.html`** (así se
ven aunque falle el JavaScript). Si cambias un precio, un stock o una
descripción en `catalogo.js`, cámbialo también en su tarjeta. Los datos que
tienen que coincidir: referencia, unidades, grado, formato, PVP, precio,
descuento y «Quedan N lotes».

Para **añadir un lote nuevo**: copia un bloque `{ … }` en `catalogo.js`,
copia una tarjeta `<article class="lote">` en `index.html`, sube su foto a
`assets/img/` y actualiza los cuatro contadores del hero si quieres
(`data-count`).

También en `catalogo.js`: teléfono, WhatsApp, correo, dirección, hora de
corte del envío (`horaCorte`), recargo del contrarreembolso (`porcentaje` y
`minimo`), el día de la semana del próximo camión (`diaSemana`: 1 = lunes …
7 = domingo; la cuenta atrás lo calcula sola) y el freno del formulario
(`freno`: cuántos pedidos por hora se aceptan desde un mismo sitio y en
total). El freno existe porque el stock se descuenta al recibir el pedido:
sin él, cualquiera con un script te dejaría el catálogo a cero. Si algún día
te frena a un cliente de verdad, súbelo ahí.

---

## Los pedidos (ya funcionan)

Al confirmar, `main.js` envía el pedido a `pedido.php`, que:

1. Recalcula el total con los precios del catálogo y comprueba el stock. El
   navegador nunca decide lo que se cobra: si alguien manipula el precio desde
   su ordenador, el servidor lo ignora.
2. Genera un número de pedido (`TR-AAMMDD-XXXX`).
3. **Guarda el pedido en `datos/pedidos/`** y descuenta el stock, así que
   aparece en el panel al instante.
4. Manda **un correo a la tienda** con todos los datos y **otro al cliente**
   con la confirmación.
5. Devuelve el resultado y el navegador lleva al cliente a `gracias.html`.

**Lo único que hay que configurar** está al principio de `pedido.php`:

```php
$DESTINO           = 'pedidos@tornarem.cat';   // a dónde llegan los pedidos
$REMITENTE         = 'web@tornarem.cat';       // desde qué cuenta salen los correos
$REMITENTE_NOMBRE  = 'Tornarem · Pedidos';
$STRIPE_SECRET_KEY = '';                       // ver «Tarjeta» más abajo
```

`$REMITENTE` **tiene que ser una cuenta real de tu dominio** (créala en
hPanel → Correos). Con un Gmail o una dirección inventada, el correo acabará
en spam.

Los datos de tus clientes están cerrados por dos vías a la vez, y son dos
a propósito: el `.htaccess` le dice al servidor que no sirva esa carpeta, y
además **cada fichero de datos es un PHP que se cierra solo en la primera
línea**. Si un día caes en un hosting que ignora el `.htaccess`, pedir esos
ficheros por el navegador sigue sin devolver nada. Por eso acaban en `.php`.

Si prefieres que la carpeta viva fuera de `public_html`, define la variable
de entorno `TORNAREM_DATOS` con la ruta que quieras.

### Contrarreembolso

No hay nada que configurar. El pedido llega por correo, lo preparas, y la
agencia cobra al entregar. El recargo (3 %, mínimo 5 €) se define en
`catalogo.js` y se aplica igual en la web y en el PHP.

### Tarjeta

Dos modos, según tengas o no cuenta en Stripe:

- **Con Stripe** (recomendado): crea una cuenta en stripe.com, copia la
  *clave secreta* (`sk_live_…`) en `$STRIPE_SECRET_KEY` y ya está. Al
  confirmar, el cliente pasa a la página de pago de Stripe (Visa,
  Mastercard, Apple Pay, Google Pay) y vuelve a `gracias.html` cuando paga.
  El correo que te llega dice «comprueba el cobro en el panel de Stripe»:
  hazlo antes de enviar. Con `sk_test_…` puedes probar sin cobrar de verdad
  (tarjeta 4242 4242 4242 4242).
- **Sin Stripe**: el pedido se registra como «tarjeta · pendiente». El
  cliente ve que le llegará un enlace de pago y tú se lo mandas como quieras
  (Bizum, enlace de tu banco, transferencia…). El correo que recibes lo
  marca como «ACCIÓN: enviar enlace de pago».

En ningún caso pasan datos de tarjeta por esta web ni por tu servidor.

### Si abres la web con doble clic (sin servidor)

El carrito y las fichas funcionan, pero al confirmar el pedido verás el aviso
de error con los botones de correo y WhatsApp: no hay PHP que lo reciba. En
el hosting funciona.

---

## El panel: `tudominio.com/admin/`

Aquí es donde trabajas tú. **La primera vez que entras te pide crear una
contraseña**, y para eso te pide dos cosas:

1. **El código de alta.** Está en tu servidor, en `datos/codigo-de-alta.txt`.
   Ábrelo con el gestor de archivos de hPanel o por FTP y copia las ocho
   letras. Sirve una sola vez y se borra al usarlo.
2. **La contraseña que quieras**, de ocho caracteres para arriba. Se guarda
   cifrada en `datos/admin.json.php` y no se puede recuperar.

El código existe por un motivo concreto: sin él, el primero que encontrara la
dirección del panel después de subir la web elegiría la contraseña y se
quedaría con todos tus pedidos. Como el fichero sólo lo puede leer quien tiene
acceso a tu servidor, esa carrera no existe.

Si olvidas la contraseña, borra `datos/admin.json.php` por FTP y el panel te
dejará crear otra (con un código nuevo). Los pedidos no se tocan.

### Inicio

Los cuatro números de arriba (ventas, pedidos, ticket medio y unidades) más el
gráfico de ventas por día, los pedidos pendientes de preparar, los lotes con
stock bajo y los últimos pedidos.

**Todo depende del rango de fechas**, y el rango se cambia de tres maneras:

| Cómo | Para qué |
|---|---|
| Los botones de atajo | Hoy, Ayer, 7 días, 30 días, Este mes, Mes pasado, Este año, Todo |
| Las dos casillas de fecha + **Aplicar** | Cualquier periodo que se te ocurra |
| Las flechas ‹ › | Mover el periodo entero hacia atrás o hacia delante |

Ejemplo: pulsas «Hoy», luego la flecha izquierda y estás viendo ayer; otra vez
y anteayer. Con «30 días» seleccionado, la flecha te lleva a los 30 anteriores.
Al cambiar el rango se recalcula todo lo que hay debajo, y la comparación en
porcentaje es siempre contra el periodo anterior de la misma duración.

El mismo control está en **Pedidos** y en **Clientes**.

### Pedidos

La lista, con filtros que se combinan: rango de fechas, estado, forma de pago
y un buscador (número, nombre, correo, teléfono o población). Se ordena por
columna, se pagina, y se pueden marcar varios pedidos para cambiarles el
estado de golpe. **Exportar** descarga en CSV exactamente lo que estás viendo,
listo para abrir en Excel.

Al pulsar una fila se abre la ficha, y ahí está todo lo que se puede hacer con
un pedido:

- **Cambiar el estado**: nuevo → preparando → enviado → entregado, y desde
  casi cualquiera a incidencia o cancelado. Solo salen los cambios que tienen
  sentido.
- **Cancelar devuelve el stock** al almacén. Si lo sacas de cancelado, se
  vuelve a descontar. No hay forma de descontarlo dos veces.
- Marcar el pago como cobrado, apuntar transportista y número de seguimiento,
  corregir la dirección del cliente, añadir notas internas.
- Copiar la dirección, imprimir el **albarán**, escribir al cliente o llamarle.
- El **historial** guarda quién cambió qué y cuándo.

### Clientes

No hay que dar de alta a nadie: el panel agrupa los pedidos por correo
electrónico y te dice cuántos ha hecho cada uno, cuánto se ha gastado y cuándo
fue la última vez. Pulsas un cliente y ves sus pedidos.

### Almacén

El precio y el stock de los diez lotes, editables. Lo que cambias aquí lo ve
la tienda al momento (la portada pregunta por `estado.php`): si pones un lote
a 0, sale como **agotado** y no se puede añadir al carrito. También puedes
desactivar un lote para que desaparezca de la portada sin borrarlo.

### Lo que este panel NO hace

No se conecta con Shopify, ni con EasySell, ni con GLS, ni con ninguna
pasarela de envíos, porque para que eso funcionase de verdad harían falta
cuentas y contratos con cada uno. Aquí no hay botones de adorno: si un botón
está, hace algo.

Lo único externo es el cobro con tarjeta, y es opcional: se activa pegando tu
clave de Stripe en `pedido.php`.

### Copia de seguridad

Descarga la carpeta `datos/` por FTP de vez en cuando. Ahí está todo: pedidos,
stock y contraseña. Para restaurar, la vuelves a subir.

---

## Las fotos

Se generaron con un modelo de imagen (OpenAI, gpt-image-1.5) a partir de una
descripción de cada lote: son **ilustrativas**, y la web lo dice en la
sección de lotes, en el pie y en el aviso legal. Si haces fotos reales de tus
palés, guárdalas en WebP con el mismo nombre en `assets/img/` y sustitúyelas;
no hay que tocar nada más. Medida recomendada: 1536 × 1024 px, menos de
300 KB.

---

## Si cambias algo y no lo ves en la web publicada

Es la caché, casi siempre. En los cuatro HTML verás:

```html
<link rel="stylesheet" href="styles.css?v=20260909">
<script defer src="lib/catalogo.js?v=20260909"></script>
<script defer src="main.js?v=20260909"></script>
```

**Cada vez que toques el CSS, el JS o el catálogo, sube esa fecha**
(`?v=20260910`, etc.) en los cuatro archivos HTML. El navegador lo lee como
una dirección nueva y descarga la versión buena.

---

## Antes de publicar

- [ ] Configurar `pedido.php` (correo de destino, remitente, Stripe si procede).
- [ ] Entrar en `tudominio.com/admin/` y **crear la contraseña del panel**. Hazlo
      nada más subir la web: hasta que no exista, cualquiera que encuentre la
      dirección puede crearla.
- [ ] Comprobar que `datos/` no se puede abrir desde el navegador: escribe
      `tudominio.com/datos/indice.jsonl.php` y debe salir un error o una
      página en blanco, nunca el contenido.
- [ ] Comprobar que la web entra por `https://`. El `.htaccess` la redirige
      sola; si tu dominio todavía no tiene certificado, comenta ese bloque
      hasta que lo tenga (está señalado en el fichero).
- [ ] Hacer un pedido de prueba y verlo aparecer en el panel.
- [ ] Cambiar teléfono, WhatsApp, correo y dirección en `lib/catalogo.js`
      **y** en los cuatro HTML (pie, FAQ, botones de aviso).
- [ ] Rellenar los datos de la empresa marcados en amarillo en `legal.html`
      y que una asesoría revise las condiciones de venta.
- [ ] Revisar precios y stock en `lib/catalogo.js` y en las tarjetas, o
      ajustarlos desde el panel (Almacén).
- [ ] Sustituir las fotos ilustrativas por fotos reales cuando las tengas.
- [ ] Cambiar `https://www.tornarem.cat/` en la etiqueta `canonical` de `index.html` por tu dominio.

---

## Detalles técnicos, por si los necesitas

- Sin frameworks, sin build, sin dependencias en tiempo de ejecución.
- Tipografías alojadas aquí: ninguna petición a Google ni a ningún tercero.
  La web no usa cookies; el carrito vive en `localStorage`.
- Todo el contenido está en el HTML. Si el JavaScript falla, la portada se
  lee entera; sólo se pierden el carrito, las fichas y las animaciones.
- Peso de la portada: unos 3,5 MB con las once fotografías (cargan en
  diferido según se hace scroll); 400 KB hasta el primer pintado.
- Funciona abriendo `index.html` con doble clic, sin servidor.
