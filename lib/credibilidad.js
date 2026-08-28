/* =============================================================================
   TornaBox — credibilidad.js · motor de nota de pedidos
   -----------------------------------------------------------------------------
   Cada pedido sale con una nota de 1 a 10 y una recomendación.
   Se parte de 10 y cada regla suma o resta décimas DEJANDO ESCRITO EL PORQUÉ:
   la nota sin el motivo no sirve para decidir.

     credAnalizar(pedido, ctx)   → Promise<analisis>   (reglas locales + red)
     credLocal(pedido, ctx)      → analisis            (solo reglas locales)
     credRed(pedido)             → Promise<checks>     (Nominatim + DNS)
     credAutoCancelar(pedidos, opciones) → Promise<[{num, motivo}]>

   ctx = { pedidos: [...todos, del más nuevo al más viejo], media: importe medio }

   analisis = {
     nota, recomendacion, pendiente,
     resta: [{ txt, val }], suma: [{ txt, val }], ok: [ txt ]
   }

   OJO CON LAS REGLAS DE RED (ver credRed): si una comprobación no se puede
   hacer porque falló la conexión, el análisis queda «pendiente» y el
   auto-cancelado se salta ese pedido. Un corte de internet no le puede
   costar el pedido a un cliente legítimo.
   ========================================================================== */
(function () {
  "use strict";

  var K_CACHE = "tb_cred_cache";
  var VIDA_CACHE = 30 * 24 * 60 * 60 * 1000;      // 30 días
  var MS_ENTRE_NOMINATIM = 1100;                  // 1 petición por segundo

  /* ============================================================ utilidades == */

  /** Sin acentos, sin espacios, en minúsculas: para comparar nombres de sitios
   *  escritos a mano («A Coruña» / «a coruna» / «LaCoruña»). */
  function normal(s) {
    return String(s == null ? "" : s)
      .toLowerCase()
      .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
      .replace(/[\s.\-_']/g, "");
  }
  function limpio(s) { return String(s == null ? "" : s).trim(); }

  /** Distancia de edición de Damerau-Levenshtein: como la de Levenshtein pero
   *  contando el INTERCAMBIO de dos letras seguidas como un solo fallo. Hace
   *  falta que sea así: «hotmial.com» es la errata más típica de hotmail.com y
   *  con Levenshtein normal sale a distancia 2, o sea, se colaría.
   *  Sirve para dos cosas: cazar erratas de dominios famosos y tolerar
   *  provincias mal escritas. */
  function distancia(a, b) {
    a = String(a); b = String(b);
    if (a === b) return 0;
    if (!a.length) return b.length;
    if (!b.length) return a.length;

    var d = [], i, j;
    for (i = 0; i <= a.length; i++) { d[i] = [i]; }
    for (j = 0; j <= b.length; j++) { d[0][j] = j; }

    for (i = 1; i <= a.length; i++) {
      for (j = 1; j <= b.length; j++) {
        var coste = a[i - 1] === b[j - 1] ? 0 : 1;
        d[i][j] = Math.min(
          d[i - 1][j] + 1,          // borrar
          d[i][j - 1] + 1,          // insertar
          d[i - 1][j - 1] + coste   // sustituir
        );
        // intercambio de dos letras contiguas: «ai» ↔ «ia»
        if (i > 1 && j > 1 && a[i - 1] === b[j - 2] && a[i - 2] === b[j - 1]) {
          d[i][j] = Math.min(d[i][j], d[i - 2][j - 2] + 1);
        }
      }
    }
    return d[a.length][b.length];
  }

  function ipPrivada(ip) {
    if (!ip) return true;
    return /^(127\.|10\.|192\.168\.|169\.254\.|::1$|fc|fd)/i.test(ip)
      || /^172\.(1[6-9]|2\d|3[01])\./.test(ip);
  }

  /* ====================================================== tablas de apoyo == */

  /* Buzones de usar y tirar: quien los usa no piensa recibir nada. */
  var DESECHABLES = ["yopmail.com", "yopmail.fr", "mailinator.com", "tempmail.com", "temp-mail.org",
    "guerrillamail.com", "10minutemail.com", "throwawaymail.com", "trashmail.com", "sharklasers.com",
    "getnada.com", "dispostable.com", "maildrop.cc", "fakeinbox.com", "mohmal.com", "emailondeck.com",
    "spamgourmet.com", "mailnesia.com", "tempr.email", "moakt.com", "inboxbear.com", "grr.la",
    "correotemporal.org", "mailcatch.com", "spam4.me", "byom.de", "disposablemail.com"];

  /* Alias que no son de una persona: nadie compra desde noreply@ */
  var GENERICOS = ["info", "test", "prueba", "noreply", "no-reply", "admin", "administrador",
    "ejemplo", "example", "asdf", "correo", "email", "webmaster", "postmaster", "contacto", "nadie"];

  var FAMOSOS = ["gmail.com", "hotmail.com", "hotmail.es", "outlook.com", "outlook.es", "yahoo.com",
    "yahoo.es", "icloud.com", "live.com", "msn.com", "protonmail.com", "proton.me", "me.com",
    "aol.com", "gmx.com", "gmx.es", "terra.es", "telefonica.net", "movistar.es"];

  /* Los dos primeros dígitos del CP dan la provincia. */
  var CP_PROV = {
    "01": "alava", "02": "albacete", "03": "alicante", "04": "almeria", "05": "avila",
    "06": "badajoz", "07": "baleares", "08": "barcelona", "09": "burgos", "10": "caceres",
    "11": "cadiz", "12": "castellon", "13": "ciudadreal", "14": "cordoba", "15": "acoruna",
    "16": "cuenca", "17": "girona", "18": "granada", "19": "guadalajara", "20": "gipuzkoa",
    "21": "huelva", "22": "huesca", "23": "jaen", "24": "leon", "25": "lleida",
    "26": "larioja", "27": "lugo", "28": "madrid", "29": "malaga", "30": "murcia",
    "31": "navarra", "32": "ourense", "33": "asturias", "34": "palencia", "35": "laspalmas",
    "36": "pontevedra", "37": "salamanca", "38": "santacruzdetenerife", "39": "cantabria",
    "40": "segovia", "41": "sevilla", "42": "soria", "43": "tarragona", "44": "teruel",
    "45": "toledo", "46": "valencia", "47": "valladolid", "48": "bizkaia", "49": "zamora",
    "50": "zaragoza", "51": "ceuta", "52": "melilla"
  };

  /* La misma provincia se escribe de muchas maneras. Todas valen. */
  var ALIAS_PROV = {
    alava: ["araba", "vitoria", "arabaalava"],
    acoruna: ["lacoruna", "coruna", "corunha", "acorunha"],
    gipuzkoa: ["guipuzcoa", "sansebastian", "donostia"],
    bizkaia: ["vizcaya", "bilbao", "vizkaya"],
    baleares: ["illesbalears", "islasbaleares", "mallorca", "palmademallorca", "ibiza", "menorca"],
    laspalmas: ["grancanaria", "laspalmasdegrancanaria", "fuerteventura", "lanzarote"],
    santacruzdetenerife: ["tenerife", "santacruz", "lapalma", "gomera", "hierro"],
    girona: ["gerona"], lleida: ["lerida"], ourense: ["orense"],
    larioja: ["rioja", "logrono"], ciudadreal: ["ciudadrreal"],
    alicante: ["alacant"], castellon: ["castello", "castellodelaplana"],
    valencia: ["valencia", "comunidadvalenciana", "comunitatvalenciana"],
    asturias: ["principadodeasturias", "oviedo", "gijon"],
    navarra: ["nafarroa", "pamplona", "comunidadforaldenavarra"],
    cantabria: ["santander"], madrid: ["comunidaddemadrid"],
    murcia: ["regiondemurcia"]
  };

  /* Trampa nº 7: poner la comunidad autónoma en vez de la provincia es un fallo
     de formulario, no un fraude. Se acepta. */
  var COMUNIDADES = {
    andalucia: ["04", "11", "14", "18", "21", "23", "29", "41"],
    aragon: ["22", "44", "50"],
    asturias: ["33"], principadodeasturias: ["33"],
    baleares: ["07"], illesbalears: ["07"], islasbaleares: ["07"],
    canarias: ["35", "38"], islascanarias: ["35", "38"],
    cantabria: ["39"],
    castillalamancha: ["02", "13", "16", "19", "45"],
    castillayleon: ["05", "09", "24", "34", "37", "40", "42", "47", "49"],
    cataluna: ["08", "17", "25", "43"], catalunya: ["08", "17", "25", "43"],
    extremadura: ["06", "10"],
    galicia: ["15", "27", "32", "36"],
    larioja: ["26"], rioja: ["26"],
    madrid: ["28"], comunidaddemadrid: ["28"],
    murcia: ["30"], regiondemurcia: ["30"],
    navarra: ["31"], comunidadforaldenavarra: ["31"],
    paisvasco: ["01", "20", "48"], euskadi: ["01", "20", "48"], euskalherria: ["01", "20", "48"],
    comunidadvalenciana: ["03", "12", "46"], comunitatvalenciana: ["03", "12", "46"],
    valencia: ["03", "12", "46"],
    ceuta: ["51"], melilla: ["52"]
  };

  var TECLADO = ["qwerty", "asdf", "asdfgh", "zxcv", "qwer", "wasd", "1234", "12345", "123456",
    "abcd", "aaaa", "hjkl", "poiu", "lkjh"];

  /* ==================================================== reglas locales ===== */

  function analisisVacio() {
    return { nota: 10, recomendacion: "ENVIAR", pendiente: false, resta: [], suma: [], ok: [] };
  }
  function resta(a, txt, val) { a.resta.push({ txt: txt, val: -Math.abs(val) }); }
  function suma(a, txt, val) { a.suma.push({ txt: txt, val: Math.abs(val) }); }
  function vale(a, txt) { a.ok.push(txt); }

  function cerrar(a) {
    var total = 10
      + a.resta.reduce(function (s, r) { return s + r.val; }, 0)
      + a.suma.reduce(function (s, r) { return s + r.val; }, 0);
    a.nota = Math.round(Math.max(1, Math.min(10, total)) * 10) / 10;
    a.recomendacion = credRecomendacion(a.nota);
    return a;
  }

  function credRecomendacion(nota) {
    if (nota >= 7) return "ENVIAR";
    if (nota >= 5) return "REVISAR";
    return "NO ENVIAR";
  }

  /* ------------------------------------------------------------- nombre --- */
  function reglaNombre(a, c) {
    var n = limpio(c.nombre);
    if (!n) { resta(a, "No hay nombre", 3); return; }

    if (/[0-9]/.test(n) || /[^\p{L}\s'.\-]/u.test(n)) resta(a, "El nombre lleva dígitos o símbolos: «" + n + "»", 1.5);

    // Sin vocales = tecleo al azar («sdfgh»). Ojo: hay apellidos sin vocales,
    // por eso se mira el nombre entero, no palabra a palabra.
    if (!/[aeiouáéíóúüàèìòùâêîôûy]/i.test(n.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
      resta(a, "El nombre no tiene ni una vocal: parece tecleado al azar", 2.5);
    }

    var palabras = n.split(/\s+/).filter(Boolean);
    if (palabras.length < 2) resta(a, "Solo un nombre, sin apellidos", 0.8);
    else if (/^[\p{L}\s'.\-]+$/u.test(n)) { vale(a, "Nombre y apellidos con forma normal"); suma(a, "Nombre completo y solo con letras", 0.3); }

    if (/(.)\1{3,}/i.test(n)) resta(a, "La misma letra repetida cuatro o más veces", 2);

    var plano = normal(n);
    for (var i = 0; i < TECLADO.length; i++) {
      if (plano.indexOf(TECLADO[i]) >= 0) { resta(a, "El nombre contiene una secuencia de teclado («" + TECLADO[i] + "»)", 2.5); break; }
    }
  }

  /* ------------------------------------------------------------- correo --- */
  function reglaCorreo(a, c) {
    var e = limpio(c.correo).toLowerCase();
    if (!e) { resta(a, "No hay correo", 2.5); return; }
    if (!/^[^\s@]+@[^\s@.]+(\.[^\s@.]+)+$/.test(e)) { resta(a, "El correo no tiene forma de correo: «" + e + "»", 3); return; }

    var partes = e.split("@");
    var usuario = partes[0], dominio = partes[1];
    vale(a, "El correo tiene un formato válido");

    if (DESECHABLES.indexOf(dominio) >= 0) resta(a, "Correo de usar y tirar (" + dominio + ")", 3);
    else vale(a, "El dominio del correo no es de usar y tirar");

    var raiz = usuario.split(/[.+_-]/)[0];
    if (GENERICOS.indexOf(raiz) >= 0) resta(a, "Alias genérico, no de una persona (" + usuario + "@)", 1.2);

    // Errata de dominio famoso: gmail.con, hotmial.com… una letra de distancia
    if (FAMOSOS.indexOf(dominio) < 0) {
      for (var i = 0; i < FAMOSOS.length; i++) {
        if (distancia(dominio, FAMOSOS[i]) === 1) {
          resta(a, "El dominio parece una errata de " + FAMOSOS[i] + " («" + dominio + "»)", 1.5);
          break;
        }
      }
    }

    // Si el correo lleva dentro el nombre del cliente, es señal buena
    var nombrePlano = normal(c.nombre);
    if (nombrePlano.length >= 4) {
      var trozos = limpio(c.nombre).split(/\s+/).map(normal).filter(function (t) { return t.length >= 3; });
      var coincide = trozos.some(function (t) { return normal(usuario).indexOf(t) >= 0; });
      if (coincide) { suma(a, "El correo lleva el nombre del cliente", 0.5); vale(a, "Correo y nombre concuerdan"); }
    }
  }

  /* ----------------------------------------------------------- teléfono --- */
  function soloDigitos(s) { return String(s || "").replace(/\D/g, ""); }

  function reglaTelefono(a, c) {
    var bruto = limpio(c.telefono);
    if (!bruto) { resta(a, "No hay teléfono: el repartidor no puede avisar", 2); return; }

    var d = soloDigitos(bruto).replace(/^0034/, "").replace(/^34(?=\d{9}$)/, "");
    if (!/^[6789]\d{8}$/.test(d)) {
      resta(a, "El teléfono no es un número español válido: «" + bruto + "»", 2);
      return;
    }
    vale(a, "Teléfono español con formato correcto");

    if (/^(\d)\1{8}$/.test(d)) { resta(a, "Todos los dígitos del teléfono son iguales (" + d + ")", 2.5); return; }

    var correlativo = true;
    for (var i = 1; i < d.length; i++) if (+d[i] !== (+d[i - 1] + 1) % 10) { correlativo = false; break; }
    if (correlativo) { resta(a, "Los dígitos del teléfono van correlativos (" + d + ")", 2); return; }

    if (/^[67]/.test(d)) { suma(a, "Es un móvil, se puede avisar de la entrega", 0.3); vale(a, "Número de móvil"); }
    else vale(a, "Número fijo (el repartidor puede avisar igual)");

    // El mismo número en el teléfono y en el portal = campos mal rellenados
    if (soloDigitos(c.numero).length >= 6 && soloDigitos(c.numero) === d) {
      resta(a, "El teléfono es el mismo número que ha puesto en el portal", 1);
    }
  }

  /* ---------------------------------------------------------- dirección --- */
  function reglaDireccion(a, c) {
    // Trampa nº 6: sin la «i», [a-z] rechaza «Carrer» y «Calle» (empiezan por
    // mayúscula) y tumba TODAS las direcciones válidas. Todas llevan «i».
    var calle = limpio(c.direccion);
    if (!calle) resta(a, "No hay calle", 2);
    else if (!/[a-záéíóúñàèìòùç]{3,}/i.test(calle)) resta(a, "La calle no parece un nombre de calle: «" + calle + "»", 2);
    else vale(a, "La calle tiene nombre");

    var num = limpio(c.numero);
    if (!num) resta(a, "Falta el número de portal", 0.8);
    else if (soloDigitos(num).length >= 9) resta(a, "Han metido un teléfono en la casilla del portal: «" + num + "»", 2);
    else if (!/^\d{1,4}\s*(bis)?\s*[a-z]?$/i.test(num.replace(/[\u00ba\u00b0\u00aa]/g, "")))
      resta(a, "El número de portal no parece plausible: «" + num + "»", 1);
    else vale(a, "Número de portal plausible");

    var cp = soloDigitos(c.cp);
    if (!/^\d{5}$/.test(cp)) { resta(a, "El código postal no tiene cinco dígitos: «" + limpio(c.cp) + "»", 1.5); return; }
    var pref = cp.slice(0, 2);
    if (!CP_PROV[pref]) { resta(a, "El código postal no corresponde a ninguna provincia española (" + cp + ")", 1.5); return; }
    vale(a, "Código postal español válido (" + cp + ")");

    var prov = normal(c.provincia);
    if (!prov) return;                                    // no la ha puesto: no se penaliza

    var esperada = CP_PROV[pref];
    var candidatas = [esperada].concat(ALIAS_PROV[esperada] || []);
    var acierta = candidatas.some(function (x) { return x === prov || distancia(x, prov) <= 1; });

    // ¿Ha puesto la comunidad autónoma en vez de la provincia? Vale igual.
    if (!acierta) {
      Object.keys(COMUNIDADES).forEach(function (com) {
        if ((com === prov || distancia(com, prov) <= 1) && COMUNIDADES[com].indexOf(pref) >= 0) acierta = true;
      });
    }

    if (acierta) vale(a, "El código postal cuadra con la provincia");
    // Trampa nº 7: escribir mal la provincia no es fraude. Resta poco.
    else resta(a, "La provincia «" + limpio(c.provincia) + "» no cuadra con el CP " + cp
      + " (sería " + esperada + "). Suele ser un fallo al rellenar, no un fraude", 0.6);
  }

  /* ---------------------------------------------------------- historial --- */
  function reglaHistorial(a, pedido, ctx) {
    var todos = (ctx && ctx.pedidos) || [];
    var c = pedido.cliente || {};
    var mismos = todos.filter(function (p) {
      if (p.num === pedido.num) return false;
      var q = p.cliente || {};
      return (c.correo && q.correo === c.correo)
        || (c.telefono && soloDigitos(q.telefono) === soloDigitos(c.telefono));
    });
    if (!mismos.length) return;

    var entregados = mismos.filter(function (p) { return p.estado === "entregado"; }).length;
    var cancelados = mismos.filter(function (p) { return p.estado === "cancelado"; }).length;

    if (entregados) {
      suma(a, "Cliente conocido: " + entregados + " pedido(s) ya entregado(s)", Math.min(1.5, entregados * 0.6));
      vale(a, "Ya le hemos entregado antes sin problemas");
    }
    if (cancelados) {
      resta(a, "Tiene " + cancelados + " pedido(s) cancelado(s) antes", Math.min(2, cancelados * 0.8));
    }
  }

  /* ------------------------------------------------------------- pedido --- */
  function reglaPedido(a, pedido, ctx) {
    var media = (ctx && ctx.media) || 0;
    if (media > 0 && pedido.total > media * 2.5) {
      resta(a, "Importe muy por encima de la media (" + pedido.total.toFixed(2) + " € frente a "
        + media.toFixed(2) + " € de media)", 0.5);
    }
    if (pedido.pago === "reembolso") {
      resta(a, "Contra reembolso: si rechaza el paquete, el porte se pierde", 0.4);
    } else {
      vale(a, "Pago con tarjeta: cobrado antes de salir del almacén");
    }
    if (!pedido.cliente || !pedido.cliente.ip || ipPrivada(pedido.cliente.ip)) {
      resta(a, "No se registró la IP del pedido: no se pueden cruzar repeticiones", 0.5);
    } else {
      vale(a, "IP registrada (" + pedido.cliente.ip + ")");
    }
  }

  function credLocal(pedido, ctx) {
    var a = analisisVacio();
    var c = (pedido && pedido.cliente) || {};
    reglaNombre(a, c);
    reglaCorreo(a, c);
    reglaTelefono(a, c);
    reglaDireccion(a, c);
    reglaHistorial(a, pedido, ctx);
    reglaPedido(a, pedido, ctx);
    return cerrar(a);
  }

  /* ================================================ comprobaciones de red == */

  function cacheRed() {
    try { return JSON.parse(localStorage.getItem(K_CACHE) || "{}"); } catch (e) { return {}; }
  }
  function guardaCacheRed(c) {
    try { localStorage.setItem(K_CACHE, JSON.stringify(c)); } catch (e) {}
  }
  function deCache(clave) {
    var c = cacheRed()[clave];
    if (!c || (Date.now() - c.ts) > VIDA_CACHE) return null;
    return c.valor;
  }
  function aCache(clave, valor) {
    var c = cacheRed();
    c[clave] = { ts: Date.now(), valor: valor };
    guardaCacheRed(c);
  }

  /* Nominatim pide como mucho 1 petición por segundo. Cola global. */
  var ultimaNominatim = 0;
  function turnoNominatim() {
    var espera = Math.max(0, MS_ENTRE_NOMINATIM - (Date.now() - ultimaNominatim));
    ultimaNominatim = Date.now() + espera;
    return new Promise(function (r) { setTimeout(r, espera); });
  }

  /** ¿Existe la dirección? Consulta ESTRUCTURADA a Nominatim (street/city/
   *  postalcode), que acierta mucho más que meterlo todo en «q».
   *
   *  Trampa nº 5: OpenStreetMap NO tiene todos los portales de España. En las
   *  pruebas falló en ~11 de 23 direcciones reales. Que no aparezca NO
   *  significa que la dirección sea falsa: por eso resta poco y nunca lo
   *  bastante para cancelar nada.
   *  (Desde el navegador el User-Agent lo pone el propio navegador; desde
   *  node o curl hay que mandarlo o Nominatim contesta 403.) */
  function comprobarDireccion(c) {
    var calle = limpio(c.direccion), ciudad = limpio(c.ciudad), cp = soloDigitos(c.cp);
    if (!calle || (!ciudad && !cp)) return Promise.resolve({ estado: "sin-datos" });

    var clave = "dir:" + normal(calle) + "|" + normal(c.numero) + "|" + normal(ciudad) + "|" + cp;
    var guardado = deCache(clave);
    if (guardado) return Promise.resolve(guardado);

    function consulta(conNumero) {
      var p = new URLSearchParams({ format: "jsonv2", limit: "1", countrycodes: "es", addressdetails: "0" });
      p.set("street", (conNumero && limpio(c.numero) ? limpio(c.numero) + " " : "") + calle);
      if (ciudad) p.set("city", ciudad);
      if (cp) p.set("postalcode", cp);
      return turnoNominatim().then(function () {
        return fetch("https://nominatim.openstreetmap.org/search?" + p.toString(), {
          headers: { "Accept": "application/json" }
        });
      }).then(function (r) {
        if (!r.ok) throw new Error("HTTP " + r.status);
        return r.json();
      });
    }

    return consulta(true)
      .then(function (j) {
        if (j && j.length) return { estado: "exacta", etiqueta: j[0].display_name || "" };
        // Sin número puede que sí exista la calle: eso ya dice bastante
        return consulta(false).then(function (j2) {
          return (j2 && j2.length)
            ? { estado: "solo-calle", etiqueta: j2[0].display_name || "" }
            : { estado: "no-encontrada" };
        });
      })
      .then(function (r) { aCache(clave, r); return r; })
      .catch(function (e) {
        // Trampa nº 3: fallo de red ≠ dirección falsa. Queda pendiente y no se
        // guarda en caché, para reintentarlo la próxima vez.
        return { estado: "error", error: (e && e.message) || "sin conexión" };
      });
  }

  /** ¿El dominio del correo recibe correo? DNS-over-HTTPS de Cloudflare:
   *  primero MX y, si no hay, A (hay dominios que reciben con solo un A). */
  function comprobarDominio(correo) {
    var dominio = String(correo || "").split("@")[1];
    if (!dominio) return Promise.resolve({ estado: "sin-datos" });
    var clave = "dns:" + dominio;
    var guardado = deCache(clave);
    if (guardado) return Promise.resolve(guardado);

    function doh(tipo) {
      return fetch("https://cloudflare-dns.com/dns-query?name=" + encodeURIComponent(dominio) + "&type=" + tipo,
        { headers: { "Accept": "application/dns-json" } })
        .then(function (r) { if (!r.ok) throw new Error("HTTP " + r.status); return r.json(); });
    }

    return doh("MX")
      .then(function (j) {
        if (j && j.Answer && j.Answer.length) return { estado: "mx", registros: j.Answer.length };
        return doh("A").then(function (j2) {
          return (j2 && j2.Answer && j2.Answer.length)
            ? { estado: "solo-a" }
            : { estado: "sin-registros" };
        });
      })
      .then(function (r) { aCache(clave, r); return r; })
      .catch(function (e) { return { estado: "error", error: (e && e.message) || "sin conexión" }; });
  }

  function credRed(pedido) {
    var c = (pedido && pedido.cliente) || {};
    return Promise.all([comprobarDireccion(c), comprobarDominio(c.correo)])
      .then(function (r) { return { direccion: r[0], dominio: r[1] }; });
  }

  /** Mete el resultado de las comprobaciones de red en el análisis local. */
  function aplicarRed(a, checks) {
    var d = checks.direccion || {}, m = checks.dominio || {};

    if (d.estado === "exacta") { suma(a, "La dirección existe en OpenStreetMap", 0.5); vale(a, "Dirección localizada: " + (d.etiqueta || "").slice(0, 80)); }
    else if (d.estado === "solo-calle") resta(a, "La calle existe pero OpenStreetMap no tiene ese portal (es habitual, no prueba nada)", 0.15);
    else if (d.estado === "no-encontrada") resta(a, "OpenStreetMap no encuentra la dirección (le faltan muchos portales de España: no es prueba de fraude)", 0.4);
    else if (d.estado === "error") { a.pendiente = true; a.motivoPendiente = "No se pudo comprobar la dirección: " + d.error; }

    if (m.estado === "mx") { suma(a, "El dominio del correo tiene servidor de correo (MX)", 0.4); vale(a, "El correo puede recibir mensajes"); }
    else if (m.estado === "solo-a") vale(a, "El dominio existe, aunque sin MX declarado");
    else if (m.estado === "sin-registros") resta(a, "El dominio del correo no existe o no recibe correo", 2.5);
    else if (m.estado === "error") { a.pendiente = true; a.motivoPendiente = "No se pudo comprobar el dominio del correo: " + m.error; }

    return cerrar(a);
  }

  function credAnalizar(pedido, ctx) {
    var a = credLocal(pedido, ctx);
    return credRed(pedido).then(function (checks) {
      a.checks = checks;
      return aplicarRed(a, checks);
    });
  }

  /* ================================================== auto-cancelación ===== */

  var CANCELABLES = ["recibido", "pendiente_pago"];

  /* Un pedido anterior solo cuenta como DUPLICADO si sigue sin salir del
     almacén. Si ya está enviado o entregado no es un duplicado: es una venta
     hecha, o sea, un cliente que repite. Ver «esDuplicado» abajo. */
  var NO_ES_VENTA_HECHA = ["recibido", "pendiente_pago", "preparacion", "cancelado"];
  var HORAS_DUPLICADO = 72;

  /**
   * ¿El pedido «q» (anterior) puede ser un duplicado de «p»?
   * Dos condiciones, y las dos hacen falta:
   *   · que no sea una venta ya servida, y
   *   · que sea de hace poco. Un pedido del mes pasado con los mismos datos
   *     es un cliente que vuelve, no alguien duplicando el formulario.
   */
  function esDuplicado(p, q, horas) {
    if (NO_ES_VENTA_HECHA.indexOf(q.estado) < 0) return false;
    var ta = Date.parse(p.fecha), tb = Date.parse(q.fecha);
    if (isNaN(ta) || isNaN(tb)) return true;          // sin fecha, mejor mirarlo
    return Math.abs(ta - tb) <= (horas || HORAS_DUPLICADO) * 3600e3;
  }

  function contexto(pedidos) {
    var suma = pedidos.reduce(function (s, p) { return s + (Number(p.total) || 0); }, 0);
    return { pedidos: pedidos, media: pedidos.length ? suma / pedidos.length : 0 };
  }

  /**
   * Decide qué pedidos se cancelarían y por qué. NO toca nada: devuelve la
   * lista para que quien llame decida (así se puede simular antes de activar).
   *
   * opciones.ventana  → cuántos pedidos anteriores se miran (10 por defecto)
   * opciones.notaMin  → por debajo de esta nota se cancela (5 por defecto)
   * opciones.conRed   → true para incluir las comprobaciones de internet
   */
  function credAutoCancelar(pedidos, opciones) {
    opciones = opciones || {};
    var ventana = opciones.ventana || 10;
    var notaMin = opciones.notaMin === undefined ? 5 : opciones.notaMin;
    var ctx = contexto(pedidos);

    var trabajo = pedidos.map(function (p, i) {
      var analisis = opciones.conRed
        ? credAnalizar(p, ctx)
        : Promise.resolve(credLocal(p, ctx));
      return analisis.then(function (a) { return { pedido: p, i: i, a: a }; });
    });

    return Promise.all(trabajo).then(function (filas) {
      var salida = [];

      filas.forEach(function (fila) {
        var p = fila.pedido, a = fila.a, i = fila.i;

        // Trampa nº 2: lo que ya salió del almacén no se cancela nunca.
        if (CANCELABLES.indexOf(p.estado) < 0) return;
        // Trampa nº 3: si una comprobación de red falló, no se cancela.
        if (a.pendiente) return;

        var motivos = [];

        // Trampa nº 1: la lista viene del MÁS NUEVO al más viejo, así que los
        // pedidos ANTERIORES a este son los de índices mayores. Comparar contra
        // los 10 primeros cancelaría el original en vez del repetido.
        var anteriores = pedidos.slice(i + 1, i + 1 + ventana);
        var c = p.cliente || {};
        /* Campos FUERTES: identifican a una persona. Uno solo basta.
           Campos DÉBILES (IP y dirección sueltas): los comparte una familia,
           una oficina o cualquiera detrás de un CGNAT del operador. Bajan la
           nota y salen en «pedidos relacionados», pero NO cancelan solos:
           cancelar a la compañera de piso de un cliente es destruir una venta
           buena. */
        var FUERTES = [
          { nombre: "correo", lee: function (q) { return normal(q.correo); } },
          { nombre: "teléfono", lee: function (q) { return soloDigitos(q.telefono); } },
          { nombre: "nombre y dirección", lee: function (q) {
              var nm = normal(q.nombre), dir = normal(q.direccion);
              return (nm && dir) ? nm + "|" + dir + "|" + normal(q.numero) : "";
            } }
        ];
        var DEBILES = [
          { nombre: "IP", lee: function (q) { return ipPrivada(q.ip) ? "" : String(q.ip || ""); } },
          { nombre: "dirección", lee: function (q) {
              var d = normal(q.direccion);
              return d ? d + "|" + normal(q.numero) + "|" + normal(q.cp) : "";
            } }
        ];

        // Solo los anteriores que puedan ser un duplicado de verdad
        var sospechosos = anteriores.filter(function (q) { return esDuplicado(p, q, opciones.horasDuplicado); });

        function choques(campo) {
          var valor = campo.lee(c);
          if (!valor) return [];
          return sospechosos.filter(function (q) { return campo.lee(q.cliente || {}) === valor; });
        }

        FUERTES.forEach(function (campo) {
          var ch = choques(campo);
          if (ch.length) {
            motivos.push("repite " + campo.nombre + " con " + ch.map(function (q) { return q.num; }).join(", ")
              + " (sin servir todavía)");
          }
        });

        // Los débiles solo se anotan si YA hay un motivo fuerte, salvo que el
        // usuario haya pedido el modo estricto.
        var debilesVistos = [];
        DEBILES.forEach(function (campo) {
          var ch = choques(campo);
          if (ch.length) debilesVistos.push(campo.nombre + " con " + ch.map(function (q) { return q.num; }).join(", "));
        });
        if (debilesVistos.length && (motivos.length || opciones.estricto)) {
          motivos.push("además repite " + debilesVistos.join(" y "));
        }

        if (a.nota < notaMin) motivos.push("nota " + a.nota.toFixed(1) + ", por debajo de " + notaMin);

        if (motivos.length) {
          salida.push({
            num: p.num, nota: a.nota, estado: p.estado,
            cliente: c.nombre || c.correo || "(sin nombre)",
            total: p.total,
            motivo: motivos.join(" · "),
            motivos: motivos
          });
        }
      });

      return salida;
    });
  }

  /* --------------------------------------------------------------- fuera --- */
  window.credLocal = credLocal;
  window.credRed = credRed;
  window.credAnalizar = credAnalizar;
  window.credRecomendacion = credRecomendacion;
  window.credAutoCancelar = credAutoCancelar;
  window.credContexto = contexto;
  window.credLimpiarCache = function () { try { localStorage.removeItem(K_CACHE); } catch (e) {} };
  window.credDistancia = distancia;   // se usa en las pruebas
})();
