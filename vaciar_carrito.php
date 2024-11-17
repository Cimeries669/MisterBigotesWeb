
<?php
session_start();

// Verificar si el carrito existe y eliminarlo
if (isset($_SESSION['carrito'])) {
    unset($_SESSION['carrito']);  // Vaciar el carrito
    $response = array(
        'success' => true,
        'mensaje' => 'El carrito ha sido vaciado con éxito.'
        
    );
} else {
    $response = array(
        'success' => false,
        'mensaje' => 'El carrito ya está vacío.'
    );
}

// Responder con JSON para que el mensaje pueda ser manejado en el frontend
echo json_encode($response);
?>
