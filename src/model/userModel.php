<?php
class usuario {
    private $conexion;

    public $id;
    public $nombre;
    public $email;
    public $contrasenaPlana;
    public $contrasenaHasheada;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function crearUsuario() {
        $query = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
        $stmt = $this->conexion->prepare($query);

        // sanitizar datos del usuario, se eliminan tags de html y convierte caracteres especiales en entidades html
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contrasenaHasheada = password_hash($this->contrasenaPlana, PASSWORD_BCRYPT);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contrasena', $this->contrasenaHasheada);

        return $stmt->execute();
    }

    public function autenticarUsuario() {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conexion->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':email', $this->email);

        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($usuario && password_verify($this->contrasenaPlana, $usuario['contrasena'])) {
            return $usuario;
        } else {
            return false;
        }
    }
}
?>