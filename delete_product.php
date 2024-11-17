<?php
require 'db_connection.php';

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);

    // Consulta para eliminar el producto
    $sql = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto.";
    }
} else {
    echo "ID de producto no especificado.";
}

$stmt->close();
$conexion->close();
?>

<!-- Redirigir de vuelta a la lista de productos -->
<script>
    setTimeout(function() {
        window.location.href = 'read_products.php';
    }, 1500);
</script>
