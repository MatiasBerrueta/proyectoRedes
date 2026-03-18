<a class='servidor' 
    href="/panel/servidores/<?= $identifier ?>"
    data-jugadores="<?= $numeroJugadores ?>"
    data-max-jugadores="<?= $maximoNumeroJugadores ?>"
    data-cpu="<?= $usoCpu ?>"
    data-max-cpu="<?= $maximoUsoCpu ?>"
    data-ram="<?= ($usoRam / 1024) / 1024 ?>"
    data-max-ram="<?= $maximoUsoRam ?>">
    <div class="informacion-juego" style="--banner:url('/assets/<?= $juego ?>-banner.jpeg')">
        <div class="misma-linea">
            <h3 class='font-size-5'><?= $nombre ?></h3>
            <span class='ip-servidor'><?= $ipServidor ?>:<?= $puertoServidor ?></span>
        </div>
        <span class="estado <?= strtolower($estado) ?>">
            <div></div>
            <?= $estado ?>
        </span>
    </div>
    <div class="informacion-servidor flex-align-items">
        <div class='contenedor-metrica'>
            <div class='metricas'>
                <p><img src='/assets/users.svg' alt='Icono jugadores'>Players</p>
                <div>
                    <span class='jugadores-actuales'><?= $numeroJugadores ?></span> / <span class="jugadores-maximos"><?= $maximoNumeroJugadores ?></span>
                </div>
            </div>
            <div class='barra'>
                <div class='barra-relleno barra-jugadores'></div>
            </div>
        </div>
        <div class='contenedor-metrica'>
            <div class='metricas'>
                <p><img src='/assets/cpu.svg' alt='Icono cpu'>CPU</p>
                 <div>
                   <span class='cpu-actual'><?= $usoCpu ?>%</span> / <span class="limite-cpu"><?= $maximoUsoCpu ?>%</span>
                </div>
            </div>
            <div class='barra'>
                <div class='barra-relleno barra-cpu'></div>
            </div>
        </div>
        <div class='contenedor-metrica'>
            <div class='metricas'>
                <p><img src='/assets/device-floppy.svg' alt='Icono ram'>RAM</p>
                <div>
                    <span class='ram-actual'><?= formatBytes($usoRam) ?></span> / <span class="limite-ram"><?= formatBytes($maximoUsoRam * 1024 * 1024) ?></span>
                </div>
            </div>
            <div class='barra'>
                <div class='barra-relleno barra-ram'></div>
            </div>
        </div>
    </div>
</a>