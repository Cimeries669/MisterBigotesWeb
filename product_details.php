<?php
// product_details.php
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$database = "mrbigotes";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_producto = $_GET['id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="productDetailsStyle.css"> <!-- Enlace a tu CSS -->
</head>
<body>

<div class="container">
    <?php
    if ($id_producto > 0) {
        $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            echo "<div class='product-details'>";
            echo "<img class='product-image' src='" . htmlspecialchars($product['imagen_url']) . "' alt='Imagen del producto'>";
            echo "<div class='product-info'>";
            echo "<h2 class='product-name'>" . htmlspecialchars($product['nombre']) . "</h2>";
            echo "<p class='product-description'>" . htmlspecialchars($product['descripcion']) . "</p>";
            echo "<p class='product-price'>Precio: $" . number_format($product['precio'], 0) . "</p>";
            echo "<button class='add-to-cart-btn'>Agregar al carrito</button>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<p>Producto no encontrado.</p>";
        }
    } else {
        echo "<p>Producto no válido.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
