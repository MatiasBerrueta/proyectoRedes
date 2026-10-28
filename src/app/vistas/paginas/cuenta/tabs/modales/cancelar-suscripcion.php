<dialog class="facturacion-modal facturacion-modal--peligro" id="facturacion-modal-cancelar" aria-labelledby="facturacion-modal-cancelar-titulo" closedby="any">
    <div class="facturacion-modal__cabecera">
        <div>
            <h3 id="facturacion-modal-cancelar-titulo">Cancelar suscripción</h3>
            <p class="facturacion-modal__subtitulo">Lamentamos que te vayas. Revisá qué pasa si cancelás.</p>
        </div>
        <button type="button" class="boton-cerrar" title="Cerrar" aria-label="Cerrar" commandfor="facturacion-modal-cancelar" command="close">
            <?php include PUBLIC_ROOT . 'assets/iconos/x.svg'; ?>
        </button>
    </div>

    <form class="facturacion-modal__cuerpo" id="facturacion-form-cancelar" method="dialog">
        <ul class="facturacion-consecuencias">
            <li>Tu servidor sigue activo hasta el
                <?= htmlspecialchars($suscripcion['fecha_renovacion'] ?? '01 nov 2026', ENT_QUOTES, 'UTF-8') ?>.
            </li>
            <li>No se te cobra la próxima renovación.</li>
            <li>Después de esa fecha el servidor se suspende. Tus mundos y backups se conservan 30 días.</li>
        </ul>

        <div class="perfil-campo">
            <label for="facturacion-motivo" class="perfil-campo__label">¿Por qué cancelás? (opcional)</label>
            <select id="facturacion-motivo" name="motivo" class="perfil-select">
                <option value="">Elegí un motivo</option>
                <option value="caro">Es muy caro</option>
                <option value="uso">Ya no lo uso</option>
                <option value="otro-proveedor">Me cambié de proveedor</option>
                <option value="tecnico">Tuve problemas técnicos</option>
                <option value="otro">Otro motivo</option>
            </select>
        </div>

        <div class="facturacion-modal__pie">
            <button type="button" class="boton boton--secundario" commandfor="facturacion-modal-cancelar" command="close">Mantener suscripción</button>
            <button type="submit" class="boton boton--peligro">Cancelar suscripción</button>
        </div>
    </form>
</dialog>
