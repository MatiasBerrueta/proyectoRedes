<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . 'controladores/controladorAutenticar.php';
require_once APP_ROOT . 'modelos/modeloUsuario.php';
require_once APP_ROOT . 'database.php';

class registroIntegracionTest extends TestCase {
    protected function setUp(): void {
        $_SESSION = [];

        $pdo = (new Database())->getConexion();
        $pdo->exec("DELETE FROM USUARIO");
    }

    public function testRegistroExitoso() {
        $controlador = new controladorAutenticar();

        $_POST = [
            'nombre' => 'Juan',
            'email' => 'nuevo@mail.com',
            'contrasena' => 'contrasenaValida',
            'confirmarContrasena' => 'contrasenaValida'
        ];

        $controlador->registrarUsuario(
            $_POST['nombre'],
            $_POST['email'],
            $_POST['contrasena'],
            $_POST['confirmarContrasena'],
            "CLIENTE"
        );

        $pdo = (new Database())->getConexion();
        $stmt = $pdo->prepare("SELECT * FROM USUARIO WHERE email = 'nuevo@mail.com'");
        $stmt->execute();
        $usuario = $stmt->fetch();

        $this->assertNotEmpty($usuario, "El usuario debe existir en la BD");
    }

    public function testRegistroConEmailDuplicado() {
        $pdo = (new Database())->getConexion();
        $pdo->exec("
            INSERT INTO USUARIO (nombre, email, contrasena, pais)
            VALUES ('Juan', 'existente@mail.com', 'hash', 'Uruguay')
        ");

        $controlador = new controladorAutenticar();

        $_POST = [
            'nombre' => 'Pedro',
            'email' => 'existente@mail.com',
            'contrasena' => 'abc123',
            'confirmarContrasena' => 'abc123'
        ];

        $controlador->registrarUsuario(
            $_POST['nombre'],
            $_POST['email'],
            $_POST['contrasena'],
            $_POST['confirmarContrasena'],
            "Usuario"
        );

        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM USUARIO WHERE email = 'existente@mail.com'");
        $count = $stmt->fetch()['total'];

        $this->assertEquals(1, $count, "No debe crearse un usuario duplicado");
        $this->assertFalse(isset($_SESSION['email']), "No debe iniciar sesión si el email está duplicado");
    }

    public function testRegistroConEmailInvalido() {
        $controlador = new controladorAutenticar();

        $_POST = [
            'nombre' => 'Juan',
            'email' => 'usuario@',
            'contrasena' => 'abc123',
            'confirmarContrasena' => 'abc123'
        ];

        $controlador->registrarUsuario(
            $_POST['nombre'],
            $_POST['email'],
            $_POST['contrasena'],
            $_POST['confirmarContrasena'],
            'Usuario'
        );

        $pdo = (new Database())->getConexion();
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM USUARIO");
        $count = $stmt->fetch()['total'];

        $this->assertEquals(0, $count, "No debe crearse usuario con email inválido");
    }

    public function testRegistroConContrasenasDistintas() {
        $controlador = new controladorAutenticar();

        $_POST = [
            'nombre' => 'Juan',
            'email' => 'mail@mail.com',
            'contrasena' => 'abc123',
            'confirmarContrasena' => 'abc124'
        ];

        $controlador->registrarUsuario(
            $_POST['nombre'],
            $_POST['email'],
            $_POST['contrasena'],
            $_POST['confirmarContrasena'],
            'Usuario'
        );

        $pdo = (new Database())->getConexion();
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM USUARIO");
        $count = $stmt->fetch()['total'];

        $this->assertEquals(0, $count, "No debe crearse usuario con contraseñas distintas");
    }
}
