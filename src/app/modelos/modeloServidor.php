<?php

class modeloServidor {
    private $idServidor;
    private $nombre;
    private $dominio;
    private $puerto;
    private $estado;
    private $reglas;
    private $videojuego;
    private $ultimoLog;
    
    public function __construct() {

    }

    public function obtenerIdServidor() {
        return $this->idServidor;
    }

    public function establecerIdServidor($nuevoIdServidor) {
        $this->idServidor = $nuevoIdServidor;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function establecerNombre($nuevoNombre) {
        $this->nombre = $nuevoNombre;
    }

    public function obtenerDominio() {
        return $this->dominio;
    }

    public function establecerDominio($nuevoDominio) {
        $this->dominio = $nuevoDominio;
    }

    public function obtenerPuerto() {
        return $this->puerto;
    }

    public function establecerPuerto($nuevoPuerto) {
        $this->puerto = $nuevoPuerto;
    }

    public function obtenerEstado() {
        return $this->estado;
    }

    public function establecerEstado($nuevoEstado) {
        $this->estado = $nuevoEstado;
    }

    public function obtenerReglas() {
        return $this->reglas;
    }

    public function establecerReglas($nuevoReglas) {
        $this->reglas = $nuevoReglas;
    }

    public function obtenerVideojuego() {
        return $this->videojuego;
    }

    public function establecerVideojuego($nuevoVideojuego) {
        $this->videojuego = $nuevoVideojuego;
    }
}