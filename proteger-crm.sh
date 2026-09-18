#!/usr/bin/env bash
# =============================================================================
# TornaBox — poner usuario y contraseña al CRM (/admin.html)
# -----------------------------------------------------------------------------
# Comprobado el 18/09/2026: https://tornabox.eu/admin.html responde 200 y SIN
# pedir credenciales. Los pedidos no se pueden leer (la API exige el token),
# pero el panel no debe estar abierto.
#
# Este script NO toca la web ni los pedidos: solo añade auth_basic a la
# configuración de nginx. Es idempotente: si ya está puesto, no hace nada.
#
# Uso, como root en el VPS:
#   curl -fsSL https://raw.githubusercontent.com/sevecat2023-pixel/tornarem/claude/tienda-minimalista-psicologia-9q5ku3/proteger-crm.sh -o proteger-crm.sh
#   sudo bash proteger-crm.sh                      # genera la clave
#   sudo CRM_USUARIO=alex CRM_CLAVE=loquesea bash proteger-crm.sh
# =============================================================================
set -euo pipefail

[ "$(id -u)" -eq 0 ] || { echo "Ejecútalo como root:  sudo bash $0"; exit 1; }

CRM_USUARIO="${CRM_USUARIO:-tornabox}"
CRM_CLAVE="${CRM_CLAVE:-}"
HTPASSWD="/etc/nginx/tornabox.htpasswd"

echo "▶ 1/4 Buscando la configuración de nginx de la tienda…"
# El fichero que define el sitio: el que nombra al dominio o la raíz de la web
CONF=""
for f in /etc/nginx/sites-enabled/* /etc/nginx/conf.d/*.conf; do
  [ -f "$f" ] || continue
  if grep -qE 'server_name[^;]*tornabox|root[[:space:]]+[^;]*tornabox' "$f"; then CONF="$f"; break; fi
done
[ -n "$CONF" ] || { echo "✗ No encuentro la configuración. Mírala con:  ls -l /etc/nginx/sites-enabled/"; exit 1; }
# sites-enabled suele ser un enlace: se edita el fichero de verdad
[ -L "$CONF" ] && CONF="$(readlink -f "$CONF")"
echo "   $CONF"

if grep -q 'auth_basic_user_file' "$CONF"; then
  echo "▶ Ya tiene auth_basic puesto. No toco nada."
  echo "   Si has olvidado la clave:  sudo htpasswd $HTPASSWD $CRM_USUARIO"
  exit 0
fi

echo "▶ 2/4 Creando el usuario…"
command -v htpasswd >/dev/null || { export DEBIAN_FRONTEND=noninteractive; apt-get install -y -qq apache2-utils >/dev/null; }
if [ -z "$CRM_CLAVE" ]; then CRM_CLAVE="$(head -c 12 /dev/urandom | base64 | tr -d '/+=' | head -c 14)"; fi
htpasswd -bc "$HTPASSWD" "$CRM_USUARIO" "$CRM_CLAVE" >/dev/null 2>&1
chmod 640 "$HTPASSWD"
chown root:www-data "$HTPASSWD" 2>/dev/null || true

echo "▶ 3/4 Añadiendo el bloque a nginx (con copia de seguridad)…"
COPIA="${CONF}.antes-de-proteger-crm.$(date +%Y%m%d%H%M%S)"
cp -a "$CONF" "$COPIA"

# Se inserta dentro del PRIMER bloque «server {...}», justo antes de su llave de
# cierre. Se hace contando llaves, no con sed a ciegas, para no romper el fichero.
python3 - "$CONF" "$HTPASSWD" <<'PY'
import sys, io
conf, htpasswd = sys.argv[1], sys.argv[2]
texto = io.open(conf, encoding="utf-8").read()

bloque = (
    "\n    # --- CRM protegido con usuario y contraseña ---\n"
    "    # La contraseña que pide el panel por dentro NO es seguridad: es una\n"
    "    # página estática y se ve en el código fuente. Esta sí la comprueba nginx.\n"
    "    location = /admin.html {\n"
    '        auth_basic "CRM de pedidos";\n'
    "        auth_basic_user_file %s;\n"
    '        add_header Cache-Control "no-store";\n'
    "    }\n"
    "    location = /admin.js {\n"
    '        auth_basic "CRM de pedidos";\n'
    "        auth_basic_user_file %s;\n"
    "    }\n" % (htpasswd, htpasswd)
)

inicio = texto.find("server")
if inicio < 0:
    sys.exit("no hay bloque server")
abre = texto.find("{", inicio)
nivel, i = 0, abre
while i < len(texto):
    if texto[i] == "{":
        nivel += 1
    elif texto[i] == "}":
        nivel -= 1
        if nivel == 0:
            break
    i += 1
else:
    sys.exit("bloque server sin cerrar")

io.open(conf, "w", encoding="utf-8").write(texto[:i] + bloque + texto[i:])
PY

echo "▶ 4/4 Comprobando y recargando…"
if ! nginx -t 2>&1 | tail -2; then
  echo "✗ La configuración no valida. Dejo el fichero como estaba."
  cp -a "$COPIA" "$CONF"
  exit 1
fi
systemctl reload nginx

sleep 1
CODIGO="$(curl -s -o /dev/null -w '%{http_code}' -k https://127.0.0.1/admin.html -H 'Host: tornabox.eu' || echo 000)"
echo
echo "═══════════════════════════════════════════════"
if [ "$CODIGO" = "401" ]; then
  echo "  ✅ El CRM ya pide usuario y contraseña"
else
  echo "  ⚠ Responde $CODIGO en vez de 401. Revisa $CONF"
fi
echo
echo "     usuario: ${CRM_USUARIO}"
echo "     clave:   ${CRM_CLAVE}"
echo
echo "  Apúntalas: la clave no se puede recuperar, solo cambiar."
echo "  Copia de la configuración anterior en:"
echo "     ${COPIA}"
echo "═══════════════════════════════════════════════"
