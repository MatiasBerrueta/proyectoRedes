<?php
require_once "../modelos/modeloUsuario.php";
require_once "../modelos/repositorioUsuario.php";

class controladorAutenticar {
    public function registrarUsuario($nombre, $email, $contrasena, $confirmarContrasena, $rol) {
        $emailError = '';
        $contrasenaError = '';
        $confirmarContrasenaError = '';

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Introduzca un email valido';
        } else {
            $repositorioUsuario = new repositorioUsuario();
            $usuarioEnBd = $repositorioUsuario->obtenerUsuarioPorEmail($email);

            if($usuarioEnBd) {
                $emailError = 'Ya existe un usuario con ese email';
            }
        }

        if(strlen($contrasena) < 3) {
            $contrasenaError = 'La contrasena tiene que tener mas de 3 caracteres';
        }

        if($contrasena != $confirmarContrasena) {
            $confirmarContrasenaError = 'Las contrasena no coinciden';
        }

        if(!$emailError && !$contrasenaError && !$confirmarContrasenaError) {
            $contrasenaHash = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
            $usuario = new modeloUsuario($_POST['email'], $contrasenaHash);
            $usuario->establecerNombre($nombre);
            $resultado = $usuario->insertarUsuario($contrasena, $rol);

            if(!is_null($resultado) && $resultado) {
                $this->iniciarSesion($email, $contrasena);
                exit;
            } else {
                $error = "Error al registrar el usuario.";
            }
        }

        require_once '../vistas/vistaRegistrarUsuario.php';
    }

    public function iniciarSesion($email, $contrasena) {
        $repositorioUsuario = new repositorioUsuario();
        $datosUsuario = $repositorioUsuario->obtenerUsuarioPorEmail($email);

        if(password_verify($contrasena, $datosUsuario['contrasena'])) {
            $_SESSION['usuario'] = [
                'id' => $datosUsuario['id_usuario'],
                'nombre' => $datosUsuario['nombre'],
                'email' => $datosUsuario['email'],
                'rol' => $datosUsuario['rol'],
            ];

            if($datosUsuario['rol'] === 'ADMIN') {
                header("Location: /admin/perfil");
            } else if ($datosUsuario['rol'] === 'CLIENTE') {
                header("Location: /usuario/perfil");
            }
        } else {
            $error = "Credenciales incorrectas";
            require_once '../vistas/vistaIniciarSesion.php';
        }
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
        
        header('Location: /');
        exit();
    }
}