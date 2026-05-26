<?php

class ServicioServidor {
    private pterodactylClientApi $pterodactylCliente;
    private RepositorioServidor $repositorioServidor;
    private RepositorioUsuario $repositorioUsuario;

    public function __construct(pterodactylClientApi $pterodactylCliente,  RepositorioServidor $repositorioServidor, RepositorioUsuario $repositorioUsuario) {
        $this->pterodactylCliente = $pterodactylCliente;
        $this->repositorioServidor = $repositorioServidor;
        $this->repositorioUsuario = $repositorioUsuario;
    }

    public function obtenerServidoresPterodactyl(int $idUsuario) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        $servidoresPterodactyl = $this->pterodactylCliente->obtenerServidores($clientKey);
        $juegos = $this->repositorioServidor->obtenerJuegosServidores($idUsuario);

        $bdPorIdentifier = array_column($juegos, null, 'identifier');

        return array_map(function($servidor) use ($bdPorIdentifier) {
            $juegos = $bdPorIdentifier[$servidor['identifier']] ?? [];
            return array_merge($servidor, $juegos);
        }, $servidoresPterodactyl);
    }

    public function obtenerServidorPterodactyl(string $idServidor, int $idUsuario) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        $servidor = $this->pterodactylCliente->obtenerServidor($idServidor, $clientKey);
        $juego = $this->repositorioServidor->obtenerJuegoServidor($idUsuario, $servidor['identifier']);

        return array_merge($servidor, $juego ?? []);
    }
    
    public function obtenerRecursosServidorPterodactyl(int $id, int $idUsuario) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        return $this->pterodactylCliente->obtenerRecursosServidor($id, $clientKey);
    }

    public function subirMod(string $idServidor, int $idUsuario, string $modUrl) {
        $logger = ServicioLogger::obtenerLogger();
        
        $logger->info('Subir mod iniciado', [
            'server_id' => $idServidor,
            'user_id' => $idUsuario,
            'mod_url' => $modUrl
        ]);
        
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        $resultado = $this->pterodactylCliente->subirArchivoDesdeUrl($idServidor, $modUrl, '/mods', $clientKey);
        
        if ($resultado['success'] ?? false) {
            $logger->info('Mod subido correctamente', [
                'server_id' => $idServidor,
                'user_id' => $idUsuario
            ]);
        } else {
            $logger->error('Error al subir mod', [
                'server_id' => $idServidor,
                'user_id' => $idUsuario,
                'error' => $resultado['error'] ?? 'Error desconocido'
            ]);
        }
        
        return $resultado;
    }
}