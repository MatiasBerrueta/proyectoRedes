<?php
require_once APP_ROOT . 'controladores/Controlador.php';
// require_once APP_ROOT . 'factories/JuegoFactory.php';

class ControladorServidor extends Controlador {
    private $servicioServidor;
    private $servicioJuego;

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
        'directory' => 'handleDirectory',
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
        echo "<script>console.log(" . json_encode($method) . ")</script>";

        $idUsuario = $_SESSION['usuario']['id'];
        return $this->servicioJuego->$method($servidor, $idUsuario);
    }

    public function mostrarServidor($idServidor, $tabId = 'consola') {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidor, $idUsuario);
        $juego = $servidor['nombre_grupo'];
        // $driver = JuegoFactory::crear($juego);
        $tabs = $this->servicioJuego->getTabs(strtolower($juego));

        // Indexa los tabs por id
        $tabsPorId = [];

        foreach ($tabs as $tab) {
            $tabsPorId[$tab['id']] = $tab;
        }

        $tabActual = $tabsPorId[$tabId] ?? null;
        $datosTab = $this->resolverTab($tabActual, $servidor);

        echo "<script>console.log(" . json_encode($tabActual) . ")</script>";

        $this->renderizar('paginas/servidor', [
            'servidor' => $servidor,
            'tabs' => $tabsPorId,
            'tabActual' => $tabActual['id'],
            'datosTab' => $datosTab,
        ]);
    }

}