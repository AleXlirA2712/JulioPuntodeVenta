<?php
$conexion = new mysqli("localhost", "root", "", "gimnasio_pos");
if ($conexion->connect_error) {
    die("Error al conectar: " . $conexion->connect_error);
}
?>