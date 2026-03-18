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

$router->before('GET|POST', '/panel/.*', function() {
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
        header("Location: /panel/servidores");
        // if ($resultado['rol'] === 'ADMIN') {
        //     header("Location: /admin/panel");
        //     exit;
        // } else {
        //     header("Location: /usuario/panel");
        //     exit;
        // }
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
        header("Location: /panel/servidores");
        // if ($resultado['rol'] === 'ADMIN') {
        //     header("Location: /admin/panel");
        //     exit;
        // } else {
        //     header("Location: /usuario/panel");
        //     exit;
        // }
    } else {
        require_once APP_ROOT . 'vistas/vistaRegistrarUsuario.php';
    }

    exit;
});

$router->get('/panel/servidores', function() {
    require_once APP_ROOT . 'controladores/controladorServidor.php';
    require_once APP_ROOT . 'vistas/vistaUsuario.php';
});

$router->get('/panel/servidores/([a-zA-Z0-9]+)', function($idServidor) {
    $tab = 'consola';
    require_once APP_ROOT . 'controladores/controladorServidor.php';
    require_once APP_ROOT . 'vistas/vistaServidor.php';
});

$router->get('/panel/servidores/([a-zA-Z0-9]+)/([a-zA-Z]+)', function($idServidor, $tab) {
    require_once APP_ROOT . 'controladores/controladorServidor.php';
    require_once APP_ROOT . 'vistas/vistaServidor.php';
});

// $router->get('/panel/servidores/([a-zA-Z0-9]+)/([a-zA-Z]+)', function($idServidor, $tab) {
//     require_once APP_ROOT . "vistas/componentes/$tab.php";
// });

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

$router->delete('/testing/borrarUsuario/(.+)', function($email) {
    modeloUsuario::eliminarUsuarioEmail($email);
});

$router->post('/api/websocket', function() {
    if (!isset($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(["error" => "No autenticado"]);
        exit;
    }

    $idServidor = $_POST['servidor_id'];
    require_once APP_ROOT . 'modelos/api/pterodactylClientApi.php';

    // $clienteApiKey = 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I';
    $clienteApiKey = 'ptlc_d8128a5e9b400e73b9afdcd977f602040f2cb0982bc22294c0efffa8bd95fe5d217ed57dd61b812c';
    $api = new pterodactylClientApi($clienteApiKey);
    echo json_encode($api->obtenerWebSocket($idServidor));
});

$router->post('api/datosServidor', function() {
    if (!isset($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(["error" => "No autenticado"]);
        exit;
    }

    $idServidor = $_POST['servidor_id'];    
    require_once APP_ROOT . 'modelos/api/pterodactylClientApi.php';

    // $clienteApiKey = 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I';
    $clienteApiKey = 'ptlc_d8128a5e9b400e73b9afdcd977f602040f2cb0982bc22294c0efffa8bd95fe5d217ed57dd61b812c';
    $api = new pterodactylClientApi($clienteApiKey);
    echo json_encode($api->obtenerServidorPorId($idServidor));
});

$router->get('/usuario/perfil', function() {
    echo "este es el perfil";
});

$router->run();