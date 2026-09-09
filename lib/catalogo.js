/* TORNAREM — catálogo y datos de la tienda.
   Lo leen a la vez el navegador (main.js) y el servidor (pedido.php).
   Por eso, todo lo que va después del signo igual tiene que ser JSON puro:
   comillas dobles, sin comentarios, sin coma después del último elemento. */
window.__TIENDA__ = {
  "marca": "Tornarem",
  "claim": "Lotes de devoluciones de Amazon",
  "contacto": {
    "telefono": "900 000 000",
    "telefonoHref": "tel:+34900000000",
    "whatsapp": "34600000000",
    "email": "pedidos@tornarem.cat",
    "direccion": "Nave 14 · Polígono Mas Xirgu · 17005 Girona",
    "horario": "Lunes a viernes, 8:00–18:00"
  },
  "envio": {
    "texto": "Envío 24 h incluido en península",
    "horaCorte": 14,
    "notaPales": "Los palés viajan con transporte especializado: 24–48 h.",
    "notaIslas": "Baleares y Canarias: pide presupuesto antes de comprar."
  },
  "contrarreembolso": {
    "porcentaje": 3,
    "minimo": 5
  },
  "lotes": [
    {
      "id": "lote-electronica",
      "ref": "TR-2609-01",
      "nombre": "Electrónica de consumo",
      "categoria": "Electrónica",
      "resumen": "Auriculares, altavoces Bluetooth, smartwatches, tablets y accesorios de carga.",
      "uds": 42,
      "grado": "A/B",
      "formato": "Caja 60×40×40 cm",
      "peso": "19 kg",
      "pvp": 2640,
      "precio": 549,
      "stock": 4,
      "img": "assets/img/lote-electronica.webp",
      "contenido": [
        "12 auriculares inalámbricos (diadema y true wireless)",
        "6 altavoces Bluetooth portátiles",
        "5 smartwatches y pulseras de actividad",
        "3 tablets de 10 pulgadas",
        "8 cargadores rápidos y baterías externas",
        "8 accesorios: cables, hubs USB-C, soportes"
      ],
      "nota": "Todo probado: enciende, carga y empareja. El 70 % conserva su caja original."
    },
    {
      "id": "lote-hogar-cocina",
      "ref": "TR-2609-02",
      "nombre": "Pequeño electrodoméstico",
      "categoria": "Hogar y cocina",
      "resumen": "Freidoras de aire, batidoras, cafeteras de cápsulas, un robot aspirador y tostadoras.",
      "uds": 14,
      "grado": "B",
      "formato": "Caja 80×60×60 cm",
      "peso": "38 kg",
      "pvp": 1890,
      "precio": 429,
      "stock": 3,
      "img": "assets/img/lote-hogar-cocina.webp",
      "contenido": [
        "4 freidoras de aire (3,5 a 5,5 litros)",
        "3 batidoras de vaso y de mano",
        "2 cafeteras de cápsulas",
        "1 robot aspirador con base de carga",
        "2 tostadoras y 2 hervidores eléctricos"
      ],
      "nota": "Grado B: marcas de uso leves, alguna caja golpeada. Todos funcionan."
    },
    {
      "id": "lote-juguetes",
      "ref": "TR-2609-03",
      "nombre": "Juguetes y juegos",
      "categoria": "Juguetes",
      "resumen": "Sets de construcción, peluches, juegos de mesa, coches teledirigidos, muñecas y puzles.",
      "uds": 64,
      "grado": "A/B",
      "formato": "Caja 80×60×60 cm",
      "peso": "27 kg",
      "pvp": 1720,
      "precio": 319,
      "stock": 5,
      "img": "assets/img/lote-juguetes.webp",
      "contenido": [
        "14 sets de construcción por piezas",
        "12 peluches y muñecos blandos",
        "10 juegos de mesa familiares",
        "6 coches y drones teledirigidos",
        "8 muñecas y figuras con accesorios",
        "14 puzles de 500 a 1.500 piezas"
      ],
      "nota": "Revisado pieza a pieza: los sets de construcción están completos o se indica en la etiqueta."
    },
    {
      "id": "lote-herramientas",
      "ref": "TR-2609-04",
      "nombre": "Herramientas y bricolaje",
      "categoria": "Bricolaje",
      "resumen": "Taladros y atornilladores a batería, sierra de calar, amoladora, maletines y nivel láser.",
      "uds": 18,
      "grado": "A/B",
      "formato": "Caja 60×40×40 cm",
      "peso": "41 kg",
      "pvp": 2150,
      "precio": 489,
      "stock": 2,
      "img": "assets/img/lote-herramientas.webp",
      "contenido": [
        "5 taladros percutores a batería con cargador",
        "4 atornilladores de impacto",
        "1 sierra de calar y 1 amoladora angular",
        "3 maletines de herramienta manual (108 a 216 piezas)",
        "2 niveles láser autonivelantes",
        "2 juegos de vasos y llaves"
      ],
      "nota": "Baterías comprobadas: cargan y aguantan el ciclo completo."
    },
    {
      "id": "lote-moda",
      "ref": "TR-2609-05",
      "nombre": "Moda y calzado",
      "categoria": "Moda",
      "resumen": "Zapatillas, sudaderas, vaqueros, chaquetas y mochilas. Prenda en bolsa con etiqueta.",
      "uds": 120,
      "grado": "A",
      "formato": "Caja gaylord 120×80×80 cm",
      "peso": "46 kg",
      "pvp": 3600,
      "precio": 590,
      "stock": 6,
      "img": "assets/img/lote-moda.webp",
      "contenido": [
        "28 pares de zapatillas (tallas 36 a 46) en su caja",
        "30 sudaderas y camisetas con etiqueta",
        "24 vaqueros y pantalones",
        "18 chaquetas y cortavientos",
        "20 mochilas, riñoneras y gorras"
      ],
      "nota": "Devoluciones de talla: prenda sin usar, doblada en bolsa y con etiqueta. Surtido de tallas y colores."
    },
    {
      "id": "lote-informatica",
      "ref": "TR-2609-06",
      "nombre": "Informática y periféricos",
      "categoria": "Informática",
      "resumen": "Teclados mecánicos, ratones, dos monitores, webcams, discos SSD, router e impresora.",
      "uds": 26,
      "grado": "A/B",
      "formato": "Caja 80×60×60 cm",
      "peso": "34 kg",
      "pvp": 3280,
      "precio": 699,
      "stock": 2,
      "img": "assets/img/lote-informatica.webp",
      "contenido": [
        "2 monitores de 27 pulgadas (uno curvo)",
        "6 teclados mecánicos y 6 ratones",
        "4 webcams Full HD",
        "4 discos SSD externos de 1 y 2 TB",
        "1 router Wi-Fi 6 y 1 impresora multifunción",
        "2 soportes de monitor"
      ],
      "nota": "Monitores sin píxeles muertos, verificados en mesa. Los SSD se entregan formateados."
    },
    {
      "id": "lote-deporte",
      "ref": "TR-2609-07",
      "nombre": "Deporte y fitness",
      "categoria": "Deporte",
      "resumen": "Mancuernas, kettlebells, esterillas, bicicleta estática plegable, bandas, tienda y patinete.",
      "uds": 22,
      "grado": "B",
      "formato": "Palé EUR 120×80×110 cm",
      "peso": "96 kg",
      "pvp": 2340,
      "precio": 519,
      "stock": 3,
      "img": "assets/img/lote-deporte.webp",
      "contenido": [
        "1 bicicleta estática plegable con pantalla",
        "1 patinete eléctrico plegable (batería probada)",
        "4 juegos de mancuernas ajustables y 2 kettlebells",
        "6 esterillas de yoga y 4 sets de bandas elásticas",
        "1 tienda de campaña para 4 personas",
        "3 mochilas de senderismo"
      ],
      "nota": "Viaja en palé por peso. Grado B: marcas de uso, embalajes abiertos."
    },
    {
      "id": "lote-bebe",
      "ref": "TR-2609-08",
      "nombre": "Bebé y puericultura",
      "categoria": "Bebé",
      "resumen": "Silla de coche, carrito plegable, trona, vigilabebés, esterilizador y mochila portabebé.",
      "uds": 15,
      "grado": "A/B",
      "formato": "Palé EUR 120×80×120 cm",
      "peso": "58 kg",
      "pvp": 2610,
      "precio": 559,
      "stock": 2,
      "img": "assets/img/lote-bebe.webp",
      "contenido": [
        "2 sillas de coche (grupo 0+/1 y grupo 2/3)",
        "1 carrito plegable de paseo",
        "2 tronas evolutivas",
        "2 vigilabebés con cámara",
        "1 esterilizador y 1 calientabiberones",
        "3 mochilas portabebé y 4 packs de accesorios"
      ],
      "nota": "Las sillas de coche se revisan una a una: sin golpes y con todas las piezas. Si no pasan, no salen."
    },
    {
      "id": "lote-belleza",
      "ref": "TR-2609-09",
      "nombre": "Belleza y cuidado personal",
      "categoria": "Belleza",
      "resumen": "Secadores, planchas de pelo, afeitadoras, cepillos eléctricos, depiladoras IPL y básculas.",
      "uds": 52,
      "grado": "A/B",
      "formato": "Caja 60×40×40 cm",
      "peso": "22 kg",
      "pvp": 1980,
      "precio": 389,
      "stock": 4,
      "img": "assets/img/lote-belleza.webp",
      "contenido": [
        "10 secadores de pelo (2 profesionales iónicos)",
        "8 planchas y rizadores",
        "10 afeitadoras y recortadoras",
        "10 cepillos de dientes eléctricos con cabezales",
        "6 depiladoras de luz pulsada (IPL)",
        "8 básculas inteligentes"
      ],
      "nota": "Higiene garantizada: sólo entran unidades sin usar o con cabezal precintado."
    },
    {
      "id": "lote-pale-mixto",
      "ref": "TR-2609-10",
      "nombre": "Palé mixto sin clasificar",
      "categoria": "Palés",
      "resumen": "Un palé completo tal cual baja del camión. Hogar, electrónica, juguetes, deporte y sorpresas.",
      "uds": 210,
      "grado": "Sin clasificar",
      "formato": "Palé EUR 120×80×180 cm",
      "peso": "210 kg",
      "pvp": 6500,
      "precio": 1290,
      "stock": 8,
      "img": "assets/img/lote-pale-mixto.webp",
      "contenido": [
        "Unas 210 referencias mezcladas, retractiladas en palé",
        "Reparto habitual: 40 % hogar, 25 % electrónica, 15 % juguete, 20 % varios",
        "Listado de manifiesto (referencias y PVP) por correo tras el pedido",
        "Sin abrir ni revisar: puede haber unidades defectuosas",
        "Precio por debajo del 20 % del PVP para compensarlo"
      ],
      "nota": "Es el lote para quien revende: máximo margen, máximo riesgo. Se vende cerrado y no admite devolución."
    }
  ],
  "proximoCamion": {
    "titulo": "Jardín y exterior",
    "texto": "Cortacésped a batería, cortasetos, hidrolimpiadoras, mangueras, lámparas solares, sillas plegables y barbacoas.",
    "diaSemana": 4,
    "hora": 8,
    "img": "assets/img/lote-jardin.webp"
  }
};
