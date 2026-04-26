<?php

class pterodactylClientApi {
    private function request($endpoint, $clientKey) {
        $curl = curl_init("http://172.17.0.1/api/client" . $endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $clientKey",
            "Accept: Application/vnd.pterodactyl.v1+json"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function obtenerLogs($serverId, $clientKey) {
        $pathArchivo = '/logs/latest.log';
        $url = "/servers/{$serverId}/files/contents?" . http_build_query(['file' => $pathArchivo]);
        return $this->request($url, $clientKey);
    }

    public function obtenerRecursosServidor($id, $clientKey) {
        $respuesta = $this->request('/servers/' . $id . '/resources', $clientKey);

        return json_decode($respuesta, true);
    }

    public function obtenerServidores($clientKey) {
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

    public function obtenerServidor($id, $clientKey) {
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

    public function obtenerWebSocket($id, $clientKey) {
        $resultado = $this->request('/servers/'. $id . '/websocket', $clientKey);
        // echo "<script>console.log(" . json_encode($resultado) . ")</script>";

        return json_decode($resultado, true);
    }

    // Devuelve una lista de los archivos y directorios que hay en la ruta especificada
    public function obtenerDirectorios($idServidor, $rutaDirectorio, $clientKey) {
        $url = "/servers/{$idServidor}/files/list?" . http_build_query(['directory' => $rutaDirectorio]);
        echo "<script>console.log(" . json_encode($url) . ")</script>";
        
        $respuesta = $this->request($url, $clientKey);
        return json_decode($respuesta, true);
    }

    // Devuelve el contenido del archivo en la ruta especificada
    public function leerArchivo($idServidor, $rutaArchivo, $clientKey) {
        $url = "/servers/{$idServidor}/files/contents?" . http_build_query(['file' => $rutaArchivo]);
        echo "<script>console.log(" . json_encode($url) . ")</script>";
        

        return $this->request($url, $clientKey);
    }

    public function escribirArchivo($idServidor, $rutaArchivo, $clientKey) {
        $url = "/servers/{$idServidor}/files/write?{$rutaArchivo}";

        return $this->request($url, $clientKey);
    }

    public function subirArchivo($idServidor, $rutaArchivo, $clientKey) {
        $url = "/servers/{$idServidor}/files/contents?" . http_build_query(['file' => $rutaArchivo]);
        

        return $this->request($url, $clientKey);
    }
}