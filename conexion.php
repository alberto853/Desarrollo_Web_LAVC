<?php

$servidor = "localhost";
$usuario_bd = "root";
$contrasena_bd = "";
$nombre_bd = "base_usuarios";

$conexion = new mysqli($servidor, $usuario_bd, $contrasena_bd, $nombre_bd, 3307);

if ($conexion->connect_error) {
    die("Error de conexion: " . $conexion->connect_error);
}
?>