<header>
    <nav>
        <a class="contenedor-logo" href="/">
            <?php include PUBLIC_ROOT . 'assets/iconos/logo.svg' ?>
            <h1 class="nombre-logo">Voxel Hosting</h1>
        </a>
        <div class="botones-navegacion">
            <a class="chip" href="/planes">Planes</a>
            <a class="chip" href="/juegos">Juegos</a>
            <a class="chip" href="/soporte">Soporte</a>
        </div>
        <div class="botones-cuentas">
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if(htmlspecialchars($_SESSION['usuario']['rol']) === 'ADMIN'): ?>
                    <a class="chip chip--violeta" href="/admin">
                        <?php include PUBLIC_ROOT . 'assets/iconos/shield.svg' ?>
                        Admin
                    </a>
                <?php endif; ?>
                <a class="chip chip--azul" href="/servidores">
                    <?php include PUBLIC_ROOT . 'assets/iconos/panel.svg' ?>
                    Mis Servidores
                </a>
                <div class="menu-usuario">
                    <button id="boton-menu-usuario" class="chip chip--neutro" aria-expanded="false">
                        <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                        <?php include PUBLIC_ROOT . 'assets/iconos/chevron-down.svg' ?>
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
                <a class="chip chip--azul chip--solido" href="/registro">Crear cuenta</a>
                <a href="/login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
