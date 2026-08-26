/* =========================================================================
   TornaBox — DATOS EDITABLES DE LA TIENDA
   -------------------------------------------------------------------------
   Este archivo es la única pieza que necesitas tocar en el día a día:
   stock semanal, teléfono de WhatsApp, enlaces de pago con tarjeta, email…

   ⚠️  Si cambias un PRECIO, cámbialo también en la tarjeta correspondiente
       de index.html (los precios están escritos en el HTML para que la web
       funcione incluso sin JavaScript).
   ========================================================================= */
(function () {
  "use strict";

  window.__BRAND__ = {
    nombre: "TornaBox",
    dominio: "tornabox.es",                 // ← tu dominio real
    emailPedidos: "pedidos@tornabox.es",    // ← donde recibirás los pedidos
    emailHola: "hola@tornabox.es",
    whatsapp: "+34 600 000 000",            // ← tu número visible
    whatsappLink: "https://wa.me/34600000000", // ← sin espacios ni «+»
    almacen: "Barcelona",

    // Pedidos confirmados antes de esta hora (laborables) salen el mismo día.
    horaCorte: 18,

    // Cifras del bloque de confianza. Sustitúyelas por las tuyas reales
    // en cuanto las tengas: los números inventados se acaban notando.
    stats: { cajasEntregadas: 18412, nota: "4,6", repiten: 96 },

    envio: {
      estandar: 4.95,       // cajas sin envío gratis
      recargoCOD: 2.95,     // gestión del contra reembolso
      plazo: "24–72 h"
    },

    /* ---------------------------------------------------------------------
       PAGO CON TARJETA (opcional, muy recomendado)
       Crea un «Payment Link» en stripe.com (o SumUp/PayPal) por cada caja y
       pega aquí la URL. Si lo dejas vacío, el pedido con tarjeta se registra
       igualmente y el cliente recibe el enlace de pago por email/WhatsApp
       (tú se lo envías al ver el pedido en tu correo).
       --------------------------------------------------------------------- */
    pagoTarjeta: {
      inicio: "",
      grande: "",
      tech: "",
      xxl: ""
    },

    /* ---------------------------------------------------------------------
       CAJAS — el stock es lo único que conviene actualizar cada semana.
       «stockRestante» alimenta las barras de escasez de la portada.
       --------------------------------------------------------------------- */
    cajas: {
      inicio: {
        nombre: "Caja Inicio",
        etiqueta: "Para probar",
        articulos: "8–12 productos",
        valorMin: 80, valorMax: 150,
        precio: 34.95,
        envioGratis: false,
        stockTotal: 40, stockRestante: 14,
        color: "#b45309"
      },
      grande: {
        nombre: "Caja Grande",
        etiqueta: "La más pedida",
        articulos: "15–20 productos",
        valorMin: 180, valorMax: 350,
        precio: 59.95,
        envioGratis: true,
        stockTotal: 35, stockRestante: 7,
        color: "#ff4b26"
      },
      tech: {
        nombre: "Caja Tech",
        etiqueta: "Solo electrónica",
        articulos: "6–10 productos",
        valorMin: 250, valorMax: 500,
        precio: 89.95,
        envioGratis: true,
        stockTotal: 25, stockRestante: 9,
        color: "#4338ca"
      },
      xxl: {
        nombre: "Caja XXL Reventa",
        etiqueta: "Mejor precio por producto",
        articulos: "30+ productos",
        valorMin: 500, valorMax: 900,
        precio: 149.95,
        envioGratis: true,
        stockTotal: 15, stockRestante: 4,
        color: "#0e8a5f"
      }
    }
  };
})();
