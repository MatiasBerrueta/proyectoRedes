<?php
require_once APP_ROOT . 'database.php';

class modeloServidor {
    private $idServidor;
    private $nombre;
    private $dominio;
    private $puerto;
    private $estado;
    private $reglas;
    private $ultimoLog;
    private $videojuego;
    
    public function __construct() {

    }

    public function insertarServidor() {
        return;
    }

    public static function obtenerServidor($idServidor) {
        return [];
    }

    public static function obtenerServidores() {
        $db = new Database();
        $conexion = $db->getConexion();

        $query = "SELECT nombre, dominio, puerto, estado, id_videojuego FROM USUARIO";
        $stmt = $conexion->prepare($query);

        $stmt->execute();

        $datosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($datosUsuario) {
            return $datosUsuario;
        } else {
            return null;
        }
    }

    public static function obtenerServidoresPterodactyl() {
        $ch = curl_init();
        
        $url = "http://172.17.0.1:80/api/application/servers";

        $headers = [
            "Authorization: Bearer ptla_uFRtsXT2S1Z3Sb3g5riseURlDxy8xcQGfeQWP0os9K6",
            "Accept: Application/vnd.pterodactyl.v1+json"
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,  // Devuelve la respuesta en lugar de imprimirla
            CURLOPT_HTTPHEADER => $headers,  // Headers personalizados
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "Error en cURL: " . curl_error($ch);
        } else {
            // Obtener el código de respuesta HTTP (opcional)
            // $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // echo "Código HTTP: $http_code\n";
            // echo "Respuesta:\n$response";
            $servidores = json_decode($response, true);
        }

        // Cerrar cURL
        curl_close($ch);

        // echo "<pre>";
        // print_r($servidores);
        // echo "</pre>";

        foreach($servidores['data'] as $servidor) {
            echo "<pre>";
            // print_r($servidor['attributes']);
            echo "Id: " . $servidor['attributes']['id'] . "\n";
            echo "Nombre: " . $servidor['attributes']['name'] . "\n";
            echo "Descripcion: " . $servidor['attributes']['description'] . "\n";
            echo "Estatus: " . $servidor['attributes']['status'] . "\n";
            echo "</pre>";
        }
    }

    public function modificarServidor() {
        return;
    }

    public function borrarServidor() {
        return;
    }

    public function obtenerIdServidor() {
        return $this->idServidor;
    }

    public function establecerIdServidor($nuevoIdServidor) {
        $this->idServidor = $nuevoIdServidor;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function establecerNombre($nuevoNombre) {
        $this->nombre = $nuevoNombre;
    }

    public function obtenerDominio() {
        return $this->dominio;
    }

    public function establecerDominio($nuevoDominio) {
        $this->dominio = $nuevoDominio;
    }

    public function obtenerPuerto() {
        return $this->puerto;
    }

    public function establecerPuerto($nuevoPuerto) {
        $this->puerto = $nuevoPuerto;
    }

    public function obtenerEstado() {
        return $this->estado;
    }

    public function establecerEstado($nuevoEstado) {
        $this->estado = $nuevoEstado;
    }

    public function obtenerReglas() {
        return $this->reglas;
    }

    public function establecerReglas($nuevoReglas) {
        $this->reglas = $nuevoReglas;
    }

    public function obtenerVideojuego() {
        return $this->videojuego;
    }

    public function establecerVideojuego($nuevoVideojuego) {
        $this->videojuego = $nuevoVideojuego;
    }
}