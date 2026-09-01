<?php

class ServicioJuego {
    private RepositorioUsuario $repositorio;
    private PterodactylClientApi $pterodactyl;

    public function __construct(RepositorioUsuario $repositorio, PterodactylClientApi $pterodactyl) {
        $this->repositorio = $repositorio;
        $this->pterodactyl = $pterodactyl;
    }

    public function obtenerConfiguracionJuego($game) {
        $path = APP_ROOT . "/juegos/$game.json";

        if (!file_exists($path)) {
            try {
                $path = APP_ROOT . "/juegos/default.json";
            } catch (\Exception $e) {
                throw new Exception("Configuracion de juego no encontrada.");
            }
        }

        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    public function getTabs($game) {
        $config = $this->obtenerConfiguracionJuego($game);

        return $config['ui']['tabs'] ?? [];
    }

    public function obtenerArchivos(string $servidorId, int $idUsuario, string $path): array {
        $clientKey = $this->repositorio->obtenerClientKey($idUsuario);
        $content = $this->pterodactyl->obtenerDirectorios($servidorId, $path, $clientKey);

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

    public function obtenerArchivoContenido(string $servidorId, string $rutaArchivo, int $idUsuario) {
        $clientKey = $this->repositorio->obtenerClientKey($idUsuario);
        $contenido = $this->pterodactyl->leerArchivo($servidorId, $rutaArchivo, $clientKey);

        return $contenido;
    }

    public function obtenerConfiguracion(string $servidorId, int $idUsuario, string $juego) {
        $gameConfig = $this->obtenerConfiguracionJuego(strtolower($juego));
        
        $settings = $gameConfig['ui']['settings'] ?? [];
        
        $rutaArchivo = $gameConfig['config']['file'];
        $configuraciones = $this->obtenerArchivoContenido($servidorId, $rutaArchivo, $idUsuario);
    
        $parsed = $this->parseProperties($configuraciones);
        
        $result = $this->mapSettings($settings, $parsed);

        return $result;
    }

    public function obtenerDatosConsola(string $idServidorPterodactyl, int $idUsuario): array {
        $clientKey = $this->repositorio->obtenerClientKey($idUsuario);
        $servidor = $this->pterodactyl->obtenerServidor($idServidorPterodactyl, $clientKey);

        if (!$servidor) {
            return [];
        }

        $estadosMap = [
            "undefined" => "-",
            "running"   => "Activo",
            "starting"  => "Iniciando",
            "stopping"  => "Deteniendo",
            "offline"   => "Inactivo"
        ];
        $estado = $servidor['estado'] ?? 'undefined';

        $logsProcesados = [];
        if (!empty($servidor['ultimoLog'])) {
            $lineas = explode("\n", $servidor['ultimoLog']);
            foreach ($lineas as $line) {
                $line = trim($line);
                if ($line !== '') {
                    $logsProcesados[] = $this->limpiarLineaLog($line);
                }
            }
        }

        return [
            'nombre'           => $servidor['nombre'] ?? 'Servidor',
            'juego'            => $servidor['nombre_grupo'] ?? 'Juego',
            'nombreJuego'      => $servidor['nombre_juego'] ?? '',
            'version'          => $servidor['version'] ?? 'v1.0',
            'location'         => $servidor['ip'] ?? 'N/A',
            'estado'           => $estado,
            'estadoFormateado' => $estadosMap[$estado] ?? 'Desconocido',
            'ip'               => $servidor['ip'] ?? '0.0.0.0',
            'puerto'           => $servidor['puerto'] ?? '25565',
            'jugadores'        => $servidor['cantidadJugadores'] ?? '0/0',
            'uptimeFormateado' => $this->formatearMilisegundos($servidor['upTime'] ?? 0),
            'cpuUso'           => $servidor['cpu'] ?? 0,
            'ramUso'           => $servidor['ram'] ?? '0 MB',
            'logsConsola'      => $logsProcesados,
            'actividadReciente'=> null
        ];
    }

    private function limpiarLineaLog(string $line): string {
        if (preg_match('/\[(.*?)\] \[(.*?)\/(.*?)\]: (.*)/', $line, $matches)) {
            return "[{$matches[1]} {$matches[3]}]: {$matches[4]}";
        }
        return $line;
    }

    private function formatearMilisegundos(float $milisegundos): string {
        $segundos = floor($milisegundos / 1000);
        $dias     = floor($segundos / 86400);
        $horas    = floor(($segundos % 86400) / 3600);
        $minutos  = floor(($segundos % 3600) / 60);
        $segundos = $segundos % 60;

        if ($dias > 0) return "{$dias}d {$horas}h {$minutos}m";
        if ($horas > 0) return "{$horas}h {$minutos}m";
        if ($minutos > 0) return "{$minutos}m {$segundos}s";
        return "{$segundos}s";
    }
}