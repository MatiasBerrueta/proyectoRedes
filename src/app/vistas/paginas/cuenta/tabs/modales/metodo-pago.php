<dialog class="facturacion-modal" id="facturacion-modal-metodo" aria-labelledby="facturacion-modal-metodo-titulo" closedby="any">
    <div class="facturacion-modal__cabecera">
        <div>
            <h3 id="facturacion-modal-metodo-titulo">Método de pago</h3>
            <p class="facturacion-modal__subtitulo">
                Agregá o cambiá la tarjeta con la que se cobran las renovaciones.
            </p>
        </div>
        <button type="button" class="boton-cerrar" title="Cerrar" aria-label="Cerrar" commandfor="facturacion-modal-metodo" command="close">
            <?php include PUBLIC_ROOT . 'assets/iconos/x.svg'; ?>
        </button>
    </div>

    <form class="facturacion-modal__cuerpo" id="facturacion-form-metodo" method="dialog">
        <input type="hidden" name="metodo-destino">

        <div class="perfil-campo">
            <label for="facturacion-tarjeta-nombre" class="perfil-campo__label">Nombre en la tarjeta</label>
            <input type="text" id="facturacion-tarjeta-nombre" name="tarjeta-nombre" placeholder="Como figura en la tarjeta" required>
        </div>

        <div class="perfil-campo">
            <label for="facturacion-tarjeta-numero" class="perfil-campo__label">Número de tarjeta</label>
            <input
                type="text"
                id="facturacion-tarjeta-numero"
                name="tarjeta-numero"
                placeholder="0000 0000 0000 0000"
                inputmode="numeric"
                autocomplete="cc-number"
                required
            >
        </div>

        <div class="facturacion-dos-campos">
            <div class="perfil-campo">
                <label for="facturacion-tarjeta-vencimiento" class="perfil-campo__label">Vencimiento</label>
                <input
                    type="text"
                    id="facturacion-tarjeta-vencimiento"
                    name="tarjeta-vencimiento"
                    placeholder="MM/AA"
                    autocomplete="cc-exp"
                    required
                >
            </div>
            <div class="perfil-campo">
                <label for="facturacion-tarjeta-cvc" class="perfil-campo__label">Código de seguridad</label>
                <input
                    type="password"
                    id="facturacion-tarjeta-cvc"
                    name="tarjeta-cvc"
                    placeholder="CVC"
                    autocomplete="cc-csc"
                    required
                >
            </div>
        </div>

        <label class="switch">
            <div>
                <span class="perfil-bloque__titulo">Usar como método de pago principal</span>
            </div>
            <input type="checkbox" name="tarjeta-principal" checked>
            <span class="slider"></span>
        </label>

        <div class="facturacion-modal__pie">
            <button type="button" class="boton boton--secundario" commandfor="facturacion-modal-metodo" command="close">Cancelar</button>
            <button type="submit" class="boton boton--primario">Guardar método de pago</button>
        </div>
    </form>
</dialog>
