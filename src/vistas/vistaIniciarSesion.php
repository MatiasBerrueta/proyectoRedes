<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/registro.css">
    <title>Login - Voxel Hosting</title>
</head>
<body>
    <div class="form-container">
        <div style="display: grid; place-content: center;">
            <img src="assets/logo.svg" alt="Voxel Hosting Logo" class="logo">
        </div>
        <form action="" method="POST">
            <div>
                <!-- <label for="input-email">Email</label> -->
                <img src="/assets/iconoEmail.svg" alt="Icono email" class="icon">
                <input id="input-email" type="text" placeholder="email@gmail.com" name="email">
            </div>
            <div>
                <!-- <label for="input-contrasena">Contraseña</label> -->
                <img src="/assets/iconoContrasena.svg" alt="Icono contrasena" class="icon">
                <input id="input-contrasena" type="password" placeholder="contraseña" name="contrasena">
                <button id="boton-toggle-confirmar-contrasena" class="boton-toggle-contrasena" type="button" onClick="toggleContrasena(this)" data-target="input-contrasena">
                    <img src="/assets/iconoVerContrasena.svg" alt="Icono ver contrasena" class="icon">
                </button>
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
        <small class="mensaje-form">No tenes una cuenta? <a href="/registrarCliente">Crear una cuenta</a></small>
    </div>
    <script>
        function toggleContrasena(actionButton) {
            const targetId = actionButton.getAttribute("data-target");
            const targetInput = document.getElementById(targetId);

            if (targetInput.type === "password") {
                targetInput.type = "text";
                actionButton.innerHTML = '<img src="/assets/iconoOcultarContrasena.svg" alt="Icono ocultar contrasena" class="icon">';
            } else {
                targetInput.type = "password";
                actionButton.innerHTML = '<img src="/assets/iconoVerContrasena.svg" alt="Icono ver contrasena" class="icon">';
            }
        }
    </script>
</body>
</html>