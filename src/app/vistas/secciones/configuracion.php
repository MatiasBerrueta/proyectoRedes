<?php require_once APP_ROOT . "vistas/helpers/formulario.php"; ?>

<link rel="stylesheet" href="/css/tabConfiguracion.css">
<link rel="stylesheet" href="/css/formulario.css">
<div class="config-container">
    <h2 class="font-size-5">Configuración del Servidor</h2>
    <section class="contenedor-configuraciones">
        <?php
        $agrupados = agruparPorSeccion($datosTab);

        foreach($agrupados as $seccion => $configuraciones) {
            echo "<section class='config-seccion'>";
            echo "<h3>" . htmlspecialchars(ucfirst($seccion)) . "</h3>";
            echo "<div class='configuraciones'>";

            foreach($configuraciones as $configuracion) {
                renderizarInput($configuracion);
            }

            echo "</div>";
            echo "</section>";
        }
        ?>
    </section>
    <section class="acciones-config">
        <button class="boton-guardar">Guardar cambios</button>
        <button class="boton-restablecer">Restablecer</button>
    </section>
</div>

<script>
const styles = getComputedStyle(document.documentElement);

const colorRelleno = styles.getPropertyValue('--azul-logo');
const colorSuperficie = styles.getPropertyValue('--color-superficie-2');

function buildTicks(min, max, step, svg) {
    const thumbW = 16;
    const padding = 5;
    const trackW = svg.getBoundingClientRect().width;

    const travelW = trackW - thumbW - (padding * 2);
    const steps = Math.round((max - min) / step);
    const rects = [];

    for (let i = 0; i <= steps; i++) {
        const ratio = i / steps;
        const pxPos = padding + (thumbW / 2) + ratio * travelW;

        rects.push(`<rect class="range__tick" x="${pxPos.toFixed(2)}" y="0" width="2" height="8"/>`);
    }

    svg.innerHTML = rects.join('\n');
}

function updateFill(input) {
    const min = +input.min;
    const max = +input.max;
    const thumbW = 12;
    const padding = 4;
    const trackW = input.offsetWidth;

    const ratio = (input.value - min) / (max - min);

    const travelW = trackW - thumbW - (padding * 2);
    const pxPos = 2 * padding + thumbW + ratio * travelW + 1;
    const pct = (pxPos / trackW) * 100;

    input.style.background = `linear-gradient(
        to right,
        ${colorRelleno} 0%,
        ${colorRelleno} ${pct}%,
        ${colorSuperficie} ${pct}%
    )`;
}

document.querySelectorAll('.range-group').forEach(group => {
    const input = group.querySelector('input[type="range"]');
    const svg = group.querySelector('.ticks');
    const counter = group.querySelector('[data-range-value]');

    if (!input) return;

    // if (svg) {
    //     const min = +input.min || 0;
    //     const max = +input.max || 100;
    //     const step = +input.step || 1;
    //     buildTicks(min, max, step, svg);
    // }

    updateFill(input);

    if (counter) {
        counter.textContent = input.value;
    }

    input.addEventListener('input', () => {
        updateFill(input);

        if (counter) {
            counter.textContent = input.value;
        }
    });
});
</script>