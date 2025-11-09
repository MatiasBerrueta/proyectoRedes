<?php
require_once APP_ROOT . 'database.php';

class modeloPlan {
    private $idPlan;
    private $nombre;
    private $costo;
    private $maxJugadores;
    private $duracion;

    public function __construct($idPlan, $nombre, $costo, $maxJugadores, $duracion) {
        $this->idPlan = $idPlan;
        $this->nombre = $nombre;
        $this->costo = $costo;
        $this->maxJugadores = $maxJugadores;
        $this->duracion = $duracion;
    }

    // Inserta el plan en la base de datos
    public function insertarPlan() {
        return true;
    }

    // Selecciona un unico plan desde la base de datos usando una id
    public static function obtenerPlan($id) {
        return true;
    }

    // Selecciona todos los planes que haya
    public static function obtenerPlanes() {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "SELECT id_plan, nombre, costo, max_jugadores, duracion FROM PLAN";
        $stmt = $conexion->prepare($query);
        $stmt->execute();

        $datosPlanes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($datosPlanes) {
            return $datosPlanes;
        } else {
            return null;
        }
    }

    // Actualiza todos los datos de planes, se puede usar para modificar un solo dato
    public function modificarPlan() {
        return true;
    }


    // Borra el plan de la base de datos
    public function borrarPlan() {
        return true;
    }

    public function obtenerIdPlan() {
        return $this->idPlan;
    }

    public function establecerIdPlan($nuevoIdPlan) {
        $this->idPlan = $nuevoIdPlan;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function establecerNombre($nuevoNombre) {
        $this->nombre = $nuevoNombre;
    }

    public function obtenerCosto() {
        return $this->costo;
    }

    public function establecerCosto($nuevoCosto) {
        $this->costo = $nuevoCosto;
    }

    public function obtenerMaxJugadores() {
        return $this->maxJugadores;
    }

    public function establecerMaxJugadores($nuevoMaxJugadores) {
        $this->maxJugadores = $nuevoMaxJugadores;
    }

    public function obtenerDuracion() {
        return $this->duracion;
    }

    public function establecerDuracion($nuevoDuracion) {
        $this->duracion = $nuevoDuracion;
    }
}
