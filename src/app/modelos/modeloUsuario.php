<?php
require_once APP_ROOT . 'database.php';

class modeloUsuario {
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

    public function obtenerContrasena() {
        return $this->contrasena;
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

    public function insertarUsuario() {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "CALL ESC_AGREGAR_USUARIO(:nombre, :email, :contrasena, :pais)";
        $stmt = $conexion->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $this->contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
        // $stmt->bindParam(':rol', $this->rol, PDO::PARAM_STR);
        $this->idUsuario = $conexion->lastInsertId();

        return $stmt->execute();
    }

    public static function obtenerUsuarioPorEmail($email) {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "SELECT id_usuario, nombre, email, contrasena, rol FROM USUARIO WHERE email = :email";
        $stmt = $conexion->prepare($query);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datosUsuario;
    }

    public static function obtenerUsuarios() {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "SELECT id_usuario, nombre, email, contrasena, rol FROM USUARIO";
        $stmt = $conexion->prepare($query);

        $stmt->execute();

        $datosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datosUsuario;
    }

    // Actualiza los datos del objeto en la bd.
    // Devuelve true si tuvo exito y false si no.
    public function actualizarUsuario() {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "UPDATE USUARIO SET :nombre, :email, :contrasena, :rol, :pais, :temaVisual, :notificacionesActivas, :estado WHERE id_usaurio = $this->idUsuario";
        $stmt = $conexion->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $this->contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
        $stmt->bindParam(':temaVisual', $this->temaVisual, PDO::PARAM_STR);
        $stmt->bindParam(':notificacionesActivas', $this->notificacionesActivas, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_STR);

        return $stmt->execute();
    }
}