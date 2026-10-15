<?php
// $usuario = $usuario ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    (function() {
        const temaGuardado = localStorage.getItem('tema');
        if (temaGuardado === 'oscuro') document.documentElement.classList.add('tema-oscuro');
    })();
    </script>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/paginas/VistaPerfil.css">
    <script src="/js/controladorTemas.js" defer></script>
    <title>Perfil</title>
</head>

<body>

    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main class="perfil-container">
        <section class="perfil-card">
            <h1>Mi perfil</h1>

            <?php if (!empty($mensaje)): ?>
                <div class="perfil-mensaje">
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="perfil-error">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form action="/perfil" method="POST" class="perfil-form">    
                <div class="perfil-input-group">
                    <?php include PUBLIC_ROOT . "/assets/iconos/user.svg" ?>
                    <input
                        type="text"
                        name="nombre"
                        placeholder="Nombre"
                        value="<?= htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="perfil-input-group">
                    <?php include PUBLIC_ROOT . "/assets/iconos/mail.svg" ?>
                    <input
                        type="email"
                        name="email"
                        placeholder="Correo electrónico"
                        value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required
                    >
                </div>

                <div class="perfil-input-group">
                    <?php include PUBLIC_ROOT . "/assets/iconos/mundos.svg" ?>
                    <input
                        type="text"
                        name="pais"
                        placeholder="País"
                        value="<?= htmlspecialchars($usuario['pais'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    >
                </div>

                <button type="submit" class="perfil-boton">
                    Guardar cambios
                </button>

            </form>

        </section>

    </main>

</body>
</html>
