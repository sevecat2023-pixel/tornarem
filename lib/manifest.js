/* =========================================================================
   TornaBox — DATOS EDITABLES DE LA TIENDA
   -------------------------------------------------------------------------
   Este archivo es la única pieza que necesitas tocar en el día a día:
   stock semanal, emails de contacto, enlaces de pago con tarjeta,
   reseñas de cada caja…

   ⚠️  Si cambias un PRECIO, cámbialo también en la tarjeta correspondiente
       de index.html y en pedido.php (los precios están escritos en el HTML
       para que la web funcione incluso sin JavaScript).
   ========================================================================= */
(function () {
  "use strict";

  window.__BRAND__ = {
    nombre: "TornaBox",
    dominio: "tornabox.es",                 // ← tu dominio real
    emailPedidos: "pedidos@tornabox.es",    // ← donde recibirás los pedidos
    emailHola: "hola@tornabox.es",
    almacen: "Barcelona",

    // Pedidos confirmados antes de esta hora (laborables) salen el mismo día.
    horaCorte: 18,

    // Cifras del bloque de confianza. Sustitúyelas por las tuyas reales
    // en cuanto las tengas: los números inventados se acaban notando.
    stats: { cajasEntregadas: 18412, nota: "4,6", repiten: 96 },

    envio: {
      estandar: 4.95,       // pedidos por debajo del mínimo de envío gratis
      gratisDesde: 50,      // envío gratis a partir de este importe de pedido
      recargoCOD: 4.95,     // gestión del contra reembolso (la tarjeta no tiene recargo)
      seguro: 4.95,         // seguro de devolución opcional (30 días + recogida)
      plazo: "24/48 h",
      transportista: "Correos"
    },

    /* ---------------------------------------------------------------------
       PAGO CON TARJETA (opcional, muy recomendado)
       Crea un «Payment Link» en stripe.com (o SumUp/PayPal) por cada caja y
       pega aquí la URL. Si lo dejas vacío, el pedido con tarjeta se registra
       igualmente y el cliente recibe el enlace de pago por email
       (tú se lo envías al ver el pedido en tu correo).
       --------------------------------------------------------------------- */
    pagoTarjeta: {
      inicio: "",
      grande: "",
      tech: "",
      xxl: ""
    },

    /* ---------------------------------------------------------------------
       ESCALERA DE MEJORA (upsell del checkout)
       Al pedir una caja se le ofrece subir a la siguiente pagando solo la
       diferencia con descuento. Si acepta, se le ofrece la siguiente.
       «precio» es lo que paga por subir un escalón; el ahorro sale solo
       comparándolo con la diferencia real de precio entre las dos cajas.
       --------------------------------------------------------------------- */
    mejoras: {
      inicio: { a: "grande", precio: 19.95 },   // diferencia real: 25,00 €
      grande: { a: "tech",   precio: 22.95 },   // diferencia real: 30,00 €
      tech:   { a: "xxl",    precio: 44.95 }    // diferencia real: 60,00 €
    },

    /* ---------------------------------------------------------------------
       CAJAS — el stock es lo único que conviene actualizar cada semana.
       «stockRestante» alimenta las barras de escasez, y «resenas» las
       valoraciones con foto de la página de producto (fotos en
       assets/img/resenas/).
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
        color: "#b45309",
        claim: "La puerta de entrada: una caja pequeña con valor de hasta 150 € para probar la suerte sin apostar fuerte.",
        puntos: [
          "8–12 productos de hogar, accesorios y tecnología pequeña",
          "Valor del contenido de hasta 150 € (suma de PVP)",
          "Revisada a mano: lo que no funciona, no entra",
          "Envío 24/48 h con Correos — GRATIS a partir de 50 € de pedido"
        ],
        categorias: ["Hogar y cocina", "Accesorios", "Tecnología pequeña", "Smart home", "Menaje de marca"],
        resenas: [
          { n: "Iván R.", e: 5, f: "assets/img/resenas/rrr4.webp", t: "¡Increíble experiencia de compra! La entrega fue rápida, los productos electrónicos son de alta calidad y el servicio al cliente fue excepcional. ¡No puedo esperar para volver a comprar aquí!" },
          { n: "Carmen L.", e: 5, f: "", t: "Regalé la Inicio a mi hermano y acabamos pidiendo otra para casa. Abrirla en familia es medio producto." },
          { n: "Laura P.", e: 5, f: "", t: "Lo del contra reembolso me convenció: pagas cuando la tienes delante. Llegó en dos días y todo funcionaba." }
        ]
      },
      grande: {
        nombre: "Caja Grande",
        etiqueta: "La más pedida",
        articulos: "15–20 productos",
        valorMin: 180, valorMax: 350,
        precio: 59.95,
        envioGratis: true,
        stockTotal: 35, stockRestante: 7,
        color: "#ff4b26",
        claim: "El equilibrio perfecto: 15–20 productos de todas las categorías con valor de hasta 350 €. La caja que más repite la gente.",
        puntos: [
          "15–20 productos de todas las categorías",
          "Valor del contenido de hasta 350 € (suma de PVP)",
          "Envío GRATIS en 24/48 h con Correos",
          "La favorita para pedir entre dos y repartir el lote"
        ],
        categorias: ["Tecnología", "Gaming", "Hogar y cocina", "Sonido", "Deporte", "Pequeño electrodoméstico"],
        resenas: [
          { n: "Laura V.", e: 5, f: "assets/img/resenas/7.webp", t: "Cuando vi que era una PS5 casi me caigo de la silla. Llevaba tiempo detrás de una y nunca me animé a comprarla. Ahora la tengo en casa gracias a la caja de devoluciones. La mejor compra que he hecho." },
          { n: "Javier M.", e: 5, f: "assets/img/resenas/4.webp", t: "Al abrir la caja me encontré con un dron con cámara profesional. ¡Increíble! Siempre había querido probar uno, y la calidad de imagen es brutal. No esperaba que me tocase algo tan tocho. Súper feliz." },
          { n: "Eduardo P.", e: 5, f: "assets/img/resenas/9.webp", t: "Me tocó una PS5 y no puedo estar más feliz. Llevo semanas viciando con mis amigos y va perfecta. Ni de broma esperaba encontrarme una en un lote de devoluciones." },
          { n: "David E.", e: 5, f: "assets/img/resenas/12.webp", t: "Me salió una Xbox Series X en la caja. No me lo creía hasta que la encendí. Carga rapidísima, gráficos espectaculares… ahora la disfruto a diario. ¡Muy feliz con la compra!" },
          { n: "Claudia P.", e: 5, f: "assets/img/resenas/rrr2.webp", t: "¡Muy satisfecho con mi compra de productos electrónicos! La entrega fue rápida, los productos son de primera calidad y el servicio al cliente fue impecable. ¡Definitivamente volveré a comprar aquí!" }
        ]
      },
      tech: {
        nombre: "Caja Tech",
        etiqueta: "Solo electrónica",
        articulos: "6–10 productos",
        valorMin: 250, valorMax: 500,
        precio: 89.95,
        envioGratis: true,
        stockTotal: 25, stockRestante: 9,
        color: "#4338ca",
        claim: "Cero relleno: solo electrónica revisada — audio, wearables, periféricos y smart home — con valor de hasta 500 €.",
        puntos: [
          "6–10 productos, solo electrónica",
          "Valor del contenido de hasta 500 € (suma de PVP)",
          "Audio, wearables, periféricos, imagen y smart home",
          "Envío GRATIS en 24/48 h con Correos"
        ],
        categorias: ["Audio", "Wearables", "Periféricos", "Imagen", "Smart home", "Gaming"],
        resenas: [
          { n: "María L.", e: 5, f: "assets/img/resenas/1.webp", t: "No me lo creía cuando abrí la caja… ¡un iPhone 17 Pro! Justo lo que necesitaba y ni de broma esperaba algo así en un lote de devoluciones. Funciona perfecto, la batería dura una barbaridad y la cámara es increíble." },
          { n: "Sofía G.", e: 5, f: "assets/img/resenas/3.webp", t: "Me llegaron unos AirPods 4 con cancelación de ruido y estoy flipando. El sonido es nítido, el aislamiento es total y encima me vinieron en perfecto estado. ¡Un regalazo inesperado!" },
          { n: "Ana R.", e: 5, f: "assets/img/resenas/5.webp", t: "Abrí la caja y me encontré con un Apple Watch S10. ¡Me hizo el día! Siempre había querido uno para controlar entrenos y salud, y ahora lo llevo puesto a todas horas. Me siento afortunadísimo." },
          { n: "Pedro A.", e: 5, f: "assets/img/resenas/2.webp", t: "Mi caja traía unos AirPods 4. Los uso todos los días para el trabajo y para entrenar, son cómodos y el sonido es de diez. Nunca pensé que en un lote de devoluciones me fuera a salir algo tan útil." },
          { n: "Jorge R.", e: 5, f: "assets/img/resenas/rrr1.webp", t: "¡Excelente experiencia con los productos electrónicos de esta tienda! La entrega fue rapidísima, los productos son de alta calidad y el servicio al cliente fue excepcional. ¡Totalmente recomendado!" }
        ]
      },
      xxl: {
        nombre: "Caja XXL Reventa",
        etiqueta: "Mejor precio por producto",
        articulos: "30+ productos",
        valorMin: 500, valorMax: 900,
        precio: 149.95,
        envioGratis: true,
        stockTotal: 15, stockRestante: 4,
        color: "#0e8a5f",
        claim: "El mini-palé: más de 30 productos con valor de hasta 900 €. La que usan quienes revenden en mercadillos y apps de segunda mano.",
        puntos: [
          "30+ productos en una sola caja",
          "Valor del contenido de hasta 900 € (suma de PVP)",
          "El mejor precio por producto de toda la tienda",
          "Envío GRATIS y prioritario · sale la primera del almacén"
        ],
        categorias: ["Tecnología", "Hogar y cocina", "Gaming", "Herramientas", "Deporte", "Accesorios", "Sonido"],
        resenas: [
          { n: "Carlos F.", e: 5, f: "assets/img/resenas/6.webp", t: "Mi caja traía un MacBook Air de 13 pulgadas. Literalmente no me lo esperaba. Es rápido, ligero y perfecto para trabajar y estudiar. No puedo estar más contenta con la compra." },
          { n: "Isabel D.", e: 5, f: "assets/img/resenas/10.webp", t: "Me llegó un MacBook Air de 14 pulgadas. El diseño es precioso, súper rápido y ligero. Nunca pensé que en un lote de devoluciones vendría algo tan útil y caro. Encantada con la compra." },
          { n: "Miguel H.", e: 5, f: "assets/img/resenas/8.webp", t: "Compro la XXL para revender y en el último palé vino un iPhone 16 Pro Max precintado, sin abrir. Solo con esa pieza ya recuperé lo que había pagado por el lote entero." },
          { n: "Andrés C.", e: 5, f: "assets/img/resenas/11.webp", t: "Al abrir mi caja encontré unas Pico 4 de realidad virtual. ¡Una pasada! La experiencia de inmersión es brutal, no paro de probar juegos nuevos. No esperaba encontrarme algo así en el lote." },
          { n: "David M.", e: 5, f: "assets/img/resenas/rrr3.webp", t: "¡Los productos electrónicos de esta tienda son increíbles! La entrega fue rápida y el servicio al cliente fue excelente. ¡Sin duda alguna, recomendaré esta tienda a mis amigos y familiares!" }
        ]
      }
    }
  };
})();
