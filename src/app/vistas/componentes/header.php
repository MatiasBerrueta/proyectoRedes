<header>
    <nav>
        <a class="contenedor-logo" href="/">
            <?php include PUBLIC_ROOT . 'assets/iconos/logo.svg' ?>
            <h1 class="nombre-logo">Voxel Hosting</h1>
        </a>
        <div class="botones-navegacion">
            <a href="/planes">Planes</a>
            <a href="/juegos">Juegos</a>
            <a href="/soporte">Soporte</a>
        </div>
        <div class="botones-cuentas">
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if(htmlspecialchars($_SESSION['usuario']['rol']) === 'ADMIN'): ?>
                    <a class="boton-panel" href="/admin">
                        <?php include PUBLIC_ROOT . 'assets/iconos/panel.svg' ?>
                        Admin
                    </a>
                <?php endif; ?>
                <a class="boton-panel" href="/servidores">
                    <?php include PUBLIC_ROOT . 'assets/iconos/panel.svg' ?>   
                    Mis Servidores
                </a>
                <div class="menu-usuario">
                    <button id="boton-menu-usuario" class="boton-menu-usuario" aria-expanded="false">
                        <?php include PUBLIC_ROOT . 'assets/iconos/user.svg' ?>   
                        <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                    </button>
                    <div id="menu-dropdown" class="menu-dropdown" hidden>
                        <a href="/cuenta">
                            <?php include PUBLIC_ROOT . 'assets/iconos/configuracion.svg' ?>   
                            Mi cuenta
                        </a>
                        <button id="boton-cambiar-tema">
                            <?php include PUBLIC_ROOT . 'assets/iconos/sun.svg' ?>   
                            Tema
                        </button>
                        <div class="separador"></div>
                        <a href="/logout">
                            <?php include PUBLIC_ROOT . 'assets/iconos/logout.svg' ?>   
                            Cerrar sesion
                        </a>    
                    </div>
                </div>
            <?php else: ?>
                <a href="/registro">Crear cuenta</a>
                <a href="/login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>