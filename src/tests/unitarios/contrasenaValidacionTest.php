<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . "controladores/controladorAutenticar.php";

class contrasenaValidacionTest extends TestCase {
    public function testContrasenaValida() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarContrasena("contrasenaValida");

         $this->assertSame("", $resultado);
    }

    public function testContrasenaCorta() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarContrasena("contra");

        $this->assertSame("La contrasena tiene que tener mas de 12 caracteres", $resultado);
    }

     public function testContrasenaMinima() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarContrasena("contrasena12");

         $this->assertSame("", $resultado);
    }

     public function testContrasenaVacia() {
        $controlador = new controladorAutenticar();
        $resultado = $controlador->validarContrasena("");

        $this->assertSame("La contrasena tiene que tener mas de 12 caracteres", $resultado);
    }
}
