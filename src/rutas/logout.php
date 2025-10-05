<?php
require_once "../controladores/controladorAutenticar.php";

$controladorAutenticar = new controladorAutenticar($db);
$controladorAutenticar->cerrarSesion();
?>