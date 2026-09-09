# Tornarem — tienda de lotes de devoluciones

Tienda estática (HTML + CSS + JavaScript) con un pequeño PHP que recibe los
pedidos. No necesita Node, ni npm, ni compilación: se sube la carpeta tal
cual por FTP y funciona.

**Qué vende:** 10 lotes cerrados de devoluciones de Amazon (electrónica,
hogar, juguetes, herramientas, moda, informática, deporte, bebé, belleza y un
palé mixto sin clasificar), con carrito, pago contrarreembolso o con tarjeta
y entrega en 24 horas.

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
styles.css          Toda la hoja de estilo (incluye las tipografías)
main.js             Carrito, fichas de lote, checkout, contadores, efectos
.htaccess           Caché, tipos MIME y protección del registro de pedidos
lib/
  catalogo.js       ← LOS LOTES: nombres, contenido, precios, stock, contacto
  gsap.min.js       Animación del hero (local, no se carga de ningún CDN)
  ScrollTrigger.min.js
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
`minimo`) y el día de la semana del próximo camión (`diaSemana`: 1 = lunes …
7 = domingo; la cuenta atrás lo calcula sola).

---

## Los pedidos (ya funcionan)

Al confirmar, `main.js` envía el pedido a `pedido.php`, que:

1. Recalcula el total con los precios del catálogo y comprueba el stock.
2. Genera un número de pedido (`TR-AAMMDD-XXXX`).
3. Manda **un correo a la tienda** con todos los datos y **otro al cliente**
   con la confirmación.
4. Guarda una línea en `pedidos.log` (JSON) por si el correo falla.
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

El `.htaccess` bloquea el acceso web a `pedidos.log`: contiene datos
personales de tus clientes y nadie debe poder leerlo desde el navegador.

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
- [ ] Cambiar teléfono, WhatsApp, correo y dirección en `lib/catalogo.js`
      **y** en los cuatro HTML (pie, FAQ, botones de aviso).
- [ ] Rellenar los datos de la empresa marcados en amarillo en `legal.html`
      y que una asesoría revise las condiciones de venta.
- [ ] Revisar precios y stock en `lib/catalogo.js` y en las tarjetas.
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
