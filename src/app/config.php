<?php
define("APP_ROOT", dirname(__DIR__) . '/app/');
define("PUBLIC_ROOT", dirname(__DIR__) . '/public/');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', APP_ROOT . '../logs/php_error_' . date('Y-m-d') . '.log');