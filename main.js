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
  function escHTML(s) {
    return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
  }

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

  /* ---------- Entrega con fecha, estilo «recíbelo mañana» ---------- */
  function entregaHTML() {
    var corte = BRAND.horaCorte || 18;
    var now = new Date();
    var esLab = function (d) { return d.getDay() >= 1 && d.getDay() <= 5; };
    var sale = new Date(now);
    var saleHoy = esLab(now) && now.getHours() < corte;
    if (!saleHoy) { do { sale.setDate(sale.getDate() + 1); } while (!esLab(sale)); }
    var entrega = new Date(sale);
    do { entrega.setDate(entrega.getDate() + 1); } while (!esLab(entrega));

    var fecha = entrega.toLocaleDateString("es-ES", { weekday: "long", day: "numeric", month: "long" });
    var manana = new Date(now); manana.setDate(manana.getDate() + 1);
    var etiqueta = entrega.toDateString() === manana.toDateString() ? "mañana, " + fecha : "el " + fecha;

    if (saleHoy) {
      var restante = (corte * 60) - (now.getHours() * 60 + now.getMinutes());
      var h = Math.floor(restante / 60), m = restante % 60;
      var tiempo = h > 0 ? h + " h " + String(m).padStart(2, "0") + " min" : m + " min";
      return "Recíbelo <b>" + etiqueta + "</b> si lo pides en las próximas <b>" + tiempo + "</b>";
    }
    return "Recíbelo <b>" + etiqueta + "</b> — pídelo ahora y sale en el primer reparto";
  }
  function initEntrega() {
    var els = $$("[data-entrega-msg]");
    if (!els.length) return;
    var paint = function () {
      var html = entregaHTML();
      els.forEach(function (el) { el.innerHTML = html; });
    };
    paint();
    setInterval(paint, 30000);
  }

  /* ---------- Seguimiento del pedido (localizador de Correos) ---------- */
  function initSeguimiento() {
    var form = $("[data-track-form]");
    if (!form) return;
    form.addEventListener("submit", function (ev) {
      ev.preventDefault();
      var v = ($("input", form).value || "").trim();
      if (!v) return;
      window.open("https://www.correos.es/es/es/herramientas/localizador/envios/detalle?tracking-number=" + encodeURIComponent(v), "_blank", "noopener");
    });
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
     PÁGINA DE PRODUCTO
     ============================================================= */
  function initProducto() {
    if (!$(".pdp-main")) return;
    var params = new URLSearchParams(window.__PV_SEARCH__ || location.search);
    var id = params.get("id");
    if (!CAJAS[id]) id = "grande";
    var caja = CAJAS[id];
    var resenas = caja.resenas || [];
    var conFoto = resenas.filter(function (r) { return r.f; }).length;
    var media = resenas.length
      ? Math.round((resenas.reduce(function (a, r) { return a + r.e; }, 0) / resenas.length) * 10) / 10
      : 5;
    var mediaTxt = String(media).replace(".", ",");
    if (mediaTxt.indexOf(",") < 0) mediaTxt += ",0";

    document.title = caja.nombre + " · TornaBox";
    var set = function (sel, txt) { $$(sel).forEach(function (el) { el.textContent = txt; }); };
    $$("[data-p-thumb]").forEach(function (t) { t.style.setProperty("--tape", caja.color); });
    set("[data-p-etiqueta]", caja.etiqueta);
    set("[data-p-nombre]", caja.nombre);
    $$("[data-p-sticker]").forEach(function (el) {
      el.innerHTML = "Valor de hasta <b>" + caja.valorMax + "&nbsp;€</b>";
    });
    set("[data-p-hasta]", "hasta " + caja.valorMax + " €");
    set("[data-p-ahorro]", "Ahorras hasta " + Math.round(caja.valorMax - caja.precio) + " €");
    set("[data-p-barhasta]", "Valor de hasta " + caja.valorMax + " €");
    set("[data-p-precio]", eur(caja.precio));
    set("[data-p-claim]", caja.claim || "");
    $$("[data-p-envio]").forEach(function (el) {
      el.classList.toggle("is-free", caja.envioGratis);
      var cfg = BRAND.envio || {};
      el.innerHTML = '<svg class="ic"><use href="#i-truck"/></svg> '
        + (caja.envioGratis
            ? "Envío gratis · 24/48&nbsp;h con Correos"
            : "Envío " + eur(cfg.estandar || 4.95) + " · GRATIS desde " + (cfg.gratisDesde || 50) + " €");
    });
    $$("[data-p-ratingtxt]").forEach(function (el) {
      el.innerHTML = "<b>" + mediaTxt + "</b> · " + resenas.length + " valoraciones" + (conFoto ? ", " + conFoto + " con foto" : "");
    });
    $$("[data-p-resenasavg]").forEach(function (el) {
      el.innerHTML = "<b>" + mediaTxt + " sobre 5</b> · " + resenas.length + " valoraciones" + (conFoto ? " · " + conFoto + " con foto" : "");
    });
    $$("[data-p-puntos]").forEach(function (ul) {
      ul.innerHTML = (caja.puntos || []).map(function (p) {
        return '<li><svg class="ic ok"><use href="#i-check"/></svg> ' + escHTML(p) + "</li>";
      }).join("");
    });
    $$("[data-p-categorias]").forEach(function (ul) {
      ul.innerHTML = (caja.categorias || []).map(function (c) { return "<li>" + escHTML(c) + "</li>"; }).join("");
    });
    $$("[data-p-cta]").forEach(function (a) { a.href = "checkout.html?caja=" + id; });
    $$("[data-stock]").forEach(function (el) { el.setAttribute("data-stock", id); });

    // Reseñas con foto
    $$("[data-p-resenas]").forEach(function (grid) {
      grid.innerHTML = resenas.map(function (r) {
        var estrellas = "★★★★★".slice(0, r.e) + '<span class="star-off">' + "★★★★★".slice(0, 5 - r.e) + "</span>";
        return '<figure class="resena">'
          + (r.f ? '<img src="' + escHTML(r.f) + '" alt="Foto de la reseña de ' + escHTML(r.n) + '" loading="lazy" decoding="async">' : "")
          + '<div class="resena-body">'
          + '<p class="stars-line" aria-label="' + r.e + ' de 5">' + estrellas + "</p>"
          + '<p class="resena-head">' + escHTML(r.n)
          + ' <span class="verificada"><svg class="ic"><use href="#i-check"/></svg> Compra verificada</span></p>'
          + '<p class="resena-texto">' + escHTML(r.t) + "</p>"
          + "</div></figure>";
      }).join("");
    });

    // Las otras tres cajas
    $$("[data-p-otras]").forEach(function (grid) {
      grid.innerHTML = Object.keys(CAJAS).filter(function (k) { return k !== id; }).map(function (k) {
        var c = CAJAS[k];
        return '<a class="otra" href="producto.html?id=' + k + '">'
          + '<svg style="--tape:' + c.color + '" aria-hidden="true"><use href="#box-mini"/></svg>'
          + '<span class="otra-txt"><b>' + escHTML(c.nombre) + "</b>"
          + "<span>" + escHTML(c.articulos) + " · hasta " + c.valorMax + " € · " + eur(c.precio) + "</span></span>"
          + '<svg class="ic"><use href="#i-arrow"/></svg></a>';
      }).join("");
    });

    // Datos estructurados del producto
    try {
      var ld = {
        "@context": "https://schema.org", "@type": "Product",
        name: caja.nombre, description: caja.claim, sku: id,
        brand: { "@type": "Brand", name: BRAND.nombre || "TornaBox" },
        offers: {
          "@type": "Offer", priceCurrency: "EUR", price: caja.precio.toFixed(2),
          availability: caja.stockRestante > 0 ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
          itemCondition: "https://schema.org/RefurbishedCondition"
        }
      };
      if (resenas.length) {
        ld.aggregateRating = { "@type": "AggregateRating", ratingValue: media, reviewCount: resenas.length, bestRating: 5, worstRating: 1 };
      }
      var s = document.createElement("script");
      s.type = "application/ld+json";
      s.textContent = JSON.stringify(ld);
      document.head.appendChild(s);
    } catch (e) {}
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
    var baseId = params.get("caja");
    if (!CAJAS[baseId]) baseId = "grande";
    var MEJORAS = BRAND.mejoras || {};
    var cfgEnvio = BRAND.envio || {};
    var finalId = baseId;               // caja tras aplicar mejoras
    var caja = CAJAS[finalId];

    // Escalones de mejora recorridos desde la caja original hasta la actual
    function pasosHasta(destino) {
      var pasos = [], id = baseId, guarda = 0;
      while (id !== destino && MEJORAS[id] && guarda++ < 6) {
        pasos.push(MEJORAS[id]);
        id = MEJORAS[id].a;
      }
      return id === destino ? pasos : [];
    }
    // Lo que cuesta la caja actual: precio base + los escalones pagados
    function precioCaja() {
      return pasosHasta(finalId).reduce(function (s, m) { return s + m.precio; },
                                        CAJAS[baseId].precio);
    }

    var set = function (sel, txt) { $$(sel).forEach(function (el) { el.textContent = txt; }); };

    // 2. Pintar la caja en el resumen (lateral, mini de móvil y barra de pago)
    function pintarCaja() {
      caja = CAJAS[finalId];
      $$("[data-r-thumb]").forEach(function (th) { th.style.setProperty("--tape", caja.color); });
      set("[data-r-nombre]", caja.nombre);
      set("[data-r-meta]", caja.articulos + " · " + caja.etiqueta);
      $$("[data-r-valor]").forEach(function (el) {
        el.innerHTML = "Valor de hasta <s>" + caja.valorMax + "&nbsp;€</s>";
      });
      var inputCaja = $("[name=caja]", form);
      if (inputCaja) inputCaja.value = baseId;
      var inputMejora = $("[name=mejora]", form);
      if (inputMejora) inputMejora.value = (finalId === baseId ? "" : finalId);
    }

    // 3. La oferta de mejora: subir a la siguiente caja pagando la diferencia
    //    con descuento. Al aceptarla se ofrece el siguiente escalón.
    function pintarMejora() {
      var caja0 = CAJAS[baseId];
      var salto = MEJORAS[finalId];
      var panel = $("[data-mejora]");
      var vuelta = $("[data-mejora-undo]");
      if (!panel) return;

      // ¿Ha mejorado ya? Enseñamos de dónde viene y cómo deshacerlo.
      if (vuelta) {
        vuelta.hidden = (finalId === baseId);
        if (finalId !== baseId) {
          var pagado = precioCaja() - caja0.precio;
          $("[data-mejora-hecho]", vuelta).innerHTML =
            "Has mejorado a la <b>" + escHTML(caja.nombre) + "</b> por " + eur(pagado) + " más.";
        }
      }

      if (!salto || !CAJAS[salto.a]) {           // ya está en la caja más grande
        panel.hidden = true;
        return;
      }
      panel.hidden = false;
      var destino = CAJAS[salto.a];
      var normal = destino.precio - caja.precio; // lo que costaría subir sin oferta
      var ahorro = normal - salto.precio;

      set("[data-mejora-titulo]", "Pasa a la " + destino.nombre);
      set("[data-mejora-precio]", "+" + eur(salto.precio));
      $$("[data-mejora-antes]").forEach(function (el) {
        el.textContent = "+" + eur(normal);
        el.hidden = ahorro <= 0;
      });
      set("[data-mejora-ahorro]", ahorro > 0 ? "Ahorras " + eur(ahorro) : "");

      var gana = [];
      gana.push("<b>" + escHTML(destino.articulos) + "</b> en vez de " + escHTML(caja.articulos));
      gana.push("Valor de hasta <b>" + destino.valorMax + "&nbsp;€</b> (+" + (destino.valorMax - caja.valorMax) + "&nbsp;€ más)");
      if (destino.envioGratis && !caja.envioGratis) gana.push("<b>Envío GRATIS</b> incluido");
      gana.push(escHTML(destino.etiqueta));
      $$("[data-mejora-gana]").forEach(function (ul) {
        ul.innerHTML = gana.map(function (g) {
          return '<li><svg class="ic ok"><use href="#i-check"/></svg> ' + g + "</li>";
        }).join("");
      });
      set("[data-mejora-btn]", "Sí, quiero la " + destino.nombre);
    }

    // 4. Totales: caja (con mejoras), envío gratis desde 50 €, seguro y pago
    var totales = function () {
      var seguroEl = $("input[name=seguro]", form);
      var subtotal = precioCaja();
      var gratisDesde = cfgEnvio.gratisDesde || 50;
      var envio = (caja.envioGratis || subtotal >= gratisDesde) ? 0 : (cfgEnvio.estandar || 4.95);
      var metodoEl = $("input[name=pago]:checked", form);
      var metodo = metodoEl ? metodoEl.value : "tarjeta";
      var recargo = metodo === "reembolso" ? (cfgEnvio.recargoCOD || 4.95) : 0;
      var seguro = seguroEl && seguroEl.checked ? (cfgEnvio.seguro || 4.95) : 0;
      return { subtotal: subtotal, envio: envio, recargo: recargo, seguro: seguro,
               metodo: metodo, total: subtotal + envio + recargo + seguro };
    };

    var pintarTotales = function () {
      var t = totales();
      set("[data-r-cajalabel]", finalId === baseId ? "Caja" : "Caja mejorada");
      set("[data-r-precio]", eur(t.subtotal));
      $$("[data-r-envio]").forEach(function (envioEl) {
        envioEl.textContent = t.envio === 0 ? "Gratis" : eur(t.envio);
        envioEl.classList.toggle("line-free", t.envio === 0);
      });
      // Aviso «te falta X para el envío gratis» (solo cuando el envío se cobra)
      $$("[data-r-freehint]").forEach(function (row) {
        row.hidden = t.envio === 0;
        var falta = (cfgEnvio.gratisDesde || 50) - t.subtotal;
        if (!row.hidden) row.textContent = "Te faltan " + eur(falta) + " para el envío GRATIS — con la mejora de abajo ya lo tienes";
      });
      $$("[data-r-seguro-row]").forEach(function (row) { row.hidden = t.seguro === 0; });
      set("[data-r-seguro]", eur(t.seguro));
      $$("[data-r-recargo-row]").forEach(function (row) { row.hidden = t.recargo === 0; });
      set("[data-r-recargo]", eur(t.recargo));
      set("[data-r-total]", eur(t.total));
      set("[data-submit-label]", t.metodo === "tarjeta"
        ? "Pagar " + eur(t.total) + " con tarjeta"
        : "Confirmar pedido · " + eur(t.total));
      set("[data-submit-short]", t.metodo === "tarjeta" ? "Pagar con tarjeta" : "Confirmar pedido");
    };

    function repintar() { pintarCaja(); pintarMejora(); pintarTotales(); }

    // Aceptar la mejora sube un escalón; «volver» deshace todos
    $$("[data-mejora-btn]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var salto = MEJORAS[finalId];
        if (!salto || !CAJAS[salto.a]) return;
        finalId = salto.a;
        repintar();
        var panel = $("[data-mejora]");
        if (panel && !panel.hidden) panel.classList.add("is-nuevo");
        setTimeout(function () { if (panel) panel.classList.remove("is-nuevo"); }, 700);
      });
    });
    $$("[data-mejora-reset]").forEach(function (btn) {
      btn.addEventListener("click", function () { finalId = baseId; repintar(); });
    });

    // 5. Radios de pago (clase de respaldo para navegadores sin :has)
    $$(".pay-option:not(.extra-option)", form).forEach(function (opt) {
      var radio = $("input", opt);
      radio.addEventListener("change", function () {
        $$(".pay-option:not(.extra-option)", form).forEach(function (o) { o.classList.remove("is-checked"); });
        opt.classList.add("is-checked");
        pintarTotales();
      });
      if (radio.checked) opt.classList.add("is-checked");
    });
    // Extra opcional: seguro de devolución
    $$(".extra-option", form).forEach(function (opt) {
      var cb = $("input", opt);
      cb.addEventListener("change", function () {
        opt.classList.toggle("is-checked", cb.checked);
        pintarTotales();
      });
    });
    repintar();

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
        mejorada: finalId !== baseId, precio: t.subtotal, envio: t.envio,
        recargo: t.recargo, seguro: t.seguro,
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
      set("[data-g-caja]", pedido.cajaNombre + (pedido.unidades === 2 ? " ×2" : ""));
      set("[data-g-envio]", pedido.envio === 0 ? "Gratis" : eur(pedido.envio));
      set("[data-g-total]", eur(pedido.total));
      set("[data-g-pago]", pedido.pago === "tarjeta" ? "Tarjeta (sin recargo)" : "Contra reembolso (+" + eur(pedido.recargo) + ")");
      var segRow = $("[data-g-seguro-row]");
      if (segRow) segRow.hidden = !pedido.seguro;
      set("[data-g-seguro]", pedido.seguro ? eur(pedido.seguro) : "");
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
    safe(initEntrega, "initEntrega");
    safe(initSeguimiento, "initSeguimiento");
    safe(initProducto, "initProducto"); // antes que initStock: fija el data-stock de la caja
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
