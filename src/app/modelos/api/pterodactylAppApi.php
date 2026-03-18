<?php

class pterodactylAppApi {
    // private $applicationKey = 'ptla_uFRtsXT2S1Z3Sb3g5riseURlDxy8xcQGfeQWP0os9K6';

    public function __construct() {
        // $this->clientKey = $clientKey;
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

    private function crearClientApiKey($pterodactylUserId) {
        $memo = json_encode([
            'memo' => 'Generada automaticamente',
        ]);
        return $this->request("/users/$pterodactylUserId/api-keys", $memo, 'POST');
    }

    public function crearUsuarioPterodactyl($email, $nombreUsuario, $nombre, $apellido, $contrasena, $external_id) {
        $userData = [
            'email' => $email,
            'username' => $nombreUsuario,
            'first_name' => $nombre,
            'last_name' => $apellido,
            'password' => $contrasena,
            'external_id' => $external_id,
        ];

        $usuarioPterodactyl = $this->request('/users', $userData, 'POST');

        if (!isset($usuarioPterodactyl['attributes'])) {
            error_log('Error creando usuario: ' . json_encode($usuarioPterodactyl));
            return null;
        }

        $this->crearClientApiKey($usuarioPterodactyl['attributes']['id']);
    }
}

// Client Key: ptlc_d8128a5e9b400e73b9afdcd977f602040f2cb0982bc22294c0efffa8bd95fe5d217ed57dd61b812c
// Identifier: d8128a5e9b400e73
// EncryptedToken: eyJpdiI6ImZlS3R2VnB0aFlvR3F2a05wK25mY3c9PSIsInZhbHVlIjoiWHRXemhJQ0sxa0tiXC9xTUdsNm9pR0YyZ0tTWEZWVU5cL2tCNUpqXC9ERms2Qlo0QXl2NGJhKzdmYktDbnZFWGRuKzBrQVREWWptVWtPNGNreVZJREZpZmZheDZEK3dGWFBab3JTZWIwSElVNFE9IiwibWFjIjoiNDUwZTg4NDlmNTg1ZjczMmRhYjdkMTM0M2FkZGY1OTJiMWJjYmVhY2E2Y2Q4MTQ0ZTkzOTZmNjRlMTNkZjMxMSIsInRhZyI6IiJ9

//   $stmt = $pteroPdo->prepare("
        // INSERT INTO api_keys (user_id, key_type, identifier, token, memo, allowed_ips, created_at, updated_at)
        // VALUES (2, 0, 'd8128a5e9b400e73', 'eyJpdiI6ImZlS3R2VnB0aFlvR3F2a05wK25mY3c9PSIsInZhbHVlIjoiWHRXemhJQ0sxa0tiXC9xTUdsNm9pR0YyZ0tTWEZWVU5cL2tCNUpqXC9ERms2Qlo0QXl2NGJhKzdmYktDbnZFWGRuKzBrQVREWWptVWtPNGNreVZJREZpZmZheDZEK3dGWFBab3JTZWIwSElVNFE9IiwibWFjIjoiNDUwZTg4NDlmNTg1ZjczMmRhYjdkMTM0M2FkZGY1OTJiMWJjYmVhY2E2Y2Q4MTQ0ZTkzOTZmNjRlMTNkZjMxMSIsInRhZyI6IiJ9', 'Generada automaticamente', NULL, NOW(), NOW())
//     ");
//     $stmt->execute([$pterodactylUserId, $identifier, $encryptedToken]);