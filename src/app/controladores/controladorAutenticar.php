<?php
require_once APP_ROOT . 'modelos/modeloUsuario.php';

class controladorAutenticar {
    public function validarEmail($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Introduzca un email valido';
        } 

        if(modeloUsuario::obtenerUsuarioPorEmail($email)) {
            return 'Ya existe un usuario con ese email';
        }

        return '';
    }

    public function validarContrasena($contrasena) {
        $CARACTERES_MINIMOS = 3;

        if(strlen($contrasena) < $CARACTERES_MINIMOS) {
            return "La contrasena tiene que tener mas de $CARACTERES_MINIMOS caracteres";
        }

        return '';
    }

    public function validarConfirmacion($contrasena, $confirmarContrasena) {
         if($contrasena !== $confirmarContrasena) {
            return 'Las contrasenas no coinciden';
        }

        return '';
    }

    public function registrarUsuario($nombre, $email, $contrasena, $confirmarContrasena, $rol) {
        $emailError = $this->validarEmail($email);
        $contrasenaError = $this->validarContrasena($contrasena);
        $confirmarContrasenaError = $this->validarConfirmacion($contrasena, $confirmarContrasena);

        if ($emailError || $contrasenaError || $confirmarContrasenaError) {
            return [
                'ok' => false,
                'emailError' => $emailError,
                'contrasenaError' => $contrasenaError,
                'confirmarContrasenaError' => $confirmarContrasenaError
            ];
        }

        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $usuario = new modeloUsuario($email, $contrasenaHash);
        $usuario->establecerNombre($nombre);
        $usuario->establecerPais("Uruguay");
        
        $resultado = $usuario->insertarUsuario();

        if ($resultado) {
            $this->iniciarSesion($email, $contrasena);

            return [
                'ok' => true,
                'mensaje' => 'Usuario registrado correctamente'
            ];
        } 

        return [
            'ok' => false,
            'mensaje' => 'Error al registrar el usuario'
        ];
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

        if(!$datosUsuario) {
            return [
                'ok' => false,
                'mensaje' => 'El usuario no existe'
            ];
        }

        if(!password_verify($contrasena, $datosUsuario['contrasena'])) {
            return [
                'ok' => false,
                'mensaje' => 'Credenciales incorrectas'
            ];
        }
        
        $_SESSION['usuario'] = [
            'id' => $datosUsuario['id_usuario'],
            'nombre' => $datosUsuario['nombre'],
            'email' => $datosUsuario['email'],
            'rol' => $datosUsuario['rol'],
        ];

        return [
            'ok' => true,
            'rol' => $datosUsuario['rol']
        ];
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
    }
}