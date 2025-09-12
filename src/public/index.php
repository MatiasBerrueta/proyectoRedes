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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
</head>
<body>
    <?php echo 'Hola! ' . $_SESSION['nombre'] ?>
    <a href="logout.php">Cerrar sesion</a>
</body>
</html>