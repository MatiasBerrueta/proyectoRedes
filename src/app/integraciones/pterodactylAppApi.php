<?php

class pterodactylAppApi {
    public function __construct() {
    }

    private function request($endpoint, $data, $metodo) {
        $logger = ServicioLogger::obtenerLogger();
        
        $url = "http://172.17.0.1/api/application" . $endpoint;
        $logger->info('App API Request', [
            'method' => $metodo,
            'endpoint' => $endpoint
        ]);

        $curl = curl_init($url);

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
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $logger->debug('App API Response', [
            'http_code' => $httpCode,
            'endpoint' => $endpoint
        ]);

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

    private function crearClientApiKey(string $pterodactylIdUsuario) {
        $memo = json_encode([
            'memo' => 'Generada automaticamente',
        ]);
        // return $this->request("/users/$pterodactylIdUsuario/api-keys", $memo, 'POST');
        $clientKeyGlobal = 'ptlc_aUGNsV1gQyu9o0O2sQQzjY4vCvc0KHrujPNIqfFAu5I';
        return $clientKeyGlobal;
    }

    // Esta funcion genera un username apartir de email, elimina y limpia simbolos basados en el regex propio de pterodactyl para usernames
    private function generarUsername(string $email): string {
        $base = mb_strtolower(explode('@', $email)[0]);
        $base = explode('+', $base)[0];
        $base = preg_replace('/[^a-z0-9_.-]/', '', $base);
        $base = trim($base, '._-');
     
        if (mb_strlen($base) < 3) {
            $base = 'u' . substr(hash('sha256', $email), 0, 6);
        }

        return $base;
    }

    public function crearUsuario(string $email, string $contrasena) {
        $logger = ServicioLogger::obtenerLogger();
        
        $userData = [
            'email' => $email,
            'username' => 'user' . substr(hash('sha256', $email), 0, 6),
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'password' => $contrasena,
        ];

        $usuarioPterodactyl = $this->request('/users', $userData, 'POST');

        if (!isset($usuarioPterodactyl['attributes'])) {
            $logger->error('Error creando usuario en Pterodactyl', [
                'email' => $email,
                'response' => $usuarioPterodactyl
            ]);
            return null;
        }

        $pterodactylIdUsuario = $usuarioPterodactyl['attributes']['uuid'];

        $logger->info('Usuario creado correctamente', [
            'pterodactyl_user_id' => $pterodactylIdUsuario
        ]);
        
        $clientKey = $this->crearClientApiKey($pterodactylIdUsuario);

        $logger->info('ClientKey generada', [
            'client_key' => $clientKey
        ]);

        return [
            'pterodactyl_id' => $pterodactylIdUsuario,
            'client_key' => $clientKey,
        ];
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