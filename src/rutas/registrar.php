<?php
require_once "../config.php";
require_once "../controladores/controladorAutenticar.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmarContrasena = $_POST['confirmarContrasena'] ?? '';

    $controladorAutenticar = new controladorAutenticar($conexion);
    $mensaje = $controladorAutenticar->registrarUsuario($nombre, $email, $contrasena, $confirmarContrasena);

    echo $mensaje;
}

require_once "../vistas/vistaRegistrarUsuario.php";
?>