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

    // Funcion que devuelve los datos de un plan segun id
    public function listarPlan($idPlan) {
        return;
    }

    // Funcion que lista todos los planes
    public function listarPlanes() {
        $planes = modeloPlan::obtenerPlanes();

        forEach($planes as $plan) {
            echo "
                <div class='plan'>
                    <h2>" . $plan['nombre'] . "</h2>
                    <h3>$". $plan['costo'] . "usd / mes</h3>
                    <small>Pensado para hasta " . $plan['max_jugadores'] . " jugadores</small>
                    <ul>
                        <li>8GB de RAM</li>
                        <li>Instalacion de modpacks</li>
                        <li>Prioridad en tiempos de trafico alto</li>
                    </ul>
                    <button>Comprar</button>
                </div>";
        }
    }

    // Funcion que muestra estadisticas como cantidad de usuarios, duracion preferida, entre otros
    // (pensar que se puede mostrar)
    public function estadisticasPlanes() {

    }
}