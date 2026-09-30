<link rel="stylesheet" href="/css/paginas/servidor/tabs/archivos.css">

<?php  

/** @var array $datosTab */
    
    $path = isset($_GET['path']) ? trim($_GET['path'], '/') : '';
    $pathSeparado = !empty($path) ? explode('/', $path) : [];


    $esDirectorio = is_array($datosTab['data'] ?? null);
    $archivos = [];
    $fileContent = '';

    if ($esDirectorio) {
        $archivos = $datosTab['data'];
        usort($archivos, function(array $a, array $b): int {
            $aEsArchivo = !empty($a['attributes']['is_file']);
            $bEsArchivo = !empty($b['attributes']['is_file']);

            if ($aEsArchivo !== $bEsArchivo) {
                return $aEsArchivo <=> $bEsArchivo;
            }

            $aNombre = $a['attributes']['name'] ?? '';
            $bNombre = $b['attributes']['name'] ?? '';

            return strnatcasecmp($aNombre, $bNombre);
        });
    } else {
        $fileContent = $datosTab ?? '';
    }

    $acumulado = '';
?>

<div>
    <h2 class="texto-g">Directorio de archivos</h2>

    <div class="breadcrumbs">
        <span>/</span>
        <a href="?path=">home</a>
        <?php foreach ($pathSeparado as $segmento):
            $acumulado .= '/' . $segmento;
        ?>
            <span>/</span>
            <a href="?path=<?= urlencode(trim($acumulado, '/')) ?>">
                <?= htmlspecialchars($segmento) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($esDirectorio): ?>
        <div class="contenedor-archivos">
            <?php foreach ($archivos as $item): 
                $attr = $item["attributes"];
                $isFile = !empty($attr["is_file"]);
                $itemPath = $path !== '' ? $path . '/' . $attr["name"] : $attr["name"];
            ?>
                <div class="item" data-tipo="<?= $isFile ? 'archivo' : 'directorio' ?>" data-path="<?= htmlspecialchars($itemPath) ?>">
                    <input type="checkbox" name=<?= htmlspecialchars($attr["name"]) ?> id="archivos-seleccionados">
                    <div>
                        <?php if ($isFile): ?>
                            <?php include PUBLIC_ROOT . 'assets/iconos/file.svg' ?>
                        <?php else: ?>
                            <?php include PUBLIC_ROOT . 'assets/iconos/folder.svg' ?>
                        <?php endif; ?>
                        <?= htmlspecialchars($attr["name"]) ?>
                    </div>   
                    <div dir="rtl">
                        <?php if($isFile) echo Formatear::formatBytes($attr["size"]) ?>
                    </div> 
                    <div dir="rtl">
                        <?= Formatear::obtenerTiempoTranscurrido($attr["modified_at"]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <form class="editor-contenedor" action="guardar.php" method="POST">
            <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
            
            
            <textarea 
            id="editor"
            name="contenido" 
            class="editor-textarea" 
            spellcheck="false" 
            placeholder="Archivo vacío..."
            ><?= htmlspecialchars($fileContent) ?></textarea>
            
            <div class="editor-footer">
                <button type="submit" class="boton boton--primario">Guardar Cambios</button>
            </div>
        </form>
    <?php endif; ?>
</div>