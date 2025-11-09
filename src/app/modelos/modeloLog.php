<?php

class modeloLog {
    private $idLog;
    private $accion;
    private $entidad;
    private $usuario;
    private $fecha;
    private $descripcion;

    public function __construct($accion, $entidad, $usuario, $descripcion) {
        
    }

    public function insertarLog() {
        return;
    }

    public function obtenerLog() {
        return [];
    }

    public function obtenerLogs() {
        return [];
    }

    // sets y gets
}