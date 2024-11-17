<?php
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos y Pedidos - Mister Bigotes</title>
    <link rel="stylesheet" href="manageStyle.css"> <!-- Estilos específicos para el área de administración -->
</head>
<body>
    <header>
        <h1>Gestión de Productos y Pedidos - Mister Bigotes</h1>
    </header>

    <div class="container">
        <!-- Sección de Productos -->
        <section class="section">
            <h2>Gestión de Productos</h2>
            <nav>
                <ul>
                    <li><a href="create_product.php">Agregar Producto</a></li>
                    <!-- Enlace que redirige directamente a read_products.php -->
                    <li><a href="read_products.php">Ver Productos</a></li>
                    <li><a href="admin.php">Panel de administración</a></li>
                </ul>
            </nav>
            <div>
                <?php
                // Manejo de acciones CRUD en función de la opción seleccionada
                if (isset($_GET['action'])) {
                    switch ($_GET['action']) {
                        case 'create':
                            include 'create_product.php'; // Formulario para agregar un producto
                            break;
                        case 'read':
                            include 'read_products.php'; // Tabla para ver los productos
                            break;
                        case 'update':
                            include 'update_product.php'; // Formulario para actualizar un producto
                            break;
                        case 'delete':
                            include 'delete_product.php'; // Formulario para eliminar un producto
                            break;
                        default:
                            echo "<p>Seleccione una opción válida del menú.</p>";
                    }
                } else {
                    echo "<p>Seleccione una acción desde el menú para gestionar los productos.</p>";
                }
                ?>
            </div>
        </section>

        <!-- Sección de Pedidos -->
        <section class="section">
            <h2>Gestión de Pedidos</h2>
            <nav>
                <ul>
                    <li><a href="?order_action=view_all">Ver Todos los Pedidos</a></li>
                    <li><a href="?order_action=update_status">Actualizar Estado de Pedido</a></li>
                </ul>
            </nav>
            <div>
                <?php
                // Manejo de acciones CRUD para pedidos
                if (isset($_GET['order_action'])) {
                    switch ($_GET['order_action']) {
                        case 'view_all':
                            include 'view_orders.php'; // Tabla para ver todos los pedidos
                            break;
                        case 'update_status':
                            include 'update_order_status.php'; // Formulario para actualizar el estado de un pedido
                            break;
                        default:
                            echo "<p>Seleccione una opción válida del menú de pedidos.</p>";
                    }
                } else {
                    echo "<p>Seleccione una acción desde el menú para gestionar los pedidos.</p>";
                }
                ?>
            </div>
        </section>
    </div>

    <script>
    // Función para alternar la visibilidad de la tabla
    function toggleTableVisibility() {
        const table = document.getElementById('product-table');
        
        // Verificamos si la tabla tiene la clase "hidden"
        if (table.classList.contains('hidden')) {
            table.classList.remove('hidden');  // Si tiene la clase "hidden", la mostramos
        } else {
            table.classList.add('hidden');     // Si no tiene la clase, la ocultamos
        }
    }
    </script>
</body>
</html>
