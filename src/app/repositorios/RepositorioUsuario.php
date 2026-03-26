<?php

class RepositorioUsuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertarUsuario(ModeloUsuario $usuario) {
        try {
            $query = "CALL ESC_AGREGAR_USUARIO(:nombre, :email, :contrasena, :pais, :rol)";
            $stmt = $this->conexion->prepare($query);
    
            $stmt->bindParam(':nombre', $usuario->obtenerNombre(), PDO::PARAM_STR);
            $stmt->bindParam(':email', $usuario->obtenerEmail(), PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $usuario->obtenerContrasena(), PDO::PARAM_STR);
            $stmt->bindParam(':pais', $usuario->obtenerPais(), PDO::PARAM_STR);
            $stmt->bindParam(':rol', $usuario->obtenerRol(), PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerUsuarioPorEmail($email) {
        $query = "SELECT id_usuario, nombre, email, contrasena, rol, client_key FROM USUARIO WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datosUsuario;
    }

    public function obtenerClientKey($idUsuario) {
        $query = "SELECT client_key FROM USUARIO WHERE id_usuario = :idUsuario";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['client_key'] ?? null;
    }

    public function obtenerUsuarios() {
        $query = "SELECT id_usuario, nombre, email, contrasena, rol FROM USUARIO";
        $stmt = $this->conexion->prepare($query);

        $stmt->execute();

        $datosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datosUsuario;
    }

    public function actualizarUsuario(ModeloUsuario $usuario) {
        $query = "UPDATE USUARIO SET :nombre, :email, :contrasena, :rol, :pais, :temaVisual, :notificacionesActivas, :estado WHERE id_usaurio = ". $usuario->obtenerId();
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':nombre', $usuario->obtenerNombre(), PDO::PARAM_STR);
        $stmt->bindParam(':email', $usuario->obtenerEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $usuario->obtenerContrasena(), PDO::PARAM_STR);
        $stmt->bindParam(':pais', $usuario->obtenerPais(), PDO::PARAM_STR);
        $stmt->bindParam(':temaVisual', $usuario->obtenerTema(), PDO::PARAM_STR);
        $stmt->bindParam(':notificacionesActivas', $usuario->obtenerNotificaciones(), PDO::PARAM_STR);
        $stmt->bindParam(':estado', $usuario->obtenerEstado(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function eliminarUsuarioEmail($email) {
        $query = "DELETE USUARIO WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        return $stmt->execute();
    }
}