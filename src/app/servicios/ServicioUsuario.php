<?php

class ServicioUsuario {
    private $repositorio;
    private $pterodactyl;

    public function __construct(RepositorioUsuario $repositorio, PterodactylAppApi $pterodactyl) {
        $this->repositorio = $repositorio;
        $this->pterodactyl = $pterodactyl;
    }

    public function crearUsuario($nombre, $email, $contrasena, $rol) {
        $this->pterodactyl->crearUsuario($nombre, $email, $contrasena);

        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $usuario = new ModeloUsuario($email, $contrasenaHash);
        $usuario->establecerNombre($nombre);
        $usuario->establecerRol($rol);
        
        return $this->repositorio->insertarUsuario($usuario, $contrasenaHash);
    }

    public function autenticar($email, $contrasena) {
        $datosUsuario = $this->repositorio->obtenerUsuarioPorEmail($email);
        
        if(!$datosUsuario || !Validar::contrasenaHash($contrasena, $datosUsuario['contrasena'])) {
            return null;
        }

        return $datosUsuario;
    }
}