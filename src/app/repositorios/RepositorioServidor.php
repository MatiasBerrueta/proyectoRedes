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

    public function obtenerJuegosServidores(int $idUsuario) {
        try {
            $query = "SELECT 
                        s.id_pterodactyl AS identifier, 
                        j.nombre AS nombre_juego,
                        v.nombre_variacion AS nombre_variacion,
                        j.descripcion AS descripcion_juego, 
                        v.egg_id, 
                        j.nest_id, 
                        j.imagen
                    FROM SERVIDOR s 
                    JOIN VARIACION_JUEGO v ON s.id_variacion = v.id_variacion 
                    JOIN JUEGO j ON v.id_juego = j.id_juego
                    WHERE s.id_usuario = :id_usuario;";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return null;
        }
    }

    public function obtenerJuegoServidor(int $idUsuario, string $idPterodactyl) {        
        try {
            $query = "SELECT s.id_pterodactyl AS identifier, 
                            j.nombre AS nombre_juego, 
                            vj.nombre_variacion AS nombre_variacion,
                            j.descripcion AS descripcion_juego, 
                            s.version_juego,
                            vj.egg_id, 
                            j.nest_id, 
                            j.imagen
                        FROM SERVIDOR s 
                        JOIN VARIACION_JUEGO vj ON s.id_variacion = vj.id_variacion 
                        JOIN JUEGO j ON vj.id_juego = j.id_juego
                        WHERE s.id_usuario = :id_usuario 
                        AND s.id_pterodactyl = :id_pterodactyl;";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_pterodactyl', $idPterodactyl, PDO::PARAM_INT);   
            
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                error_log("No se encontró el juego");
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            throw $exception;
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