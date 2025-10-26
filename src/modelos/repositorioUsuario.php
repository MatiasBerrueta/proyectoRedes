<?php
require_once('../database.php');
require_once 'modeloUsuario.php';

class repositorioUsuario {
    private $conexion;

    public function __construct() {
        $db = new Database;
        $this->conexion = $db->getConexion();
    }

    public function obtenerUsuarioPorEmail($email) {
    $query = "SELECT id_usuario, nombre, email, contrasena, rol FROM USUARIO WHERE email = :email";
    // $query = "CALL /"
    $stmt = $this->conexion->prepare($query);

    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
    // $datosUsuario = $stmt->fetchObject('modeloUsuario');

    if($datosUsuario) {
        return $datosUsuario;
    } else {
        return null;
    }
}
}