<?php
define('BASE_PATH', __DIR__);

ini_set('display_errors', 0);
ini_set('log_errors', 1);

ini_set('error_log', BASE_PATH . '/logs/php_error.log'); 

error_reporting(E_ALL);
