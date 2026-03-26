<?php

class RepositorioServidor {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerServidores() {
        $query = "SELECT nombre, dominio, puerto, estado, id_videojuego FROM USUARIO";
        $stmt = $this->conexion->prepare($query);

        $stmt->execute();

        $datosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($datosUsuario) {
            return $datosUsuario;
        } else {
            return null;
        }
    }

    public function obtenerJuegosServidores($idUsuario) {
        try {
            $query = "SELECT s.id_pterodactyl as identifier, 
                    v.nombre as nombre_juego, 
                    v.descripcion as descripcion_juego, 
                    v.egg_id, 
                    v.nest_id, 
                    v.nombre_grupo,
                    v.imagen
                    FROM SERVIDOR s JOIN VIDEOJUEGO v ON s.id_videojuego = v.id_videojuego 
                    WHERE s.id_usuario = :id_usuario";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return null;
        }
    }

    public function obtenerJuegoServidor($idUsuario, $idServidor) {
        try {
            $query = "SELECT s.id_pterodactyl as identifier, 
                    v.nombre as nombre_juego, 
                    v.descripcion as descripcion_juego, 
                    v.egg_id, 
                    v.nest_id, 
                    v.nombre_grupo,
                    v.imagen
                    FROM SERVIDOR s JOIN VIDEOJUEGO v ON s.id_videojuego = v.id_videojuego 
                    WHERE s.id_usuario = :id_usuario AND s.id_servidor = :id_servidor";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_servidor', $idServidor, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return null;
        }
    }

    public function insertarServidor() {
        return;
    }

    public static function obtenerServidor($idServidor) {
        return [];
    }

    public function modificarServidor() {
        return;
    }

    public function borrarServidor() {
        return;
    }
}