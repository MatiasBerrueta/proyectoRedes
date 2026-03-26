<?php
require_once APP_ROOT . 'controladores/Controlador.php';
require_once APP_ROOT . 'utils/Validar.php';

class ControladorUsuario extends Controlador {
    private $servicio;

    public function __construct(ServicioUsuario $servicio) {
        $this->servicio = $servicio;
    }

    public function mostrarLogin($datos = []) {
        $this->renderizar('paginas/inicioSesion', $datos);
    }

    public function mostrarRegristro() {
        $this->renderizar('paginas/registroUsuario');
    }

    public function mostrarServidor($idServidor) {
        $this->requiereLogin();
        $this->renderizar('/paginas/servidor', ['id_servidor' => $idServidor]);
    }

    public function registrarUsuario() {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $confirmarContrasena = $_POST['confirmarContrasena'];
        $rol = 'CLIENTE';

        if (!Validar::mail($email) || !Validar::contrasena($contrasena)) {
            $this->mostrarLogin(['error' => 'Datos inválidos']);
            return;
        } else if ($contrasena !== $confirmarContrasena) {
            $this->mostrarLogin(['error' => 'Las contraseñas no coinciden']);
            return;
        }

        $usuario = $this->servicio->crearUsuario($nombre, $email, $contrasena, $rol);
        if(!$usuario) {
            $this->mostrarLogin(['error' => 'Ocurrio un error al crear el usaurio']);
            return;
        }

        $this->iniciarSesion();
    }

    public function iniciarSesion() {
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];

        if (!Validar::mail($email) || !Validar::contrasena($contrasena)) {
            $this->renderizar('paginas/inicioSesion', ['error' => 'Datos inválidos']);
            return;
        }

        $datosUsuario = $this->servicio->autenticar($email, $contrasena);

        if(!$datosUsuario) {
            $this->mostrarLogin(['error' => 'No se pudo autenticar']);
            return;
        }
        
        $_SESSION['usuario'] = [
            'id' => $datosUsuario['id_usuario'],
            'nombre' => $datosUsuario['nombre'],
            'email' => $datosUsuario['email'],
            'rol' => $datosUsuario['rol'],
        ];

        unset($_POST);
        $this->redirigir('/panel');
    }

    public function cerrarSesion() {
        session_unset();
        session_destroy();
        $this->redirigir('/');
    }

    // Esta funcion se encarga de modificar los datos del usuario
    // Recibe parametros que pueden ser null (ej: si solo queres cambiar el email, 
    // los demas campos vendrian como null). Usa los sets del modeloUsuario para 
    // actualizar los datos localmente y despues guarda todo en la base de datos 
    // usando actualizarUsuario().
    public function modificarUsuario() {
        return true;
    }

    // Esta funcion ejecuta metodos para recuperar la contrasena del usuario:
    // 1- Envia al usuario al formulario recuperarContrasena donde ingresara su email
    // 2- Una vez se tiene el email se verifica que exista en la bd y se envia el email al usuario
    // 3- Se muestra un mensaje tipo "Se ha enviado un email al correo especificado"
    // El email tiene que tener un link que lo enviara a un formulario donde podra escribir su nueva contrasena
    // La parte donde el usuario pone su contrasena y se actualiza en la bd se manejan en la funcionn modificarUsuario()
    public function recuperarContrasena() {
        return true;
    }
}
?>