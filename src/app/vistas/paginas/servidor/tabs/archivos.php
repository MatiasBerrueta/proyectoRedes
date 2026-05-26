<link rel="stylesheet" href="/css/paginas/servidor/tabs/archivos.css">
<div>
    <h2 class="texto-g">Directorio de archivos</h2 class="texto-xl">

    <!-- <pre>c -->
    <!-- <?= print_r($datosTab['data']) ?> -->
    <!-- </pre> -->

    <div class="breadcrumbs">
        <a href="#">/home</a>
    </div>
    <div class="contenedor-archivos">
        <?php 
            $archivos = $datosTab['data'];
            usort($archivos, function($a, $b) {
                return ($a["attributes"]["is_file"] ?? 0) <=> ($b["attributes"]["is_file"] ?? 0);
            });
        ?>
        <?php foreach ($archivos as $item): 
            $attr = $item["attributes"];
            $isFile = !empty($attr["is_file"]);
        ?>
            <div class="item">
                <?php if ($isFile): ?>
                    <?php include PUBLIC_ROOT . 'assets/iconos/file.svg' ?> <?= htmlspecialchars($attr["name"]) ?>
                <?php else: ?>
                    <?php include PUBLIC_ROOT . 'assets/iconos/folder.svg' ?> <?= htmlspecialchars($attr["name"]) ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>