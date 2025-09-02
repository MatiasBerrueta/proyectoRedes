<?php
require_once('../model/userModel.php');
require_once('../config.php');

class userController {
    private $db;

    public function __construct() {
        $database = new database();
        $this->db = $database->getConexion();
    }

    private function validarContrasena($contrasena, $contrasenaRepetida) {
        // seguridad a implementar:
        // nombre o email no pueden estar en la contrasena
        // $longitud = strlen($contrasena) >= 12;
        $longitud = true;
        $contrasenasIguales = $contrasena === $contrasenaRepetida;

        return $longitud && $contrasenasIguales;
    }

    public function registrar($email, $contrasena, $contrasenaRepetida) {
        if (!$this->validarContrasena($contrasena, $contrasenaRepetida)) {
            return "La contraseña no cumple con los requisitos de seguridad.";
        }

        $usuario = new usuario($email, $contrasena, $this->db);

        if($usuario->crearUsuario()) {
            $this->iniciarSesion($usuario->getEmail(), $usuario->getContrasena());
            return "Cuenta creada.";
        } else {
            return "Error al registrar el usuario.";
        }
    }

    public function iniciarSesion($email, $contrasenaPlana) {
        $usuario = new usuario($email, $contrasenaPlana, $this->db);

        $datosUsuario = $usuario->autenticarUsuario($contrasenaPlana);

        if($datosUsuario) {
            session_start();
            $_SESSION['nombre'] = $datosUsuario['nombre'];
            header('Location: index.php');
            exit();
        } else {
            return "Creedenciales incorrectas";
        }
    }
}
?>