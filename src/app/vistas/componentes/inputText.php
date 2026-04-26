<div class="form-group">    
    <label for="<?= $clave ?>"><?= $etiqueta ?></label>
    <?php if (!isset($descripcion) && !empty($descripcion)): ?>
        <p class="descripcion"><?= $descripcion ?></p>
    <?php endif; ?>
    <input 
        type="text" 
        name="<?= $clave ?>" 
        value="<?= $valor ?? $default ?>" 
    >
</div>