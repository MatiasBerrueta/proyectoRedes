<a class='servidor' 
    href="/panel/servidor/<?= $servidor['identifier'] ?>"
    data-jugadores="<?= $servidor['numeroJugadores'] ?>"
    data-max-jugadores="<?= $servidor['maximoNumeroJugadores'] ?>"
    data-cpu="<?= $servidor['usoCpu'] ?>"
    data-max-cpu="<?= $servidor['maximoUsoCpu'] ?>"
    data-ram="<?= ($servidor['usoRam'] / 1024) / 1024 ?>"
    data-max-ram="<?= $servidor['maximoUsoRam'] ?>">
    <div class="informacion-juego" style="--banner:url('/assets/banners/<?= $servidor['imagen'] ?>')">
        <div class="misma-linea">
            <h3 class='font-size-5'><?= $servidor['nombre'] ?></h3>
            <span class='ip-servidor'><?= $servidor['ip'] ?>:<?= $servidor['puerto'] ?></span>
        </div>
        <span class="estado <?= strtolower($servidor['estado']) ?>">
            <div></div>
            <?= $servidor['estado'] ?>
        </span>
    </div>
    <div class="informacion-servidor flex-align-items">
        <div class='contenedor-metrica'>
            <div class='metricas'>
                <p><?php include PUBLIC_ROOT . 'assets/iconos/users.svg'; ?>Players</p>
                <div>
                    <span class='jugadores-actuales'><?= $servidor['numeroJugadores'] ?></span> / <span class="jugadores-maximos"><?= $servidor['maximoNumeroJugadores'] ?></span>
                </div>
            </div>
            <div class='barra'>
                <div class='barra-relleno barra-jugadores'></div>
            </div>
        </div>
        <div class='contenedor-metrica'>
            <div class='metricas'>
                <p><?php include PUBLIC_ROOT . 'assets/iconos/cpu.svg'; ?>CPU</p>
                 <div>
                   <span class='cpu-actual'><?= $servidor['usoCpu'] ?>%</span> / <span class="limite-cpu"><?= $servidor['maximoUsoCpu'] ?>%</span>
                </div>
            </div>
            <div class='barra'>
                <div class='barra-relleno barra-cpu'></div>
            </div>
        </div>
        <div class='contenedor-metrica'>
            <div class='metricas'>
                <p><?php include PUBLIC_ROOT . 'assets/iconos/device-floppy.svg'; ?>RAM</p>
                <div>
                    <span class='ram-actual'><?= formatBytes($servidor['usoRam']) ?></span> / <span class="limite-ram"><?= formatBytes($servidor['maximoUsoRam'] * 1024 * 1024) ?></span>
                </div>
            </div>
            <div class='barra'>
                <div class='barra-relleno barra-ram'></div>
            </div>
        </div>
    </div>
</a>