<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registro.css">
    <script src="js/validacionRegistro.js" defer></script>
    <title>Registro</title>
</head>
<body>
    <div class="form-container">
        <h1>Crear una cuenta</h1>
        <form action="/registrarCliente" method="POST">
            <div>
                <!-- <label for="input-nombre">Nombre</label> -->
                <img src="/assets/iconoUsuario.svg" alt="Icono usuario" class="icon">
                <input id="input-nombre" type="text" placeholder="Nombre" name="nombre" required>
                <p class="mensaje-input"></p>
            </div>
            <div>
                <!-- <label for="input-email">Email</label> -->
                <img src="/assets/iconoEmail.svg" alt="Icono email" class="icon">
                <input id="input-email" type="text" placeholder="Direccion email" name="email" required>
                <?php if(!empty($emailError)): ?>
                    <p class="mensaje-input"><?= $emailError ?> </p>
                <?php endif; ?>
            </div>
            <div>
                <!-- <label for="input-contrasena">Contraseña</label> -->
                <img src="/assets/iconoContrasena.svg" alt="Icono contrasena" class="icon">
                <input id="input-contrasena" type="password" placeholder="Contrasena" name="contrasena" required>
                <button id="boton-toggle-contrasena" class="boton-toggle-contrasena" type="button" onClick="toggleContrasena(this)" data-target="input-contrasena">
                    <img src="/assets/iconoVerContrasena.svg" alt="Icono ver contrasena" class="icon">
                </button>
                <?php if(!empty($contrasenaError)): ?>
                    <p class="mensaje-input"><?= $contrasenaError ?> </p>
                <?php endif; ?>
            </div>
            <div>
                <!-- <label for="input-confirmar-contrasena">Confirmar contraseña</label> -->
                <img src="/assets/iconoContrasena.svg" alt="Icono contrasena" class="icon">
                <input id="input-confirmar-contrasena" type="password" placeholder="Confirmar contrasena" name="confirmarContrasena" required>
                <button id="boton-toggle-confirmar-contrasena" class="boton-toggle-contrasena" type="button" onClick="toggleContrasena(this)" data-target="input-confirmar-contrasena">
                    <img src="/assets/iconoVerContrasena.svg" alt="Icono ver contrasena" class="icon">
                </button>
                <?php if(!empty($confirmarContrasenaError)): ?>
                    <p class="mensaje-input"><?= $confirmarContrasenaError ?> </p>
                <?php endif; ?>
            </div>
            <button class="boton-subir boton-azul" type="submit">Crear cuenta</button>
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
        <small class="mensaje-form">Ya tenes una cuenta? <a href="/login">Iniciar sesion</a></small>
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