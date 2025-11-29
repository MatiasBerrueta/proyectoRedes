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

    public function obtenerServidores() {
        return $this->request('/');
    }

    public function obtenerServidorPorId($id) {
        return $this->request('/servers/' . $id);
    }
}