<?php
if (!isset($plan)) return;

// Badge del plan más vendido
$badges = [
    'MAS_VENDIDO' => 'Más Vendido',
];
$tagActual = $plan['tag'] ?? 'NINGUNO';
$conBadge = isset($badges[$tagActual]);
$destacado = $tagActual === 'MAS_VENDIDO';
?>

<div class="plan<?= $conBadge ? ' plan--badge' : '' ?>">

    <?php if ($conBadge): ?>
        <span class="plan-badge"><?= htmlspecialchars($badges[$tagActual]) ?></span>
    <?php endif; ?>

    <div class="flex-align-items flex--space-between">
        <div>
          <span class="plan-titulo"><?= htmlspecialchars($plan['nombre'] ?? '') ?></span>
          <?php if (!empty($plan['descripcion'])): ?>
              <p class="plan-descripcion">
                  <?= htmlspecialchars($plan['descripcion']) ?>
              </p>
          <?php endif; ?>
        </div>
        <?php
            $iconoId = $plan['id_plan'] ?? 1;
            $iconoPath = PUBLIC_ROOT . 'assets/iconos/plan' . $iconoId . '.svg';
            if (file_exists($iconoPath)) {
                include $iconoPath;
            }
        ?>
    </div>
    <span class="plan-precio texto-g">
        <b>$<span class="texto-3xl texto-principal"><?= number_format($plan['costo'] ?? 0, 2) ?></span></b> usd / mes
    </span>
    <div class="separador"></div>
    <ul>
        <!-- Memoria RAM -->
        <?php if (isset($plan['ram_gb'])): ?>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                <p>
                  <b><?= htmlspecialchars($plan['ram_gb']) ?> GB</b> RAM dedicada
                </p>
            </li>
        <?php endif; ?>

        <!-- Máximo de Jugadores -->
        <?php if (isset($plan['max_jugadores'])): ?>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                <p>
                  Hasta <b><?= htmlspecialchars($plan['max_jugadores']) ?></b> jugadores
                </p>
            </li>
        <?php endif; ?>

        <!-- Prioridad de Recursos (CPU/E/S) -->
        <?php if (!empty($plan['prioridad'])): ?>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                <p>
                  Prioridad de CPU: <b><?= ucfirst(strtolower($plan['prioridad'])) ?></b>
                </p>
            </li>
        <?php endif; ?>

        <!-- Soporte 24/7 -->
        <?php if (!empty($plan['soporte_24_7'])): ?>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
              <p>
                Soporte técnico 24/7
              </p>
            </li>
        <?php endif; ?>
    </ul>

    <button class="boton <?= $destacado ? ' boton--primario' : '' ?>">Elegir plan</button>
</div>
