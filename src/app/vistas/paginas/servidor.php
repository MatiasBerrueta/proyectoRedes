<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href="/css/panelUsuario.css">
    <link rel="stylesheet" href="/css/servidor-contenido.css">
    <script src="https://cdn.jsdelivr.net/npm/ansi_up@5.0.0/ansi_up.min.js"></script>
    <script src="/js/controladorTemas.js" defer></script>
    <script> const SERVER_ID = "<?= $servidor['identifier'] ?>"; </script>
    <script src="/js/servidorWebsocket.js" defer></script>
    <title>Usuario</title>
</head>
<body>
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <aside id="sidemenu">
            <nav>
                <ul>
                    <?php forEach($tabs as $tab): ?>
                        <li class="<?= $tabActual === $tab['id'] ? 'activo' : '' ?>">
                            <a href="/panel/servidor/<?= $servidor['identifier'] ?>/<?= $tab['id'] ?>">
                                <?php include PUBLIC_ROOT . 'assets/iconos/' . $tab['id'] . '.svg' ?> <?= $tab['label'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>
        <section class="seccion-servidores">
            <a href="/panel">
                <?php include PUBLIC_ROOT . '/assets/iconos/arrow-narrow-left.svg'; ?>
                Volver a lista servidores
            </a>
            <?php require_once APP_ROOT . "vistas/secciones/$tabActual.php"; ?>
        </section>
    </main>
</body>
</html>