# TornaBox — tienda de lotes de devoluciones de Amazon y grandes tiendas

Tienda estática minimalista, lista para arrastrar a **Hostinger** (o cualquier
hosting con PHP) y empezar a recibir pedidos. Sin Node, sin npm, sin compilar.

La compra son **dos clics y un formulario**: portada → checkout → confirmación.
Pago con **tarjeta** (pasarela externa) o **contra reembolso**.

> El dominio real es **tornabox.eu** (registrado en Hostinger). Las
> cifras y opiniones siguen siendo **contenido de plantilla inventado**:
> sustitúyelas por las reales antes de lanzar.
>
> La web **nombra a Amazon** como origen de los lotes (uso descriptivo) y
> repite en el pie, en el almacén, en la FAQ y en las condiciones que
> TornaBox **no está afiliada, asociada ni patrocinada** por ninguna de esas
> plataformas. Es la práctica habitual del sector, pero conviene que lo
> revise tu asesoría antes de publicar, y que solo lo mantengas mientras los
> lotes procedan realmente de ahí.

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
nano /var/www/tornabox/lib/manifest.js  # emails visibles y stock semanal
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
| Emails visibles, hora de corte | `lib/manifest.js` |
| **Stock semanal de cada caja** | `lib/manifest.js` → `cajas.*.stockRestante` |
| Enlaces de pago con tarjeta (Stripe Payment Links) | `lib/manifest.js` → `pagoTarjeta` |
| Envío, mínimo de envío gratis, recargo COD y seguro | `lib/manifest.js` → `envio` **y** `pedido.php` |
| Titular, NIF y dirección (marcados `[así]` en amarillo) | `aviso-legal.html`, `privacidad.html`, `condiciones.html`, `contacto.html` |
| Cifras de confianza (cajas entregadas, valoraciones) y opiniones | `index.html` + `lib/manifest.js` → sustitúyelas por las reales |
| Dominio (ya puesto a tornabox.eu) | `index.html` (canonical), `robots.txt`, `sitemap.xml` |

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

---

---

## Publicar tornabox.eu en el VPS (dos pasos)

> Guion completo, con comprobaciones y qué hacer si algo falla, en
> **[DESPLIEGUE.md](DESPLIEGUE.md)**.

### 1 · Apuntar el dominio al VPS

En hPanel, con `tornabox.eu` seleccionado → **DNS/Nameservers** → *Registros DNS*.
Los nameservers de Hostinger (`athena/apollo.dns-parking.com`) ya valen; solo
hay que añadir o editar dos registros **A** con la IP del VPS (la ves en
hPanel → *VPS* → *Vista general*):

| Tipo | Nombre | Apunta a | TTL |
|---|---|---|---|
| A | `@` | LA-IP-DE-TU-VPS | 3600 |
| A | `www` | LA-IP-DE-TU-VPS | 3600 |

Si ya existe un registro A de aparcamiento en `@`, se **edita**, no se añade
otro. Comprobar que se ha propagado (tarda de minutos a un par de horas):

```bash
dig +short tornabox.eu
```

Tiene que devolver la IP del VPS. Hasta entonces, el certificado HTTPS fallará.

### 2 · Instalar la tienda en el VPS

Por SSH en el VPS (hPanel → *VPS* → *Acceso SSH* da el usuario y la IP):

```bash
curl -fsSL https://raw.githubusercontent.com/sevecat2023-pixel/tornarem/claude/tienda-minimalista-psicologia-9q5ku3/deploy-vps.sh -o deploy-vps.sh
sudo bash deploy-vps.sh tornabox.eu --ssl
```

Eso instala nginx, PHP, Node y pm2; publica la tienda en `tornabox.eu` y en
`www.tornabox.eu`; levanta la API de pedidos en `/api`; deja el CRM en
`/admin.html` con usuario y contraseña de nginx; y saca el certificado HTTPS
de Let's Encrypt. Al terminar imprime la clave del panel y el token de la API.

Volver a lanzar el mismo comando **actualiza** la tienda a la última versión.

> Si el certificado falla es que el DNS todavía no había llegado: espera a que
> `dig +short tornabox.eu` dé la IP del VPS y repite el comando.

### Después, en el VPS

```bash
nano /var/www/tornabox/pedido.php       # tu email de pedidos (líneas 9-10)
nano /var/www/tornabox/lib/manifest.js  # emails visibles y stock semanal
```

Para que salgan los correos hace falta un envío configurado
(`sudo apt install msmtp-mta` con tu SMTP). Mientras tanto cada pedido queda
en `/var/www/tornabox/datos/pedidos.json` y se ve en el CRM.


## CRM de pedidos (`admin.html`)

Panel propio para trabajar los pedidos: tabla, ficha de cada uno, clientes,
estadísticas y una **nota de credibilidad** de 1 a 10 por pedido.

### Las tres piezas

| Pieza | Fichero | Qué hace |
|---|---|---|
| Panel | `admin.html` + `admin.js` | Toda la interfaz. HTML/JS plano, sin framework ni compilación. |
| Cliente de datos | `lib/db.js` | **Lo único que habla con la API.** Guarda copia en `localStorage`: si la API cae, el panel sigue enseñando datos y la tienda sigue aceptando pedidos (quedan en cola y se reenvían solos). |
| API | `server.js` | Node **sin dependencias** (`http`, `https`, `fs`, `path`, `crypto`). Datos en `datos/pedidos.json` con escritura atómica (`.tmp` + `renameSync`). Va con pm2 detrás de nginx en `/api`. |

Motor de notas aparte, en `lib/credibilidad.js`, para poder probarlo solo.

### Arrancarlo

```bash
node server.js                  # API en 127.0.0.1:8787
ESTATICO=1 node server.js       # + sirve la tienda, para probar en local
```

`deploy-vps.sh` ya lo deja montado: instala Node y pm2, publica la API en
`/api`, protege `/admin.html` con usuario y contraseña de nginx y te imprime
el token al terminar.

Crear un pedido (lo hace el checkout) es **público**. Leer o modificar exige
la cabecera `x-admin-token`, que se genera sola en `datos/token.txt` (chmod 600)
o se fija con la variable `ADMIN_TOKEN`.

**Los precios los calcula siempre el servidor.** Si el navegador manda un total
de 0,01 €, se ignora: se recalcula la caja, la escalera de mejora, el envío,
el seguro y el recargo del reembolso.

### Las cuatro pestañas

1. **Pedidos** — tabla con casilla, fecha, nº, cliente, contacto, total, nota,
   estado (se guarda al cambiarlo) y nº de seguimiento. Pulsar la fila abre la
   ficha; las celdas con controles llevan `data-stop` para que cambiar el estado
   no abra la ficha. Al marcar casillas sale la barra de acciones en masa.
2. **Clientes** — agrupados por correo (o teléfono, o nombre), ordenados por
   gasto. Lo cancelado no cuenta como gasto.
3. **Estadísticas** — pedidos, ingresos, ticket medio, unidades y ranking de
   productos con barras.
4. **Ajustes** — pixel de Google, contraseña y token, credenciales de Correos,
   exportar a CSV (con BOM, para que Excel respete los acentos), pedido de
   ejemplo, limpiar caché y borrar todo.

### La nota de credibilidad

Se parte de 10 y cada regla suma o resta décimas **dejando escrito el porqué**.
En la tabla se ve solo el número (verde ≥7, naranja ≥5, rojo <5); en la ficha,
tres bloques: «por qué baja», «por qué sube» y las comprobaciones superadas.

Reglas locales sobre nombre, correo, teléfono, dirección, historial e importe.
Dos comprobaciones contra internet, **cacheadas 30 días** en `localStorage`:

- **¿Existe la dirección?** → Nominatim (OpenStreetMap) con consulta
  *estructurada* (`street`, `city`, `postalcode`), 1 petición por segundo.
  Si no la encuentra con número, reintenta sin número.
- **¿El dominio del correo recibe correo?** → DNS-over-HTTPS de Cloudflare,
  registro MX y, si no hay, A.

### Cancelación automática

**Viene desactivada.** En Ajustes hay un botón de *simular* que dice qué se
cancelaría sin tocar nada. Actívala solo después de mirar esa lista.

Se cancela un pedido si su nota es menor que 5, o si **duplica** a uno de los
10 anteriores. Y «duplicar» tiene dos condiciones, las dos necesarias:

- que el pedido anterior **siga sin salir del almacén** (un pedido igual ya
  entregado no es un duplicado: es un cliente que repite), y
- que sea **de las últimas 72 horas**.

Campos fuertes (correo, teléfono, nombre+dirección): uno solo basta para
cancelar. Campos débiles (IP o dirección sueltas): los comparte una familia,
una oficina o cualquiera detrás del CGNAT del operador, así que bajan la nota
y salen en «pedidos relacionados», pero **no cancelan solos**.
Con `estricto: true` se recupera la regla literal de «cualquier campo repetido
cancela».

Nunca se cancela algo que ya esté `enviado` o `entregado`, ni un pedido cuyo
análisis quedó incompleto porque falló una comprobación de red.

### Transportista (Correos)

Las credenciales viven **solo en el servidor**, en `datos/correos.json` con
chmod 600. El endpoint de configuración nunca devuelve la contraseña, solo si
está puesta. El navegador jamás ve una credencial: el panel solo pide «haz el
envío del pedido X».

Si el pedido es contra reembolso y **no hay IBAN configurado, la API se niega
a generar la etiqueta**: sin IBAN el repartidor entrega el paquete y no cobra.
En la ficha, junto al botón, se ve «Contra reembolso · cobrar XX €».

> El sobre SOAP del preregistro de envíos está escrito contra la especificación
> publicada de Correos, pero **no se ha podido probar contra el servicio real**
> sin credenciales. Usa *Probar credenciales* en Ajustes con las tuyas antes de
> fiarte: devuelve el código HTTP y el principio de la respuesta tal cual.

### Seguridad — léelo, no está maquillado

La contraseña del panel **no es seguridad real**. El panel es una página
estática: cualquiera que abra el código fuente la ve. Sirve para que no entre
quien pase por delante del ordenador, nada más. Lo mismo vale para el token si
lo pegas en un JS público.

Los pedidos contienen **datos personales** (nombre, dirección, teléfono), así
que lo correcto es poner el panel detrás de **autenticación de servidor**.
`deploy-vps.sh` ya lo hace con `auth_basic` de nginx, y el `.htaccess` de
Apache **bloquea `admin.html` por defecto** (en un hosting compartido no hay
Node, la API no puede correr y el panel solo expondría datos).

### En Hostinger

`server.js` **no funciona** en hosting compartido: no hay Node. Allí la tienda
va igual (con `pedido.php` mandando los pedidos por email), pero el CRM
necesita el VPS. Por eso `admin.html` viene denegado en el `.htaccess`.

## Qué hay dentro

```
admin.html          CRM de pedidos (protegido; ver «Seguridad»)
admin.js            Panel: tabla, ficha, clientes, estadísticas, ajustes
server.js           ← API de pedidos (Node sin dependencias, va con pm2)
lib/db.js           Cliente de datos: lo único que habla con la API
lib/credibilidad.js Motor de la nota de credibilidad
datos/              Pedidos, token y credenciales (NO va al repositorio)
index.html          Portada: hero, pasos, 4 cajas, opiniones, FAQ, CTA
checkout.html       Pedido en una pantalla: datos + método de pago
gracias.html        Confirmación con nº de pedido y siguientes pasos
pedido.php          ← RECIBE LOS PEDIDOS: configura tu email aquí
envios-devoluciones.html  Envíos, seguro y seguimiento (sección del menú)
devoluciones.html   Política de devoluciones (legal)
condiciones.html    Condiciones de compra   aviso-legal.html   Aviso legal
privacidad.html     RGPD                    cookies.html       Cookies
contacto.html       Email de contacto       404.html           Error con marca
styles.css          Toda la hoja de estilos (tipografías incluidas)
main.js             Contadores, stock, checkout, confirmación (vanilla JS)
lib/manifest.js     ← DATOS EDITABLES: stock, emails, enlaces de pago
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
