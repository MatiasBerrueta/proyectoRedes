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
    <link rel="stylesheet" href="/css/componentes.css">
    <link rel="stylesheet" href="/css/paginas/VistaPerfil.css">
    <script src="/js/controladorTemas.js" defer></script>
    <title>Perfil</title>
</head>
<body>
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main class="perfil-container">
        <div class="perfil-cabecera">
            <h1>Mi cuenta</h1>
        </div>

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

        <!-- Información de cuenta -->
        <section class="perfil-seccion">
            <div class="perfil-seccion__header">
                <h2 class="perfil-seccion__titulo">Información de cuenta</h2>
                <p class="descripcion">Estos datos serán visibles para el resto de usuarios.</p>
            </div>

            <div class="perfil-bloques">
                <div class="perfil-bloque perfil-bloque--columna">
                    <div class="perfil-identidad">
                        <p class="perfil-identidad__nombre">
                            <?= htmlspecialchars($usuario['nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <p class="perfil-identidad__miembro">
                            Miembro desde <span>enero de 2025</span>
                        </p>
                    </div>
                    <form action="/perfil" method="POST" class="perfil-form">
                        <div class="perfil-campo">
                            <label for="input-nombre" class="perfil-campo__label">Nombre</label>
                            <input
                                id="input-nombre"
                                type="text"
                                name="nombre"
                                placeholder="Nombre"
                                value="<?= htmlspecialchars($usuario['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                required
                            >
                        </div>
                        <div class="perfil-campo">
                            <label for="input-email" class="perfil-campo__label">Correo electrónico</label>
                            <div class="perfil-campo__deshabilitado">
                                <input
                                    id="input-email"
                                    type="email"
                                    aria-describedby="email-nota"
                                    value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    disabled
                                >
                                <input
                                    type="hidden"
                                    name="email"
                                    value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                >
                                <?php include PUBLIC_ROOT . "/assets/iconos/lock.svg" ?>
                            </div>
                            <p id="email-nota" class="perfil-campo__nota">
                                Es el correo con el que iniciás sesión y no se puede cambiar.
                            </p>
                        </div>
                        <div class="perfil-campo">
                            <label for="input-pais" class="perfil-campo__label">País</label>
                            <input
                                id="input-pais"
                                type="text"
                                name="pais"
                                placeholder="País"
                                value="<?= htmlspecialchars($usuario['pais'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            >
                        </div>
                        <div class="perfil-form__acciones">
                            <button type="reset" class="perfil-boton perfil-boton--secundario">
                                Descartar cambios
                            </button>
                            <button type="submit" class="perfil-boton">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Seguridad -->
        <section class="perfil-seccion">
            <div class="perfil-seccion__header">
                <h2 class="perfil-seccion__titulo">Seguridad</h2>
                <p class="descripcion">Protegé el acceso a tus servidores</p>
            </div>

            <div class="perfil-bloques">
                <div class="perfil-bloque">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Contraseña</h3>
                        <p class="descripcion">Cambia tu contraseña periódicamente para mantener tu cuenta segura.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <button type="button" class="boton boton--secundario">
                            Cambiar contraseña
                        </button>
                    </div>
                </div>

                <div class="perfil-bloque">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Verificación en dos pasos</h3>
                        <p class="descripcion">Agrega una capa adicional de seguridad a tu cuenta.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <label class="switch">
                            <input type="checkbox" name="verificacion-dos-pasos">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <!-- Preferencias -->
        <section class="perfil-seccion">
            <div class="perfil-seccion__header">
                <h2 class="perfil-seccion__titulo">Preferencias</h2>
                <p class="descripcion">Personaliza a tu gusto cómo querés ver el panel.</p>
            </div>

            <div class="perfil-bloques">
                <div class="perfil-bloque">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Tema</h3>
                        <p class="descripcion">Elige cómo se ve la interfaz.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <select class="perfil-select" aria-label="Tema">
                            <option value="claro">Claro</option>
                            <option value="oscuro">Oscuro</option>
                            <option value="sistema">Sistema</option>
                        </select>
                    </div>
                </div>

                <div class="perfil-bloque">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Idioma</h3>
                        <p class="descripcion">Selecciona el idioma de la interfaz.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <select class="perfil-select" aria-label="Idioma">
                            <option value="es">Español</option>
                            <option value="en">English</option>
                            <option value="pt">Português</option>
                        </select>
                    </div>
                </div>

                <div class="perfil-bloque">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Zona horaria</h3>
                        <p class="descripcion">Define la zona horaria para fechas y horarios.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <select class="perfil-select" aria-label="Zona horaria">
                            <option value="UTC-3">(UTC-03:00) Buenos Aires</option>
                            <option value="UTC-5">(UTC-05:00) Bogotá</option>
                            <option value="UTC-6">(UTC-06:00) Ciudad de México</option>
                            <option value="UTC+0">(UTC+00:00) Londres</option>
                            <option value="UTC+1">(UTC+01:00) Madrid</option>
                        </select>
                    </div>
                </div>

                <div class="perfil-bloque">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Notificaciones</h3>
                        <p class="descripcion">Recibe avisos sobre la actividad de tus servidores.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <label class="switch">
                            <input type="checkbox" name="notificaciones" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <!-- Zona de peligro -->
        <section class="perfil-seccion">
            <div class="perfil-seccion__header">
                <h2 class="perfil-seccion__titulo perfil-seccion__titulo--peligro">Zona de peligro</h2>
                <p class="descripcion">Acciones que no se pueden deshacer.</p>
            </div>

            <div class="perfil-bloques">
                <div class="perfil-bloque perfil-bloque--peligro">
                    <div class="perfil-bloque__texto">
                        <h3 class="perfil-bloque__titulo">Eliminar cuenta</h3>
                        <p class="descripcion">Tu cuenta sera deshabilitada por 15 dias, luego se borran tus servidores, mundos, backups e historial. Si tenés una suscripción activa, se cancela.</p>
                    </div>
                    <div class="perfil-bloque__control">
                        <button type="button" class="boton boton--peligro">
                            Eliminar cuenta
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
