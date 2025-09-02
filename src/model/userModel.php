<?php
class usuario {
    private $conexion;

    private $nombre;
    private $email;
    private $contrasenaHasheada;

    public function __construct($email, $contrasenaPlana, $db) {
        // sanitizar datos del usuario, se eliminan tags de html y convierte caracteres especiales en entidades html
        $this->email = htmlspecialchars(strip_tags($email));
        $this->contrasenaHasheada = password_hash($contrasenaPlana, PASSWORD_BCRYPT);
        $this->conexion = $db;
    }

    public function crearUsuario() {
        $query = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contrasena', $this->contrasenaHasheada);

        return $stmt->execute();
    }

    public function autenticarUsuario($contrasenaPlana) {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $stmt->bindParam(':email', $this->email);

        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($usuario && password_verify($contrasenaPlana, $usuario['contrasena'])) {
            return $usuario;
        } else {
            return false;
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->nombre;
    }

    public function getContrasena() {
        return $this->nombre;
    }
}
?>