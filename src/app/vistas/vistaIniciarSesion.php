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
        <img src="assets/logo.svg" alt="Voxel Hosting Logo" class="logo">
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
                <button id="boton-toggle-confirmar-contrasena" class="boton-toggle-contrasena" type="button" onClick="toggleContrasena(this, 'input-contrasena')">
                    <img src="/assets/iconoVerContrasena.svg" alt="Icono ver contrasena" class="icon">
                </button>
            </div>
            <small class="mensaje-form"><a href="/recuperarContrasena">Olvide mi contrasena</a></small>
            <button class="boton-subir boton-azul" type="submit">Ingresar</button>
            <?php if(!empty($error)): ?>
                <p class="mensaje-input"><?= $error ?> </p>
            <?php endif; ?>
        </form>
        <div class="separador">
            <hr class="linea">
            <small>O con</small>
            <hr class="linea">
        </div>
         <div class="contenedor-otras-opciones">
            <button class="boton-subir">
                <div class="gsi-material-button-icon">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </svg>
                </div>
                Continuar con Google
            </button>
            <button class="boton-subir boton-negro">
                <img src="/assets/github-mark-white.svg" alt="Icono Github" class="icono-github">                
                Continuar con Github
            </button>
        </div>
        <small class="mensaje-form">No tenes una cuenta? <a href="/registrarCliente">Crear una cuenta</a></small>
    </div>
    <script>
        function toggleContrasena(boton, targetId) {
            const targetInput = document.getElementById(targetId);

            if (targetInput.type === "password") {
                targetInput.type = "text";
                boton.innerHTML = '<img src="/assets/iconoOcultarContrasena.svg" alt="Icono ocultar contrasena" class="icon">';
            } else {
                targetInput.type = "password";
                boton.innerHTML = '<img src="/assets/iconoVerContrasena.svg" alt="Icono ver contrasena" class="icon">';
            }
        }
    </script>
</body>
</html>