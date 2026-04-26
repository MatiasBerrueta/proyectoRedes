<div class="form-group">
    <label for="<?= $clave ?>"><?= $etiqueta ?></label>
    <p class="descripcion"><?= $descripcion ?></p>
    <select name="<?= $clave ?>" id="<?= $clave ?>" class="form-control">
        <?php foreach ($opciones as $opcion): ?>
            <option value="<?= $opcion || $default ?>" 
                <?= ($opcion == $valor) ? 'selected' : '' ?>>
                <?= $opcion ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>