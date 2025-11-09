<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
</head>
<body>
    <?php
        echo "Bienvenido administrador: {$_SESSION['usuario']['nombre']}!";

        echo '<pre>';
        print_r($_SESSION['usuario']);
        echo '</pre>';
    ?>
    <a href="../logout">Cerrar sesion</a>
</body>
</html>