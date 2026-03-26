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
    <script src="/js/controladorTemas.js" defer></script>
    <title>Usuario</title>
</head>
<body>
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <aside>
            <nav>
                <ul>
                    <li class="activo">
                        <a href="/servidores">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-2" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /><path d="M11 8h6" /><path d="M11 16h6" /></svg>
                            Mis servidores
                        </a>
                    </li>
                    <li>
                        <a href="/servidores">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-2" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /><path d="M11 8h6" /><path d="M11 16h6" /></svg>
                            Prefabricados
                        </a>
                    </li>
                    <li>
                        <a href="/servidores">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-2" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /><path d="M11 8h6" /><path d="M11 16h6" /></svg>
                            Servidores comunitarios
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <section class="seccion-servidores">
            <div class="contenedor-acciones">
                <h2 class="font-size-6">Mis servidores</h2>
                <button class="boton-crear-servidor" onclick="crearServidorModal.showModal()">
                    <?php include PUBLIC_ROOT . 'assets/iconos/plus.svg'; ?>
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
                
                    return round($bytes, $precision) . $units[$pow]; 
                }

                foreach($servidores as $servidor) {
                    include APP_ROOT . 'vistas/componentes/componenteServidor.php';
                }
                ?>
            </div>
        </section>
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
        </script>
    </main>
</body>
</html>