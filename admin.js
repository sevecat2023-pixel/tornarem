/* =============================================================================
   TornaBox — admin.js · panel de pedidos
   -----------------------------------------------------------------------------
   HTML/JS plano, sin framework ni compilación. Habla con los datos SOLO a
   través de db.js, y con el motor de notas a través de credibilidad.js.

   Nada de alert(): los avisos se pintan dentro de la página (ver aviso()).
   ========================================================================== */
(function () {
  "use strict";

  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  var K_CLAVE = "tb_admin_clave";
  var K_PIXEL = "tb_pixel";
  var K_AUTO = "tb_auto_cancelar";
  var K_AUTO_RED = "tb_auto_cancelar_red";
  var CLAVE_POR_DEFECTO = "tornabox";

  var ESTADOS = {
    pendiente_pago: "Pendiente de pago", recibido: "Recibido", preparacion: "En preparación",
    enviado: "Enviado", entregado: "Entregado", cancelado: "Cancelado"
  };

  var pedidos = [];        // del más nuevo al más viejo
  var notas = {};          // num -> analisis
  var filtro = "";
  var seleccion = {};

  /* ============================================================ utilidades == */
  function esc(s) {
    return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
  }
  function eur(n) {
    return (Number(n) || 0).toFixed(2).replace(".", ",") + " €";
  }
  function fecha(iso) {
    var d = new Date(iso);
    if (isNaN(d)) return "—";
    return d.toLocaleDateString("es-ES", { day: "2-digit", month: "2-digit", year: "2-digit" })
      + " " + d.toLocaleTimeString("es-ES", { hour: "2-digit", minute: "2-digit" });
  }

  /** Avisos dentro de la página. Un alert() bloquea el hilo de pintado y deja
   *  la pestaña colgada mientras no le das a «aceptar»: aquí no se usa nunca. */
  function aviso(titulo, cuerpo, tipo, lista) {
    var caja = document.createElement("div");
    caja.className = "aviso " + (tipo || "");
    caja.innerHTML = '<button class="cerrar" aria-label="Cerrar">&times;</button>'
      + "<b>" + esc(titulo) + "</b>" + (cuerpo ? "<span>" + esc(cuerpo) + "</span>" : "")
      + (lista && lista.length ? "<ul>" + lista.map(function (l) { return "<li>" + esc(l) + "</li>"; }).join("") + "</ul>" : "");
    caja.querySelector(".cerrar").addEventListener("click", function () { caja.remove(); });
    $("#avisos").appendChild(caja);
    if (tipo === "bien") setTimeout(function () { caja.remove(); }, 6000);
    caja.scrollIntoView({ block: "nearest", behavior: "smooth" });
    return caja;
  }

  function claseNota(n) {
    if (n == null) return "gris";
    return n >= 7 ? "v" : (n >= 5 ? "n" : "r");
  }

  /* ================================================================ acceso == */
  function claveGuardada() {
    try { return localStorage.getItem(K_CLAVE) || CLAVE_POR_DEFECTO; } catch (e) { return CLAVE_POR_DEFECTO; }
  }

  var TEXTO_SEGURIDAD =
    "Esta contraseña NO es seguridad de verdad: el panel es una página estática, "
    + "así que cualquiera que abra el código fuente la ve. Sirve para que no entre "
    + "quien pase por delante del ordenador, nada más. Lo que sí protege los pedidos "
    + "es el token de administración, porque lo comprueba el servidor en cada petición: "
    + "guárdalo bien y no lo pegues en ningún fichero público. Los pedidos llevan nombre, "
    + "dirección y teléfono de personas reales, así que lo correcto es poner el panel "
    + "detrás de autenticación de servidor (por ejemplo un htpasswd en nginx) además de esto.";

  function initAcceso() {
    $("#nota-seguridad").textContent = TEXTO_SEGURIDAD;
    $("#aviso-seguridad").textContent = TEXTO_SEGURIDAD;

    var form = $("[data-acceso]");
    var tokenGuardado = window.dbToken();
    if (tokenGuardado) form.token.value = tokenGuardado;

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (form.clave.value !== claveGuardada()) {
        form.clave.value = "";
        form.clave.focus();
        form.clave.style.borderColor = "#b91c1c";
        return;
      }
      if (form.token.value) window.dbToken(form.token.value.trim());
      try { sessionStorage.setItem("tb_admin_ok", "1"); } catch (x) {}
      abrirPanel();
    });

    var yaDentro = false;
    try { yaDentro = sessionStorage.getItem("tb_admin_ok") === "1"; } catch (x) {}
    if (yaDentro) abrirPanel(); else form.clave.focus();
  }

  function abrirPanel() {
    $("#acceso").classList.add("oculto");
    $("#panel").classList.remove("oculto");
    initPanel();
    cargar();
  }

  /* ============================================================== conexión == */
  function pintarConexion() {
    var e = window.dbEstado();
    var el = $("[data-conexion]");
    if (e.ultimoError === "token") { el.className = "conexion tok"; el.textContent = "Token no válido"; return; }
    if (e.enLinea === false) {
      el.className = "conexion off";
      el.textContent = "Sin conexión" + (e.enCola ? " · " + e.enCola + " en cola" : "");
      return;
    }
    el.className = "conexion on";
    el.textContent = "Conectado" + (e.enCola ? " · " + e.enCola + " en cola" : "");
  }

  /* ================================================================= carga == */
  function cargar() {
    return window.dbListarPedidos()
      .then(function (lista) {
        pedidos = lista || [];
        recalcularNotas();
        pintarTodo();
        pintarConexion();
        if (window.dbEstado().enLinea === false) {
          aviso("Sin conexión con la API",
            "Se está trabajando con la última copia guardada en este navegador. "
            + "Los cambios se reenviarán solos cuando vuelva.", "ojo");
        }
        autoCancelarSiTocaba();
      })
      .catch(function (e) {
        pintarConexion();
        if (e && e.http === 401) {
          aviso("El token de administración no vale",
            "El servidor responde, pero rechaza el token. Cámbialo en Ajustes.", "mal");
        } else {
          aviso("No se han podido cargar los pedidos", (e && e.message) || "", "mal");
        }
      });
  }

  function recalcularNotas() {
    var ctx = window.credContexto(pedidos);
    pedidos.forEach(function (p) { notas[p.num] = window.credLocal(p, ctx); });
  }

  function pintarTodo() {
    pintarFilas();
    pintarClientes();
    pintarStats();
  }

  /* ========================================================== 1. PEDIDOS ==== */
  function visibles() {
    if (!filtro) return pedidos;
    var q = filtro.toLowerCase();
    return pedidos.filter(function (p) {
      var c = p.cliente || {};
      return [p.num, c.nombre, c.correo, c.telefono, c.direccion, c.ciudad, c.cp, c.ip, p.tracking]
        .join(" ").toLowerCase().indexOf(q) >= 0;
    });
  }

  function opcionesEstado(actual) {
    return Object.keys(ESTADOS).map(function (k) {
      return '<option value="' + k + '"' + (k === actual ? " selected" : "") + ">" + ESTADOS[k] + "</option>";
    }).join("");
  }

  function pintarFilas() {
    var cuerpo = $("[data-filas]");
    var lista = visibles();
    if (!lista.length) {
      cuerpo.innerHTML = '<tr><td colspan="9"><p class="vacio">'
        + (filtro ? "Ningún pedido cuadra con la búsqueda." : "Todavía no hay pedidos.")
        + "</p></td></tr>";
      pintarMasa();
      return;
    }

    cuerpo.innerHTML = lista.map(function (p) {
      var c = p.cliente || {};
      var a = notas[p.num] || {};
      var n = a.nota;
      return '<tr data-num="' + esc(p.num) + '" style="border-left-color:var(--e-' + esc(p.estado) + ')"'
        + (seleccion[p.num] ? ' class="sel"' : "") + ">"
        /* Las celdas con controles llevan data-stop: el manejador de la fila
           ignora los clics que salgan de dentro, para que cambiar el estado o
           escribir el seguimiento no abra la ficha. */
        + '<td data-stop><input type="checkbox" data-marcar="' + esc(p.num) + '"'
        + (seleccion[p.num] ? " checked" : "") + ' aria-label="Seleccionar ' + esc(p.num) + '"></td>'
        + "<td>" + esc(fecha(p.fecha)) + (p.sinSincronizar ? '<br><span class="sinsync">sin sincronizar</span>' : "") + "</td>"
        + '<td class="num">' + esc(p.num) + "</td>"
        + '<td class="cli"><b>' + esc(c.nombre || "—") + "</b><span>"
        + esc([c.ciudad, c.cp].filter(Boolean).join(" · ")) + "</span></td>"
        + '<td class="cont">' + esc(c.correo || "") + "<br>" + esc(c.telefono || "") + "</td>"
        + '<td class="imp">' + eur(p.total) + "</td>"
        + '<td><span class="nota ' + claseNota(n) + '">' + (n == null ? "—" : n.toFixed(1)) + "</span></td>"
        + '<td data-stop><select class="sel-estado" data-estado="' + esc(p.num) + '">'
        + opcionesEstado(p.estado) + "</select></td>"
        + '<td data-stop><span class="tr-campo">'
        + '<input type="text" data-tracking="' + esc(p.num) + '" value="' + esc(p.tracking || "") + '" placeholder="Nº seguimiento">'
        + '<button class="mini" data-guardar-tr="' + esc(p.num) + '">Guardar</button></span></td>'
        + "</tr>";
    }).join("");
    pintarMasa();
  }

  function pintarMasa() {
    var n = Object.keys(seleccion).filter(function (k) { return seleccion[k]; }).length;
    $("[data-masa-n]").textContent = n;
    $("[data-masa]").classList.toggle("oculto", n === 0);
  }

  function porNum(num) {
    return pedidos.filter(function (p) { return p.num === num; })[0];
  }

  function guardar(num, patch, silencio) {
    return window.dbActualizarPedido(num, patch)
      .then(function (p) {
        pedidos = pedidos.map(function (x) { return x.num === num ? p : x; });
        recalcularNotas();
        pintarTodo();
        pintarConexion();
        if (!silencio) aviso("Guardado", num + " actualizado.", "bien");
        return p;
      })
      .catch(function (e) {
        aviso("No se ha podido guardar " + num, (e && e.message) || "", "mal");
        throw e;
      });
  }

  /* ------------------------------------------------------------ la ficha --- */
  function relacionados(p) {
    var c = p.cliente || {};
    return pedidos.filter(function (q) {
      if (q.num === p.num) return false;
      var d = q.cliente || {};
      var mismoCorreo = c.correo && d.correo === c.correo;
      var mismoTel = c.telefono && d.telefono === c.telefono;
      var mismaDir = c.direccion && d.direccion === c.direccion && (d.numero || "") === (c.numero || "");
      var mismaIp = c.ip && d.ip === c.ip;
      return mismoCorreo || mismoTel || mismaDir || mismaIp;
    });
  }

  function listaMotivos(items, clase) {
    if (!items || !items.length) return '<p style="font-size:.86rem;color:var(--tenue)">Nada.</p>';
    return '<ul class="motivos ' + clase + '">' + items.map(function (m) {
      return '<li><span class="v">' + (m.val > 0 ? "+" : "") + m.val.toFixed(2) + "</span><span>" + esc(m.txt) + "</span></li>";
    }).join("") + "</ul>";
  }

  function abrirFicha(num) {
    var p = porNum(num);
    if (!p) return;
    var a = notas[num] || window.credLocal(p, window.credContexto(pedidos));
    var c = p.cliente || {};
    var rel = relacionados(p);

    var host = $("#ficha-host");
    host.innerHTML = '<div class="velo" data-velo><div class="ficha" role="dialog" aria-modal="true">'
      + '<button class="cerrar" data-cerrar aria-label="Cerrar">&times;</button>'
      + "<h2>" + esc(p.num)
      + ' <span class="nota ' + claseNota(a.nota) + '">' + a.nota.toFixed(1) + "</span>"
      + ' <span style="font-size:.8rem;font-weight:700;color:var(--e-' + esc(p.estado) + ')">'
      + esc(ESTADOS[p.estado] || p.estado) + "</span>"
      + (a.pendiente ? ' <span class="cobrar">Análisis incompleto</span>' : "")
      + "</h2>"
      + '<p style="font-size:.85rem;color:var(--tenue)">' + esc(fecha(p.fecha))
      + " · recomendación: <b>" + esc(a.recomendacion) + "</b></p>"

      + '<div class="bloques">'

      + '<div class="bloque"><h3>Cliente</h3><dl>'
      + "<dt>Nombre</dt><dd>" + esc(c.nombre || "—") + "</dd>"
      + "<dt>Correo</dt><dd>" + esc(c.correo || "—") + "</dd>"
      + "<dt>Teléfono</dt><dd>" + esc(c.telefono || "—") + "</dd>"
      + "<dt>Dirección</dt><dd>" + esc([c.direccion, c.numero, c.piso, c.planta].filter(Boolean).join(", ") || "—") + "</dd>"
      + "<dt>CP</dt><dd>" + esc(c.cp || "—") + "</dd>"
      + "<dt>Ciudad</dt><dd>" + esc([c.ciudad, c.pueblo].filter(Boolean).join(" / ") || "—") + "</dd>"
      + "<dt>Provincia</dt><dd>" + esc(c.provincia || "—") + "</dd>"
      + "<dt>IP</dt><dd>" + esc(c.ip || "(no registrada)") + "</dd>"
      + (p.notas ? "<dt>Notas</dt><dd>" + esc(p.notas) + "</dd>" : "")
      + "</dl></div>"

      + '<div class="bloque"><h3>Pedido</h3><dl>'
      + p.lineas.map(function (l) {
          return "<dt>" + esc(l.qty) + "×</dt><dd>" + esc(l.nombre) + " — " + eur(l.precio) + "</dd>";
        }).join("")
      + "<dt>Subtotal</dt><dd>" + eur(p.subtotal) + "</dd>"
      + "<dt>Envío</dt><dd>" + (p.envio ? eur(p.envio) : "Gratis") + " (" + esc(p.envioTipo) + ")</dd>"
      + (p.recargo ? "<dt>Contra reembolso</dt><dd>" + eur(p.recargo) + "</dd>" : "")
      + "<dt><b>Total</b></dt><dd><b>" + eur(p.total) + "</b></dd>"
      + "<dt>Pago</dt><dd>" + (p.pago === "reembolso" ? "Contra reembolso" : "Tarjeta") + "</dd>"
      + "<dt>Seguimiento</dt><dd>" + esc(p.tracking || "—") + "</dd>"
      + "</dl></div>"

      + '<div class="bloque"><h3>Por qué baja la nota</h3>' + listaMotivos(a.resta, "baja") + "</div>"
      + '<div class="bloque"><h3>Por qué sube</h3>' + listaMotivos(a.suma, "sube")
      + '<details class="superadas"><summary>Comprobaciones superadas (' + a.ok.length + ")</summary><ul>"
      + a.ok.map(function (t) { return "<li>" + esc(t) + "</li>"; }).join("") + "</ul></details>"
      + (a.pendiente ? '<p class="chivato" style="color:var(--aviso)">' + esc(a.motivoPendiente || "")
          + " — este pedido queda fuera del cancelado automático.</p>" : "")
      + "</div>"

      + '<div class="bloque ancho rel"><h3>Pedidos relacionados (' + rel.length + ")</h3>"
      + (rel.length
          ? rel.map(function (q) {
              var d = q.cliente || {};
              var por = [];
              if (c.correo && d.correo === c.correo) por.push("mismo correo");
              if (c.telefono && d.telefono === c.telefono) por.push("mismo teléfono");
              if (c.direccion && d.direccion === c.direccion) por.push("misma dirección");
              if (c.ip && d.ip === c.ip) por.push("misma IP");
              return '<a href="#" data-ir="' + esc(q.num) + '">' + esc(q.num) + " · " + esc(fecha(q.fecha))
                + " · " + eur(q.total) + " · " + esc(ESTADOS[q.estado] || q.estado)
                + " — " + esc(por.join(", ")) + "</a>";
            }).join("")
          : '<p style="font-size:.86rem;color:var(--tenue)">Ninguno.</p>')
      + "</div>"

      + "</div>"

      + '<div class="acciones">'
      + '<select class="sel-estado" data-f-estado>' + opcionesEstado(p.estado) + "</select>"
      + '<input type="text" data-f-tracking value="' + esc(p.tracking || "") + '" placeholder="Nº de seguimiento" '
      + 'style="padding:.5rem .7rem;border:1px solid var(--linea);border-radius:9px">'
      + '<button class="btn pri" data-f-guardar>Guardar</button>'
      + '<button class="btn" data-f-envio>Generar envío con Correos</button>'
      + (p.tracking ? '<button class="btn" data-f-etiqueta>Ver etiqueta</button>' : "")
      + (p.pago === "reembolso" ? '<span class="cobrar">Contra reembolso · cobrar ' + eur(p.total) + "</span>" : "")
      + '<button class="btn peligro" data-f-borrar style="margin-left:auto">Borrar pedido</button>'
      + "</div></div></div>";

    var velo = $("[data-velo]", host);
    var cerrar = function () { host.innerHTML = ""; document.removeEventListener("keydown", esc2); };
    var esc2 = function (e) { if (e.key === "Escape") cerrar(); };
    document.addEventListener("keydown", esc2);
    velo.addEventListener("click", function (e) { if (e.target === velo) cerrar(); });
    $("[data-cerrar]", host).addEventListener("click", cerrar);

    $$("[data-ir]", host).forEach(function (a2) {
      a2.addEventListener("click", function (e) { e.preventDefault(); cerrar(); abrirFicha(a2.dataset.ir); });
    });

    $("[data-f-guardar]", host).addEventListener("click", function () {
      guardar(num, { estado: $("[data-f-estado]", host).value, tracking: $("[data-f-tracking]", host).value.trim() })
        .then(cerrar);
    });
    $("[data-f-borrar]", host).addEventListener("click", function () {
      if (!confirm("¿Borrar el pedido " + num + "? No se puede deshacer.")) return;
      window.dbBorrarPedido(num).then(function () {
        pedidos = pedidos.filter(function (x) { return x.num !== num; });
        recalcularNotas(); pintarTodo(); cerrar();
        aviso("Pedido borrado", num, "bien");
      }).catch(function (e) { aviso("No se ha podido borrar", (e && e.message) || "", "mal"); });
    });
    $("[data-f-envio]", host).addEventListener("click", function () {
      var b = $("[data-f-envio]", host); b.disabled = true; b.textContent = "Generando…";
      fetch((window.__DB_API__ || "/api") + "/correos/envio", {
        method: "POST",
        headers: { "Content-Type": "application/json", "x-admin-token": window.dbToken() },
        body: JSON.stringify({ num: num })
      }).then(function (r) { return r.json(); }).then(function (j) {
        b.disabled = false; b.textContent = "Generar envío con Correos";
        if (!j.ok) { aviso("Correos no ha generado el envío", j.error || "", "mal"); return; }
        aviso("Envío generado", "Seguimiento " + j.pedido.tracking, "bien");
        cerrar(); cargar();
      }).catch(function (e) {
        b.disabled = false; b.textContent = "Generar envío con Correos";
        aviso("No se ha podido contactar con la API", (e && e.message) || "", "mal");
      });
    });
    var bEt = $("[data-f-etiqueta]", host);
    if (bEt) bEt.addEventListener("click", function () {
      window.open((window.__DB_API__ || "/api") + "/correos/etiqueta?num=" + encodeURIComponent(num), "_blank");
    });

    // Las comprobaciones de internet se lanzan al abrir la ficha (van cacheadas
    // 30 días), y si cambian la nota se refresca también la tabla.
    if (!a.checks) {
      window.credAnalizar(p, window.credContexto(pedidos)).then(function (a2) {
        notas[num] = a2;
        pintarFilas();
        if ($("[data-velo]")) abrirFicha(num);
      });
    }
  }

  /* ========================================================= 2. CLIENTES ==== */
  function agrupaClientes() {
    var mapa = {};
    pedidos.forEach(function (p) {
      var c = p.cliente || {};
      // Se agrupa por correo; si no hay, por teléfono; si tampoco, por nombre.
      var clave = (c.correo || c.telefono || c.nombre || "(sin datos)").toLowerCase();
      if (!mapa[clave]) mapa[clave] = { nombre: c.nombre, correo: c.correo, telefono: c.telefono,
                                        ciudad: c.ciudad, n: 0, gastado: 0 };
      var g = mapa[clave];
      g.n++;
      // Lo cancelado no es dinero: no cuenta como gasto.
      if (p.estado !== "cancelado") g.gastado += Number(p.total) || 0;
      if (!g.nombre) g.nombre = c.nombre;
      if (!g.ciudad) g.ciudad = c.ciudad;
    });
    return Object.keys(mapa).map(function (k) { return mapa[k]; })
      .sort(function (a, b) { return b.gastado - a.gastado; });
  }

  function pintarClientes() {
    var lista = agrupaClientes();
    $("[data-clientes]").innerHTML = lista.length
      ? lista.map(function (g) {
          return "<tr><td><b>" + esc(g.nombre || "—") + "</b></td><td>" + esc(g.correo || "—") + "</td>"
            + "<td>" + esc(g.telefono || "—") + "</td><td>" + esc(g.ciudad || "—") + "</td>"
            + '<td class="imp">' + g.n + '</td><td class="imp">' + eur(g.gastado) + "</td></tr>";
        }).join("")
      : '<tr><td colspan="6"><p class="vacio">Todavía no hay clientes.</p></td></tr>';
  }

  /* ===================================================== 3. ESTADÍSTICAS ==== */
  function pintarStats() {
    var validos = pedidos.filter(function (p) { return p.estado !== "cancelado"; });
    var ingresos = validos.reduce(function (s, p) { return s + (Number(p.total) || 0); }, 0);
    var unidades = validos.reduce(function (s, p) { return s + (Number(p.unidades) || 0); }, 0);

    $("[data-st-pedidos]").textContent = validos.length;
    $("[data-st-ingresos]").textContent = eur(ingresos);
    $("[data-st-medio]").textContent = eur(validos.length ? ingresos / validos.length : 0);
    $("[data-st-unidades]").textContent = unidades;

    var cuenta = {};
    validos.forEach(function (p) {
      (p.lineas || []).forEach(function (l) {
        if (!cuenta[l.nombre]) cuenta[l.nombre] = { n: 0, euros: 0 };
        cuenta[l.nombre].n += l.qty || 1;
        cuenta[l.nombre].euros += (Number(l.precio) || 0) * (l.qty || 1);
      });
    });
    var rank = Object.keys(cuenta).map(function (k) {
      return { nombre: k, n: cuenta[k].n, euros: cuenta[k].euros };
    }).sort(function (a, b) { return b.n - a.n; });
    var tope = rank.length ? rank[0].n : 1;

    $("[data-st-ranking]").innerHTML = rank.length
      ? "<h3 style='font-size:.95rem'>Lo más vendido</h3>" + rank.map(function (r) {
          return '<div class="rank-fila"><span>' + esc(r.nombre) + "</span>"
            + "<b>" + r.n + " · " + eur(r.euros) + "</b>"
            + '<span class="barra"><i style="width:' + Math.round(r.n / tope * 100) + '%"></i></span></div>';
        }).join("")
      : '<p class="vacio">Sin ventas todavía.</p>';
  }

  /* ========================================================== 4. AJUSTES ==== */

  /** CSV con BOM: sin él, Excel abre el fichero en su codificación regional y
   *  destroza todos los acentos («García» → «GarcÃ­a»). */
  function exportarCSV() {
    var cols = ["num", "fecha", "estado", "nota", "nombre", "correo", "telefono", "direccion",
      "numero", "piso", "cp", "ciudad", "provincia", "ip", "articulos", "unidades",
      "subtotal", "envio", "recargo", "total", "pago", "envioTipo", "tracking"];
    var campo = function (v) {
      var s = String(v == null ? "" : v);
      return /[";\n\r]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s;
    };
    var filas = [cols.join(";")];
    pedidos.forEach(function (p) {
      var c = p.cliente || {}, a = notas[p.num] || {};
      filas.push([p.num, p.fecha, p.estado, a.nota == null ? "" : a.nota.toFixed(1),
        c.nombre, c.correo, c.telefono, c.direccion, c.numero, c.piso, c.cp, c.ciudad,
        c.provincia, c.ip,
        (p.lineas || []).map(function (l) { return l.qty + "× " + l.nombre; }).join(" + "),
        p.unidades,
        String(p.subtotal).replace(".", ","), String(p.envio).replace(".", ","),
        String(p.recargo || 0).replace(".", ","), String(p.total).replace(".", ","),
        p.pago, p.envioTipo, p.tracking].map(campo).join(";"));
    });

    var blob = new Blob(["﻿" + filas.join("\r\n")], { type: "text/csv;charset=utf-8;" });
    var url = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = url;
    a.download = "pedidos-tornabox-" + new Date().toISOString().slice(0, 10) + ".csv";
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(function () { URL.revokeObjectURL(url); }, 2000);
    $("[data-datos-chivato]").textContent = "Exportadas " + pedidos.length + " filas.";
  }

  function pedidoEjemplo() {
    var n = Math.floor(Math.random() * 4);
    var gente = [
      { nombre: "Lucía Fernández Soto", correo: "lucia.fernandez@gmail.com", telefono: "612345678",
        direccion: "Calle Sierpes", numero: "12", piso: "2A", cp: "41004", ciudad: "Sevilla", provincia: "Sevilla" },
      { nombre: "Marc Puig Roca", correo: "marc.puig@hotmail.com", telefono: "678112233",
        direccion: "Carrer de Mallorca", numero: "212", piso: "3B", cp: "08008", ciudad: "Barcelona", provincia: "Barcelona" },
      { nombre: "sdfg", correo: "test@yopmail.com", telefono: "111111111",
        direccion: "x", numero: "600123456", piso: "", cp: "0", ciudad: "", provincia: "Aragón" },
      { nombre: "Iker Etxeberria", correo: "iker@gmail.con", telefono: "600999888",
        direccion: "Gran Via", numero: "32", piso: "", cp: "48001", ciudad: "Bilbao", provincia: "Vizkaya" }
    ][n];
    var cajas = ["inicio", "grande", "tech", "xxl"];
    return window.dbCrearPedido({
      caja: cajas[n], pago: n % 2 ? "reembolso" : "tarjeta", seguro: n === 1,
      cliente: Object.assign({ ip: "88.20.30." + (10 + n) }, gente)
    }).then(function (p) {
      aviso("Pedido de ejemplo creado", p.num, "bien");
      return cargar();
    });
  }

  /* --------------------------------------------------- pixel de Google ----- */
  function pixelGuardado() { try { return localStorage.getItem(K_PIXEL) || ""; } catch (e) { return ""; } }

  function cargarPixel(id) {
    if (!id || $("#gtag-js")) return;
    var s = document.createElement("script");
    s.id = "gtag-js"; s.async = true;
    s.src = "https://www.googletagmanager.com/gtag/js?id=" + encodeURIComponent(id);
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag("js", new Date());
    window.gtag("config", id);
  }

  /* --------------------------------------- cancelación automática ---------- */
  function autoActivo() { try { return localStorage.getItem(K_AUTO) === "1"; } catch (e) { return false; } }
  function autoRed() { try { return localStorage.getItem(K_AUTO_RED) === "1"; } catch (e) { return false; } }

  function simular() {
    var chiv = $("[data-auto-chivato]");
    chiv.textContent = "Analizando " + pedidos.length + " pedidos"
      + (autoRed() ? " con comprobaciones de internet (1 por segundo, puede tardar)…" : "…");
    return window.credAutoCancelar(pedidos, { conRed: autoRed() });
  }

  function pintarSimulacion(lista, aplicado) {
    var chiv = $("[data-auto-chivato]");
    chiv.textContent = "";
    if (!lista.length) {
      aviso("No se cancelaría ningún pedido",
        "Se han analizado " + pedidos.length + " pedidos y ninguno cumple las condiciones de cancelación.", "bien");
      return;
    }
    aviso(aplicado ? "Cancelados " + lista.length + " pedidos"
                   : "Se cancelarían " + lista.length + " de " + pedidos.length + " pedidos",
      aplicado ? "" : "Esto es solo una simulación: no se ha tocado nada.",
      aplicado ? "ojo" : "ojo",
      lista.map(function (x) {
        return x.num + " · " + x.cliente + " · " + eur(x.total) + " · nota " + x.nota.toFixed(1) + " — " + x.motivo;
      }));
  }

  function aplicarAuto() {
    return simular().then(function (lista) {
      if (!lista.length) { pintarSimulacion(lista, false); return; }
      var cadena = Promise.resolve();
      lista.forEach(function (x) {
        cadena = cadena.then(function () {
          return guardar(x.num, { estado: "cancelado", cancelacion: x.motivo }, true);
        });
      });
      return cadena.then(function () { pintarSimulacion(lista, true); });
    });
  }

  /** Se ejecuta sola al cargar SOLO si está activada en Ajustes. Por defecto
   *  está apagada: primero se simula y se revisa. */
  function autoCancelarSiTocaba() {
    if (!autoActivo() || !pedidos.length) return;
    aplicarAuto();
  }

  /* ---------------------------------------------------------- Correos ------ */
  function cargarCorreos() {
    return fetch((window.__DB_API__ || "/api") + "/correos/config", {
      headers: { "x-admin-token": window.dbToken() }
    }).then(function (r) { return r.json(); }).then(function (j) {
      if (!j.ok) return;
      var c = j.config || {};
      $("[data-co-usuario]").value = c.usuario || "";
      $("[data-co-codcliente]").value = c.codCliente || "";
      $("[data-co-iban]").value = c.iban || "";
      $("[data-co-chivato]").textContent = "Contraseña guardada: " + (c.tienePassword ? "sí" : "no")
        + " · IBAN para reembolso: " + (c.tieneIban ? "sí" : "no");
    }).catch(function () {});
  }

  /* ============================================================== eventos == */
  function initPanel() {
    // --- pestañas ---
    $$(".tabs button").forEach(function (b) {
      b.addEventListener("click", function () {
        $$(".tabs button").forEach(function (x) { x.setAttribute("aria-selected", String(x === b)); });
        $$("[data-panel]").forEach(function (s) { s.classList.toggle("oculto", s.dataset.panel !== b.dataset.tab); });
      });
    });

    $("[data-recargar]").addEventListener("click", function () { cargar(); });
    $("[data-salir]").addEventListener("click", function () {
      try { sessionStorage.removeItem("tb_admin_ok"); } catch (e) {}
      location.reload();
    });

    var temporizador;
    $("[data-buscar]").addEventListener("input", function (e) {
      clearTimeout(temporizador);
      var v = e.target.value;
      temporizador = setTimeout(function () { filtro = v.trim(); pintarFilas(); }, 180);
    });

    // --- tabla: un solo manejador para todo (delegación) ---
    var cuerpo = $("[data-filas]");

    cuerpo.addEventListener("click", function (e) {
      // Los clics que salen de una celda con controles NO abren la ficha.
      if (e.target.closest("[data-stop]")) return;
      var tr = e.target.closest("tr[data-num]");
      if (tr) abrirFicha(tr.dataset.num);
    });

    cuerpo.addEventListener("change", function (e) {
      var t = e.target;
      if (t.dataset.marcar) {
        seleccion[t.dataset.marcar] = t.checked;
        t.closest("tr").classList.toggle("sel", t.checked);
        pintarMasa();
      }
      if (t.dataset.estado) guardar(t.dataset.estado, { estado: t.value });
    });

    cuerpo.addEventListener("click", function (e) {
      var b = e.target.closest("[data-guardar-tr]");
      if (!b) return;
      var num = b.dataset.guardarTr;
      var input = $('[data-tracking="' + CSS.escape(num) + '"]', cuerpo);
      guardar(num, { tracking: input.value.trim() });
    });

    $("[data-todos]").addEventListener("change", function (e) {
      visibles().forEach(function (p) { seleccion[p.num] = e.target.checked; });
      pintarFilas();
    });

    // --- acciones en masa ---
    $("[data-masa-aplicar]").addEventListener("click", function () {
      var estado = $("[data-masa-estado]").value;
      if (!estado) { aviso("Elige un estado", "", "ojo"); return; }
      var nums = Object.keys(seleccion).filter(function (k) { return seleccion[k]; });
      var cadena = Promise.resolve();
      nums.forEach(function (n) { cadena = cadena.then(function () { return guardar(n, { estado: estado }, true); }); });
      cadena.then(function () {
        seleccion = {}; pintarFilas();
        aviso("Estado aplicado a " + nums.length + " pedidos", ESTADOS[estado], "bien");
      });
    });

    $("[data-masa-borrar]").addEventListener("click", function () {
      var nums = Object.keys(seleccion).filter(function (k) { return seleccion[k]; });
      if (!confirm("¿Borrar " + nums.length + " pedidos? No se puede deshacer.")) return;
      var cadena = Promise.resolve();
      nums.forEach(function (n) { cadena = cadena.then(function () { return window.dbBorrarPedido(n); }); });
      cadena.then(function () {
        seleccion = {};
        aviso("Borrados " + nums.length + " pedidos", "", "bien");
        cargar();
      }).catch(function (e) { aviso("No se han podido borrar todos", (e && e.message) || "", "mal"); });
    });

    // --- ajustes: pixel ---
    $("[data-pixel]").value = pixelGuardado();
    if (pixelGuardado()) cargarPixel(pixelGuardado());
    $("[data-pixel-guardar]").addEventListener("click", function () {
      var id = $("[data-pixel]").value.trim();
      try { localStorage.setItem(K_PIXEL, id); } catch (e) {}
      cargarPixel(id);
      $("[data-pixel-chivato]").textContent = id ? "Guardado: " + id : "Vaciado.";
    });
    $("[data-pixel-probar]").addEventListener("click", function () {
      var id = $("[data-pixel]").value.trim();
      if (!id) { $("[data-pixel-chivato]").textContent = "Pon primero un identificador."; return; }
      cargarPixel(id);
      setTimeout(function () {
        var cargado = Boolean(window.gtag) && Boolean($("#gtag-js"));
        if (cargado && window.gtag) window.gtag("event", "prueba_crm", { origen: "panel" });
        $("[data-pixel-chivato]").textContent = cargado
          ? "Script cargado y evento «prueba_crm» enviado. Compruébalo en el tiempo real de Google."
          : "No se ha podido cargar el script de Google (¿bloqueador de anuncios?).";
      }, 1200);
    });
    $("[data-pixel-quitar]").addEventListener("click", function () {
      try { localStorage.removeItem(K_PIXEL); } catch (e) {}
      $("[data-pixel]").value = "";
      var s = $("#gtag-js"); if (s) s.remove();
      $("[data-pixel-chivato]").textContent = "Quitado. Recarga la página para descargarlo del todo.";
    });

    // --- ajustes: contraseña y token ---
    $("[data-clave-guardar]").addEventListener("click", function () {
      var v = $("[data-clave-nueva]").value;
      if (v.length < 4) { $("[data-clave-chivato]").textContent = "Pon al menos 4 caracteres."; return; }
      try { localStorage.setItem(K_CLAVE, v); } catch (e) {}
      $("[data-clave-nueva]").value = "";
      $("[data-clave-chivato]").textContent = "Contraseña cambiada (solo en este navegador; recuerda que no es seguridad real).";
    });
    $("[data-token-guardar]").addEventListener("click", function () {
      window.dbToken($("[data-token-nuevo]").value.trim());
      $("[data-token-nuevo]").value = "";
      $("[data-clave-chivato]").textContent = "Token guardado. Recargando pedidos…";
      cargar();
    });

    // --- ajustes: auto-cancelado ---
    $("[data-auto-activo]").checked = autoActivo();
    $("[data-auto-red]").checked = autoRed();
    $("[data-auto-activo]").addEventListener("change", function (e) {
      try { localStorage.setItem(K_AUTO, e.target.checked ? "1" : "0"); } catch (x) {}
      $("[data-auto-chivato]").textContent = e.target.checked
        ? "Activada: se aplicará cada vez que se carguen los pedidos."
        : "Desactivada.";
    });
    $("[data-auto-red]").addEventListener("change", function (e) {
      try { localStorage.setItem(K_AUTO_RED, e.target.checked ? "1" : "0"); } catch (x) {}
    });
    $("[data-auto-simular]").addEventListener("click", function () {
      simular().then(function (l) { pintarSimulacion(l, false); });
    });
    $("[data-auto-aplicar]").addEventListener("click", function () {
      if (!confirm("Esto va a cancelar de verdad los pedidos que salgan. ¿Seguir?")) return;
      aplicarAuto();
    });

    // --- ajustes: Correos ---
    cargarCorreos();
    $("[data-co-guardar]").addEventListener("click", function () {
      fetch((window.__DB_API__ || "/api") + "/correos/config", {
        method: "POST",
        headers: { "Content-Type": "application/json", "x-admin-token": window.dbToken() },
        body: JSON.stringify({
          usuario: $("[data-co-usuario]").value.trim(),
          password: $("[data-co-password]").value,
          codCliente: $("[data-co-codcliente]").value.trim(),
          iban: $("[data-co-iban]").value.trim()
        })
      }).then(function (r) { return r.json(); }).then(function () {
        $("[data-co-password]").value = "";
        aviso("Credenciales guardadas en el servidor", "Este navegador no conserva ninguna.", "bien");
        cargarCorreos();
      }).catch(function (e) { aviso("No se han podido guardar", (e && e.message) || "", "mal"); });
    });
    $("[data-co-probar]").addEventListener("click", function () {
      $("[data-co-chivato]").textContent = "Probando…";
      fetch((window.__DB_API__ || "/api") + "/correos/probar", {
        method: "POST", headers: { "x-admin-token": window.dbToken() }
      }).then(function (r) { return r.json(); }).then(function (j) {
        $("[data-co-chivato]").textContent = j.ok
          ? "Respuesta de Correos: HTTP " + (j.estado || "—") + ". " + (j.respuesta || "").slice(0, 200)
          : (j.error || "No se ha podido probar");
      }).catch(function (e) { $("[data-co-chivato]").textContent = (e && e.message) || "error"; });
    });

    // --- ajustes: datos ---
    $("[data-csv]").addEventListener("click", exportarCSV);
    $("[data-ejemplo]").addEventListener("click", pedidoEjemplo);
    $("[data-limpiar]").addEventListener("click", function () {
      window.dbLimpiarCache();
      window.credLimpiarCache();
      $("[data-datos-chivato]").textContent = "Caché de pedidos y de comprobaciones vaciada.";
      cargar();
    });
    $("[data-borrar-todo]").addEventListener("click", function () {
      if (!confirm("¿BORRAR TODOS LOS PEDIDOS? Esto no se puede deshacer.")) return;
      if (!confirm("Última confirmación: se van a borrar " + pedidos.length + " pedidos.")) return;
      window.dbBorrarTodos().then(function () {
        aviso("Todos los pedidos borrados", "", "ojo");
        cargar();
      }).catch(function (e) { aviso("No se han podido borrar", (e && e.message) || "", "mal"); });
    });
  }

  /* ================================================================ arranque */
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", initAcceso);
  else initAcceso();
})();
