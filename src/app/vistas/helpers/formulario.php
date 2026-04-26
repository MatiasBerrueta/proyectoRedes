<?php

function renderizarInput($data = []) {
    extract($data);
    $tipo = ucfirst($data['tipo']);
    include APP_ROOT . "vistas/componentes/input{$tipo}.php";
}

function agruparPorSeccion(array $configs): array {
    $resultado = [];

    foreach($configs as $config) {
        $seccion = $config['seccion'];

        if(!isset($resultado[$seccion])) {
            $resultado[$seccion] = [];
        }

        $resultado[$seccion][] = $config;
    }

    return $resultado;
}