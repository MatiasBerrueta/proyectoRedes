<?php
$servidor = $servidor ?? [];
$tabs = $tabs ?? [];
$tabActual = $tabActual ?? null;
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
    <script type="module" src="/js/servidor/cambiarTabs.js"></script>
    <script type="module" src="/js/servidor/servidorWebsocket.js"></script>
    <script src="/js/controladorTemas.js" defer></script>
    <title>Usuario</title>
</head>
<body class="layout-panel">
    <?php include_once APP_ROOT . 'vistas/componentes/header.php'; ?>
    <main>
        <aside id="sidemenu">
            <nav>
                <ul>
                    <?php forEach($tabs as $tab): ?>
                        <li class="<?= $tabActual === $tab['id'] ? 'activo' : '' ?>" data-tab="<?= $tab['id'] ?>">
                            <!-- <a href="/servidores/<?= $servidor['id'] ?>/<?= $tab['id'] ?>"> -->
                                <?php include PUBLIC_ROOT . 'assets/iconos/' . $tab['id'] . '.svg' ?> <?= $tab['label'] ?>
                            <!-- </a> -->
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>
        <section class="tab-contenido">
            <div id="tab-contenido">
                <?php include APP_ROOT . 'vistas/paginas/servidor/tabs/' . $tabActual . '.php'?>
            </div>
        </section>
    </main>
    <script>
        window.estadoInicial = {
            servidor: <?= json_encode($servidor, false) ?>,
            tabActual: "<?= $tabActual ?>"
        };

        let { servidor, tabActual } = window.estadoInicial;
        let moduloTabActivo = tabActual;
    </script>
</body>
</html>