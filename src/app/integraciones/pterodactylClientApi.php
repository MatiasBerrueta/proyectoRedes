<?php

class pterodactylClientApi {
    private function request(string $endpoint, string $clientKey, string $method = 'GET', $data = null, array $headers = [], string $contentType = 'text/plain') {
        $logger = ServicioLogger::obtenerLogger();
        
        $url = "http://172.17.0.1/api/client" . $endpoint;
        $logger->info('Request iniciado', [
            'method' => $method,
            'url' => $url,
            'content_type' => $contentType
        ]);

        $curl = curl_init($url);

        $defaultHeaders = [
            "Authorization: Bearer $clientKey",
            "Accept: Application/vnd.pterodactyl.v1+json",
            "Content-Type: $contentType"
        ];

        $finalHeaders = array_merge($defaultHeaders, $headers);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $finalHeaders);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            if ($data !== null) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        $logger->debug('Response recibida', [
            'http_code' => $httpCode,
            'curl_error' => $error,
            'body_length' => strlen($response)
        ]);

        if ($httpCode >= 400) {
            $logger->error('Request falló', [
                'http_code' => $httpCode,
                'endpoint' => $endpoint,
                'response' => substr($response, 0, 500)
            ]);
        }

        return $response;
    }

    public function obtenerLogs(string $serverId, string $clientKey) {
        $pathArchivo = '/logs/latest.log';
        $url = "/servers/{$serverId}/files/contents?" . http_build_query(['file' => $pathArchivo]);
        return $this->request($url, $clientKey);
    }

    public function obtenerRecursosServidor(string $id, string $clientKey) {
        $respuesta = $this->request('/servers/' . $id . '/resources', $clientKey);

        return json_decode($respuesta, true);
    }

    public function obtenerServidores(string $clientKey) {
        $respuesta = json_decode($this->request('/', $clientKey), true);

        return array_map(function($servidor) use ($clientKey) {
        $recursos = $this->obtenerRecursosServidor($servidor['attributes']['identifier'], $clientKey);
        return [
            'identifier' => $servidor['attributes']['identifier'],
            'nombre' => $servidor['attributes']['name'],
            'ip' => $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['ip'],
            'puerto' => $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['port'],
            'estado' => $recursos['attributes']['current_state'],
            'numeroJugadores' => 0,
            'maximoNumeroJugadores' => 20,
            'usoCpu' => $recursos['attributes']['resources']['cpu_absolute'],
            'maximoUsoCpu' => $servidor['attributes']['limits']['cpu'],
            'usoRam' => $recursos['attributes']['resources']['memory_bytes'],
            'maximoUsoRam' => $servidor['attributes']['limits']['memory'],
            'usoDisco' => $recursos['attributes']['resources']['disk_bytes'],
            'maximoUsoDisco' => $servidor['attributes']['limits']['disk'],
        ];
    }, $respuesta['data']);
    }

    public function obtenerServidor(string $id, string $clientKey) {
        $servidor = json_decode($this->request('/servers/' . $id, $clientKey), true);
        $recursos = $this->obtenerRecursosServidor($id, $clientKey);
        $ultimoLog = $this->obtenerLogs($id, $clientKey);
        
        return [
            'identifier' => $servidor['attributes']['identifier'],
            'nombre' => $servidor['attributes']['name'],
            'ip' => $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['ip'],
            'puerto' => $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['port'],
            'estado' => $recursos['attributes']['current_state'],
            'numeroJugadores' => 0,
            'maximoNumeroJugadores' => 20,
            'usoCpu' => $recursos['attributes']['resources']['cpu_absolute'],
            'maximoUsoCpu' => $servidor['attributes']['limits']['cpu'],
            'usoRam' => $recursos['attributes']['resources']['memory_bytes'],
            'maximoUsoRam' => $servidor['attributes']['limits']['memory'],
            'usoDisco' => $recursos['attributes']['resources']['disk_bytes'],
            'maximoUsoDisco' => $servidor['attributes']['limits']['disk'],
            'upTime' => $recursos['attributes']['resources']['uptime'],
            'ultimoLog' => $ultimoLog,
        ];
    }

    public function obtenerWebSocket(string $id, string $clientKey) {
        $resultado = $this->request('/servers/'. $id . '/websocket', $clientKey);
        // echo "<script>console.log(" . json_encode($resultado) . ")</script>";

        return json_decode($resultado, true);
    }

    // Devuelve una lista de los archivos y directorios que hay en la ruta especificada
    public function obtenerDirectorios(string $idServidor, string $rutaDirectorio, string $clientKey) {
        $url = "/servers/{$idServidor}/files/list?" . http_build_query(['directory' => $rutaDirectorio]);
        echo "<script>console.log(" . json_encode($url) . ")</script>";
        
        $respuesta = $this->request($url, $clientKey);
        return json_decode($respuesta, true);
    }

    // Devuelve el contenido del archivo en la ruta especificada
    public function leerArchivo(string $idServidor, string $rutaArchivo, string $clientKey) {
        $url = "/servers/{$idServidor}/files/contents?" . http_build_query(['file' => $rutaArchivo]);
        echo "<script>console.log(" . json_encode($url) . ")</script>";
        

        return $this->request($url, $clientKey);
    }

    public function escribirArchivo(string $idServidor, string $rutaArchivo, string $contenido, string $clientKey) {
        $url = "/servers/{$idServidor}/files/write?" . http_build_query(['file' => $rutaArchivo]);

        $response = $this->request($url, $clientKey, 'POST', $contenido);
        return json_decode($response, true);
    }

    public function subirArchivo(string $idServidor, string $rutaDirectorio, string $rutaArchivo, string $clientKey) {
        $url = "/servers/{$idServidor}/files/upload?" . http_build_query(['directory' => $rutaDirectorio]);
        $respuesta = json_decode($this->request($url, $clientKey));

        $urlFirmada = $respuesta['attributes']['url'];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $urlFirmada);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'files' => new CURLFile($rutaArchivo),
            'directory' => $rutaDirectorio
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $uploadResponse = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        
        return [
            'success' => ($httpCode === 200 || $httpCode === 204),
            'httpCode' => $httpCode,
            'response' => json_decode($uploadResponse, true)
        ];
    }

    public function subirArchivoDesdeUrl(string $idServidor, string $urlArchivo, string $rutaDirectorio, string $clientKey, ?string $nombreArchivo = null) {
        $logger = ServicioLogger::obtenerLogger();
        
        $logger->info('Subir archivo desde URL', [
            'server_id' => $idServidor,
            'url' => $urlArchivo,
            'directory' => $rutaDirectorio,
            'filename' => $nombreArchivo
        ]);
        
        $endpoint = "/servers/{$idServidor}/files/pull";
        
        $payload = [
            'url' => $urlArchivo,
            'directory' => $rutaDirectorio,
        ];

        if ($nombreArchivo !== null) {
            $payload['filename'] = $nombreArchivo;
        }

        $response = $this->request($endpoint, $clientKey, 'POST', json_encode($payload), [], 'application/json');
        
        if (empty($response)) {
            $logger->info('Archivo subido correctamente', [
                'server_id' => $idServidor,
                'directory' => $rutaDirectorio
            ]);
            return ['success' => true, 'message' => 'Archivo descargado correctamente'];
        }
        
        $decoded = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $logger->error('Respuesta inválida al subir archivo', [
                'server_id' => $idServidor,
                'error' => json_last_error_msg()
            ]);
            return ['success' => false, 'error' => 'Respuesta inválida del servidor', 'raw' => $response];
        }
        
        return $decoded;
    }
}