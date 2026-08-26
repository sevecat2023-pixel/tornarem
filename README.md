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
| Titular, NIF y dirección (marcados `[así]` en amarillo) | `aviso-legal.html`, `privacidad.html`, `condiciones.html`, `contacto.html` |
| Cifras de confianza (cajas entregadas, valoraciones) y opiniones | `index.html` + `lib/manifest.js` → sustitúyelas por las reales |
| Dominio real (si no es tornabox.es) | `index.html` (canonical), `robots.txt`, `sitemap.xml` |

### Cómo funciona el pago

- **Contra reembolso**: el pedido te llega por email (y queda copia en
  `pedidos.log`); cobra el repartidor. Recargo de 2,95 € ya calculado.
- **Tarjeta**: crea un *Payment Link* en [stripe.com](https://stripe.com) por
  caja y pégalo en `lib/manifest.js` → el cliente salta a la pasarela al
  confirmar. Sin enlace configurado, el pedido se registra igual y tú le
  envías el enlace de pago (el email del pedido te lo recuerda).
  La web **nunca pide ni almacena números de tarjeta**.

### Si cambias un precio

Cámbialo en los tres sitios: `index.html` (tarjeta del producto),
`lib/manifest.js` y `pedido.php` (tabla de precios del servidor).

---

## Qué hay dentro

```
index.html          Portada: hero, pasos, 4 cajas, opiniones, FAQ, CTA
checkout.html       Pedido en una pantalla: datos + método de pago
gracias.html        Confirmación con nº de pedido y siguientes pasos
pedido.php          ← RECIBE LOS PEDIDOS: configura tu email aquí
envios.html         Política de envíos      devoluciones.html  Devoluciones
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
- Reversión de riesgo: contra reembolso por defecto, 14 días de devolución.
- Checkout de una sola pantalla, sin registro, con total siempre visible.
- CTA fija en móvil y avisos de «sale hoy» repetidos en el resumen.

## Mantenimiento semanal (2 minutos)

1. Actualiza `stockRestante` de cada caja en `lib/manifest.js`.
2. Si cambias CSS o JS, sube el número de versión `?v=AAAAMMDD` en los HTML.

## Aviso importante

Las opiniones y cifras incluidas son **ejemplo de maquetación**. Publicar
reseñas o estadísticas inventadas como si fueran reales es contrario a la
normativa de consumo: sustitúyelas por datos verificables antes de lanzar.
