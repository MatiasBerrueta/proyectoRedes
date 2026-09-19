<?php
// TODO: (-- terminado, - a medias)
// -sistema de inicio de sesion. --
// -sistema de recuperar contrasena.
// -verificacion de contrasena valida (servidor) -
// -verificacion de contrasena valida (cliente) -
// -permitir crear o vincular cuentas con terceros autorizados (google, github)
// -sistema de roles --

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config.php';
require_once APP_ROOT . 'rutas.php';