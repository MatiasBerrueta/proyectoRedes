<?php
// Si no hay datosTab, abortamos
if (empty($datosTab)) {
    return;
}
?>

<link rel="stylesheet" href="/css/paginas/servidor/tabs/consola.css">
<script src="https://cdn.jsdelivr.net/npm/ansi_up@5.0.0/ansi_up.min.js"></script>

<div class="altura-consola">
    <div class="titulo-acciones">
        <div>
            <h1 class="texto-xl"><?= htmlspecialchars($datosTab['nombre']) ?></h1>
            <p class="texto-secundario">
                <?= htmlspecialchars($datosTab['juego']) ?> · 
                <?= htmlspecialchars($datosTab['version']) ?> · 
                <?= htmlspecialchars($datosTab['nombreJuego']) ?> · 
                <?= htmlspecialchars($datosTab['location']) ?>
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
                <div>
                    <small>Estado</small>
                    <span class="texto-estado texto-m"><?= htmlspecialchars($datosTab['estadoFormateado']) ?></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-server"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /></svg>
            </div>

            <div class="contenedor-estadistica">
                <div>
                    <small>Jugadores</small>
                    <span class="texto-estado texto-m"><?= htmlspecialchars($datosTab['jugadores']) ?></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
            </div>

            <div class="contenedor-estadistica">
                <div>
                    <small>IP</small>
                    <span class="texto-ip texto-m"><?= htmlspecialchars($datosTab['ip'] . ':' . $datosTab['puerto']) ?></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>
            </div>

            <div class="contenedor-estadistica">
                <div>
                    <small>Recursos</small>
                    <div class="contenedor-recursos">
                        <div>
                            <p><span>CPU</span><span><?= $datosTab['cpuUso'] ?>%</span></p>
                            <div class="barra-recurso">
                                <div class="barra-recurso__relleno" style="width: <?= $datosTab['cpuUso'] ?>%"></div>
                            </div>
                        </div>
                        <div>
                            <p><span>RAM</span><span><?= $datosTab['ramUso'] ?></span></p>
                            <div class="barra-recurso">
                                <div class="barra-recurso__relleno"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contenedor-estadistica">
                <div>
                    <small>Uptime</small>
                    <span class="texto-ip texto-m" data-uptime><?= htmlspecialchars($datosTab['uptimeFormateado']) ?></span>
                </div>
                <?php include PUBLIC_ROOT . '/assets/iconos/clock.svg'; ?>
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