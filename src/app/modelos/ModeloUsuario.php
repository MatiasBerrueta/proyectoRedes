<?php
enum RolUsuario: string {
    case CLIENTE = 'CLIENTE';
    case ADMIN = 'ADMIN';
}

enum TemaVisual: string {
    case CLARO = 'CLARO';
    case OSCURO = 'OSCURO';
    case SISTEMA = 'SISTEMA';
}

enum EstadoUsuario: string {
    case ACTIVO = 'ACTIVO';
    case INACTIVO = 'INACTIVO';
}

class ModeloUsuario {
    private ?int $idUsuario = null;
    private ?string $nombre = null;
    private string $email;
    private string $contrasena;
    private RolUsuario $rol = RolUsuario::CLIENTE;
    private ?string $pais = null;
    private TemaVisual $temaVisual = TemaVisual::SISTEMA;
    private bool $notificacionesActivas = true;
    private EstadoUsuario $estado = EstadoUsuario::ACTIVO;
    private ?string $clientKey = null;
    // devuelve string porque es un UUID
    // UUID es un hexadecimal de 32 digitos y 4 guiones organizados en cinco grupos
    private ?string $idUsuarioPterodactyl = null;


    public function __construct(string $email, string $contrasena) {
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public static function desdeArrayDB(array $usuarioArray): self {
        $usuario = new self($usuarioArray['email'], $usuarioArray['contrasena']);

        $usuario->establecerId($usuarioArray['id_usuario']);
        $usuario->establecerNombre($usuarioArray['nombre']);
        $usuario->establecerRol(RolUsuario::from($usuarioArray['rol']));
        $usuario->establecerPais($usuarioArray['pais']);
        $usuario->establecerEstado(EstadoUsuario::from($usuarioArray['estado']));
        $usuario->establecerClientKey($usuarioArray['client_key']);
        $usuario->establecerIdUsuarioPterodactyl($usuarioArray['id_pterodactyl']);

        return $usuario;
    }

    public function obtenerId(): ?int {
        return $this->idUsuario;
    }

    public function obtenerNombre(): ?string {
        return $this->nombre;
    }

    public function obtenerEmail(): string {
        return $this->email;
    }

    public function obtenerRol(): RolUsuario {
        return $this->rol;
    }

    public function obtenerPais(): ?string {
        return $this->pais;
    }

    public function obtenerContrasena(): string {
        return $this->contrasena;
    }

    public function obtenerTema(): TemaVisual {
        return $this->temaVisual;
    }

    public function obtenerNotificacionesActivas(): bool {
        return $this->notificacionesActivas;
    }

    public function obtenerEstado(): EstadoUsuario {
        return $this->estado;
    }

    public function obtenerClientKey(): ?string {
        return $this->clientKey;
    }

    public function obtenerIdUsuarioPterodactyl(): ?string {
        return $this->idUsuarioPterodactyl;
    }

    public function establecerId(int $idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function establecerNombre(?string $nombre) {
        $this->nombre = $nombre;
    }

    public function establecerPais(?string $pais) {
        $this->pais = $pais;
    }

    public function establecerContrasena(string $contrasena) {
        $this->contrasena = password_hash($contrasena, PASSWORD_BCRYPT);
    }

    public function establecerRol(RolUsuario $rol) {
        $this->rol = $rol;
    }

    public function establecerEstado(EstadoUsuario $estado) {
        $this->estado = $estado;
    }

    public function establecerClientKey(?string $clientKey) {
        $this->clientKey = $clientKey;
    }

    public function establecerIdUsuarioPterodactyl(?string $idUsuarioPterodactyl) {
        $this->idUsuarioPterodactyl = $idUsuarioPterodactyl;
    }
}