<?php

class Validar {
    public static function mail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
   
    public static function contrasena($contrasena) {
        $CARACTERES_MINIMOS = 3;

        return strlen($contrasena) >= $CARACTERES_MINIMOS;
    }

    public static function contrasenaHash($contrasena, $hash) {
        return password_verify($contrasena, $hash);
    }
}