<?php
use Bramus\Router\Router;

$router = new router();

// esto hace que cualquiera que entre a una ruta de usuario sin tener
// una sesion iniciada se le rediriga a /login
$router->before('GET|POST', '/usuario/.*', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
    }
});

$router->get('/', function() {
    require_once APP_ROOT . 'controladores/controladorPlan.php';
    require_once APP_ROOT . 'vistas/vistaPaginaPrincipal.php';
});

$router->get('/login', function() {
    require_once APP_ROOT . 'vistas/vistaIniciarSesion.php';
});

$router->post('/login', function() {
    require_once APP_ROOT . 'controladores/controladorAutenticar.php';

    $controlador = new controladorAutenticar();
    $resultado = $controlador->iniciarSesion($_POST['email'], $_POST['contrasena']);

    if ($resultado['ok']) {
        if ($resultado['rol'] === 'ADMIN') {
            header("Location: /admin/panel");
            exit;
        } else {
            header("Location: /usuario/panel");
            exit;
        }
    } else {
        require APP_ROOT . "vistas/vistaIniciarSesion.php";
    }

    unset($_POST);
});

$router->get('/registrarCliente', function() {
    require_once APP_ROOT . 'vistas/vistaRegistrarUsuario.php';
});

$router->post('/registrarCliente', function() {
    require_once APP_ROOT . 'controladores/controladorAutenticar.php';

    $controlador = new controladorAutenticar();
    $resultado = $controlador->registrarUsuario($_POST['nombre'], $_POST['email'], $_POST['contrasena'], $_POST['confirmarContrasena'], 'CLIENTE');

    if($resultado['ok']) {
        if ($resultado['rol'] === 'ADMIN') {
            header("Location: /admin/panel");
            exit;
        } else {
            header("Location: /usuario/panel");
            exit;
        }
    } else {
        require_once APP_ROOT . 'vistas/vistaRegistrarUsuario.php';
    }

    exit;
});

$router->get('/usuario/panel', function() {
    require_once APP_ROOT . 'controladores/controladorServidor.php';
    require_once APP_ROOT . 'vistas/vistaUsuario.php';
});

$router->get('/admin/panel', function() {
    require_once APP_ROOT . 'vistas/vistaAdministrador.php';
});

$router->get('/recuperarContrasena', function() {
    require_once APP_ROOT . 'vistas/recuperarContrasena.php';
});

$router->get('/logout', function() {
    require_once APP_ROOT . 'controladores/controladorAutenticar.php';
    
    $controladorAutenticar = new controladorAutenticar();
    $controladorAutenticar->cerrarSesion();
    header('Location: /login');
});

$router->set404(function() {
    http_response_code(404);
    require_once APP_ROOT . 'vistas/404.php';
});

$router->delete('/testing/borrarUsuario/(.+)', function ($email) {
    modeloUsuario::eliminarUsuarioEmail($email);
});

$router->run();