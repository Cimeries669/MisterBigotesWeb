<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="carrito.css">
</head>
<body>

<?php
// Verificar si el carrito tiene productos
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<h2>Tu Carrito de Compras</h2>";
    echo "<table class='table'>";
    echo "<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr></thead><tbody>";
    echo "<a href='index.php' class='btn btn-success mt-3'>Volver al inicio</a>";
 
    echo "<p>No hay productos en tu carrito.</p>";
  
} else {
    echo "<h2>Tu Carrito de Compras</h2>";
    echo "<table class='table'>";
    echo "<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acciones</th></tr></thead><tbody>";

    $total = 0;

    // Recorrer los productos en el carrito
    foreach ($_SESSION['carrito'] as $item) {
        $producto_total = $item['precio'] * $item['cantidad'];
        $total += $producto_total;

        echo "<tr data-producto-id='" . $item['id_producto'] . "'>";
        echo "<td>" . htmlspecialchars($item['nombre']) . "</td>";
        echo "<td>$" . number_format($item['precio'], 0) . "</td>";
        echo "<td><input type='number' min='1' value='" . $item['cantidad'] . "' data-id='" . $item['id_producto'] . "' class='form-control cantidad-input' /></td>";
        echo "<td class='total-producto'>$" . number_format($producto_total, 0) . "</td>";
        echo "<td><button class='btn btn-danger remove-product' data-id='" . $item['id_producto'] . "'>Eliminar</button></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "<h3 id='total-carrito'>Total: $" . number_format($total, 0) . "</h3>";

    // Formulario para método de envío
    echo "<form id='envio-form'>";
    echo "<h3>Opciones de Envío</h3>";
    echo "<label><input type='radio' name='envio' value='tienda' checked> Retirar en tienda</label><br>";
    echo "<label><input type='radio' name='envio' value='domicilio'> Envío a domicilio</label>";

    // Campos adicionales para envío a domicilio
    echo "<div id='domicilio-fields' style='display:none;'>";
    echo "<label>Dirección: <input type='text' name='direccion'></label><br>";
    echo "<label>Teléfono: <input type='text' name='telefono'></label><br>";
    echo "<label>Email: <input type='email' name='email'></label><br>";
    echo "<label>Receptor: <textarea name='receptor'></textarea></label><br>";
    echo "<label>Región: 
            <select name='region'>
                <option value='santiago'>Santiago (+$3000)</option>
                <option value='regiones'>Regiones (+$7000)</option>
            </select>
         </label>";
    echo "</div>";

    echo "<h3 id='total-envio'>Total con Envío: $" . number_format($total, 0) . "</h3>";
    echo "</form>";

    echo "<a href='index.php' class='btn btn-primary mt-3'>Volver al catálogo</a>";
    echo "<button id='clear-cart' class='btn btn-warning mt-3'>Vaciar Carrito</button>";
    echo "<a href='finalizar_compra.php' class='btn btn-success'>Finalizar Compra</a>";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const baseTotal = <?php echo $total; ?>;

        // Mostrar campos adicionales si se selecciona "Envío a domicilio"
        $('input[name="envio"]').on('change', function() {
            actualizarTotal();
        });

        // Actualizar total al cambiar la región
        $('select[name="region"]').on('change', function() {
            actualizarTotal();
        });

        function actualizarTotal() {
            const envio = $('input[name="envio"]:checked').val();
            let recargo = 0;

            if (envio === 'domicilio') {
                $('#domicilio-fields').show();
                const region = $('select[name="region"]').val();
                recargo = region === 'santiago' ? 3000 : region === 'regiones' ? 7000 : 0;
            } else {
                $('#domicilio-fields').hide();
            }

            const totalConEnvio = baseTotal + recargo;
            $('#total-envio').text("Total con Envío: $" + totalConEnvio.toLocaleString());
        }

        // Inicializar el total con envío al cargar la página
        actualizarTotal();

        // Vaciar todo el carrito
        $('#clear-cart').on('click', function() {
            $.ajax({
                url: 'vaciar_carrito.php',
                type: 'POST',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert("Carrito vaciado correctamente.");
                        location.reload();
                    } else {
                        alert("Hubo un error al vaciar el carrito.");
                    }
                },
                error: function() {
                    alert("Hubo un error al intentar vaciar el carrito.");
                }
            });
        });
    });
</script>

</body>
</html>
