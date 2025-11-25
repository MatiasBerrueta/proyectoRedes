<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . "controladores/controladorAutenticar.php";

class confirmarContrasenaValidacionTest extends TestCase {
    public function testCoinciden() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarConfirmacion("contrasenaValida", "contrasenaValida");

        $this->assertSame("", $resultado);
    }

    public function testNoCoinciden() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarConfirmacion("contrasenaValida1", "contrasenaValida2");

        $this->assertSame("Las contrasenas no coinciden", $resultado);
    }
}