<?php
require_once "../modelos/modeloAutenticar.php";

class controladorAutenticar {
    private $autenticar;

    public function __construct($db) {
        $this->autenticar = new modeloAutenticar($db);
    } 

    public function validarContrasena($contrasena, $confirmarContrasena) {
        // longitud minima en 3 para pruebas cambiar a 12 despues
        $longitud = strlen($contrasena) >= 3;
        $contrasenasIguales = $contrasena === $confirmarContrasena;

        return $longitud && $contrasenasIguales;
    }

    public function registrarUsuario($nombre, $email, $contrasena, $confirmarContrasena) {
        if (!$this->validarContrasena($contrasena, $confirmarContrasena)) {
            return "La contraseña no cumple con los requisitos de seguridad.";
        }

        $resultado = $this->autenticar->crearUsuario($nombre, $email, $contrasena);

        if($resultado) {
            $this->iniciarSesion($email, $contrasena);
        } else {
            return "Error al registrar el usuario.";
        }
    }

    public function iniciarSesion($email, $contrasena) {
        $datosUsuario = $this->autenticar->obtenerUsuarioPorEmail($email);

        if($datosUsuario && password_verify($contrasena, $datosUsuario['contrasena'])) {
            session_start();
            $_SESSION['idUsuario'] = $datosUsuario['idUsuario'];
            $_SESSION['nombre'] = $datosUsuario['nombre'];
            $_SESSION['email'] = $datosUsuario['email'];
            header('Location: index.php');
            exit();
        } else {
            return "Creedenciales incorrectas";
        }
    }

    public function cerrarSesion() {
        session_start();
        session_unset();
        session_destroy();
        
        header('Location: ../vistas/vistaIniciarSesion.php');
        exit();
    }
}