/* =============================================================================
   TornaBox — db.js · cliente de datos
   -----------------------------------------------------------------------------
   ES LA ÚNICA PIEZA QUE HABLA CON LA API. Ni el panel ni la tienda hacen
   fetch por su cuenta: todo pasa por aquí.

   Funciones globales:
     dbListarPedidos()               → Promise<[pedido]>   (más nuevo primero)
     dbCrearPedido(o)                → Promise<pedido>
     dbActualizarPedido(num, patch)  → Promise<pedido>
     dbBorrarPedido(num)             → Promise<{ok}>
     dbBorrarTodos()                 → Promise<{ok}>
     dbBuscarPedido(q)               → Promise<[pedido]>

   RESPALDO EN localStorage
   ------------------------
   Cada respuesta buena se guarda en local. Si la API falla:
     · el panel sigue enseñando los pedidos de la última copia, y
     · la tienda sigue aceptando pedidos, que quedan en una cola y se
       reenvían solos en cuanto la API vuelve.
   Así una caída del servidor no deja la tienda muerta ni pierde ventas.
   ========================================================================== */
(function () {
  "use strict";

  var API = (window.__DB_API__ || "/api").replace(/\/+$/, "");
  var K_CACHE = "tb_pedidos_cache";
  var K_COLA = "tb_pedidos_cola";
  var K_TOKEN = "tb_admin_token";

  var estado = { enLinea: null, ultimoError: "", ultimaSync: 0 };

  /* --------------------------------------------------------- localStorage -- */
  function leerLocal(clave, porDefecto) {
    try {
      var v = localStorage.getItem(clave);
      return v ? JSON.parse(v) : porDefecto;
    } catch (e) { return porDefecto; }
  }
  function escribirLocal(clave, valor) {
    try { localStorage.setItem(clave, JSON.stringify(valor)); return true; }
    catch (e) { return false; }            // modo incógnito, cuota llena…
  }

  function cache() { return leerLocal(K_CACHE, []); }
  function guardarCache(pedidos) { escribirLocal(K_CACHE, pedidos); }
  function cola() { return leerLocal(K_COLA, []); }
  function guardarCola(c) { escribirLocal(K_COLA, c); }

  function token() {
    try { return localStorage.getItem(K_TOKEN) || ""; } catch (e) { return ""; }
  }

  /* ------------------------------------------------------------- peticiones -- */
  function pedir(ruta, opciones) {
    opciones = opciones || {};
    var cab = { "Content-Type": "application/json" };
    var t = token();
    if (t) cab["x-admin-token"] = t;

    var ctrl = typeof AbortController !== "undefined" ? new AbortController() : null;
    var corte = setTimeout(function () { if (ctrl) ctrl.abort(); }, opciones.espera || 12000);

    return fetch(API + ruta, {
      method: opciones.method || "GET",
      headers: cab,
      body: opciones.body ? JSON.stringify(opciones.body) : undefined,
      signal: ctrl ? ctrl.signal : undefined
    }).then(function (r) {
      clearTimeout(corte);
      return r.json().catch(function () { return {}; }).then(function (j) {
        if (!r.ok || j.ok === false) {
          var err = new Error(j.error || ("HTTP " + r.status));
          err.http = r.status;
          throw err;
        }
        estado.enLinea = true;
        estado.ultimoError = "";
        return j;
      });
    }).catch(function (e) {
      clearTimeout(corte);
      // Un 401 significa que la API está viva pero el token no vale: eso no es
      // «estar sin conexión», y conviene distinguirlo para avisar bien.
      if (e && e.http === 401) { estado.enLinea = true; estado.ultimoError = "token"; throw e; }
      estado.enLinea = false;
      estado.ultimoError = (e && e.message) || "sin conexión";
      throw e;
    });
  }

  /* ------------------------------------------------------- utilidades varias -- */
  function porFecha(a, b) {
    return String(b.fecha || "").localeCompare(String(a.fecha || ""));
  }

  /** Número provisional para un pedido que no ha podido llegar a la API.
   *  Lleva la misma forma que los del servidor para que nada se rompa; al
   *  sincronizar, el servidor puede darle otro y lo reemplazamos. */
  function numeroLocal() {
    var n = Math.floor(10000 + Math.random() * 90000);
    return "TB-" + new Date().getFullYear() + "-" + n;
  }

  /* Copia de la escalera de precios para poder calcular un total razonable
     cuando la API no responde. El importe bueno lo recalcula SIEMPRE el
     servidor al sincronizar: esto es solo para poder enseñar algo. */
  var CAJAS = {
    inicio: { nombre: "Caja Inicio", precio: 34.95, envioGratis: false },
    grande: { nombre: "Caja Grande", precio: 59.95, envioGratis: true },
    tech: { nombre: "Caja Tech", precio: 89.95, envioGratis: true },
    xxl: { nombre: "Caja XXL Reventa", precio: 149.95, envioGratis: true }
  };
  var MEJORAS = { inicio: { a: "grande", precio: 19.95 }, grande: { a: "tech", precio: 22.95 }, tech: { a: "xxl", precio: 44.95 } };

  function pedidoLocal(o) {
    var cajaId = CAJAS[o.caja] ? o.caja : "grande";
    var id = cajaId, extra = 0, guarda = 0;
    while (o.mejora && id !== o.mejora && MEJORAS[id] && guarda++ < 6) {
      extra += MEJORAS[id].precio; id = MEJORAS[id].a;
    }
    if (o.mejora && id !== o.mejora) { id = cajaId; extra = 0; }
    var caja = CAJAS[id];
    var precio = Math.round((CAJAS[cajaId].precio + extra) * 100) / 100;
    var lineas = [{ id: id, nombre: caja.nombre, qty: 1, precio: precio.toFixed(2), tipo: "caja" }];
    if (o.seguro) lineas.push({ id: "seguro", nombre: "Seguro de devolución (30 días)", qty: 1, precio: "4.95", tipo: "extra" });
    var subtotal = lineas.reduce(function (s, l) { return s + Number(l.precio); }, 0);
    var envio = (caja.envioGratis || precio >= 50) ? 0 : 4.95;
    var recargo = o.pago === "reembolso" ? 4.95 : 0;
    var c = o.cliente || {};
    return {
      num: o.num || numeroLocal(),
      fecha: new Date().toISOString(),
      cliente: {
        nombre: c.nombre || "", correo: (c.correo || c.email || "").toLowerCase(),
        telefono: c.telefono || "", direccion: c.direccion || "", numero: c.numero || "",
        piso: c.piso || "", planta: c.planta || "", cp: c.cp || "",
        ciudad: c.ciudad || c.poblacion || "", pueblo: c.pueblo || "",
        provincia: c.provincia || "", ip: c.ip || ""
      },
      notas: o.notas || "",
      lineas: lineas,
      unidades: 1,
      subtotal: Math.round(subtotal * 100) / 100,
      envio: envio, recargo: recargo,
      total: Math.round((subtotal + envio + recargo) * 100) / 100,
      pago: o.pago === "reembolso" ? "reembolso" : "tarjeta",
      envioTipo: envio === 0 ? "gratis" : "estandar",
      estado: o.pago === "reembolso" ? "recibido" : "pendiente_pago",
      tracking: "", cajaBase: cajaId, mejorada: id !== cajaId,
      sinSincronizar: true
    };
  }

  /* --------------------------------------------------------- cola pendiente -- */
  var vaciando = false;

  /** Reenvía a la API los pedidos que se quedaron en local. Se llama sola al
   *  cargar, al volver la conexión y después de cada listado con éxito. */
  function dbVaciarCola() {
    if (vaciando) return Promise.resolve(0);
    var pendientes = cola();
    if (!pendientes.length) return Promise.resolve(0);
    vaciando = true;
    var enviados = 0;

    function siguiente() {
      if (!pendientes.length) return Promise.resolve();
      var o = pendientes[0];
      return pedir("/pedidos", { method: "POST", body: o })
        .then(function (j) {
          pendientes.shift();
          guardarCola(pendientes);
          enviados++;
          // El servidor manda: si le ha dado otro número, se sustituye en la copia
          var c = cache().filter(function (p) { return p.num !== o.num; });
          c.unshift(j.pedido);
          guardarCache(c.sort(porFecha));
          return siguiente();
        });
    }

    return siguiente()
      .then(function () { vaciando = false; return enviados; })
      .catch(function () { vaciando = false; return enviados; });
  }

  /* ------------------------------------------------------- API pública ----- */

  function dbListarPedidos() {
    return pedir("/pedidos")
      .then(function (j) {
        var pedidos = (j.pedidos || []).slice().sort(porFecha);
        guardarCache(pedidos);
        estado.ultimaSync = Date.now();
        dbVaciarCola();
        return pedidos;
      })
      .catch(function (e) {
        if (e && e.http === 401) throw e;      // token malo: hay que decirlo
        // Sin API: se sigue trabajando con la última copia + lo que haya en cola
        return cache().concat(cola().filter(function (o) {
          return !cache().some(function (p) { return p.num === o.num; });
        })).sort(porFecha);
      });
  }

  function dbCrearPedido(o) {
    return pedir("/pedidos", { method: "POST", body: o })
      .then(function (j) {
        var c = cache();
        c.unshift(j.pedido);
        guardarCache(c.sort(porFecha));
        return j.pedido;
      })
      .catch(function () {
        // La venta NO se pierde: se guarda en local y se reenvía sola.
        var local = pedidoLocal(o);
        var q = cola(); q.push(o.num ? o : Object.assign({}, o, { num: local.num })); guardarCola(q);
        var c = cache(); c.unshift(local); guardarCache(c.sort(porFecha));
        return local;
      });
  }

  function dbActualizarPedido(num, patch) {
    return pedir("/pedidos/" + encodeURIComponent(num), { method: "PATCH", body: patch })
      .then(function (j) {
        var c = cache().map(function (p) { return p.num === num ? j.pedido : p; });
        guardarCache(c);
        return j.pedido;
      })
      .catch(function (e) {
        // Se aplica en local para que el panel no mienta, marcado como no sincronizado
        var actualizado = null;
        var c = cache().map(function (p) {
          if (p.num !== num) return p;
          actualizado = Object.assign({}, p, patch, { sinSincronizar: true });
          return actualizado;
        });
        guardarCache(c);
        if (!actualizado) throw e;
        return actualizado;
      });
  }

  function dbBorrarPedido(num) {
    return pedir("/pedidos/" + encodeURIComponent(num), { method: "DELETE" })
      .then(function (j) {
        guardarCache(cache().filter(function (p) { return p.num !== num; }));
        return j;
      });
  }

  function dbBorrarTodos() {
    return pedir("/pedidos", { method: "DELETE" })
      .then(function (j) { guardarCache([]); guardarCola([]); return j; });
  }

  function dbBuscarPedido(q) {
    var texto = String(q || "").toLowerCase().trim();
    if (!texto) return Promise.resolve([]);
    return pedir("/buscar?q=" + encodeURIComponent(texto))
      .then(function (j) { return (j.pedidos || []).sort(porFecha); })
      .catch(function () {
        // Búsqueda sobre la copia local con los mismos campos que el servidor
        return cache().filter(function (p) {
          var c = p.cliente || {};
          return [p.num, c.nombre, c.correo, c.telefono, c.direccion, c.ciudad, c.cp, c.ip, p.tracking]
            .join(" ").toLowerCase().indexOf(texto) >= 0;
        });
      });
  }

  /* ------------------------------------------------------------ auxiliares -- */

  /** IP pública del cliente, para detectar pedidos repetidos.
   *  El servidor se queda con la IP de la conexión si la tiene (más fiable);
   *  esto es el plan B y lo que hace falta cuando no hay proxy delante. */
  function dbIP() {
    return fetch("https://api.ipify.org?format=json", { cache: "no-store" })
      .then(function (r) { return r.json(); })
      .then(function (j) { return String(j && j.ip || ""); })
      .catch(function () { return ""; });
  }

  function dbEstado() {
    return { enLinea: estado.enLinea, ultimoError: estado.ultimoError,
             ultimaSync: estado.ultimaSync, enCola: cola().length };
  }
  function dbToken(nuevo) {
    if (nuevo === undefined) return token();
    try { localStorage.setItem(K_TOKEN, String(nuevo || "")); } catch (e) {}
    return token();
  }
  function dbLimpiarCache() { try { localStorage.removeItem(K_CACHE); } catch (e) {} }

  window.dbListarPedidos = dbListarPedidos;
  window.dbCrearPedido = dbCrearPedido;
  window.dbActualizarPedido = dbActualizarPedido;
  window.dbBorrarPedido = dbBorrarPedido;
  window.dbBorrarTodos = dbBorrarTodos;
  window.dbBuscarPedido = dbBuscarPedido;
  window.dbVaciarCola = dbVaciarCola;
  window.dbIP = dbIP;
  window.dbEstado = dbEstado;
  window.dbToken = dbToken;
  window.dbLimpiarCache = dbLimpiarCache;

  // En cuanto vuelve la conexión, se reenvía lo que quedó pendiente
  window.addEventListener("online", function () { dbVaciarCola(); });
  if (cola().length) setTimeout(dbVaciarCola, 1500);
})();
