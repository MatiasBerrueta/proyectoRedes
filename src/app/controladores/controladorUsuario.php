<?php
require_once APP_ROOT . 'modelos/modeloUsuario.php';

class controladorUsuario {
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