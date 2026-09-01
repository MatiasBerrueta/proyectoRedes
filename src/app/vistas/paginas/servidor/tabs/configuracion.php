<?php require_once APP_ROOT . "vistas/componentes/formulario.php"; ?>

<link rel="stylesheet" href="/css/paginas/servidor/tabs/configuracion.css">
<link rel="stylesheet" href="/css/componentes.css">
<div class="config-container">
    <h2 class="texto-g">Configuración del Servidor</h2>
    <section class="contenedor-configuraciones">
        <?php
        $logger = ServicioLogger::obtenerLogger();

        $logger->info("configuracion:", $datosTab);

        $agrupados = agruparPorSeccion($datosTab);

        foreach($agrupados as $seccion => $configuraciones) {
            echo "<section class='config-seccion'>";
            echo "<h3>" . htmlspecialchars(ucfirst($seccion)) . "</h3>";
            echo "<div class='configuraciones'>";

            foreach($configuraciones as $configuracion) {
                renderizarInput($configuracion);
            }

            echo "</div>";
            echo "</section>";
        }
        ?>
    </section>
    <section class="acciones-config">
        <button class="boton boton--primario">Guardar cambios</button>
        <button class="boton boton--peligro">Restablecer</button>
    </section>
</div>
