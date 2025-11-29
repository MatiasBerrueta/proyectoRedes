<?php
require_once APP_ROOT . 'modelos/modeloPlan.php';

class controladorPlan {
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

    // Funcion que lista todos los planes
    public static function listarPlanes() {
        $planes = modeloPlan::obtenerPlanes();

        forEach($planes as $i => $plan) {
            $nombre = $plan['nombre'];
            $costo = $plan['costo'];
            // capas agregar un atributo "descripcion" en vez de solo max_jugadores
            // que diga algo como ""
            $max_jugadores = $plan['max_jugadores'];
            // agregar en la base de datos este atributo
            $prestaciones = ['8GB de RAM', 'Instalacion de modpacks', 'Prioridad en tiempos de trafico alto'];

            include APP_ROOT . 'vistas/componentes/plan.php';
        }
    }

    // Funcion que muestra estadisticas como cantidad de usuarios, duracion preferida, entre otros
    // (pensar que se puede mostrar)
    public function estadisticasPlanes() {

    }
}