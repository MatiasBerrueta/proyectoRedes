<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/paginaPrincipal.css">
    <script src="/js/controladorTemas.js" defer></script>
    <title>Pagina principal - Voxel Hosting</title>
</head>
<body class="">
    <?php include_once 'componentes/header.php'; ?>
    <main>
        <section class="seccion-presentacion">
            <div class="contenedor">
                <h1 class="font-size-8">Crea tu servidor en minutos
                <br>juega sin limites.</h1>
                <p class="font-size-5">Tú eliges el juego y el tamaño de tu comunidad, nosotros nos ocupamos de la 
                <br>configuración, el rendimiento y el soporte para que disfrutes sin complicaciones.</p>
                <button class="boton font-size-4 flex-align-items">
                    Empezar ahora 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                </button>
            </div>
        </section>
        <section class="seccion-features">
            <div class="contenedor">
                <span>¿Por qué elegirnos?</span>
                <div class="contenedor-razones">
                    <div class="bloque-razon">
                        <span>Rendimiento que se siente jugando</span>
                        <p>La velocidad no es solo hardware. Ajustamos cada servidor según el juego, la cantidad de jugadores y el estilo de tu comunidad. Menos lag, más partidas fluidas.</p>
                    </div>
                    <div class="bloque-razon derecha">
                        <span>Soporte que habla tu mismo idioma</span>
                        <p>Si un plugin rompe tu mundo o un mod no carga, hablamos de eso todos los días. Nuestro soporte está entrenado en problemas reales de gaming, no en respuestas genéricas.</p>
                    </div>
                    <div class="bloque-razon derecha">
                        <span>Tu servidor, tu estilo</span>
                        <p>Desde servidores para amigos hasta comunidades grandes: elegí la región, modpacks, slots y recursos. Nuestro sistema te recomienda el plan que encaja mejor con tu forma de jugar.</p>
                    </div>
                    <div class="bloque-razon">
                        <span>Crecemos con tu comunidad</span>
                        <p>Cuando tu servidor se llena, subir de nivel no corta la partida. Escalá RAM, CPU y almacenamiento en segundos, con backups automáticos incluidos.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="seccion-juegos">
            <div class="contenedor">
                <span>Hospeda tus juegos favoritos</span>
                <p>Desde Minecraft hasta FPS competitivos, soportamos todos los títulos principales con rendimiento optimizado.</p>
                <div class="carrusel-juegos">
                    <div class="slider">
                        <div class="juego">
                            <img src="assets/portadaMinecraft.jpeg" alt="Portada Minecraft">
                            <div class="informacion-juego">
                                <h3>Minecraft</h3>
                                <p>Un juego sandbox infinito donde puedes crear, explorar y cooperar con amigos. Compatible con mods, plugins y múltiples versiones.</p>
                                <!-- <button>Mas informacion</button> -->
                            </div>
                        </div>
                        <div class="juego">
                            <img src="assets/portada-counter-strike-2.webp" alt="Portada Counter-Strike 1.6">
                            <div class="informacion-juego">
                                <h3>Counter-Strike 1.6</h3>
                                <p>Un clásico FPS competitivo donde dos equipos se enfrentan en partidas rápidas y tácticas. Ligero, rápido y con miles de mods disponibles.</p>
                                <!-- <button>Mas informacion</button> -->
                            </div>
                        </div>
                        <div class="juego">
                            <img src="assets/portada-terraria.png" alt="Portada Terraria">
                            <div class="informacion-juego">
                                <h3>Terraria</h3>
                                <p>Un juego de aventura y exploración en 2D con construcción, combate y jefes épicos. Perfecto para mundos cooperativos y servidores persistentes.</p>
                                <!-- <button>Mas informacion</button> -->
                            </div>
                        </div>
                        <div class="juego">
                            <img src="assets/portada-left-4-dead-2.webp" alt="Portada Left 4 Dead 2">
                            <div class="informacion-juego">
                                <h3>Left 4 Dead 2</h3>
                                <p>Un shooter cooperativo contra hordas de infectados. Ideal para campañas personalizadas, modos competitivos y servidores dedicados.</p>
                                <!-- <button>Mas informacion</button> -->
                            </div>
                        </div>
                        <div class="juego">
                            <img src="assets/portada-valheim.jpg" alt="Portada Valheim">
                            <div class="informacion-juego">
                                <h3>Valheim</h3>
                                <p>Un juego de supervivencia inspirado en la mitología nórdica. Construye bases, explora biomas y enfréntate a jefes en mundos generados proceduralmente.</p>
                                <!-- <button>Mas informacion</button> -->
                            </div>
                        </div>
                    </div>
                    <script>
                        const slider = document.querySelector('.slider');
                        slider.innerHTML += slider.innerHTML;
                    </script>
                </div>
            </div>
        </section>
        <section class="seccion-planes">
            <div class="contenedor">
                <span>Conoce nuestros planes</span>
                <p>Nuestros planes estan pensandos para darte una experiencia de juego fluida y a un bajo precio</p>
                <div class="contenedor-planes">
                    <?php controladorPlan::listarPlanes() ?>
                </div>
                <p>¿No estás seguro de qué plan elegir? Usa nuestro <a href="">asistente de planes</a> o <a href="">crea uno a tu medida.</a></p>
            </div>
        </section>
        <section class="seccion-tutorial">
            <div class="contenedor">
                <span>Como usar Voxel Hosting</span>
                <div>
                    <div class="descripcion-paso">
                        <span>01. Crea tu cuenta</span>
                        <p>Regístrate en segundos con tu correo o cuenta social.</p>
                    </div>
                    <img src="" alt="" class="display-paso active">
                </div>
                <div>
                    <div class="descripcion-paso">
                        <span>02. Elegi un juego</span>
                        <p>Selecciona entre más de 20 juegos soportados y configura tu servidor.</p>
                    </div>
                    <img src="" alt="" class="display-paso active">
                </div>
                <div>
                    <div class="descripcion-paso">
                        <span>03. Adquiri un plan</span>
                        <p>Elegi uno de nuestros planes segun tus preferencias.</p>
                        <div class="barra-carga"></div>
                    </div>
                    <img src="" alt="" class="display-paso active">
                </div>
                <div>
                    <div class="descripcion-paso">
                        <span>04. Desplega el servidor</span>
                        <p>Presiona desplegar y mira tu servidor en línea en menos de un minuto.</p>
                        <div class="barra-carga"></div>
                    </div>
                    <img src="" alt="" class="display-paso active">
                </div>
                <div>
                    <div class="descripcion-paso">
                        <span>05. Empeza a jugar!</span>
                        <p>Comparte tu IP del servidor y comienza a jugar con amigos inmediatamente.</p>
                        <div class="barra-carga"></div>
                    </div>
                    <img src="" alt="" class="display-paso active">
                </div>
            </div>
        </section>
    </main>
    <?php include_once 'componentes/footer.php' ?>
</body>
</html>