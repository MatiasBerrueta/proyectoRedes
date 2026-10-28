<!DOCTYPE html>
<html lang="es">
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
    <link rel="stylesheet" href="/css/paginas/soporte.css">
    <script src="/js/controladorTemas.js" defer></script>
    <title>Soporte y FAQ - Voxel Hosting</title>
</head>
<body class="layout-soporte">
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <section class="base-conocimientos" id="base-conocimientos">
            <div class="base-conocimientos__header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                    Base de Conocimientos
                </h2>
                <div class="base-conocimientos__buscador">
                    <input type="text" placeholder="Buscar en guías técnicas...">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </div>
            </div>

            <div class="base-conocimientos__grid">
                <div class="articulo-bc">
                    <span class="articulo-bc__categoria">Servidores & FTP</span>
                    <h3 class="articulo-bc__titulo">Cómo conectar por SFTP a tu Servidor</h3>
                    <p class="articulo-bc__descripcion">Aprende a usar FileZilla o WinSCP para subir modpacks o gestionar archivos directamente.</p>
                    <a href="#" class="articulo-bc__enlace">
                        Leer guía completa
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    </a>
                </div>
                <div class="articulo-bc">
                    <span class="articulo-bc__categoria">Mods & Plugins</span>
                    <h3 class="articulo-bc__titulo">Instalación de Plugins Spigot/Paper en Minecraft</h3>
                    <p class="articulo-bc__descripcion">Paso a paso para agregar plugins .jar dentro del directorio /plugins sin perder rendimiento.</p>
                    <a href="#" class="articulo-bc__enlace">
                        Leer guía completa
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    </a>
                </div>
                <div class="articulo-bc">
                    <span class="articulo-bc__categoria">Server.properties</span>
                    <h3 class="articulo-bc__titulo">Optimización de RAM y Aumentos de Tickrate</h3>
                    <p class="articulo-bc__descripcion">Ajustes en el archivo spigot.yml y paper.yml para evitar lag de entidades.</p>
                    <a href="#" class="articulo-bc__enlace">
                        Leer guía completa
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    </a>
                </div>
                <div class="articulo-bc">
                    <span class="articulo-bc__categoria">Servidores & FTP</span>
                    <h3 class="articulo-bc__titulo">Configuración de Copias de Seguridad Automáticas</h3>
                    <p class="articulo-bc__descripcion">Programa backups automáticos hacia nuestro almacenamiento externo seguro S3.</p>
                    <a href="#" class="articulo-bc__enlace">
                        Leer guía completa
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    </a>
                </div>
            </div>
        </section>
        <section class="seccion-faq">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-help-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2 -3 3 -3 3" /><circle cx="12" cy="17" r=".5" fill="currentColor" /></svg>
                Preguntas Frecuentes (FAQ)
            </h2>

            <div class="acordeon-faq">
                <div class="faq-item">
                    <button class="faq-item__pregunta">
                        <span>¿Cuánto tiempo tarda en activarse mi servidor tras realizar el pago?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                    </button>
                    <div class="faq-item__respuesta" hidden>
                        La activación es 100% automatizada e instantánea. Una vez confirmado el pago por el pasarela, recibirás los datos de acceso al Panel y SSH en menos de 60 segundos en tu correo.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__pregunta">
                        <span>¿Puedo cambiar de plan (Upgrades / Downgrades) en cualquier momento?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                    </button>
                    <div class="faq-item__respuesta" hidden>
                        Sí, totalmente. Desde tu panel de control puedes aumentar la memoria RAM, CPU o disco en un clic. El sistema calculará el prorrateo automáticamente sin borrar ninguno de tus mundos ni configuraciones.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__pregunta">
                        <span>¿Cómo funciona la protección Anti-DDoS?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                    </button>
                    <div class="faq-item__respuesta" hidden>
                        Utilizamos un sistema de mitigación en tiempo real en la capa 3, 4 y 7. Filtramos ataques UDP/TCP de hasta 3.2 Tbps sin generar un solo incremento de ping para tus jugadores.
                    </div>
                </div>
            </div>
        </section>

        <section class="seccion-tickets">
            <div class="seccion-tickets__contenedor">
                <div class="lista-tickets">
                    <div class="lista-tickets__header">
                        <h3>
                            <?php include PUBLIC_ROOT . "assets/iconos/list.svg" ?>
                            Tus Tickets <span class="lista-tickets__contador">(3)</span>
                        </h3>
                        <button type="button" class="boton boton--primario boton--s" commandfor="modal-ticket" command="show-modal">Nuevo ticket</button>
                        <div class="segmento" role="group" aria-label="Filtrar tickets">
                            <button type="button" class="segmento__item segmento__item--activo" data-filtro="todos">Todos</button>
                            <button type="button" class="segmento__item" data-filtro="activos">Activos</button>
                            <button type="button" class="segmento__item" data-filtro="cerrados">Cerrados</button>
                        </div>
                    </div>

                    <div class="lista-tickets__contenido">
                        <aside class="lista-tickets__barra">
                            <div class="lista-tickets__items">
                                <!-- Ticket 1 (Abierto) -->
                                <div class="ticket-item ticket-item--seleccionado" data-estado="abierto" data-ticket-id="1042">
                                    <div class="ticket-item__info">
                                        <div class="ticket-item__id-asunto">
                                            <span>#1042 - Optimización de Bukkit y Lags</span>
                                        </div>
                                        <div class="ticket-item__meta">
                                            <span class="ticket-item__estado ticket-item__estado--abierto">Abierto</span>
                                            <span class="ticket-item__fecha">hace 20 minutos</span>
                                        </div>
                                        <span class="ticket-item__detalles">Categoría: Técnico | Prioridad: Media</span>
                                    </div>
                                </div>

                                <!-- Ticket 3 (Abierto, resolución automática previa) -->
                                <div class="ticket-item" data-estado="abierto" data-ticket-id="1041">
                                    <div class="ticket-item__info">
                                        <div class="ticket-item__id-asunto">
                                            <span>#1041 - Instalación de plugins en mi servidor</span>
                                        </div>
                                        <div class="ticket-item__meta">
                                            <span class="ticket-item__estado ticket-item__estado--abierto">Abierto</span>
                                            <span class="ticket-item__fecha">hace 1 hora</span>
                                        </div>
                                        <span class="ticket-item__detalles">Categoría: Técnico | Prioridad: Media</span>
                                    </div>
                                </div>

                                <!-- Ticket 2 (Cerrado) -->
                                <div class="ticket-item ticket-item--cerrado" data-estado="cerrado" data-ticket-id="1039">
                                    <div class="ticket-item__info">
                                        <div class="ticket-item__id-asunto">
                                            <span>#1039 - Cambio de plan y reembolso</span>
                                        </div>
                                        <div class="ticket-item__meta">
                                            <span class="ticket-item__estado ticket-item__estado--cerrado">
                                                Cerrado
                                            </span>
                                            <span class="ticket-item__fecha">hace 4 días</span>
                                        </div>
                                        <span class="ticket-item__detalles">Categoría: Facturación | Prioridad: Baja</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado Vacío -->
                            <div class="estado-vacio" hidden>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 21V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v14l-3.5-2l-3.5 2l-3.5-2l-3.5 2z" /><path d="M9 7h1" /><path d="M14 7h1" /><path d="M9 13h6" /><path d="M9 17h6" /></svg>
                                <h4>Todavía no tienes tickets</h4>
                                <p>Abre un nuevo ticket desde el formulario y nuestro equipo técnico se pondrá en contacto contigo.</p>
                            </div>
                        </aside>

                        <!-- Chat del ticket seleccionado -->
                        <div class="hilo-ticket" data-ticket-id="1042">
                            <div class="hilo-ticket__header">
                                <h4>
                                    <span class="hilo-ticket__estado-dot"></span>
                                    TICKET #1042: Optimización de Bukkit
                                </h4>
                                <button class="boton boton--fantasma boton--s">Cerrar Hilo</button>
                            </div>
                            <div class="hilo-ticket__mensajes">
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--usuario">
                                    Hola, noto tirones cuando entran más de 25 personas al mapa.
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--tecnico">
                                    Hemos revisado tus logs. Te recomendamos ajustar el tick-distance en paper.yml a 6.
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--usuario">
                                    ¿Puedo cambiarlo desde el panel o necesito editar el archivo a mano?
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--tecnico">
                                    Puedes editarlo desde el panel en Configuración > server.properties y reiniciar.
                                </div>
                            </div>
                            <div class="hilo-ticket__respuesta">
                                <input type="text" placeholder="Escribir respuesta al técnico...">
                                <button class="boton boton--primario boton--s">Responder</button>
                            </div>
                        </div>

                        <!-- Chat ticket resuelto por agente virtual -->
                        <div class="hilo-ticket" data-ticket-id="1041" hidden>
                            <div class="hilo-ticket__header">
                                <h4>
                                    <span class="hilo-ticket__estado-dot"></span>
                                    TICKET #1041: Instalación de plugins
                                </h4>
                                <button class="boton boton--fantasma boton--s">Cerrar Hilo</button>
                            </div>
                            <div class="hilo-ticket__mensajes">
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--usuario">
                                    Hola, ¿cómo instalo plugins en mi servidor de Minecraft?
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--agente">
                                    <span class="hilo-ticket__mensaje-automatico">
                                        <?php include PUBLIC_ROOT . "assets/iconos/bulb.svg" ?>
                                        Respuesta Automatica
                                    </span>
                                    <p>
                                        Encontramos un artículo que puede resolver tu problema inmediatamente:
                                    </p>
                                    <a class="hilo-ticket__kb-link" href="#base-conocimientos">
                                        Instalación de Plugins Spigot/Paper en Minecraft
                                    </a>
                                    <div class="hilo-ticket__acciones">
                                        <p>Esto resolvio tu problema?</p>
                                        <div>
                                            <button type="button" class="boton boton--s boton--exito">Sí, resolver y cerrar</button>
                                            <button type="button" class="boton boton--s hilo-ticket__accion hilo-ticket__accion--agente">No, continuar enviando ticket a un agente</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="hilo-ticket__nota-agente">
                                    El usuario eligió continuar con un agente humano.
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--usuario">
                                    La guía me sirvió, pero quiero instalar EssentialsX y no encuentro la carpeta /plugins en el panel.
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--tecnico">
                                    Tranquilo. Ve a tu panel en Archivos → Plugins, sube el archivo EssentialsX.jar y reinicia el servidor. Si vas a usar Vault para la economía, avísanos y te dejamos los permisos configurados.
                                </div>
                            </div>
                            <div class="hilo-ticket__respuesta">
                                <input type="text" placeholder="Escribir respuesta al técnico...">
                                <button class="boton boton--primario boton--s">Responder</button>
                            </div>
                        </div>

                        <!-- Chat ticket cerrado -->
                        <div class="hilo-ticket hilo-ticket--cerrado" data-ticket-id="1039" hidden>
                            <div class="hilo-ticket__header">
                                <h4>
                                    <span class="hilo-ticket__estado-dot--cerrado"></span>
                                    TICKET #1039: Cambio de plan y reembolso
                                </h4>
                                <button class="boton boton--fantasma boton--s">Reabrir Hilo</button>
                            </div>
                            <div class="hilo-ticket__banner hilo-ticket__banner--cerrado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                                <span>Este ticket está <strong>cerrado</strong>. El chat es de solo lectura hasta que se reabra.</span>
                            </div>
                            <div class="hilo-ticket__mensajes">
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--usuario">
                                    Solicité un cambio de plan y quiero saber si me devuelven la diferencia.
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--tecnico">
                                    Claro, hemos aplicado el prorrateo automático. Revisa tu factura en el panel.
                                </div>
                                <div class="hilo-ticket__mensaje hilo-ticket__mensaje--usuario">
                                    Perfecto, ya veo el ajuste. ¡Muchas gracias!
                                </div>
                            </div>
                            <div class="hilo-ticket__respuesta">
                                <input type="text" placeholder="Escribir respuesta al técnico..." disabled>
                                <button class="boton boton--primario boton--s" disabled>Responder</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            <dialog class="modal-ticket" id="modal-ticket">
                <button type="button" class="boton-cerrar" aria-label="Cerrar" commandfor="modal-ticket" command="close" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                </button>
                <div class="formulario-ticket">
                    <h3 id="modal-ticket-titulo">
                        <?php include PUBLIC_ROOT . "assets/iconos/ticket.svg" ?>
                        Abrir Nuevo Ticket
                    </h3>
                    <p>Escribe directamente a nuestros ingenieros técnicos para resolver incidencias complejas.</p>

                    <form class="space-y-1">
                        <div class="form-group">
                            <label for="asunto">Asunto / Título</label>
                            <input type="text" id="asunto" required placeholder="Ej: Problema al cargar Modpack Forge">
                        </div>

                        <div class="formulario-ticket__grid">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <select id="categoria">
                                    <option>Soporte Técnico</option>
                                    <option>Facturación</option>
                                    <option>Configuración Especial</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mensaje">Mensaje Detallado / Logs</label>
                            <textarea class="textarea-mensaje-soporte" id="mensaje" rows="4" required placeholder="Describe tu problema o pega los errores del server.log..."></textarea>
                        </div>

                        <button type="submit" class="boton boton--primario boton--bloque">Enviar Ticket de Soporte</button>
                    </form>
                </div>
          </dialog>
    </main>
    <?php include_once APP_ROOT . 'vistas/componentes/footer.php'; ?>
    <script>
        const faqItems = document.querySelectorAll('.faq-item');
        const faqPreguntas = document.querySelectorAll('.faq-item__pregunta');
        const faqRespuestas = document.querySelectorAll('.faq-item__respuesta');

        faqPreguntas.forEach((pregunta, index) => {
            pregunta.addEventListener('click', () => {
                const respuesta = faqRespuestas[index];
                const icono = pregunta.querySelector('svg');
                const estaAbierto = respuesta.hasAttribute("hidden") === false;

                respuesta.toggleAttribute("hidden");
                icono.classList.toggle('rotado');
                pregunta.setAttribute("aria-expanded", !estaAbierto);
            });
        });

        const filtrosTickets = document.querySelectorAll('.segmento__item');
        const ticketItems = document.querySelectorAll('.ticket-item');
        const hilosTickets = document.querySelectorAll('.hilo-ticket');
        const estadoVacioTickets = document.querySelector('.estado-vacio');
        const contadorTickets = document.querySelector('.lista-tickets__contador');

        function filtrarTickets(filtroSeleccionado) {
            filtrosTickets.forEach(f => f.classList.toggle('segmento__item--activo', f === filtroSeleccionado));
            const estado = filtroSeleccionado.dataset.filtro;

            let visibles = 0;
            ticketItems.forEach(item => {
                const coincide = estado === 'todos' || item.dataset.estado === estado;
                item.hidden = !coincide;
                if (coincide) visibles++;
            });

            contadorTickets.textContent = `(${visibles})`;
            estadoVacioTickets.hidden = visibles > 0;
        }

        filtrosTickets.forEach(filtro => {
            filtro.addEventListener('click', () => filtrarTickets(filtro));
        });

        function seleccionarTicket(ticket) {
            ticketItems.forEach(item => item.classList.toggle('ticket-item--seleccionado', item === ticket));
            hilosTickets.forEach(hilo => {
                hilo.hidden = hilo.dataset.ticketId !== ticket.dataset.ticketId;
            });
        }

        ticketItems.forEach(item => {
            item.addEventListener('click', () => seleccionarTicket(item));
        });
    </script>
</body>
</html>
