<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$dbname = "mrbigotes";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el carrito ya existe en la sesión
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Si se recibe una acción para agregar al carrito
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['producto_id'])) {
    $producto_id = $_GET['producto_id'];

    // Consultar el producto en la base de datos, incluyendo el stock
    $sql = "SELECT id_producto, nombre, precio, imagen_url, stock FROM productos WHERE id_producto = $producto_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Verificar si el producto ya está en el carrito
        $producto_existente = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id_producto'] == $producto['id_producto']) {
                // Verificar si al incrementar la cantidad se excede el stock
                if ($item['cantidad'] + 1 > $producto['stock']) {
                    echo json_encode(array('mensaje' => 'No se puede agregar más del stock disponible.'));
                    exit;
                }
                $item['cantidad']++;  // Incrementar cantidad
                $producto_existente = true;
                break;
            }
        }
        unset($item); // Para evitar problemas de referencia con el foreach

        // Si el producto no estaba en el carrito, agregarlo con cantidad 1, si hay stock
        if (!$producto_existente) {
            if ($producto['stock'] > 0) {
                $producto['cantidad'] = 1;
                $_SESSION['carrito'][] = $producto;
            } else {
                echo json_encode(array('mensaje' => 'Este producto está agotado.'));
                exit;
            }
        }

        // Calcular el total de productos (suma de todas las cantidades)
        $totalProductos = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $totalProductos += $item['cantidad'];
        }

        // Responder con el mensaje y el total de productos en el carrito
        $response = array(
            'mensaje' => 'Producto agregado al carrito con éxito.',
            'totalProductos' => $totalProductos
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('mensaje' => 'Producto no encontrado.'));
    }
}

$conn->close();
?>
