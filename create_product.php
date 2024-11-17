<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$database = "mrbigotes";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener las categorías para el campo de selección
$query = "SELECT id_categoria, nombre_categoria FROM categorias";
$result = $conn->query($query);
$categorias = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="create_product_style.css">
</head>
<body>
    <form action="process_create_product.php" method="POST" enctype="multipart/form-data">
        <h2>Agregar Nuevo Producto</h2>    
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required step="0.01">

        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required>

        <label for="stock">Cantidad en Stock:</label>
        <input type="number" id="stock" name="stock" required min="0">
        
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="id_categoria" required>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="imagen">Imagen del Producto:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
