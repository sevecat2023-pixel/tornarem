/* =============================================================
   TORNAREM TELECOM — main.js
   Script clásico, patrón IIFE. Sin imports: funciona en file://,
   en FTP y detrás de cualquier CDN.
   El HTML ya contiene todo el contenido; esto sólo lo enriquece.
   ============================================================= */
(function () {
  "use strict";

  var data = window.__BRAND__ || {};

  /* ---------- helpers ---------- */
  function $(sel, scope) { return (scope || document).querySelector(sel); }
  function $$(sel, scope) { return Array.prototype.slice.call((scope || document).querySelectorAll(sel)); }
  function safe(fn, name) { try { fn(); } catch (e) { console.warn("[" + name + "]", e); } }

  var fineHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
  var reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* Quita acentos y mayúsculas para comparar textos escritos a mano */
  function norm(s) {
    return String(s == null ? "" : s)
      .toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .replace(/[^a-z0-9\s]/g, " ")
      .replace(/\s+/g, " ")
      .trim();
  }

  function fmt(value, decimals) {
    try {
      return value.toLocaleString("es-ES", {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
      });
    } catch (e) {
      return decimals ? value.toFixed(decimals) : String(Math.round(value));
    }
  }

  /* =============================================================
     Navegación
     ============================================================= */
  function initNav() {
    var nav = $("[data-nav]");
    if (!nav) return;

    var onScroll = function () {
      if (window.scrollY > 60) nav.classList.add("is-scrolled");
      else nav.classList.remove("is-scrolled");
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });

    var toggle = $(".nav-toggle", nav);
    var drawer = $("#menu-movil");
    if (!toggle || !drawer) return;

    var setOpen = function (open) {
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
      toggle.setAttribute("aria-label", open ? "Cerrar menú" : "Abrir menú");
      drawer.setAttribute("data-open", open ? "true" : "false");
      document.body.style.overflow = open ? "hidden" : "";
    };

    toggle.addEventListener("click", function () {
      setOpen(toggle.getAttribute("aria-expanded") !== "true");
    });

    drawer.addEventListener("click", function (e) {
      if (e.target.closest("a")) setOpen(false);
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") setOpen(false);
    });

    window.addEventListener("resize", function () {
      if (window.innerWidth >= 960) setOpen(false);
    });
  }

  /* =============================================================
     Anclas con desplazamiento nativo
     ============================================================= */
  function initAnchors() {
    document.addEventListener("click", function (e) {
      var a = e.target.closest('a[href^="#"]');
      if (!a) return;
      var id = a.getAttribute("href");
      if (!id || id === "#") return;
      var el = document.querySelector(id);
      if (!el) return;
      e.preventDefault();
      var top = el.getBoundingClientRect().top + window.scrollY - 88;
      window.scrollTo({ top: top, behavior: reduced ? "auto" : "smooth" });
      if (el.id === "hero-cp" || el.tagName === "INPUT") {
        setTimeout(function () { try { el.focus({ preventScroll: true }); } catch (_) { el.focus(); } }, 500);
      }
    });
  }

  /* =============================================================
     Revelado al hacer scroll
     ============================================================= */
  function initReveals() {
    var els = $$("[data-reveal]");
    if (!els.length) return;

    if (!("IntersectionObserver" in window)) {
      els.forEach(function (el) { el.classList.add("is-revealed"); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-revealed");
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.01, rootMargin: "0px 0px -2% 0px" });

    els.forEach(function (el) { io.observe(el); });

    /* Red de seguridad: a los 6 s, nada que esté en pantalla sigue oculto */
    setTimeout(function () {
      $$("[data-reveal]:not(.is-revealed)").forEach(function (el) {
        if (el.getBoundingClientRect().top < window.innerHeight * 1.2) {
          el.classList.add("is-revealed");
        }
      });
    }, 6000);
  }

  /* =============================================================
     Cifras que cuentan hacia arriba
     ============================================================= */
  function initCountUp() {
    var els = $$("[data-count-to]");
    if (!els.length) return;

    els.forEach(function (el) {
      var raw = el.getAttribute("data-count-to");
      var target = parseFloat(raw);
      if (isNaN(target)) return;
      var decimals = (raw.split(".")[1] || "").length;
      var final = fmt(target, decimals);

      var run = function () {
        if (reduced || !window.gsap || target === 0) { el.textContent = final; return; }
        var obj = { v: 0 };
        window.gsap.to(obj, {
          v: target,
          duration: 1.5,
          ease: "power2.out",
          onUpdate: function () { el.textContent = fmt(obj.v, decimals); },
          onComplete: function () { el.textContent = final; }
        });
      };

      if (!("IntersectionObserver" in window)) { run(); return; }
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) { run(); io.unobserve(entry.target); }
        });
      }, { threshold: 0.3 });
      io.observe(el);
    });
  }

  /* =============================================================
     Botones magnéticos (sólo con ratón fino)
     ============================================================= */
  function initMagnetic() {
    if (!fineHover) return;

    $$("[data-magnetic]").forEach(function (el) {
      if (el.dataset.magneticBound) return;
      el.dataset.magneticBound = "1";

      var strength = parseFloat(el.getAttribute("data-magnetic-strength") || "0.22");
      var inner = document.createElement("span");
      inner.className = "magnetic-inner";
      while (el.firstChild) inner.appendChild(el.firstChild);
      el.appendChild(inner);
      el.classList.add("has-magnetic");

      var tx = 0, ty = 0, cx = 0, cy = 0, raf = null;

      function loop() {
        cx += (tx - cx) * 0.2;
        cy += (ty - cy) * 0.2;
        inner.style.transform = "translate3d(" + cx.toFixed(2) + "px," + cy.toFixed(2) + "px,0)";
        raf = (Math.abs(tx - cx) > 0.1 || Math.abs(ty - cy) > 0.1) ? requestAnimationFrame(loop) : null;
      }

      el.addEventListener("mousemove", function (e) {
        var r = el.getBoundingClientRect();
        tx = ((e.clientX - r.left) - r.width / 2) * strength;
        ty = ((e.clientY - r.top) - r.height / 2) * strength;
        if (!raf) raf = requestAnimationFrame(loop);
      });

      el.addEventListener("mouseleave", function () {
        tx = 0; ty = 0;
        if (!raf) raf = requestAnimationFrame(loop);
      });
    });
  }

  /* =============================================================
     Conmutador de tarifas
     ============================================================= */
  function initPlansSwitch() {
    var group = $("[data-plans-switch]");
    if (!group) return;
    var tabs = $$("[data-plan-tab]", group);
    if (!tabs.length) return;

    function select(key) {
      tabs.forEach(function (t) {
        t.setAttribute("aria-selected", t.getAttribute("data-plan-tab") === key ? "true" : "false");
      });
      $$("[data-plan-panel]").forEach(function (panel) {
        panel.hidden = panel.getAttribute("data-plan-panel") !== key;
      });
      if (window.ScrollTrigger) { try { window.ScrollTrigger.refresh(); } catch (_) {} }
    }

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () { select(tab.getAttribute("data-plan-tab")); });
      tab.addEventListener("keydown", function (e) {
        if (e.key !== "ArrowRight" && e.key !== "ArrowLeft") return;
        e.preventDefault();
        var i = tabs.indexOf(tab);
        var next = tabs[(i + (e.key === "ArrowRight" ? 1 : tabs.length - 1)) % tabs.length];
        next.focus();
        select(next.getAttribute("data-plan-tab"));
      });
    });
  }

  /* =============================================================
     Comprobador de cobertura
     ============================================================= */
  function findCobertura(query) {
    var list = data.cobertura || [];
    var q = norm(query);
    if (!q) return null;

    /* Código postal exacto o por prefijo */
    var digits = q.replace(/\D/g, "");
    if (digits.length >= 3) {
      var byCp = list.filter(function (row) { return row.cp.indexOf(digits) === 0; });
      if (byCp.length) return byCp[0];
    }

    /* Nombre del municipio */
    var exact = null, partial = null;
    list.forEach(function (row) {
      var n = norm(row.m);
      if (n === q) exact = exact || row;
      else if (n.indexOf(q) === 0 || n.indexOf(" " + q) > -1) partial = partial || row;
    });
    return exact || partial;
  }

  function initCoverCheck() {
    var form = $("[data-cover-check]");
    if (!form) return;
    var box = $("[data-cover-result]", form);
    var titleEl = $("[data-cover-title]", form);
    var textEl = $("[data-cover-text]", form);
    var input = $("input", form);
    if (!box || !titleEl || !textEl || !input) return;

    var msgs = data.coberturaMsg || {};

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var value = input.value.trim();
      if (!value) { input.focus(); return; }

      var hit = findCobertura(value);
      var state = hit ? hit.estado : "no";
      var msg = msgs[state] || msgs.no || { titulo: "", texto: "" };

      box.setAttribute("data-state", state);
      titleEl.textContent = hit ? hit.m + " — " + msg.titulo : msg.titulo;
      textEl.textContent = msg.texto;
      box.classList.add("is-open");
    });

    /* Al reescribir, el resultado anterior deja de tener sentido */
    input.addEventListener("input", function () {
      box.classList.remove("is-open");
    });
  }

  /* =============================================================
     Filtro del listado de cobertura
     ============================================================= */
  function initCoverFilter() {
    var input = $("[data-cover-filter]");
    var list = $("[data-cover-list]");
    if (!input || !list) return;

    var items = $$(".cover-item", list);
    var empty = document.createElement("li");
    empty.className = "cover-empty";
    empty.hidden = true;
    empty.textContent = "Ahí todavía no llegamos. Escríbenos y entras en el plan del año que viene.";
    list.appendChild(empty);

    input.addEventListener("input", function () {
      var q = norm(input.value);
      var visible = 0;
      items.forEach(function (item) {
        var match = !q || norm(item.textContent).indexOf(q) > -1;
        item.hidden = !match;
        if (match) visible++;
      });
      empty.hidden = visible > 0;
    });
  }

  /* =============================================================
     Formulario de contacto (envío simulado)
     ============================================================= */
  function initContactForm() {
    var form = $("[data-contact-form]");
    var success = $("[data-contact-success]");
    if (!form || !success) return;

    var btn = $("[type=submit]", form);
    var msg = $("[data-contact-success-msg]", success);
    var title = $("[data-contact-success-title]", success);

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      if (form.classList.contains("is-sending")) return;
      if (!form.reportValidity()) return;

      form.classList.add("is-sending");
      if (btn) btn.disabled = true;

      setTimeout(function () {
        var nombre = (form.elements.nombre && form.elements.nombre.value || "").trim();
        var municipio = (form.elements.municipio && form.elements.municipio.value || "").trim();
        var pila = nombre.split(/\s+/)[0] || "Hola";
        var hit = municipio ? findCobertura(municipio) : null;

        if (title) title.textContent = pila + ", recibido.";
        if (msg) {
          msg.textContent = hit && hit.estado !== "obras"
            ? "En " + hit.m + " ya tenemos nodo abierto, así que te llamamos hoy mismo en horario de oficina para cerrar día de instalación."
            : "Te llamamos en menos de un día laborable. Si prefieres adelantarlo, marca el 900 000 000 y pregunta por el equipo de altas.";
        }

        form.classList.add("is-sent");

        /* Al acabar el desvanecido retiramos el formulario del flujo:
           si sólo bajase la opacidad, el acuse quedaría fuera de pantalla. */
        setTimeout(function () {
          form.hidden = true;
          success.classList.add("is-visible");
          try {
            success.scrollIntoView({ behavior: reduced ? "auto" : "smooth", block: "center" });
          } catch (_) {
            success.scrollIntoView();
          }
        }, 480);
      }, 850);
    });
  }

  /* =============================================================
     Créditos de las fotografías (enriquecimiento, no contenido)
     ============================================================= */
  function initCredits() {
    var node = $("[data-credits]");
    if (!node || !window.fetch) return;

    fetch("assets/credits.json")
      .then(function (r) { return r.ok ? r.json() : null; })
      .then(function (credits) {
        if (!credits) return;
        var parts = Object.keys(credits).map(function (key) {
          var c = credits[key];
          var licencia = String(c.license || "").toUpperCase();
          return '<a href="' + c.foreign_landing_url + '" rel="noopener nofollow">' + c.title + "</a>"
            + " de " + c.creator + " (CC " + licencia + " " + (c.license_version || "") + ")";
        });
        if (parts.length) {
          node.innerHTML = "Fotografías bajo licencia Creative Commons vía Openverse: " + parts.join(" · ") + ".";
        }
      })
      .catch(function () { /* en file:// el fetch falla; el texto de respaldo ya está en el HTML */ });
  }

  /* =============================================================
     Profundidad de la malla de color al hacer scroll
     ============================================================= */
  function initMeshParallax() {
    if (!window.gsap || !window.ScrollTrigger) return;
    $$(".hero .mesh").forEach(function (mesh) {
      window.gsap.to(mesh, {
        yPercent: 14,
        ease: "none",
        scrollTrigger: {
          trigger: mesh.parentElement,
          start: "top top",
          end: "bottom top",
          scrub: true
        }
      });
    });
  }

  /* =============================================================
     Arranque
     ============================================================= */
  function boot() {
    safe(initNav, "initNav");
    safe(initAnchors, "initAnchors");
    safe(initReveals, "initReveals");
    safe(initCountUp, "initCountUp");
    safe(initMagnetic, "initMagnetic");
    safe(initPlansSwitch, "initPlansSwitch");
    safe(initCoverCheck, "initCoverCheck");
    safe(initCoverFilter, "initCoverFilter");
    safe(initContactForm, "initContactForm");
    safe(initCredits, "initCredits");

    if (window.gsap && window.ScrollTrigger) {
      try { window.gsap.registerPlugin(window.ScrollTrigger); } catch (_) {}
      safe(initMeshParallax, "initMeshParallax");
    }

    document.documentElement.classList.add("is-ready");
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
