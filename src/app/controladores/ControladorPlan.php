<?php

class ControladorPlan extends Controlador {
    private $servicio;

    public function __construct($servicio) {
        $this->servicio = $servicio;
    }

    // Funcion que recibe datos necesarios para crear un plan
    // luego llama a la funcion insertarPlan() para guardarlo en la BD.
    public function crearPlan($nombre, $costo, $max_jugadores, $duracion) {
        return;
    }

    // Funcion que modifica los datos de un plan de forma local usando sets de modeloPlan
    // segun los parametros que se pasan, despues se guardan en la bd usando actualizarPlan()
    public function modificarPlan($nombre = null, $costo = null, $max_jugadores = null, $duracion = null) {
        return;
    }

    // Funcion que elimina (capas deberia tener un estado?) un plan segun id 
    public function eliminarPlan($idPlan) {
        return;
    }

    // Funcion que lista los datos de un plan segun id
    public function listarPlan($idPlan) {
        return;
    }

    // Funcion que muestra estadisticas como cantidad de usuarios, duracion preferida, entre otros
    // (pensar que se puede mostrar)
    public function estadisticasPlanes() {

    }
}