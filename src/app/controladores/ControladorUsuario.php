<?php

require_once APP_ROOT . 'controladores/Controlador.php';
require_once APP_ROOT . 'utils/Validar.php';

class ControladorUsuario extends Controlador {
    private ServicioUsuario $servicioUsuario;

    public function __construct(ServicioUsuario $servicioUsuario) {
        $this->servicioUsuario = $servicioUsuario;
    }

    public function mostrarLogin($datos = []) {
        $this->renderizar('paginas/inicioSesion', $datos);
    }

    public function mostrarRegristro() {
        $this->renderizar('paginas/registroUsuario');
    }

    public function mostrarServidor(int $idServidor) {
        $this->requiereLogin();

        $this->renderizar('/paginas/servidor', [
            'id_servidor' => $idServidor
        ]);
    }

    public function registrarUsuario() {
        $logger = ServicioLogger::obtenerLogger();

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $confirmarContrasena = $_POST['confirmarContrasena'];
        $pais = $_POST['pais'];

        if (!Validar::mail($email) || !Validar::contrasena($contrasena)) {
            $this->mostrarRegristro();
            $logger->error("Controlador: Datos invalidos");
            return;
        }

        if ($contrasena !== $confirmarContrasena) {
            $this->mostrarRegristro();
            $logger->error("Controlador: Las contrasenas no coinciden");
            return;
        }

        $usuario = $this->servicioUsuario->crearUsuario(
            $nombre,
            $email,
            $contrasena,
            $pais
        );

        if (!$usuario) {
            $this->mostrarRegristro();
            $logger->error("Controlador: hubo un error al crear el usuario");
            return;
        }

        $_SESSION['usuario'] = [
            'id' => $usuario->obtenerId(),
            'nombre' => $usuario->obtenerNombre(),
            'email' => $usuario->obtenerEmail(),
            'rol' => $usuario->obtenerRol()->value
        ];

        $this->redirigir('/servidores');
    }

    public function iniciarSesion() {
        $logger = ServicioLogger::obtenerLogger();

        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];

        if (!Validar::mail($email) || !Validar::contrasena($contrasena)) {
            $this->mostrarLogin([
                'error' => 'Datos inválidos'
            ]);
            return;
        }

        $datosUsuario = $this->servicioUsuario->autenticarUsuario(
            $email,
            $contrasena
        );

        if (is_null($datosUsuario)) {
            $this->mostrarLogin([
                'error' => 'No se pudo autenticar'
            ]);
            $logger->error("No se encontro el usuario en bd.");
            return;
        }

        $_SESSION['usuario'] = [
            'id' => $datosUsuario['id_usuario'],
            'nombre' => $datosUsuario['nombre'],
            'email' => $datosUsuario['email'],
            'rol' => $datosUsuario['rol']
        ];

        unset($_POST);

        $this->redirigir('/servidores');
    }

    public function cerrarSesion() {

        session_unset();
        session_destroy();

        $this->redirigir('/');
    }

    public function mostrarPerfil($datos = []) {
        $this->requiereLogin();

        $idUsuario = $_SESSION['usuario']['id'];

        $usuario = $this->servicioUsuario->obtenerUsuario($idUsuario);

        if (!$usuario) {
            $datos['error'] = 'No se pudo obtener la información del usuario.';
        }

        $datos['usuario'] = $usuario;

        $this->renderizar('paginas/vistaPerfil', $datos);
    }

    public function actualizarPerfil() {
        $this->requiereLogin();

        $idUsuario = $_SESSION['usuario']['id'];

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pais = trim($_POST['pais'] ?? '');

        if (
            empty($nombre) ||
            empty($email) ||
            !Validar::mail($email)
        ) {
            $this->mostrarPerfil([
                'error' => 'Completá correctamente los campos obligatorios.'
            ]);
            return;
        }

        $resultado = $this->servicioUsuario->modificarUsuario($idUsuario, $nombre, $pais);

        if (is_null($resultado) || !$resultado) {
            $this->mostrarPerfil([
                'error' => 'No se pudo actualizar el perfil.'
            ]);
            return;
        }

        $_SESSION['usuario']['nombre'] = $nombre;
        // $_SESSION['usuario']['email'] = $email;

        $this->mostrarPerfil([
            'mensaje' => 'Perfil actualizado correctamente.'
        ]);
    }

    public function recuperarContrasena() {
        return true;
    }
}
?>
