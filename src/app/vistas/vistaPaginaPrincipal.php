<?php  
require_once APP_ROOT . 'controladores/controladorPlan.php';

$controladorPlan = new controladorPlan();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paginaPrincipal.css">
    <title>Pagina principal - Voxel Hosting</title>
</head>
<body>
    <header>
        <nav>
            <img src="assets/logo.svg" alt="Logo voxel hosting">
            <div class="botones-navegacion">
                <a href="/juegos">Planes</a>
                <a href="/juegos">Juegos</a>
                <a href="/soporte">Soporte</a>
            </div>
            <div class="botones-cuentas">
                <a href="/login">Inciar Sesion</a>
                <a href="/registrarCliente">Crear cuenta</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="seccion-presentacion">
            <h1>Crea tu servidor en minutos
            <br>juega sin limites.</h1>
            <p>Tú eliges el juego y el tamaño de tu comunidad, nosotros nos ocupamos de la configuración,
            <br>el rendimiento y el soporte para que disfrutes sin complicaciones.</p>
            <button>Empezar ahora</button>
        </section>
        <section class="seccion-planes">
            <div class="presentacion-planes">
                <h2>Conoce nuestros planes</h2>
                <p>Nuestros planes estan pensandos para darte una experiencia de juego fluida y a un bajo precio</p>
            </div>
            <div class="contenedor-planes">
                <?php $planes = $controladorPlan->listarPlanes(); ?>
            </div>
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>