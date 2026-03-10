<header>
    <nav>
        <a href="/">
            <img class="logo" src="/assets/logo.svg" alt="Logo voxel hosting">
            <h1 class="nombre-logo">Voxel Hosting</h1>
        </a>
        <div class="botones-navegacion">
            <a href="/juegos">Planes</a>
            <a href="/juegos">Juegos</a>
            <a href="/soporte">Soporte</a>
        </div>
        <div class="botones-cuentas">
            <?php if (isset($_SESSION['usuario'])): ?>
                <a class="boton-panel" href="/panel/servidores">
                    <img src="/assets/layout-dashboard.svg" alt="Icono panel">    
                    Panel
                </a>
                <div class="menu-usuario">
                    <button id="boton-menu-usuario" class="boton-menu-usuario" aria-expanded="false">
                        <img src="/assets/user(1).svg" alt="Icono usuario">
                        <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                    </button>
                    <div id="menu-dropdown" class="menu-dropdown" hidden>
                        <a href="/usuario/perfil">
                            <img src="/assets/adjustments-horizontal.svg" alt="">
                            Ver perfil
                        </a>
                        <button id="boton-cambiar-tema">
                            <img src="/assets/brush.svg" alt="">
                            Cambiar tema
                        </button>
                        <div class="separador"></div>
                        <a href="/logout">
                            <img src="/assets/logout-2.svg" alt="">
                            Cerrar sesion
                        </a>    
                    </div>
                </div>
            <?php else: ?>
                <a href="/registrarCliente">Crear cuenta</a>
                <a href="/login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>