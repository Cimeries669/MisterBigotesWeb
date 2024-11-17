<?php
session_start(); // Iniciar la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$database = "mrbigotes"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

// Verificar si el correo electrónico ya está registrado
$sql = "SELECT * FROM clientes WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "El correo electrónico ya está en uso. Intenta con otro.";
} else {
    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo cliente en la base de datos
    $sql_insert = "INSERT INTO clientes (nombre, email, password, telefono, direccion) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $nombre, $email, $hashedPassword, $telefono, $direccion);

    if ($stmt_insert->execute()) {
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
        // Opcional: Redirigir a la página de login después del registro exitoso
        header("Location: login.php");
        exit;
    } else {
        echo "Error al registrar. Inténtalo de nuevo más tarde.";
    }
}

$conn->close();
?>
