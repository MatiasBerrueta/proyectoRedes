 <?php if(!isset($plan)) return; ?>
 <div class='plan'>
    <p class="texto-g flex-align-items flex--space-between"><span class="plan-titulo"><?= $plan['nombre'] ?></span><?php include PUBLIC_ROOT . 'assets/iconos/plan' . (1) . '.svg'; ?></p>
    <p><span class="plan-precio texto-g"><b>$<span class="texto-2xl texto-principal"><?= $plan['costo'] ?></span></b> usd / mes</p>
    <p class="plan-descripcion">Pensado para hasta <?= $plan['max_jugadores'] ?> jugadores</p>
    <div class="separador"></div>
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