<?php
// TODO: (-- terminado, - a medias)
// -sistema de inicio de sesion. --
// -sistema de recuperar contrasena.
// -verificacion de contrasena valida (servidor) -
// -verificacion de contrasena valida (cliente)
// -permitir crear o vincular cuentas con terceros autorizados (google, github)
require_once('../config.php');
session_start();

if(!isset($_SESSION['nombre'])) {
    header('Location: login.php');
    exit();
}

require_once('views/viewPaginaPrincipal');
?>
