<?php
// resultados_busqueda.php
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$database = "mrbigotes";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = $_GET['query'] ?? '';
$productos = [];

// Verificar si hay una consulta válida
if (!empty($query)) {
    $searchQuery = "%" . $conn->real_escape_string($query) . "%";
    $stmt = $conn->prepare("SELECT * FROM productos WHERE nombre LIKE ?");
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link rel="stylesheet" href="resultados_busqueda.css">
</head>
<body>
    <h1>Resultados para: <?php echo htmlspecialchars($query); ?></h1>

    <?php if (!empty($productos)): ?>
        <div class="product-list">
            <?php foreach ($productos as $producto): ?>
                <div class="product-item">
                    <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                    <p>Precio: $<?php echo number_format($producto['precio'], 0); ?></p>
                    <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="Imagen del producto">
                    <a href="product_details.php?id=<?php echo $producto['id_producto']; ?>">Ver detalles</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No se encontraron productos que coincidan con la búsqueda.</p>
    <?php endif; ?>
</body>
</html>
