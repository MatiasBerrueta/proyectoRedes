<dialog class="facturacion-modal" id="facturacion-modal-plan" aria-labelledby="facturacion-modal-plan-titulo" closedby="any">
    <div class="facturacion-modal__cabecera">
        <div>
            <h3 id="facturacion-modal-plan-titulo">Cambiar de plan</h3>
            <p class="facturacion-modal__subtitulo">Elegí el plan que mejor se ajuste a tu servidor.</p>
        </div>
        <button type="button" class="boton-cerrar" title="Cerrar" aria-label="Cerrar" commandfor="facturacion-modal-plan" command="close">
            <?php include PUBLIC_ROOT . 'assets/iconos/x.svg'; ?>
        </button>
    </div>

    <form class="facturacion-modal__cuerpo" id="facturacion-form-plan" method="dialog">
        <div role="radiogroup" aria-label="Planes disponibles" class="facturacion-opciones">
            <?php foreach (($planes_disponibles ?? [
                ['id' => 'fabric-2', 'nombre' => 'Plan Fabric 2 GB', 'desc' => 'Para un grupo chico de amigos.', 'precio' => 'US$ 5,99'],
                ['id' => 'fabric-4', 'nombre' => 'Plan Fabric 4 GB', 'desc' => 'Para modpacks livianos y más jugadores.', 'precio' => 'US$ 9,99', 'actual' => true],
                ['id' => 'fabric-8', 'nombre' => 'Plan Fabric 8 GB', 'desc' => 'Para modpacks grandes y comunidades.', 'precio' => 'US$ 17,99'],
            ]) as $plan): ?>
                <label class="facturacion-opcion">
                    <input
                        type="radio"
                        name="plan"
                        value="<?= htmlspecialchars($plan['id'], ENT_QUOTES, 'UTF-8') ?>"
                        <?= !empty($plan['actual']) ? 'checked' : '' ?>
                    >
                    <span class="facturacion-opcion__punto" aria-hidden="true"></span>
                    <span class="facturacion-opcion__contenido">
                        <span class="facturacion-opcion__nombre">
                            <?= htmlspecialchars($plan['nombre'], ENT_QUOTES, 'UTF-8') ?>
                            <?php if (!empty($plan['actual'])): ?>
                                <span class="facturacion-badge facturacion-badge--mute">Plan actual</span>
                            <?php endif; ?>
                        </span>
                        <span class="facturacion-opcion__desc">
                            <?= htmlspecialchars($plan['desc'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </span>
                    <span class="facturacion-opcion__precio">
                        <?= htmlspecialchars($plan['precio'], ENT_QUOTES, 'UTF-8') ?>
                        <span class="facturacion-plan__periodo">/ mes</span>
                    </span>
                </label>
            <?php endforeach; ?>
        </div>

        <p class="facturacion-modal__nota">
            El nuevo precio se aplica desde la próxima renovación
            (<?= htmlspecialchars($suscripcion['fecha_renovacion'] ?? '01 nov 2026', ENT_QUOTES, 'UTF-8') ?>).
        </p>

        <div class="facturacion-modal__pie">
            <button type="button" class="boton boton--secundario" commandfor="facturacion-modal-plan" command="close">Cancelar</button>
            <button type="submit" class="boton boton--primario">Confirmar cambio</button>
        </div>
    </form>
</dialog>
