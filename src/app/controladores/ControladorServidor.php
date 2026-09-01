<?php
require_once APP_ROOT . 'controladores/Controlador.php';

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

    private function resolverTab(string $idServidorPterodactyl, string $tabId, array $params) {
        $idUsuario = $_SESSION['usuario']['id'];

        // Obtenemos el servidor de forma segura (valida ownership e identifica el juego)
        $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidorPterodactyl, $idUsuario);
        if (!$servidor) {
            throw new Exception("Servidor no encontrado o no autorizado.", 404);
        }

        $juego = $servidor['nombre_grupo'] ?? 'default';

        switch ($tabId) {
            case 'consola':
                return $this->servicioJuego->obtenerDatosConsola($idServidorPterodactyl, $idUsuario);

            case 'configuracion':
                return $this->servicioJuego->obtenerConfiguracion($idServidorPterodactyl, $idUsuario, $juego);

            case 'archivos':
                $path = $params['path'] ?? '';
                
                $basename = basename($path);
    
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $filename = pathinfo($path, PATHINFO_FILENAME);

                // es un elemento oculto tipo '.cache' si el filename esta vacio
                $esOcultoSinExtension = str_starts_with($basename, '.') && empty($filename);
                
                $esArchivo = !empty($extension) && !$esOcultoSinExtension;

                if ($esArchivo) {
                    try {
                        return $this->servicioJuego->obtenerArchivoContenido($idServidorPterodactyl, $path, $idUsuario);
                    } catch (\Exception $e) {
                        return "No se pudo leer el contenido de este archivo.";
                    }
                }

                return $this->servicioJuego->obtenerArchivos($idServidorPterodactyl, $idUsuario, $path);

            default:
                return [];
        }
    }

    public function mostrarServidor(string $idServidorPterodactyl, string $tabId = 'consola') {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidorPterodactyl, $idUsuario);
        $juego = $servidor['nombre_grupo'];
        
        $tabs = $this->servicioJuego->getTabs(strtolower($juego));
        $tabsPorId = array_column($tabs, null, 'id');

        $tabActualId = isset($tabsPorId[$tabId]) ? $tabId : 'consola';
        
        $datosTab = $this->resolverTab($idServidorPterodactyl, $tabActualId, ['path' => $_GET['path'] ?? '/']);

        $this->renderizar('paginas/servidor/servidor', [
            'servidor'  => $servidor,
            'tabs'      => $tabsPorId,
            'tabActual' => $tabActualId,
            'datosTab'  => $datosTab,
        ]);
    }

    public function obtenerTabPanel(string $idServidorPterodactyl, string $tabId) {
        $this->requiereLogin();

        $params = [
            'path' => $_GET['path'] ?? '/'
        ];

        $logger = ServicioLogger::obtenerLogger();
        $logger->info('GET', [
            'path' => $_GET['path'],
        ]);

        $datosTab = $this->resolverTab($idServidorPterodactyl, $tabId, $params);

        $this->renderizar("paginas/servidor/tabs/$tabId", [
            'datosTab' => $datosTab
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