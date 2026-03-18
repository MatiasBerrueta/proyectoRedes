<?php
require_once APP_ROOT . 'modelos/modeloServidor.php';

class controladorServidor {
    public static function mostrarServidoresUsuario() {
        $servidores = modeloServidor::obtenerServidoresPterodactyl();

        $eggJuegos = [
            1 => 'minecraft',
        ];

        // solo para pruebas sin tener que abrir pterodactyl, borrar esto para version final.
        if (is_null($servidores)) {
            $identifier = '1a';
            $nombre = 'Servidor muestra 1';
            $ipServidor = '192.168.0.1';
            $puertoServidor = '25565';
            $estado = 'Offline';
            $numeroJugadores = 1;
            $maximoNumeroJugadores = 20;
            $usoCpu = 5;
            $maximoUsoCpu = 100;
            $usoRam = 1024 * 100000;
            $maximoUsoRam = 1024;
            $juego = 'terraria';

            include APP_ROOT . 'vistas/componentes/servidor.php';

            $identifier = '2b';
            $nombre = 'Servidor muestra 2';
            $ipServidor = '192.168.0.2';
            $puertoServidor = '25566';
            $estado = 'Online';
            $numeroJugadores = 8;
            $maximoNumeroJugadores = 50;
            $usoCpu = 25;
            $maximoUsoCpu = 100;
            $usoRam = 2048 * 100000;
            $maximoUsoRam = 4096;
            $juego = 'minecraft';

            include APP_ROOT . 'vistas/componentes/servidor.php';

            $identifier = '3c';
            $nombre = 'Servidor muestra 3';
            $ipServidor = '192.168.0.3';
            $puertoServidor = '27015';
            $estado = 'Online';
            $numeroJugadores = 12;
            $maximoNumeroJugadores = 32;
            $usoCpu = 40;
            $maximoUsoCpu = 100;
            $usoRam = 3072 * 100000;
            $maximoUsoRam = 8192;
            $juego = 'cs2';

            include APP_ROOT . 'vistas/componentes/servidor.php';

            // incluir un mensaje asi para version final.
            // echo "Todavia no creaste ningun servidor (boton) Empezar Ahora (boton)"
        } else {
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
                $juego = 'minecraft';
    
                include APP_ROOT . 'vistas/componentes/servidor.php';
            }
        }

    }

    public function mostrarContenidoServidor($idServidor) {
        include APP_ROOT . 'vistas/componentes/servidorContenido.php';
    }
}