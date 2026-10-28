<?php
/** @var string $tabActual */
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
    <link rel="stylesheet" href="/css/paginas/cuenta.css">
    <script src="/js/controladorTemas.js" defer></script>
    <title>Perfil</title>
</head>
<body>
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main class="perfil-container">
        <div class="perfil-cabecera">
            <h1>Mi cuenta</h1>
        </div>
        <section>
          <nav class="perfil-nav">
            <ul>
              <li>
                <a class="<?= $tabActual === 'perfil' ? 'activo' : '' ?>" href="/cuenta/perfil">
                  <?php include PUBLIC_ROOT . "assets/iconos/user.svg" ?>
                  Perfil
                </a>
              </li>
              <li>
                <a class="<?= $tabActual === 'facturacion' ? 'activo' : '' ?>" href="/cuenta/facturacion">
                  <?php include PUBLIC_ROOT . "assets/iconos/credit-card.svg" ?>
                  Facturacion
                </a>
              </li>
              <li>
                <a class="<?= $tabActual === 'tickets' ? 'activo' : '' ?>" href="/cuenta/tickets">
                  <?php include PUBLIC_ROOT . "assets/iconos/ticket.svg" ?>
                  Mis tickets
                </a>
              </li>
            </ul>
          </nav>
        </section>

        <?php require_once APP_ROOT . 'vistas/paginas/cuenta/tabs/' . $tabActual . '.php'?>
    </main>
    <?php include_once APP_ROOT . 'vistas/componentes/footer.php'; ?>
</body>
</html>
