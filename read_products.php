<?php
require 'db_connection.php'; // Archivo que contiene la conexión a la BD

// Definir el orden por defecto
$orden = 'nombre';
$direccion = 'ASC';

// Verificar si se ha solicitado un ordenamiento diferente
if (isset($_GET['orden'])) {
    $orden = $_GET['orden'] === 'categoria' ? 'nombre_categoria' : $_GET['orden'];
    $direccion = (isset($_GET['direccion']) && $_GET['direccion'] == 'DESC') ? 'DESC' : 'ASC';
}

// Consulta para obtener productos junto con sus categorías
$sql = "SELECT p.id_producto, p.nombre, p.marca, p.precio, p.stock, p.descripcion, c.nombre_categoria 
        FROM productos p 
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
        ORDER BY $orden $direccion";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Mister Bigotes</title>
    <link rel="stylesheet" href="manageStyle.css">
</head>
<body>
    <header>
        <h1>Gestión de Productos - Mister Bigotes</h1>
    </header>

    <div class="container">
        <div id="product-table" class="product-table">
            <table>
                <thead>
                    <tr>
                        <th><a href="?action=read&orden=nombre&direccion=<?php echo ($orden == 'nombre' && $direccion == 'ASC') ? 'DESC' : 'ASC'; ?>">Nombre</a></th>
                        <th><a href="?action=read&orden=marca&direccion=<?php echo ($orden == 'marca' && $direccion == 'ASC') ? 'DESC' : 'ASC'; ?>">Marca</a></th>
                        <th><a href="?action=read&orden=precio&direccion=<?php echo ($orden == 'precio' && $direccion == 'ASC') ? 'DESC' : 'ASC'; ?>">Precio</a></th>
                        <th><a href="?action=read&orden=stock&direccion=<?php echo ($orden == 'stock' && $direccion == 'ASC') ? 'DESC' : 'ASC'; ?>">Stock</a></th>
                        <th><a href="?action=read&orden=descripcion&direccion=<?php echo ($orden == 'descripcion' && $direccion == 'ASC') ? 'DESC' : 'ASC'; ?>">Descripción</a></th>
                        <th><a href="?action=read&orden=categoria&direccion=<?php echo ($orden == 'categoria' && $direccion == 'ASC') ? 'DESC' : 'ASC'; ?>">Categoría</a></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while ($producto = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                                <td><?php echo number_format($producto['precio'], 0, ',', '.'); ?> CLP</td>
                                <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre_categoria']); ?></td>
                                <td>
                                <div class="button-container">
                                    <!-- Botones para editar y eliminar -->
                                    <a href="edit_product.php?id=<?php echo $producto['id_producto']; ?>" id="btn-edit">Editar</a>
                                    <a href="delete_product.php?id=<?php echo $producto['id_producto']; ?>" id="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                                </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No se encontraron productos.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="btnCloseTB-div">
                <button id="btnCloseTB" onclick="closeTableAndRedirect()">Cerrar Tabla de productos</button>
            </div>
        </div>
    </div>

    <script>
    function closeTableAndRedirect() {
        const table = document.getElementById('product-table');
        table.classList.add('hidden');
        window.location.href = 'manage_products.php';
    }
    </script>
</body>
</html>

<?php
$conexion->close();
?>
