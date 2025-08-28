<?php
class database {
    private $HOST = 'db';
    private $BASE_DATOS = 'proyectoRedesBase';
    private $USUARIO = 'root';
    private $CONTRASENA = 'root123';
    public $conexion;
    
    public function getConexion() {
        try {
            $this->conexion = new PDO("mysql:host=$this->HOST;dbname=$this->BASE_DATOS;charset=utf8", $this->USUARIO, $this->CONTRASENA);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            die("Conexión fallida: " . $exception->getMessage());
        }

        return $this->conexion;
    }
}
?>