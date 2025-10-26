<?php
use Bramus\Router\Router;

$router = new router();

// esto hace que cualquiera que entre a una ruta de usuario sin tener
// una sesion iniciada se le rediriga a /login
$router->before('GET|POST', '/usuario/.*', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
        exit();
    }
});

$router->get('/', function() {
    require_once 'vistas/vistaPaginaPrincipal.php';
});

$router->get('/login', function() {
    require_once 'vistas/vistaIniciarSesion.php';
});

$router->post('/login', function() {
    require_once 'controladores/controladorAutenticar.php';

    $controlador = new controladorAutenticar();
    $controlador->iniciarSesion($_POST['email'], $_POST['contrasena']);
    unset($_POST);
});

$router->get('/registrarCliente', function() {
    require_once 'vistas/vistaRegistrarUsuario.php';
});

$router->post('/registrarCliente', function() {
    require_once 'controladores/controladorAutenticar.php';

    $controlador = new controladorAutenticar();
    $controlador->registrarUsuario($_POST['nombre'], $_POST['email'], $_POST['contrasena'], $_POST['confirmarContrasena'], 'CLIENTE');
});

$router->get('/usuario/perfil', function() {
    require_once 'vistas/vistaUsuario.php';
});

$router->get('/admin/perfil', function() {
    require_once 'vistas/vistaAdministrador.php';
});

$router->get('/logout', function() {
    require_once 'controladores/controladorAutenticar.php';
    
    $controladorAutenticar = new controladorAutenticar();
    $controladorAutenticar->cerrarSesion();
});

$router->set404(function() {
    http_response_code(404);
    echo "Error 404 - Página no encontrada";
});

$router->run();