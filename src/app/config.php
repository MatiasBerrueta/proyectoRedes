<?php
define("APP_ROOT", dirname(__DIR__) . '/app/');
define("PUBLIC_ROOT", dirname(__DIR__) . '/public/');

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once APP_ROOT . 'servicios/ServicioLogger.php';

$ruta_logs = APP_ROOT . '../logs';
$logger = ServicioLogger::init($ruta_logs);