<?php
require_once('../config.php');
require_once('../modelos/modeloUsuario.php');

class controladorUsuario {
    private $modeloUsuario;

    public function __construct($idUsuario, $nombre, $email, $conexion) {
        $this->modeloUsuario = new modeloUsuario($idUsuario, $nombre, $email, $conexion);
    }

    public function cambiarNombre($nuevoNombre) {
        if(is_null($nuevoNombre)) {
            return false;
        }

        
        $this->modeloUsuario->modificarNombre($nuevoNombre);
    }
}
?>