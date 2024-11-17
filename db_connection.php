<?php
// Configuración de la conexión a la base de datos
$servidor = "localhost";        // Dirección del servidor (habitualmente localhost para desarrollo local)
$usuario_bd = "root";      // Usuario de la base de datos
$contrasena_bd = "Gooddemise1"; // Contraseña del usuario
$base_datos = "mrbigotes";       // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($servidor, $usuario_bd, $contrasena_bd, $base_datos);


// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Definir la codificación de caracteres
$conexion->set_charset("utf8");
?>
