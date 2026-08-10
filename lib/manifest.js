/* Tornarem Telecom — datos de marca.
   Un único global: window.__BRAND__. Sin imports, sin módulos. */
(function () {
  "use strict";

  window.__BRAND__ = {
    name: "Tornarem Telecom",
    claim: "Fibra y móvil de proximidad",
    zona: "Gironès · Osona · Ripollès",

    contacto: {
      telefono: "900 000 000",
      telefonoHref: "tel:+34900000000",
      email: "hola@tornarem.cat",
      soporte: "averias@tornarem.cat",
      direccion: "Carrer del Portal Nou, 12 · 17001 Girona",
      horario: "Lunes a viernes, 8:00–21:00 · Sábados, 9:00–14:00",
      averias: "Averías 24 h, todos los días del año"
    },

    /* Municipios con cobertura. estado: "10g" | "1g" | "obras" */
    cobertura: [
      { m: "Girona", cp: "17001", comarca: "Gironès", estado: "10g" },
      { m: "Salt", cp: "17190", comarca: "Gironès", estado: "10g" },
      { m: "Sarrià de Ter", cp: "17840", comarca: "Gironès", estado: "10g" },
      { m: "Sant Gregori", cp: "17150", comarca: "Gironès", estado: "1g" },
      { m: "Bescanó", cp: "17162", comarca: "Gironès", estado: "1g" },
      { m: "Celrà", cp: "17460", comarca: "Gironès", estado: "10g" },
      { m: "Bordils", cp: "17462", comarca: "Gironès", estado: "1g" },
      { m: "Flaçà", cp: "17463", comarca: "Gironès", estado: "1g" },
      { m: "Cassà de la Selva", cp: "17244", comarca: "Gironès", estado: "10g" },
      { m: "Llagostera", cp: "17240", comarca: "Gironès", estado: "1g" },
      { m: "Quart", cp: "17242", comarca: "Gironès", estado: "1g" },
      { m: "Fornells de la Selva", cp: "17458", comarca: "Gironès", estado: "10g" },
      { m: "Vilablareix", cp: "17180", comarca: "Gironès", estado: "10g" },
      { m: "Aiguaviva", cp: "17181", comarca: "Gironès", estado: "1g" },
      { m: "Riudellots de la Selva", cp: "17457", comarca: "Gironès", estado: "10g" },

      { m: "Vic", cp: "08500", comarca: "Osona", estado: "10g" },
      { m: "Manlleu", cp: "08560", comarca: "Osona", estado: "10g" },
      { m: "Torelló", cp: "08570", comarca: "Osona", estado: "1g" },
      { m: "Roda de Ter", cp: "08510", comarca: "Osona", estado: "1g" },
      { m: "Centelles", cp: "08540", comarca: "Osona", estado: "1g" },
      { m: "Tona", cp: "08551", comarca: "Osona", estado: "1g" },
      { m: "Taradell", cp: "08552", comarca: "Osona", estado: "1g" },
      { m: "Sant Hipòlit de Voltregà", cp: "08512", comarca: "Osona", estado: "obras" },
      { m: "Folgueroles", cp: "08519", comarca: "Osona", estado: "1g" },
      { m: "Calldetenes", cp: "08506", comarca: "Osona", estado: "1g" },
      { m: "Gurb", cp: "08503", comarca: "Osona", estado: "10g" },
      { m: "Seva", cp: "08553", comarca: "Osona", estado: "obras" },
      { m: "Sant Julià de Vilatorta", cp: "08504", comarca: "Osona", estado: "1g" },

      { m: "Ripoll", cp: "17500", comarca: "Ripollès", estado: "10g" },
      { m: "Campdevànol", cp: "17530", comarca: "Ripollès", estado: "1g" },
      { m: "Sant Joan de les Abadesses", cp: "17860", comarca: "Ripollès", estado: "1g" },
      { m: "Ribes de Freser", cp: "17534", comarca: "Ripollès", estado: "1g" },
      { m: "Queralbs", cp: "17539", comarca: "Ripollès", estado: "obras" },
      { m: "Camprodon", cp: "17867", comarca: "Ripollès", estado: "1g" },
      { m: "Setcases", cp: "17869", comarca: "Ripollès", estado: "obras" },
      { m: "Llanars", cp: "17869", comarca: "Ripollès", estado: "1g" },
      { m: "Vilallonga de Ter", cp: "17869", comarca: "Ripollès", estado: "obras" },
      { m: "Gombrèn", cp: "17531", comarca: "Ripollès", estado: "obras" },
      { m: "Planoles", cp: "17535", comarca: "Ripollès", estado: "1g" },
      { m: "Pardines", cp: "17537", comarca: "Ripollès", estado: "obras" },
      { m: "Vallfogona de Ripollès", cp: "17862", comarca: "Ripollès", estado: "1g" }
    ],

    /* Textos del comprobador de cobertura */
    coberturaMsg: {
      "10g": {
        titulo: "Llegamos con fibra de 10 Gb",
        texto: "Tu calle está dentro del anillo. Instalación en 72 horas laborables, sin obra y sin cuota de alta."
      },
      "1g": {
        titulo: "Llegamos con fibra de 1 Gb",
        texto: "Cobertura completa en el municipio. Los 10 Gb llegan a lo largo de este año; el cambio será gratuito."
      },
      obras: {
        titulo: "Estamos tendiendo la fibra",
        texto: "Hay obra abierta en el municipio. Déjanos tu dirección y te avisamos el día que abrimos el nodo."
      },
      no: {
        titulo: "Todavía no llegamos ahí",
        texto: "No está en el plan de este año, pero cada solicitud cuenta para el siguiente. Apúntate y te escribimos cuando haya fecha."
      }
    },

    /* Tarifas: convergentes (fibra + móvil) y solo fibra */
    tarifas: {
      convergente: [
        {
          id: "basica",
          nombre: "Bàsica",
          resumen: "Para una casa de dos, con teletrabajo puntual.",
          precio: 28,
          antes: null,
          destacada: false,
          incluye: [
            "600 Mb simétricos de fibra",
            "1 línea móvil con 25 GB en 5G",
            "Llamadas ilimitadas a fijos y móviles",
            "Router Wi‑Fi 6 en propiedad",
            "Instalación y alta gratuitas"
          ]
        },
        {
          id: "comarca",
          nombre: "Comarca",
          resumen: "La que contratan 6 de cada 10 hogares.",
          precio: 38,
          antes: 45,
          destacada: true,
          incluye: [
            "1 Gb simétrico de fibra",
            "2 líneas móviles con 60 GB en 5G",
            "Llamadas ilimitadas y roaming en la UE",
            "Router Wi‑Fi 6 + repetidor mallado",
            "IP fija sin coste si la pides"
          ]
        },
        {
          id: "total",
          nombre: "Total",
          resumen: "Casas grandes, familias numerosas, gente que sube vídeo.",
          precio: 59,
          antes: null,
          destacada: false,
          incluye: [
            "10 Gb simétricos de fibra",
            "4 líneas móviles ilimitadas en 5G",
            "Wi‑Fi mallado en toda la casa (3 puntos)",
            "IP fija y puertos abiertos a petición",
            "Prioridad de avería en menos de 8 h"
          ]
        }
      ],
      fibra: [
        {
          id: "fibra-600",
          nombre: "Fibra 600",
          resumen: "Suficiente para dos personas y una tele.",
          precio: 22,
          antes: null,
          destacada: false,
          incluye: [
            "600 Mb simétricos, subida real",
            "Router Wi‑Fi 6 en propiedad",
            "Instalación y alta gratuitas",
            "Sin permanencia, nunca",
            "Soporte técnico local"
          ]
        },
        {
          id: "fibra-1000",
          nombre: "Fibra 1 Gb",
          resumen: "El punto dulce entre precio y margen.",
          precio: 29,
          antes: 34,
          destacada: true,
          incluye: [
            "1 Gb simétrico, subida real",
            "Router Wi‑Fi 6 + repetidor mallado",
            "IP fija sin coste si la pides",
            "Sin permanencia, nunca",
            "Soporte técnico local"
          ]
        },
        {
          id: "fibra-10000",
          nombre: "Fibra 10 Gb",
          resumen: "Para quien mueve archivos, no páginas.",
          precio: 45,
          antes: null,
          destacada: false,
          incluye: [
            "10 Gb simétricos, subida real",
            "Wi‑Fi mallado en toda la casa (3 puntos)",
            "IP fija y puertos abiertos a petición",
            "Prioridad de avería en menos de 8 h",
            "Soporte técnico local"
          ]
        }
      ]
    },

    movil: [
      { nombre: "Justa", datos: "25 GB", precio: 8 },
      { nombre: "Holgada", datos: "60 GB", precio: 12 },
      { nombre: "Sin contar", datos: "Datos ilimitados", precio: 18 }
    ],

    testimonios: [
      {
        texto: "Vivimos a cuatro kilómetros del pueblo y llevábamos ocho años con un radioenlace que se caía cada tormenta. Tornarem tendió la fibra hasta la masía en once días.",
        nombre: "Roser Puigdemunt",
        rol: "Ganadería Can Serrat · Vallfogona de Ripollès"
      },
      {
        texto: "Llamé un domingo a las nueve de la noche por una avería. Me cogió una persona, no un menú de opciones. El lunes a primera hora tenía técnico en casa.",
        nombre: "Marc Aleñà",
        rol: "Cliente desde 2019 · Manlleu"
      },
      {
        texto: "Somos doce en la oficina y subimos vídeo todo el día. Pasamos de esperar la subida a no pensar en ella. Y la factura no ha cambiado en tres años.",
        nombre: "Núria Bosch",
        rol: "Estudio Ramal · Girona"
      }
    ],

    faq: [
      {
        q: "¿La fibra es vuestra o la alquiláis?",
        a: "Es nuestra. Desplegamos y mantenemos 480 km de anillo propio y damos servicio directamente sobre él. En los cuatro municipios donde todavía no hemos llegado usamos red mayorista, y lo decimos antes de firmar."
      },
      {
        q: "¿Qué pasa si me mudo dentro de la zona?",
        a: "El traslado es gratuito y no reinicia nada: mismo precio, mismo contrato. Si te mudas fuera de nuestra cobertura, cancelas sin penalización ni devolución de equipos."
      },
      {
        q: "¿Me vais a subir el precio dentro de un año?",
        a: "No. El precio que firmas es el que pagas mientras mantengas la tarifa. No aplicamos subidas por IPC ni descuentos de bienvenida que caducan a los doce meses."
      },
      {
        q: "¿Cuánto tarda la instalación?",
        a: "72 horas laborables desde que confirmas, si tu calle ya tiene nodo abierto. Si hace falta obra en la fachada o acometida nueva, entre una y tres semanas, y te damos fecha cerrada antes de empezar."
      },
      {
        q: "¿Puedo mantener mi número?",
        a: "Sí, de fijo y de móvil. Nos ocupamos nosotros de la portabilidad y coordinamos el corte para que no pierdas servicio más de unos minutos."
      },
      {
        q: "¿Tenéis atención en catalán?",
        a: "Sí, y en castellano. Todo el equipo de atención y los técnicos están en Girona y Vic: no hay centro de llamadas externo ni horario de otro huso."
      }
    ],

    empresas: [
      {
        titulo: "Fibra dedicada",
        texto: "Ancho de banda garantizado al 100 % y simétrico, de 100 Mb a 10 Gb, con SLA de disponibilidad del 99,95 % y compensación automática en factura."
      },
      {
        titulo: "Centralita virtual",
        texto: "Extensiones, colas, locuciones y desvíos gestionados desde el navegador. Se integra con tu CRM y sobrevive a un corte porque vive en nuestros dos centros de datos."
      },
      {
        titulo: "Backup 5G automático",
        texto: "Un router con doble WAN que salta a 5G en menos de tres segundos cuando la fibra cae. Ni te enteras, salvo por el aviso que te llega al móvil."
      },
      {
        titulo: "Red multisede (SD‑WAN)",
        texto: "Todas tus oficinas en la misma red privada, con políticas por aplicación y un panel donde ves qué sede consume qué. Sin equipos que comprar."
      },
      {
        titulo: "Housing y nube local",
        texto: "Racks en Girona y Vic, con energía redundante y refrigeración libre. Tus datos se quedan en la comarca y cumples RGPD sin asteriscos."
      },
      {
        titulo: "Técnico asignado",
        texto: "Una persona con nombre que conoce tu instalación, no una cola de tickets. Visita de revisión dos veces al año, incluida."
      }
    ]
  };
})();
