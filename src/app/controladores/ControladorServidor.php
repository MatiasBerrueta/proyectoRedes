<?php
require_once APP_ROOT . 'controladores/Controlador.php';
// require_once APP_ROOT . 'factories/JuegoFactory.php';

class ControladorServidor extends Controlador {
    private ServicioServidor $servicioServidor;
    private ServicioJuego $servicioJuego;

    public function __construct(ServicioServidor $servicioServidor, ServicioJuego $servicioJuego) {
        $this->servicioServidor = $servicioServidor;
        $this->servicioJuego = $servicioJuego;
    }

    // Funcion solo para pruebas sin levantar pterodactyl, no usar en produccion
    private function obtenerServidores() {
        return [
            [
                'identifier' => '1a',
                'nombre' => 'Servidor muestra 1',
                'ipServidor' => '192.168.0.1',
                'puertoServidor' => '25565',
                'estado' => 'Offline',
                'numeroJugadores' => 1,
                'maximoNumeroJugadores' => 20,
                'usoCpu' => 5,
                'maximoUsoCpu' => 100,
                'usoRam' => 1024 * 100000,
                'maximoUsoRam' => 1024,
                'juego' => 'terraria'
            ],
            [
                'identifier' => '2b',
                'nombre' => 'Servidor muestra 2',
                'ipServidor' => '192.168.0.2',
                'puertoServidor' => '25566',
                'estado' => 'Online',
                'numeroJugadores' => 8,
                'maximoNumeroJugadores' => 50,
                'usoCpu' => 25,
                'maximoUsoCpu' => 100,
                'usoRam' => 2048 * 100000,
                'maximoUsoRam' => 4096,
                'juego' => 'minecraft'
            ],
            [
                'identifier' => '3c',
                'nombre' => 'Servidor muestra 3',
                'ipServidor' => '192.168.0.3',
                'puertoServidor' => '27015',
                'estado' => 'Online',
                'numeroJugadores' => 12,
                'maximoNumeroJugadores' => 32,
                'usoCpu' => 40,
                'maximoUsoCpu' => 100,
                'usoRam' => 3072 * 100000,
                'maximoUsoRam' => 8192,
                'juego' => 'cs2'
            ]
        ];
    }

    public function mostrarPanel() {
        $this->requiereLogin();
        $rol = $_SESSION['usuario']['rol'];
        // $url = 'panel/panel' . $rol === 'CLIENTE' ? 'Usuario' : 'Administrador';
        $url = '/paginas/panelUsuario';

        $servidores = $this->servicioServidor->obtenerServidoresPterodactyl($_SESSION['usuario']['id']);
        // $servidores = $this->obtenerServidores();

        $this->renderizar($url, ['servidores' => $servidores]);
    }

    // public function ejecutarAccion($juego, $accion) {
    //     $driver = JuegoFactory::crear($juego);

    //     $datos = array_merge($_GET, $_POST);
    //     $resultado = $driver->$accion($datos);

    //     header('Content-Type: application/json');
    //     echo json_encode($resultado);
    // }

    // public function mostrarServidor($idServidor, $tab = 'consola') {
    //     $this->requiereLogin();
    //     $idUsuario = $_SESSION['usuario']['id'];

    //     $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidor, $idUsuario);
    //     $driver = JuegoFactory::crear($servidor['nombre_grupo']);
    //     $tabs = $driver->obtenerTabs();
    //     $tabActual = array_find($tabs, fn($tab) => $tab['id'] === $tab);
    //     $datosTab = $driver->$tabActual['init']();

    //     echo "<script>console.log(" . json_encode($servidor) . ")</script>";

    //     $this->renderizar('paginas/servidor', [
    //         'servidor' => $servidor,
    //         'tabs' => $tabs,
    //         'tabActual' => $tabActual,
    //         'datosTab' => $datosTab,
    //     ]);
    // }

    // prueba de sistema
    private $tabHandlers = [
        'log' => 'handleLog',
        'file' => 'handleFile',
        'config' => 'obtenerConfiguracion',
        'pterodactyl' => 'handlePterodactyl',
        'directory' => 'obtenerArchivos',
    ];

    private function resolverTab($tab, $servidor) {
        $type = $tab['type'];

        if (!isset($this->tabHandlers[$type])) {
            return null;
        }

        $method = $this->tabHandlers[$type];

        $idUsuario = $_SESSION['usuario']['id'];
        return $this->servicioJuego->$method($servidor, $idUsuario);
    }

    public function mostrarServidor(string $idServidorPterodactyl, string $tabId = 'consola') {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidorPterodactyl, $idUsuario);
        $juego = $servidor['nombre_grupo'];
        $tabs = $this->servicioJuego->getTabs(strtolower($juego));

        $tabsPorId = [];

        foreach ($tabs as $tab) {
            $tabsPorId[$tab['id']] = $tab;
        }

        $tabActual = $tabsPorId[$tabId] ?? null;
        $datosTab = $this->resolverTab($tabActual, $servidor);

        $this->renderizar('paginas/servidor/servidor', [
            'servidor' => $servidor,
            'tabs' => $tabsPorId,
            'tabActual' => $tabActual['id'],
            'datosTab' => $datosTab,
        ]);
    }

    public function subirMod() {
        $logger = ServicioLogger::obtenerLogger();
        $this->requiereLogin();
        
        $idServidor = $_POST['servidor_id'] ?? null;
        $modUrl = $_POST['mod_url'] ?? null;
        $idUsuario = $_SESSION['usuario']['id'];

        $logger->info('Subir mod solicitado', [
            'user_id' => $idUsuario,
            'server_id' => $idServidor
        ]);

        if (!$idServidor || !$modUrl) {
            $logger->warning('Subir mod llamado sin parámetros requeridos', [
                'user_id' => $idUsuario
            ]);
            http_response_code(400);
            return;
        }

        $resultado = $this->servicioServidor->subirMod($idServidor, $idUsuario, $modUrl);
        
        $logger->debug('Subir mod resultado', [
            'user_id' => $idUsuario,
            'result' => $resultado
        ]);
        
        header('Content-Type: application/json');
    }

}