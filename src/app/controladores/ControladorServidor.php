<?php
require_once APP_ROOT . 'controladores/Controlador.php';
require_once APP_ROOT . 'factories/JuegoFactory.php';

class ControladorServidor extends Controlador {
    private $servicio;

    public function __construct($servicio) {
        $this->servicio = $servicio;
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

        $servidores = $this->servicio->obtenerServidoresPterodactyl($_SESSION['usuario']['id']);
        // $servidores = $this->obtenerServidores();

        $this->renderizar($url, ['servidores' => $servidores]);
    }

    public function mostrarServidor($idServidor, $tab = 'consola') {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $servidor = $this->servicio->obtenerServidorPterodactyl($idServidor, $idUsuario);
        $driver = JuegoFactory::crear($servidor['nombre_grupo']);

        echo "<script>console.log(" . json_encode($servidor) . ")</script>";

        $this->renderizar('paginas/servidor', [
            'servidor' => $servidor,
            'tabActual' => $tab,
            'tabsJuego' => $driver->obtenerTabs(),
        ]);
    }
}