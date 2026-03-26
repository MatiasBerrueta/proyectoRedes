<?php

require_once APP_ROOT . 'abstracts/JuegoAbstracto.php';

class DriverMinecraft extends JuegoAbstracto {
    // Funciones del abstract
    public function obtenerTabs() {
        return [
            [
                'id' => 'consola',
                'label' => 'Consola',
                'acciones' => ['verConsola']
            ],
            [
                'id' => 'monitor',
                'label' => 'Monitor',
                'acciones' => ['verMonitor']
            ],
            [
                'id' => 'configuracion',
                'label' => 'Configuración',
                'acciones' => ['verConfiguracion', 'guardarConfiguracion']
            ],
            [
                'id' => 'archivos',
                'label' => 'Archivos',
                'acciones' => ['listarArchivos', 'subirArchivo', 'eliminarArchivo']
            ],
            [
                'id' => 'user',
                'label' => 'Jugadores',
                'acciones' => ['listarJugadores', 'expulsarJugador', 'banearJugador']
            ],
            [
                'id' => 'mods',
                'label' => 'Mods',
                'acciones' => ['listarMods', 'instalarMod', 'eliminarMod']
            ],
            [
                'id' => 'backups',
                'label' => 'Backups',
                'acciones' => ['listarBackups', 'crearBackup', 'restaurarBackup']
            ],
            [
                'id' => 'logs',
                'label' => 'Logs',
                'acciones' => ['verLogs']
            ],
            [
                'id' => 'control_acceso',
                'label' => 'Control de acceso',
                'acciones' => ['listarUsuarios', 'agregarUsuario', 'eliminarUsuario']
            ],
        ];
    }

    public function obtenerFunciones() {
        throw new \Exception('Not implemented');
    }

    public function obtenerConfiguraciones() {
        return [
        [
            'clave' => 'chunks',
            'etiqueta' => 'Jugadores máximos',
            'tipo' => 'slider',
            'min' => 2,
            'max' => 32,
            'defecto' => 4
        ],
        [
            'clave' => 'pvp',
            'etiqueta' => 'PVP',
            'tipo' => 'toggle',
            'defecto' => true
        ],
        [
            'clave' => 'difficulty',
            'etiqueta' => 'Dificultad',
            'tipo' => 'select',
            'opciones' => ['peaceful', 'easy', 'normal', 'hard'],
            'defecto' => 'normal'
        ],
    ];
    }

    // Funciones espeficias

    
}
