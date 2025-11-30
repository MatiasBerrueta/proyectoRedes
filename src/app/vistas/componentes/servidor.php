<div class='servidor' data-id="<?=  $identifier ?>">
    <div class="informacion-juego">
        <img class='icono-juego' src='/assets/brand-minecraft.svg' width='32' alt='Icono juego minecraft'>
        <h3 class='nombre-servidor'> <?= $nombre ?> </h3>
        <span id="estado-<?= $identifier ?>" class='estado online'>Offline</span>
    </div>
    <div class="flex-align-items">
        <p id="ip-<?= $identifier ?>" class='version-juego'>
            Ip: <?= $idServidor ?>:<?= $puertoServidor ?>
        </p>
        <div class='flex-align-items'>
            <p class="flex-align-items"><img src='/assets/user(1).svg' alt='Icono jugadores'>Jugadores</p>
            <span class='estadistica-jugadores'>0/20</span>
        </div>
    </div>
    <div class='flex-align-items'>
        <p class="flex-align-items"><img src='/assets/cpu.svg' width='24' alt='Icono cpu'>CPU</p>
        <span id='cpu-<?= $identifier ?>' class='estadistica-cpu'>0%</span>
    </div>
    <div class='barra'>
        <div class='barra-relleno' id='barra-cpu-<?= $identifier ?>'></div>
    </div>
    <div class='flex-align-items'>
        <p class="flex-align-items"><img src='/assets/device-floppy.svg' alt='Icono ram'>RAM</p>
        <span id='ram-<?= $identifier ?>' class='estadistica-ram'>0/0</span>
    </div>
    <div class='barra'>
        <div class='barra-relleno' id='barra-ram-<?= $identifier ?>'></div>
    </div>
    <div class="botones-accion">
        <div class="botones-intercambiables">
            <button id='iniciar-<?= $identifier ?>' class='boton-iniciar'>
                <img src='/assets/player-play.svg' alt=''>
                Iniciar
            </button>
            <button id='detener-<?= $identifier ?>' class='boton-detener' hidden>
                <img src='/assets/player-stop.svg' alt=''>
                Detener
            </button>
        </div>
        <button id='detener-<?= $identifier ?>' class='boton-configurar flex-align-items'>
            <img src='/assets/settings.svg' alt=''>
            Configuraciones
        </button>
    </div>
</div>