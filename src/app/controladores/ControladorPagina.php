<?php
require_once APP_ROOT . 'controladores/Controlador.php';

class ControladorPagina extends Controlador {
    private $repositorio;

    public function __construct($repositorio) {
        $this->repositorio = $repositorio;
    }

    public function mostrarPrincipal() {
        $planes = $this->repositorio->obtenerPlanes();
        $planes[0]['prestaciones'] = ['bajo precio', '8GB de RAM'];
        $planes[1]['prestaciones'] = ['bajo precio', '8GB de RAM'];
        $planes[2]['prestaciones'] = ['bajo precio', '8GB de RAM'];

        $this->renderizar('paginas/principal', ['planes' => $planes]);
    }
}