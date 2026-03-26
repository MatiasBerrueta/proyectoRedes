 <div class='plan'>
    <p class="font-size-4 flex-align-items" style="justify-content: space-between"><b><?= $plan['nombre'] ?></b><?php include PUBLIC_ROOT . 'assets/iconos/plan' . ($i + 1) . '.svg'; ?></p>
    <p><span class="font-size-6"><b><?= $plan['costo'] ?></span> usd / mes</b></p>
    <p>Pensado para hasta <?= $plan['max_jugadores'] ?> jugadores</p>
    <ul>
        <?php foreach($plan['prestaciones'] as $prestacion) : ?>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                <?= $prestacion ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <button class="boton">Adquirir</button>
</div>