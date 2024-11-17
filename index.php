<?php
session_start(); // Iniciar la sesión

header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT"); // Fecha en el pasado

// Tiempo de inactividad permitido (10 minutos)
$inactividad = 600; // 600 segundos 
if (isset($_SESSION['ultimo_acceso'])) {
    if (time() - $_SESSION['ultimo_acceso'] > $inactividad) {
        // Destruir la sesión si ha pasado el tiempo de inactividad
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}

// Actualizar el tiempo del último acceso
$_SESSION['ultimo_acceso'] = time();

// Verificar si el usuario ha iniciado sesión
$usuario_logueado = isset($_SESSION['usuario_id']);
$tipo_usuario = $usuario_logueado ? $_SESSION['tipo_usuario'] : null;
?>

<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$dbname = "mrbigotes";  // Asegúrate de que el nombre de la base de datos sea el correcto

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los productos
$sql = "SELECT id_producto, nombre, descripcion, precio, stock, id_categoria, imagen_url, marca FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="indexStyle.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Mr. Bigotes.cl</title>

    <!-- Cargar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="search.js"></script>
</head>
<body>
    <!-- Encabezado o Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-nav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#catalogo">Catálogo</a></li>
                <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                <?php if ($usuario_logueado): ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
                <?php endif; ?>
            </ul>
            
            <!-- Icono del carrito con el contador -->
            <div class="navbar-nav ms-auto">
                <a class="nav-item nav-link" href="carrito.php">
                    <i class="fas fa-shopping-cart"></i>
                    <?php
                    $cantidad_productos = 0;
                    if (isset($_SESSION['carrito'])) {
                        foreach ($_SESSION['carrito'] as $item) {
                            $cantidad_productos += $item['cantidad'];
                        }
                    }
                    
                    if ($cantidad_productos > 0) {
                        echo "<span class='badge bg-danger' id='carrito-count'>$cantidad_productos</span>";
                    } else {
                        echo "<span class='badge bg-danger' id='carrito-count'>0</span>";
                    }
                    ?>
                </a>
            </div>
        </nav>
    </header>


    <!-- Sección de Inicio -->
    <section id="inicio">
        <h2>Bienvenidos a Mister Bigotes</h2>
        <p>La mejor tienda online para consentir a tu gato.</p>
    </section>

    <!-- Saludo de bienvenida -->
    <?php if ($usuario_logueado): ?>
        <section id="bienvenida">
            <h3>Bienvenido <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>, ¿qué buscas hoy?</h3>
        </section>
    <?php endif; ?>

    <!-- Buscador -->
    <section id="buscador">
        <form id="searchForm" action="buscar.php" method="GET">
            <label for="buscar">Buscar productos:</label>
            <input type="text" id="buscar" name="query" placeholder="Buscar productos...">
            <button id ="search-btn" type="submit">Buscar</button>
        </form>
    </section>
    <div id="sugerencias" style="display: none;"></div> <!-- Contenedor para sugerencias -->

    <!-- Carrusel -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="imagesCarrusel/slideComida1G.png" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="imagesCarrusel/slide1G.png" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="imagesCarrusel/slide2Gminino.png" class="d-block w-100" alt="Imagen 3">
            </div>
            <div class="carousel-item">
                <img src="imagesCarrusel/slideJuguete1G.png" class="d-block w-100" alt="Imagen 4">
            </div>
            <div class="carousel-item">
                <img src="imagesCarrusel/slideEsteticaYCuidados2G.png" class="d-block w-100" alt="Imagen 5">
            </div>
            <div class="carousel-item">
                <img src="imagesCarrusel/slideEsteticaYCuidados1G.png" class="d-block w-100" alt="Imagen 5">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Contenedor de los productos -->
<div class="container mt-4">
    <div class="row">
        <?php
        // Verificar si la consulta devuelve resultados
        if ($result->num_rows > 0) {
            // Recorrer cada producto
            while ($row = $result->fetch_assoc()) {
                // Obtener cada campo del producto
                $id_producto = $row['id_producto'];
                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $precio = $row['precio'];
                $stock = $row['stock'];
                $imagen_url = $row['imagen_url'];
                $marca = $row['marca'];
                
                // Crear una card para cada producto
                echo '<div class="col-md-4 mb-4">';
                echo '    <div class="card h-100">';
                echo '        <div class="img-container">';
                echo '            <img src="' . htmlspecialchars($imagen_url) . '" class="card-img-top" alt="' . htmlspecialchars($nombre) . '">';
                echo '        </div>';
                echo '        <div class="card-body">';
                echo '            <h5 class="card-title">' . htmlspecialchars($nombre) . '</h5>';
                echo '            <p class="card-text">' . htmlspecialchars($descripcion) . '</p>';
                echo '            <p class="card-text"><strong>$' . number_format($precio, 0) . '</strong></p>';
                echo '            <p class="card-text">Marca: ' . htmlspecialchars($marca) . '</p>';
                echo '            <p class="card-text">Stock: ' . $stock . '</p>';
                
                if ($stock > 0) {
                    echo '            <button class="btn btn-primary add-to-cart" data-id="' . $id_producto . '">Agregar al carrito</button>';
                } else {
                    echo '            <button class="btn btn-secondary" disabled>Agotado</button>';
                }
                
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay productos disponibles en este momento.</p>';
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</div>


    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <div id="popup-message" style="display: none; position: fixed; bottom: 20px; right: 20px; background-color: #28a745; color: white; padding: 15px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
    <span id="popup-text"></span>
</div>



    <!-- Script para agregar productos al carrito -->
    <script>
       $(document).ready(function() {
    $('.add-to-cart').on('click', function() {
        var producto_id = $(this).data('id');

        $.ajax({
            url: 'agregar_al_carrito.php',
            type: 'GET',
            data: { action: 'add', producto_id: producto_id },
            success: function(response) {
                var data = JSON.parse(response);

                if (data.mensaje) {
                    // Si no hay más productos disponibles, cambiar el popup a color rojo
                    if (data.mensaje.toLowerCase().includes('agotado') || data.mensaje.toLowerCase().includes('no disponible')) {
                        showPopup(data.mensaje, true); // Mostrar popup en color rojo
                    } else {
                        showPopup(data.mensaje); // Mostrar popup en color verde
                    }
                }

                // Actualizar el contador del carrito
                $('#carrito-count').text(data.totalProductos);
            },
            error: function() {
                showPopup("Hubo un error al agregar el producto al carrito.", true);
            }
        });
    });
});

// Función para mostrar el popup
function showPopup(message, isError = false) {
    var popup = $('#popup-message');
    var popupText = $('#popup-text');

    popupText.text(message);
    popup.css('background-color', isError ? '#dc3545' : '#28a745'); // Rojo para errores o productos agotados, verde para éxito
    popup.fadeIn();

    // Ocultar el popup después de 3 segundos
    setTimeout(function() {
        popup.fadeOut();
    }, 900);
}


    </script>

</body>

<!-- Pie de página o Footer -->
<footer>
    <p>&copy; 2024 Mister Bigotes. Todos los derechos reservados.</p>
</footer>

</html>
