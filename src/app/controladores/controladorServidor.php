<?php
require_once APP_ROOT . 'modelos/modeloServidor.php';

class controladorServidor {
    public static function mostrarServidoresUsuario() {
        $servidores = modeloServidor::obtenerServidoresPterodactyl();

        if(is_null($servidores)) {
            $identifier = '1a';
            $nombre = 'Servidor muestra';
            $ipServidor = '192.168.0.1';
            $puertoServidor = '25565';

            include APP_ROOT . 'vistas/componentes/servidor.php';
        }

        foreach($servidores['data'] as $servidor) {
            $identifier = $servidor['attributes']['identifier'];
            $nombre = $servidor['attributes']['name'];
            $ipServidor = $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['ip'];
            $puertoServidor = $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['port'];
            $recursosServidor = modeloServidor::obtenerRecursosServidorPterodactyl($identifier);

            $estado = $recursosServidor['attributes']['current_state'];
            $numeroJugadores = 0;
            $maximoNumeroJugadores = 20;
            $usoCpu = $recursosServidor['attributes']['resources']['cpu_absolute'];
            $maximoUsoCpu = $servidor['attributes']['limits']['cpu'];
            $usoRam = $recursosServidor['attributes']['resources']['memory_bytes'];
            $maximoUsoRam = $servidor['attributes']['limits']['memory'];
            $usoDisco = $recursosServidor['attributes']['resources']['disk_bytes'];
            $maximosUsoDisco = $servidor['attributes']['limits']['disk'];

            include APP_ROOT . 'vistas/componentes/servidor.php';
        }
    }

    public function mostrarContenidoServidor($idServidor) {
        include APP_ROOT . 'vistas/componentes/servidorContenido.php';
    }
}