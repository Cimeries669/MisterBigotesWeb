<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Mister Bigotes</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>

<header>
    <h1>Panel de Administración - Mister Bigotes</h1>
</header>

<nav>
    <a href="admin.php">Inicio</a>
    <a href="manage_products.php">Gestionar Productos y Pedidos</a>
    <a href="logout.php">Cerrar Sesión</a>
</nav>

<div class="container">
    <h2>Bienvenido, Administrador</h2>
    <p>Desde aquí puedes gestionar los productos, pedidos y más opciones de administración.</p>

    <div class="table-container">
        <h3>Productos Actuales</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Comida para Gatos</td>
                <td>$15.00</td>
                <td>100</td>
                <td><button>Editar</button> <button>Eliminar</button></td>
            </tr>
            <!-- Más filas de productos pueden agregarse aquí -->
        </table>
    </div>
</div>

</body>
</html>
