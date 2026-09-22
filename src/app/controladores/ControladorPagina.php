<?php
require_once APP_ROOT . 'controladores/Controlador.php';

class ControladorPagina extends Controlador {
    private RepositorioPlan $repositorioPlan;
    private RepositorioJuego $repositorioJuego;

    public function __construct(RepositorioPlan $repositorioPlan, RepositorioJuego $repositorioJuego) {
        $this->repositorioPlan = $repositorioPlan;
        $this->repositorioJuego = $repositorioJuego;
    }

    public function mostrarPrincipal() {
        $planes = $this->repositorioPlan->obtenerPlanes();

        $this->renderizar('paginas/principal', ['planes' => $planes]);
        // $this->renderizar('paginas/principal');
    }

    public function mostrarJuegos() {
        $juegos = $this->repositorioJuego->obtenerJuegos();

        $this->renderizar('paginas/juegos', ['juegos' => $juegos]);
    }
}