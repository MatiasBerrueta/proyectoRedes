<?php
class modeloUsuario {
    private $conexion;

    private $idUsuario;
    private $nombre;
    private $email;
    private $telefono;
    private $region;
    private $localidad;
    private $direccion;
    private $temaVisual;
    private $notificacionesActivas;
    private $rol;
    private $estado;

    public function __construct($idUsuario, $nombre, $email, $db) {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->conexion = $db;
    }

    public function modificarNombre($nuevoNombre) {
        $this->nombre = $nuevoNombre;

        $query = "UPDATE usuarios SET nombre = :nombre WHERE idUsuario = :idUsuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':idUsuario', $this->idUsuario);

        return $stmt->execute();
    }

    public function modificarTelefono($nuevoTelefono) {
        $this->telefono = $nuevoTelefono;

        $query = "UPDATE usuarios SET telefono = :telefono WHERE idUsuario = :idUsuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':idUsuario', $this->idUsuario);

        return $stmt->execute();
    }

    public function modificarRegion($nuevaRegion) {
        $this->region = $nuevaRegion;

        $query = "UPDATE usuarios SET region = :region WHERE idUsuario = :idUsuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':region', $this->region);
        $stmt->bindParam(':idUsuario', $this->idUsuario);

        return $stmt->execute();
    }

    public function modificarLocalidad($nuevaLocalidad) {
        $this->localidad = $nuevaLocalidad;

        $query = "UPDATE usuarios SET localidad = :localidad WHERE idUsuario = :idUsuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':localidad', $this->localidad);
        $stmt->bindParam(':idUsuario', $this->idUsuario);

        return $stmt->execute();
    }

    public function modificarContrasena($contrasenaActual, $contrasenaNueva, $modeloAutenticar) {
        if(!$modeloAutenticar->autenticarContrasena($this->idUsuario, $contrasenaActual)) return false;

        $contrasenaNuevaHasehada = password_hash($contrasenaNueva, PASSWORD_BCRYPT);
        $query = "UPDATE usaurios SET contrasena = :hash WHERE idUsuario = :idUsuario";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':hash', $contrasenaNuevaHasehada);
        $stmt->bindParam(':idUsuario', $this->idUsuario);
        
        return $stmt->execute();
    }
}
?>