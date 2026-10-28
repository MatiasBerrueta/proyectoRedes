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
                  <button popovertarget="menu-dropdown" id="boton-menu-usuario" class="chip chip--neutro" aria-expanded="false">
                      <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                      <?php include PUBLIC_ROOT . 'assets/iconos/chevron-down.svg' ?>
                  </button>
                  <div popover id="menu-dropdown" class="menu-dropdown">
                      <div class="menu-dropdown__usuario-info">
                        <span>
                          <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                        </span>
                        <span class="usuario-email">
                          <?= htmlspecialchars($_SESSION['usuario']['email']) ?>
                        </span>
                      </div>
                      <div class="separador"></div>
                      <div class="menu-dropdown__botones">
                        <a class="chip" href="/cuenta/perfil">
                            <?php include PUBLIC_ROOT . 'assets/iconos/configuracion.svg' ?>
                            Perfil
                        </a>
                        <a class="chip" href="/cuenta/facturacion">
                            <?php include PUBLIC_ROOT . 'assets/iconos/credit-card.svg' ?>
                            Facturacion
                        </a>
                        <a class="chip" href="/cuenta/tickets">
                            <?php include PUBLIC_ROOT . 'assets/iconos/ticket.svg' ?>
                            Tickets
                        </a>
                        <button class="chip" id="boton-cambiar-tema">
                            <?php include PUBLIC_ROOT . 'assets/iconos/sun.svg' ?>
                            Tema
                        </button>
                      </div>
                      <div class="separador"></div>
                      <a class="chip chip--rojo" href="/logout">
                          <?php include PUBLIC_ROOT . 'assets/iconos/logout.svg' ?>
                          Cerrar sesion
                      </a>
                  </div>
            <?php else: ?>
                <a class="chip chip--azul chip--solido" href="/registro">Crear cuenta</a>
                <a class="chip" href="/login">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
