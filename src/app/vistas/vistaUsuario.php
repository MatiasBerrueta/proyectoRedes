<?php
// Source - https://stackoverflow.com/a/2510459
// Posted by Leo, modified by community. See post 'Timeline' for change history
// Retrieved 2026-02-16, License - CC BY-SA 4.0

function formatBytes($bytes, $precision = 2) { 
    $units = ['B', 'KB', 'MB', 'GB', 'TB']; 
   
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
   
    $bytes /= pow(1024, $pow);
    // this will also work in place of the above line:
    // $bytes /= (1 << (10 * $pow)); 
   
    return round($bytes, $precision) . $units[$pow]; 
} 
?>

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
    <?php include_once 'componentes/header.php'; ?>
    <main>
        <section class="seccion-servidores">
            <div class="contenedor-acciones">
                <h2 class="font-size-6">Mis servidores</h2>
                <button class="boton-crear-servidor" onclick="crearServidorModal.showModal()">
                    <img src="/assets/plus.svg" alt="Icono crear servidor">
                    Crear servidor
                </button>
                <dialog id="crearServidorModal">
                    <form action="">
                        <button type="button" class="boton-cerrar-crear-servidor" onclick="crearServidorModal.close()">cerrar</button>
                        <div>
                            <label for="input-nombre">Nombre</label>
                            <input id="input-nombre" type="text">
                        </div>
                        <div>
                            <label for="selector-juego">Juego</label>
                            <select name="selector-juegos" id="selector-juegos">
                                <option value="minecraft">Minecraft</option>
                                <option value="terraria">Terraria</option>
                            </select>
                        </div>
                        <div>
                            <label for="input-descripcion">Descripcion</label>
                            <input id="input-descripcion" type="text">
                        </div>
                        <button type="submit" class="boton-crear-servidor">Crear</button>
                    </form>
                </dialog>
                <script>
                    // const botonAbrirAgregarServidorModal = document.querySelector('.boton-crear-servidor');
                    // const agregarServidorModal = document.querySelector('#crearServidorModal');
                    // const botonCerrarAgergarServidorModal = document.querySelector('.boton-cerrar-crear-servidor');

                    // botonAbrirAgregarServidorModal.addEventListener('click', () => agregarServidorModal.showModal());
                    // botonCerrarAgergarServidorModal.addEventListener('click', () => agregarServidorModal.close());
                </script>
            </div>
            <div class="contenedor-servidores">
                <?php controladorServidor::mostrarServidoresUsuario(); ?>
            </div>
        </section>
        <aside>
            <nav>
                <ul>
                    <li class="activo">Mis servidores</li>
                    <li>Backups</li>
                </ul>
            </nav>
        </aside>
        <script>
            function inicializarServidor(servidor) {
                const jugadores = parseFloat(servidor.dataset.jugadores);
                const maxJugadores = parseFloat(servidor.dataset.maxJugadores);
                const cpu = parseFloat(servidor.dataset.cpu);
                const maxCpu = parseFloat(servidor.dataset.maxCpu);
                const ram = parseFloat(servidor.dataset.ram);
                const maxRam = parseFloat(servidor.dataset.maxRam);

                const calcularPorcentaje = (valor, maximo) => (valor / maximo) * 100 + '%';

                servidor.querySelector('.barra-jugadores').style.width = calcularPorcentaje(jugadores, maxJugadores);
                servidor.querySelector('.barra-cpu').style.width = calcularPorcentaje(cpu, maxCpu);
                servidor.querySelector('.barra-ram').style.width = calcularPorcentaje(ram, maxRam);
            }

            document.querySelectorAll('.servidor').forEach(inicializarServidor);

            const contenedorServidores = document.querySelector('.seccion-servidores');

            function formatBytes(bytes, decimals = 2) {
                if (!+bytes) return '0 Bytes'

                const k = 1024
                const dm = decimals < 0 ? 0 : decimals
                const sizes = ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB']

                const i = Math.floor(Math.log(bytes) / Math.log(k))

                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
            }

            // const identifier = '1cbf818f';
            // const metricaEstado = document.getElementById(`estado-${identifier}`);
            // const metricaCpu = document.getElementById(`cpu-${identifier}`);
            // const barraCpu = document.getElementById(`barra-cpu-${identifier}`);
            // const metricaRam = document.getElementById(`ram-${identifier}`);
            // const barraRam = document.getElementById(`barra-ram-${identifier}`);
            // const botonIniciar = document.getElementById(`iniciar-${identifier}`);
            // const botonDetener = document.getElementById(`detener-${identifier}`);

            // socket.onmessage = function(event) {
            //     const message = JSON.parse(event.data);
            //     console.log(message);

            //     if (message.event === 'stats') {
            //         const stats = JSON.parse(message.args[0]);

            //         const ramActualEnGB = (stats.memory_bytes / 1024 / 1024 / 1024).toFixed(1);
            //         const ramMaximaEnGB = (stats.memory_limit_bytes / 1024 / 1024 / 1024).toFixed(1);

            //         metricaEstado.textContent = stats.state;
            //         metricaCpu.textContent = Math.floor(stats.cpu_absolute) + '%';
            //         barraCpu.style.width = Math.floor(stats.cpu_absolute) + '%';
            //         metricaRam.textContent = `${formatBytes(stats.memory_bytes)}/${formatBytes(stats.memory_limit_bytes)}`;
            //         barraRam.style.width = ((stats.memory_bytes / stats.memory_limit_bytes) * 100) + "%";
            //     }
            // };

            // botonIniciar.addEventListener('click', () => {
            //     socket.send(JSON.stringify({
            //         event: 'set state',
            //         args: ['start']
            //     }));
            // });

            // botonDetener.addEventListener('click', () => {
            //     socket.send(JSON.stringify({
            //         event: 'set state',
            //         args: ['stop']
            //     }));
            // });

        </script>
    </main>
</body>
</html>