<?php
use Bramus\Router\Router;
use Monolog\Logger;

require_once APP_ROOT . 'Database.php';
require_once APP_ROOT . 'integraciones/pterodactylAppApi.php';
require_once APP_ROOT . 'integraciones/pterodactylClientApi.php';

require_once APP_ROOT . 'repositorios/RepositorioUsuario.php';
require_once APP_ROOT . 'repositorios/RepositorioServidor.php';
require_once APP_ROOT . 'repositorios/RepositorioPlan.php';
require_once APP_ROOT . 'repositorios/RepositorioJuego.php';

require_once APP_ROOT . 'servicios/ServicioUsuario.php';
require_once APP_ROOT . 'servicios/ServicioServidor.php';
require_once APP_ROOT . 'servicios/ServicioJuego.php';

require_once APP_ROOT . 'controladores/ControladorPagina.php';
require_once APP_ROOT . 'controladores/ControladorUsuario.php';
require_once APP_ROOT . 'controladores/ControladorServidor.php';
require_once APP_ROOT . 'controladores/ControladorJuego.php';

require_once APP_ROOT . 'modelos/ModeloUsuario.php';

require_once APP_ROOT . 'utils/Formeatear.php';

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
$repositorioJuego = new RepositorioJuego($database->getConexion());

$servicioUsuario = new ServicioUsuario($repositorioUsuario, $pterodactylApp);
$servicioServidor = new ServicioServidor($pterodactylCliente, $repositorioServidor, $repositorioUsuario);
$servicioJuego = new ServicioJuego($repositorioUsuario, $servicioServidor, $pterodactylCliente);

$controladorPagina = new ControladorPagina($repositorioPlan, $repositorioJuego);
$controladorUsuario = new ControladorUsuario($servicioUsuario, $repositorioUsuario);
$controladorServidor = new ControladorServidor($servicioServidor, $servicioJuego);
$controladorJuego = new ControladorJuego($servicioJuego);

// ------------------
// Autenticacion
// ------------------

$router->before('GET|POST', '/servidores/.*', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
    }
});

$router->before('GET|POST', '/cuenta', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
    }
});

$router->before('GET|POST', '/tickets', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
    }
});

$router->before('GET|POST', '/facturas', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
    }
});

$router->before('GET|POST', '/admin/.*', function() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: /login');
        exit;
    }
    if ($_SESSION['usuario']['rol'] !== 'ADMIN') {
        http_response_code(403);
        require_once APP_ROOT . 'vistas/paginas/404.php';
        exit;
    }
});

// ------------------
// General
// ------------------

$router->get('/', function() use ($controladorPagina) {
    $controladorPagina->mostrarPrincipal();
});

$router->get('/login', function() use ($controladorUsuario) {
    $controladorUsuario->mostrarLogin();
});

$router->post('/login', function() use ($controladorUsuario) {
    $controladorUsuario->iniciarSesion();
});

$router->get('/registro', function() use ($controladorUsuario) {
    $controladorUsuario->mostrarRegristro();
});

$router->post('/registro', function() use ($controladorUsuario) {
    $controladorUsuario->registrarUsuario();
});

$router->get('/planes', function() use ($controladorPagina) {
    $controladorPagina->mostrarPlanes();
});

$router->get('/juegos', function() use ($controladorPagina) {
    $controladorPagina->mostrarJuegos();
});

$router->get('/soporte', function() use ($controladorUsuario) {
    require_once APP_ROOT . 'vistas/paginas/soporte.php';
});

$router->get('/recuperar-contrasena', function() {
    require_once APP_ROOT . 'vistas/paginas/recuperarContrasena.php';
});

$router->post('/recuperar-contrasena', function() use ($controladorUsuario) {
    // TODO: enviar email con token y lógica de recuperación
    $controladorUsuario->recuperarContrasena();
});

$router->get('/logout', function() use ($controladorUsuario) {
    $controladorUsuario->cerrarSesion();
});

// ------------------
// Servidores
// ------------------

$router->get('/servidores', function() use ($controladorServidor) {
    $controladorServidor->mostrarPanel();
});

$router->get('/servidores/([a-zA-Z0-9]+)', function($idServidor) use ($controladorServidor) {
    $controladorServidor->mostrarServidor($idServidor);
});

$router->get('/servidores/([a-zA-Z0-9]+)/([a-zA-Z]+)', function($idServidor, $tab) use ($controladorServidor) {
    $controladorServidor->mostrarServidor($idServidor, $tab);
});


// ------------------
// Cuenta usuario
// ------------------

$router->get('/cuenta', function() use ($controladorUsuario) {
    $controladorUsuario->mostrarCuenta('perfil');
});

$router->get('/cuenta/([a-zA-Z]+)', function($tab) use ($controladorUsuario) {
    $controladorUsuario->mostrarCuenta($tab);
});

// Panel de administración
$router->get('/admin', function() {
    // TODO: dashboard con estadísticas del sistema
    echo '<h1>Panel de Administración</h1><p>Próximamente</p>';
});

$router->get('/admin/usuarios', function() {
    // TODO: listar, buscar y gestionar usuarios
    echo '<h1>Usuarios</h1><p>Próximamente</p>';
});

$router->get('/admin/servidores', function() {
    // TODO: listar servidores de todos los usuarios
    echo '<h1>Servidores</h1><p>Próximamente</p>';
});

$router->get('/admin/tickets', function() {
    // TODO: gestionar tickets de soporte (asignar, prioridad, cerrar)
    echo '<h1>Tickets de Soporte</h1><p>Próximamente</p>';
});

$router->get('/admin/planes', function() {
    // TODO: CRUD de planes de hosting
    echo '<h1>Planes</h1><p>Próximamente</p>';
});

$router->get('/admin/config', function() {
    // TODO: configuración global (SMTP, precios, etc.)
    echo '<h1>Configuración</h1><p>Próximamente</p>';
});

// ------------------
// Api
// ------------------

$router->get('/api/servidores/([a-zA-Z0-9]+)/websocket', function($idServidor) use ($controladorJuego) {
    $controladorJuego->obtenerWebSocket($idServidor);
});

$router->post('/api/servidores/([a-zA-Z0-9]+)/subirMod', function($idServidor) use ($controladorServidor) {
    $controladorServidor->subirMod($idServidor);
});

$router->get('api/servidores/([a-zA-Z0-9]+)/archivos', function($idServidor) use ($controladorJuego) {
    $controladorJuego->listarArchivos($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/eliminar', function($idServidor) use ($controladorJuego) {
    $controladorJuego->eliminarArchivos($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/crearDirectorio', function($idServidor) use ($controladorJuego) {
    $controladorJuego->crearDirectorio($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/crearArchivo', function($idServidor) use ($controladorServidor) {
    $controladorServidor->crearArchivo($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/subirArchivo', function($idServidor) use ($controladorServidor) {
    $controladorServidor->subirArchivo($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/moverArchivo', function($idServidor) use ($controladorServidor) {
    $controladorServidor->moverArchivo($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/renombrarArchivo', function($idServidor) use ($controladorServidor) {
    $controladorServidor->renombrarArchivo($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/descargarArchivo', function($idServidor) use ($controladorServidor) {
    $controladorServidor->descargarArchivo($idServidor);
});

$router->post('api/servidores/([a-zA-Z0-9]+)/archivos/guardarArchivo', function($idServidor) use ($controladorServidor) {
    $controladorServidor->guardarArchivo($idServidor);
});

$router->get('/api/servidores/([a-zA-Z0-9]+)/tabs/([a-zA-Z]+)', function($idServidor, $tabNombre) use ($controladorServidor) {
    $controladorServidor->obtenerTabPanel($idServidor, $tabNombre);
});

$router->post('api/perfil', function() use ($controladorUsuario) {
    $controladorUsuario->actualizarPerfil();
});

// ------------------
// Errores
// ------------------

$router->set404(function() {
    http_response_code(404);
    require_once APP_ROOT . 'vistas/paginas/404.php';
});

$router->run();
