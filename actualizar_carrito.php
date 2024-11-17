<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$dbname = "mrbigotes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['producto_id']) && isset($_GET['cantidad'])) {
    $producto_id = $_GET['producto_id'];
    $nueva_cantidad = (int)$_GET['cantidad'];

    if ($nueva_cantidad < 1) {
        echo json_encode(['mensaje' => 'La cantidad debe ser mayor que 0.']);
        exit;
    }

    // Consultar el stock disponible y precio del producto
    $sql_stock = "SELECT stock, precio FROM productos WHERE id_producto = $producto_id";
    $result = $conn->query($sql_stock);
    $producto = $result->fetch_assoc();

    if ($producto) {
        $producto_encontrado = false;
        $total_carrito = 0;
        $total_producto = 0;

        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id_producto'] == $producto_id) {
                if ($nueva_cantidad <= $producto['stock']) {
                    $item['cantidad'] = $nueva_cantidad;
                    $total_producto = $item['precio'] * $nueva_cantidad;
                } else {
                    // Si excede el stock, mantener la cantidad actual sin cambios
                    $total_producto = $item['precio'] * $item['cantidad'];
                    $producto_encontrado = true;  // Producto encontrado, detener la búsqueda

                    // Calcular el total del carrito con la cantidad actual del producto
                    foreach ($_SESSION['carrito'] as $producto) {
                        $total_carrito += $producto['precio'] * $producto['cantidad'];
                    }

                    echo json_encode([
                        'mensaje' => 'La cantidad solicitada supera el stock disponible.',
                        'total' => number_format($total_carrito, 0),
                        'totalProducto' => number_format($total_producto, 0)
                    ]);
                    exit;
                }
                $producto_encontrado = true;
            }
            $total_carrito += $item['precio'] * $item['cantidad'];
        }

        if ($producto_encontrado) {
            echo json_encode([
                'mensaje' => 'Cantidad actualizada correctamente.',
                'total' => number_format($total_carrito, 0),
                'totalProducto' => number_format($total_producto, 0)
            ]);
        } else {
            echo json_encode(['mensaje' => 'Producto no encontrado en el carrito.']);
        }
    } else {
        echo json_encode(['mensaje' => 'Producto no encontrado en la base de datos.']);
}
} else {
    echo json_encode(['mensaje' => 'Solicitud no válida.']);
}

$conn->close();
?>
