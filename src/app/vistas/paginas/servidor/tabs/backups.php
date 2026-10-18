<link rel="stylesheet" href="/css/paginas/servidor/tabs/backups.css">

<?php
/** @var array $datosTab */

$backups = $datosTab['backups'] ?? [];

// Datos de ejemplo mientras no exista la integración con la API de backups.
if (empty($backups)) {
    $backups = [
        [
            'nombre'      => 'pre-update-forge-1.20',
            'tipo'        => 'manual',
            'detalle'     => 'Generado manualmente por el usuario',
            'autor'       => 'Matias',
            'tamano'      => 2630667468, // 2.45 GB
            'creado'      => '2026-10-14 18:30:00',
            'exclusiones' => 'logs/*, dynmap/*',
            'bloqueado'   => true,
            'estado'      => 'completado',
        ],
        [
            'nombre'      => 'backup-diario-2026-10-13',
            'tipo'        => 'automatico',
            'detalle'     => 'Tarea programada del sistema (00:00 UTC)',
            'tamano'      => 1879048192, // 1.75 GB
            'creado'      => '2026-10-13 00:00:00',
            'exclusiones' => null,
            'bloqueado'   => false,
            'estado'      => 'completado',
        ],
        [
            'nombre'      => 'respaldo-manual-temp',
            'tipo'        => 'manual',
            'detalle'     => 'Comprimiendo mapa del mundo y archivos...',
            'tamano'      => null,
            'creado'      => null,
            'exclusiones' => 'logs/*',
            'bloqueado'   => false,
            'estado'      => 'en_proceso',
            'progreso'    => 68,
        ],
    ];
}

$slotLimite   = (int) ($datosTab['slotLimite'] ?? 3);
$slotsUsados  = count(array_filter(
    $backups,
    static fn (array $backup): bool => ($backup['estado'] ?? 'completado') !== 'en_proceso'
));

$almacenamientoUsado    = (int) ($datosTab['almacenamientoUsado'] ?? 4510043340);   // ~4.2 GB
$almacenamientoLimite   = (int) ($datosTab['almacenamientoLimite'] ?? 10737418240); // 10 GB
$porcentajeAlmacenamiento = $almacenamientoLimite > 0
    ? (int) min(100, round($almacenamientoUsado / $almacenamientoLimite * 100))
    : 0;
?>

<div class="backups-tab">

    <div class="backups-encabezado">
        <h2 class="texto-g">Copias de seguridad</h2>
        <p class="texto-secundario texto-s">Creá, restaurá y administrá los respaldos de tu servidor.</p>
    </div>
    <div class="backup-aviso" id="backup-aviso">
        <div class="backup-aviso__info">
            <?php include PUBLIC_ROOT . 'assets/iconos/warning.svg'; ?>
            <div>
                <h4>Restaurando copia de seguridad en curso</h4>
                <p>Los controles de energía y la consola están bloqueados temporalmente para evitar corrupción de datos.</p>
            </div>
        </div>
        <span class="backup-aviso__estado">Restaurando archivos...</span>
    </div>
    <div class="backups-metricas">
        <div class="backup-card">
            <div>
                <span class="backup-card__etiqueta">Slots de backups</span>
                <div class="backup-card__valor">
                    <strong><?= $slotsUsados ?></strong>
                    <span>/ <?= $slotLimite ?> disponibles</span>
                </div>
                <p class="backup-card__nota">Incluidos en tu plan</p>
            </div>
            <div class="backup-card__icono">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4l-8 4l8 4l8 -4l-8 -4" /><path d="M4 12l8 4l8 -4" /><path d="M4 16l8 4l8 -4" /></svg>
            </div>
        </div>
        <div class="backup-card">
            <div class="backup-card__crecimiento">
                <div class="backup-card__fila">
                    <span class="backup-card__etiqueta">Espacio utilizado</span>
                    <span class="backup-card__metrica"><?= Formatear::formatBytes($almacenamientoUsado) ?> / <?= Formatear::formatBytes($almacenamientoLimite) ?></span>
                </div>
                <div class="backup-progreso__barra">
                    <span style="width: <?= $porcentajeAlmacenamiento ?>%"></span>
                </div>
                <p class="backup-card__nota">Compresión automática de respaldos activada</p>
            </div>
            <div class="backup-card__icono backup-card__icono--azul">
                <?php include PUBLIC_ROOT . 'assets/iconos/device-floppy.svg'; ?>
            </div>
        </div>
        <div class="backup-card backup-card--accion">
            <div class="backup-card__fila">
                <div>
                    <span class="backup-card__etiqueta">Copia instantánea</span>
                    <p class="backup-card__nota">Generá un punto de restauración seguro</p>
                </div>
                <button type="button" class="boton boton--s boton--primario backup-boton-crear" data-abrir-modal="backup-modal-crear">
                    <?php include PUBLIC_ROOT . 'assets/iconos/plus.svg'; ?>
                    Crear backup
                </button>
            </div>
            <p class="backup-card__ayuda">
                <?php include PUBLIC_ROOT . 'assets/iconos/info.svg'; ?>
                Los backups bloqueados están protegidos contra la rotación automática.
            </p>
        </div>
    </div>
    <div class="backups-panel">
        <div class="backups-panel__cabecera">
            <div class="backups-panel__titulo">
                <h3 class="texto-m">Copias de seguridad disponibles</h3>
                <span class="backup-contador"><?= count($backups) ?> copias guardadas</span>
            </div>
            <div class="backup-busqueda">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                <input type="search" placeholder="Buscar por nombre..." data-backup-buscar>
            </div>
        </div>
        <div class="backups-tabla-scroll">
            <table class="backups-tabla">
                <thead>
                    <tr>
                        <th scope="col">Nombre &amp; detalles</th>
                        <th scope="col">Tamaño</th>
                        <th scope="col">Fecha de creación</th>
                        <th scope="col">Exclusiones</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($backups as $indice => $backup):
                        $nombre      = $backup['nombre'] ?? 'backup-' . ($indice + 1);
                        $tipo        = $backup['tipo'] ?? 'manual';
                        $detalle     = $backup['detalle'] ?? '';
                        $tamano      = $backup['tamano'] ?? null;
                        $creado      = $backup['creado'] ?? null;
                        $exclusiones = $backup['exclusiones'] ?? null;
                        $bloqueado   = !empty($backup['bloqueado']);
                        $estado      = $backup['estado'] ?? 'completado';
                        $progreso    = (int) ($backup['progreso'] ?? 0);
                        $enProceso = $estado === 'en_proceso';
                    ?>
                        <tr class="backup-fila <?= $enProceso ? 'backup-fila--en-proceso' : '' ?>" data-nombre="<?= htmlspecialchars(strtolower($nombre)) ?>">
                            <td>
                                <div class="backup-nombre">
                                    <div class="backup-nombre__icono backup-nombre__icono--<?= $enProceso ? 'proceso' : ($bloqueado ? 'protegido' : ($tipo === 'automatico' ? 'automatico' : 'manual')) ?>">
                                        <?php if ($enProceso): ?>
                                            <span class="backup-spinner"></span>
                                        <?php elseif ($tipo === 'automatico'): ?>
                                            <?php include PUBLIC_ROOT . 'assets/iconos/clock.svg'; ?>
                                        <?php else: ?>
                                            <?php include PUBLIC_ROOT . 'assets/iconos/shield.svg'; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="backup-nombre__linea">
                                            <span class="backup-nombre__texto"><?= htmlspecialchars($nombre) ?></span>
                                            <?php if ($bloqueado): ?>
                                                <span class="backup-lock" title="Bloqueado contra borrado automático">
                                                    <?php include PUBLIC_ROOT . 'assets/iconos/lock.svg'; ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($tipo === 'automatico'): ?>
                                                <span class="backup-badge">Automático</span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="backup-nombre__detalle"><?= htmlspecialchars($detalle) ?></span>
                                    </div>
                                </div>
                            </td>

                            <td class="backup-tamano">
                                <?= $enProceso ? 'Calculando...' : ($tamano !== null ? Formatear::formatBytes((int) $tamano) : '—') ?>
                            </td>

                            <td>
                                <?php if ($creado): ?>
                                    <span class="backup-fecha"><?= htmlspecialchars(date('d/m/Y — H:i', strtotime($creado))) ?></span>
                                    <span class="backup-fecha__relativa"><?= htmlspecialchars(Formatear::obtenerTiempoTranscurrido($creado)) ?></span>
                                <?php else: ?>
                                    <span class="backup-fecha">Ahora mismo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($exclusiones): ?>
                                    <span class="backup-exclusion"><?= htmlspecialchars($exclusiones) ?></span>
                                <?php else: ?>
                                    <span class="backup-vacio">Ninguna</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($enProceso): ?>
                                    <div class="backup-progreso">
                                        <div class="backup-progreso__cabecera">
                                            <span>Procesando</span>
                                            <span><?= $progreso ?>%</span>
                                        </div>
                                        <div class="backup-progreso__barra">
                                            <span style="width: <?= $progreso ?>%"></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="backup-estado backup-estado--<?= htmlspecialchars($estado) ?>">
                                        <span class="backup-estado__punto"></span>
                                        <?= htmlspecialchars(ucfirst($estado)) ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="col-acciones">
                                <?php if ($enProceso): ?>
                                    <span class="backup-esperando">Esperando finalización...</span>
                                <?php else: ?>
                                    <div class="backup-acciones">
                                        <button type="button" class="backup-accion" data-accion="restaurar" data-backup="<?= htmlspecialchars($nombre) ?>" title="Restaurar este backup">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 14l-4 -4l4 -4" /><path d="M5 10h11a4 4 0 1 1 0 8h-1" /></svg>
                                        </button>
                                        <button type="button" class="backup-accion" data-accion="descargar" data-backup="<?= htmlspecialchars($nombre) ?>" title="Descargar archivo .tar.gz">
                                            <?php include PUBLIC_ROOT . 'assets/iconos/download.svg'; ?>
                                        </button>
                                        <button type="button" class="backup-accion" data-accion="bloquear" data-bloqueado="<?= $bloqueado ? '1' : '0' ?>" title="<?= $bloqueado ? 'Desbloquear este backup' : 'Bloquear contra borrado' ?>">
                                            <span class="backup-accion__icono">
                                                <span class="solo-bloqueado"><?php include PUBLIC_ROOT . 'assets/iconos/lock.svg'; ?></span>
                                                <span class="solo-desbloqueado">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 0 1 7.5 -1.5" /></svg>
                                                </span>
                                            </span>
                                        </button>
                                        <button type="button" class="backup-accion backup-accion--peligro" data-accion="eliminar" title="Eliminar backup">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="backups-panel__pie">
            <span>Mostrando <?= $slotsUsados ?> de <?= $slotLimite ?> copias permitidas por tu suscripción.</span>
            <a href="#" class="backup-enlace">¿Necesitás más espacio de backups? Aumentar cuota</a>
        </div>

    </div>

    <!-- Modal: crear backup -->
    <div class="backup-modal" id="backup-modal-crear" data-modal>
        <div class="backup-modal__caja">
            <div class="backup-modal__cabecera">
                <h3 class="texto-m">Crear nueva copia de seguridad</h3>
                <button type="button" class="boton-cerrar" data-cerrar title="Cerrar" aria-label="Cerrar">
                    <?php include PUBLIC_ROOT . 'assets/iconos/x.svg'; ?>
                </button>
            </div>

            <form class="backup-modal__cuerpo" id="backup-form-crear">
                <div class="backup-campo">
                    <label for="backup-nombre">Nombre de la copia (opcional)</label>
                    <input type="text" id="backup-nombre" name="nombre" placeholder="Ej: antes-de-instalar-modpack">
                    <small>Si lo dejás en blanco, se asignará la fecha y hora actual automáticamente.</small>
                </div>

                <div class="backup-campo">
                    <label for="backup-excluir">Archivos o carpetas a excluir</label>
                    <textarea id="backup-excluir" name="excluir" rows="2" placeholder="logs/*, dynmap/web/*, cache/*"></textarea>
                    <small>Separá con comas las rutas o patrones para ahorrar espacio de almacenamiento.</small>
                </div>

                <div class="backup-switches">
                    <label class="switch">
                        <div>
                            <span class="backup-switch__titulo">Proteger con candado (bloqueo)</span>
                            <small>Evita que la rutina automática elimine este backup cuando la lista esté llena.</small>
                        </div>
                        <input type="checkbox" name="bloquear" checked>
                        <span class="slider"></span>
                    </label>

                    <label class="switch">
                        <div>
                            <span class="backup-switch__titulo">Detener el servidor temporalmente</span>
                            <small>Recomendado en mapas grandes para asegurar la consistencia total del mundo.</small>
                        </div>
                        <input type="checkbox" name="detener">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="backup-modal__pie">
                    <button type="button" class="boton boton--secundario" data-cerrar>Cancelar</button>
                    <button type="submit" class="boton boton--primario">Iniciar respaldo</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: confirmar restauración -->
    <div class="backup-modal" id="backup-modal-restaurar" data-modal>
        <div class="backup-modal__caja backup-modal__caja--centrada">
            <div class="backup-modal__icono-aviso">
                <?php include PUBLIC_ROOT . 'assets/iconos/warning.svg'; ?>
            </div>

            <div class="backup-modal__mensaje">
                <h3 class="texto-m">¿Restaurar copia de seguridad?</h3>
                <p class="texto-secundario texto-s">
                    Esta acción sobrescribirá los archivos del servidor con el estado guardado en
                    <strong class="backup-resaltado" id="backup-restaurar-nombre">backup</strong>.
                </p>
                <div class="backup-alerta">
                    <strong>Advertencia:</strong> el servidor se apagará automáticamente durante el proceso y se perderán los cambios no guardados en el mapa actual.
                </div>
            </div>

            <div class="backup-modal__pie">
                <button type="button" class="boton boton--secundario" data-cerrar>Cancelar</button>
                <button type="button" class="boton boton--advertencia" id="backup-confirmar-restaurar">Sí, restaurar ahora</button>
            </div>
        </div>
    </div>

</div>
