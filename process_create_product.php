<?php
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$database = "mrbigotes";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$marca = $_POST['marca'];
$stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
$id_categoria = $_POST['id_categoria'];

// Manejar la imagen
$imagen_url = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $nombreImagen = uniqid() . "_" . basename($_FILES['imagen']['name']);
    $rutaDestino = "imagesProducts/" . $nombreImagen;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $imagen_url = $rutaDestino;
        echo "<p>Imagen cargada exitosamente: $imagen_url</p>";  // Mensaje de depuración
    } else {
        echo "<p>Error al mover la imagen a la carpeta destino.</p>";
    }
} else {
    echo "<p>No se ha seleccionado ninguna imagen o ocurrió un error en la carga.</p>";
}

// Confirmar el valor de `$imagen_url` antes de la consulta
if ($imagen_url !== null) {
    echo "<p>Ruta de la imagen: $imagen_url</p>"; // Mensaje de depuración
}

// Consulta SQL para insertar el producto
$sql = "INSERT INTO productos (nombre, descripcion, precio, marca, stock, id_categoria, imagen_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsiis", $nombre, $descripcion, $precio, $marca, $stock, $id_categoria, $imagen_url);

if ($stmt->execute()) {
    echo "<p>Producto agregado exitosamente.</p>";
} else {
    echo "<p>Error al agregar el producto: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();

// Redirigir de nuevo a la página de gestión de productos
header("Location: manage_products.php");
exit;
?>
