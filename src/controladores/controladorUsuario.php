<?php
require_once('../modelos/modeloUsuario.php');

class controladorUsuario {
    private $modeloUsuario;

    public function __construct($idUsuario, $nombre, $email, $contrasena, $tipo) {
        $this->modeloUsuario = new modeloUsuario($idUsuario, $nombre, $email, $contrasena, $tipo);
    }

    public function cambiarNombre($nuevoNombre) {
        if(is_null($nuevoNombre)) {
            return false;
        }

        $this->modeloUsuario->establecerNombre($nuevoNombre);
    }

    public function cambiarEmail($nuevoEmail) {
        return;
    }
}
?>