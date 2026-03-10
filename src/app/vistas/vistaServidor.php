<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/panelUsuario.css">
    <script src="/js/controladorTemas.js" defer></script>
    <title>Usuario</title>
</head>
<body>
    <?php require_once 'componentes/header.php'; ?>
    <main>
        <section class="seccion-servidores">
            <a href="/panel/servidores">Volver a lista servidores</a>
            <?php require_once APP_ROOT . "vistas/componentes/$tab.php"; ?>
            <!-- <div id="contenido"></div> -->
        </section>
        <aside id="sidemenu">
            <nav>
                <ul>
                    <li class="activo" data-tab="consola"><a href="/panel/servidores/<?= $idServidor ?>">Consola</a></li>
                    <li data-tab="monitor"><a href="/panel/servidores/<?= $idServidor ?>/monitor">Monitor</a></li>
                    <li data-tab="configuraciones"><a href="/panel/servidores/<?= $idServidor ?>/configuracion">Configuracion</a></li>
                    <li data-tab="archivos"><a href="/panel/servidores/<?= $idServidor ?>/archivos">Archivos</a></li>
                </ul>
            </nav>
        </aside>
    </main>
    <script>
        const consola = document.querySelector('.contenido-consola');
        const botonIniciar = document.querySelector('.boton-iniciar');
        const botonDetener = document.querySelector('.boton-detener');
        const botonReiniciar = document.querySelector('.boton-reiniciar');
        const textoEstatus = document.querySelector('.texto-estatus');
        
        const pathName = window.location.pathname;
        const serverId = pathName.split('/').pop();

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

                        const nuevaLinea = document.createElement("div");
                        nuevaLinea.textContent = message.args[0];
                        consola.appendChild(nuevaLinea);
                        consola.parentElement.scrollTop = consola.parentElement.scrollHeight;
                        break;
                    case 'status':
                        console.log('Status changed:', message.args[0]);
                        textoEstatus.innerText = message.args[0];
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