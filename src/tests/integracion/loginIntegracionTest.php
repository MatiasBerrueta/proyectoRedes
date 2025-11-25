<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . 'controladores/controladorAutenticar.php';
require_once APP_ROOT . 'modelos/modeloUsuario.php';
require_once APP_ROOT . 'database.php';

class loginIntegracionTest extends TestCase
{
    protected function setUp(): void {
        $_SESSION = [];

        $pdo = (new Database())->getConexion();

        $hash = password_hash("contrasenaValida", PASSWORD_BCRYPT);
        $pdo->exec("DELETE FROM USUARIO WHERE email = 'prueba@mail.com'");

        $pdo->exec("
            INSERT INTO USUARIO (nombre, email, contrasena, pais)
            VALUES ('Tester', 'prueba@mail.com', '$hash', 'Uruguay')
        ");
    }

    public function testLoginExitoso() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->iniciarSesion("prueba@mail.com", "contrasenaValida");

        $this->assertTrue($resultado['ok']);
        $this->assertTrue(isset($_SESSION['usuario']));
        $this->assertEquals("prueba@mail.com", $_SESSION['usuario']['email']);
    }

    public function testLoginFallidoConContrasenaIncorrecta() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->iniciarSesion("prueba@mail.com", "123123");

        $this->assertFalse($resultado['ok']);
        $this->assertEquals("Credenciales incorrectas", $resultado['mensaje']);
        $this->assertFalse(isset($_SESSION['usuario']));
    }

    public function testLoginConEmailInexistente() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->iniciarSesion("noexiste@mail.com", "contrasenaValida");

        $this->assertFalse($resultado['ok']);
        $this->assertEquals("El usuario no existe", $resultado['mensaje']);
        $this->assertFalse(isset($_SESSION['usuario']));
    }
}
