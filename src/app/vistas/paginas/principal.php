<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    (function() {
        const temaGuardado = localStorage.getItem('tema');
        if (temaGuardado === 'oscuro') document.documentElement.classList.add('tema-oscuro');
    })();
    </script>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/componentes.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/paginas/landing.css">
    <script src="/js/controladorTemas.js" defer></script>
    <script src="/js/separadorPixeladoGenerador.js" defer></script>
    <title>Pagina principal - Voxel Hosting</title>
</head>
<body class="layout-landing">
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <section class="seccion-presentacion">
            <div class="contenedor">
                <p class="eyebrow">No te compliques</p>
                <h1 class="hero-copy">
                    Crea tu servidor en minutos,
                    <br>disfruta con amigos.
                </h1>
                <p class="hero-subtexto">Tú eliges el juego y el tamaño de tu comunidad, nosotros nos ocupamos de la 
                <br>configuración, el rendimiento y el soporte para que disfrutes sin complicaciones.</p>
                <a href="#" class="boton texto-g flex-align-items">
                    Empieza tu prueba gratuita
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                </a>
                <p class="cta-subtexto">Sin tarjeta de credito. 1 dia gratis.</p>
                <?php include PUBLIC_ROOT . 'assets/ilustracion.svg'; ?>
            </div>
        </section>
         <section class="seccion-tutorial">
            <div class="contenedor">
                <span class="seccion__titulo">Facil de configurar</span>
                <div class="tarjetas-tutorial">   
                    <!-- <div class="tarjeta">
                        <span>Paso 1</span>
                        <div class="tarjeta-contenido">
                            <div>
                                <span>Crea tu cuenta</span>
                                <p>Regístrate en segundos con tu correo o cuenta social.</p>
                            </div>
                            <div class="img"></div>
                            <img src="" alt="">
                        </div>
                    </div> -->
                    <div class="tarjeta">
                        <span class="tarjeta__paso">Paso 1</span>
                        <div class="tarjeta-contenido">
                            <div>
                                <span>Elegi un juego</span>
                                <p>Selecciona entre más de 20 juegos soportados y configura tu servidor.</p>
                            </div>
                            <div class="img"></div>
                            <!-- <img src="" alt=""> -->
                        </div>
                    </div>
                    <div class="tarjeta">
                        <span class="tarjeta__paso">Paso 2</span>
                        <div class="tarjeta-contenido">
                            <div>
                                <span>Adquiri un plan</span>
                                <p>Elegi uno de nuestros planes segun tus preferencias.</p>
                            </div>
                            <div class="img"></div>
                            <!-- <img src="" alt=""> -->
                        </div>
                    </div>
                    <div class="tarjeta">
                        <span class="tarjeta__paso">Paso 3</span>
                        <div class="tarjeta-contenido">
                            <div>
                                <span>Desplega el servidor</span>
                                <p>Presiona desplegar y mira tu servidor en línea en menos de un minuto.</p>
                            </div>
                            <div class="img"></div>
                            <!-- <img src="" alt=""> -->
                        </div>
                    </div>
                    <div class="tarjeta">
                        <span class="tarjeta__paso">Paso 4</span>
                        <div class="tarjeta-contenido">
                            <div>
                                <span>Empeza a jugar!</span>
                                <p>Comparte tu IP del servidor y comienza a jugar con amigos inmediatamente.</p>
                            </div>
                            <div class="img"></div>
                            <!-- <img src="" alt=""> -->
                        </div>
                    </div>
                    <div class="linea">
                        <div class="marcador"></div>
                        <div class="marcador"></div>
                        <div class="marcador"></div>
                        <div class="marcador"></div>
                    </div> 
                </div>
                <div class="cta-tutorial">
                    <div>
                        <span class="texto-g cta-tutorial__titulo">Probalo gratis hoy</span>
                        <p class="texto-secundario">Disfruta de 1 dia de prueba gratis sin tarjeta - Tu servidor en minutos</p>
                    </div>
                    <button>Comenzar prueba gratis</button>
                </div>
            </div>
        </section>
        <section class="seccion-juegos">
            <div class="contenedor">
                <span class="seccion__titulo">Hospeda tus juegos favoritos</span>
                <p class="seccion__descripcion">Desde Minecraft hasta FPS competitivos, soportamos todos los títulos principales con rendimiento optimizado.</p>
                <div class="carrusel-juegos">
                    <div class="slider-juegos">
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
        <section class="seccion-testimonios">
            <div class="contenedor">
                <span class="seccion__titulo">Gente real, servidores reales</span>
                <p class="seccion__descripcion">Mira lo que opinan nuestros clientes sobre nosotros.</p>
                <div class="contenedor-testimonios">
                    <div class="testimonio">
                        <div class="comillas">"</div>
                        <p>Tenía el servidor de Valheim andando antes de que mis amigos terminaran de descargar el juego.</p>
                        <div class="separador"></div>
                        <div class="testimonio-footer">
                            <div class="foto-usuario"></div>
                            <div>
                                <span class="nombre-usuario">Matias</span>
                                <span class="tipo-usuario">Anonimo</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonio">
                        <div class="comillas">"</div>
                        <p>Siempre intenté armar servidores yo mismo y siempre terminaba peleado con mis amigos antes de jugar. Esto lo resolvió en tres clics.</p>
                        <div class="separador"></div>
                        <div class="testimonio-footer">
                            <div class="foto-usuario"></div>
                            <div>
                                <span class="nombre-usuario">Matias</span>
                                <span class="tipo-usuario">Anonimo</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonio">
                        <div class="comillas">"</div>
                        <p>Instalé un modpack de Minecraft que nunca había funcionado en otro hosting. Le pregunté al soporte y en diez minutos estaba andando.</p>
                        <div class="separador"></div>
                        <div class="testimonio-footer">
                            <div class="foto-usuario"></div>
                            <div>
                                <span class="nombre-usuario">Matias</span>
                                <span class="tipo-usuario">Anonimo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="pixel-separator" data-seed="1500" data-direction="up"></div>
        <section class="seccion-features">
            <div class="contenedor">
                <span class="seccion__titulo">¿Por qué elegirnos?</span>
                <p class="seccion__descripcion">Nos enfocamos en darte la mejor experiencia posible.</p>
                <div class="contenedor-razones">
                    <div class="bloque-razon bloque-razon--destacado">
                        <span>Listo en minutos sin esfuerzo.</span>
                        <p>La velocidad no es solo hardware. Ajustamos cada servidor según el juego, la cantidad de jugadores y el estilo de tu comunidad. Menos lag, más partidas fluidas.</p>
                        <div class="imagen-placeholder"></div>
                    </div>
                    <div class="bloque-razon">
                        <span>Soporte que entiende de juegos.</span>
                        <p>Si un plugin rompe tu mundo o un mod no carga, hablamos de eso todos los días. Nuestro soporte está entrenado en problemas reales de gaming, no en respuestas genéricas.</p>
                        <div class="imagen-placeholder"></div>
                    </div>
                    <div class="bloque-razon">
                        <span>Instala mods sin complicaciones.</span>
                        <p>Desde servidores para amigos hasta comunidades grandes: elegí la región, modpacks, slots y recursos. Nuestro sistema te recomienda el plan que encaja mejor con tu forma de jugar.</p>
                        <div class="imagen-placeholder"></div>
                    </div>
                    <!-- <div class="bloque-razon">
                        <span>Crecemos con tu comunidad</span>
                        <p>Cuando tu servidor se llena, subir de nivel no corta la partida. Escalá RAM, CPU y almacenamiento en segundos, con backups automáticos incluidos.</p>
                    </div> -->
                    <!-- <div class="bloque-razon">
                        <span>Crecemos con tu comunidad</span>
                        <p>Cuando tu servidor se llena, subir de nivel no corta la partida. Escalá RAM, CPU y almacenamiento en segundos, con backups automáticos incluidos.</p>
                    </div>
                    <div class="bloque-razon">
                        <span>Crecemos con tu comunidad</span>
                        <p>Cuando tu servidor se llena, subir de nivel no corta la partida. Escalá RAM, CPU y almacenamiento en segundos, con backups automáticos incluidos.</p>
                    </div> -->
                </div>
            </div>
        </section>
        <div class="pixel-separator" data-seed="1520" data-direction="down"></div>
        <section class="seccion-planes">
            <div class="contenedor">
                <span class="seccion__titulo">Planes accesibles y competitivos</span>
                <p class="seccion__descripcion">Nuestros planes estan pensandos para darte una experiencia de juego fluida y a un bajo precio</p>
                <div class="contenedor-planes">
                    <?php
                    if(isset($planes)) {
                        foreach($planes as $plan) {
                            include APP_ROOT . 'vistas/componentes/plan.php';
                        }
                    }
                    ?>
                </div>
                <div class="planes-adicionales">
                    <span>¿No estás seguro de qué plan elegir?</span>
                    <p> Usa nuestro <a href="">asistente de planes</a> o <a href="">crea uno a tu medida.</a></p>
                </div>
                
            </div>
        </section>
        <div class="pixel-separator" data-seed="150" data-direction="up" data-color="hsl(225, 75%, 65%)"></div>
        <section class="seccion-final">  
            <div class="contenedor seccion-final__contenido">
                <p class="final-titulo">Listo para comenzar a jugar?</p>
                <p class="texto-semi-transparente mb-1">Creá tu servidor en minutos y jugá con tus amigos 
                sin configuraciones, sin complicaciones. </p>
                <a href="#" class="boton texto-g flex-align-items">
                    Empieza tu prueba gratuita
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                </a>
                <p class="cta-subtexto">Sin tarjeta de credito. 1 dia gratis.</p>
            </div>
        </section>
    </main>
    <div class="pixel-separator" data-seed="100" data-direction="up" data-color="hsl(235, 40%, 30%)"></div>
    <?php include_once APP_ROOT . 'vistas/componentes/footer.php'; ?>
</body>
</html>