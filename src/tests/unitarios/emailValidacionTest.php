<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . "controladores/controladorAutenticar.php";

class emailValidacionTest extends TestCase {
    public function testEmailValido() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarEmail("usuariovalido@mail.com");
        $this->assertSame('', $resultado);
    }

    public function testEmailSinArroba() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarEmail("usuario.com");
        $this->assertSame('Introduzca un email valido', $resultado);
    }

    public function testEmailIncompleto() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarEmail("usuario@");
        $this->assertSame('Introduzca un email valido', $resultado);
    }

    public function testEmailVacio() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarEmail("");
        $this->assertSame('Introduzca un email valido', $resultado);
    }
}
