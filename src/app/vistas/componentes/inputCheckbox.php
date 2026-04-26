<div class="form-group">
    <label class="switch">
        <div>
            <span class="label-text"><?= $etiqueta ?></span>
            <p class="descripcion"><?= $descripcion ?></p>
        </div>
        <input 
            type="checkbox" 
            name="<?= $clave ?>" 
            <?= !empty($valor) ? 'checked' : '' ?>
        >
        <span class="slider"></span>
    </label>
</div>