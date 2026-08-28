# Publicar tornabox.eu — guion para Claude Code en el Mac

Este fichero es para la sesión de **Claude Code que corra en el Mac**, no para
la sesión en la nube: desde la nube el puerto 22 está bloqueado y no hay acceso
al Chrome donde está iniciada la sesión de Hostinger.

## Estado comprobado (28/08/2026)

- `tornabox.eu` **resuelve**, pero a la página de aparcamiento de Hostinger:
  `2.57.91.91`, cabecera `server: hcdn`.
- `www.tornabox.eu` es un CNAME al dominio, así que hereda lo mismo.
- Nameservers: `athena.dns-parking.com` / `apollo.dns-parking.com` (los de
  Hostinger). **No hay que tocarlos**: basta con cambiar el registro A.

Verificar en cualquier momento:

```bash
dig +short tornabox.eu          # ahora: 2.57.91.91 (aparcamiento)
curl -sI http://tornabox.eu/ | head -3
```

## Lo que hace falta antes de nada

Un **VPS** con la tienda. En hosting compartido de Hostinger la tienda
funcionaría (PHP sí corre) pero **el CRM no**: no hay Node, así que
`server.js` no puede levantarse y `admin.html` viene denegado a propósito en
el `.htaccess`.

Lo primero es sacar la IP del VPS: hPanel → **VPS** → *Vista general*.
Si ahí no hay ningún VPS, hay que contratarlo antes; el resto de este guion
no sirve sin él.

## Paso 1 · Apuntar el dominio al VPS

**A mano (30 segundos):** hPanel → dominio `tornabox.eu` → *DNS/Nameservers* →
*Registros DNS*. Editar el registro A que ya existe (no crear uno nuevo al
lado) y añadir el de `www`:

| Tipo | Nombre | Apunta a | TTL |
|---|---|---|---|
| A | `@` | IP-DEL-VPS | 3600 |
| A | `www` | IP-DEL-VPS | 3600 |

Si `www` está como CNAME, se puede dejar el CNAME apuntando a `tornabox.eu`:
también vale, y así solo hay que mantener un registro.

**Automático (opcional):** Hostinger tiene API. hPanel → arriba a la derecha
(icono de la persona) → *Cuenta* → *API* → generar un token con permiso de
DNS, y usar `https://developers.hostinger.com/` para hacer el cambio con
`curl`. Solo compensa si esto se va a repetir.

Esperar a que se propague (de minutos a un par de horas):

```bash
dig +short tornabox.eu          # tiene que dar la IP del VPS, no 2.57.91.91
```

**Hasta que esto no dé la IP del VPS, el certificado HTTPS del paso 2 fallará.**

## Paso 2 · Instalar la tienda en el VPS

Por SSH (hPanel → *VPS* → *Acceso SSH* da usuario e IP):

```bash
ssh root@IP-DEL-VPS

curl -fsSL https://raw.githubusercontent.com/sevecat2023-pixel/tornarem/claude/tienda-minimalista-psicologia-9q5ku3/deploy-vps.sh -o deploy-vps.sh
sudo bash deploy-vps.sh tornabox.eu --ssl
```

El script es **idempotente**: volver a lanzarlo actualiza la tienda a la
última versión del repositorio. Hace, en este orden:

1. nginx, PHP, Node 22 y pm2.
2. Clona el repo en `/var/www/tornabox`.
3. Levanta `server.js` con pm2 en `127.0.0.1:8787` y lo publica en `/api`,
   pasando `X-Forwarded-For` (sin eso todos los pedidos llegarían con IP
   `127.0.0.1` y la regla de «IP repetida» del CRM cancelaría media tienda).
4. Protege `/admin.html` con `auth_basic` y genera la contraseña.
5. Sirve `tornabox.eu` y `www.tornabox.eu`.
6. Pide el certificado a Let's Encrypt para los dos.

Al terminar imprime: usuario y clave de nginx, el **token de la API**
(`/var/www/tornabox/datos/token.txt`) y recuerda que la contraseña interna
del panel es `tornabox` hasta que se cambie en Ajustes.

Para fijar la clave de nginx en vez de que la genere:

```bash
CRM_USUARIO=alex CRM_CLAVE=loquesea sudo -E bash deploy-vps.sh tornabox.eu --ssl
```

## Paso 3 · Comprobar que ha quedado bien

```bash
curl -sI https://tornabox.eu/            | head -1   # 200
curl -s  https://tornabox.eu/api/salud                # {"ok":true,...}
curl -so /dev/null -w '%{http_code}\n' https://tornabox.eu/admin.html   # 401
curl -so /dev/null -w '%{http_code}\n' https://tornabox.eu/datos/pedidos.json  # 404
pm2 status                                            # tornabox-api online
```

Los cuatro códigos importan: `401` en el panel y `404` en `datos/` son la
prueba de que los datos personales de los pedidos no están expuestos.

Y una compra de verdad, desde el móvil: portada → una caja → rellenar →
confirmar → debe llegar a `gracias.html` y aparecer en el CRM.

## Si el certificado falla

Casi siempre es que el DNS todavía no había llegado. No hay que tocar nada:

```bash
dig +short tornabox.eu     # esperar a que dé la IP del VPS
sudo bash deploy-vps.sh tornabox.eu --ssl   # y repetir
```

## Después, en el VPS

```bash
nano /var/www/tornabox/pedido.php       # email de pedidos (líneas 9-10)
nano /var/www/tornabox/lib/manifest.js  # emails visibles y stock semanal
```

Para que salgan los correos hace falta un envío SMTP configurado
(`sudo apt install msmtp-mta`). Mientras tanto ningún pedido se pierde:
quedan en `/var/www/tornabox/datos/pedidos.json` y se ven en el CRM.

## Lo que NO hay que hacer

- **No** cambiar los nameservers a los del VPS: con los de Hostinger y un
  registro A basta, y así el correo del dominio sigue funcionando.
- **No** subir la carpeta `datos/` a ningún sitio: lleva los pedidos con
  nombre, dirección y teléfono, el token de administración y las credenciales
  del transportista. Está en `.gitignore` por eso.
- **No** dejar `admin.html` accesible sin `auth_basic`. La contraseña que pide
  el panel por dentro no es seguridad: es una página estática y se ve en el
  código fuente.
