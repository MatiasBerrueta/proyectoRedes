<?php
use Bramus\Router\Router;
use Monolog\Logger;

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
// Redirecciones de rutas antiguas
// ------------------

$router->get('/registroUsuario', function() {
    header('Location: /registro');
});
$router->post('/registroUsuario', function() {
    header('Location: /registro');
});

$router->get('/panel', function() {
    header('Location: /servidores');
});
$router->get('/panel/servidor/([a-zA-Z0-9]+)', function($id) {
    header("Location: /servidores/$id");
});
$router->get('/panel/servidor/([a-zA-Z0-9]+)/([a-zA-Z]+)', function($id, $tab) {
    header("Location: /servidores/$id/$tab");
});

$router->get('/perfil', function() {
    header('Location: /cuenta');
});
$router->post('/perfil', function() {
    header('Location: /cuenta');
});

$router->get('/recuperarContrasena', function() {
    header('Location: /recuperar-contrasena');
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

$router->get('/cuenta', function() {
    // TODO: migrar a ControladorUsuario y usar servicio/repositorio
    require_once APP_ROOT . 'vistas/paginas/vistaPerfil.php';
});

$router->post('/cuenta', function() use ($controladorUsuario) {
    // TODO: implementar actualización de perfil con servicio
    $controladorUsuario->modificarUsuario();
    header('Location: /cuenta');
});

// ------------------
// Tickets soporte sin funcionalidad todavia
// ------------------

// Tickets de soporte
$router->get('/tickets', function() {
    // TODO: mostrar listado de tickets del usuario
    echo '<h1>Mis Tickets</h1><p>Próximamente</p>';
});

$router->get('/tickets/crear', function() {
    // TODO: formulario para crear un nuevo ticket
    echo '<h1>Nuevo Ticket</h1><p>Próximamente</p>';
});

$router->post('/tickets/crear', function() {
    // TODO: guardar nuevo ticket y redirigir
    header('Location: /tickets');
});

$router->get('/tickets/([0-9]+)', function($idTicket) {
    // TODO: mostrar detalle del ticket con sus mensajes
    echo "<h1>Ticket #$idTicket</h1><p>Próximamente</p>";
});

$router->post('/tickets/([0-9]+)/responder', function($idTicket) {
    // TODO: agregar mensaje al ticket
    header("Location: /tickets/$idTicket");
});

// Facturación
$router->get('/facturas', function() {
    // TODO: listar facturas del usuario
    echo '<h1>Mis Facturas</h1><p>Próximamente</p>';
});

$router->get('/facturas/([0-9]+)', function($idFactura) {
    // TODO: mostrar detalle de factura
    echo "<h1>Factura #$idFactura</h1><p>Próximamente</p>";
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

$router->post('/api/websocket', function() use ($repositorioUsuario, $pterodactylCliente) {
    $idServidor = $_POST['servidor_id'];
    $clientKey = $repositorioUsuario->obtenerClientKey($_SESSION['usuario']['id']);
    $websocket = $pterodactylCliente->obtenerWebSocket($idServidor, $clientKey);

    echo json_encode($websocket);
});

$router->post('/api/servidores/subirMod', function() use ($controladorServidor) {
    $controladorServidor->subirMod();
});

// Redirección desde la ruta API anterior
$router->post('/api/servidor/subirMod', function() {
    header('Location: /api/servidores/subirMod');
});

$router->post('/api/servidores/([a-zA-Z0-9]+)/accion/([a-zA-Z0-9]+)', function($idServidor, $accion) use ($controladorServidor) {
    // $controladorServidor->ejecutarAccion($idServidor, $accion);
});

$router->get('/api/servidores/([a-zA-Z0-9]+)/tabs/([a-zA-Z]+)', function($idServidor, $tabNombre) use ($controladorServidor) {
    $controladorServidor->obtenerTabPanel($idServidor, $tabNombre);
});

// ------------------
// Errores
// ------------------

$router->set404(function() {
    http_response_code(404);
    require_once APP_ROOT . 'vistas/paginas/404.php';
});

$router->run();
