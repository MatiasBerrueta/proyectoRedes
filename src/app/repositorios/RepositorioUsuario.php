<?php

require_once APP_ROOT . 'repositorios/Repositorio.php';

class RepositorioUsuario extends Repositorio {
    private PDO $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function insertarUsuario(ModeloUsuario $usuario) {
        $logger = ServicioLogger::obtenerLogger();

        try {
            $query = "CALL ESC_AGREGAR_USUARIO(:nombre, :email, :contrasena, :pais)";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindValue(':nombre', $usuario->obtenerNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $usuario->obtenerEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', $usuario->obtenerContrasena(), PDO::PARAM_STR);
            $stmt->bindValue(':pais', $usuario->obtenerPais(), PDO::PARAM_STR);

            $resultado = $stmt->execute();

            if ($resultado) {
                $fila = $stmt->fetch(PDO::PARAM_INT);
                $idGenerado = (int) $fila['id_usuario'];

                $usuario->establecerId($idGenerado);
                $logger->info("Usuario_id: " . $usuario->obtenerId());

                $stmt->closeCursor();

                return true;
            }

            return false;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            throw $exception;
        }
    }

    public function obtenerUsuarioPorId(int $idUsuario) {
        try {
            $query = "SELECT * FROM USUARIO WHERE id_usuario = :id_usuario";
            $stmt = $this->conexion->prepare($query);

            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_STR);
            $stmt->execute();

            $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

            return $datosUsuario;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            throw $exception;
        }
    }

    public function obtenerUsuarioPorEmail(string $email) {
        $query = "SELECT id_usuario, nombre, email, contrasena, rol, client_key FROM USUARIO WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $datosUsuario;
    }

    public function obtenerClientKey(int $idUsuario) {
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

    public function actualizarUsuario(ModeloUsuario $usuario): bool {
        try {
            $query = "UPDATE USUARIO SET
                        nombre = :nombre,
                        email = :email,
                        contrasena = :contrasena,
                        rol = :rol,
                        pais = :pais,
                        -- notificaciones_activas = :notificacionesActivas,
                        estado = :estado,
                        client_key = :client_key,
                        id_pterodactyl = :id_pterodactyl
                    WHERE id_usuario = :id";

            $stmt = $this->conexion->prepare($query);

            $stmt->bindValue(':id', $usuario->obtenerId(), PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $usuario->obtenerNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $usuario->obtenerEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', $usuario->obtenerContrasena(), PDO::PARAM_STR);
            $stmt->bindValue(':rol', $usuario->obtenerRol()->value, PDO::PARAM_STR);
            $stmt->bindValue(':pais', $usuario->obtenerPais(), PDO::PARAM_STR);
            // $stmt->bindValue(':notificacionesActivas', $usuario->obtenerNotificacionesActivas(), PDO::PARAM_INT);
            $stmt->bindValue(':estado', $usuario->obtenerEstado()->value, PDO::PARAM_STR);
            $stmt->bindValue(':client_key', $usuario->obtenerClientKey(), PDO::PARAM_STR);
            $stmt->bindValue(':id_pterodactyl', $usuario->obtenerIdUsuarioPterodactyl(), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            throw $exception;
        }
    }

    public function eliminarUsuarioEmail(string $email) {
        $query = "DELETE FROM USUARIO WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
