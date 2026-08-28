# TornaBox — tienda de cajas sorpresa de devoluciones

Tienda estática minimalista, lista para arrastrar a **Hostinger** (o cualquier
hosting con PHP) y empezar a recibir pedidos. Sin Node, sin npm, sin compilar.

La compra son **dos clics y un formulario**: portada → checkout → confirmación.
Pago con **tarjeta** (pasarela externa) o **contra reembolso**.

> «TornaBox», el dominio tornabox.es y todas las cifras/opiniones son
> **contenido de plantilla inventado**. Antes de lanzar: comprueba la
> disponibilidad del dominio y de la marca, y sustituye los datos de ejemplo
> por los reales.

---

## Verla en línea sin instalar nada

- **Vista rápida (ya activa):** el repositorio es público, así que cualquier
  commit se puede ver servido por CDN en
  `https://rawcdn.githack.com/sevecat2023-pixel/tornarem/<sha-del-commit>/index.html`.
- **URL fija gratis (un clic):** en GitHub, `Settings → Pages → Build and
  deployment → Source: Deploy from a branch` → elige la rama
  `claude/tienda-minimalista-psicologia-9q5ku3` y carpeta `/ (root)` → Save.
  En un minuto tendrás `https://sevecat2023-pixel.github.io/tornarem/`.
  (El archivo `.nojekyll` ya está incluido para que se sirva tal cual.)
- En ambos casos `pedido.php` no se ejecuta (son estáticos): la web entera
  funciona para verla y probarla, y los pedidos reales necesitan un host
  con PHP como Hostinger.

---

## Publicar en tu propio VPS (recomendado: aquí sí funcionan los pedidos)

Un solo comando, como root en el servidor. Instala nginx + PHP, descarga la
tienda y la deja funcionando:

```bash
curl -fsSL https://raw.githubusercontent.com/sevecat2023-pixel/tornarem/claude/tienda-minimalista-psicologia-9q5ku3/deploy-vps.sh -o deploy-vps.sh
sudo bash deploy-vps.sh
```

- `sudo bash deploy-vps.sh` → la web queda en `http://TU-IP/`
- `sudo bash deploy-vps.sh tienda.local` → responde además a ese nombre
  (un nombre interno solo funciona dentro de tu red: añádelo al
  `/etc/hosts` de tus equipos, o al DNS de tu router)
- `sudo bash deploy-vps.sh tudominio.com --ssl` → dominio público con
  HTTPS gratis de Let's Encrypt (el dominio debe apuntar ya a la IP)

Volver a lanzarlo **actualiza** la tienda a la última versión.

Después, en el servidor, edita tus datos reales:

```bash
nano /var/www/tornabox/pedido.php       # tu email de pedidos
nano /var/www/tornabox/lib/manifest.js  # WhatsApp y stock semanal
```

Para que los emails salgan del VPS necesitas un envío de correo configurado
(`sudo apt install msmtp-mta` con tu SMTP, o similar). Mientras tanto, cada
pedido queda guardado en `/var/www/tornabox/pedidos.log`, que **no** es
accesible desde la web.

---

## Publicar en Hostinger

1. hPanel → **Administrador de archivos** (o FTP) → carpeta `public_html`.
2. Arrastra **todo el contenido** de esta carpeta, incluido `.htaccess`
   (empieza por punto: activa «mostrar archivos ocultos» si no lo ves).
3. Abre `pedido.php` y pon tu email real en las dos primeras variables.
4. Listo. `index.html` es la portada.

En Netlify/Vercel/Cloudflare Pages la web también funciona, pero `pedido.php`
no (no ejecutan PHP): allí conecta el formulario a un servicio tipo FormSubmit
o usa solo los enlaces de pago de Stripe.

---

## Configuración imprescindible (10 minutos)

| Qué | Dónde |
|---|---|
| Email que recibe los pedidos | `pedido.php` (líneas 10–11) |
| WhatsApp, emails visibles, hora de corte | `lib/manifest.js` |
| **Stock semanal de cada caja** | `lib/manifest.js` → `cajas.*.stockRestante` |
| Enlaces de pago con tarjeta (Stripe Payment Links) | `lib/manifest.js` → `pagoTarjeta` |
| Envío, mínimo de envío gratis, recargo COD y seguro | `lib/manifest.js` → `envio` **y** `pedido.php` |
| Titular, NIF y dirección (marcados `[así]` en amarillo) | `aviso-legal.html`, `privacidad.html`, `condiciones.html`, `contacto.html` |
| Cifras de confianza (cajas entregadas, valoraciones) y opiniones | `index.html` + `lib/manifest.js` → sustitúyelas por las reales |
| Dominio real (si no es tornabox.es) | `index.html` (canonical), `robots.txt`, `sitemap.xml` |

### Cómo funciona el pago

- **Contra reembolso**: el pedido te llega por email (y queda copia en
  `pedidos.log`); cobra el repartidor. Recargo de 4,95 € ya calculado.
- **Tarjeta**: crea un *Payment Link* en [stripe.com](https://stripe.com) por
  caja y pégalo en `lib/manifest.js` → el cliente salta a la pasarela al
  confirmar. Sin enlace configurado, el pedido se registra igual y tú le
  envías el enlace de pago (el email del pedido te lo recuerda).
  La web **nunca pide ni almacena números de tarjeta**.

### Si cambias un precio

Cámbialo en los tres sitios: `index.html` (tarjeta del producto),
`lib/manifest.js` y `pedido.php` (tabla de precios del servidor).

---

## Reglas comerciales (y dónde se cambian)

| Regla | Valor | Dónde |
|---|---|---|
| Envío estándar | 4,95 € | `manifest.js` → `envio.estandar` + `pedido.php` |
| Envío gratis a partir de | 50 € de pedido | `envio.gratisDesde` + `pedido.php` |
| Recargo contra reembolso | 4,95 € | `envio.recargoCOD` + `pedido.php` |
| Pago con tarjeta | sin recargo | — |
| Seguro de devolución (opcional) | 4,95 € | `envio.seguro` + `pedido.php` |
| Hora de corte para «sale hoy» | 18:00 | `manifest.js` → `horaCorte` |

Los precios se calculan **siempre en el servidor** (`pedido.php`): lo que
llegue del navegador no se usa para cobrar. Si cambias un importe, tócalo
en los dos sitios.

### Los dos upsells del checkout

1. **Escalera de mejora** — en vez de ofrecer una segunda caja igual, se
   ofrece **subir a la siguiente** pagando solo la diferencia con
   descuento. Al aceptar, se ofrece el escalón siguiente:

   | Salto | Paga | En vez de | Ahorra | Valor que gana |
   |---|---|---|---|---|
   | Inicio → Grande | +19,95 € | +25,00 € | 5,05 € | +200 € (y envío gratis) |
   | Grande → Tech | +22,95 € | +30,00 € | 7,05 € | +150 € |
   | Tech → XXL | +44,95 € | +60,00 € | 15,05 € | +400 € |

   Encadenando los tres, la XXL sale por 122,80 € en vez de 149,95 €.
   Los importes se editan en `manifest.js` → `mejoras` **y** en
   `pedido.php` → `$MEJORAS`. El servidor recorre la escalera desde la
   caja pedida: una mejora que no sea alcanzable se ignora y se cobra la
   caja original.

2. **Seguro de devolución (4,95 €)** — amplía a 30 días, recogida gratis a
   domicilio y cambio por otra caja o reembolso del 100 %. Sin él, el
   cliente conserva sus 14 días legales de desistimiento.

El método de pago por defecto es **tarjeta**, marcado en verde y sin
recargo, para reducir los impagos del contra reembolso.

## Qué hay dentro

```
index.html          Portada: hero, pasos, 4 cajas, opiniones, FAQ, CTA
checkout.html       Pedido en una pantalla: datos + método de pago
gracias.html        Confirmación con nº de pedido y siguientes pasos
pedido.php          ← RECIBE LOS PEDIDOS: configura tu email aquí
envios-devoluciones.html  Envíos, seguro y seguimiento (sección del menú)
devoluciones.html   Política de devoluciones (legal)
condiciones.html    Condiciones de compra   aviso-legal.html   Aviso legal
privacidad.html     RGPD                    cookies.html       Cookies
contacto.html       WhatsApp y email        404.html           Error con marca
styles.css          Toda la hoja de estilos (tipografías incluidas)
main.js             Contadores, stock, checkout, confirmación (vanilla JS)
lib/manifest.js     ← DATOS EDITABLES: stock, WhatsApp, enlaces de pago
assets/fonts/       Space Grotesk + Inter autoalojadas (sin Google Fonts CDN)
assets/favicon.svg  Icono de la marca
.htaccess           Caché, MIME, 404 y protección de pedidos.log
robots.txt / sitemap.xml
```

Toda la imagen de producto es SVG dibujado a medida (las cajas isométricas):
no hay fotos de stock que licenciar ni pesos que optimizar.

## Detalles de conversión ya incluidos

- Anclaje de precio (valor orientativo tachado frente al precio).
- Escasez real por lote semanal (barras de stock desde `manifest.js`).
- Urgencia honesta: cuenta atrás hasta la hora de corte de envío del día.
- Prueba social (valoraciones, contador de cajas, opiniones verificadas).
- Reversión de riesgo: devoluciones sin preguntas y contra reembolso disponible.
- Checkout de una sola pantalla, sin registro, con total siempre visible.
- CTA fija en móvil y avisos de «sale hoy» repetidos en el resumen.
- Entrega con fecha real estilo Prime («Recíbelo mañana si lo pides en 2 h»).
- Umbral de envío gratis con aviso de cuánto falta, resuelto por la mejora.
- Escalera de mejora encadenada: cada caja ofrece subir a la siguiente con
  descuento, mostrando el valor extra que gana.
- Seguro de devolución como segundo upsell, y devoluciones «sin preguntas»
  como argumento de reversión de riesgo en toda la web.

## Pensada para el móvil primero

- **Menú desplegable** en la cabecera (marca + hamburguesa): en móvil el
  encabezado deja de competir con el CTA, que vive en la barra fija de abajo.
- Aviso superior **rotatorio** (una línea en vez de tres) y textos cortos
  específicos de móvil (`.solo-movil` / `.solo-ancho`).
- Las **cuatro cajas en una pantalla** (2×2) y alineadas entre sí: el rótulo
  de cada tarjeta ocupa siempre una línea.
- Opiniones en **carrusel deslizable** (scroll-snap) con puntos de
  posición y asomo de la siguiente tarjeta.
- Checkout con **resumen compacto arriba** y **barra de pago fija abajo**:
  el total y el botón de confirmar siempre a un pulgar.
- Objetivos táctiles de 48 px, inputs de 16 px (iOS no hace zoom al
  enfocar), sin scroll horizontal y con respeto de las zonas seguras
  del notch (`viewport-fit=cover` + `safe-area-inset`).

## Mantenimiento semanal (2 minutos)

1. Actualiza `stockRestante` de cada caja en `lib/manifest.js`.
2. Si cambias CSS o JS, sube el número de versión `?v=AAAAMMDD` en los HTML.

## Aviso importante

Las opiniones y cifras incluidas son **ejemplo de maquetación**. Publicar
reseñas o estadísticas inventadas como si fueran reales es contrario a la
normativa de consumo: sustitúyelas por datos verificables antes de lanzar.
