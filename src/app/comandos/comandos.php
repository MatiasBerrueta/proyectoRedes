<?php

class SincronizarJuegos {
    private $pterodactylApp;
    private $conexion;

    public function __construct($pterodactylApp, $conexion) {
        $this->pterodactylApp = $pterodactylApp;
        $this->conexion = $conexion;
    }

    public function sincronizarJuegos() {
        $nests = $this->pterodactylApp->listarNests();

        foreach ($nests['data'] as $nest) {
            $nestId = $nest['attributes']['id'];
            $nestName = $nest['attributes']['name'];

            $eggs = $nest['attributes']['relationships']['eggs']['data'] ?? [];

            foreach ($eggs as $egg) {
                try {
                    $query = "INSERT INTO VIDEOJUEGO 
                        (egg_id, nest_id, nombre, nombre_grupo, descripcion)
                        VALUES 
                        (:egg_id, :nest_id, :nombre, :nombre_grupo, :descripcion)";

                    $stmt = $this->conexion->prepare($query);

                    $stmt->bindParam(':egg_id', $egg['attributes']['id'], PDO::PARAM_INT);
                    $stmt->bindParam(':nest_id', $nestId, PDO::PARAM_INT);
                    $stmt->bindParam(':nombre', $egg['attributes']['name'], PDO::PARAM_STR);
                    $stmt->bindParam(':nombre_grupo', $nestName, PDO::PARAM_STR);
                    $stmt->bindParam(':descripcion', $egg['attributes']['description'], PDO::PARAM_STR);

                    $stmt->execute();

                } catch (PDOException $e) {
                    error_log("Error insertando juego: " . $e->getMessage());
                    continue;
                }
            }
        }

        return true;
    }
}