<?php

class pterodactylClientApi {
    private $clientKey;

    public function __construct($clientKey) {
        $this->clientKey = $clientKey;
    }

    private function request($endpoint) {
        $curl = curl_init("http://172.17.0.1/api/client" . $endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $this->clientKey",
            "Accept: Application/vnd.pterodactyl.v1+json"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function obtenerConsola($serverId) {
        $pathArchivo = '/logs/latest.log';
        $url = "/servers/{$serverId}/files/contents?" . http_build_query(['file' => $pathArchivo]);
        
        $curl = curl_init("http://172.17.0.1/api/client" . $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $this->clientKey",
            "Accept: Application/vnd.pterodactyl.v1+json"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function obtenerServidores() {
        return $this->request('/');
    }

    public function obtenerServidorPorId($id) {
        return $this->request('/servers/' . $id);
    }

    public function obtenerRecursosServidorPorId($id) {
        return $this->request('/servers/' . $id . '/resources');
    }

    public function obtenerWebSocket($id) {
        return $this->request('/servers/'. $id . '/websocket');
    }
}