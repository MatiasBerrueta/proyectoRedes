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

    public function obtenerServidorPterodactyl(int $idServidor, int $idUsuario) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        $servidor = $this->pterodactylCliente->obtenerServidor($idServidor, $clientKey);
        $juego = $this->repositorioServidor->obtenerJuegoServidor($idUsuario, $servidor['identifier']);

        return array_merge($servidor, $juego ?? []);
    }
    
    public function obtenerRecursosServidorPterodactyl(int $id, int $idUsuario) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        return $this->pterodactylCliente->obtenerRecursosServidor($id, $clientKey);
    }
}