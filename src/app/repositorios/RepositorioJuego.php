<?php

class RepositorioJuego {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerJuegos() {
        try {
            $query = "SELECT * FROM JUEGO";
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