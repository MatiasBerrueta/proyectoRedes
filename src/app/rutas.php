<?php
use Bramus\Router\Router;

require_once APP_ROOT . 'Database.php';
require_once APP_ROOT . 'integraciones/pterodactylAppApi.php';
require_once APP_ROOT . 'integraciones/pterodactylClientApi.php';

require_once APP_ROOT . 'repositorios/RepositorioUsuario.php';
require_once APP_ROOT . 'repositorios/RepositorioServidor.php';
require_once APP_ROOT . 'repositorios/RepositorioPlan.php';

require_once APP_ROOT . 'servicios/ServicioUsuario.php';
require_once APP_ROOT . 'servicios/ServicioServidor.php';
require_once APP_ROOT . 'servicios/ServicioJuego.php';

require_once APP_ROOT . 'controladores/ControladorPagina.php';
require_once APP_ROOT . 'controladores/ControladorUsuario.php';
require_once APP_ROOT . 'controladores/ControladorServidor.php';

$router = new router();

$database = new Database();
$pterodactylApp = new pterodactylAppApi();
$pterodactylCliente = new pterodactylClientApi();

require_once APP_ROOT . 'comandos/comandos.php';
$comandos = new SincronizarJuegos($pterodactylApp, $database->getConexion());
// $comandos->sincronizarJuegos(); 

$repositorioUsuario = new RepositorioUsuario($database->getConexion());
$repositorioServidor = new RepositorioServidor($database->getConexion());
$repositorioPlan = new RepositorioPlan($database->getConexion());

$servicioUsuario = new ServicioUsuario($repositorioUsuario, $pterodactylApp);
$servicioServidor = new ServicioServidor($pterodactylCliente, $repositorioServidor, $repositorioUsuario);
$servicioJuego = new ServicioJuego($repositorioUsuario, $pterodactylCliente);

$controladorPagina = new ControladorPagina($repositorioPlan);
$controladorUsuario = new ControladorUsuario($servicioUsuario);
$controladorServidor = new ControladorServidor($servicioServidor, $servicioJuego);

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

$router->get('/', function() use ($controladorPagina) {
    $controladorPagina->mostrarPrincipal();
});

$router->get('/login', function() use ($controladorUsuario) {
    $controladorUsuario->mostrarLogin();
});

$router->post('/login', function() use ($controladorUsuario)  {
    $controladorUsuario->iniciarSesion();
});

$router->get('/registroUsuario', function() use ($controladorUsuario)  {
    $controladorUsuario->mostrarRegristro();
});

$router->post('/registroUsuario', function() use ($controladorUsuario)  {
    $controladorUsuario->registrarUsuario();
});

$router->get('/panel', function() use ($controladorServidor)  {
    $controladorServidor->mostrarPanel();
});

$router->get('/panel/servidor/([a-zA-Z0-9]+)', function($idServidor) use ($controladorServidor) {
    $controladorServidor->mostrarServidor($idServidor);
});

$router->get('/panel/servidor/([a-zA-Z0-9]+)/([a-zA-Z]+)', function($idServidor, $tab) use ($controladorServidor) {
    $controladorServidor->mostrarServidor($idServidor, $tab);
});

$router->get('/recuperarContrasena', function() {
    // require_once APP_ROOT . 'vistas/paginas/recuperarContrasena.php';
});

$router->get('/logout', function() use ($controladorUsuario)  {
    $controladorUsuario->cerrarSesion();
});


$router->set404(function() {
    http_response_code(404);
    require_once APP_ROOT . 'vistas/paginas/404.php';
});

// $router->delete('/testing/borrarUsuario/(.+)', function($email) {
//     RepositorioUsuario::eliminarUsuarioEmail($email);
// });

$router->post('/api/websocket', function() use ($repositorioUsuario, $pterodactylCliente) {
    $idServidor = $_POST['servidor_id'];
    $clientKey = $repositorioUsuario->obtenerClientKey($_SESSION['usuario']['id']);
    $websocket = $pterodactylCliente->obtenerWebSocket($idServidor, $clientKey);

    echo json_encode($websocket);
});

// $router->post('api/datosServidor', function() {
//     if (!isset($_SESSION['usuario'])) {
//         http_response_code(401);
//         echo json_encode(["error" => "No autenticado"]);
//         exit;
//     }

//     $idServidor = $_POST['servidor_id'];    
//     require_once APP_ROOT . 'modelos/api/pterodactylClientApi.php';
//     require_once APP_ROOT . 'modelos/modeloUsuario.php';

//     // $usuarioActual = modeloUsuario::obtenerUsuarioPorEmail($_SESSION['usuario']['email']);

//     $api = new pterodactylClientApi($usuarioActual['client_key']);
//     echo json_encode($api->obtenerServidorPorId($idServidor));
// });

// No hagas require a la vista, hacelo al controlador y llama la funcion mostrarPerfil()
// Mira como esta hecho para /login mas arriba en este archivo
$router->get('/perfil', function() {
    require_once APP_ROOT . 'vistas/paginas/vistaPerfil.php';
});

// Hace require al controlador y llama la funcion actualizarPerfil()
// Mira como esta hecho para /login mas arriba en este archivo
$router->post('/perfil', function() {
    echo "aca va la logica";
});


$router->post('/api/servidor/{([a-zA-Z0-9]+)}/accion/{([a-zA-Z0-9]+)}', function($idServidor, $accion) use ($controladorServidor) {
    $controladorServidor->ejecutarAccion($idServidor, $accion);
});

$router->run();