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
    <link rel="stylesheet" href="/css/panelUsuario.css">
    <link rel="stylesheet" href="/css/servidor-contenido.css">
    <script src="/js/controladorTemas.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/ansi_up@5.0.0/ansi_up.min.js"></script>
    <title>Usuario</title>
</head>
<body>
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <aside id="sidemenu">
            <nav>
                <ul>
                    <li class="<?= $tab === 'consola' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/consola">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-terminal-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l3 3l-3 3" /><path d="M13 15l3 0" /><path d="M3 6a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -12" /></svg>
                            Consola
                        </a>
                    </li>
                    <li class="<?= $tab === 'monitor' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/monitor">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-activity-heartbeat"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12h4.5l1.5 -6l4 12l2 -9l1.5 3h4.5" /></svg>
                            Monitor
                        </a>
                    </li>
                    <li class="<?= $tab === 'configuracion' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/configuracion">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                            Configuracion
                        </a>
                    </li>
                    <li class="<?= $tab === 'archivos' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/archivos">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                            Archivos
                        </a>
                    </li>
                    <li class="<?= $tab === 'jugadores' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/jugadores">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                            Jugadores
                        </a>
                    </li>
                    <li class="<?= $tab === 'mods' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/mods">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-puzzle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1" /></svg>
                            Mods/Plugins
                        </a>
                    </li>
                    <li class="<?= $tab === 'backups' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/backups">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-archive"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 6a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><path d="M10 12l4 0" /></svg>
                            Backups
                        </a>
                    </li>
                    <li class="<?= $tab === 'logs' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/logs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-description"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M9 17h6" /><path d="M9 13h6" /></svg>
                            Logs
                        </a>
                    </li>
                    <li class="<?= $tab === 'acceso' ? 'activo' : '' ?>">
                        <a href="/panel/servidores/<?= $idServidor ?>/acceso">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-shield"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /></svg>
                            Control de acceso
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <section class="seccion-servidores">
            <a href="/panel/servidores">Volver a lista servidores</a>
            <?php require_once APP_ROOT . "vistas/secciones/$tab.php"; ?>
        </section>
    </main>
    <script>
        const consola = document.querySelector('.contenido-consola');
        const botonIniciar = document.querySelector('.boton.iniciar');
        const botonDetener = document.querySelector('.boton.detener');
        const botonReiniciar = document.querySelector('.boton.reiniciar');
        const textoEstado = document.querySelector('.texto-estado');
        
        const pathName = window.location.pathname;
        const serverId = pathName.split('/').pop();

        const ansi_up = new AnsiUp();
        ansi_up.use_classes = true;

        async function obtenerDatosWebSocket(serverId) {
            const form = new FormData();
            form.append("servidor_id", serverId);

            const res = await fetch("/api/websocket", {
                method: "POST",
                body: form
            });

            return await res.json();
        }

        let webSocket;

        async function iniciarWebSocket(serverId) {
            const datosWS = await obtenerDatosWebSocket(serverId);

            const socketUrl = datosWS.data.socket;
            const token = datosWS.data.token;

            webSocket = new WebSocket(socketUrl, [], {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Origin': 'http://localhost:8081'
                }
            });

            webSocket.onopen = function(event) {
                console.log('WebSocket connection established');
                
                webSocket.send(JSON.stringify({
                    event: 'auth',
                    args: [token]
                }));
            };

            webSocket.onmessage = function(event) {
                const message = JSON.parse(event.data);
          
                switch(message.event) {
                    case 'console output':
                        console.log('Console:', message.args[0]);

                        const raw = message.args[0];
                        const html = ansi_up.ansi_to_html(raw);
                        const div = document.createElement('div');
                        div.className = 'line';
                        div.innerHTML = html.replace(/\n/g, '<br>');

                        consola.appendChild(div);

                        consola.scrollTop = consola.scrollHeight;
                        break;
                    case 'status':
                        console.log('Status changed:', message.args[0]);
                        textoEstado.innerText = message.args[0];
                        break;
                    case 'stats':
                        const stats = JSON.parse(message.args[0]);
                        console.log('Resource usage:', stats);
                        break;
                }
            };
        }

        iniciarWebSocket(serverId);

        botonIniciar.addEventListener('click', () => {
            webSocket.send(JSON.stringify({
                event: 'set state',
                args: ['start']
            }));
        })

        botonDetener.addEventListener('click', () => {
            webSocket.send(JSON.stringify({
                event: 'set state',
                args: ['stop']
            }));
        })

        botonReiniciar.addEventListener('click', () => {
            webSocket.send(JSON.stringify({
                event: 'set state',
                args: ['restart']
            }));
        })
    </script>
</body>
</html>