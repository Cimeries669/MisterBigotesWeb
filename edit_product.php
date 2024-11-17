<?php
require 'db_connection.php';

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);

    // Obtener los datos actuales del producto
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }

    // Actualizar el producto
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);
        $descripcion = $_POST['descripcion'];
        $id_categoria = intval($_POST['id_categoria']); // Asegúrate de tener una lista de categorías

        $sql_update = "UPDATE productos SET nombre = ?, marca = ?, precio = ?, stock = ?, descripcion = ?, id_categoria = ? WHERE id_producto = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("ssdissi", $nombre, $marca, $precio, $stock, $descripcion, $id_categoria, $id_producto);

        if ($stmt_update->execute()) {
            // Redirigir a read_products.php tras la edición exitosa
            header("Location: read_products.php");
            exit();
        } else {
            echo "Error al actualizar el producto.";
        }
    }
} else {
    echo "ID de producto no especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="edit_product.css">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form method="POST">
        Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br>
        Marca: <input type="text" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required><br>
        Precio: <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required><br>
        Stock: <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required><br>
        Descripción: <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea><br>
        Categoría: <select name="id_categoria">
            <?php
            $categorias = $conexion->query("SELECT id_categoria, nombre_categoria FROM categorias");
            while ($categoria = $categorias->fetch_assoc()) {
                $selected = $producto['id_categoria'] == $categoria['id_categoria'] ? 'selected' : '';
                echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nombre_categoria']}</option>";
            }
            ?>
        </select><br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="read_products.php">Volver a la lista de productos</a>
</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
