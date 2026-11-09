<?php

require_once APP_ROOT . 'controladores/Controlador.php';

class ControladorJuego extends Controlador {
    private ServicioJuego $servicioJuego;

    public function __construct(ServicioJuego $servicioJuego) {
        $this->servicioJuego = $servicioJuego;
    }

    public function obtenerWebSocket(string $idServidor): void {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $websocket = $this->servicioJuego->obtenerWebSocket($idServidor, $idUsuario);

        echo json_encode($websocket);
    }

    public function listarArchivos(string $idServidor): void {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];
        $path = $_GET['path'] ?? '/';

        $archivos = $this->servicioJuego->obtenerArchivos($idServidor, $path, $idUsuario);

        header('Content-Type: application/json');
        echo json_encode($archivos,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function eliminarArchivos(string $idServidor): void {
        $this->requiereLogin();
        $idUsuario = $_SESSION['usuario']['id'];

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, true);

        $ruta = $data['ruta'] ?? '/';
        $archivos = $data['archivos'] ?? '';

        $this->servicioJuego->eliminarArchivos($idServidor, $idUsuario, $ruta, $archivos);
    }

    public function crearDirectorio(string $idServidor): void {
        $this->requiereLogin();
        header('Content-Type: application/json');

        $idUsuario = $_SESSION['usuario']['id'];

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, true);

        $ruta = $data['ruta'] ?? '/';
        $nombre = $data['nombre'] ?? '';

        $this->servicioJuego->crearDirectorio($idServidor, $idUsuario, $ruta, $nombre);
    }
}
