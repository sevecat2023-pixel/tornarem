#!/usr/bin/env bash
# =============================================================
# TornaBox — instalación en un VPS (Debian/Ubuntu)
#
# Uso, como root en tu VPS:
#   bash deploy-vps.sh                 → sirve por la IP del servidor
#   bash deploy-vps.sh tienda.local    → además responde a ese nombre
#   bash deploy-vps.sh tornabox.es --ssl → dominio público + HTTPS gratis
#
# Instala nginx + PHP + Node/pm2, clona la tienda, levanta la API de pedidos
# en /api y deja el CRM en /admin.html protegido con usuario y contraseña.
# Volver a ejecutarlo actualiza la web a la última versión (es idempotente).
#
# Variables opcionales:
#   CRM_USUARIO=jefe CRM_CLAVE=loquesea bash deploy-vps.sh   ← htpasswd del panel
# =============================================================
set -euo pipefail

DOMINIO="${1:-_}"
SSL="${2:-}"
RAIZ="/var/www/tornabox"
RAMA="claude/tienda-minimalista-psicologia-9q5ku3"
REPO="https://github.com/sevecat2023-pixel/tornarem.git"

[ "$(id -u)" -eq 0 ] || { echo "Ejecútalo como root:  sudo bash $0 $*"; exit 1; }

CRM_USUARIO="${CRM_USUARIO:-tornabox}"
CRM_CLAVE="${CRM_CLAVE:-}"

echo "▶ 1/7 Instalando nginx, PHP y Node…"
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get install -y -qq nginx php-fpm php-mbstring git curl apache2-utils >/dev/null
if ! command -v node >/dev/null; then
  curl -fsSL https://deb.nodesource.com/setup_22.x | bash - >/dev/null 2>&1
  apt-get install -y -qq nodejs >/dev/null
fi
command -v pm2 >/dev/null || npm install -g pm2 --silent >/dev/null 2>&1

PHPSOCK="$(ls /run/php/php*-fpm.sock 2>/dev/null | head -1)"
[ -n "$PHPSOCK" ] || { echo "No encuentro el socket de PHP-FPM"; exit 1; }

echo "▶ 2/7 Descargando la tienda…"
if [ -d "$RAIZ/.git" ]; then
  git -C "$RAIZ" fetch --quiet origin "$RAMA"
  git -C "$RAIZ" reset --hard --quiet "origin/$RAMA"
else
  rm -rf "$RAIZ"
  git clone --quiet --depth 1 --branch "$RAMA" "$REPO" "$RAIZ"
fi
# datos/ guarda pedidos con datos personales: solo lo toca el proceso de la API
mkdir -p "$RAIZ/datos"
chown -R www-data:www-data "$RAIZ"
chmod 700 "$RAIZ/datos"

echo "▶ 3/7 Levantando la API de pedidos con pm2…"
cd "$RAIZ"
pm2 delete tornabox-api >/dev/null 2>&1 || true
PORT=8787 HOST=127.0.0.1 pm2 start "$RAIZ/server.js" --name tornabox-api --update-env >/dev/null
pm2 save >/dev/null 2>&1 || true
pm2 startup systemd -u root --hp /root >/dev/null 2>&1 || true
sleep 1
TOKEN="$(cat "$RAIZ/datos/token.txt" 2>/dev/null || echo '(mira datos/token.txt)')"

echo "▶ 4/7 Protegiendo el panel con usuario y contraseña…"
if [ ! -f /etc/nginx/tornabox.htpasswd ] || [ -n "$CRM_CLAVE" ]; then
  [ -n "$CRM_CLAVE" ] || CRM_CLAVE="$(head -c 9 /dev/urandom | base64 | tr -d '/+=')"
  htpasswd -bc /etc/nginx/tornabox.htpasswd "$CRM_USUARIO" "$CRM_CLAVE" >/dev/null 2>&1
  CLAVE_MOSTRAR="$CRM_CLAVE"
else
  CLAVE_MOSTRAR="(la que ya tenías)"
fi
chmod 640 /etc/nginx/tornabox.htpasswd
chown root:www-data /etc/nginx/tornabox.htpasswd

echo "▶ 5/7 Configurando nginx…"
cat > /etc/nginx/sites-available/tornabox <<NGINX
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMINIO};
    root ${RAIZ};
    index index.html;

    # Nada de esto se sirve por web: registro de pedidos, base de datos con
    # datos personales, código del servidor y credenciales del transportista
    location = /pedidos.log { deny all; return 404; }
    location ^~ /datos/ { deny all; return 404; }
    location = /server.js { deny all; return 404; }
    location = /deploy-vps.sh { deny all; return 404; }
    location ~ /\.(git|htaccess) { deny all; return 404; }

    # --- API de pedidos (Node con pm2 en 127.0.0.1:8787) ---
    # Crear un pedido es público (lo llama el checkout); leer o modificar
    # exige la cabecera x-admin-token, que comprueba la propia API.
    location /api/ {
        proxy_pass http://127.0.0.1:8787;
        proxy_http_version 1.1;
        proxy_set_header Host \$host;
        # Sin esto, TODOS los pedidos llegarían con IP 127.0.0.1 y la regla de
        # «IP repetida» del CRM se volvería loca
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$remote_addr;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_read_timeout 30s;
    }

    # --- El CRM, detrás de autenticación de servidor ---
    # La contraseña que pide el panel por dentro NO es seguridad: esta sí.
    location = /admin.html {
        auth_basic "CRM de pedidos";
        auth_basic_user_file /etc/nginx/tornabox.htpasswd;
        add_header Cache-Control "no-store";
    }
    location = /admin.js {
        auth_basic "CRM de pedidos";
        auth_basic_user_file /etc/nginx/tornabox.htpasswd;
    }

    # HTML, CSS y JS se revalidan siempre (equivale al .htaccess de Apache)
    location ~* \.(html|css|js|json)$ {
        add_header Cache-Control "no-cache, must-revalidate";
    }
    # Imágenes y tipografías, un mes en caché
    location ~* \.(webp|jpg|jpeg|png|svg|woff2)$ {
        add_header Cache-Control "public, max-age=2592000";
    }

    # Los pedidos: aquí es donde pedido.php se ejecuta de verdad
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:${PHPSOCK};
    }

    error_page 404 /404.html;
}
NGINX

ln -sf /etc/nginx/sites-available/tornabox /etc/nginx/sites-enabled/tornabox
rm -f /etc/nginx/sites-enabled/default
nginx -t
systemctl reload nginx

echo "▶ 6/7 Abriendo el puerto 80…"
command -v ufw >/dev/null && ufw allow 'Nginx Full' >/dev/null 2>&1 || true

echo "▶ 7/7 Comprobando…"
sleep 1
CODIGO="$(curl -s -o /dev/null -w '%{http_code}' http://127.0.0.1/index.html || echo 000)"
[ "$CODIGO" = "200" ] || { echo "⚠ La web responde $CODIGO. Revisa: journalctl -u nginx -n 30"; exit 1; }
API="$(curl -s -o /dev/null -w '%{http_code}' http://127.0.0.1/api/salud || echo 000)"
[ "$API" = "200" ] || { echo "⚠ La API responde $API. Revisa: pm2 logs tornabox-api"; exit 1; }
PANEL="$(curl -s -o /dev/null -w '%{http_code}' http://127.0.0.1/admin.html || echo 000)"
[ "$PANEL" = "401" ] || echo "⚠ El panel responde $PANEL en vez de 401: revisa el auth_basic"


if [ "$SSL" = "--ssl" ] && [ "$DOMINIO" != "_" ]; then
  echo "▶ Extra: certificado HTTPS con Let's Encrypt…"
  apt-get install -y -qq certbot python3-certbot-nginx >/dev/null
  certbot --nginx -d "$DOMINIO" --non-interactive --agree-tos --register-unsafely-without-email --redirect || \
    echo "⚠ El certificado ha fallado (¿el dominio apunta ya a esta IP?). La web sigue en http://"
fi

IP="$(curl -s --max-time 5 https://api.ipify.org || hostname -I | awk '{print $1}')"
echo
echo "═══════════════════════════════════════════════"
echo "  ✅ Tienda publicada"
echo "     http://${IP}/"
[ "$DOMINIO" != "_" ] && echo "     http://${DOMINIO}/  (si el DNS apunta aquí)"
echo
echo "  CRM de pedidos:  http://${IP}/admin.html"
echo "     usuario nginx: ${CRM_USUARIO}"
echo "     clave nginx:   ${CLAVE_MOSTRAR}"
echo "     token de la API (pégalo al entrar en el panel):"
echo "       ${TOKEN}"
echo "     contraseña del panel por defecto: tornabox  (cámbiala en Ajustes)"
echo
echo "  Antes de vender, edita en el servidor:"
echo "     nano ${RAIZ}/pedido.php      ← tu email de pedidos (líneas 9-10)"
echo "     nano ${RAIZ}/lib/manifest.js ← emails visibles y stock semanal"
echo
echo "  API:      pm2 logs tornabox-api   ·   pm2 restart tornabox-api"
echo "  Pedidos:  ${RAIZ}/datos/pedidos.json  (no accesible por web)"
echo
echo "  Para actualizar la web más adelante:  bash $0 $*"
echo "═══════════════════════════════════════════════"
