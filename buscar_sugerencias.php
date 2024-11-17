<?php
// buscar_sugerencias.php
$servername = "localhost";
$username = "root";
$password = "Gooddemise1";
$dbname = "mrbigotes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = $_GET['query'] ?? '';
$suggestions = [];

if (!empty($query)) {
    $stmt = $conn->prepare("SELECT id_producto, nombre FROM productos WHERE nombre LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row;
    }
}

echo json_encode($suggestions);
$conn->close();
?>
