<a class='servidor' href="/panel/servidores/<?= $identifier ?>">
    <div class="informacion-juego">
        <img class='icono-juego' src='/assets/brand-minecraft.svg' width='32' alt='Icono juego minecraft'>
        <div class="misma-linea">
            <h3 class='font-size-4'> <?= $nombre ?> </h3>
            <span class='ip-servidor'><?= $ipServidor ?>:<?= $puertoServidor ?></span>
        </div>
        <span id="estado" class='estado online'><div></div><?= $estado ?></span>
    </div>
    <div class="informacion-servidor flex-align-items">
    </div>
    <div class='contenedor-metrica'>
        <div class='metricas'>
            <p><img src='/assets/users.svg' width="20px" height="20px" alt='Icono cpu'>Players</p>
            <div>
                <span id='jugadores-actuales'><?= $numeroJugadores ?></span>/<span id="jugadores-maximos"><?= $maximoNumeroJugadores ?></span>
            </div>
        </div>
        <div class='barra'>
            <div class='barra-relleno' id='barra-cpu'></div>
        </div>
    </div>
    <div class='contenedor-metrica'>
        <div class='metricas'>
            <p><img src='/assets/cpu.svg' width="20px" height="20px" alt='Icono cpu'>CPU</p>
             <div>
               <span id='cpu-actual'><?= $usoCpu ?>%</span> / <span id="limite-cpu"><?= $maximoUsoCpu ?>%</span>
            </div>
        </div>
        <div class='barra'>
            <div class='barra-relleno' id='barra-cpu'></div>
        </div>
    </div>
    <div class='contenedor-metrica'>
        <div class='metricas'>
            <p><img src='/assets/device-floppy.svg' width="20px" height="20px" alt='Icono ram'>RAM</p>
            <div>
                <span id='ram-actual'><?= formatBytes($usoRam) ?></span> / <span id="limite-ram"><?= formatBytes($maximoUsoRam * 1024 * 1024) ?></span>
            </div>
        </div>
        <div class='barra'>
            <div class='barra-relleno' id='barra-ram'></div>
        </div>
    </div>
</a>