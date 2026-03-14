<?php
    $pathName = $_SERVER['REQUEST_URI'];
    $serverId = basename(parse_url($pathName, PHP_URL_PATH));
    require_once APP_ROOT . 'modelos/api/pterodactylClientApi.php';

    $clienteApiKey = 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I';
    $api = new pterodactylClientApi($clienteApiKey);
    $datosServidor = $api->obtenerServidorPorId($idServidor);
    $recursosServidor = $api->obtenerRecursosServidorPorId($idServidor);

    echo "<script>console.log(" . json_encode($datosServidor) . ")</script>";
    echo "<script>console.log(" . json_encode($recursosServidor) . ")</script>";

    $nombreServidor = $datosServidor['attributes']['name'];
    $estadoServidor = $recursosServidor['attributes']['current_state'];
    $datosIp = $datosServidor['attributes']['relationships']['allocations']['data'][0]['attributes'];
    $ipServidor = $datosIp['ip'] . $datosIp['port'];
?>

<div>
    <h1>Consola</h1>
    <h2>Nombre: <?= $nombreServidor ?></h2>
    <!-- cambiar nombre estatus por estado en todas sus apariciones -->
    <p>Estado: <span class="texto-estatus"><?= $estadoServidor ?></span></p>
    <p>ip: <span class="texto-ip"><?= $ipServidor ?></span></p>
    <div>
        <button class="boton-iniciar">Iniciar</button>
        <button class="boton-detener">Detener</button>
        <button class="boton-reiniciar">Reiniciar</button>
        <style>
            .consola {
                background-color: #0d1117;
                color: white;
                font-family: monospace;
                font-size: 14px;
                height: 400px;
                overflow: hidden;
                border-radius: 6px;
                padding: 10px;
            }

            .contenido-consola {
                overflow-y: auto;
                box-sizing: border-box;
                white-space: pre-wrap;
                word-break: break-word;
            }
        </style>
        <div class="consola">
            <div class="contenido-consola"></div>
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