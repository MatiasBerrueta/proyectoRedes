<?php
require_once APP_ROOT . 'database.php';

class ModeloUsuario {
    private $idUsuario;
    private $nombre;
    private $email;
    private $contrasena;
    private $rol;
    private $pais;
    private $temaVisual;
    private $notificacionesActivas;
    private $estado;

    public function __construct($email, $contrasena) {
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public function obtenerId() {
        return $this->idUsuario;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function obtenerEmail() {
        return $this->email;
    }

    public function obtenerRol() {
        return $this->rol;
    }

    public function obtenerPais() {
        return $this->pais;
    }

    public function obtenerContrasena() {
        return $this->contrasena;
    }

    public function obtenerTema() {
        return $this->temaVisual;
    }

    public function obtenerNotificaciones() {
        return $this->notificacionesActivas;
    }

    public function obtenerEstado() {
        return $this->estado;
    }

    public function establecerNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function establecerPais($pais) {
        $this->pais = $pais;
    }

    public function establecerContrasena($contrasena) {
        $this->contrasena = password_hash($contrasena, PASSWORD_BCRYPT);
    }

    public function establecerRol($rol) {
        $this->rol = $rol;
    }
}