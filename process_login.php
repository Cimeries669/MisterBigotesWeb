<?php
session_start(); // Iniciar la sesión para almacenar el estado del usuario

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
$email = $_POST['email'];
$password = $_POST['password'];

// Verificar si el usuario es un cliente
$sql_cliente = "SELECT * FROM clientes WHERE email = ?";
$stmt_cliente = $conn->prepare($sql_cliente);
$stmt_cliente->bind_param("s", $email);
$stmt_cliente->execute();
$result_cliente = $stmt_cliente->get_result();

// Verificar si el usuario es un administrador
$sql_admin = "SELECT * FROM administradores WHERE email = ?";
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("s", $email);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();

if ($result_cliente->num_rows > 0) {
    // Usuario encontrado en la tabla de clientes
    $cliente = $result_cliente->fetch_assoc();

    if (password_verify($password, $cliente['password'])) {
        // Inicio de sesión exitoso
        $_SESSION['usuario_id'] = $cliente['id_cliente'];
        $_SESSION['tipo_usuario'] = 'cliente';
        $_SESSION['usuario_nombre'] = $cliente['nombre']; // Guardar el nombre del cliente en la sesión

        // Redirigir al index.php
        header("Location: index.php");
        exit;
    } else {
        echo "Contraseña incorrecta.";
    }
} elseif ($result_admin->num_rows > 0) {
    // Usuario encontrado en la tabla de administradores
    $admin = $result_admin->fetch_assoc();

    if (password_verify($password, $admin['password'])) {
        // Inicio de sesión exitoso
        $_SESSION['usuario_id'] = $admin['id_admin'];
        $_SESSION['tipo_usuario'] = 'administrador';

        // Redirigir al admin.php
        header("Location: admin.php");
        exit;
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    // Usuario no encontrado en ninguna tabla
    echo "Usuario no registrado.";
}

$conn->close();
?>
