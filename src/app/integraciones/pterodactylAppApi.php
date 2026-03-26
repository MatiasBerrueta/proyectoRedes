<?php

class pterodactylAppApi {
    public function __construct() {
    }

    private function request($endpoint, $data, $metodo) {
        $curl = curl_init("http://172.17.0.1/api/application" . $endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ptla_uFRtsXT2S1Z3Sb3g5riseURlDxy8xcQGfeQWP0os9K6",
            "Accept: Application/vnd.pterodactyl.v1+json",
            'Content-Type: application/json'
        ]);

        if ($metodo === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($metodo === 'GET') {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        }

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    public function crearServidor($nombre, $pterodactylIdUsuario, $eggId, $nestId, $limites, $allocationId) {
        $egg = $this->request("/nests/$nestId/eggs/$eggId?include=variables", [], 'GET');
    
        $dockerImage = $egg['attributes']['docker_image'];
        $startup = $egg['attributes']['startup'];

        $environment = [];
        foreach ($egg['attributes']['relationships']['variables']['data'] as $var) {
            $attr = $var['attributes'];
            $environment[$attr['env_variable']] = $attr['default_value'];
        }

        // name: Nombre del servidor (solo visual)
        // user: ID del usuario en Pterodactyl (propietario del servidor)
        // egg: Tipo de servidor (define instalación y comportamiento, en algunos casos es el juego, en otros el motor)

        // docker_image: Imagen Docker usada para ejecutar el servidor
        // startup: Comando de arranque del servidor
        // environment: Variables del entorno (VERSION, puertos, etc.)

        // memory: RAM máxima en MB
        // swap: Si la memoria RAM se llena, se usa memoria extra en disco (lenta). 0 = desactivado
        // disk: Espacio máximo en disco (MB)
        // io: Prioridad de I/O (lectura/escritura en disco). 500-1000 normal
        // cpu: Límite de CPU (0 = sin limites, 50 = medio core, 100 = 1 core, 200 = 2 cores, etc.)
        // oom_disabled: false = OOM activo (mata proceso si se queda sin RAM)

        // databases: Cantidad máxima de bases de datos
        // allocations: Cantidad de puertos/asignaciones adicionales
        // backups: Cantidad máxima de backups

        // default (allocation): Puerto/IP principal asignado al servidor
        $serverData = [
            'name' => $nombre,
            'user' => $pterodactylIdUsuario,
            'egg' => $eggId,
            'docker_image' => $dockerImage,
            'startup' => $startup,
            'environment' => $environment,
            'limits' => [
                'memory' => $limites['ram'],
                'swap' => 0,
                'disk' => $limites['disco'],
                'io' => $limites['io'],
                'cpu' => $limites['cpu'],
                'oom_disabled' => false
            ],
            'feature_limits' => [
                'databases' => 0,
                'allocations' => 1,
                'backups' => 5
            ],
            'allocation' => [
                'default' => $allocationId
            ]
        ];

        return $this->request("servers", $serverData, 'POST');
    }

    private function crearClientApiKey($pterodactylIdUsuario) {
        $memo = json_encode([
            'memo' => 'Generada automaticamente',
        ]);
        return $this->request("/users/$pterodactylIdUsuario/api-keys", $memo, 'POST');
    }

    public function crearUsuario($nombre, $email, $contrasena) {
        $userData = [
            'email' => $email,
            'username' => $nombre,
            'first_name' => $nombre,
            'last_name' => '',
            'password' => $contrasena,
            'external_id' => uniqid('app_', true),
        ];

        $usuarioPterodactyl = $this->request('/users', $userData, 'POST');

        if (!isset($usuarioPterodactyl['attributes'])) {
            error_log('Error creando usuario: ' . json_encode($usuarioPterodactyl));
            return null;
        }

        $this->crearClientApiKey($usuarioPterodactyl['attributes']['id']);
    }

    public function listarServidores() {
        return $this->request('/servers', [], 'GET');
    }

    public function listarNests() {
        return $this->request('/nests?include=eggs', [], 'GET');
    }

    public function listarEggs($nestId) {
        return $this->request("/nests/$nestId/eggs", [], 'GET');
    }
}