# Tornarem Telecom — web

Sitio estático de tres páginas más un pequeño PHP que recibe los
formularios. No necesita Node, ni npm, ni compilación: se sube la carpeta
tal cual por FTP y funciona.

---

## Cómo publicarlo en Hostinger

1. Entra en **hPanel → Administrador de archivos** (o conéctate por FTP).
2. Abre la carpeta `public_html`.
3. Arrastra **todo el contenido** de esta carpeta dentro, incluido el
   archivo `.htaccess` (empieza por punto; si tu cliente FTP no lo muestra,
   activa «ver archivos ocultos»).
4. Listo. `index.html` es la portada.

Sirve igual para Netlify, Cloudflare Pages, Vercel o cualquier hosting
estático. En Netlify y Cloudflare el `.htaccess` se ignora: usa un archivo
`_headers` equivalente si quieres el mismo control de caché.

---

## Qué hay dentro

```
index.html          Portada: tarifas, cobertura, la red, FAQ, contacto
empresas.html       Página para empresas: servicios, SLA, presupuesto
gracias.html        Acuse tras enviar el formulario sin JavaScript
enviar.php          ← RECEPCIÓN DE LOS FORMULARIOS: configúralo (ver abajo)
styles.css          Toda la hoja de estilo (incluye las tipografías)
main.js             Comportamiento: menú, comprobador, filtros, formularios
.htaccess           Caché, tipos MIME y protección del registro de solicitudes
lib/
  manifest.js       ← DATOS EDITABLES: municipios, tarifas, contacto, FAQ
  gsap.min.js       Animación (local, no se carga de ningún CDN)
  ScrollTrigger.min.js
assets/
  img/              Fotografías en WebP
  fonts/            Manrope, Inter y JetBrains Mono alojadas aquí
  credits.json      Autoría de las fotos (aparece al pie de la web)
  favicon.svg
```

---

## Qué tienes que cambiar antes de publicar

Los datos de la empresa son de ejemplo. Sustitúyelos por los reales:

| Dato | Dónde |
|---|---|
| Teléfono `900 000 000` | `index.html`, `empresas.html`, `gracias.html`, `enviar.php` y `lib/manifest.js` |
| Correos `hola@` y `averias@tornarem.cat` | los mismos archivos, y sobre todo la cabecera de `enviar.php` |
| Dirección de la oficina | `index.html` y `empresas.html` (bloque «O directamente» y pie) |
| Precios y contenido de las tarifas | `index.html` (sección `#tarifas`) y `lib/manifest.js` |
| Municipios con cobertura | `index.html` (lista `data-cover-list`) **y** `lib/manifest.js` (array `cobertura`) |
| Textos legales del pie | `index.html`, `empresas.html` |

> Los municipios están en dos sitios a propósito: en el HTML para que la
> lista se vea aunque falle el JavaScript, y en `manifest.js` para que el
> comprobador del hero sepa qué responder. **Si cambias uno, cambia el otro.**

Las fotografías son de Openverse con licencia Creative Commons y la
atribución sale automáticamente al pie. Si las sustituyes por fotos
propias, borra `assets/credits.json` y quita el párrafo `data-credits`.

---

## Los formularios (ya funcionan)

Los dos formularios envían a `enviar.php`, que te manda un correo con la
solicitud. Funciona en Hostinger tal cual, sin cuentas de terceros ni
librerías.

**Lo único que hay que configurar** son las cuatro primeras líneas de
`enviar.php`:

```php
$DESTINO          = 'hola@tornarem.cat';   // a dónde llegan los avisos
$DESTINO_EMPRESAS = 'hola@tornarem.cat';   // idem, para el formulario de empresas
$REMITENTE        = 'web@tornarem.cat';    // desde qué dirección salen
$REGISTRO         = __DIR__ . '/solicitudes.log';
```

`$REMITENTE` **tiene que ser una cuenta real de tu propio dominio**
(créala en hPanel → Correos). Si pones un Gmail o una dirección inventada,
los servidores del destinatario tratarán el correo como falsificado y
acabará en spam.

Cómo se comporta:

- **Con JavaScript**: envía por detrás y muestra el acuse sin recargar.
- **Sin JavaScript**: se envía como un formulario de toda la vida y
  aterriza en `gracias.html`. Si algo falla, sale una página con el motivo.
- **Si el correo no sale** (servidor mal configurado, cuota, lo que sea),
  la solicitud queda igualmente guardada en `solicitudes.log` y el visitante
  ve un aviso con el teléfono. No se pierde ninguna.
- **Anti-spam**: un campo trampa invisible. Los robots lo rellenan y su
  envío se descarta en silencio.
- El `.htaccess` bloquea el acceso web a `solicitudes.log`: contiene datos
  personales de tus clientes y nadie debe poder leerlo desde el navegador.

### Si tu hosting no tiene PHP

En Netlify, Cloudflare Pages o GitHub Pages no hay PHP. Cambia el `action`
de los dos formularios por un servicio tipo Formspree
(`action="https://formspree.io/f/TU_ID"`) y borra el atributo
`data-contact-form` para que el JavaScript no intercepte el envío.

> Al abrir la web con doble clic (sin servidor) el formulario no puede
> enviar: verás el aviso de error. Es lo esperado; en el hosting funciona.

---

## Si cambias algo y no lo ves en la web publicada

Es la caché, casi siempre. En `index.html` y `empresas.html` verás:

```html
<link rel="stylesheet" href="styles.css?v=20260810">
<script defer src="main.js?v=20260810"></script>
```

**Cada vez que toques el CSS o el JS, sube esa fecha** (`?v=20260811`, etc.)
en los tres archivos HTML. El navegador lo lee como una dirección nueva y
descarga la versión buena. El `.htaccess` ya pide al servidor que no cachee
el HTML, el CSS ni el JS; las imágenes y tipografías sí, un mes.

---

## Detalles técnicos, por si los necesitas

- Sin frameworks, sin build, sin dependencias en tiempo de ejecución.
- Las tipografías están alojadas aquí: ninguna petición a Google. Una cosa
  menos que declarar en la política de cookies.
- Todo el contenido está escrito en el HTML. Si el JavaScript falla, la web
  se sigue leyendo entera y se sigue navegando; sólo se pierden las
  animaciones y el comprobador de cobertura.
- Peso de la portada: unos 300 KB la primera visita (fuentes incluidas).
- Funciona abriendo `index.html` con doble clic, sin servidor.
