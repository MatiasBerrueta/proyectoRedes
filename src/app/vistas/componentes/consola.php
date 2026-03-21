<?php
    $pathName = $_SERVER['REQUEST_URI'];
    $serverId = basename(parse_url($pathName, PHP_URL_PATH));
    require_once APP_ROOT . 'modelos/api/pterodactylClientApi.php';

    $clienteApiKey = 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I';
    $api = new pterodactylClientApi($clienteApiKey);
    $datosServidor = $api->obtenerServidorPorId($idServidor);
    $recursosServidor = $api->obtenerRecursosServidorPorId($idServidor);
    $logsConsola = $api->obtenerConsola($idServidor);

    function cleanLog($line) {
        if (preg_match('/\[(.*?)\] \[(.*?)\/(.*?)\]: (.*)/', $line, $matches)) {
            return "[{$matches[1]} {$matches[3]}]: {$matches[4]}";
        }

        return $line;
    }

    $lines = explode("\n", $logsConsola);

    echo "<script>console.log(" . json_encode($datosServidor) . ")</script>";
    echo "<script>console.log(" . json_encode($recursosServidor) . ")</script>";

    $nombreServidor = $datosServidor['attributes']['name'];
    $estadoServidor = $recursosServidor['attributes']['current_state'];
    $datosIp = $datosServidor['attributes']['relationships']['allocations']['data'][0]['attributes'];
    // $ipServidor = $datosIp['ip'] . $datosIp['port'];

?>

<div style="height: 400px;">
    <div class="titulo-acciones">
        <h1 class="font-size-6">Resumen - <?= $nombreServidor ?? 'Servidor muestra 1' ?></h1>
        <div class="acciones-servidor">
            <button class="boton iniciar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-player-play"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 4v16l13 -8l-13 -8" /></svg>
                Iniciar
            </button>
            <button class="boton detener">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-player-stop"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2l0 -10" /></svg>
                Detener
            </button>
            <button class="boton reiniciar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-rotate-rectangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.09 4.01l.496 -.495a2 2 0 0 1 2.828 0l7.071 7.07a2 2 0 0 1 0 2.83l-7.07 7.07a2 2 0 0 1 -2.83 0l-7.07 -7.07a2 2 0 0 1 0 -2.83l3.535 -3.535h-3.988" /><path d="M7.05 11.038v-3.988" /></svg>
                Reiniciar
            </button>
        </div>
    </div>
    <!-- <h2>Nombre: </h2> -->
    <div class="consola-estadisticas-contenedor">
        <div class="consola">
            <div class="contenido-consola">
                <?php
                    foreach ($lines as $line) {
                        $line = trim($line);

                        if ($line === '') continue;

                        echo "<div>" . cleanLog($line) . "</div>";
                    }
                ?>
            </div>
            <div class="input-consola">
                <span>$</span>
                <input type="text" placeholder="Enter server command...">
                <button class="boton">Enviar</button>
            </div>
        </div>
        <div class="estadisticas">
            <div class="contenedor-estadistica">
                <div>
                    <small>Estado</small>
                    <span class="texto-estado font-size-4"><?= $estadoServidor ?? 'Online' ?>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /></svg>
            </div>
             <div class="contenedor-estadistica">
                <div>
                    <small>Jugadores</small>
                    <span class="texto-estado font-size-4"><?= $cantidadJugadores ?? '10/20'?>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
            </div>
            <div class="contenedor-estadistica">
                <div>
                    <small>Ip</small>
                    <span><span class="texto-ip font-size-4"><?= $ipServidor ?? 'admin.hosting.com' ?></span></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>
            </div>
            <div class="contenedor-estadistica">
                <div>
                    <small>Uptime</small>
                    <span><span class="texto-ip font-size-4">5h</span></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>
            </div>
            <div class="contenedor-estadistica">
                <div>
                    <small>TPS</small>
                    <span><span class="texto-ip font-size-4">19.8</span></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>
            </div>
        </div>
    </div>
    <div class="actividades">
        <h2 class="font-size-6">Actividad reciente</h2>
        <div class="contenedor-actividades">
            <div class="actividad">
                
            </div>
        </div>
    </div>
</div>

<script>
    const botonCopiarIp = document.querySelector('.texto-ip');

    botonCopiarIp.addEventListener('click', () => {
        ipServidor = botonCopiarIp.innerText;
        navigator.clipboard.writeText(ipServidor)
        .then(() => {
            alert('texto copiado');
        });
    })
</script>