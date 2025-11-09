<?php

class modeloHistorialPago {
    private $idPago;
    private $metodoPago;
    private $monto;
    private $fechaPago;
    private $estado;
    private $fechaVencimiento;
    private $idUsuario;

    public function __construct($metodoPago, $monto, $estado, $fechaVencimiento, $idUsuario) {
        $this->metodoPago = $metodoPago;
        $this->monto = $monto;
        $this->estado = $estado;
        $this->fechaVencimiento = $fechaVencimiento;
        $this->idUsuario = $idUsuario;
    }

    public function aprobar() {
        return;
    }

    public function rechazar() {
        return;
    }

    public function estaPagado() {
        return true;
    }

    public function asignarAUsuario($userId) {
        return;
    }

    public function buscarPorUsuario($userId) {
        return [];
    }

    public function insertarPago() {
        return;
    }

    public function obtenerPagos() {
        return [];
    }

    public function obtenerPago($idPago) {
        return null;
    }

    public function actualizarPago() {
        return;
    }

    public function elimiarPago() {
        return;
    }

    public function obtenerPagosPendientes() {
        return [];
    }

    public function generarEstadisticas() {
        return [];
    }

     public function obtenerIdPago() {
        return $this->idPago;
    }

    public function establecerIdPago($nuevoIdPago) {
        $this->idPago = $nuevoIdPago;
    }

    public function obtenerMetodoPago() {
        return $this->metodoPago;
    }

    public function establecerMetodoPago($nuevoMetodoPago) {
        $this->metodoPago = $nuevoMetodoPago;
    }

    public function obtenerMonto() {
        return $this->monto;
    }

    public function establecerMonto($nuevoMonto) {
        $this->monto = $nuevoMonto;
    }

    public function obtenerFechaPago() {
        return $this->fechaPago;
    }

    public function establecerFechaPago($nuevaFechaPago) {
        $this->fechaPago = $nuevaFechaPago;
    }

    public function obtenerEstado() {
        return $this->estado;
    }

    public function establecerEstado($nuevoEstado) {
        $this->estado = $nuevoEstado;
    }

    public function obtenerFechaVencimiento() {
        return $this->fechaVencimiento;
    }

    public function establecerFechaVencimiento($nuevaFechaVencimiento) {
        $this->fechaVencimiento = $nuevaFechaVencimiento;
    }

    public function obtenerIdUsuario() {
        return $this->idUsuario;
    }

    public function establecerIdUsuario($nuevaIdUsuario) {
        $this->idUsuario = $nuevaIdUsuario;
    }    
}