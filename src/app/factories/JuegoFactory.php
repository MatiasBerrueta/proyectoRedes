<?php

require_once APP_ROOT . 'drivers/DriverMinecraft.php';
require_once APP_ROOT . 'drivers/DriverSteam.php';
require_once APP_ROOT . 'drivers/DriverTerraria.php';
require_once APP_ROOT . 'drivers/DriverGenerico.php';

class JuegoFactory {
    private static $drivers = [
        'Minecraft' => DriverMinecraft::class,
        'Source Engine' => DriverSteam::class,
        'Terraria' => DriverTerraria::class,
    ];

    public static function crear($juego) {
        $driver = self::$drivers[$juego] ?? DriverGenerico::class;
        return new $driver();
    }
}