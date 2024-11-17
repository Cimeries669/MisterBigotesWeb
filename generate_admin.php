<?php
// Define la contraseña de administrador
$password = "";

// Genera el hash de la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Muestra el hash en pantalla
echo "Contraseña hasheada: " . $hashedPassword;
