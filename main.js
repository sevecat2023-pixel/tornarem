(function () {
  "use strict";
  /* ===========================================================
     TORNAREM · Lotes de devoluciones — comportamiento
     Un solo fichero, sin módulos: funciona abriendo index.html con
     doble clic, en Hostinger y en cualquier hosting estático.
     Todo el contenido está en el HTML; aquí sólo se añade el
     carrito, las fichas, el checkout y los pequeños efectos.
     =========================================================== */

  var T = window.__TIENDA__ || { lotes: [], contacto: {}, envio: {}, contrarreembolso: {} };
  var LOTES = {};
  (T.lotes || []).forEach(function (l) { LOTES[l.id] = l; });

  var reduced = matchMedia("(prefers-reduced-motion: reduce)").matches;
  var $ = function (sel, scope) { return (scope || document).querySelector(sel); };
  var $$ = function (sel, scope) { return Array.prototype.slice.call((scope || document).querySelectorAll(sel)); };
  var escHTML = function (s) {
    return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
    });
  };
  function safe(fn, name) { try { fn(); } catch (e) { console.warn("[" + name + "]", e); } }

  /* Dinero a la española, con punto de millar siempre: 1.290 € / 84,18 €
     (Intl en es-ES no agrupa los números de cuatro cifras y en una tienda
     queda raro ver «1290 €» junto a «2.640 €»). */
  function eur(n) {
    n = Math.round((Number(n) || 0) * 100) / 100;
    var neg = n < 0; n = Math.abs(n);
    var entero = Math.floor(n), cents = Math.round((n - entero) * 100);
    var s = String(entero).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    if (cents) s += "," + (cents < 10 ? "0" : "") + cents;
    return (neg ? "−" : "") + s + " €";
  }
  function pct(l) { return Math.round((1 - l.precio / l.pvp) * 100); }

  /* Recargo del contrarreembolso: porcentaje con mínimo */
  function recargoCOD(subtotal) {
    var c = T.contrarreembolso || {};
    var p = Number(c.porcentaje) || 0, min = Number(c.minimo) || 0;
    if (subtotal <= 0) return 0;
    return Math.max(min, Math.round(subtotal * p) / 100);
  }

  /* Fecha de entrega prevista: corte a las 14:00, sólo laborables */
  function fechaEntrega(esPale) {
    var corte = Number((T.envio || {}).horaCorte) || 14;
    var d = new Date();
    var laborable = function (x) { var w = x.getDay(); return w >= 1 && w <= 5; };
    var siguiente = function (x) { var y = new Date(x); do { y.setDate(y.getDate() + 1); } while (!laborable(y)); return y; };
    var salida = (laborable(d) && d.getHours() < corte) ? d : siguiente(d);
    var entrega = siguiente(salida);
    if (esPale) entrega = siguiente(entrega);
    return entrega;
  }
  function fechaLarga(d) {
    try { return d.toLocaleDateString("es-ES", { weekday: "long", day: "numeric", month: "long" }); }
    catch (_) { return d.toLocaleDateString(); }
  }

  /* -------------------------------------------------------------
     Carrito (localStorage)
     ------------------------------------------------------------- */
  var CART_KEY = "tornarem_cart_v1";
  var cart = {
    items: {},
    load: function () {
      try {
        var raw = localStorage.getItem(CART_KEY);
        var data = raw ? JSON.parse(raw) : {};
        this.items = {};
        var self = this;
        Object.keys(data.items || {}).forEach(function (id) {
          var l = LOTES[id]; var q = parseInt(data.items[id], 10);
          if (l && q > 0) self.items[id] = Math.min(q, l.stock || 99);
        });
      } catch (_) { this.items = {}; }
    },
    save: function () {
      try { localStorage.setItem(CART_KEY, JSON.stringify({ items: this.items, t: Date.now() })); } catch (_) {}
      document.dispatchEvent(new CustomEvent("cart:change"));
    },
    add: function (id, qty) {
      var l = LOTES[id]; if (!l) return false;
      var cur = this.items[id] || 0;
      var next = Math.min(cur + (qty || 1), l.stock || 99);
      if (next === cur) return false;
      this.items[id] = next; this.save(); return true;
    },
    set: function (id, qty) {
      var l = LOTES[id]; if (!l) return;
      qty = Math.max(0, Math.min(parseInt(qty, 10) || 0, l.stock || 99));
      if (qty === 0) delete this.items[id]; else this.items[id] = qty;
      this.save();
    },
    remove: function (id) { delete this.items[id]; this.save(); },
    clear: function () { this.items = {}; this.save(); },
    lines: function () {
      var self = this;
      return Object.keys(this.items).map(function (id) {
        var l = LOTES[id]; var q = self.items[id];
        return { lote: l, qty: q, total: l.precio * q };
      });
    },
    count: function () { var n = 0; for (var k in this.items) n += this.items[k]; return n; },
    subtotal: function () { return this.lines().reduce(function (s, x) { return s + x.total; }, 0); },
    hasPale: function () { return this.lines().some(function (x) { return /pal[eé]/i.test(x.lote.formato || ""); }); }
  };
  cart.load();

  /* -------------------------------------------------------------
     Avisos (toast)
     ------------------------------------------------------------- */
  var toastTimer;
  function toast(html, ms) {
    var el = $("[data-toast]"); if (!el) return;
    el.innerHTML = html;
    el.classList.add("is-on");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { el.classList.remove("is-on"); }, ms || 3200);
  }

  /* -------------------------------------------------------------
     Cabecera: menú móvil y contador del carrito
     ------------------------------------------------------------- */
  function initNav() {
    var btn = $("[data-menu-toggle]"), menu = $("[data-menu]");
    if (btn && menu) {
      btn.addEventListener("click", function () {
        var open = menu.classList.toggle("is-open");
        btn.setAttribute("aria-expanded", open ? "true" : "false");
        btn.setAttribute("aria-label", open ? "Cerrar menú" : "Abrir menú");
      });
      $$("a", menu).forEach(function (a) { a.addEventListener("click", function () { menu.classList.remove("is-open"); btn.setAttribute("aria-expanded", "false"); }); });
    }
    /* Marquesina sin costura: duplica el contenido una vez */
    var track = $("[data-ticker]");
    if (track && !track.dataset.dup) { track.dataset.dup = "1"; track.innerHTML += track.innerHTML; }

    /* Anclas con desplazamiento suave y margen para la cabecera fija */
    document.addEventListener("click", function (e) {
      var a = e.target.closest('a[href^="#"]');
      if (!a) return;
      var id = a.getAttribute("href");
      if (!id || id === "#" || a.hasAttribute("data-open-lote")) return;
      var el = document.querySelector(id);
      if (!el) return;
      e.preventDefault();
      var offset = 110;
      window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - offset, behavior: reduced ? "auto" : "smooth" });
      history.replaceState(null, "", id);
    });
  }

  function renderBadge() {
    var n = cart.count();
    $$("[data-cart-count]").forEach(function (el) { el.textContent = n; });
    $$("[data-cart-count-2]").forEach(function (el) { el.textContent = "(" + n + ")"; });
  }

  /* -------------------------------------------------------------
     Cajón del carrito
     ------------------------------------------------------------- */
  function initCartDrawer() {
    var drawer = $("[data-cart]"), backdrop = $("[data-cart-backdrop]");
    var openBtns = $$("[data-cart-open]");
    if (!drawer) {
      /* En páginas sin cajón, el botón del carrito lleva al checkout */
      openBtns.forEach(function (b) { b.addEventListener("click", function () { location.href = "checkout.html"; }); });
      return;
    }
    var lastFocus = null;
    function open() {
      lastFocus = document.activeElement;
      drawer.classList.add("is-open"); backdrop.classList.add("is-open");
      drawer.setAttribute("aria-hidden", "false");
      openBtns.forEach(function (b) { b.setAttribute("aria-expanded", "true"); });
      document.body.style.overflow = "hidden";
      var c = $("[data-cart-close]", drawer); if (c) c.focus();
    }
    function close() {
      drawer.classList.remove("is-open"); backdrop.classList.remove("is-open");
      drawer.setAttribute("aria-hidden", "true");
      openBtns.forEach(function (b) { b.setAttribute("aria-expanded", "false"); });
      document.body.style.overflow = "";
      if (lastFocus && lastFocus.focus) lastFocus.focus();
    }
    openBtns.forEach(function (b) { b.addEventListener("click", open); });
    $$("[data-cart-close]", drawer).forEach(function (b) { b.addEventListener("click", close); });
    backdrop.addEventListener("click", close);
    document.addEventListener("keydown", function (e) { if (e.key === "Escape" && drawer.classList.contains("is-open")) close(); });

    var itemsEl = $("[data-cart-items]", drawer);
    var subEl = $("[data-cart-subtotal]", drawer);
    var checkoutBtn = $("[data-cart-checkout]", drawer);

    function render() {
      var lines = cart.lines();
      if (!lines.length) {
        itemsEl.innerHTML = '<div class="drawer-empty"><span>Todavía no hay ningún lote.</span><button class="btn btn-solid" type="button" data-cart-close>Ver los lotes</button></div>';
        $$("[data-cart-close]", itemsEl).forEach(function (b) { b.addEventListener("click", close); });
        if (checkoutBtn) { checkoutBtn.setAttribute("aria-disabled", "true"); checkoutBtn.classList.add("is-busy"); }
      } else {
        itemsEl.innerHTML = lines.map(function (x) {
          var l = x.lote;
          return '<div class="citem" data-citem="' + escHTML(l.id) + '">' +
            '<img src="' + escHTML(l.img) + '" alt="" loading="lazy">' +
            '<div>' +
              '<div class="citem-name">' + escHTML(l.nombre) + '</div>' +
              '<div class="citem-meta">' + escHTML(l.ref) + ' · ' + escHTML(l.uds) + ' uds · ' + escHTML(eur(l.precio)) + '/lote</div>' +
              '<div class="citem-row">' +
                '<span class="qty" aria-label="Cantidad">' +
                  '<button type="button" data-qty="-1" aria-label="Quitar uno"' + (x.qty <= 1 ? "" : "") + '>−</button>' +
                  '<output>' + x.qty + '</output>' +
                  '<button type="button" data-qty="1" aria-label="Añadir uno"' + (x.qty >= l.stock ? " disabled" : "") + '>+</button>' +
                '</span>' +
                '<b class="citem-total">' + escHTML(eur(x.total)) + '</b>' +
              '</div>' +
              '<button class="citem-remove" type="button" data-remove>Quitar</button>' +
            '</div>' +
          '</div>';
        }).join("");
        if (checkoutBtn) { checkoutBtn.removeAttribute("aria-disabled"); checkoutBtn.classList.remove("is-busy"); }
      }
      if (subEl) subEl.textContent = eur(cart.subtotal());
      renderBadge();
    }
    itemsEl.addEventListener("click", function (e) {
      var row = e.target.closest("[data-citem]"); if (!row) return;
      var id = row.getAttribute("data-citem");
      var q = e.target.closest("[data-qty]");
      if (q) { cart.set(id, (cart.items[id] || 0) + parseInt(q.getAttribute("data-qty"), 10)); return; }
      if (e.target.closest("[data-remove]")) { cart.remove(id); }
    });
    document.addEventListener("cart:change", render);
    render();

    /* Botones "Añadir al carrito" de la página */
    document.addEventListener("click", function (e) {
      var b = e.target.closest("[data-add]"); if (!b) return;
      var id = b.getAttribute("data-add"); var l = LOTES[id]; if (!l) return;
      var ok = cart.add(id, 1);
      var navBtn = $("[data-cart-open]");
      if (navBtn) { navBtn.classList.remove("is-bump"); void navBtn.offsetWidth; navBtn.classList.add("is-bump"); }
      if (ok) toast('Añadido: <b>' + escHTML(l.nombre) + '</b> <a href="#carrito" data-toast-open>Ver carrito</a>');
      else toast('Ya tienes las ' + l.stock + ' unidades disponibles de <b>' + escHTML(l.nombre) + '</b> en el carrito.');
      var dlg = $("[data-lote-dialog]"); if (dlg && dlg.open) dlg.close();
    });
    document.addEventListener("click", function (e) {
      var a = e.target.closest("[data-toast-open]"); if (!a) return;
      e.preventDefault(); open();
    });
  }

  /* -------------------------------------------------------------
     Ficha de lote (diálogo)
     ------------------------------------------------------------- */
  function initLoteDialog() {
    var dlg = $("[data-lote-dialog]"); if (!dlg) return;
    var img = $("[data-dlg-img]", dlg), meta = $("[data-dlg-meta]", dlg), title = $("[data-dlg-title]", dlg),
        resumen = $("[data-dlg-resumen]", dlg), cont = $("[data-dlg-contenido]", dlg), nota = $("[data-dlg-nota]", dlg),
        precio = $("[data-dlg-precio]", dlg), off = $("[data-dlg-off]", dlg), pvp = $("[data-dlg-pvp]", dlg),
        stock = $("[data-dlg-stock]", dlg), add = $("[data-dlg-add]", dlg);

    function openLote(id) {
      var l = LOTES[id]; if (!l) return;
      img.src = l.img; img.alt = l.nombre;
      meta.textContent = "Ref " + l.ref + " · " + l.uds + " uds · " + l.formato + " · " + l.peso + " · Grado " + l.grado;
      title.textContent = l.nombre;
      resumen.textContent = l.resumen;
      cont.innerHTML = (l.contenido || []).map(function (c) { return "<li>" + escHTML(c) + "</li>"; }).join("");
      nota.textContent = l.nota || ""; nota.style.display = l.nota ? "" : "none";
      precio.textContent = eur(l.precio); off.textContent = "−" + pct(l) + " %"; pvp.textContent = "PVP estimado " + eur(l.pvp) + " · IVA y envío incluidos";
      var esPale = /pal[eé]/i.test(l.formato || "");
      stock.textContent = "Quedan " + l.stock + (esPale ? " palés" : " lotes") + " · Entrega prevista: " + fechaLarga(fechaEntrega(esPale));
      stock.classList.toggle("is-low", l.stock <= 2);
      add.setAttribute("data-add", id);
      add.textContent = "Añadir al carrito · " + eur(l.precio);
      if (typeof dlg.showModal === "function") dlg.showModal(); else dlg.setAttribute("open", "");
      dlg.scrollTop = 0;
    }
    document.addEventListener("click", function (e) {
      var b = e.target.closest("[data-open-lote]"); if (!b) return;
      e.preventDefault(); openLote(b.getAttribute("data-open-lote"));
    });
    $$("[data-dialog-close]", dlg).forEach(function (b) { b.addEventListener("click", function () { dlg.close(); }); });
    dlg.addEventListener("click", function (e) { if (e.target === dlg) dlg.close(); });

    /* Enlace directo: index.html#lote-moda abre la ficha */
    var h = location.hash.replace("#", "");
    if (h && LOTES[h]) setTimeout(function () { openLote(h); }, 400);
  }

  /* -------------------------------------------------------------
     Ordenar el catálogo
     ------------------------------------------------------------- */
  function initSort() {
    var sel = $("[data-sort]"), grid = $("[data-lotes]"); if (!sel || !grid) return;
    sel.addEventListener("change", function () {
      var cards = $$(".lote", grid);
      var wide = cards.filter(function (c) { return c.classList.contains("lote--wide"); });
      var rest = cards.filter(function (c) { return !c.classList.contains("lote--wide"); });
      var n = function (c, k) { return parseFloat(c.getAttribute("data-" + k)) || 0; };
      var by = {
        "default": function (a, b) { return n(a, "index") - n(b, "index"); },
        "precio-asc": function (a, b) { return n(a, "precio") - n(b, "precio"); },
        "precio-desc": function (a, b) { return n(b, "precio") - n(a, "precio"); },
        "descuento": function (a, b) { return (n(b, "pvp") / n(b, "precio")) - (n(a, "pvp") / n(a, "precio")); },
        "uds": function (a, b) { return n(b, "uds") - n(a, "uds"); }
      }[sel.value] || function () { return 0; };
      rest.sort(by).concat(wide).forEach(function (c) { grid.appendChild(c); c.classList.add("is-in"); });
    });
  }

  /* -------------------------------------------------------------
     Efectos: revelado, contadores, cuenta atrás, hero
     ------------------------------------------------------------- */
  function initReveals() {
    var els = $$(".rv"); if (!els.length) return;
    if (!("IntersectionObserver" in window)) { els.forEach(function (e) { e.classList.add("is-in"); }); return; }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add("is-in"); io.unobserve(en.target); } });
    }, { threshold: 0.01, rootMargin: "0px 0px -4% 0px" });
    els.forEach(function (e) { io.observe(e); });
    setTimeout(function () { $$(".rv:not(.is-in)").forEach(function (e) { e.classList.add("is-in"); }); }, 6000);
  }

  function initCounters() {
    var els = $$("[data-count]"); if (!els.length) return;
    var fmt = function (n) { return String(Math.round(n)).replace(/\B(?=(\d{3})+(?!\d))/g, "."); };
    function run(el) {
      var to = parseFloat(el.getAttribute("data-count")) || 0, dur = reduced ? 400 : 1400, t0 = null;
      function step(ts) {
        if (!t0) t0 = ts;
        var p = Math.min(1, (ts - t0) / dur); p = 1 - Math.pow(1 - p, 3);
        el.textContent = fmt(to * p);
        if (p < 1) requestAnimationFrame(step); else el.textContent = fmt(to);
      }
      requestAnimationFrame(step);
    }
    if (!("IntersectionObserver" in window)) return;
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { run(en.target); io.unobserve(en.target); } });
    }, { threshold: 0.01 });
    els.forEach(function (e) { io.observe(e); });
  }

  function initCountdown() {
    var box = $("[data-countdown]"); if (!box) return;
    var pc = T.proximoCamion || {}; var dia = Number(pc.diaSemana) || 4, hora = Number(pc.hora) || 8;
    function target() {
      var d = new Date(); d.setHours(hora, 0, 0, 0);
      var diff = (dia - d.getDay() + 7) % 7;
      if (diff === 0 && d <= new Date()) diff = 7;
      d.setDate(d.getDate() + diff); return d;
    }
    var t = target();
    var cells = { d: $('[data-cd="d"]', box), h: $('[data-cd="h"]', box), m: $('[data-cd="m"]', box), s: $('[data-cd="s"]', box) };
    var pad = function (n) { return (n < 10 ? "0" : "") + n; };
    function tick() {
      var ms = t - new Date(); if (ms < 0) { t = target(); ms = t - new Date(); }
      var s = Math.floor(ms / 1000);
      cells.d.textContent = Math.floor(s / 86400);
      cells.h.textContent = pad(Math.floor(s % 86400 / 3600));
      cells.m.textContent = pad(Math.floor(s % 3600 / 60));
      cells.s.textContent = pad(s % 60);
    }
    tick(); setInterval(tick, 1000);
  }

  function initHero() {
    var title = $(".hero-title"); if (!title || !window.gsap) return;
    var stamps = $$(".stamp", title);
    var img = $(".hero-fig img");
    /* Primero se activa el estado "oculto" por CSS y, al terminar la
       animación, se quita la clase y los estilos en línea a la vez para
       que la regla CSS no vuelva a esconder nada. */
    var done = false;
    function finish() {
      if (done) return; done = true;
      document.documentElement.classList.remove("has-gsap");
      gsap.set(stamps, { clearProps: "all" });
      if (img) gsap.set(img, { clearProps: "all" });
    }
    document.documentElement.classList.add("has-gsap");
    var tl = gsap.timeline({ onComplete: finish });
    tl.to(stamps, { opacity: 1, scale: 1, duration: reduced ? 0.3 : 0.55, ease: "expo.out", stagger: reduced ? 0.03 : 0.09 }, 0.1);
    if (img) tl.to(img, { clipPath: "inset(0 0% 0 0)", duration: reduced ? 0.4 : 1.1, ease: "expo.inOut" }, 0.35);
    /* Red de seguridad: pase lo que pase, todo visible a los 4 s */
    setTimeout(finish, 4000);
  }

  /* -------------------------------------------------------------
     Checkout
     ------------------------------------------------------------- */
  function initCheckout() {
    var form = $("[data-checkout-form]"); if (!form) return;
    var itemsEl = $("[data-co-items]"), emptyEl = $("[data-co-empty]"), gridEl = $("[data-co-grid]");
    var subEl = $("[data-co-subtotal]"), codRow = $("[data-co-cod-row]"), codEl = $("[data-co-cod]"), totEl = $("[data-co-total]"), etaEl = $("[data-co-eta]");
    var msg = $("[data-co-msg]"), submit = $("[data-co-submit]");
    var pagoInputs = $$('input[name="pago"]', form);

    function pago() { var c = pagoInputs.filter(function (i) { return i.checked; })[0]; return c ? c.value : "contrarreembolso"; }
    function totals() {
      var sub = cart.subtotal(); var cod = pago() === "contrarreembolso" ? recargoCOD(sub) : 0;
      return { sub: sub, cod: cod, total: sub + cod };
    }
    function render() {
      var lines = cart.lines();
      if (!lines.length) { if (gridEl) gridEl.style.display = "none"; if (emptyEl) emptyEl.style.display = ""; renderBadge(); return; }
      if (gridEl) gridEl.style.display = ""; if (emptyEl) emptyEl.style.display = "none";
      itemsEl.innerHTML = lines.map(function (x) {
        var l = x.lote;
        return '<div class="citem" data-citem="' + escHTML(l.id) + '">' +
          '<img src="' + escHTML(l.img) + '" alt="" loading="lazy"><div>' +
          '<div class="citem-name">' + escHTML(l.nombre) + '</div>' +
          '<div class="citem-meta">' + escHTML(l.ref) + ' · ' + escHTML(l.uds) + ' uds · Grado ' + escHTML(l.grado) + '</div>' +
          '<div class="citem-row"><span class="qty" aria-label="Cantidad"><button type="button" data-qty="-1" aria-label="Quitar uno">−</button><output>' + x.qty + '</output><button type="button" data-qty="1" aria-label="Añadir uno"' + (x.qty >= l.stock ? " disabled" : "") + '>+</button></span>' +
          '<b class="citem-total">' + escHTML(eur(x.total)) + '</b></div>' +
          '<button class="citem-remove" type="button" data-remove>Quitar</button></div></div>';
      }).join("");
      var t = totals();
      subEl.textContent = eur(t.sub);
      if (codRow) codRow.style.display = t.cod ? "" : "none";
      if (codEl) codEl.textContent = eur(t.cod);
      totEl.textContent = eur(t.total);
      if (etaEl) etaEl.textContent = "Entrega prevista: " + fechaLarga(fechaEntrega(cart.hasPale())) + (cart.hasPale() ? " · palé con llamada previa" : " · antes de las 14:00 sale hoy");
      if (submit) submit.textContent = (pago() === "tarjeta" ? "Pagar con tarjeta · " : "Confirmar pedido · ") + eur(t.total);
      renderBadge();
    }
    itemsEl.addEventListener("click", function (e) {
      var row = e.target.closest("[data-citem]"); if (!row) return;
      var id = row.getAttribute("data-citem");
      var q = e.target.closest("[data-qty]");
      if (q) { cart.set(id, (cart.items[id] || 0) + parseInt(q.getAttribute("data-qty"), 10)); return; }
      if (e.target.closest("[data-remove]")) cart.remove(id);
    });
    pagoInputs.forEach(function (i) { i.addEventListener("change", render); });
    document.addEventListener("cart:change", render);
    render();

    /* Si vuelve de la pasarela sin pagar */
    if (/cancelado=1/.test(location.search)) showMsg("No se ha completado el pago. Tu carrito sigue aquí: puedes volver a intentarlo o elegir contrarreembolso.", true);

    function showMsg(html, isError) {
      if (!msg) return;
      msg.innerHTML = html; msg.classList.add("is-on"); msg.classList.toggle("co-msg--error", !!isError);
      msg.scrollIntoView({ behavior: reduced ? "auto" : "smooth", block: "center" });
    }
    function field(name) { return form.elements[name]; }
    function val(name) { var f = field(name); return f ? String(f.value || "").trim() : ""; }
    function markError(name, on) {
      var f = field(name); if (!f) return;
      var wrap = f.closest(".field"); if (wrap) wrap.classList.toggle("is-error", !!on);
      f.setAttribute("aria-invalid", on ? "true" : "false");
    }
    function validate() {
      var bad = [];
      var req = ["nombre", "email", "telefono", "direccion", "cp", "poblacion", "provincia"];
      req.forEach(function (n) { var ok = val(n) !== ""; markError(n, !ok); if (!ok) bad.push(n); });
      if (val("email") && !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(val("email"))) { markError("email", true); bad.push("email"); }
      if (val("telefono") && (val("telefono").replace(/\D/g, "").length < 9)) { markError("telefono", true); bad.push("telefono"); }
      if (val("cp") && !/^\d{5}$/.test(val("cp"))) { markError("cp", true); bad.push("cp"); }
      var acepta = field("acepta"); if (acepta && !acepta.checked) { bad.push("acepta"); acepta.closest(".check").style.outline = "3px solid var(--accent)"; } else if (acepta) { acepta.closest(".check").style.outline = ""; }
      return bad;
    }
    function textoPedido(num) {
      var t = totals();
      var lines = cart.lines().map(function (x) { return "- " + x.qty + " × " + x.lote.nombre + " (" + x.lote.ref + ") = " + eur(x.total); });
      return ["PEDIDO " + (num || "(nuevo)") + " — Tornarem", "", "Lotes:"].concat(lines).concat(["",
        "Subtotal: " + eur(t.sub), (t.cod ? "Recargo contrarreembolso: " + eur(t.cod) : "Pago con tarjeta"), "TOTAL: " + eur(t.total), "",
        "Nombre: " + val("nombre"), "Email: " + val("email"), "Teléfono: " + val("telefono"),
        "Dirección: " + val("direccion") + ", " + val("cp") + " " + val("poblacion") + " (" + val("provincia") + ")",
        (val("nif") ? "NIF/CIF: " + val("nif") : ""), (val("empresa") ? "Empresa: " + val("empresa") : ""), (val("notas") ? "Notas: " + val("notas") : "")]).filter(function (s) { return s !== ""; }).join("\n");
    }

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (!cart.count()) { showMsg("El carrito está vacío.", true); return; }
      var bad = validate();
      if (bad.length) { showMsg("Revisa los campos marcados: faltan datos o no son correctos.", true); var f = field(bad[0]); if (f && f.focus) f.focus(); return; }
      var payload = {
        cliente: { nombre: val("nombre"), email: val("email"), telefono: val("telefono"), direccion: val("direccion"), cp: val("cp"),
                   poblacion: val("poblacion"), provincia: val("provincia"), nif: val("nif"), empresa: val("empresa"), notas: val("notas") },
        pago: pago(),
        items: cart.lines().map(function (x) { return { id: x.lote.id, qty: x.qty }; }),
        total_cliente: totals().total,
        web: val("web"),
        origen: location.href
      };
      submit.classList.add("is-busy"); submit.textContent = "Enviando…";
      if (msg) msg.classList.remove("is-on");

      var ctrl = ("AbortController" in window) ? new AbortController() : null;
      var timer = ctrl ? setTimeout(function () { ctrl.abort(); }, 25000) : null;
      fetch("pedido.php", { method: "POST", headers: { "Content-Type": "application/json", "Accept": "application/json" },
        body: JSON.stringify(payload), signal: ctrl ? ctrl.signal : undefined })
        .then(function (r) { return r.text().then(function (t) { var d; try { d = JSON.parse(t); } catch (_) { throw new Error("respuesta no válida (" + r.status + ")"); } if (!r.ok && !d.mensaje) throw new Error("HTTP " + r.status); return d; }); })
        .then(function (d) {
          if (timer) clearTimeout(timer);
          if (!d.ok) { throw new Error(d.mensaje || "No se ha podido registrar el pedido."); }
          cart.clear();
          if (d.url) { location.href = d.url; return; }
          location.href = "gracias.html?p=" + encodeURIComponent(d.pedido) + "&pago=" + encodeURIComponent(d.pago) + "&total=" + encodeURIComponent(d.total) + "&email=" + encodeURIComponent(payload.cliente.email);
        })
        .catch(function (err) {
          if (timer) clearTimeout(timer);
          submit.classList.remove("is-busy"); render();
          var c = T.contacto || {};
          var texto = textoPedido();
          var mailto = "mailto:" + (c.email || "") + "?subject=" + encodeURIComponent("Pedido web — " + val("nombre")) + "&body=" + encodeURIComponent(texto);
          var wa = c.whatsapp ? "https://wa.me/" + c.whatsapp + "?text=" + encodeURIComponent(texto) : "";
          showMsg("<b>No hemos podido registrar el pedido automáticamente</b> (" + escHTML(err.message || "error de red") + "). " +
            "No has perdido nada: envíanoslo por correo o WhatsApp con un clic y lo confirmamos nosotros." +
            '<div class="fallbacks"><a class="btn btn-solid" href="' + mailto + '">Enviar por correo</a>' + (wa ? '<a class="btn btn-line" href="' + wa + '" target="_blank" rel="noopener">Enviar por WhatsApp</a>' : "") +
            (c.telefonoHref ? '<a class="btn btn-line" href="' + escHTML(c.telefonoHref) + '">Llamar al ' + escHTML(c.telefono) + '</a>' : "") + "</div>", true);
        });
    });
  }

  /* -------------------------------------------------------------
     Página de gracias
     ------------------------------------------------------------- */
  function initGracias() {
    var box = $("[data-gracias]"); if (!box) return;
    var q = {}; location.search.replace(/^\?/, "").split("&").forEach(function (kv) { if (!kv) return; var p = kv.split("="); q[decodeURIComponent(p[0])] = decodeURIComponent((p[1] || "").replace(/\+/g, " ")); });
    var num = q.p || "", pago = q.pago || "", total = parseFloat(q.total);
    $$("[data-g-num]", box).forEach(function (el) { el.textContent = num || "pendiente de confirmar"; });
    $$("[data-g-total]", box).forEach(function (el) { el.textContent = isNaN(total) ? "—" : eur(total); });
    $$("[data-g-email]", box).forEach(function (el) { el.textContent = q.email || "tu correo"; });
    $$("[data-g-pago]", box).forEach(function (el) { el.style.display = (el.getAttribute("data-g-pago") === pago) ? "" : "none"; });
    if (!pago) { var g = $('[data-g-pago="generico"]', box); if (g) g.style.display = ""; }
    if (q.stripe === "ok") cart.clear();
    var eta = $("[data-g-eta]", box); if (eta) eta.textContent = fechaLarga(fechaEntrega(false));
  }

  /* -------------------------------------------------------------
     Arranque
     ------------------------------------------------------------- */
  function boot() {
    document.documentElement.classList.add("js-ready");
    safe(initNav, "initNav");
    safe(renderBadge, "renderBadge");
    safe(initCartDrawer, "initCartDrawer");
    safe(initLoteDialog, "initLoteDialog");
    safe(initSort, "initSort");
    safe(initReveals, "initReveals");
    safe(initCounters, "initCounters");
    safe(initCountdown, "initCountdown");
    safe(initHero, "initHero");
    safe(initCheckout, "initCheckout");
    safe(initGracias, "initGracias");
    /* Sincroniza el carrito entre pestañas */
    window.addEventListener("storage", function (e) { if (e.key === CART_KEY) { cart.load(); document.dispatchEvent(new CustomEvent("cart:change")); } });
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot); else boot();
})();
