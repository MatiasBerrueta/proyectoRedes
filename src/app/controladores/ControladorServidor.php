<?php
require_once APP_ROOT . 'controladores/Controlador.php';

class ControladorServidor extends Controlador {
    private ServicioServidor $servicioServidor;
    private ServicioJuego $servicioJuego;

    public function __construct(ServicioServidor $servicioServidor, ServicioJuego $servicioJuego) {
        $this->servicioServidor = $servicioServidor;
        $this->servicioJuego = $servicioJuego;
    }

    public function mostrarPanel() {
        $this->requiereLogin();
        $rol = $_SESSION['usuario']['rol'];
        // $url = 'panel/panel' . $rol === 'CLIENTE' ? 'Usuario' : 'Administrador';
        $url = '/paginas/panelUsuario';

        $servidores = $this->servicioServidor->obtenerServidoresPterodactyl($_SESSION['usuario']['id']);

        $this->renderizar($url, ['servidores' => $servidores]);
    }

    private function resolverTab(string $idServidorPterodactyl, string $tabId, array $params) {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidorPterodactyl, $idUsuario);
        if (!$servidor) {
            throw new Exception("Servidor no encontrado o no autorizado.", 404);
        }

        $juego = $servidor['nombre_juego'] ?? 'default';

        switch ($tabId) {
            case 'consola':
                return $this->servicioJuego->obtenerDatosConsola($idServidorPterodactyl, $idUsuario);

            case 'configuracion':
                return $this->servicioJuego->obtenerConfiguracion($idServidorPterodactyl, $idUsuario, $juego);

            case 'archivos':
                $archivos = $this->servicioJuego->obtenerArchivos($idServidorPterodactyl, $params['path'], $idUsuario);
                return json_encode(
                    $archivos,
                    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
                );
            default:
                return [];
        }
    }

    public function mostrarServidor(string $idServidorPterodactyl, string $tabId = 'consola') {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $servidor = $this->servicioServidor->obtenerServidorPterodactyl($idServidorPterodactyl, $idUsuario);
        $juego = $servidor['nombre_juego'];

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
