<?php
require_once "../config.php";
require_once "../controladores/controladorAutenticar.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $controladorAutenticar = new controladorAutenticar($conexion);
    $mensaje = $controladorAutenticar->iniciarSesion($email, $contrasena);

    echo $mensaje;
}
?>