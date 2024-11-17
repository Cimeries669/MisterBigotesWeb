<?php
// buscar.php
if (isset($_GET['query'])) {
    $query = urlencode($_GET['query']);
    header("Location: resultados_busqueda.php?query=$query");
    exit();
} else {
    header("Location: index.php"); // Redirige a la página principal si no hay término de búsqueda
    exit();
}
