<?php
require_once APP_ROOT . 'database.php';
require_once APP_ROOT . 'modelos/api/pterodactylClientApi.php';

class modeloServidor {
    private $idServidor;
    private $nombre;
    private $dominio;
    private $puerto;
    private $estado;
    private $reglas;
    private $ultimoLog;
    private $videojuego;
    
    public function __construct() {

    }

    public function insertarServidor() {
        return;
    }

    public static function obtenerServidor($idServidor) {
        return [];
    }

    public static function obtenerServidores() {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "SELECT nombre, dominio, puerto, estado, id_videojuego FROM USUARIO";
        $stmt = $conexion->prepare($query);

        $stmt->execute();

        $datosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($datosUsuario) {
            return $datosUsuario;
        } else {
            return null;
        }
    }

    public static function obtenerServidoresPterodactyl() {
        $clientKey = 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I';

        $api = new pterodactylClientApi($clientKey);
        $servidores = $api->obtenerServidores();

        return $servidores;
    }

    public function modificarServidor() {
        return;
    }

    public function borrarServidor() {
        return;
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