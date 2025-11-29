<header>
    <div class="contenedor">
        <nav>
            <a href="/">
                <img src="/assets/logo.svg" alt="Logo voxel hosting">
            </a>
            <div class="botones-navegacion">
                <a href="/juegos">Planes</a>
                <a href="/juegos">Juegos</a>
                <a href="/soporte">Soporte</a>
            </div>
            <div class="botones-cuentas">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- <img src="/assets/icono-usuario.png" alt="Usuario"> -->
                    <a class="boton-panel" href="/usuario/panel">Panel</a>
                    <div class="menu-usuario">
                        <button id="boton-menu-usuario" class="boton-menu-usuario" aria-expanded="false">
                            <img src="/assets/iconoUsuario.svg" alt="">
                            <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                        </button>
                        <div id="menu-dropdown" class="menu-dropdown" hidden>
                            <a href="/usuario/perfil">Ver perfil</a>
                            <button id="boton-cambiar-tema">Cambiar tema</button>
                            <a href="/logout">Cerrar sesion</a>    
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login">Iniciar sesión</a>
                    <a href="/registrarCliente">Crear cuenta</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>