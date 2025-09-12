<?php
require_once('../config.php');
require_once('../model/userModel.php');

class userController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function validarContrasena($contrasena, $confirmarContrasena) {
        // longitud minima en 3 para pruebas cambiar a 12 despues
        $longitud = strlen($contrasena) >= 3;
        $contrasenasIguales = $contrasena === $confirmarContrasena;

        return $longitud && $contrasenasIguales;
    }

    public function registrar($nombre, $email, $contrasena, $confirmarContrasena) {
        if (!$this->validarContrasena($contrasena, $confirmarContrasena)) {
            return "La contraseña no cumple con los requisitos de seguridad.";
        }

        $usuario = new usuario($email, $contrasena, $this->db);
        // capas esto deberia ir en el constructor y ponerlo null en iniciarSesion
        $usuario->setNombre($nombre);

        if($usuario->crearUsuario()) {
            $this->iniciarSesion($usuario->getEmail(), $contrasena);
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