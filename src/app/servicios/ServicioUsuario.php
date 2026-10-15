<?php

class ServicioUsuario {
    private RepositorioUsuario $repositorio;
    private pterodactylAppApi $pterodactyl;

    public function __construct(RepositorioUsuario $repositorio, PterodactylAppApi $pterodactyl) {
        $this->repositorio = $repositorio;
        $this->pterodactyl = $pterodactyl;
    }

    public function crearUsuario(?string $nombre, string $email, string $contrasena, ?string $pais, RolUsuario $rol = RolUsuario::CLIENTE) {
        $logger = ServicioLogger::obtenerLogger();
        $usuarioExistente = $this->repositorio->obtenerUsuarioPorEmail($email);
        if($usuarioExistente) {
            $logger->error("Error al crear usuario, el usuario email ya existe");
            return null;
        }

        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $nuevoUsuario = new ModeloUsuario($email, $contrasenaHash);
        if(!is_null($nombre)) $nuevoUsuario->establecerNombre($nombre);
        if(!is_null($pais)) $nuevoUsuario->establecerPais($pais);
        $nuevoUsuario->establecerRol($rol);

        $this->repositorio->iniciarTransaccion();
        try {
            $this->repositorio->insertarUsuario($nuevoUsuario);
            
            $datosPterodactyl = $this->pterodactyl->crearUsuario($email, $contrasena);
            if (empty($datosPterodactyl['client_key']) || empty($datosPterodactyl['pterodactyl_id'])) {
                throw new RuntimeException('Pterodactyl no devolvió credenciales');
            }

            $nuevoUsuario->establecerClientKey($datosPterodactyl['client_key']);
            $nuevoUsuario->establecerIdUsuarioPterodactyl($datosPterodactyl['pterodactyl_id']);
            $this->repositorio->actualizarUsuario($nuevoUsuario);

            $this->repositorio->confirmarTransaccion();
            return $nuevoUsuario;
        } catch (Throwable $e) {
            $this->repositorio->revertirTransaccion();
            $logger->error("Error creando usuario, se revirtió el alta", [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    public function modificarUsuario(int $idUsuario, string $nombre, string $pais) {
        $datosUsuario = $this->repositorio->obtenerUsuarioPorId($idUsuario);

        if(!$datosUsuario) {
            $logger = ServicioLogger::obtenerLogger();
            $logger->error('No se encontro el usuario a modificar');

            return false;
        }

        $usuario = ModeloUsuario::desdeArrayDB($datosUsuario);

        $usuario->establecerNombre($nombre);
        // El email es unico para los usuarios cambiarlo asi nomas puede causar errores
        // $usuario->establecerEmail($email);
        $usuario->establecerPais($pais);

        $resultado = $this->repositorio->actualizarUsuario($usuario);

        return $resultado;
    }

    public function obtenerUsuario(string $idUsuario) {
        $usuario = $this->repositorio->obtenerUsuarioPorId($idUsuario);

        $logger = ServicioLogger::obtenerLogger();
        $logger->info("Datos usuario: ", $usuario);
        
        return $usuario;
    }

    public function autenticarUsuario(string $email, string $contrasena) {
        $datosUsuario = $this->repositorio->obtenerUsuarioPorEmail($email);
        
        if(!$datosUsuario || !Validar::contrasenaHash($contrasena, $datosUsuario['contrasena'])) {
            return null;
        }

        return $datosUsuario;
    }
}