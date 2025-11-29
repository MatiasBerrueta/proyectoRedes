<?php
require_once APP_ROOT . 'modelos/modeloServidor.php';

class controladorServidor {
    public static function mostrarServidoresUsuario() {
        $servidores = modeloServidor::obtenerServidoresPterodactyl();

        foreach($servidores['data'] as $servidor) {
            // echo "<pre>";
            // print_r($servidor);
            // echo "</pre>";

            $identifier = $servidor['attributes']['identifier'];
            $nombre = $servidor['attributes']['name'];
            $idServidor = $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['ip'];
            $puertoServidor = $servidor['attributes']['relationships']['allocations']['data'][0]['attributes']['port'];

            include APP_ROOT . 'vistas/componentes/servidor.php';
        }
    }
}