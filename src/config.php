<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error.log'); 

set_error_handler(function($severity, $message, $file, $line) {
    error_log("Error: [$severity] $message in $file on line $line");
    echo json_encode(["status" => "error", "message" => $message]);
});

set_exception_handler(function($exception) {
    error_log("Excepción: " . $exception->getMessage() . " en " . $exception->getFile() . " linea " . $exception->getLine());
    echo json_encode(["status" => "error", "message" => $exception->getMessage()]);
});

$HOST = 'db';
$BASE_DATOS = 'voxelHostingDB';
$USUARIO = 'user';
$CONTRASENA = 'pass123';

try {
    $conexion = new PDO("mysql:host=$HOST;dbname=$BASE_DATOS;charset=utf8", $USUARIO, $CONTRASENA);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    die("Conexión fallida: " . $exception->getMessage());
}
?>