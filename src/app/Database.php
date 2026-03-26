<?php
class Database {
    private $HOST = 'db_primario';
    private $BASE_DATOS = 'Voxel_Hosting';
    private $USUARIO = 'root';
    private $CONTRASENA = 'root123';
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host={$this->HOST};dbname={$this->BASE_DATOS};charset=utf8mb4", $this->USUARIO, $this->CONTRASENA);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            die("Conexión fallida: " . $exception->getMessage());
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}