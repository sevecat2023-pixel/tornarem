(function () {
  "use strict";
  /* ===========================================================
     TORNAREM · Panel de administración — comportamiento

     Un solo fichero, sin módulos y sin dependencias: el panel es una
     herramienta de trabajo que tiene que abrirse rápido en el móvil
     del almacén y en el portátil de la oficina.

     Todo lo que se ve aquí sale de admin/api.php, que lee la carpeta
     «datos» del servidor. No hay datos de ejemplo ni de relleno: si
     una lista está vacía es que no hay nada que enseñar.
     =========================================================== */

  var VERSION = "20260910";
  var CLAVE = "tornarem_panel_v1";

  /* Catálogo del navegador: sirve de red por si el panel se abre antes
     de que responda la API (nombres y fotos de los lotes). */
  var TIENDA = window.__TIENDA__ || { lotes: [] };

  var ESTADOS = {
    nuevo: "Nuevo",
    preparando: "Preparando",
    enviado: "Enviado",
    entregado: "Entregado",
    incidencia: "Incidencia",
    cancelado: "Cancelado"
  };
  var PAGOS = { contrarreembolso: "Contrarreembolso", tarjeta: "Tarjeta" };
  var PAGO_ESTADOS = {
    pendiente: "Pendiente",
    pagado: "Pagado",
    cobrado_entrega: "Cobrado en entrega",
    fallido: "Fallido"
  };

  /* Transiciones con sentido. Un pedido no salta de nuevo a entregado:
     si hace falta corregir, se pasa por incidencia. Desde cancelado sólo
     se puede reabrir (y eso vuelve a descontar el stock). */
  var TRANSICIONES = {
    nuevo: ["preparando", "incidencia", "cancelado"],
    preparando: ["enviado", "incidencia", "cancelado"],
    enviado: ["entregado", "incidencia", "cancelado"],
    entregado: ["incidencia"],
    incidencia: ["preparando", "enviado", "entregado", "cancelado"],
    cancelado: ["nuevo"]
  };

  /* Acciones que escriben en disco: llevan el testigo CSRF. */
  var ESCRIBEN = [
    "cambiar_estado", "cambiar_pago", "guardar_envio", "guardar_cliente",
    "anadir_nota", "estado_lote", "guardar_lote", "cambiar_password"
  ];

  var VISTAS = ["inicio", "pedidos", "clientes", "almacen", "ajustes"];
  var CON_RANGO = { inicio: true, pedidos: true, clientes: true };
  var TITULOS = {
    inicio: "Inicio",
    pedidos: "Pedidos",
    clientes: "Clientes",
    almacen: "Almacén",
    ajustes: "Ajustes"
  };

  /* -------------------------------------------------------------
     Ayudas
     ------------------------------------------------------------- */
  var $ = function (sel, scope) { return (scope || document).querySelector(sel); };
  var $$ = function (sel, scope) { return Array.prototype.slice.call((scope || document).querySelectorAll(sel)); };
  var tiene = function (o, k) { return Object.prototype.hasOwnProperty.call(o, k); };
  var escHTML = function (s) {
    return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
  };
  function safe(fn, name) { try { fn(); } catch (e) { console.warn("[" + name + "]", e); } }

  /* Dinero a la española, igual que en la tienda: punto de millar
     siempre y coma decimal sólo si hay céntimos. */
  function eur(n) {
    n = Math.round((Number(n) || 0) * 100) / 100;
    var neg = n < 0; n = Math.abs(n);
    var entero = Math.floor(n), cents = Math.round((n - entero) * 100);
    var s = String(entero).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    if (cents) s += "," + (cents < 10 ? "0" : "") + cents;
    return (neg ? "−" : "") + s + " €";
  }
  function num(n) {
    return String(Math.round(Number(n) || 0)).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
  function pctTexto(n) {
    n = Math.round((Number(n) || 0) * 10) / 10;
    return String(Math.abs(n)).replace(".", ",") + " %";
  }
  function retardo(fn, ms) {
    var t = null;
    return function () {
      var args = arguments, self = this;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(self, args); }, ms);
    };
  }
  function ocupado(el, on) {
    if (!el) return;
    if (on) { el.classList.add("is-cargando"); el.disabled = true; }
    else { el.classList.remove("is-cargando"); el.disabled = false; }
  }
  function etiquetaEstado(k) { return tiene(ESTADOS, k) ? ESTADOS[k] : (k || "—"); }
  function etiquetaPago(k) { return tiene(PAGOS, k) ? PAGOS[k] : (k || "—"); }
  function etiquetaPagoEstado(k) { return tiene(PAGO_ESTADOS, k) ? PAGO_ESTADOS[k] : (k || "—"); }
  function badge(clave, texto) {
    return '<span class="badge badge--' + escHTML(clave) + '">' + escHTML(texto) + "</span>";
  }
  /* Las fotos del catálogo vienen con la ruta de la tienda («assets/…»)
     y el panel cuelga de /admin, así que hay que subir un nivel. */
  function foto(ruta) {
    var s = String(ruta || "");
    if (s === "") return "";
    if (/^(https?:)?\/\//.test(s) || s.charAt(0) === "/" || s.indexOf("../") === 0) return s;
    return "../" + s;
  }

  /* -------------------------------------------------------------
     Fechas: todo en AAAA-MM-DD y en hora local, igual que el servidor
     ------------------------------------------------------------- */
  function pad2(n) { return (n < 10 ? "0" : "") + n; }
  function isoDe(d) { return d.getFullYear() + "-" + pad2(d.getMonth() + 1) + "-" + pad2(d.getDate()); }
  function deISO(iso) {
    var p = String(iso).split("-");
    /* Al mediodía: así ningún cambio de hora mueve el día. */
    return new Date(Number(p[0]), Number(p[1]) - 1, Number(p[2]), 12, 0, 0);
  }
  function hoyISO() { return isoDe(new Date()); }
  function sumaDias(iso, n) {
    if (!iso) return "";
    var d = deISO(iso); d.setDate(d.getDate() + n); return isoDe(d);
  }
  function diasEntre(a, b) {
    if (!a || !b) return 0;
    return Math.round((deISO(b).getTime() - deISO(a).getTime()) / 86400000);
  }
  function esISO(s) { return /^\d{4}-\d{2}-\d{2}$/.test(String(s || "")); }

  function rangoPreset(nombre) {
    var hoy = hoyISO(), d = deISO(hoy), ayer, mesPasado;
    if (nombre === "hoy") return { desde: hoy, hasta: hoy };
    if (nombre === "ayer") { ayer = sumaDias(hoy, -1); return { desde: ayer, hasta: ayer }; }
    if (nombre === "7d") return { desde: sumaDias(hoy, -6), hasta: hoy };
    if (nombre === "30d") return { desde: sumaDias(hoy, -29), hasta: hoy };
    if (nombre === "mes") return { desde: isoDe(new Date(d.getFullYear(), d.getMonth(), 1)), hasta: hoy };
    if (nombre === "mes-1") {
      mesPasado = new Date(d.getFullYear(), d.getMonth() - 1, 1);
      return { desde: isoDe(mesPasado), hasta: isoDe(new Date(d.getFullYear(), d.getMonth(), 0)) };
    }
    if (nombre === "ano") return { desde: isoDe(new Date(d.getFullYear(), 0, 1)), hasta: hoy };
    if (nombre === "todo") return { desde: "", hasta: "" };
    return { desde: sumaDias(hoy, -29), hasta: hoy };
  }

  /* «2026-09-10T19:04:00+02:00» -> «10/09/2026». Se corta la cadena en
     vez de construir una fecha: el servidor ya la escribió en la hora
     de Madrid y así el día del panel es el mismo que el del filtro. */
  function fechaCorta(ts) {
    var s = String(ts || "");
    if (s.length < 10) return "—";
    return s.substring(8, 10) + "/" + s.substring(5, 7) + "/" + s.substring(0, 4);
  }
  function fechaHora(ts) {
    var s = String(ts || "");
    if (s.length < 10) return "—";
    var hora = (s.length >= 16 && s.charAt(10) === "T") ? " · " + s.substring(11, 16) : "";
    return fechaCorta(s) + hora;
  }
  function fechaDiaMes(iso) {
    var s = String(iso || "");
    if (s.length < 10) return "";
    return s.substring(8, 10) + "/" + s.substring(5, 7);
  }
  function fechaLarga(iso) {
    if (!esISO(iso)) return "";
    try { return deISO(iso).toLocaleDateString("es-ES", { day: "numeric", month: "long", year: "numeric" }); }
    catch (_) { return fechaCorta(iso); }
  }

  /* -------------------------------------------------------------
     Estado del panel (lo que se recuerda entre recargas)
     ------------------------------------------------------------- */
  var inicial = rangoPreset("30d");
  var S = {
    vista: "inicio",
    preset: "30d",
    desde: inicial.desde,
    hasta: inicial.hasta,
    estado: "",
    pago: "",
    q: "",
    qCliente: "",
    orden: "creado",
    direccion: "desc",
    pagina: 1,
    porPagina: 25,
    seleccion: {},
    csrf: "",
    marca: "Tornarem",
    lotes: {},
    vendidos: {},
    pedido: null,
    ultimoFoco: null,
    autenticado: false,
    setup: false
  };
  (TIENDA.lotes || []).forEach(function (l) { if (l && l.id) S.lotes[l.id] = l; });

  function guardarPreferencias() {
    try {
      localStorage.setItem(CLAVE, JSON.stringify({
        vista: S.vista, preset: S.preset, desde: S.desde, hasta: S.hasta,
        estado: S.estado, pago: S.pago, q: S.q, qCliente: S.qCliente,
        orden: S.orden, direccion: S.direccion, porPagina: S.porPagina
      }));
    } catch (_) { /* modo privado: se sigue trabajando sin recordar nada */ }
  }
  function cargarPreferencias() {
    var d = null;
    try { d = JSON.parse(localStorage.getItem(CLAVE) || "null"); } catch (_) { d = null; }
    if (!d || typeof d !== "object") return;
    if (VISTAS.indexOf(d.vista) >= 0) S.vista = d.vista;
    if (typeof d.preset === "string") S.preset = d.preset;
    if (esISO(d.desde) || d.desde === "") S.desde = d.desde;
    if (esISO(d.hasta) || d.hasta === "") S.hasta = d.hasta;
    if (tiene(ESTADOS, d.estado) || d.estado === "") S.estado = d.estado;
    if (tiene(PAGOS, d.pago) || d.pago === "") S.pago = d.pago;
    if (typeof d.q === "string") S.q = d.q;
    if (typeof d.qCliente === "string") S.qCliente = d.qCliente;
    if (["creado", "total", "nombre", "estado"].indexOf(d.orden) >= 0) S.orden = d.orden;
    if (d.direccion === "asc" || d.direccion === "desc") S.direccion = d.direccion;
    if ([25, 50, 100, 200].indexOf(Number(d.porPagina)) >= 0) S.porPagina = Number(d.porPagina);
    /* Si el preset guardado es de los que se mueven con el calendario,
       se recalcula: ayer no es el mismo día que cuando se guardó. */
    if (S.preset && S.preset !== "todo") {
      var r = rangoPreset(S.preset);
      S.desde = r.desde; S.hasta = r.hasta;
    }
  }

  /* El hash lleva la vista y los filtros para poder enlazar una
     pantalla concreta («mándame los cancelados de agosto»). */
  var hashPropio = false;
  function escribirHash() {
    var p = [];
    if (S.preset) p.push("preset=" + encodeURIComponent(S.preset));
    if (S.desde) p.push("desde=" + S.desde);
    if (S.hasta) p.push("hasta=" + S.hasta);
    if (S.vista === "pedidos") {
      if (S.estado) p.push("estado=" + encodeURIComponent(S.estado));
      if (S.pago) p.push("pago=" + encodeURIComponent(S.pago));
      if (S.q) p.push("q=" + encodeURIComponent(S.q));
      if (S.pagina > 1) p.push("pagina=" + S.pagina);
    }
    if (S.vista === "clientes" && S.qCliente) p.push("q=" + encodeURIComponent(S.qCliente));
    var nuevo = "#" + S.vista + (p.length ? "?" + p.join("&") : "");
    if (location.hash !== nuevo) {
      hashPropio = true;
      try { history.replaceState(null, "", nuevo); }
      catch (_) { location.hash = nuevo; }
      hashPropio = false;
    }
  }
  function leerHash() {
    var h = String(location.hash || "").replace(/^#/, "");
    if (!h) return false;
    var trozos = h.split("?");
    var vista = trozos[0];
    var p = {};
    if (trozos[1]) {
      trozos[1].split("&").forEach(function (kv) {
        if (!kv) return;
        var i = kv.indexOf("=");
        var k = i < 0 ? kv : kv.substring(0, i);
        var v = i < 0 ? "" : kv.substring(i + 1);
        try { p[decodeURIComponent(k)] = decodeURIComponent(v.replace(/\+/g, " ")); }
        catch (_) { p[k] = v; }
      });
    }
    if (VISTAS.indexOf(vista) >= 0) S.vista = vista;
    if (typeof p.preset === "string" && p.preset !== "") {
      S.preset = p.preset;
      var r = rangoPreset(p.preset);
      S.desde = r.desde; S.hasta = r.hasta;
    }
    if (esISO(p.desde)) { S.desde = p.desde; }
    if (esISO(p.hasta)) { S.hasta = p.hasta; }
    if (p.preset === "" || (typeof p.desde === "string" && !p.preset)) S.preset = "";
    if (S.vista === "pedidos") {
      if (typeof p.estado === "string") S.estado = tiene(ESTADOS, p.estado) ? p.estado : "";
      if (typeof p.pago === "string") S.pago = tiene(PAGOS, p.pago) ? p.pago : "";
      if (typeof p.q === "string") S.q = p.q;
      if (p.pagina) S.pagina = Math.max(1, parseInt(p.pagina, 10) || 1);
    }
    if (S.vista === "clientes" && typeof p.q === "string") S.qCliente = p.q;
    return true;
  }

  /* -------------------------------------------------------------
     Llamadas a la API
     ------------------------------------------------------------- */
  function api(accion, datos) {
    var cuerpo = { accion: accion }, k;
    if (datos) { for (k in datos) { if (tiene(datos, k)) cuerpo[k] = datos[k]; } }
    var cabeceras = { "Content-Type": "application/json", "Accept": "application/json" };
    if (ESCRIBEN.indexOf(accion) >= 0 && S.csrf) cabeceras["X-CSRF"] = S.csrf;

    return fetch("api.php", {
      method: "POST",
      headers: cabeceras,
      body: JSON.stringify(cuerpo),
      credentials: "same-origin"
    }).then(function (r) {
      return r.text().then(function (texto) {
        var d = null;
        try { d = JSON.parse(texto); } catch (_) { d = null; }
        if (d === null || typeof d !== "object") {
          throw new Error("El servidor no ha contestado en JSON (" + r.status + "). Comprueba que el hosting ejecuta PHP.");
        }
        if (r.status === 401 && d.sesion === false) {
          sesionCaducada();
          throw new Error(d.mensaje || "Sesión caducada.");
        }
        if (!d.ok) {
          var e = new Error(d.mensaje || "No se ha podido completar la operación.");
          e.codigo = r.status;
          e.datos = d;
          throw e;
        }
        return d;
      });
    }, function () {
      throw new Error("No hay conexión con el servidor. Revisa la red y vuelve a intentarlo.");
    });
  }

  function sesionCaducada() {
    S.autenticado = false;
    S.csrf = "";
    cerrarCajon();
    mostrarAcceso(false);
    var err = $("[data-acceso-error]");
    if (err) err.textContent = "La sesión ha caducado. Vuelve a entrar: no se ha perdido nada.";
  }

  /* -------------------------------------------------------------
     Avisos y confirmaciones
     ------------------------------------------------------------- */
  var avisoTimer = null;
  function aviso(texto, esError) {
    var el = $("[data-aviso]");
    if (!el) return;
    el.textContent = texto;
    el.classList.toggle("is-error", !!esError);
    el.hidden = false;
    el.classList.add("is-on");
    clearTimeout(avisoTimer);
    avisoTimer = setTimeout(function () {
      el.classList.remove("is-on");
      el.hidden = true;
    }, esError ? 7000 : 3600);
  }

  function confirmar(texto) {
    return new Promise(function (resolver) {
      var dlg = $("[data-confirmar]");
      if (!dlg || typeof dlg.showModal !== "function") { resolver(window.confirm(texto)); return; }
      var p = $("[data-confirmar-texto]", dlg);
      if (p) p.textContent = texto;
      var si = $("[data-confirmar-si]", dlg), no = $("[data-confirmar-no]", dlg);
      var fin = function (v) {
        dlg.onclose = null;
        try { if (dlg.open) dlg.close(); } catch (_) { dlg.removeAttribute("open"); }
        resolver(v);
      };
      if (si) si.onclick = function () { fin(true); };
      if (no) no.onclick = function () { fin(false); };
      dlg.onclose = function () { resolver(false); };
      dlg.showModal();
      if (no) no.focus();
    });
  }

  function fallo(e) {
    aviso((e && e.message) ? e.message : "Algo ha fallado.", true);
  }

  /* -------------------------------------------------------------
     Acceso: entrar o crear la contraseña la primera vez
     ------------------------------------------------------------- */
  function mostrarAcceso(setup) {
    S.setup = !!setup;
    var acceso = $("[data-acceso]"), app = $("[data-app]");
    if (acceso) acceso.hidden = false;
    if (app) app.hidden = true;
    var titulo = $("[data-acceso-titulo]");
    var boton = $("[data-acceso-enviar]");
    var repetir = $("[data-acceso-repetir]");
    if (titulo) titulo.textContent = setup ? "Crear la contraseña del panel" : "Entrar al panel";
    if (boton) boton.textContent = setup ? "Crear contraseña y entrar" : "Entrar";
    if (repetir) repetir.hidden = !setup;
    var p1 = $("#acceso-password");
    if (p1) {
      p1.setAttribute("autocomplete", setup ? "new-password" : "current-password");
      p1.value = "";
      p1.focus();
    }
    var p2 = $("#acceso-password2");
    if (p2) p2.value = "";
  }

  function mostrarApp() {
    var acceso = $("[data-acceso]"), app = $("[data-app]");
    if (acceso) acceso.hidden = true;
    if (app) app.hidden = false;
    S.autenticado = true;
  }

  function initAcceso() {
    var form = $("[data-form-acceso]");
    if (!form) return;
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var boton = $("[data-acceso-enviar]");
      var err = $("[data-acceso-error]");
      var p1 = $("#acceso-password"), p2 = $("#acceso-password2");
      var password = p1 ? String(p1.value) : "";
      if (err) err.textContent = "";

      if (S.setup) {
        if (password.length < 8) { if (err) err.textContent = "La contraseña necesita ocho caracteres como mínimo."; return; }
        if (!p2 || String(p2.value) !== password) { if (err) err.textContent = "Las dos contraseñas no coinciden."; return; }
      } else if (password === "") {
        if (err) err.textContent = "Escribe la contraseña.";
        return;
      }

      ocupado(boton, true);
      api(S.setup ? "crear_admin" : "entrar", { password: password })
        .then(function (d) {
          ocupado(boton, false);
          S.csrf = d.csrf || "";
          if (p1) p1.value = "";
          if (p2) p2.value = "";
          mostrarApp();
          entrarEnElPanel();
        })
        .catch(function (e) {
          ocupado(boton, false);
          if (err) err.textContent = e.message || "No se ha podido entrar.";
          if (e.datos && e.datos.setup_pendiente) mostrarAcceso(true);
          if (p1) { p1.value = ""; p1.focus(); }
        });
    });
  }

  function initSalir() {
    var b = $("[data-salir]");
    if (!b) return;
    b.addEventListener("click", function () {
      ocupado(b, true);
      api("salir").then(function () {
        ocupado(b, false);
        S.autenticado = false;
        S.csrf = "";
        cerrarCajon();
        /* Un testigo nuevo para el formulario de acceso. */
        api("estado_sesion").then(function (d) {
          S.csrf = d.csrf || "";
          mostrarAcceso(!!d.setup_pendiente);
        }).catch(function () { mostrarAcceso(false); });
      }).catch(function (e) { ocupado(b, false); fallo(e); });
    });
  }

  /* -------------------------------------------------------------
     Navegación entre vistas
     ------------------------------------------------------------- */
  function ir(vista, recargar) {
    if (VISTAS.indexOf(vista) < 0) vista = "inicio";
    var cambia = (vista !== S.vista);
    S.vista = vista;
    if (cambia) S.seleccion = {};

    $$("[data-vista]").forEach(function (sec) {
      sec.hidden = (sec.getAttribute("data-vista") !== vista);
    });
    $$(".lado-link").forEach(function (a) {
      var suya = (a.getAttribute("data-ir") === vista);
      a.classList.toggle("is-activa", suya);
      if (suya) a.setAttribute("aria-current", "page"); else a.removeAttribute("aria-current");
    });
    var titulo = $("[data-titulo]");
    if (titulo) titulo.textContent = TITULOS[vista] || "Panel";
    var rango = $("[data-rango]");
    if (rango) rango.hidden = !CON_RANGO[vista];
    pintarAcciones();
    pintarRango();
    subtitulo("");
    guardarPreferencias();
    escribirHash();
    if (cambia || recargar !== false) cargarVista();
  }

  function subtitulo(texto) {
    var el = $("[data-subtitulo]");
    if (el) el.textContent = texto || "";
  }

  function pintarAcciones() {
    var el = $("[data-acciones]");
    if (!el) return;
    var h = "";
    if (S.vista === "pedidos") {
      h += '<button class="btn btn-line btn-mini" type="button" data-exportar>Exportar CSV</button>';
    }
    if (S.vista !== "ajustes") {
      h += '<button class="btn btn-line btn-mini" type="button" data-recargar>Actualizar</button>';
    }
    el.innerHTML = h;
  }

  function cargarVista() {
    if (!S.autenticado) return null;
    if (S.vista === "inicio") return cargarInicio();
    if (S.vista === "pedidos") return cargarPedidos();
    if (S.vista === "clientes") return cargarClientes();
    if (S.vista === "almacen") return cargarAlmacen();
    if (S.vista === "ajustes") return cargarAjustes();
    return null;
  }

  function initNavegacion() {
    document.addEventListener("click", function (e) {
      var a = e.target.closest("[data-ir]");
      if (a) { e.preventDefault(); ir(a.getAttribute("data-ir")); return; }
      var rec = e.target.closest("[data-recargar]");
      if (rec) {
        ocupado(rec, true);
        var pendiente = cargarVista();
        var soltar = function () { ocupado(rec, false); };
        if (pendiente && pendiente.then) pendiente.then(soltar, soltar); else soltar();
        return;
      }
      var exp = e.target.closest("[data-exportar]");
      if (exp) { location.href = urlExportar(); aviso("Descargando el CSV de los pedidos del periodo."); }
    });
    window.addEventListener("hashchange", function () {
      if (hashPropio) return;
      if (leerHash()) {
        pintarFiltros();
        ir(S.vista, true);
      }
    });
  }

  function urlExportar() {
    var p = ["accion=exportar"];
    if (S.desde) p.push("desde=" + encodeURIComponent(S.desde));
    if (S.hasta) p.push("hasta=" + encodeURIComponent(S.hasta));
    if (S.estado) p.push("estado=" + encodeURIComponent(S.estado));
    if (S.pago) p.push("pago=" + encodeURIComponent(S.pago));
    if (S.q) p.push("q=" + encodeURIComponent(S.q));
    return "api.php?" + p.join("&");
  }

  /* -------------------------------------------------------------
     Selector de rango de fechas
     ------------------------------------------------------------- */
  function etiquetaRango() {
    if (!S.desde && !S.hasta) return "Todo el histórico";
    if (S.desde && S.hasta && S.desde === S.hasta) return fechaLarga(S.desde);
    if (S.desde && S.hasta) {
      var dias = diasEntre(S.desde, S.hasta) + 1;
      return fechaCorta(S.desde) + " → " + fechaCorta(S.hasta) + " · " + dias + (dias === 1 ? " día" : " días");
    }
    if (S.desde) return "Desde el " + fechaCorta(S.desde);
    return "Hasta el " + fechaCorta(S.hasta);
  }

  function pintarRango() {
    var desde = $("[data-desde]"), hasta = $("[data-hasta]");
    if (desde) desde.value = S.desde || "";
    if (hasta) hasta.value = S.hasta || "";
    $$("[data-preset]").forEach(function (b) {
      b.classList.toggle("is-activo", b.getAttribute("data-preset") === S.preset);
      b.setAttribute("aria-pressed", b.getAttribute("data-preset") === S.preset ? "true" : "false");
    });
    var et = $("[data-rango-etiqueta]");
    if (et) et.textContent = etiquetaRango();
    /* Sin fechas no hay nada que desplazar. */
    var sinRango = (!S.desde || !S.hasta);
    var prev = $("[data-rango-prev]"), next = $("[data-rango-next]");
    if (prev) prev.disabled = sinRango;
    if (next) next.disabled = sinRango;
  }

  function aplicarRango(preset, desde, hasta) {
    S.preset = preset || "";
    S.desde = desde || "";
    S.hasta = hasta || "";
    S.pagina = 1;
    pintarRango();
    guardarPreferencias();
    escribirHash();
    cargarVista();
  }

  function initRango() {
    $$("[data-preset]").forEach(function (b) {
      b.addEventListener("click", function () {
        var nombre = b.getAttribute("data-preset");
        var r = rangoPreset(nombre);
        aplicarRango(nombre, r.desde, r.hasta);
      });
    });

    var aplicar = $("[data-rango-aplicar]");
    if (aplicar) {
      aplicar.addEventListener("click", function () {
        var d = $("[data-desde]"), h = $("[data-hasta]");
        var desde = d ? String(d.value || "") : "";
        var hasta = h ? String(h.value || "") : "";
        if (desde && !esISO(desde)) { aviso("La fecha de inicio no es válida.", true); return; }
        if (hasta && !esISO(hasta)) { aviso("La fecha de fin no es válida.", true); return; }
        if (desde && hasta && desde > hasta) {
          var t = desde; desde = hasta; hasta = t;
          aviso("Las fechas estaban del revés: se han cambiado.");
        }
        /* Fechas escritas a mano: ya no hay atajo marcado. */
        aplicarRango("", desde, hasta);
      });
    }
    /* Enter en cualquiera de los dos campos aplica, como el botón. */
    $$("[data-desde], [data-hasta]").forEach(function (i) {
      i.addEventListener("keydown", function (e) {
        if (e.key === "Enter") { e.preventDefault(); if (aplicar) aplicar.click(); }
      });
    });

    var mover = function (signo) {
      if (!S.desde || !S.hasta) return;
      var largo = diasEntre(S.desde, S.hasta) + 1;
      aplicarRango("", sumaDias(S.desde, signo * largo), sumaDias(S.hasta, signo * largo));
    };
    var prev = $("[data-rango-prev]"), next = $("[data-rango-next]");
    if (prev) prev.addEventListener("click", function () { mover(-1); });
    if (next) next.addEventListener("click", function () { mover(1); });
  }

  /* -------------------------------------------------------------
     INICIO: KPI, gráfico, pendientes, stock bajo y últimos pedidos
     ------------------------------------------------------------- */
  function cargarInicio() {
    var sec = $('[data-vista="inicio"]');
    if (sec) sec.classList.add("is-cargando");
    return Promise.all([
      api("resumen", { desde: S.desde, hasta: S.hasta }),
      api("pedidos", {
        desde: S.desde, hasta: S.hasta, orden: "creado", direccion: "desc",
        pagina: 1, por_pagina: 8
      })
    ]).then(function (res) {
      if (sec) sec.classList.remove("is-cargando");
      var r = res[0].resumen || {};
      pintarKPIs(r);
      pintarGrafico(r);
      pintarPendientes(r.pendientes || []);
      pintarStockBajo(r.stock_bajo || []);
      pintarBarras(r);
      pintarUltimos(res[1].pedidos || []);
      subtitulo(num(r.pedidos) + (Number(r.pedidos) === 1 ? " pedido" : " pedidos") + " · " + eur(r.ventas) + " · " + etiquetaRango());
    }).catch(function (e) {
      if (sec) sec.classList.remove("is-cargando");
      fallo(e);
    });
  }

  function pintaDelta(clave, valor, comparable, texto) {
    var el = $('[data-kpi="' + clave + '"]');
    if (!el || !el.parentNode) return;
    var d = el.parentNode.querySelector(".kpi-delta");
    if (!d) return;
    d.classList.remove("is-sube", "is-baja");
    if (!comparable) { d.textContent = texto || "Sin periodo anterior con el que comparar"; return; }
    var n = Number(valor) || 0;
    if (n > 0) { d.classList.add("is-sube"); d.textContent = "▲ " + pctTexto(n) + " que el periodo anterior"; }
    else if (n < 0) { d.classList.add("is-baja"); d.textContent = "▼ " + pctTexto(n) + " que el periodo anterior"; }
    else { d.textContent = "Igual que el periodo anterior"; }
  }

  function pintarKPIs(r) {
    var v = r.variacion || {};
    var ant = r.anterior || {};
    var comparable = !!r.comparable;
    var poner = function (clave, texto) {
      var el = $('[data-kpi="' + clave + '"]');
      if (el) el.textContent = texto;
    };
    poner("ventas", eur(r.ventas));
    poner("pedidos", num(r.pedidos));
    poner("ticket", eur(r.ticket_medio));
    poner("unidades", num(r.unidades));

    pintaDelta("ventas", v.ventas, comparable);
    pintaDelta("pedidos", v.pedidos, comparable);

    /* El ticket medio anterior se saca de las dos cifras que ya envía
       el servidor: no hace falta otra consulta. */
    var ticketAntes = (Number(ant.pedidos) > 0) ? (Number(ant.ventas) / Number(ant.pedidos)) : 0;
    var ticketAhora = Number(r.ticket_medio) || 0;
    var varTicket = 0;
    if (ticketAntes > 0) varTicket = ((ticketAhora - ticketAntes) / ticketAntes) * 100;
    else if (ticketAhora > 0) varTicket = 100;
    pintaDelta("ticket", varTicket, comparable && Number(ant.pedidos) > 0, "Sin pedidos en el periodo anterior");

    var unidades = Number(r.unidades) || 0;
    var pedidos = Number(r.pedidos) || 0;
    var porPedido = pedidos > 0 ? Math.round((unidades / pedidos) * 10) / 10 : 0;
    pintaDelta("unidades", 0, false, pedidos > 0 ? String(porPedido).replace(".", ",") + " lotes por pedido" : "");
  }

  /* Gráfico de barras dibujado a mano: sin librerías, sin peticiones y
     con etiquetas que se leen con lector de pantalla. */
  var SVGNS = "http://www.w3.org/2000/svg";
  function svgEl(nombre, attrs) {
    var el = document.createElementNS(SVGNS, nombre), k;
    if (attrs) { for (k in attrs) { if (tiene(attrs, k)) el.setAttribute(k, String(attrs[k])); } }
    return el;
  }

  function pintarGrafico(r) {
    var svg = $("[data-grafico]");
    var vacio = $(".grafico-vacio");
    if (!svg) return;
    while (svg.firstChild) svg.removeChild(svg.firstChild);

    var serie = (r.serie && r.serie.length) ? r.serie : [];
    var maximo = 0;
    serie.forEach(function (p) { var v = Number(p.ventas) || 0; if (v > maximo) maximo = v; });
    var hayDatos = serie.length > 0 && maximo > 0;

    if (vacio) vacio.hidden = hayDatos;
    /* En un <svg> la propiedad .hidden no existe: se pone el atributo. */
    if (hayDatos) svg.removeAttribute("hidden"); else svg.setAttribute("hidden", "");
    if (!hayDatos) {
      svg.setAttribute("aria-label", "No hay ventas en el periodo seleccionado.");
      return;
    }

    var W = 720, H = 220;
    var izq = 62, der = 14, arr = 18, aba = 34;
    var ancho = W - izq - der, alto = H - arr - aba;
    var n = serie.length;
    var paso = ancho / n;
    var grosor = Math.max(2, Math.min(46, paso - 3));
    var porSemana = (r.agrupado === "semana");

    var titulo = svgEl("title", {});
    titulo.textContent = "Ventas por " + (porSemana ? "semana" : "día") + ": " + eur(r.ventas) + " en " + n + (porSemana ? " semanas" : " días");
    svg.appendChild(titulo);
    svg.setAttribute("aria-label", titulo.textContent + ". " + serie.map(function (p) {
      return fechaDiaMes(p.fecha) + " " + eur(p.ventas);
    }).join(", "));

    /* Tres líneas de referencia con su importe a la izquierda. */
    [0, 0.5, 1].forEach(function (f) {
      var y = arr + alto * (1 - f);
      var linea = svgEl("line", {
        x1: izq, y1: y, x2: W - der, y2: y,
        stroke: (f === 0 ? "#111111" : "#dcdad3"), "stroke-width": 1
      });
      svg.appendChild(linea);
      var t = svgEl("text", { x: izq - 8, y: y + 4, "text-anchor": "end", "font-size": 11, fill: "#6a6862" });
      t.textContent = eur(maximo * f);
      svg.appendChild(t);
    });

    /* Etiquetas del eje: como mucho seis, para que se lean. */
    var cada = Math.max(1, Math.ceil(n / 6));

    serie.forEach(function (p, i) {
      var v = Number(p.ventas) || 0;
      var h = maximo > 0 ? (alto * v / maximo) : 0;
      if (v > 0 && h < 2) h = 2;
      var x = izq + paso * i + (paso - grosor) / 2;
      var y = arr + alto - h;
      var barra = svgEl("rect", {
        x: Math.round(x * 10) / 10, y: Math.round(y * 10) / 10,
        width: Math.round(grosor * 10) / 10, height: Math.round(h * 10) / 10,
        fill: v > 0 ? "#ff4d00" : "#e4d0a9"
      });
      var tb = svgEl("title", {});
      tb.textContent = fechaCorta(p.fecha) + " · " + num(p.pedidos) + (Number(p.pedidos) === 1 ? " pedido" : " pedidos") + " · " + eur(v);
      barra.appendChild(tb);
      svg.appendChild(barra);

      if (i % cada === 0 || i === n - 1) {
        var t = svgEl("text", {
          x: izq + paso * i + paso / 2, y: arr + alto + 18,
          "text-anchor": "middle", "font-size": 11, fill: "#6a6862"
        });
        t.textContent = fechaDiaMes(p.fecha);
        svg.appendChild(t);
      }
    });
  }

  function pintarPendientes(lista) {
    var ul = $("[data-pendientes]");
    if (!ul) return;
    if (!lista.length) {
      ul.innerHTML = '<li class="es-vacia">No queda ningún pedido por preparar.</li>';
      return;
    }
    ul.innerHTML = lista.slice(0, 12).map(function (l) {
      return "<li>" +
        '<a href="#pedidos" data-abrir="' + escHTML(l.numero) + '">' +
          "<b>" + escHTML(l.numero) + "</b>" +
          "<span>" + escHTML(l.nombre) + " · " + escHTML(fechaCorta(l.creado)) + " · " + escHTML(eur(l.total)) + "</span>" +
          badge(l.estado, etiquetaEstado(l.estado)) +
        "</a></li>";
    }).join("");
  }

  function pintarStockBajo(lista) {
    var ul = $("[data-stock-bajo]");
    if (!ul) return;
    if (!lista.length) {
      ul.innerHTML = '<li class="es-vacia">Ningún lote por debajo de tres unidades.</li>';
      return;
    }
    ul.innerHTML = lista.map(function (l) {
      var texto = l.stock === 0 ? "Agotado" : (l.stock === 1 ? "Queda 1" : "Quedan " + l.stock);
      if (!l.activo) texto += " · fuera de la tienda";
      return "<li>" +
        '<a href="#almacen" data-ir="almacen">' +
          "<span>" + escHTML(l.nombre) + "</span>" +
          '<b class="' + (l.stock <= 1 ? "is-baja is-bajo" : "") + '">' + escHTML(texto) + "</b>" +
        "</a></li>";
    }).join("");
  }

  function pintarBarras(r) {
    var pagos = $("[data-por-pago]");
    var estados = $("[data-por-estado]");
    var filas = function (lista, contenedor) {
      if (!contenedor) return;
      var max = 0;
      lista.forEach(function (x) { if (Number(x.total) > max) max = Number(x.total); });
      var conDatos = lista.filter(function (x) { return Number(x.pedidos) > 0; });
      if (!conDatos.length) { contenedor.innerHTML = "<p>No hay pedidos en este periodo.</p>"; return; }
      /* El color va en línea porque lo decide el servidor (cada estado
         tiene el suyo); el resto del aspecto lo pone admin.css. */
      contenedor.innerHTML = conDatos.map(function (x) {
        var ancho = max > 0 ? Math.max(2, Math.round(Number(x.total) / max * 100)) : 0;
        return "<div>" +
          "<span>" + escHTML(x.etiqueta) + "</span>" +
          '<i class="pista"><span style="width:' + ancho + "%;background:" + escHTML(x.color || "#ff4d00") + '"></span></i>' +
          "<b>" + escHTML(num(x.pedidos)) + " · " + escHTML(eur(x.total)) + "</b>" +
          "</div>";
      }).join("");
    };
    var listaPagos = [];
    var pp = r.por_pago || {};
    Object.keys(pp).forEach(function (k) {
      var x = pp[k];
      listaPagos.push({ etiqueta: x.etiqueta || etiquetaPago(k), pedidos: x.pedidos, total: x.total, color: k === "tarjeta" ? "#111111" : "#ff4d00" });
    });
    filas(listaPagos, pagos);

    var listaEstados = [];
    var pe = r.por_estado || {};
    Object.keys(pe).forEach(function (k) {
      var x = pe[k];
      listaEstados.push({ etiqueta: x.etiqueta || etiquetaEstado(k), pedidos: x.pedidos, total: x.total, color: x.color });
    });
    filas(listaEstados, estados);
  }

  function pintarUltimos(lista) {
    var tabla = $("[data-ultimos]");
    if (!tabla) return;
    var tbody = tabla.querySelector("tbody");
    if (!tbody) return;
    if (!lista.length) {
      tbody.innerHTML = '<tr><td colspan="5">Todavía no hay pedidos en este periodo.</td></tr>';
      return;
    }
    tbody.innerHTML = lista.map(function (l) {
      return '<tr data-abrir="' + escHTML(l.numero) + '">' +
        "<td>" + escHTML(l.numero) + "</td>" +
        "<td>" + escHTML(fechaHora(l.creado)) + "</td>" +
        "<td>" + escHTML(l.nombre) + "</td>" +
        "<td>" + escHTML(eur(l.total)) + "</td>" +
        "<td>" + badge(l.estado, etiquetaEstado(l.estado)) + "</td>" +
        "</tr>";
    }).join("");
  }

  /* -------------------------------------------------------------
     PEDIDOS
     ------------------------------------------------------------- */
  function pintarFiltros() {
    $$("[data-estado]").forEach(function (b) {
      if (b.tagName !== "BUTTON") return;
      b.classList.toggle("is-activo", (b.getAttribute("data-estado") || "") === S.estado);
      b.setAttribute("aria-pressed", (b.getAttribute("data-estado") || "") === S.estado ? "true" : "false");
    });
    var pago = $("[data-pago]");
    if (pago) pago.value = S.pago;
    var buscar = $("[data-buscar]");
    if (buscar && buscar.value !== S.q) buscar.value = S.q;
    var buscarC = $("[data-buscar-clientes]");
    if (buscarC && buscarC.value !== S.qCliente) buscarC.value = S.qCliente;
    var pp = $("[data-por-pagina]");
    if (pp) pp.value = String(S.porPagina);
    $$("[data-orden]").forEach(function (th) {
      var suyo = th.getAttribute("data-orden") === S.orden;
      th.setAttribute("aria-sort", suyo ? (S.direccion === "asc" ? "ascending" : "descending") : "none");
      th.classList.toggle("is-activo", suyo);
    });
  }

  function cargarPedidos() {
    var sec = $('[data-vista="pedidos"]');
    if (sec) sec.classList.add("is-cargando");
    pintarFiltros();
    return api("pedidos", {
      desde: S.desde, hasta: S.hasta, estado: S.estado, pago: S.pago, q: S.q,
      orden: S.orden, direccion: S.direccion, pagina: S.pagina, por_pagina: S.porPagina
    }).then(function (d) {
      if (sec) sec.classList.remove("is-cargando");
      S.pagina = d.pagina || 1;
      pintarTablaPedidos(d);
      subtitulo(num(d.total) + (d.total === 1 ? " pedido" : " pedidos") + " · " + eur(d.suma) + " · " + num(d.unidades) + " uds · " + etiquetaRango());
      escribirHash();
    }).catch(function (e) {
      if (sec) sec.classList.remove("is-cargando");
      fallo(e);
    });
  }

  function nombreLotes(ids) {
    if (!ids || !ids.length) return "—";
    return ids.map(function (id) {
      var l = S.lotes[id];
      return (l && l.nombre) ? l.nombre : id;
    }).join(" · ");
  }

  function pintarTablaPedidos(d) {
    var tbody = $("[data-cuerpo-pedidos]");
    var vacio = $("[data-pedidos-vacio]");
    var tabla = $("[data-tabla-pedidos]");
    if (!tbody) return;
    var lista = d.pedidos || [];

    if (vacio) vacio.hidden = lista.length > 0;
    if (tabla && tabla.parentNode) tabla.parentNode.hidden = (lista.length === 0);

    tbody.innerHTML = lista.map(function (l) {
      var marcada = !!S.seleccion[l.numero];
      return '<tr data-numero="' + escHTML(l.numero) + '"' + (marcada ? ' class="is-marcada"' : "") + ">" +
        '<td><input type="checkbox" data-marcar="' + escHTML(l.numero) + '"' + (marcada ? " checked" : "") +
          ' aria-label="Seleccionar el pedido ' + escHTML(l.numero) + '"></td>' +
        "<td>" + escHTML(l.numero) + (l.es_pale ? " <small>palé</small>" : "") + "</td>" +
        "<td>" + escHTML(fechaHora(l.creado)) + "</td>" +
        "<td>" + escHTML(l.nombre) + "<br><small>" + escHTML(l.email) + "</small></td>" +
        "<td>" + escHTML(l.poblacion) + (l.provincia ? "<br><small>" + escHTML(l.provincia) + "</small>" : "") + "</td>" +
        "<td>" + escHTML(nombreLotes(l.lotes)) + "</td>" +
        "<td>" + escHTML(num(l.unidades)) + "</td>" +
        "<td>" + escHTML(eur(l.total)) + "</td>" +
        "<td>" + escHTML(etiquetaPago(l.pago)) + "<br>" + badge(l.pago_estado, etiquetaPagoEstado(l.pago_estado)) + "</td>" +
        "<td>" + badge(l.estado, etiquetaEstado(l.estado)) + "</td>" +
        "</tr>";
    }).join("");

    var info = $("[data-pagina-info]");
    if (info) {
      info.textContent = lista.length
        ? "Página " + num(d.pagina) + " de " + num(d.paginas) + " · " + num(d.total) + (d.total === 1 ? " pedido" : " pedidos")
        : "Sin resultados";
    }
    var prev = $("[data-pagina-prev]"), next = $("[data-pagina-next]");
    if (prev) prev.disabled = (d.pagina <= 1);
    if (next) next.disabled = (d.pagina >= d.paginas);

    var todos = $("[data-bulk-todos]");
    if (todos) {
      var marcados = lista.filter(function (l) { return !!S.seleccion[l.numero]; }).length;
      todos.checked = (lista.length > 0 && marcados === lista.length);
      todos.indeterminate = (marcados > 0 && marcados < lista.length);
    }
    pintarBulk();
  }

  function contarSeleccion() {
    var n = 0, k;
    for (k in S.seleccion) { if (tiene(S.seleccion, k) && S.seleccion[k]) n++; }
    return n;
  }
  function numerosSeleccion() {
    var out = [], k;
    for (k in S.seleccion) { if (tiene(S.seleccion, k) && S.seleccion[k]) out.push(k); }
    return out;
  }
  function pintarBulk() {
    var barra = $("[data-bulk]");
    if (!barra) return;
    var n = contarSeleccion();
    barra.hidden = (n === 0);
    var et = $("[data-bulk-num]");
    if (et) et.textContent = n + (n === 1 ? " pedido seleccionado" : " pedidos seleccionados");
  }

  function initPedidos() {
    /* Chips de estado */
    $$(".chips [data-estado]").forEach(function (b) {
      b.addEventListener("click", function () {
        S.estado = b.getAttribute("data-estado") || "";
        S.pagina = 1;
        guardarPreferencias();
        cargarPedidos();
      });
    });

    var pago = $("[data-pago]");
    if (pago) {
      pago.addEventListener("change", function () {
        S.pago = tiene(PAGOS, pago.value) ? pago.value : "";
        S.pagina = 1;
        guardarPreferencias();
        cargarPedidos();
      });
    }

    var buscar = $("[data-buscar]");
    if (buscar) {
      var buscarYa = retardo(function () {
        S.q = String(buscar.value || "").trim();
        S.pagina = 1;
        guardarPreferencias();
        cargarPedidos();
      }, 300);
      buscar.addEventListener("input", buscarYa);
      buscar.addEventListener("keydown", function (e) {
        if (e.key === "Enter") { e.preventDefault(); S.q = String(buscar.value || "").trim(); S.pagina = 1; cargarPedidos(); }
      });
    }
    var limpiar = $("[data-buscar-limpiar]");
    if (limpiar) {
      limpiar.addEventListener("click", function () {
        if (buscar) buscar.value = "";
        S.q = ""; S.pagina = 1;
        guardarPreferencias();
        cargarPedidos();
        if (buscar) buscar.focus();
      });
    }

    /* Orden por cabecera */
    $$("[data-orden]").forEach(function (th) {
      th.addEventListener("click", function () {
        var campo = th.getAttribute("data-orden");
        if (S.orden === campo) S.direccion = (S.direccion === "asc") ? "desc" : "asc";
        else { S.orden = campo; S.direccion = (campo === "nombre" || campo === "estado") ? "asc" : "desc"; }
        S.pagina = 1;
        guardarPreferencias();
        cargarPedidos();
      });
      th.setAttribute("tabindex", "0");
      th.addEventListener("keydown", function (e) {
        if (e.key === "Enter" || e.key === " ") { e.preventDefault(); th.click(); }
      });
    });

    /* Paginación */
    var prev = $("[data-pagina-prev]"), next = $("[data-pagina-next]"), pp = $("[data-por-pagina]");
    if (prev) prev.addEventListener("click", function () { if (S.pagina > 1) { S.pagina--; cargarPedidos(); } });
    if (next) next.addEventListener("click", function () { S.pagina++; cargarPedidos(); });
    if (pp) {
      pp.addEventListener("change", function () {
        S.porPagina = parseInt(pp.value, 10) || 25;
        S.pagina = 1;
        guardarPreferencias();
        cargarPedidos();
      });
    }

    /* Filas: marcar, abrir ficha */
    var tbody = $("[data-cuerpo-pedidos]");
    if (tbody) {
      tbody.addEventListener("change", function (e) {
        var c = e.target.closest("[data-marcar]");
        if (!c) return;
        var numero = c.getAttribute("data-marcar");
        if (c.checked) S.seleccion[numero] = true; else delete S.seleccion[numero];
        var fila = c.closest("tr");
        if (fila) fila.classList.toggle("is-marcada", !!c.checked);
        var todos = $("[data-bulk-todos]");
        if (todos) {
          var filas = $$("[data-marcar]", tbody);
          var marcados = filas.filter(function (x) { return x.checked; }).length;
          todos.checked = (filas.length > 0 && marcados === filas.length);
          todos.indeterminate = (marcados > 0 && marcados < filas.length);
        }
        pintarBulk();
      });
      tbody.addEventListener("click", function (e) {
        if (e.target.closest("input, a, label, button")) return;
        var fila = e.target.closest("[data-numero]");
        if (!fila) return;
        abrirPedido(fila.getAttribute("data-numero"));
      });
    }

    var todos = $("[data-bulk-todos]");
    if (todos) {
      todos.addEventListener("change", function () {
        $$("[data-marcar]").forEach(function (c) {
          c.checked = todos.checked;
          var numero = c.getAttribute("data-marcar");
          if (todos.checked) S.seleccion[numero] = true; else delete S.seleccion[numero];
          var fila = c.closest("tr");
          if (fila) fila.classList.toggle("is-marcada", !!todos.checked);
        });
        pintarBulk();
      });
    }

    var aplicar = $("[data-bulk-aplicar]");
    if (aplicar) {
      aplicar.addEventListener("click", function () {
        var sel = $("[data-bulk-estado]");
        var estado = sel ? sel.value : "";
        var numeros = numerosSeleccion();
        if (!estado) { aviso("Elige a qué estado pasan los pedidos.", true); return; }
        if (!numeros.length) { aviso("No hay ningún pedido seleccionado.", true); return; }
        var texto = "Vas a pasar " + numeros.length + (numeros.length === 1 ? " pedido" : " pedidos") + " a «" + etiquetaEstado(estado) + "».";
        if (estado === "cancelado") texto += " Las unidades vuelven al stock.";
        confirmar(texto + " ¿Seguimos?").then(function (si) {
          if (!si) return;
          ocupado(aplicar, true);
          api("estado_lote", { numeros: numeros, estado: estado, nota: "" })
            .then(function (d) {
              ocupado(aplicar, false);
              S.seleccion = {};
              if (sel) sel.value = "";
              var errores = d.errores || [];
              if (errores.length) {
                aviso(d.cambiados + " cambiados. " + errores.length + " sin cambiar: " + errores[0].numero + " — " + errores[0].mensaje, true);
              } else {
                aviso(d.cambiados + (d.cambiados === 1 ? " pedido pasado a «" : " pedidos pasados a «") + etiquetaEstado(estado) + "».");
              }
              cargarPedidos();
            })
            .catch(function (e) { ocupado(aplicar, false); fallo(e); });
        });
      });
    }

    /* Los enlaces de Inicio (pendientes y últimos pedidos) abren la ficha */
    document.addEventListener("click", function (e) {
      var a = e.target.closest("[data-abrir]");
      if (!a) return;
      e.preventDefault();
      abrirPedido(a.getAttribute("data-abrir"));
    });
  }

  /* -------------------------------------------------------------
     CAJÓN: ficha completa del pedido
     ------------------------------------------------------------- */
  function abrirPedido(numero) {
    if (!numero) return;
    api("pedido", { numero: numero }).then(function (d) {
      if (d.lotes) {
        Object.keys(d.lotes).forEach(function (id) { S.lotes[id] = d.lotes[id]; });
      }
      S.pedido = d.pedido;
      pintarCajon(d.pedido);
      mostrarCajon();
    }).catch(fallo);
  }

  function mostrarCajon() {
    var cajon = $("[data-cajon]"), fondo = $("[data-fondo]");
    if (!cajon) return;
    if (cajon.hidden) S.ultimoFoco = document.activeElement;
    cajon.hidden = false;
    if (fondo) fondo.hidden = false;
    document.body.style.overflow = "hidden";
    var cerrar = $("[data-cajon-cerrar]", cajon);
    if (cerrar) cerrar.focus();
  }

  function cerrarCajon() {
    var cajon = $("[data-cajon]"), fondo = $("[data-fondo]");
    if (!cajon || cajon.hidden) return;
    cajon.hidden = true;
    if (fondo) fondo.hidden = true;
    document.body.style.overflow = "";
    S.pedido = null;
    if (S.ultimoFoco && S.ultimoFoco.focus) {
      try { S.ultimoFoco.focus(); } catch (_) { /* el elemento ya no está */ }
    }
    S.ultimoFoco = null;
  }

  function enfocables(scope) {
    return $$('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex="0"]', scope)
      .filter(function (el) { return el.getClientRects().length > 0; });
  }

  function pintarCajon(p) {
    var cuerpo = $("[data-cajon-cuerpo]"), pie = $("[data-cajon-pie]");
    var titulo = $("[data-cajon-titulo]"), estado = $("[data-cajon-estado]");
    if (!cuerpo || !p) return;

    if (titulo) titulo.textContent = p.numero;
    if (estado) estado.innerHTML = badge(p.estado, etiquetaEstado(p.estado));

    var c = p.cliente || {};
    var envio = p.envio || {};
    var pago = p.pago || {};
    var importes = p.importes || {};
    var lineas = p.lineas || [];
    var historial = (p.historial || []).slice().reverse();
    var notas = (p.notas_internas || []).slice().reverse();

    /* admin.css estiliza «.campo» como envoltorio: dentro van la
       etiqueta y el control, atados por id para que se pueda pulsar. */
    var campo = function (clave, etiqueta, valor, tipo) {
      var id = "ficha-" + clave;
      return '<div class="campo"><label for="' + id + '">' + escHTML(etiqueta) + "</label>" +
        '<input id="' + id + '" type="' + (tipo || "text") + '" data-cliente="' + escHTML(clave) + '" value="' + escHTML(valor || "") + '"></div>';
    };
    /* Fila de botones: la hoja no conoce este bloque, así que el
       reparto va aquí para que no se peguen unos a otros. */
    var BOTONES = '<div class="x-botones" style="display:flex;flex-wrap:wrap;gap:.4rem">';
    var BLOQUE = '<section class="x-bloque" style="display:grid;gap:.6rem;align-content:start">';

    var html = "";

    /* ---- Líneas y totales ---- */
    html += BLOQUE + '<h3>Lotes del pedido</h3>' +
      '<div class="tabla-wrap"><table class="tabla">' +
      "<thead><tr><th scope=\"col\">Lote</th><th scope=\"col\">Uds</th><th scope=\"col\">Precio</th><th scope=\"col\">Total</th></tr></thead><tbody>" +
      lineas.map(function (ln) {
        var lote = S.lotes[ln.id] || {};
        var img = foto(lote.img);
        return "<tr><td>" +
          (img ? '<img class="x-mini" src="' + escHTML(img) + '" alt="" width="44" height="44" loading="lazy" style="object-fit:cover;vertical-align:middle;margin-right:.4rem"> ' : "") +
          "<b>" + escHTML(ln.nombre) + "</b><br><small>" + escHTML(ln.ref) + " · " + escHTML(ln.uds) + " uds · Grado " + escHTML(ln.grado) + "</small></td>" +
          "<td>" + escHTML(String(ln.qty)) + "</td>" +
          "<td>" + escHTML(eur(ln.precio)) + "</td>" +
          "<td>" + escHTML(eur(ln.total)) + "</td></tr>";
      }).join("") +
      "</tbody><tfoot>" +
      '<tr><td colspan="3">Subtotal</td><td>' + escHTML(eur(importes.subtotal)) + "</td></tr>" +
      (Number(importes.recargo) > 0 ? '<tr><td colspan="3">Recargo contrarreembolso</td><td>' + escHTML(eur(importes.recargo)) + "</td></tr>" : "") +
      '<tr><td colspan="3"><b>Total</b></td><td><b>' + escHTML(eur(importes.total)) + "</b></td></tr>" +
      "</tfoot></table></div></section>";

    /* ---- Estado ---- */
    var siguientes = TRANSICIONES[p.estado] || [];
    html += BLOQUE + '<h3>Estado del pedido</h3>' +
      "<p>Ahora mismo: " + badge(p.estado, etiquetaEstado(p.estado)) +
      (p.stock_descontado ? " · stock descontado" : " · stock devuelto") + "</p>" +
      '<div class="campo"><label for="ficha-nota-estado">Nota del cambio (opcional)</label>' +
      '<input id="ficha-nota-estado" type="text" data-ficha-estado-nota placeholder="Por ejemplo: hablado con el cliente"></div>' +
      BOTONES +
      (siguientes.length
        ? siguientes.map(function (e) {
            var clase = (e === "cancelado") ? "btn btn-peligro btn-mini" : "btn btn-line btn-mini";
            return '<button class="' + clase + '" type="button" data-ficha-estado="' + escHTML(e) + '">' + escHTML(etiquetaEstado(e)) + "</button>";
          }).join("")
        : "<span>Este pedido no admite más cambios de estado.</span>") +
      "</div></section>";

    /* ---- Cobro ---- */
    html += BLOQUE + '<h3>Cobro</h3>' +
      "<p>Forma de pago: <b>" + escHTML(etiquetaPago(pago.metodo)) + "</b>" +
      (Number(pago.recargo) > 0 ? " · recargo " + escHTML(eur(pago.recargo)) : "") + "</p>" +
      '<div class="campo"><label for="ficha-pago-estado">Estado del cobro</label><select id="ficha-pago-estado" data-ficha-pago-estado>' +
      Object.keys(PAGO_ESTADOS).map(function (k) {
        return '<option value="' + escHTML(k) + '"' + (pago.estado === k ? " selected" : "") + ">" + escHTML(PAGO_ESTADOS[k]) + "</option>";
      }).join("") +
      "</select></div>" +
      '<div class="campo"><label for="ficha-referencia">Referencia del cobro</label>' +
      '<input id="ficha-referencia" type="text" data-ficha-pago-referencia value="' + escHTML(pago.referencia || "") + '" placeholder="Número de operación o recibo"></div>' +
      BOTONES + '<button class="btn btn-solid btn-mini" type="button" data-ficha-guardar-pago>Guardar el cobro</button></div>' +
      "</section>";

    /* ---- Envío ---- */
    html += BLOQUE + '<h3>Envío</h3>' +
      "<p>" + (envio.es_pale ? "Palé: transporte especializado con llamada previa." : "Paquetería estándar.") +
      (envio.fecha_prevista ? " Entrega prevista: <b>" + escHTML(fechaLarga(envio.fecha_prevista)) + "</b>." : "") + "</p>" +
      '<div class="campo"><label for="ficha-transportista">Transportista</label>' +
      '<input id="ficha-transportista" type="text" data-ficha-transportista value="' + escHTML(envio.transportista || "") + '"></div>' +
      '<div class="campo"><label for="ficha-seguimiento">Número de seguimiento</label>' +
      '<input id="ficha-seguimiento" type="text" data-ficha-seguimiento value="' + escHTML(envio.seguimiento || "") + '"></div>' +
      BOTONES + '<button class="btn btn-solid btn-mini" type="button" data-ficha-guardar-envio>Guardar el envío</button></div>' +
      "</section>";

    /* ---- Cliente ---- */
    html += BLOQUE + '<h3>Cliente</h3>' +
      campo("nombre", "Nombre", c.nombre) +
      campo("email", "Correo", c.email, "email") +
      campo("telefono", "Teléfono", c.telefono, "tel") +
      campo("direccion", "Dirección", c.direccion) +
      campo("cp", "Código postal", c.cp) +
      campo("poblacion", "Población", c.poblacion) +
      campo("provincia", "Provincia", c.provincia) +
      campo("nif", "NIF/CIF", c.nif) +
      campo("empresa", "Empresa", c.empresa) +
      (c.notas ? "<p><b>Notas del cliente:</b> " + escHTML(c.notas) + "</p>" : "") +
      BOTONES + '<button class="btn btn-solid btn-mini" type="button" data-ficha-guardar-cliente>Guardar los datos</button></div>' +
      "</section>";

    /* ---- Notas internas ---- */
    html += BLOQUE + '<h3>Notas internas</h3>' +
      '<div class="campo"><label for="ficha-nota">Nueva nota</label>' +
      '<textarea id="ficha-nota" data-ficha-nota rows="3" placeholder="Lo que se habló por teléfono, un aviso para el almacén…"></textarea></div>' +
      BOTONES + '<button class="btn btn-solid btn-mini" type="button" data-ficha-guardar-nota>Añadir la nota</button></div>' +
      (notas.length
        ? '<ul class="lista">' + notas.map(function (n) {
            return "<li><span><b>" + escHTML(fechaHora(n.ts)) + "</b><span>" + escHTML(n.texto) + "</span><small>" + escHTML(n.autor) + "</small></span></li>";
          }).join("") + "</ul>"
        : "<p>Sin notas internas.</p>") +
      "</section>";

    /* ---- Historial ---- */
    html += BLOQUE + '<h3>Historial</h3>' +
      (historial.length
        ? '<ul class="lista">' + historial.map(function (h) {
            return "<li><span><b>" + escHTML(fechaHora(h.ts)) + "</b><span>" + escHTML(h.texto) + "</span><small>" + escHTML(h.autor) + "</small></span></li>";
          }).join("") + "</ul>"
        : "<p>Sin movimientos registrados.</p>") +
      "<p><small>Pedido creado el " + escHTML(fechaHora(p.creado)) + " · última modificación " + escHTML(fechaHora(p.actualizado)) + "</small></p>" +
      "</section>";

    cuerpo.innerHTML = html;
    cuerpo.scrollTop = 0;

    if (pie) {
      var asunto = "Tu pedido " + p.numero + " · Tornarem";
      var mail = c.email ? "mailto:" + encodeURIComponent(c.email) + "?subject=" + encodeURIComponent(asunto) : "";
      var tel = c.telefono ? "tel:" + String(c.telefono).replace(/[^\d+]/g, "") : "";
      pie.innerHTML =
        '<button class="btn btn-line btn-mini" type="button" data-ficha-copiar>Copiar la dirección</button>' +
        '<a class="btn btn-line btn-mini" href="albaran.php?numero=' + encodeURIComponent(p.numero) + '" target="_blank" rel="noopener">Albarán</a>' +
        (mail ? '<a class="btn btn-line btn-mini" href="' + escHTML(mail) + '">Escribir</a>' : "") +
        (tel ? '<a class="btn btn-line btn-mini" href="' + escHTML(tel) + '">Llamar</a>' : "");
    }
  }

  function direccionTexto(p) {
    var c = p.cliente || {};
    return [
      c.nombre || "",
      c.empresa || "",
      c.direccion || "",
      ((c.cp || "") + " " + (c.poblacion || "")).trim(),
      c.provincia || "",
      c.telefono ? "Tel. " + c.telefono : ""
    ].filter(function (x) { return String(x).trim() !== ""; }).join("\n");
  }

  function copiar(texto) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      return navigator.clipboard.writeText(texto);
    }
    return new Promise(function (resolver, rechazar) {
      var ta = document.createElement("textarea");
      ta.value = texto;
      ta.setAttribute("readonly", "");
      ta.style.position = "fixed";
      ta.style.top = "-1000px";
      document.body.appendChild(ta);
      ta.select();
      var ok = false;
      try { ok = document.execCommand("copy"); } catch (_) { ok = false; }
      document.body.removeChild(ta);
      if (ok) resolver(); else rechazar(new Error("El navegador no ha dejado copiar."));
    });
  }

  /* Tras cualquier cambio, el servidor devuelve la ficha entera: se
     vuelve a pintar y se refresca lo que hubiera debajo. */
  function trasCambio(pedido, texto) {
    S.pedido = pedido;
    pintarCajon(pedido);
    aviso(texto);
    if (S.vista === "pedidos") cargarPedidos();
    else if (S.vista === "inicio") cargarInicio();
    else if (S.vista === "clientes") cargarClientes();
  }

  function initCajon() {
    var cajon = $("[data-cajon]"), fondo = $("[data-fondo]");
    var cerrar = $("[data-cajon-cerrar]");
    if (cerrar) cerrar.addEventListener("click", cerrarCajon);
    if (fondo) fondo.addEventListener("click", cerrarCajon);
    document.addEventListener("keydown", function (e) {
      if (!cajon || cajon.hidden) return;
      if (e.key === "Escape") { e.preventDefault(); cerrarCajon(); return; }
      if (e.key !== "Tab") return;
      /* Foco atrapado dentro de la ficha mientras esté abierta. */
      var lista = enfocables(cajon);
      if (!lista.length) return;
      var primero = lista[0], ultimo = lista[lista.length - 1];
      if (e.shiftKey && document.activeElement === primero) { e.preventDefault(); ultimo.focus(); }
      else if (!e.shiftKey && document.activeElement === ultimo) { e.preventDefault(); primero.focus(); }
    });

    if (!cajon) return;
    cajon.addEventListener("click", function (e) {
      var p = S.pedido;
      if (!p) return;
      var b;

      b = e.target.closest("[data-ficha-estado]");
      if (b) {
        var nuevo = b.getAttribute("data-ficha-estado");
        var notaEl = $("[data-ficha-estado-nota]", cajon);
        var nota = notaEl ? String(notaEl.value || "") : "";
        var pregunta = "El pedido " + p.numero + " pasa a «" + etiquetaEstado(nuevo) + "».";
        if (nuevo === "cancelado") pregunta += " Las unidades vuelven al stock.";
        if (p.estado === "cancelado") pregunta += " Se vuelven a descontar las unidades del stock.";
        confirmar(pregunta + " ¿Seguimos?").then(function (si) {
          if (!si) return;
          ocupado(b, true);
          api("cambiar_estado", { numero: p.numero, estado: nuevo, nota: nota })
            .then(function (d) { ocupado(b, false); trasCambio(d.pedido, "Pedido en «" + etiquetaEstado(nuevo) + "»."); })
            .catch(function (err) { ocupado(b, false); fallo(err); });
        });
        return;
      }

      b = e.target.closest("[data-ficha-guardar-pago]");
      if (b) {
        var sel = $("[data-ficha-pago-estado]", cajon);
        var ref = $("[data-ficha-pago-referencia]", cajon);
        ocupado(b, true);
        api("cambiar_pago", {
          numero: p.numero,
          estado: sel ? sel.value : "pendiente",
          referencia: ref ? String(ref.value || "") : ""
        }).then(function (d) { ocupado(b, false); trasCambio(d.pedido, "Cobro guardado."); })
          .catch(function (err) { ocupado(b, false); fallo(err); });
        return;
      }

      b = e.target.closest("[data-ficha-guardar-envio]");
      if (b) {
        var tr = $("[data-ficha-transportista]", cajon);
        var sg = $("[data-ficha-seguimiento]", cajon);
        ocupado(b, true);
        api("guardar_envio", {
          numero: p.numero,
          transportista: tr ? String(tr.value || "") : "",
          seguimiento: sg ? String(sg.value || "") : ""
        }).then(function (d) { ocupado(b, false); trasCambio(d.pedido, "Envío guardado."); })
          .catch(function (err) { ocupado(b, false); fallo(err); });
        return;
      }

      b = e.target.closest("[data-ficha-guardar-cliente]");
      if (b) {
        var cliente = {};
        $$("[data-cliente]", cajon).forEach(function (i) {
          cliente[i.getAttribute("data-cliente")] = String(i.value || "").trim();
        });
        ocupado(b, true);
        api("guardar_cliente", { numero: p.numero, cliente: cliente })
          .then(function (d) { ocupado(b, false); trasCambio(d.pedido, "Datos del cliente guardados."); })
          .catch(function (err) { ocupado(b, false); fallo(err); });
        return;
      }

      b = e.target.closest("[data-ficha-guardar-nota]");
      if (b) {
        var ta = $("[data-ficha-nota]", cajon);
        var texto = ta ? String(ta.value || "").trim() : "";
        if (texto === "") { aviso("La nota está vacía.", true); if (ta) ta.focus(); return; }
        ocupado(b, true);
        api("anadir_nota", { numero: p.numero, texto: texto })
          .then(function (d) { ocupado(b, false); trasCambio(d.pedido, "Nota añadida."); })
          .catch(function (err) { ocupado(b, false); fallo(err); });
        return;
      }

      b = e.target.closest("[data-ficha-copiar]");
      if (b) {
        copiar(direccionTexto(p))
          .then(function () { aviso("Dirección copiada al portapapeles."); })
          .catch(function (err) { fallo(err); });
      }
    });
  }

  /* -------------------------------------------------------------
     CLIENTES
     ------------------------------------------------------------- */
  function cargarClientes() {
    var sec = $('[data-vista="clientes"]');
    if (sec) sec.classList.add("is-cargando");
    return api("clientes", { desde: S.desde, hasta: S.hasta, q: S.qCliente })
      .then(function (d) {
        if (sec) sec.classList.remove("is-cargando");
        pintarClientes(d.clientes || []);
        escribirHash();
      })
      .catch(function (e) {
        if (sec) sec.classList.remove("is-cargando");
        fallo(e);
      });
  }

  function pintarClientes(lista) {
    var tbody = $("[data-cuerpo-clientes]");
    var vacio = $("[data-clientes-vacio]");
    if (!tbody) return;
    if (vacio) vacio.hidden = lista.length > 0;
    var gastado = lista.reduce(function (s, c) { return s + (Number(c.gastado) || 0); }, 0);
    subtitulo(num(lista.length) + (lista.length === 1 ? " cliente" : " clientes") + " · " + eur(gastado) + " · " + etiquetaRango());

    tbody.innerHTML = lista.map(function (c) {
      return '<tr data-cliente-email="' + escHTML(c.email) + '">' +
        "<td>" + escHTML(c.nombre || "—") + "</td>" +
        "<td>" + (c.email ? '<a href="mailto:' + escHTML(c.email) + '">' + escHTML(c.email) + "</a>" : "—") + "</td>" +
        "<td>" + (c.telefono ? '<a href="tel:' + escHTML(String(c.telefono).replace(/[^\d+]/g, "")) + '">' + escHTML(c.telefono) + "</a>" : "—") + "</td>" +
        "<td>" + escHTML(c.poblacion || "—") + "</td>" +
        "<td>" + escHTML(c.provincia || "—") + "</td>" +
        "<td>" + escHTML(num(c.pedidos)) + (Number(c.cancelados) > 0 ? "<br><small>" + escHTML(num(c.cancelados)) + " cancelado(s)</small>" : "") + "</td>" +
        "<td>" + escHTML(eur(c.gastado)) + "</td>" +
        "<td>" + escHTML(fechaCorta(c.primero)) + "</td>" +
        "<td>" + escHTML(fechaCorta(c.ultimo)) + "</td>" +
        "</tr>";
    }).join("");
  }

  function initClientes() {
    var buscar = $("[data-buscar-clientes]");
    if (buscar) {
      var lanzar = retardo(function () {
        S.qCliente = String(buscar.value || "").trim();
        guardarPreferencias();
        cargarClientes();
      }, 300);
      buscar.addEventListener("input", lanzar);
      buscar.addEventListener("keydown", function (e) {
        if (e.key === "Enter") { e.preventDefault(); S.qCliente = String(buscar.value || "").trim(); cargarClientes(); }
      });
    }
    var tbody = $("[data-cuerpo-clientes]");
    if (tbody) {
      tbody.addEventListener("click", function (e) {
        if (e.target.closest("a")) return;
        var fila = e.target.closest("[data-cliente-email]");
        if (!fila) return;
        /* Ver todos sus pedidos: se pasa el correo al buscador de Pedidos. */
        S.q = fila.getAttribute("data-cliente-email") || "";
        S.estado = "";
        S.pago = "";
        S.pagina = 1;
        var b = $("[data-buscar]");
        if (b) b.value = S.q;
        guardarPreferencias();
        ir("pedidos");
      });
    }
  }

  /* -------------------------------------------------------------
     ALMACÉN
     ------------------------------------------------------------- */
  function cargarAlmacen() {
    var sec = $('[data-vista="almacen"]');
    if (sec) sec.classList.add("is-cargando");
    return api("catalogo").then(function (d) {
      if (sec) sec.classList.remove("is-cargando");
      S.lotes = d.lotes || {};
      S.vendidos = d.vendidos || {};
      pintarAlmacen();
    }).catch(function (e) {
      if (sec) sec.classList.remove("is-cargando");
      fallo(e);
    });
  }

  function pintarAlmacen() {
    var tbody = $("[data-cuerpo-almacen]");
    if (!tbody) return;
    var ids = Object.keys(S.lotes);
    if (!ids.length) {
      tbody.innerHTML = '<tr><td colspan="9">No se ha podido leer el catálogo.</td></tr>';
      return;
    }
    var unidades = 0, valor = 0;
    ids.forEach(function (id) {
      var l = S.lotes[id];
      unidades += Number(l.stock) || 0;
      valor += (Number(l.stock) || 0) * (Number(l.precio) || 0);
    });
    subtitulo(ids.length + " lotes · " + num(unidades) + " unidades en almacén · " + eur(valor) + " a precio de venta");

    tbody.innerHTML = ids.map(function (id) {
      var l = S.lotes[id];
      var vendidos = Number(S.vendidos[id]) || 0;
      var bajo = (Number(l.stock) <= 1);
      var img = foto(l.img);
      return '<tr data-lote="' + escHTML(id) + '">' +
        "<td>" + (img ? '<img class="x-mini" src="' + escHTML(img) + '" alt="" width="44" height="44" loading="lazy" style="object-fit:cover;vertical-align:middle;margin-right:.4rem"> ' : "") +
          "<b>" + escHTML(l.nombre) + "</b><br><small>" + escHTML(l.uds) + " uds · " + escHTML(l.formato) + "</small></td>" +
        "<td>" + escHTML(l.ref) + "</td>" +
        "<td>" + escHTML(l.grado) + "</td>" +
        "<td>" + escHTML(eur(l.pvp)) + "</td>" +
        '<td><input type="number" min="0" step="0.01" data-precio value="' + escHTML(String(l.precio)) + '" aria-label="Precio de ' + escHTML(l.nombre) + '"></td>' +
        '<td class="' + (bajo ? "is-bajo is-baja" : "") + '"><input type="number" min="0" step="1" data-stock' +
          (bajo ? ' class="is-bajo"' : "") + ' value="' + escHTML(String(l.stock)) + '" aria-label="Stock de ' + escHTML(l.nombre) + '"></td>' +
        "<td>" + escHTML(num(vendidos)) + "</td>" +
        '<td><label><input type="checkbox" data-activo' + (l.activo ? " checked" : "") + ' aria-label="Se vende ' + escHTML(l.nombre) + '"> Se vende</label></td>' +
        '<td><button class="btn btn-solid btn-mini" type="button" data-guardar-lote>Guardar</button></td>' +
        "</tr>";
    }).join("");
  }

  function initAlmacen() {
    var tbody = $("[data-cuerpo-almacen]");
    if (!tbody) return;
    tbody.addEventListener("click", function (e) {
      var b = e.target.closest("[data-guardar-lote]");
      if (!b) return;
      var fila = b.closest("[data-lote]");
      if (!fila) return;
      var id = fila.getAttribute("data-lote");
      var precioEl = $("[data-precio]", fila), stockEl = $("[data-stock]", fila), activoEl = $("[data-activo]", fila);
      var precio = precioEl ? String(precioEl.value).replace(",", ".") : "";
      var stock = stockEl ? String(stockEl.value) : "";
      if (precio === "" || isNaN(Number(precio)) || Number(precio) < 0) { aviso("El precio tiene que ser un número.", true); if (precioEl) precioEl.focus(); return; }
      if (stock === "" || isNaN(Number(stock)) || Number(stock) < 0) { aviso("El stock tiene que ser un número entero.", true); if (stockEl) stockEl.focus(); return; }

      ocupado(b, true);
      api("guardar_lote", {
        id: id,
        precio: Number(precio),
        stock: parseInt(stock, 10),
        activo: activoEl ? !!activoEl.checked : true
      }).then(function (d) {
        ocupado(b, false);
        S.lotes[id] = d.lote;
        var bajo = (Number(d.lote.stock) <= 1);
        var celdaStock = stockEl ? stockEl.parentNode : null;
        if (celdaStock) { celdaStock.classList.toggle("is-bajo", bajo); celdaStock.classList.toggle("is-baja", bajo); }
        if (stockEl) stockEl.classList.toggle("is-bajo", bajo);
        if (precioEl) precioEl.value = String(d.lote.precio);
        if (stockEl) stockEl.value = String(d.lote.stock);
        aviso(d.lote.nombre + ": " + eur(d.lote.precio) + " · " + d.lote.stock + " en stock · " + (d.lote.activo ? "a la venta" : "fuera de la tienda"));
      }).catch(function (err) { ocupado(b, false); fallo(err); });
    });
    /* Enter dentro de una casilla guarda esa fila. */
    tbody.addEventListener("keydown", function (e) {
      if (e.key !== "Enter") return;
      var fila = e.target.closest("[data-lote]");
      if (!fila) return;
      e.preventDefault();
      var b = $("[data-guardar-lote]", fila);
      if (b) b.click();
    });
  }

  /* -------------------------------------------------------------
     AJUSTES
     ------------------------------------------------------------- */
  function cargarAjustes() {
    subtitulo("Contraseña del panel y dónde vive todo lo demás.");
    return null;
  }

  function initAjustes() {
    var form = $("[data-form-password]");
    if (!form) return;
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var err = $("[data-password-error]");
      var boton = form.querySelector('button[type="submit"]');
      var actual = $("#ajustes-actual"), nueva = $("#ajustes-nueva"), nueva2 = $("#ajustes-nueva2");
      var a = actual ? String(actual.value) : "";
      var n1 = nueva ? String(nueva.value) : "";
      var n2 = nueva2 ? String(nueva2.value) : "";
      if (err) err.textContent = "";

      if (a === "") { if (err) err.textContent = "Escribe la contraseña actual."; if (actual) actual.focus(); return; }
      if (n1.length < 8) { if (err) err.textContent = "La contraseña nueva necesita ocho caracteres como mínimo."; if (nueva) nueva.focus(); return; }
      if (n1 !== n2) { if (err) err.textContent = "Las dos contraseñas nuevas no coinciden."; if (nueva2) nueva2.focus(); return; }
      if (n1 === a) { if (err) err.textContent = "La contraseña nueva es igual que la actual."; if (nueva) nueva.focus(); return; }

      ocupado(boton, true);
      api("cambiar_password", { actual: a, nueva: n1 })
        .then(function () {
          ocupado(boton, false);
          form.reset();
          aviso("Contraseña cambiada. La próxima vez entra con la nueva.");
        })
        .catch(function (e2) {
          ocupado(boton, false);
          if (err) err.textContent = e2.message || "No se ha podido cambiar la contraseña.";
        });
    });
  }

  /* -------------------------------------------------------------
     Arranque
     ------------------------------------------------------------- */
  function entrarEnElPanel() {
    mostrarApp();
    pintarFiltros();
    pintarRango();
    ir(S.vista, true);
    /* El catálogo hace falta en casi todas las vistas (nombres y fotos
       de los lotes). La vista de Almacén ya lo pide ella misma, así que
       no se repite la petición. Si falla, se sigue trabajando con los
       nombres que trae lib/catalogo.js. */
    if (S.vista !== "almacen") {
      api("catalogo").then(function (d) {
        S.lotes = d.lotes || S.lotes;
        S.vendidos = d.vendidos || {};
        if (S.vista === "pedidos") pintarFiltros();
      }).catch(function () { /* se sigue con el catálogo del navegador */ });
    }
  }

  function arrancar() {
    api("estado_sesion").then(function (d) {
      S.csrf = d.csrf || "";
      S.marca = d.marca || "Tornarem";
      if (d.version && d.version !== VERSION) {
        aviso("El panel del servidor es la versión " + d.version + " y el navegador tiene la " + VERSION + ". Recarga la página forzando la caché.", true);
      }
      if (d.autenticado) entrarEnElPanel();
      else mostrarAcceso(!!d.setup_pendiente);
    }).catch(function (e) {
      mostrarAcceso(false);
      var err = $("[data-acceso-error]");
      if (err) err.textContent = e.message || "No se ha podido hablar con el servidor.";
    });
  }

  function boot() {
    document.documentElement.classList.add("js-ready");
    safe(cargarPreferencias, "cargarPreferencias");
    safe(function () { leerHash(); }, "leerHash");
    safe(initAcceso, "initAcceso");
    safe(initSalir, "initSalir");
    safe(initNavegacion, "initNavegacion");
    safe(initRango, "initRango");
    safe(initPedidos, "initPedidos");
    safe(initClientes, "initClientes");
    safe(initAlmacen, "initAlmacen");
    safe(initAjustes, "initAjustes");
    safe(initCajon, "initCajon");
    safe(pintarRango, "pintarRango");
    safe(pintarFiltros, "pintarFiltros");
    safe(arrancar, "arrancar");
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();
})();
