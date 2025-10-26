<?php
class modeloUsuario {
    private $id_usuario;
    private $nombre;
    private $email;
    private $contrasena;
    private $rol;
    private $pais;
    private $temaVisual;
    private $notificacionesActivas;
    private $estado;

    public function __construct($email, $contrasena) {
        $this->email = $email;
        $this->contrasena = $contrasena;
    }

    public function obtenerId() {
        return $this->id_usuario;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function obtenerEmail() {
        return $this->email;
    }

    public function obtenerRol() {
        return $this->rol;
    }

    public function obtenerContrasena() {
        return $this->contrasena;
    }

    public function establecerNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function establecerPais($pais) {
        $this->pais = $pais;
    }

    public function establecerContrasena($contrasenaActual, $contrasenaNueva, $modeloAutenticar) {

    }

    public function establecerRol($rol) {
        $this->rol = $rol;
    }

    public function insertarUsuario($rol) {
        $db = new Database();
        $conexion = $db->getConexion();

        if(!in_array($rol, ["ADMIN", "CLIENTE"])) {
            return null;
        }

        $query = "INSERT INTO USUARIO (nombre, email, contrasena, rol) VALUES (:nombre, :email, :contrasena, :rol)";
        // $query = 'CALL AGREGAR_USUARIO(:nombre, :email, :contrasena, uruguay)';
        $stmt = $conexion->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $this->contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $this->id_usuario = $conexion->lastInsertId();

        if($stmt->execute()) {
            $conexion = null;
            return true;
        } else {
            $conexion = null;
            return null;
        }
    }
}
?>