<?php
use PHPUnit\Framework\TestCase;
require_once APP_ROOT . 'controladores/controladorAutenticar.php';

class logoutIntegracionTest extends TestCase {
    public function testLogoutExitoso() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = ['email' => 'algo@mail.com'];

        $controlador = new controladorAutenticar();
        $controlador->cerrarSesion();

        $this->assertEmpty($_SESSION, "La sesión debe eliminarse correctamente");
    }

    public function testLogoutSinSesionActiva() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];

        $controlador = new controladorAutenticar();
        $controlador->cerrarSesion();

        $this->assertEmpty($_SESSION, "Debe seguir sin sesión y sin errores");
    }
}
