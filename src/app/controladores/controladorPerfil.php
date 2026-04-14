<?php

class controladorPerfil extends Controlador {
    //Borra este archivo, move las funciones a ControladorUsuario.php

    public function mostrarPerfil() {
        $this->requiereLogin();

        // Usa la funcion obtenerUsuarioEmail(email) de ServicioUsuario.php
        $db = new Database();
        $conn = $db->getConexion();

        $id = $_SESSION['usuario']['id_usuario'];

        $stmt = $conn->prepare("SELECT * FROM USUARIO WHERE id_usuario = ?");
        $stmt->execute([$id]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Usa la funcion $this->renderizar(vista, datos);
        require APP_ROOT . 'vistas/vistaPerfil.php';
    }

    public function actualizarPerfil() {
            $this->requiereLogin();

            $id = $_SESSION['usuario']['id_usuario'];
            $nombre = trim($_POST['nombre']); 
            $email = trim($_POST['email']);
            $pais = trim($_POST['pais']);

            // Usa la funcion mostrarPerfil y mandar errores
            // Mira como esta hecho en la funcion inicarSesion() en ControladorUsuario.php
            if(empty($nombre) || empty($email)){
                header("Location: /usuario/perfil?error=1");
                exit;
            }

            // Usa la funcion actualizarDatos() desde RepositorioUsuario.php
            $db = new Database();
            $conn = $db->getConexion();

            $stmt = $conn->prepare("
                UPDATE USUARIO 
                SET nombre = ?, email = ?, pais = ?
                WHERE id_usuario = ?
            ");

            $stmt->execute([$nombre, $email, $pais, $id]);

            header("Location: /usuario/perfil?ok=1");
        }
}
