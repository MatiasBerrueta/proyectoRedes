<?php
// TODO: (-- terminado, - a medias)
// -sistema de inicio de sesion. --
// -sistema de recuperar contrasena.
// -verificacion de contrasena valida (servidor) -
// -verificacion de contrasena valida (cliente) -
// -permitir crear o vincular cuentas con terceros autorizados (google, github)
// -sistema de roles --

session_start();

require_once '../app/config.php';
require_once '../vendor/autoload.php';
require_once APP_ROOT . 'rutas.php';