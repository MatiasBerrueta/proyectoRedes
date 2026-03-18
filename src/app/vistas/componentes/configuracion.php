<div class="config-container">
    <h2 class="font-size-6">Configuración del Servidor</h2 class="font-size-6">
    <section class="config-section">
        <h3>General</h3>
        <div>
            <div>
                <label>Nombre del servidor</label><br>
                <input type="text" placeholder="Mi servidor">
            </div>
            <div>
                <label>Dirección IP</label><br>
                <input type="text" placeholder="123.123.123.123">
            </div>
            <div>
                <label>Puerto</label><br>
                <input type="number" placeholder="25565">
            </div>
            <div>
                <label>Jugadores máximos</label><br>
                <input type="number" placeholder="20">
            </div>
        </div>
    </section>
    <section class="config-section">
        <h3>Juego</h3>
        <div>
            <div>
                <label>Modo de juego</label><br>
                <select>
                    <option>Survival</option>
                    <option>Creative</option>
                    <option>Adventure</option>
                    <option>Spectator</option>
                </select>
            </div>
            <div>
                <label>Dificultad</label><br>
                <select>
                    <option>Peaceful</option>
                    <option>Easy</option>
                    <option>Normal</option>
                    <option>Hard</option>
                </select>
            </div>
            <label class="switch">
                <span class="label-text">Permitir PvP</span>
                <input type="checkbox" name="allow_php">
                <span class="slider"></span>
            </label>
            <label class="switch">
                <span class="label-text">Modo online (verificación de cuentas)</span>
                <input type="checkbox" name="online_mode">
                <span class="slider"></span>
            </label>
            <label class="switch">
                <span class="label-text">Permitir Nether</span>
                <input type="checkbox" name="allow_nether">
                <span class="slider"></span>
            </label>
            <label class="switch">
                <span class="label-text">Habilitar spawn de mobs</span>
                <input type="checkbox" name="allow_mob_spawn">
                <span class="slider"></span>
            </label>
        </div>
    </section>
    <section class="config-section">
        <h3>Rendimiento</h3>
        <div>
            <div>
                <label>Memoria RAM asignada (MB)</label>
                <input type="number" placeholder="2048">
            </div>
            <div class="range-group">
                <label for="chunks">Chunks - <span id="chunks-value">10</span></label>
                <div class="range-wrapper">
                    <input type="range" id="chunks" min="2" max="32" step="1" value="10">
                    <div class="range-steps"></div>
                    <svg class="ticks" fill="currentColor" role="presentation" width="50%" height="26" xmlns="http://www.w3.org/2000/svg"></svg>
                </div>
            </div>
            <div>
                <label>Tick rate</label>
                <input type="number" placeholder="20">
            </div>
        </div>
    </section>
    <section class="config-actions">
        <button class="btn-save">Guardar cambios</button>
        <button class="btn-reset">Restablecer</button>
    </section>
</div>

<script>
    const styles = getComputedStyle(document.documentElement);

    const colorRelleno = styles.getPropertyValue('--slider-relleno');
    const colorGris300 = styles.getPropertyValue('--gris-300');

    function buildTicks(min, max, step, svg, input) {
        const thumbW = 16;
        const padding = 5;
        const trackW = svg.getBoundingClientRect().width;

        const travelW = trackW - thumbW - (padding * 2);
        const steps = Math.round((max - min) / step);
        const rects = [];

        for (let i = 0; i <= steps; i++) {
            const ratio = i / steps;
            const pxPos = padding + (thumbW / 2) + ratio * travelW;

            // Lineas
            rects.push(`<rect class="range__tick" x="${pxPos.toFixed(2)}" y="0" width="2" height="8"/>`);

            // Circulos
            // rects.push(`<circle class="range__tick" cx="${pxPos.toFixed(2)}" cy="13" r="1.5"/>`);
        }

        svg.innerHTML = rects.join('\n');
    }

    function updateFill(input) {
        const min = +input.min;
        const max = +input.max;
        const thumbW = 16;
        const padding = 5;
        const trackW = input.offsetWidth;

        const ratio = (input.value - min) / (max - min);

        const travelW = trackW - thumbW - (padding * 2);
        const pxPos = 2 * padding + thumbW + ratio * travelW + 1;
        const pct = (pxPos / trackW) * 100;

        input.style.background = `linear-gradient(
            to right,
            ${colorRelleno} 0%,
            ${colorRelleno} ${pct}%,
            ${colorGris300} ${pct}%
        )`;
    }

    const svg = document.querySelector('.ticks');
    const sliderContainer = document.querySelector('.range-group');
    const sliderInput = sliderContainer.querySelector('input');
    const chunkCounter = sliderContainer.querySelector('#chunks-value');

    sliderInput.addEventListener('input', () => {
        updateFill(sliderInput);
        chunkCounter.textContent = sliderInput.value
    })

    updateFill(sliderInput);
    buildTicks(2, 32, 1, svg, sliderInput);
</script>