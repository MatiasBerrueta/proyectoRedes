<?php

class ServicioJuego {
    private $repositorio;
    private $pterodactyl;

    public function __construct(RepositorioUsuario $repositorio, PterodactylClientApi $pterodactyl) {
        $this->repositorio = $repositorio;
        $this->pterodactyl = $pterodactyl;
    }

    public function obtenerConfiguracionJuego($game) {
        $path = APP_ROOT . "/juegos/$game.json";

        if (!file_exists($path)) {
            throw new Exception("Configuracion de juego no encontrada.");
        }

        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    public function getTabs($game) {
        $config = $this->obtenerConfiguracionJuego($game);

        return $config['ui']['tabs'] ?? [];
    }

    public function obtenerArchivos($servidor, $idUsuario): array {
        // $gameConfig = $this->obtenerConfiguracionJuego(strtolower($servidor['nombre_grupo']));
        // $settings = $gameConfig['ui']['tabs'] ?? [];
        $clientKey = $this->repositorio->obtenerClientKey($idUsuario);
        $content = $this->pterodactyl->obtenerDirectorios($servidor['identifier'], '/', $clientKey);
        echo "<script>console.log(" . json_encode($content) . ")</script>";

        return $content;
    }

    public function handleLog() {
        return [];
    }

    public function handlePterodactyl() {
        return [];
    }

    function parseProperties($contenido) {
        $lineas = explode("\n", $contenido);
        $resultado = [];

        foreach ($lineas as $linea) {
            $linea = trim($linea);

            if ($linea === '' || str_starts_with($linea, '#')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $linea, 2));
            $resultado[$key] = $value;
        }

        return $resultado;
    }

    private function mapSettings($settingsJson, $properties) {
        foreach ($settingsJson as &$setting) {
            $fileKey = $setting['fileKey'];

            $valor = $properties[$fileKey] ?? $setting['default'];

            switch ($setting['tipo']) {
                case 'checkbox':
                    $valor = filter_var($valor, FILTER_VALIDATE_BOOLEAN);
                    break;

                case 'slider':
                    $valor = (int) $valor;
                    break;

                default:
                    $valor = (string) $valor;
                    break;
            }

            $setting['valor'] = $valor;
        }

        return $settingsJson;
    }

    public function obtenerConfiguracion($servidor, $idUsuario) {
        $gameConfig = $this->obtenerConfiguracionJuego(strtolower($servidor['nombre_grupo']));
        echo "<script>console.log(" . json_encode($gameConfig) . ")</script>";
        
        $settings = $gameConfig['ui']['settings'] ?? [];
        
        $rutaArchivo = $gameConfig['config']['file'];
        $clientKey = $this->repositorio->obtenerClientKey($idUsuario);
        $content = $this->pterodactyl->leerArchivo($servidor['identifier'], $rutaArchivo, $clientKey);
    
        $parsed = $this->parseProperties($content);
        
        $result = $this->mapSettings($settings, $parsed);
        echo "<script>console.log(" . json_encode($result) . ")</script>";

        return $result;
    }
}