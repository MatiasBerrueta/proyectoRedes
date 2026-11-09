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

        $datosTab = $this->resolverTab($idServidorPterodactyl, $tabActualId, ['path' => $_GET['path'] ?? '']);

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
            'path' => $_GET['path'] ?? ''
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

    public function subirMod($idServidor) {
        $logger = ServicioLogger::obtenerLogger();
        $this->requiereLogin();

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
        echo $resultado;
    }

    public function renombrarArchivo(string $idServidor): void {
      $this->requiereLogin();

      $idUsuario = $_SESSION['usuario']['id'];

      $inputJSON = file_get_contents('php://input');
      $data = json_decode($inputJSON, true);

      $ruta = $data['ruta'] ?? '/';
      $nombreViejo = $data['nombre'];
      $nombreNuevo = $data['nombreNuevo'];

      $this->servicioServidor->renombrarArchivo($idServidor, $idUsuario, $ruta, $nombreViejo, $nombreNuevo);
    }

    public function guardarArchivo(string $idServidor): void {
        header('Content-Type: application/json');

        $idUsuario = $_SESSION['usuario']['id'];
        $inputJSON = file_get_contents('php://input');

        $data = json_decode($inputJSON, true);

        $ruta = $data['ruta'] ?? '/';
        $nombre = $data['nombre'];
        $contenido = $data['contenido'];

        if (!$this->servicioServidor->servidorTieneArchivo($idServidor, $idUsuario, $ruta, $nombre)) {
            http_response_code(409);
            echo json_encode(["error" => "El archivo no existe"]);
            return;
        }

        $this->servicioServidor->modificarArchivo($idServidor, $idUsuario, $ruta, $nombre, $contenido);
    }

    public function crearArchivo(string $idServidor): void {
        header('Content-Type: application/json');

        $idUsuario = $_SESSION['usuario']['id'];
        $inputJSON = file_get_contents('php://input');

        $data = json_decode($inputJSON, true);

        $ruta = $data['ruta'] ?? '/';
        $nombre = $data['nombre'];

        if ($this->servicioServidor->servidorTieneArchivo($idServidor, $idUsuario, $ruta, $nombre)) {
            http_response_code(409);
            echo json_encode(["error" => "El archivo ya existe"]);
            return;
        }

        $this->servicioServidor->modificarArchivo($idServidor, $idUsuario, $ruta, $nombre);
    }

    public function descargarArchivo(string $idServidor): void {
        header('Content-Type: application/json');

        $idUsuario = $_SESSION['usuario']['id'];
        $inputJSON = file_get_contents('php://input');

        $data = json_decode($inputJSON, true);

        $ruta = $data['ruta'] ?? '/';
        $nombre = $data['nombre'];

        if (!$this->servicioServidor->servidorTieneArchivo($idServidor, $idUsuario, $ruta, $nombre)) {
            http_response_code(409);
            echo json_encode(["error" => "El archivo no existe"]);
            return;
        }

        $linkDescarga = $this->servicioServidor->descargarArchivo($idServidor, $idUsuario, $ruta, $nombre);
        echo json_encode($linkDescarga);
    }

    public function subirArchivo(string $idServidor): void {
        header('Content-Type: application/json');
        $this->requiereLogin();

        $idUsuario = $_SESSION['usuario']['id'];
        $ruta = $this->normalizarDirectorio($_POST['ruta'] ?? '/');

        if (!isset($_FILES['archivos'])) {
            http_response_code(400);
            echo json_encode(["error" => "No se recibieron archivos"]);
            return;
        }

        $archivos = $this->normalizarArchivosSubidos($_FILES['archivos']);
        $subidos = [];
        $errores = [];

        foreach ($archivos as $archivo) {
            $nombre = $this->normalizarNombreArchivo((string) ($archivo['name'] ?? ''));

            if (($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                $errores[] = $this->mensajeErrorSubida((int) $archivo['error'], $nombre);
                continue;
            }

            if ($nombre === '') {
                $errores[] = "Nombre de archivo inválido.";
                continue;
            }

            if (!is_uploaded_file((string) $archivo['tmp_name'])) {
                $errores[] = "El archivo {$nombre} no es una subida válida.";
                continue;
            }

            try {
                $this->servicioServidor->subirArchivo($idServidor, $idUsuario, $ruta, $archivo['tmp_name'], $nombre);
                $subidos[] = $nombre;
            } catch (Throwable $e) {
                $errores[] = "No se pudo subir {$nombre}: " . $e->getMessage();
            }
        }

        if (empty($subidos) && !empty($errores)) {
            http_response_code(500);
            echo json_encode(["error" => implode(' ', $errores)]);
            return;
        }

        echo json_encode([
            "subidos" => $subidos,
            "errores" => $errores,
        ]);
    }

    public function moverArchivo(string $idServidor): void {
        header('Content-Type: application/json');
        $this->requiereLogin();

        $idUsuario = $_SESSION['usuario']['id'];
        $data = json_decode(file_get_contents('php://input'), true);

        if (!is_array($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos"]);
            return;
        }

        $ruta = $this->normalizarDirectorio($data['ruta'] ?? '/');
        $destino = trim(str_replace('\\', '/', (string) ($data['destino'] ?? '')));
        $nombre = $this->normalizarNombreArchivo((string) ($data['nombre'] ?? ''));

        if ($nombre === '' || $destino === '') {
            http_response_code(400);
            echo json_encode(["error" => "Faltan el nombre o la ruta de destino"]);
            return;
        }

        try {
            $this->servicioServidor->moverArchivo($idServidor, $idUsuario, $ruta, $nombre, $destino);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
            return;
        }

        echo json_encode([
            "ok" => true,
            "nombre" => $nombre,
            "destino" => $destino,
        ]);
    }

    private function normalizarDirectorio($ruta): string {
        $ruta = '/' . trim(str_replace('\\', '/', (string) $ruta), '/');

        return $ruta === '/' ? '/' : $ruta;
    }

    private function normalizarNombreArchivo(string $nombre): string {
        $nombre = str_replace('\\', '/', $nombre);
        $nombre = basename($nombre);
        $nombre = preg_replace('/[\x00-\x1F\x7F]/', '', $nombre) ?? '';
        $nombre = trim($nombre);

        if ($nombre === '' || $nombre === '.' || $nombre === '..') {
            return '';
        }

        return $nombre;
    }

    private function normalizarArchivosSubidos(array $archivos): array {
        if (!isset($archivos['name'])) {
            return [];
        }

        if (!is_array($archivos['name'])) {
            return [$archivos];
        }

        $lista = [];

        foreach ($archivos['name'] as $indice => $nombre) {
            $lista[] = [
                'name' => $nombre,
                'type' => $archivos['type'][$indice] ?? '',
                'tmp_name' => $archivos['tmp_name'][$indice] ?? '',
                'error' => $archivos['error'][$indice] ?? UPLOAD_ERR_NO_FILE,
                'size' => $archivos['size'][$indice] ?? 0,
            ];
        }

        return $lista;
    }

    private function mensajeErrorSubida(int $codigo, string $nombre): string {
        $mensajes = [
            UPLOAD_ERR_INI_SIZE => 'excede el tamaño máximo permitido por el servidor',
            UPLOAD_ERR_FORM_SIZE => 'excede el tamaño máximo permitido por el formulario',
            UPLOAD_ERR_PARTIAL => 'se subió parcialmente',
            UPLOAD_ERR_NO_FILE => 'no se recibió',
            UPLOAD_ERR_NO_TMP_DIR => 'no hay directorio temporal disponible',
            UPLOAD_ERR_CANT_WRITE => 'no se pudo escribir en el disco',
            UPLOAD_ERR_EXTENSION => 'una extensión de PHP detuvo la subida',
        ];

        $detalle = $mensajes[$codigo] ?? 'no se pudo subir';
        $nombre = $nombre !== '' ? $nombre : 'archivo';

        return "El archivo {$nombre} {$detalle}.";
    }
}
