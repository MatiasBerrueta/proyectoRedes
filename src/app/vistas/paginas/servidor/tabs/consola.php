<?php
/** @var array $datosTab */
?>

<link rel="stylesheet" href="/css/paginas/servidor/tabs/consola.css">
<script src="https://cdn.jsdelivr.net/npm/ansi_up@5.0.0/ansi_up.min.js"></script>

<div class="altura-consola">
    <div class="titulo-acciones">
        <div>
            <div style="display: flex; align-items: center; column-gap: 1rem;">
                <h1 class="texto-xl"><?= htmlspecialchars($datosTab['nombre']) ?></h1>
                <span class="texto-estado">
                    <span class="indicador-estado"></span>
                    <span data-estado><?= htmlspecialchars($datosTab['estadoFormateado']) ?></span>
                </span>
            </div>
            <p class="texto-secundario">
                <?= htmlspecialchars($datosTab['juego']) ?> · 
                <?= htmlspecialchars($datosTab['version']) ?> · 
                <?= htmlspecialchars($datosTab['nombreVariacion']) ?>
            </p>
            <p>
                <?= htmlspecialchars($datosTab['descripcion']) ?>
            </p>
        </div>
        <div class="acciones-servidor">
            <button class="boton iniciar" data-action="iniciar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-player-play"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 4v16l13 -8l-13 -8" /></svg>
                Iniciar
            </button>
            <button class="boton detener" data-action="detener">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-player-stop"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2l0 -10" /></svg>
                Detener
            </button>
            <button class="boton reiniciar" data-action="reiniciar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-rotate-rectangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.09 4.01l.496 -.495a2 2 0 0 1 2.828 0l7.071 7.07a2 2 0 0 1 0 2.83l-7.07 7.07a2 2 0 0 1 -2.83 0l-7.07 -7.07a2 2 0 0 1 0 -2.83l3.535 -3.535h-3.988" /><path d="M7.05 11.038v-3.988" /></svg>
                Reiniciar
            </button>
        </div>
    </div>

    <div class="consola-estadisticas-contenedor">
        <div class="consola">
            <div class="contenido-consola" id="logs-contenedor">
                <?php foreach ($datosTab['logsConsola'] as $linea): ?>
                    <div><?= htmlspecialchars($linea) ?></div>
                <?php endforeach; ?>
            </div>
            <form class="input-consola" id="form-comando">
                <span>$</span>
                <input type="text" id="comando-input" placeholder="Enter server command..." autocomplete="off">
                <button type="submit" class="boton">Enviar</button>
            </form>
        </div>

        <div class="estadisticas">
            <div class="contenedor-estadistica">
                <div class="contenedor-svg">
                    <?php include PUBLIC_ROOT . '/assets/iconos/user.svg'; ?>
                </div>
                <div>
                    <small>Jugadores</small>
                    <span class="texto-m"><?= htmlspecialchars($datosTab['jugadores']) ?>/<?= htmlspecialchars($datosTab['maxJugadores']) ?></span>
                </div>
            </div>

            <div class="contenedor-estadistica">
                <div class="contenedor-svg">
                    <?php include PUBLIC_ROOT . '/assets/iconos/clock.svg'; ?>
                </div>
                <div>
                    <small>Direccion</small>
                    <span class="texto-ip texto-m"><?= htmlspecialchars($datosTab['ip'] . ':' . $datosTab['puerto']) ?></span>
                </div>
            </div>

            <div class="contenedor-estadistica">
                <div class="contenedor-svg">
                    <?php include PUBLIC_ROOT . '/assets/iconos/cpu.svg'; ?>
                </div>
                <div>
                    <small>Uso de CPU</small>
                    <div>
                        <span class="texto-m" data-cpu><?= $datosTab['usoCpu'] ?></span>%
                    </div>
                </div>
            </div>

            <div class="contenedor-estadistica">
                <div class="contenedor-svg">
                    <?php include PUBLIC_ROOT . '/assets/iconos/device-floppy.svg'; ?>
                </div>

                <div>
                    <small>Uso de RAM</small>
                    <div class="texto-m">
                        <span data-ram><?= $datosTab['usoRam'] ?></span> 
                        <span>/ <?= $datosTab['maximoUsoRam'] ?>MB</span>
                    </div>
                </div>
            </div>

            <div class="contenedor-estadistica">
                <div class="contenedor-svg">
                    <?php include PUBLIC_ROOT . '/assets/iconos/clock.svg'; ?>
                </div>
                <div>
                    <small>Uptime</small>
                    <span class="texto-m" data-uptime><?= htmlspecialchars($datosTab['uptime']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="actividades">
        <h2 class="texto-g">Actividad reciente</h2>
        <div class="contenedor-logs">
            <?php foreach ($datosTab['actividadReciente'] as $log): ?>
                <div class="log">
                    <div class="icono <?= htmlspecialchars($log['tipo']) ?>">
                        <?php include PUBLIC_ROOT . "/assets/iconos/" . $log['tipo'] . '.svg' ?>
                    </div>
                    <div class="detalles">
                        <div class="linea-superior">
                            <span class="fecha-hora"><?= htmlspecialchars($log['fecha'] . ' ' . $log['hora']) ?></span>
                            <span class="badge-tipo badge-tipo--<?= htmlspecialchars($log['tipo']) ?>"><?= ucfirst(htmlspecialchars($log['tipo'])) ?></span>
                            <span class="etiqueta-origen"><?= htmlspecialchars($log['origen']) ?></span>
                        </div>
                        <div class="linea-inferior">
                            <p><?= htmlspecialchars($log['descripcion']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>