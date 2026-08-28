#!/usr/bin/env node
/* =============================================================================
   TornaBox — API de pedidos
   -----------------------------------------------------------------------------
   Node puro, SIN DEPENDENCIAS (http, https, fs, path, crypto, url).
   Los datos viven en un JSON con escritura atómica: se escribe a «.tmp» y se
   renombra encima, así un corte a media escritura nunca deja el fichero roto.

   Arranque:
     node server.js                 → escucha en 127.0.0.1:8787
     PORT=9000 node server.js
     ESTATICO=1 node server.js      → sirve también la tienda (solo para probar
                                      en local; en producción sirve nginx)

   En producción va con pm2 detrás de nginx, que la publica en /api:
     pm2 start /var/www/tornabox/server.js --name tornabox-api

   TOKEN DE ADMINISTRACIÓN
   -----------------------
   Todo lo que lee o modifica pedidos exige la cabecera «x-admin-token».
   Crear un pedido (lo hace la tienda) NO la exige.
   El token se genera solo la primera vez en datos/token.txt (chmod 600).
   Puedes fijarlo tú con la variable de entorno ADMIN_TOKEN.
   ========================================================================== */
"use strict";

const http = require("http");
const https = require("https");
const fs = require("fs");
const path = require("path");
const crypto = require("crypto");

/* ---------------------------------------------------------------- ajustes -- */
const PUERTO = Number(process.env.PORT || 8787);
const HOST = process.env.HOST || "127.0.0.1";
const RAIZ = __dirname;
const DIR_DATOS = process.env.DATOS || path.join(RAIZ, "datos");
const F_PEDIDOS = path.join(DIR_DATOS, "pedidos.json");
const F_CORREOS = path.join(DIR_DATOS, "correos.json");
const F_TOKEN = path.join(DIR_DATOS, "token.txt");
const DIR_ETIQUETAS = path.join(DIR_DATOS, "etiquetas");
const SERVIR_ESTATICO = process.env.ESTATICO === "1";
const ORIGEN = process.env.ORIGEN || "*";
const MAX_CUERPO = 256 * 1024;

/* Precios autoritativos. Lo que llegue del navegador NO se usa para cobrar.
   Si cambias un precio, cámbialo también en index.html, lib/manifest.js
   y pedido.php. */
const CAJAS = {
  inicio: { nombre: "Caja Inicio", precio: 34.95, envioGratis: false },
  grande: { nombre: "Caja Grande", precio: 59.95, envioGratis: true },
  tech: { nombre: "Caja Tech", precio: 89.95, envioGratis: true },
  xxl: { nombre: "Caja XXL Reventa", precio: 149.95, envioGratis: true }
};
const MEJORAS = {
  inicio: { a: "grande", precio: 19.95 },
  grande: { a: "tech", precio: 22.95 },
  tech: { a: "xxl", precio: 44.95 }
};
const ENVIO = 4.95;
const GRATIS_DESDE = 50.0;
const RECARGO_COD = 4.95;
const SEGURO = 4.95;

const ESTADOS = ["pendiente_pago", "recibido", "preparacion", "enviado", "entregado", "cancelado"];

/* ------------------------------------------------------------- utilidades -- */
function log(...a) {
  console.log(new Date().toISOString(), ...a);
}

function asegurarDirs() {
  fs.mkdirSync(DIR_DATOS, { recursive: true });
  fs.mkdirSync(DIR_ETIQUETAS, { recursive: true });
}

/** Escritura atómica: fichero temporal + rename. El rename es atómico en el
 *  mismo sistema de ficheros, así que o está el contenido viejo o el nuevo,
 *  nunca medio fichero. */
function escribirAtomico(destino, texto, modo) {
  const tmp = destino + ".tmp";
  fs.writeFileSync(tmp, texto, { encoding: "utf8", mode: modo || 0o644 });
  fs.renameSync(tmp, destino);
  if (modo) { try { fs.chmodSync(destino, modo); } catch (e) {} }
}

function leerJSON(fichero, porDefecto) {
  try {
    return JSON.parse(fs.readFileSync(fichero, "utf8"));
  } catch (e) {
    return porDefecto;
  }
}

function leerPedidos() {
  const d = leerJSON(F_PEDIDOS, null);
  if (d && Array.isArray(d.pedidos)) return d.pedidos;
  return [];
}

/* Node es de un solo hilo y aquí escribimos en síncrono, así que dos peticiones
   nunca se pisan a media escritura. */
function guardarPedidos(pedidos) {
  escribirAtomico(F_PEDIDOS, JSON.stringify({ pedidos: pedidos }, null, 2));
}

function token() {
  if (process.env.ADMIN_TOKEN) return process.env.ADMIN_TOKEN;
  try {
    const t = fs.readFileSync(F_TOKEN, "utf8").trim();
    if (t) return t;
  } catch (e) {}
  const nuevo = crypto.randomBytes(24).toString("hex");
  escribirAtomico(F_TOKEN, nuevo + "\n", 0o600);
  log("Token de administración generado en", F_TOKEN);
  return nuevo;
}
asegurarDirs();
const TOKEN = token();

/** Comparación en tiempo constante: evita adivinar el token midiendo tiempos. */
function tokenValido(recibido) {
  if (typeof recibido !== "string" || recibido.length === 0) return false;
  const a = Buffer.from(recibido);
  const b = Buffer.from(TOKEN);
  if (a.length !== b.length) return false;
  return crypto.timingSafeEqual(a, b);
}

function dinero(n) {
  return Math.round((Number(n) || 0) * 100) / 100;
}
function texto(v, max) {
  return String(v == null ? "" : v).replace(/[\r\n\t]+/g, " ").trim().slice(0, max || 200);
}

/* --------------------------------------------------------------- respuesta -- */
function cabecerasBase(res) {
  res.setHeader("Access-Control-Allow-Origin", ORIGEN);
  res.setHeader("Access-Control-Allow-Headers", "content-type, x-admin-token");
  res.setHeader("Access-Control-Allow-Methods", "GET, POST, PATCH, DELETE, OPTIONS");
  res.setHeader("X-Content-Type-Options", "nosniff");
  res.setHeader("Cache-Control", "no-store");
}
function json(res, codigo, cuerpo) {
  cabecerasBase(res);
  const txt = JSON.stringify(cuerpo);
  res.writeHead(codigo, { "Content-Type": "application/json; charset=utf-8" });
  res.end(txt);
}
function error(res, codigo, mensaje) {
  json(res, codigo, { ok: false, error: mensaje });
}

function leerCuerpo(req) {
  return new Promise((resolve, reject) => {
    let trozos = [];
    let bytes = 0;
    req.on("data", (c) => {
      bytes += c.length;
      if (bytes > MAX_CUERPO) { reject(new Error("cuerpo demasiado grande")); req.destroy(); return; }
      trozos.push(c);
    });
    req.on("end", () => {
      const crudo = Buffer.concat(trozos).toString("utf8");
      if (!crudo) return resolve({});
      const tipo = String(req.headers["content-type"] || "");
      try {
        if (tipo.indexOf("application/json") >= 0) return resolve(JSON.parse(crudo));
        if (tipo.indexOf("application/x-www-form-urlencoded") >= 0) {
          const o = {};
          new URLSearchParams(crudo).forEach((v, k) => { o[k] = v; });
          return resolve(o);
        }
        return resolve(JSON.parse(crudo));   // por si no manda cabecera
      } catch (e) {
        reject(new Error("cuerpo ilegible"));
      }
    });
    req.on("error", reject);
  });
}

/** ¿Es una IP de andar por casa (loopback o red privada)? Detrás de un proxy
 *  mal configurado TODOS los pedidos llegarían con 127.0.0.1, y la regla de
 *  «IP repetida» cancelaría la tienda entera. Por eso se detectan. */
function ipPrivada(ip) {
  if (!ip) return true;
  return /^(127\.|10\.|192\.168\.|169\.254\.|::1$|fc|fd)/i.test(ip)
    || /^172\.(1[6-9]|2\d|3[01])\./.test(ip);
}

/** IP real del cliente. Detrás de nginx el socket siempre es 127.0.0.1, así que
 *  la buena es la primera de X-Forwarded-For. Si no hay proxy, el socket. */
function ipDe(req) {
  const xff = String(req.headers["x-forwarded-for"] || "").split(",")[0].trim();
  if (xff && !ipPrivada(xff)) return xff;
  const ip = String(req.socket && req.socket.remoteAddress || "").replace(/^::ffff:/, "");
  return ipPrivada(ip) ? "" : ip;
}

/* ------------------------------------------------------------ los pedidos -- */
function numeroLibre(pedidos) {
  const anio = new Date().getFullYear();
  for (let i = 0; i < 50; i++) {
    const n = "TB-" + anio + "-" + crypto.randomInt(10000, 100000);
    if (!pedidos.some((p) => p.num === n)) return n;
  }
  return "TB-" + anio + "-" + Date.now().toString().slice(-5);
}

/** Recorre la escalera de mejora desde «desde» hasta «hasta» sumando escalones.
 *  Una mejora inalcanzable se ignora y se cobra la caja original. */
function aplicarMejora(desde, hasta) {
  if (!hasta || hasta === desde || !CAJAS[hasta]) return { id: desde, extra: 0 };
  let paso = desde, extra = 0, guarda = 0;
  while (paso !== hasta && MEJORAS[paso] && guarda++ < 6) {
    extra += MEJORAS[paso].precio;
    paso = MEJORAS[paso].a;
  }
  return paso === hasta ? { id: hasta, extra: extra } : { id: desde, extra: 0 };
}

/** Construye el pedido canónico. Los importes SIEMPRE se calculan aquí. */
function normalizarPedido(entrada, pedidos, ipPeticion) {
  const cajaId = CAJAS[entrada.caja] ? entrada.caja : "grande";
  const mejora = aplicarMejora(cajaId, entrada.mejora);
  const caja = CAJAS[mejora.id];
  const conSeguro = entrada.seguro === true || entrada.seguro === "1" || entrada.seguro === "on";
  const pago = entrada.pago === "reembolso" ? "reembolso" : "tarjeta";

  const precioCaja = dinero(CAJAS[cajaId].precio + mejora.extra);
  const lineas = [
    { id: mejora.id, nombre: caja.nombre, qty: 1, precio: precioCaja.toFixed(2), tipo: "caja" }
  ];
  if (conSeguro) {
    lineas.push({ id: "seguro", nombre: "Seguro de devolución (30 días)", qty: 1, precio: SEGURO.toFixed(2), tipo: "extra" });
  }

  const subtotal = dinero(lineas.reduce((s, l) => s + Number(l.precio) * l.qty, 0));
  const envio = (caja.envioGratis || precioCaja >= GRATIS_DESDE) ? 0 : ENVIO;
  const recargo = pago === "reembolso" ? RECARGO_COD : 0;
  const total = dinero(subtotal + envio + recargo);

  const c = entrada.cliente || entrada;
  // La IP de la conexión manda sobre la que diga el navegador (ipify): el
  // navegador la puede falsear, la conexión no. Pero si la conexión solo da
  // una IP privada (proxy sin X-Forwarded-For, pruebas en local), se usa la
  // de ipify antes que quedarse sin dato.
  const ipNavegador = texto(c.ip, 45);
  const ipCliente = ipPeticion || (ipPrivada(ipNavegador) ? "" : ipNavegador);

  let num = texto(entrada.num, 20);
  if (!/^TB-\d{4}-\d{5}$/.test(num) || pedidos.some((p) => p.num === num)) num = numeroLibre(pedidos);

  const estado = ESTADOS.indexOf(entrada.estado) >= 0
    ? entrada.estado
    : (pago === "tarjeta" ? "pendiente_pago" : "recibido");

  return {
    num: num,
    fecha: new Date().toISOString(),
    cliente: {
      nombre: texto(c.nombre, 120),
      correo: texto(c.correo || c.email, 160).toLowerCase(),
      telefono: texto(c.telefono, 30),
      direccion: texto(c.direccion, 160),
      numero: texto(c.numero, 20),
      piso: texto(c.piso, 20),
      planta: texto(c.planta, 20),
      cp: texto(c.cp, 10),
      ciudad: texto(c.ciudad || c.poblacion, 90),
      pueblo: texto(c.pueblo, 90),
      provincia: texto(c.provincia, 90),
      ip: ipCliente
    },
    notas: texto(entrada.notas, 300),
    lineas: lineas,
    unidades: lineas.filter((l) => l.tipo !== "extra").reduce((s, l) => s + l.qty, 0),
    subtotal: subtotal,
    envio: envio,
    recargo: recargo,
    total: total,
    pago: pago,
    envioTipo: envio === 0 ? "gratis" : "estandar",
    estado: estado,
    tracking: "",
    cajaBase: cajaId,
    mejorada: mejora.id !== cajaId
  };
}

/* Solo estos campos se pueden tocar desde el CRM. Ni importes ni cliente:
   si hiciera falta corregir un importe, se hace en el servidor. */
const CAMPOS_EDITABLES = ["estado", "tracking", "notasInternas", "etiqueta", "cancelacion"];

function parchear(pedido, patch) {
  Object.keys(patch || {}).forEach((k) => {
    if (CAMPOS_EDITABLES.indexOf(k) < 0) return;
    if (k === "estado" && ESTADOS.indexOf(patch[k]) < 0) return;
    pedido[k] = k === "cancelacion" ? patch[k] : texto(patch[k], 400);
  });
  return pedido;
}

/* ------------------------------------------------------ Correos (opcional) -- */
/* Las credenciales viven SOLO aquí, en datos/correos.json con chmod 600.
   El navegador nunca ve una contraseña: el CRM solo pide «haz el envío de X». */
function correosConfig() {
  return leerJSON(F_CORREOS, {
    endpoint: "https://preregistroenvios.correos.es/preregistroenvios",
    usuario: "", password: "", codCliente: "", codContrato: "",
    remNombre: "", remDireccion: "", remCp: "", remPoblacion: "", remProvincia: "",
    remTelefono: "", remCorreo: "", iban: ""
  });
}
/** Versión pública: nunca sale la contraseña, solo si está puesta. */
function correosConfigPublica() {
  const c = correosConfig();
  const out = Object.assign({}, c);
  delete out.password;
  out.tienePassword = Boolean(c.password);
  out.tieneIban = Boolean(c.iban);
  return out;
}
function guardarCorreosConfig(patch) {
  const actual = correosConfig();
  Object.keys(patch || {}).forEach((k) => {
    if (k === "tienePassword" || k === "tieneIban") return;
    // Contraseña vacía = «no la toques», para poder guardar sin reescribirla
    if (k === "password" && !patch[k]) return;
    actual[k] = texto(patch[k], 300);
  });
  escribirAtomico(F_CORREOS, JSON.stringify(actual, null, 2), 0o600);
  return correosConfigPublica();
}

function peticionHTTPS(url, opciones, cuerpo) {
  return new Promise((resolve) => {
    let u;
    try { u = new URL(url); } catch (e) { return resolve({ ok: false, error: "URL inválida" }); }
    const req = https.request({
      hostname: u.hostname,
      port: u.port || 443,
      path: u.pathname + u.search,
      method: opciones.method || "POST",
      headers: opciones.headers || {},
      timeout: 20000
    }, (res) => {
      const trozos = [];
      res.on("data", (c) => trozos.push(c));
      res.on("end", () => resolve({
        ok: res.statusCode >= 200 && res.statusCode < 300,
        estado: res.statusCode,
        cabeceras: res.headers,
        cuerpo: Buffer.concat(trozos)
      }));
    });
    req.on("timeout", () => { req.destroy(); resolve({ ok: false, error: "tiempo agotado" }); });
    req.on("error", (e) => resolve({ ok: false, error: e.message }));
    if (cuerpo) req.write(cuerpo);
    req.end();
  });
}

function escXML(s) {
  return String(s == null ? "" : s)
    .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;").replace(/'/g, "&apos;");
}

/* Sobre SOAP del preregistro de envíos de Correos. Está escrito contra su
   especificación publicada, pero NO se ha podido probar contra el servicio
   real sin credenciales: usa /correos/probar con las tuyas antes de confiar. */
function sobreSOAP(cfg, pedido, reembolso) {
  const c = pedido.cliente;
  return '<?xml version="1.0" encoding="UTF-8"?>'
    + '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pre="http://www.correos.es/iris6/services/preregistroenvios">'
    + "<soapenv:Header/><soapenv:Body><pre:PreregistroEnvio>"
    + "<pre:FechaOperacion>" + escXML(new Date().toISOString().slice(0, 10)) + "</pre:FechaOperacion>"
    + "<pre:CodEtiquetador>" + escXML(cfg.codCliente) + "</pre:CodEtiquetador>"
    + "<pre:NumEnvio>" + escXML(pedido.num) + "</pre:NumEnvio>"
    + "<pre:Remitente><pre:Nombre>" + escXML(cfg.remNombre) + "</pre:Nombre>"
    + "<pre:Direccion>" + escXML(cfg.remDireccion) + "</pre:Direccion>"
    + "<pre:Localidad>" + escXML(cfg.remPoblacion) + "</pre:Localidad>"
    + "<pre:Provincia>" + escXML(cfg.remProvincia) + "</pre:Provincia>"
    + "<pre:CP>" + escXML(cfg.remCp) + "</pre:CP>"
    + "<pre:Telefono>" + escXML(cfg.remTelefono) + "</pre:Telefono>"
    + "<pre:Email>" + escXML(cfg.remCorreo) + "</pre:Email></pre:Remitente>"
    + "<pre:Destinatario><pre:Nombre>" + escXML(c.nombre) + "</pre:Nombre>"
    + "<pre:Direccion>" + escXML([c.direccion, c.numero, c.piso].filter(Boolean).join(" ")) + "</pre:Direccion>"
    + "<pre:Localidad>" + escXML(c.ciudad) + "</pre:Localidad>"
    + "<pre:Provincia>" + escXML(c.provincia) + "</pre:Provincia>"
    + "<pre:CP>" + escXML(c.cp) + "</pre:CP>"
    + "<pre:Telefono>" + escXML(c.telefono) + "</pre:Telefono>"
    + "<pre:Email>" + escXML(c.correo) + "</pre:Email></pre:Destinatario>"
    + "<pre:Envio><pre:CodProducto>S0132</pre:CodProducto>"
    + "<pre:Referencia>" + escXML(pedido.num) + "</pre:Referencia>"
    + "<pre:Bultos>1</pre:Bultos>"
    + (reembolso
        ? "<pre:Reembolso><pre:Importe>" + escXML(pedido.total.toFixed(2)) + "</pre:Importe>"
          + "<pre:IBAN>" + escXML(cfg.iban) + "</pre:IBAN></pre:Reembolso>"
        : "")
    + "</pre:Envio></pre:PreregistroEnvio></soapenv:Body></soapenv:Envelope>";
}

/* --------------------------------------------------------------- estáticos -- */
const MIME = {
  ".html": "text/html; charset=utf-8", ".js": "text/javascript; charset=utf-8",
  ".css": "text/css; charset=utf-8", ".json": "application/json; charset=utf-8",
  ".svg": "image/svg+xml", ".webp": "image/webp", ".png": "image/png",
  ".jpg": "image/jpeg", ".woff2": "font/woff2", ".pdf": "application/pdf",
  ".txt": "text/plain; charset=utf-8", ".xml": "application/xml"
};
function servirEstatico(req, res, ruta) {
  let rel = decodeURIComponent(ruta.split("?")[0]);
  if (rel === "/" || rel === "") rel = "/index.html";
  const destino = path.join(RAIZ, path.normalize(rel).replace(/^(\.\.[/\\])+/, ""));
  if (!destino.startsWith(RAIZ)) { res.writeHead(403); return res.end("403"); }
  fs.readFile(destino, (err, buf) => {
    if (err) { res.writeHead(404, { "Content-Type": "text/plain" }); return res.end("404"); }
    res.writeHead(200, { "Content-Type": MIME[path.extname(destino)] || "application/octet-stream" });
    res.end(buf);
  });
}

/* ------------------------------------------------------------------ rutas -- */
async function router(req, res) {
  const u = new URL(req.url, "http://x");
  let ruta = u.pathname.replace(/\/+$/, "") || "/";
  if (ruta.startsWith("/api")) ruta = ruta.slice(4) || "/";   // nginx puede o no cortar /api

  if (req.method === "OPTIONS") { cabecerasBase(res); res.writeHead(204); return res.end(); }

  if (!ruta.startsWith("/pedidos") && !ruta.startsWith("/correos") && ruta !== "/salud" && ruta !== "/buscar") {
    if (SERVIR_ESTATICO) return servirEstatico(req, res, req.url);
    return error(res, 404, "No existe");
  }

  if (ruta === "/salud") return json(res, 200, { ok: true, servicio: "tornabox-api", pedidos: leerPedidos().length });

  const admin = tokenValido(req.headers["x-admin-token"]);

  /* --- crear pedido: ES PÚBLICO, lo llama la tienda --- */
  if (ruta === "/pedidos" && req.method === "POST") {
    let cuerpo;
    try { cuerpo = await leerCuerpo(req); } catch (e) { return error(res, 400, e.message); }
    const pedidos = leerPedidos();
    const pedido = normalizarPedido(cuerpo, pedidos, ipDe(req));
    pedidos.unshift(pedido);                       // el más nuevo, el primero
    guardarPedidos(pedidos);
    log("pedido nuevo", pedido.num, pedido.total + "€", pedido.pago, pedido.cliente.ip);
    return json(res, 201, { ok: true, pedido: pedido });
  }

  /* --- a partir de aquí, todo exige token --- */
  if (!admin) return error(res, 401, "Falta o no vale la cabecera x-admin-token");

  if (ruta === "/pedidos" && req.method === "GET") {
    return json(res, 200, { ok: true, pedidos: leerPedidos() });
  }

  if (ruta === "/pedidos" && req.method === "DELETE") {
    guardarPedidos([]);
    log("BORRADOS todos los pedidos");
    return json(res, 200, { ok: true, borrados: "todos" });
  }

  if (ruta === "/buscar" && req.method === "GET") {
    const q = String(u.searchParams.get("q") || "").toLowerCase().trim();
    if (!q) return json(res, 200, { ok: true, pedidos: [] });
    const hit = (p) => [p.num, p.cliente.nombre, p.cliente.correo, p.cliente.telefono,
      p.cliente.direccion, p.cliente.ciudad, p.cliente.cp, p.cliente.ip, p.tracking]
      .join(" ").toLowerCase().indexOf(q) >= 0;
    return json(res, 200, { ok: true, pedidos: leerPedidos().filter(hit) });
  }

  const mPedido = ruta.match(/^\/pedidos\/([A-Za-z0-9-]+)$/);
  if (mPedido) {
    const num = mPedido[1];
    const pedidos = leerPedidos();
    const i = pedidos.findIndex((p) => p.num === num);
    if (i < 0) return error(res, 404, "Pedido no encontrado");

    if (req.method === "GET") return json(res, 200, { ok: true, pedido: pedidos[i] });

    if (req.method === "PATCH") {
      let cuerpo;
      try { cuerpo = await leerCuerpo(req); } catch (e) { return error(res, 400, e.message); }
      parchear(pedidos[i], cuerpo);
      guardarPedidos(pedidos);
      return json(res, 200, { ok: true, pedido: pedidos[i] });
    }

    if (req.method === "DELETE") {
      const fuera = pedidos.splice(i, 1)[0];
      guardarPedidos(pedidos);
      log("pedido borrado", fuera.num);
      return json(res, 200, { ok: true, borrado: fuera.num });
    }
  }

  /* ------------------------------ Correos ------------------------------ */
  if (ruta === "/correos/config") {
    if (req.method === "GET") return json(res, 200, { ok: true, config: correosConfigPublica() });
    if (req.method === "POST") {
      let cuerpo;
      try { cuerpo = await leerCuerpo(req); } catch (e) { return error(res, 400, e.message); }
      return json(res, 200, { ok: true, config: guardarCorreosConfig(cuerpo) });
    }
  }

  if (ruta === "/correos/probar" && req.method === "POST") {
    const cfg = correosConfig();
    if (!cfg.usuario || !cfg.password) return error(res, 400, "Faltan usuario y contraseña de Correos");
    const r = await peticionHTTPS(cfg.endpoint, {
      method: "POST",
      headers: {
        "Content-Type": "text/xml; charset=utf-8",
        "Authorization": "Basic " + Buffer.from(cfg.usuario + ":" + cfg.password).toString("base64"),
        "SOAPAction": ""
      }
    }, '<?xml version="1.0"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body/></soapenv:Envelope>');
    // Se devuelve el estado y el principio de la respuesta tal cual para que
    // se pueda diagnosticar. Nunca se devuelve la credencial.
    return json(res, 200, {
      ok: true,
      alcanzado: r.ok || Boolean(r.estado),
      estado: r.estado || null,
      error: r.error || null,
      respuesta: r.cuerpo ? r.cuerpo.toString("utf8").slice(0, 600) : ""
    });
  }

  if (ruta === "/correos/envio" && req.method === "POST") {
    let cuerpo;
    try { cuerpo = await leerCuerpo(req); } catch (e) { return error(res, 400, e.message); }
    const pedidos = leerPedidos();
    const i = pedidos.findIndex((p) => p.num === texto(cuerpo.num, 20));
    if (i < 0) return error(res, 404, "Pedido no encontrado");
    const pedido = pedidos[i];
    const cfg = correosConfig();
    if (!cfg.usuario || !cfg.password) return error(res, 400, "Faltan las credenciales de Correos");

    // Sin IBAN, el repartidor entrega y no cobra: se pierde el importe.
    if (pedido.pago === "reembolso" && !cfg.iban) {
      return error(res, 409, "Es contra reembolso y no hay IBAN configurado: no se genera la etiqueta "
        + "porque Correos entregaría el paquete sin cobrar los " + pedido.total.toFixed(2) + " €.");
    }

    const r = await peticionHTTPS(cfg.endpoint, {
      method: "POST",
      headers: {
        "Content-Type": "text/xml; charset=utf-8",
        "Authorization": "Basic " + Buffer.from(cfg.usuario + ":" + cfg.password).toString("base64"),
        "SOAPAction": "PreregistroEnvio"
      }
    }, sobreSOAP(cfg, pedido, pedido.pago === "reembolso"));

    if (!r.ok) {
      return error(res, 502, "Correos respondió " + (r.estado || r.error || "sin respuesta"));
    }
    const txt = r.cuerpo.toString("utf8");
    const mCod = txt.match(/<[^>]*CodEnvio[^>]*>([^<]+)</i) || txt.match(/<[^>]*NumEnvio[^>]*>([^<]+)</i);
    const mPdf = txt.match(/<[^>]*Etiqueta[^>]*>([A-Za-z0-9+/=\s]{200,})</i);
    if (!mCod) return error(res, 502, "Correos no devolvió número de envío. Respuesta: " + txt.slice(0, 300));

    pedido.tracking = mCod[1].trim();
    if (mPdf) {
      // Se guarda el PDF para poder reimprimir la etiqueta sin volver a pedirla
      const pdf = Buffer.from(mPdf[1].replace(/\s+/g, ""), "base64");
      fs.writeFileSync(path.join(DIR_ETIQUETAS, pedido.num + ".pdf"), pdf);
      pedido.etiqueta = pedido.num + ".pdf";
    }
    pedido.estado = "preparacion";
    guardarPedidos(pedidos);
    log("envío generado", pedido.num, pedido.tracking);
    return json(res, 200, { ok: true, pedido: pedido });
  }

  if (ruta === "/correos/etiqueta" && req.method === "GET") {
    const num = texto(u.searchParams.get("num"), 20);
    const f = path.join(DIR_ETIQUETAS, num + ".pdf");
    if (!f.startsWith(DIR_ETIQUETAS) || !fs.existsSync(f)) return error(res, 404, "No hay etiqueta guardada");
    cabecerasBase(res);
    res.writeHead(200, { "Content-Type": "application/pdf", "Content-Disposition": 'inline; filename="' + num + '.pdf"' });
    return res.end(fs.readFileSync(f));
  }

  if (ruta === "/correos/anular" && req.method === "POST") {
    let cuerpo;
    try { cuerpo = await leerCuerpo(req); } catch (e) { return error(res, 400, e.message); }
    const pedidos = leerPedidos();
    const i = pedidos.findIndex((p) => p.num === texto(cuerpo.num, 20));
    if (i < 0) return error(res, 404, "Pedido no encontrado");
    const cfg = correosConfig();
    const r = await peticionHTTPS(cfg.endpoint, {
      method: "POST",
      headers: {
        "Content-Type": "text/xml; charset=utf-8",
        "Authorization": "Basic " + Buffer.from(cfg.usuario + ":" + cfg.password).toString("base64"),
        "SOAPAction": "AnulacionEnvio"
      }
    }, '<?xml version="1.0"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">'
      + "<soapenv:Body><AnulacionEnvio><CodEnvio>" + escXML(pedidos[i].tracking) + "</CodEnvio></AnulacionEnvio></soapenv:Body></soapenv:Envelope>");
    if (!r.ok) return error(res, 502, "Correos respondió " + (r.estado || r.error));
    pedidos[i].tracking = "";
    pedidos[i].etiqueta = "";
    guardarPedidos(pedidos);
    return json(res, 200, { ok: true, pedido: pedidos[i] });
  }

  if (ruta === "/correos/seguimiento" && req.method === "GET") {
    const codigo = texto(u.searchParams.get("codigo"), 40);
    if (!codigo) return error(res, 400, "Falta el código");
    const r = await peticionHTTPS(
      "https://api1.correos.es/digital-services/searchengines/api/v1/?text=" + encodeURIComponent(codigo) + "&language=ES",
      { method: "GET", headers: { "Accept": "application/json" } });
    return json(res, 200, {
      ok: true, estado: r.estado || null, error: r.error || null,
      respuesta: r.cuerpo ? r.cuerpo.toString("utf8").slice(0, 4000) : ""
    });
  }

  return error(res, 404, "Ruta no encontrada: " + ruta);
}

/* ------------------------------------------------------------------ arranque */
if (!fs.existsSync(F_PEDIDOS)) guardarPedidos([]);

const servidor = http.createServer((req, res) => {
  router(req, res).catch((e) => {
    log("ERROR", e && e.stack ? e.stack : e);
    try { error(res, 500, "Error interno"); } catch (x) {}
  });
});

servidor.listen(PUERTO, HOST, () => {
  log("API de TornaBox escuchando en http://" + HOST + ":" + PUERTO);
  log("Datos en " + DIR_DATOS);
  if (!process.env.ADMIN_TOKEN) log("Token de administración en " + F_TOKEN);
  if (SERVIR_ESTATICO) log("Sirviendo también la tienda desde " + RAIZ + " (solo para pruebas)");
});
