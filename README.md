# Tornarem Telecom — web

Sitio estático de dos páginas. No necesita Node, ni npm, ni compilación:
se sube la carpeta tal cual por FTP y funciona.

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
styles.css          Toda la hoja de estilo (incluye las tipografías)
main.js             Comportamiento: menú, comprobador, filtros, formularios
.htaccess           Cabeceras de caché y tipos MIME para Apache/LiteSpeed
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
| Teléfono `900 000 000` | `index.html`, `empresas.html` y `lib/manifest.js` |
| Correos `hola@` y `averias@tornarem.cat` | los mismos tres archivos |
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

## Los formularios no envían nada todavía

Los dos formularios simulan el envío y muestran un acuse. Es intencionado:
un sitio estático no puede mandar correo por sí solo. Para que lleguen de
verdad tienes tres caminos, de menos a más trabajo:

1. **Formspree, Basin o similar** — cambia `<form ...>` por
   `<form action="https://formspree.io/f/TU_ID" method="POST">` y borra el
   `data-contact-form` para que el JavaScript no intercepte el envío.
2. **El formulario de Hostinger** (hPanel → Correo → Formularios).
3. **Un PHP propio** en `public_html/enviar.php` y `action="enviar.php"`.

---

## Si cambias algo y no lo ves en la web publicada

Es la caché, casi siempre. En `index.html` y `empresas.html` verás:

```html
<link rel="stylesheet" href="styles.css?v=20260810">
<script defer src="main.js?v=20260810"></script>
```

**Cada vez que toques el CSS o el JS, sube esa fecha** (`?v=20260811`, etc.)
en los dos archivos HTML. El navegador lo lee como una dirección nueva y
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
