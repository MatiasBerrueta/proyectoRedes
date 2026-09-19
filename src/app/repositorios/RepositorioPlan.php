<?php

class RepositorioPlan {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerPlanes() {
        try {
            $query = "SELECT id_plan, nombre, costo, max_jugadores, duracion FROM PLAN";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
    
            $datosPlanes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datosPlanes;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            throw $exception;
        }
    }
}