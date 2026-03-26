<?php

class Controlador {
    protected function renderizar($vista, $datos = []) {
        extract($datos);
        include APP_ROOT . 'vistas/' . $vista . '.php';
    }

    protected function redirigir($url) {
        header("Location: {$url}");
        exit;
    }

    protected function requiereLogin() {
    if (!isset($_SESSION['usuario'])) {
        $this->redirigir('/login');
    }
}
}