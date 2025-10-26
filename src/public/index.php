<?php
// TODO: (-- terminado, - a medias)
// -sistema de inicio de sesion. --
// -sistema de recuperar contrasena.
// -verificacion de contrasena valida (servidor) -
// -verificacion de contrasena valida (cliente) -
// -permitir crear o vincular cuentas con terceros autorizados (google, github)
// -sistema de roles
// -sistema de logs mas detallado especificamente para errores de bd

session_start();

// base de datos unicamente en los modelos, esto no
require_once '../config.php';
require_once '../vendor/autoload.php';
require_once '../rutas.php';
?>
