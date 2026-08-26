/* =============================================================
   TornaBox — main.js
   Todo vanilla, sin dependencias. El contenido vive en el HTML;
   este archivo solo lo enriquece (contadores, stock, checkout…).
   ============================================================= */
(function () {
  "use strict";

  var BRAND = window.__BRAND__ || {};
  var CAJAS = BRAND.cajas || {};
  var $ = function (sel, scope) { return (scope || document).querySelector(sel); };
  var $$ = function (sel, scope) { return Array.prototype.slice.call((scope || document).querySelectorAll(sel)); };
  function safe(fn, name) { try { fn(); } catch (e) { console.warn("[" + name + "]", e); } }

  function eur(n) {
    return n.toLocaleString("es-ES", { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + " €";
  }
  function num(n) { return Math.round(n).toLocaleString("es-ES"); }

  /* ---------- Nav: sombra al hacer scroll ---------- */
  function initNav() {
    var nav = $("[data-nav]");
    if (!nav) return;
    var onScroll = function () { nav.classList.toggle("is-scrolled", window.scrollY > 8); };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  /* ---------- Revelado de secciones ---------- */
  function initReveals() {
    var targets = $$(".reveal");
    if (!targets.length) return;
    if (!("IntersectionObserver" in window)) {
      targets.forEach(function (el) { el.classList.add("is-visible"); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add("is-visible"); io.unobserve(e.target); }
      });
    }, { threshold: 0.01, rootMargin: "0px 0px -4% 0px" });
    targets.forEach(function (el) { io.observe(el); });
    // Red de seguridad: a los 6 s, nada puede quedarse invisible
    setTimeout(function () {
      $$(".reveal:not(.is-visible)").forEach(function (el) { el.classList.add("is-visible"); });
    }, 6000);
  }

  /* ---------- Contadores animados (cajas entregadas) ---------- */
  function initCountUp() {
    var els = $$("[data-count]");
    if (!els.length) return;
    var reduced = matchMedia("(prefers-reduced-motion: reduce)").matches;
    els.forEach(function (el) {
      var target = parseInt(el.getAttribute("data-count"), 10);
      if (!target) return;
      if (reduced || !("IntersectionObserver" in window)) { el.textContent = num(target); return; }
      var done = false;
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
          if (!e.isIntersecting || done) return;
          done = true; io.unobserve(el);
          var t0 = performance.now(), dur = 1400;
          (function tick(t) {
            var p = Math.min(1, (t - t0) / dur);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = num(target * eased);
            if (p < 1) requestAnimationFrame(tick);
          })(t0);
        });
      }, { threshold: 0.1 });
      io.observe(el);
    });
  }

  /* ---------- Hora de corte: «sale hoy» honesto ---------- */
  function cutoffText() {
    var corte = BRAND.horaCorte || 18;
    var now = new Date();
    var day = now.getDay(); // 0 dom … 6 sáb
    var esLaborable = day >= 1 && day <= 5;
    if (esLaborable && now.getHours() < corte) {
      var restante = (corte * 60) - (now.getHours() * 60 + now.getMinutes());
      var h = Math.floor(restante / 60), m = restante % 60;
      var tiempo = h > 0 ? h + " h " + String(m).padStart(2, "0") + " min" : m + " min";
      return "Sale HOY si confirmas en " + tiempo;
    }
    if (day === 5 || day === 6 || day === 0) return "Pídelo ahora: sale el lunes a primera hora";
    return "Pídelo ahora: sale mañana a primera hora";
  }
  function initCutoff() {
    var els = $$("[data-cutoff-msg]");
    if (!els.length) return;
    var paint = function () {
      var txt = cutoffText();
      els.forEach(function (el) { el.textContent = txt; });
    };
    paint();
    setInterval(paint, 30000);
  }

  /* ---------- Barras de stock (escasez con datos del manifest) ---------- */
  function initStock() {
    $$("[data-stock]").forEach(function (el) {
      var caja = CAJAS[el.getAttribute("data-stock")];
      if (!caja || !caja.stockTotal) return;
      var resto = Math.max(0, caja.stockRestante);
      var pct = Math.max(4, Math.round((resto / caja.stockTotal) * 100));
      var fill = $(".stock-fill", el);
      var label = $(".stock-label", el);
      if (fill) requestAnimationFrame(function () { fill.style.width = pct + "%"; });
      if (label) label.textContent = resto > 0
        ? "Quedan " + resto + " de " + caja.stockTotal + " esta semana"
        : "Agotada esta semana — vuelve el lunes";
      if (pct <= 30) el.classList.add("is-low");
    });
  }

  /* ---------- CTA fija en móvil ---------- */
  function initStickyCta() {
    var bar = $("[data-sticky-cta]");
    if (!bar) return;
    var onScroll = function () { bar.classList.toggle("is-on", window.scrollY > 520); };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  /* ---------- Puntos de posición de los carruseles móviles ---------- */
  function initSnapDots() {
    $$("[data-snap]").forEach(function (car) {
      var dots = $('[data-dots="' + car.getAttribute("data-snap") + '"]');
      if (!dots || dots.children.length) return;
      var items = car.children;
      Array.prototype.forEach.call(items, function (item, i) {
        var b = document.createElement("button");
        b.type = "button";
        b.setAttribute("aria-label", "Ir a la tarjeta " + (i + 1));
        b.addEventListener("click", function () {
          item.scrollIntoView({ behavior: "smooth", inline: "start", block: "nearest" });
        });
        dots.appendChild(b);
      });
      var paint = function () {
        if (car.scrollWidth <= car.clientWidth + 8) { dots.hidden = true; return; }
        dots.hidden = false;
        var gap = parseFloat(getComputedStyle(car).columnGap) || 14;
        var i = Math.round(car.scrollLeft / (items[0].offsetWidth + gap));
        i = Math.max(0, Math.min(items.length - 1, i));
        Array.prototype.forEach.call(dots.children, function (d, j) {
          d.classList.toggle("is-on", j === i);
        });
      };
      car.addEventListener("scroll", function () { requestAnimationFrame(paint); }, { passive: true });
      window.addEventListener("resize", paint);
      paint();
    });
  }

  /* =============================================================
     CHECKOUT
     ============================================================= */
  function pedidoNum() {
    var y = new Date().getFullYear();
    var r = Math.floor(10000 + Math.random() * 89999);
    return "TB-" + y + "-" + r;
  }

  function initCheckout() {
    var form = $("[data-checkout-form]");
    if (!form) return;

    // 1. Caja elegida por URL (?caja=grande). Si no existe, la más pedida.
    var params = new URLSearchParams(location.search);
    var cajaId = params.get("caja");
    if (!CAJAS[cajaId]) cajaId = "grande";
    var caja = CAJAS[cajaId];

    // 2. Pintar el resumen (lateral, mini de móvil y barra de pago a la vez)
    $$("[data-r-thumb]").forEach(function (th) { th.style.setProperty("--tape", caja.color); });
    var set = function (sel, txt) { $$(sel).forEach(function (el) { el.textContent = txt; }); };
    set("[data-r-nombre]", caja.nombre);
    set("[data-r-meta]", caja.articulos + " · " + caja.etiqueta);
    $$("[data-r-valor]").forEach(function (el) {
      el.innerHTML = "Valor orientativo: <s>" + caja.valorMin + "–" + caja.valorMax + "&nbsp;€</s>";
    });

    var inputCaja = $("[name=caja]", form);
    if (inputCaja) inputCaja.value = cajaId;

    // 3. Totales según método de pago
    var totales = function () {
      var envio = caja.envioGratis ? 0 : (BRAND.envio ? BRAND.envio.estandar : 4.95);
      var metodoEl = $("input[name=pago]:checked", form);
      var metodo = metodoEl ? metodoEl.value : "reembolso";
      var recargo = metodo === "reembolso" ? (BRAND.envio ? BRAND.envio.recargoCOD : 2.95) : 0;
      return { envio: envio, recargo: recargo, metodo: metodo, total: caja.precio + envio + recargo };
    };

    var pintarTotales = function () {
      var t = totales();
      set("[data-r-precio]", eur(caja.precio));
      $$("[data-r-envio]").forEach(function (envioEl) {
        envioEl.textContent = t.envio === 0 ? "Gratis" : eur(t.envio);
        envioEl.classList.toggle("line-free", t.envio === 0);
      });
      $$("[data-r-recargo-row]").forEach(function (row) { row.hidden = t.recargo === 0; });
      set("[data-r-recargo]", eur(t.recargo));
      set("[data-r-total]", eur(t.total));
      set("[data-submit-label]", t.metodo === "tarjeta"
        ? "Pagar " + eur(t.total) + " con tarjeta"
        : "Confirmar pedido · " + eur(t.total));
      set("[data-submit-short]", t.metodo === "tarjeta" ? "Pagar con tarjeta" : "Confirmar pedido");
    };

    // 4. Radios de pago (clase de respaldo para navegadores sin :has)
    $$(".pay-option", form).forEach(function (opt) {
      var radio = $("input", opt);
      radio.addEventListener("change", function () {
        $$(".pay-option", form).forEach(function (o) { o.classList.remove("is-checked"); });
        opt.classList.add("is-checked");
        pintarTotales();
      });
      if (radio.checked) opt.classList.add("is-checked");
    });
    pintarTotales();

    // 5. Validación amable
    var marcar = function (input, mal) {
      input.classList.toggle("is-invalid", mal);
      var field = input.closest(".field");
      if (field) field.classList.toggle("has-error", mal);
    };
    $$("input[required]", form).forEach(function (input) {
      input.addEventListener("input", function () { marcar(input, false); });
      input.addEventListener("blur", function () { marcar(input, !input.checkValidity()); });
    });

    // 6. Envío del pedido
    form.addEventListener("submit", function (ev) {
      ev.preventDefault();
      var valido = true;
      $$("input[required]", form).forEach(function (input) {
        var mal = !input.checkValidity();
        marcar(input, mal);
        if (mal && valido) { input.focus(); valido = false; }
      });
      if (!valido) return;

      var t = totales();
      var numPedido = pedidoNum();
      var fd = new FormData(form);
      fd.set("num", numPedido);
      fd.set("total", t.total.toFixed(2));
      fd.set("caja_nombre", caja.nombre);
      fd.set("ajax", "1");

      var pedido = {
        num: numPedido, caja: cajaId, cajaNombre: caja.nombre,
        precio: caja.precio, envio: t.envio, recargo: t.recargo,
        total: t.total, pago: t.metodo, fecha: new Date().toISOString()
      };
      try { localStorage.setItem("tb_pedido", JSON.stringify(pedido)); } catch (e) {}

      $$(".btn-submit, .paybar button").forEach(function (b) { b.disabled = true; });
      set("[data-submit-label]", "Enviando pedido…");
      set("[data-submit-short]", "Enviando…");

      var irAGracias = function (n) {
        var q = "?p=" + encodeURIComponent(n || numPedido) + "&pago=" + t.metodo;
        // Con enlace de pago configurado, la tarjeta salta a la pasarela
        var link = (BRAND.pagoTarjeta || {})[cajaId];
        if (t.metodo === "tarjeta" && link) { location.href = link; return; }
        location.href = "gracias.html" + q;
      };

      // pedido.php envía el aviso por email; si no hay PHP (previa local),
      // el pedido queda igualmente registrado en el navegador y seguimos.
      fetch("pedido.php", { method: "POST", body: fd })
        .then(function (r) { return r.ok ? r.json() : Promise.reject(new Error("HTTP " + r.status)); })
        .then(function (json) { irAGracias(json && json.num); })
        .catch(function () { irAGracias(numPedido); });
    });
  }

  /* =============================================================
     GRACIAS
     ============================================================= */
  function initGracias() {
    var root = $("[data-gracias]");
    if (!root) return;
    var params = new URLSearchParams(location.search);
    var pedido = null;
    try { pedido = JSON.parse(localStorage.getItem("tb_pedido") || "null"); } catch (e) {}

    var numP = params.get("p") || (pedido && pedido.num) || pedidoNum();
    var set = function (sel, txt) { var el = $(sel); if (el) el.textContent = txt; };
    set("[data-g-num]", numP);

    if (pedido && pedido.cajaNombre) {
      set("[data-g-caja]", pedido.cajaNombre);
      set("[data-g-envio]", pedido.envio === 0 ? "Gratis" : eur(pedido.envio));
      set("[data-g-total]", eur(pedido.total));
      set("[data-g-pago]", pedido.pago === "tarjeta" ? "Tarjeta" : "Contra reembolso (+" + eur(pedido.recargo) + ")");
    } else {
      var res = $("[data-g-resumen]");
      if (res) res.hidden = true;
    }

    var pago = params.get("pago") || (pedido && pedido.pago) || "reembolso";
    var avisoTarjeta = $("[data-g-tarjeta]");
    var avisoCod = $("[data-g-cod]");
    if (avisoTarjeta) avisoTarjeta.hidden = pago !== "tarjeta";
    if (avisoCod) avisoCod.hidden = pago === "tarjeta";
  }

  /* ---------- Arranque ---------- */
  function boot() {
    safe(initNav, "initNav");
    safe(initReveals, "initReveals");
    safe(initCountUp, "initCountUp");
    safe(initCutoff, "initCutoff");
    safe(initStock, "initStock");
    safe(initStickyCta, "initStickyCta");
    safe(initSnapDots, "initSnapDots");
    safe(initCheckout, "initCheckout");
    safe(initGracias, "initGracias");
    document.documentElement.classList.add("is-ready");
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
