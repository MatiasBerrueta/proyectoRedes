<?php
require_once APP_ROOT . 'controladores/Controlador.php';

class ControladorPagina extends Controlador {
    private RepositorioPlan $repositorio;

    public function __construct(RepositorioPlan $repositorio) {
        $this->repositorio = $repositorio;
    }

    public function mostrarPrincipal() {
        $planes = $this->repositorio->obtenerPlanes();

        $this->renderizar('paginas/principal', ['planes' => $planes]);
        // $this->renderizar('paginas/principal');
    }
}