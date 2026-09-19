<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class ServicioLogger {
    private static ?Logger $logger = null;

    public static function init(string $logDir): Logger {
        if (self::$logger === null) {
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }

            $handler = new RotatingFileHandler($logDir . '/app.log', 30, Logger::DEBUG);

            $format = "[%datetime%] %level_name%: %message% %context% %extra%\n";
            $formatter = new LineFormatter($format, "Y-m-d H:i:s");
            $handler->setFormatter($formatter);

            
            self::$logger = new Logger('hosting');
            self::$logger->pushHandler($handler);
            
            $stderr = new StreamHandler('php://stderr', Logger::DEBUG);
            $stderr->setFormatter($formatter);
            self::$logger->pushHandler($stderr);

            self::vincularErroresPHP(self::$logger);
        }

        if (!is_dir($logDir) && !mkdir($logDir, 0755, true) && !is_dir($logDir)) {
            error_log("ServicioLogger: no se pudo crear $logDir");
        }
        if (is_dir($logDir) && !is_writable($logDir)) {
            error_log("ServicioLogger: $logDir no tiene permisos de escritura");
        }

        return self::$logger;
    }

    public static function obtenerLogger(): Logger {
        if (self::$logger === null) {
            throw new RuntimeException("El LoggerService no ha sido inicializado.");
        }
        return self::$logger;
    }

    private static function vincularErroresPHP(Logger $logger): void {
        set_error_handler(function($nivel, $mensaje, $archivo, $linea) use ($logger) {
            if (!(error_reporting() & $nivel)) return false;

            $context = ['file' => $archivo, 'line' => $linea];
            
            if ($nivel === E_USER_ERROR || $nivel === E_RECOVERABLE_ERROR) {
                $logger->error($mensaje, $context);
            } else {
                $logger->warning($mensaje, $context);
            }
            return true;
        });

        set_exception_handler(function (Throwable $ex) use ($logger) {
            $logger->critical('Excepción no atrapada: ' . $ex->getMessage(), [
                'clase' => get_class($ex),
                'file'  => $ex->getFile(),
                'line'  => $ex->getLine(),
                'trace' => $ex->getTraceAsString(),
            ]);

            if (!headers_sent()) {
                http_response_code(500);
            }

            // solo en desarrollo
            echo '<pre>' . htmlspecialchars((string) $ex) . '</pre>';   
            // include APP_ROOT . 'vistas/paginas/500.php';
        });

       register_shutdown_function(function () use ($logger) {
            $error = error_get_last();
            if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
                $logger->critical('Error fatal: ' . $error['message'], [
                    'file' => $error['file'],
                    'line' => $error['line'],
                ]);
                if (!headers_sent()) {
                    http_response_code(500);
                }
            }
        });
    }
}