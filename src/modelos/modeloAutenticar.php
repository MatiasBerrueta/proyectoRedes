<?php

class modeloAutenticar {
    private $conexion;

    public function crearUsuario($nombre, $email, $contrasenaHasheada) {
        $query = "INSERT INTO usuario (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $contrasenaHasheada);

        return $stmt->execute();
    }

    public function obtenerUsuarioPorEmail($email) {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':email', $email);

        $stmt->execute();
        $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $datosUsuario;
    }
}