<?php

class pterodactylClientApi {
    // private $clientKey;

    // public function __construct($clientKey) {
    //     $this->clientKey = $clientKey;
    // }

    private function request($endpoint, $clientKey) {
        $curl = curl_init("http://172.17.0.1/api/client" . $endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $clientKey",
            "Accept: Application/vnd.pterodactyl.v1+json"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function obtenerLogs($serverId, $clientKey) {
        $pathArchivo = '/logs/latest.log';
        $url = "/servers/{$serverId}/files/contents?" . http_build_query(['file' => $pathArchivo]);
        return $this->request($url, $clientKey);
    }

    public function obtenerRecursosServidor($id, $clientKey) {
        return $this->request('/servers/' . $id . '/resources', $clientKey);
    }

    public function obtenerServidores($clientKey) {
        $respuesta = $this->request('/', $clientKey);

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
        $servidor = $this->request('/servers/' . $id, $clientKey);
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
        return $this->request('/servers/'. $id . '/websocket', $clientKey);
    }
}