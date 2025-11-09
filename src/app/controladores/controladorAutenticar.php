<?php
require_once APP_ROOT . 'modelos/modeloUsuario.php';

class controladorAutenticar {
    public function registrarUsuario($nombre, $email, $contrasena, $confirmarContrasena, $rol) {
        $emailError = '';
        $contrasenaError = '';
        $confirmarContrasenaError = '';

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Introduzca un email valido';
        } else {
            $usuarioEnBd = modeloUsuario::obtenerUsuarioPorEmail($email);

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
            $usuario->establecerPais("Uruguay");
            $resultado = $usuario->insertarUsuario();

            if(!is_null($resultado) && $resultado) {
                $this->iniciarSesion($email, $contrasena);
                exit;
            } else {
                $error = "Error al registrar el usuario.";
            }
        }

        require_once APP_ROOT . '/vistas/vistaRegistrarUsuario.php';
    }

    // Esta funcion deberia remplazar a la actual si se decide usar ajax
    // public function registrarUsuario($nombre, $email, $contrasena, $confirmarContrasena, $rol) {
    //     $errores = [];

    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errores['email'] = 'Introduzca un email valido';
    //     } else {
    //         $repositorioUsuario = new repositorioUsuario();
    //         $usuarioEnBd = $repositorioUsuario->obtenerUsuarioPorEmail($email);

    //         if ($usuarioEnBd) {
    //             $errores['email'] = 'Ya existe un usuario con ese email';
    //         }
    //     }

    //     if (strlen($contrasena) < 3) {
    //         $errores['contrasena'] = 'La contraseña debe tener mas de 3 caracteres';
    //     }

    //     if ($contrasena !== $confirmarContrasena) {
    //         $errores['confirmarContrasena'] = 'Las contraseñas no coinciden';
    //     }

    //     if (empty($errores)) {
    //         $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    //         $usuario = new modeloUsuario($email, $contrasenaHash);
    //         $usuario->establecerNombre($nombre);
    //         $usuario->establecerRol($rol);

    //         $resultado = $usuario->insertarUsuario($contrasena, $rol);

    //         if (!is_null($resultado) && $resultado) {
    //             $this->iniciarSesion($email, $contrasena);
    //             echo json_encode(['success' => true, 'redirect' => '/usuario/perfil']);
    //         } else {
    //             $errores['general'] = 'Error al registrar el usuario.';
    //         }
    //     }

    //     echo json_encode(['success' => false, 'errores' => $errores]);
    // }

    public function iniciarSesion($email, $contrasena) {
        $datosUsuario = modeloUsuario::obtenerUsuarioPorEmail($email);

        if($datosUsuario && password_verify($contrasena, $datosUsuario['contrasena'])) {
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
            require_once APP_ROOT . 'vistas/vistaIniciarSesion.php';
        }
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
        
        header('Location: /');
        exit();
    }
}