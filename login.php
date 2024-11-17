<?php
session_start(); // Iniciar la sesión

// Si el usuario ya está logueado, redirigir a index.php
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Mister Bigotes</title>
    <link rel="stylesheet" href="loginStyle.css"> <!-- Enlace a tu hoja de estilos -->
</head>
<body>
    <form action="process_login.php" method="POST"> <!-- Enlace a la página de procesamiento -->
    <h2>Iniciar Sesión</h2>    
    <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar Sesión</button>
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p> <!-- Enlace a registro -->
    </form>
</body>
</html>
