<?php
use Monolog\Logger;
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

            self::vincularErroresPHP(self::$logger);
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

        set_exception_handler(function(Throwable $ex) use ($logger) {
            $logger->critical('Excepción no atrapada: ' . $ex->getMessage(), [
                'clase' => get_class($ex),
                'file'  => $ex->getFile(),
                'line'  => $ex->getLine(),
                'trace' => $ex->getTraceAsString()
            ]);
        });

       register_shutdown_function(function() {
            $error = error_get_last();
            if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR])) {
                http_response_code(500);
            }
        });
    }
}