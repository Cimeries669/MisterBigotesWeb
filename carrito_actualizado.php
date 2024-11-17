<?php
session_start();

$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

echo json_encode(['total' => number_format($total, 0)]);
?>
