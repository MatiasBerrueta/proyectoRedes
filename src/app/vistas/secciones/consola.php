<div style="height: 400px;">
    <div class="titulo-acciones">
        <h1 class="font-size-6">Resumen - <?= $servidor['nombre'] ?></h1>
        <div class="acciones-servidor">
            <button class="boton iniciar" onclick="iniciarServidor()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-player-play"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 4v16l13 -8l-13 -8" /></svg>
                Iniciar
            </button>
            <button class="boton detener" onclick="detenerServidor()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-player-stop"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2l0 -10" /></svg>
                Detener
            </button>
            <button class="boton reiniciar" onclick="reiniciarServidor()">
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
                    function cleanLog($line) {
                        if (preg_match('/\[(.*?)\] \[(.*?)\/(.*?)\]: (.*)/', $line, $matches)) {
                            return "[{$matches[1]} {$matches[3]}]: {$matches[4]}";
                        }

                        return $line;
                    }

                    foreach (explode("\n", $servidor['ultimoLog']) as $line) {
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
                    <span class="texto-estado font-size-4"><?= $servidor['estado'] ?? 'Online' ?>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-server"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3" /><path d="M3 15a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3l0 -2" /><path d="M7 8l0 .01" /><path d="M7 16l0 .01" /></svg>
            </div>
             <div class="contenedor-estadistica">
                <div>
                    <small>Jugadores</small>
                    <span class="texto-estado font-size-4"><?= $servidor['cantidadJugadores']  ?? '10/20'?>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
            </div>
            <div class="contenedor-estadistica">
                <div>
                    <small>Ip</small>
                    <span><span class="texto-ip font-size-4"><?= $servidor['ip'] . ':' . $servidor['puerto'] ?></span></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>
            </div>
            <div class="contenedor-estadistica">
                <div>
                    <small>Uptime</small>
                    <?php
                    function formatearMilisegundos($milisegundos) {
                        $segundos = floor($milisegundos / 1000);
                        $dias     = floor($segundos / 86400);
                        $horas    = floor(($segundos % 86400) / 3600);
                        $minutos  = floor(($segundos % 3600) / 60);
                        $segundos = $segundos % 60;

                        if ($dias > 0) {
                            return "{$dias}d {$horas}h {$minutos}m";
                        } else if ($horas > 0) {
                            return "{$horas}h {$minutos}m";
                        } else if ($minutos > 0) {
                            return "{$minutos}m {$segundos}s";
                        } else {
                            return "{$segundos}s";
                        }
                    }
                    ?>
                    <span><span class="texto-ip font-size-4"> <?= formatearMilisegundos($servidor['upTime']); ?> </span></span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plug"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.785 6l8.215 8.215l-2.054 2.054a5.81 5.81 0 1 1 -8.215 -8.215l2.054 -2.054" /><path d="M4 20l3.5 -3.5" /><path d="M15 4l-3.5 3.5" /><path d="M20 9l-3.5 3.5" /></svg>
            </div>
        </div>
    </div>
    <div class="actividades">
        <h2 class="font-size-6">Actividad reciente</h2>
        <div class="contenedor-logs">
            <?php
            $logs = [
                [
                    'tipo' => 'info',
                    'fecha' => '08/04/2026',
                    'hora' => '12:30',
                    'origen' => 'Sistema',
                    'descripcion' => 'Servidor iniciado correctamente'
                ],
                [
                    'tipo' => 'warning',
                    'fecha' => '08/04/2026',
                    'hora' => '12:45',
                    'origen' => 'Panel',
                    'descripcion' => 'Uso de RAM cercano al límite'
                ],
                [
                    'tipo' => 'error',
                    'fecha' => '08/04/2026',
                    'hora' => '13:00',
                    'origen' => 'API',
                    'descripcion' => 'Error al conectar con el nodo'
                ],
                [
                    'tipo' => 'debug',
                    'fecha' => '08/04/2026',
                    'hora' => '13:10',
                    'origen' => 'Sistema',
                    'descripcion' => 'Respuesta de API recibida (200 OK)'
                ],
            ];
            ?>

            <?php foreach ($logs as $log): ?>
                <div class="log">
                    <div class="icono <?= $log['tipo'] ?>">
                        <?php include PUBLIC_ROOT . "/assets/iconos/" . $log['tipo'] . '.svg' ?>
                    </div>
                    <div class="detalles">
                        <div class="linea-superior">
                            <span class="fecha-hora"><?= $log['fecha'], " ", $log['hora']?></span>
                            <span class="etiqueta-tipo <?= $log['tipo'] ?>"><?= ucfirst($log['tipo']) ?></span>
                            <span class="etiqueta-origen"><?= $log['origen'] ?></span>
                        </div>
                        <div class="linea-inferior">
                            <p><?= $log['descripcion'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
                <!-- <div class="log">
                    <div>
                        icono tipo log
                    </div>
                    <div class="detalles-logo">
                        <div class="linea-superior">
                            <span>Fecha log</span>
                            <span>Hora log</span>
                            <span>Tipo log</span>
                            <span>Origen log</span>
                        </div>
                        <div class="linea-inferior">
                            <p>Descripcion log</p>
                        </div>
                    </div>
                </div> -->
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