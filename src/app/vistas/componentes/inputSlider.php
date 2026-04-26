<div>
    <div class="form-group range-group">
        <label for="chunks"><?= $etiqueta ?>: <span id="chunks-value"><?= $valor ?? $default ?></span></label>
        <p class="descripcion"><?= $descripcion ?></p>
        <div class="range-wrapper">
            <input type="range" id="chunks" min="<?= $min ?>" max="<?= $max ?>" step="1" value="<?= $valor ?>">
            <!-- <div class="range-steps">
                <svg class="ticks" fill="currentColor" role="presentation" width="50%" height="26" xmlns="http://www.w3.org/2000/svg"></svg>
            </div> -->
        </div>
    </div>
</div>