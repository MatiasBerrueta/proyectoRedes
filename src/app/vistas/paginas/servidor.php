<?php
$tabs = $tabs ?? [];
$tabActual = $tabActual ?? null;
$servidorId = $servidor['identifier'] ?? null;
?>

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
    <link rel="stylesheet" href="/css/componentes.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/paginas/servidor/servidor.css">
    <script src="https://cdn.jsdelivr.net/npm/ansi_up@5.0.0/ansi_up.min.js"></script>
    <script src="/js/controladorTemas.js" defer></script>
    <script> const SERVER_ID = "<?= $servidorId ?>"; </script>
    <script src="/js/servidorWebsocket.js" defer></script>
    <title>Usuario</title>
</head>
<body class="layout-panel">
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <aside id="sidemenu">
            <nav>
                <ul>
                    <?php forEach($tabs as $tab): ?>
                        <li class="<?= $tabActual === $tab['id'] ? 'activo' : '' ?>">
                            <a href="/panel/servidor/<?= $servidorId ?>/<?= $tab['id'] ?>">
                                <?php include PUBLIC_ROOT . 'assets/iconos/' . $tab['id'] . '.svg' ?> <?= $tab['label'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>
        <section class="tab-contenido">
            <a href="/panel">
                <?php include PUBLIC_ROOT . '/assets/iconos/arrow-narrow-left.svg'; ?>
                Volver a lista servidores
            </a>
            <?php require_once APP_ROOT . "vistas/secciones/$tabActual.php"; ?>
        </section>
    </main>
</body>
</html>