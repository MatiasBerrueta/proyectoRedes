<?php
require_once "../controller/userController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $controller = new userController();
    $mensaje = $controller->iniciarSesion($email, $contrasena);

    echo $mensaje;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="form-container">
        <h1>Login</h1>
        <form action="" method="POST">
            <div>
                <!-- <label for="input-email">Email</label> -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="icon">
                    <path fill-rule="evenodd" d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z" clip-rule="evenodd" />
                </svg>
                <input id="input-email" type="text" placeholder="email@gmail.com" name="email">
            </div>
            <div>
                <!-- <label for="input-contrasena">Contraseña</label> -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="icon">
                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                </svg>
                <input id="input-contrasena" type="password" placeholder="contraseña" name="contrasena">
            </div>
            <small class="mensaje-form"><a href="">Olvide mi contrasena</a></small>
            <button class="boton-subir boton-azul" type="submit">Ingresar</button>
        </form>
        <div class="separador">
            <hr class="linea">
            <small>O con</small>
            <hr class="linea">
        </div>
        <div class="contenedor-otras-opciones">
            <button class="boton-subir">
                Continuar con Google
            </button>
            <button class="boton-subir boton-negro">                
                Continuar con Github
            </button>
        </div>
        <small class="mensaje-form">No tenes una cuenta? <a href="registrar.php">Crear una cuenta</a></small>
    </div>
</body>
</html>