<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    (function() {
        const temaGuardado = localStorage.getItem('tema');
        if (temaGuardado === 'oscuro') document.documentElement.classList.add('tema-oscuro');
    })();
    </script>
    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/componentes.css">
    <link rel="stylesheet" href="css/paginas/registro.css">
    <script src="js/validacionRegistro.js" defer></script>
    <title>Registro - Voxel Hosting</title>
</head>
<body class="layout-auth">
    <div class="auth-fondo">
        <a href="/" class="logo">
            <?php include PUBLIC_ROOT . "assets/iconos/logo.svg"; ?>
            <h1>Voxel Hosting</h1>
        </a>
    </div>
    <div class="auth-form">
        <div class="auth-navegacion">
            <a class="boton" href="/login">Iniciar Sesion</a>
            <a class="boton boton--primario" href="/registroUsuario">Crear cuenta</a>
        </div>
        <div class="auth-titulo">
            <h1>Crea tu cuenta</h1>
            <p>Ingresa tus datos para registrarte.</p>
        </div>
        <form id="formulario-registro" action="/registrarCliente" method="POST">
            <div class="auth-input-group">
                <label for="input-nombre">Nombre</label>
                <div>
                    <?php include PUBLIC_ROOT . "assets/iconos/user.svg"; ?>
                    <input id="input-nombre" type="text" placeholder="Nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) { echo $_POST["nombre"]; } ?>" required>
                </div>
                <p class="mensaje-input"></p>
            </div>
            <div class="auth-input-group">
                <label for="input-email">Email</label>
                <div>
                    <?php include PUBLIC_ROOT . "assets/iconos/mail.svg"; ?>
                    <input id="input-email" type="text" placeholder="email@gmail.com" name="email" value="<?php if (isset($_POST["email"])) { echo $_POST["email"]; } ?>" required>
                </div>
                <?php if (!empty($resultado["emailError"])): ?>
                    <p id="mensaje-error-email" class="mensaje-input"><?= $resultado["emailError"] ?></p>
                <?php endif; ?>
            </div>
            <div class="auth-input-group">
                <label for="input-contrasena">Contraseña</label>
                <div>
                    <?php include PUBLIC_ROOT . "assets/iconos/lock.svg"; ?>
                    <input id="input-contrasena" type="password" placeholder="Contrasena" name="contrasena" value="<?php if (isset($_POST["contrasena"])) { echo $_POST["contrasena"]; } ?>" required>
                    <button id="boton-toggle-contrasena" class="boton-toggle-contrasena" type="button" onClick="toggleContrasena(this, 'input-contrasena')">
                        <svg class="activo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                    </button>
                </div>
                <?php if (!empty($resultado["contrasenaError"])): ?>
                    <p id="mensaje-error-contrasena" class="mensaje-input"><?= $resultado["contrasenaError"] ?></p>
                <?php endif; ?>
            </div>
            <div class="auth-input-group">
                <label for="input-confirmar-contrasena">Confirmar contraseña</label>
                <div>
                    <?php include PUBLIC_ROOT . "assets/iconos/lock.svg"; ?>
                    <input id="input-confirmar-contrasena" type="password" placeholder="Confirmar contrasena" name="confirmarContrasena" value="<?php if (isset($_POST["confirmarContrasena"])) { echo $_POST["confirmarContrasena"]; } ?>" required>
                    <button id="boton-toggle-confirmar-contrasena" class="boton-toggle-contrasena" type="button" onClick="toggleContrasena(this, 'input-confirmar-contrasena')">
                        <svg class="activo" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                    </button>
                </div>
                <?php if (!empty($resultado["confirmarContrasenaError"])): ?>
                    <p id="mensaje-error-confirmar-contrasena" class="mensaje-input"><?= $resultado["confirmarContrasenaError"] ?></p>
                <?php endif; ?>
            </div>
            <button class="boton boton--primario boton--bloque" type="submit">Crear cuenta</button>
            <?php if (!empty($resultado["mensaje"])): ?>
                <p id="mensaje-error-general" class="mensaje-input"><?= $resultado["mensaje"] ?></p>
            <?php endif; ?>
        </form>
        <div class="separador-login">
            <small>O</small>
        </div>
        <div class="contenedor-otras-opciones">
            <button class="boton boton--secundario boton--bloque">
                <div class="gsi-material-button-icon">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" class="svg-block">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </svg>
                </div>
                Continuar con Google
            </button>
            <button class="boton boton--negro boton--bloque">
                <img src="/assets/iconos/github-mark-white.svg" alt="Icono Github" class="icono-github">
                Continuar con Github
            </button>
        </div>
    </div>
    <script>
        function toggleContrasena(boton, targetId) {
            const targetInput = document.getElementById(targetId);
            if (targetInput.type === "password") {
                boton.children[1].classList.add("activo");
                boton.children[0].classList.remove("activo");
                targetInput.type = "text";
            } else {
                boton.children[0].classList.add("activo");
                boton.children[1].classList.remove("activo");
                targetInput.type = "password";
            }
        }
    </script>
</body>
</html>
