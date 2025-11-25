<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . '/modelos/modeloUsuario.php';

class insertarUsuarioTest extends TestCase {
    private function borrarUsuarioEmail($email) {
        $pdo = new Database();
        $conexion = $pdo->getConexion();

        $query = "DELETE FROM USUARIO WHERE email = :email;";

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function testInsertarUsuario() {
        $email = "email@mail.com";
        $this->borrarUsuarioEmail($email);

        $modelo = new modeloUsuario($email, password_hash("contrasenaValida", PASSWORD_BCRYPT));

        $modelo->establecerNombre("Test");
        $modelo->establecerPais("Uruguay");

        $resultado = $modelo->insertarUsuario();

        $this->assertTrue($resultado);
    }

    public function testInsertarUsuarioDuplicado() {
        $email = "duplicado@mail.com";
        $this->borrarUsuarioEmail($email);

        $m1 = new modeloUsuario($email, password_hash("contrasenaValida", PASSWORD_BCRYPT));
        $m1->insertarUsuario();

        $m2 = new modeloUsuario($email, password_hash("contrasenaValida", PASSWORD_BCRYPT));
        $resultado = $m2->insertarUsuario();

        $this->assertFalse($resultado);
    }
}
