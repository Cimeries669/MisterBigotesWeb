<?php
session_start();

// Verificar si se recibió el ID del producto a eliminar vía POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $producto_id = $_POST['id_producto'];

    // Buscar el producto en el carrito y eliminarlo
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['id_producto'] == $producto_id) {
            unset($_SESSION['carrito'][$key]);
            $response = array(
                'success' => true,
                'mensaje' => 'Producto eliminado del carrito correctamente.'
            );
            echo json_encode($response);
            exit;
        }
    }

    // Respuesta si el producto no se encontró en el carrito
    $response = array(
        'success' => false,
        'mensaje' => 'El producto no se encontró en el carrito.'
    );
    echo json_encode($response);
    exit;
}

// Respuesta en caso de que la solicitud no sea válida
$response = array(
    'success' => false,
    'mensaje' => 'Solicitud no válida.'
);
echo json_encode($response);
?>
