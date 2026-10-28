<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    (function() {
        const temaGuardado = localStorage.getItem('tema');
        if (temaGuardado === 'oscuro') document.documentElement.classList.add('tema-oscuro');
    })();
    </script>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/componentes.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/paginas/planes.css">
    <script src="/js/controladorTemas.js" defer></script>
    <script src="/js/planes.js" defer></script>
    <title>Planes y Precios - Voxel Hosting</title>
</head>
<body class="layout-planes">
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <!-- Hero Banner -->
        <section class="hero-planes">
            <h1>Elegí el plan para tu servidor</h1>
            <p class="hero-planes__subtexto">
                Elegí uno de los planes listos, armá el tuyo o dejá que te ayudemos a decidir. Podés cambiar de plan cuando quieras.
            </p>
        </section>

         <!-- Planes Preconfigurados -->
        <section class="planes-preconfigurados">
            <div class="planes-preconfigurados__header">
                <div class="segmento">
                    <button type="button" class="segmento__item segmento__item--activo">Pago Mensual</button>
                    <button type="button" class="segmento__item">Pago Anual <span class="planes-preconfigurados__descuento">-20% OFF</span></button>
                </div>
            </div>

            <div class="contenedor-planes">
                <?php if (empty($planes)): ?>
                    <p>No hay planes disponibles por el momento.</p>
                <?php else: ?>
                    <?php foreach ($planes as $plan): ?>
                        <?php include APP_ROOT . 'vistas/componentes/plan.php'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Tabla Comparativa -->
        <section class="tabla-comparativa">
            <div class="tabla-comparativa__header">
                <h2>Compará los planes</h2>
                <p>Todo lo que incluye cada plan, lado a lado.</p>
            </div>
            <div class="tabla-contenedor">
              <table>
                  <thead>
                      <tr>
                          <th>Característica / Plan</th>
                          <?php foreach ($planes as $plan): ?>
                              <th<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>><?= htmlspecialchars($plan['nombre']) ?></th>
                          <?php endforeach; ?>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>Memoria RAM DDR5</td>
                          <?php foreach ($planes as $plan): ?>
                              <td<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>><?= (int)$plan['ram_gb'] ?> GB</td>
                          <?php endforeach; ?>
                      </tr>
                      <tr>
                          <td>Precio Mensual</td>
                          <?php foreach ($planes as $plan): ?>
                              <td<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>>$<?= number_format((float)$plan['costo'], 2) ?></td>
                          <?php endforeach; ?>
                      </tr>
                      <tr>
                          <td>Jugadores Máximos</td>
                          <?php foreach ($planes as $plan): ?>
                              <td<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>><?= (int)$plan['max_jugadores'] ?></td>
                          <?php endforeach; ?>
                      </tr>
                      <tr>
                          <td>Soporte 24/7</td>
                          <?php foreach ($planes as $plan): ?>
                              <td<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>><?= $plan['soporte_24_7'] ? 'Sí' : 'No' ?></td>
                          <?php endforeach; ?>
                      </tr>
                      <tr>
                          <td>Protección DDoS</td>
                          <?php foreach ($planes as $plan): ?>
                              <td<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>>3.2 Tbps Standard</td>
                          <?php endforeach; ?>
                      </tr>
                      <tr>
                          <td>Acceso Completo FTP / SFTP</td>
                          <?php foreach ($planes as $plan): ?>
                              <td<?= $plan['tag'] === 'MAS_VENDIDO' ? ' class="destacado"' : '' ?>>Sí</td>
                          <?php endforeach; ?>
                      </tr>
                  </tbody>
              </table>
            </div>
        </section>

        <!-- Selector de ayuda -->
        <section class="selector-planes" aria-labelledby="selector-planes-titulo">
            <div class="selector-planes__header">
                <h2 id="selector-planes-titulo">¿No sabés qué elegir?</h2>
                <p>Armá un plan a tu medida o respondé unas preguntas y te recomendamos uno.</p>
            </div>

            <div class="selector-planes__opciones">
                <button type="button" class="selector-planes__opcion" data-abrir-seccion="asistente-planes" aria-controls="asistente-planes" aria-expanded="false">
                    <span class="selector-planes__icono">
                        <?php include PUBLIC_ROOT . "assets/iconos/sparkles-2.svg" ?>
                    </span>
                    <span class="selector-planes__texto">
                        <span class="selector-planes__titulo">Recomendame un plan</span>
                        <span class="selector-planes__desc">Contanos qué jugás y cuántos jugadores sos, y te sugerimos el plan ideal.</span>
                    </span>
                    <span class="selector-planes__flecha" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                    </span>
                </button>

                <button type="button" class="selector-planes__opcion" data-abrir-seccion="plan-personalizado" aria-controls="plan-personalizado" aria-expanded="false">
                    <span class="selector-planes__icono selector-planes__icono--violeta">
                        <?php include PUBLIC_ROOT . "assets/iconos/adjustments-horizontal.svg" ?>
                    </span>
                    <span class="selector-planes__texto">
                        <span class="selector-planes__titulo">Armar mi plan personalizado</span>
                        <span class="selector-planes__desc">Elegí RAM, CPU y almacenamiento exactos y pagá solo por lo que usás.</span>
                    </span>
                    <span class="selector-planes__flecha" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                    </span>
                </button>
            </div>
        </section>

        <!-- Asistente de Planes -->
        <section class="asistente-planes seccion-desplegable" id="asistente-planes" hidden>
            <div class="asistente-planes__header">
                <div class="asistente-planes__icono" aria-hidden="true">
                    <?php include PUBLIC_ROOT . "assets/iconos/sparkles-2.svg" ?>
                </div>
                <div class="asistente-planes__titulo">
                    <h2>Contanos qué necesitás</h2>
                    <p>Contanos qué vas a jugar y cuántos jugadores te acompañan. Te sugerimos el plan ideal.</p>
                </div>
                <button type="button" class="boton boton--icono boton--fantasma seccion-desplegable__cerrar" data-cerrar-seccion="asistente-planes" aria-label="Cerrar asistente de recomendaciones">
                </button>
            </div>

            <div class="asistente-planes__grid">
                <div class="asistente-planes__campo">
                    <span class="asistente-planes__campo-icono" aria-hidden="true">
                    </span>
                    <div class="asistente-planes__campo-cuerpo">
                        <label for="asistente-juego">Juego principal</label>
                        <select id="asistente-juego">
                            <option>Minecraft (Java / Bedrock)</option>
                            <option>Rust</option>
                            <option>Palworld</option>
                            <option>ARK: Survival Evolved</option>
                            <option>Valheim</option>
                            <option>Project Zomboid</option>
                            <option>Counter-Strike 2</option>
                        </select>
                    </div>
                </div>

                <div class="asistente-planes__campo">
                    <span class="asistente-planes__campo-icono" aria-hidden="true">
                    </span>
                    <div class="asistente-planes__campo-cuerpo">
                        <label for="asistente-jugadores">Jugadores simultáneos</label>
                        <input id="asistente-jugadores" type="range" min="5" max="200" step="5" value="25">
                        <div class="asistente-planes__escala">
                            <span>5 jugadores</span>
                            <span>200 jugadores</span>
                        </div>
                    </div>
                </div>

                <div class="asistente-planes__campo">
                    <span class="asistente-planes__campo-icono" aria-hidden="true">
                    </span>
                    <div class="asistente-planes__campo-cuerpo">
                        <label for="asistente-mods">Uso de mods / plugins</label>
                        <select id="asistente-mods">
                            <option>Vanilla (Sin Mods / Ligero)</option>
                            <option>Mods Moderados / Spigot Plugins (~20-50)</option>
                            <option>Modpacks Pesados / RLCraft / ATM (~150+)</option>
                        </select>
                    </div>
                </div>

                <div class="asistente-planes__campo">
                    <span class="asistente-planes__campo-icono" aria-hidden="true">
                    </span>
                    <div class="asistente-planes__campo-cuerpo">
                        <label for="asistente-region">Región del servidor</label>
                        <select id="asistente-region">
                            <option>EE.UU. Este (Miami / Virginia)</option>
                            <option>Sudamérica (São Paulo, Brasil)</option>
                            <option>Europa (Frankfurt, Alemania)</option>
                        </select>
                    </div>
                </div>

                <div class="asistente-planes__campo">
                    <span class="asistente-planes__campo-icono" aria-hidden="true">
                    </span>
                    <div class="asistente-planes__campo-cuerpo">
                        <label for="asistente-respaldos">Respaldos automáticos</label>
                        <select id="asistente-respaldos">
                            <option>Diarios (Recomendado)</option>
                            <option>Cada Hora (Ultra Seguro)</option>
                            <option>Sin respaldos automáticos</option>
                        </select>
                    </div>
                </div>

                <div class="asistente-planes__info-box">
                    <span class="asistente-planes__info-icono" aria-hidden="true">
                    </span>
                    <div class="asistente-planes__info-texto">
                        <p class="asistente-planes__info-titulo">Protección Anti-DDoS</p>
                        <p class="asistente-planes__info-desc">Incluida gratis en todos los servidores.</p>
                    </div>
                    <span class="asistente-planes__info-badge">Incluido</span>
                </div>
            </div>

            <div class="asistente-planes__resultado">
                <div class="asistente-planes__info">
                    <h3>Plan ideal sugerido</h3>
                    <span class="asistente-planes__plan-nombre">Performance · 12 GB RAM</span>
                    <span class="asistente-planes__plan-desc">Excelente equilibrio para hasta 35 jugadores en Minecraft con plugins medianos.</span>
                </div>
                <div class="asistente-planes__acciones">
                    <div class="asistente-planes__precio">
                        <span class="asistente-planes__precio-valor">$14.99 <span class="asistente-planes__precio-periodo">/mes</span></span>
                    </div>
                    <button type="button" class="boton boton--primario boton--l">Contratar ahora</button>
                </div>
            </div>
        </section>

        <!-- Configurador Personalizado -->
        <section class="configurador-planes seccion-desplegable" id="plan-personalizado" hidden>
            <div class="configurador-planes__header">
                <div class="configurador-planes__titulo">
                    <div class="configurador-planes__icono">
                        <?php include PUBLIC_ROOT . "assets/iconos/adjustments-horizontal.svg" ?>
                    </div>
                    <div>
                        <h2>Plan personalizado</h2>
                        <p>Ajustá RAM, CPU y almacenamiento. Pagá solo por el hardware que usás.</p>
                    </div>
                </div>
                <button type="button" class="boton boton--icono boton--fantasma seccion-desplegable__cerrar" data-cerrar-seccion="plan-personalizado" aria-label="Cerrar plan personalizado">
                </button>
            </div>

            <div class="configurador-planes__grid">
                <div class="configurador-planes__controles">
                    <!-- RAM Slider -->
                    <div class="configurador-planes__control">
                        <div class="configurador-planes__control-header">
                            <label for="configurador-ram">
                                Memoria RAM DDR5
                            </label>
                            <span class="configurador-planes__control-valor">16 GB</span>
                        </div>
                        <input id="configurador-ram" type="range" min="4" max="128" step="4" value="16">
                        <div class="configurador-planes__control-labels">
                            <span>4 GB</span>
                            <span>32 GB</span>
                            <span>64 GB</span>
                            <span>128 GB</span>
                        </div>
                    </div>

                    <!-- CPU Cores Slider -->
                    <div class="configurador-planes__control">
                        <div class="configurador-planes__control-header">
                            <label for="configurador-cpu">
                                Núcleos CPU (Ryzen 9 7950X / 5.7 GHz)
                            </label>
                            <span class="configurador-planes__control-valor">4 Cores</span>
                        </div>
                        <input id="configurador-cpu" type="range" min="1" max="16" step="1" value="4">
                        <div class="configurador-planes__control-labels">
                            <span>1 Core</span>
                            <span>4 Cores</span>
                            <span>8 Cores</span>
                            <span>16 Cores</span>
                        </div>
                    </div>

                    <!-- NVMe Storage Slider -->
                    <div class="configurador-planes__control">
                        <div class="configurador-planes__control-header">
                            <label for="configurador-almacenamiento">
                                Almacenamiento NVMe PCIe 4.0
                            </label>
                            <span class="configurador-planes__control-valor">100 GB</span>
                        </div>
                        <input id="configurador-almacenamiento" type="range" min="20" max="1000" step="20" value="100">
                        <div class="configurador-planes__control-labels">
                            <span>20 GB</span>
                            <span>250 GB</span>
                            <span>500 GB</span>
                            <span>1000 GB</span>
                        </div>
                    </div>

                    <!-- Extras -->
                    <div class="configurador-planes__extras">
                        <label class="configurador-planes__extra">
                            <span class="configurador-planes__extra-info">
                                <span class="configurador-planes__extra-icono">
                                </span>
                                <span class="configurador-planes__extra-texto">
                                    <span class="configurador-planes__extra-titulo">IP Dedicada Port 25565/Default</span>
                                    <span class="configurador-planes__extra-precio">+$3.00/mes</span>
                                </span>
                            </span>
                            <input type="checkbox">
                            <span class="slider" aria-hidden="true"></span>
                        </label>

                        <label class="configurador-planes__extra">
                            <span class="configurador-planes__extra-info">
                                <span class="configurador-planes__extra-icono">
                                </span>
                                <span class="configurador-planes__extra-texto">
                                    <span class="configurador-planes__extra-titulo">Copias de Seguridad Diarias</span>
                                    <span class="configurador-planes__extra-precio">+$2.00/mes</span>
                                </span>
                            </span>
                            <input type="checkbox" checked>
                            <span class="slider" aria-hidden="true"></span>
                        </label>
                    </div>
                </div>

                <!-- Resumen de Facturación -->
                <div class="configurador-planes__resumen">
                    <div class="configurador-planes__resumen-header">
                        <h3>Desglose de facturación</h3>
                    </div>

                    <div class="configurador-planes__resumen-items">
                        <div class="configurador-planes__resumen-item">
                            <span>RAM DDR5 (16 GB)</span>
                            <span>$16.00</span>
                        </div>
                        <div class="configurador-planes__resumen-item">
                            <span>CPU Cores (4 Cores)</span>
                            <span>$8.00</span>
                        </div>
                        <div class="configurador-planes__resumen-item">
                            <span>SSD NVMe (100 GB)</span>
                            <span>$5.00</span>
                        </div>
                        <div class="configurador-planes__resumen-item">
                            <span>IP Dedicada</span>
                            <span>$0.00</span>
                        </div>
                        <div class="configurador-planes__resumen-item">
                            <span>Backups Automáticos</span>
                            <span>$2.00</span>
                        </div>
                    </div>

                    <div class="configurador-planes__resumen-total">
                        <div class="configurador-planes__total-info">
                            <span class="configurador-planes__total-hora">Estimado por hora: $0.043 / hr</span>
                        </div>
                        <span class="configurador-planes__total-valor">$31.00</span>
                    </div>

                    <button type="button" class="boton boton--primario boton--bloque boton--l">
                        Desplegar servidor custom
                    </button>
                </div>
            </div>
        </section>
    </main>
    <?php include_once APP_ROOT . 'vistas/componentes/footer.php'; ?>
</body>
</html>
