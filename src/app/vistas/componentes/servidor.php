<div class='servidor'>
    <img class='icono-servidor' src='/assets/server.svg' width='48' alt='Icono servidor'>
    <h3 class='nombre-servidor'> <?= $nombre ?> </h3>
    <p id="ip-<?= $identifier ?>" class='version-juego'>
        Ip: <?= $idServidor ?>:<?= $puertoServidor ?>
    </p>
    <span id="estado-<?= $identifier ?>" class='estado online'>Offline</span>
    <div class='metrica-jugadores'>
        <p><img src='/assets/user.svg' alt='Icono jugadores'>Jugadores</p>
        <span class='estadistica-jugadores'>0/20</span>
    </div>
    <div class='metrica-cpu'>
        <p><img src='/assets/cpu.svg' width='24' alt='Icono cpu'>CPU</p>
        <span id='cpu-<?= $identifier ?>' class='estadistica-cpu'>0%</span>
    </div>
    <div class='barra-cpu'>
        <div class='barra-relleno' id='barra-cpu-<?= $identifier ?>'></div>
    </div>

    <div class='metrica-ram'>
        <p><img src='/assets/device-floppy.svg' alt='Icono ram'>RAM</p>
        <span id='ram-<?= $identifier ?>' class='estadistica-ram'>0/0</span>
    </div>

    <div class='barra-ram'>
        <div class='barra-relleno' id='barra-ram-<?= $identifier ?>'></div>
    </div>
    <button id='iniciar-<?= $identifier ?>' class='boton-iniciar'>
        <img src='' alt=''>Iniciar
    </button>
    <button id='detener-<?= $identifier ?>' class='boton-configurar'>
        <img src='' alt=''>Detener
    </button>
</div>