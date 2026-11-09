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

    public function obtenerDirectorios(string $servidorId, string $path, string $clientKey): array {
        $content = $this->pterodactylCliente->obtenerDirectorios($servidorId, $path, $clientKey);

        return $content;
    }

    public function servidorTieneArchivo(string $idServidorPterodactyl, string $idUsuario, string $ruta, string $nombre) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);
        $archivos = $this->obtenerDirectorios($idServidorPterodactyl, $ruta, $clientKey);

        foreach($archivos['data'] as $archivo) {
            if($archivo['attributes']['is_file'] && $archivo['attributes']['name'] === $nombre) return true;
        }

        return false;
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

    public function modificarArchivo(string $idServidorPterodactyl, int $idUsuario, string $ruta, string $nombre, string $contenido = "") {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);

        $rutaCompleta = $this->unirRuta($ruta, $nombre);

        $this->pterodactylCliente->escribirArchivo($idServidorPterodactyl, $clientKey, $rutaCompleta, $contenido);
    }

    public function descargarArchivo(string $idServidorPterodactyl, int $idUsuario, string $ruta, string $nombre, string $contenido = "") {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);

        $rutaCompleta = $this->unirRuta($ruta, $nombre);

        return $this->pterodactylCliente->descargarArchivo($idServidorPterodactyl, $clientKey, $rutaCompleta);
    }

    public function subirArchivo(string $idServidorPterodactyl, int $idUsuario, string $ruta, string $rutaTemporal, string $nombreArchivo) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);

        $resultado = $this->pterodactylCliente->subirArchivo(
            $idServidorPterodactyl,
            $ruta,
            $rutaTemporal,
            $clientKey,
            $nombreArchivo
        );

        if (!($resultado['success'] ?? false)) {
            throw new Exception($resultado['error'] ?? 'Error desconocido al subir el archivo.');
        }

        return $resultado;
    }

    public function renombrarArchivo(string $idServidorPterodactyl, int $idUsuario, string $ruta, string $nombreViejo, string $nombreNuevo) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);

        $this->pterodactylCliente->renombrarArcihvo($idServidorPterodactyl, $clientKey, $ruta, $nombreViejo, $nombreNuevo);
    }

    public function moverArchivo(string $idServidorPterodactyl, int $idUsuario, string $ruta, string $nombre, string $destino) {
        $clientKey = $this->repositorioUsuario->obtenerClientKey($idUsuario);

        $directorioDestino = str_starts_with($destino, '/')
            ? $destino
            : $this->unirRuta($ruta, $destino);

        $rutaOrigen = $this->unirRuta($ruta, $nombre);
        $rutaDestino = $this->unirRuta($directorioDestino, $nombre);

        if ($rutaOrigen === $rutaDestino) {
            return;
        }

        $this->pterodactylCliente->renombrarArcihvo($idServidorPterodactyl, $clientKey, '/', $rutaOrigen, $rutaDestino);
    }

    private function unirRuta(string $directorio, string $nombre): string {
        $directorio = '/' . trim(str_replace('\\', '/', $directorio), '/');
        $nombre = ltrim(str_replace('\\', '/', $nombre), '/');

        if ($directorio === '/') {
            return '/' . $nombre;
        }

        return $directorio . '/' . $nombre;
    }
}
