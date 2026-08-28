#!/usr/bin/env bash
# =============================================================
# TornaBox — instalación en un VPS (Debian/Ubuntu)
#
# Uso, como root en tu VPS:
#   bash deploy-vps.sh                 → sirve por la IP del servidor
#   bash deploy-vps.sh tienda.local    → además responde a ese nombre
#   bash deploy-vps.sh tornabox.es --ssl → dominio público + HTTPS gratis
#
# Instala nginx + PHP, clona la tienda y la deja funcionando.
# Volver a ejecutarlo actualiza la web a la última versión (es idempotente).
# =============================================================
set -euo pipefail

DOMINIO="${1:-_}"
SSL="${2:-}"
RAIZ="/var/www/tornabox"
RAMA="claude/tienda-minimalista-psicologia-9q5ku3"
REPO="https://github.com/sevecat2023-pixel/tornarem.git"

[ "$(id -u)" -eq 0 ] || { echo "Ejecútalo como root:  sudo bash $0 $*"; exit 1; }

echo "▶ 1/5 Instalando nginx y PHP…"
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get install -y -qq nginx php-fpm php-mbstring git curl >/dev/null

PHPSOCK="$(ls /run/php/php*-fpm.sock 2>/dev/null | head -1)"
[ -n "$PHPSOCK" ] || { echo "No encuentro el socket de PHP-FPM"; exit 1; }

echo "▶ 2/5 Descargando la tienda…"
if [ -d "$RAIZ/.git" ]; then
  git -C "$RAIZ" fetch --quiet origin "$RAMA"
  git -C "$RAIZ" reset --hard --quiet "origin/$RAMA"
else
  rm -rf "$RAIZ"
  git clone --quiet --depth 1 --branch "$RAMA" "$REPO" "$RAIZ"
fi
chown -R www-data:www-data "$RAIZ"

echo "▶ 3/5 Configurando nginx…"
cat > /etc/nginx/sites-available/tornabox <<NGINX
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMINIO};
    root ${RAIZ};
    index index.html;

    # El registro de pedidos nunca se sirve por web
    location = /pedidos.log { deny all; return 404; }
    location ~ /\.(git|htaccess) { deny all; return 404; }

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

echo "▶ 4/5 Abriendo el puerto 80…"
command -v ufw >/dev/null && ufw allow 'Nginx Full' >/dev/null 2>&1 || true

echo "▶ 5/5 Comprobando…"
sleep 1
CODIGO="$(curl -s -o /dev/null -w '%{http_code}' http://127.0.0.1/index.html || echo 000)"
[ "$CODIGO" = "200" ] || { echo "⚠ La web responde $CODIGO. Revisa: journalctl -u nginx -n 30"; exit 1; }

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
echo "  Antes de vender, edita en el servidor:"
echo "     nano ${RAIZ}/pedido.php      ← tu email de pedidos (líneas 9-10)"
echo "     nano ${RAIZ}/lib/manifest.js ← WhatsApp y stock semanal"
echo
echo "  Para actualizar la web más adelante:  bash $0 $*"
echo "═══════════════════════════════════════════════"
