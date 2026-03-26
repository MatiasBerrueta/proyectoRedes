<?php

require_once APP_ROOT . 'abstracts/JuegoAbstracto.php';

class DriverGenerico extends JuegoAbstracto {
    public function obtenerTabs() {
        throw new \Exception('Not implemented');
    }

    public function obtenerFunciones() {
        throw new \Exception('Not implemented');
    }

    public function obtenerConfiguraciones() {
        throw new \Exception('Not implemented');
    }
}
