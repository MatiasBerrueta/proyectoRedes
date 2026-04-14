<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Perfil</title>
    <!-- Esto va en un archivo aparte vistaPerfil.css -->
    <!-- Hace un link a css/vistaPerfil.css -->
    <!-- Todos los colores que uses tienen que ser variables desde main.css -->
    <style>
    body {
        margin: 0;
        font-family: Arial;
        background: #f5f5f5;
    }

    .container {
        width: 320px;
        margin: 80px auto;
        text-align: center;
    }

    .logo {
        width: 80px;
        height: 80px;
        background: var(--azul-logo);
        border-radius: 15px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 30px;
        margin-bottom: 20px;
    }

    .input-group {
        position: relative;
        margin-bottom: 12px;
    }

    .input-group input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border-radius: 8px;
        border: none;
        background: #eee;
    }

    .input-group span {
        position: absolute;
        left: 10px;
        top: 12px;
        color: gray;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #2563eb;
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background: #1d4ed8;
    }

    .mensaje {
        color: green;
        margin-bottom: 10px;
    }

    .error {
        color: red;
        margin-bottom: 10px;
    }
    </style>
    <!---->
</head>
<body>
    <div class="container">
        <div class="logo">VH</div>
        <!-- No usar GET para errores -->
        <!-- Mira vista inicioSesion.php para comparar -->
        <?php if(isset($_GET['ok'])): ?>
            <div class="mensaje">Datos actualizados correctamente</div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="error">Completar campos obligatorios</div>
        <?php endif; ?>
        <form action="/perfil" method="POST">
            <!-- Importa iconos desde assets/iconos -->
            <div class="input-group">
                <span>👤</span>
                <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
            </div>
            <div class="input-group">
                <span>@</span>
                <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            </div>
            <div class="input-group">
                <span>🌍</span>
                <input type="text" name="pais" value="<?php echo $usuario['pais']; ?>">
            </div>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
