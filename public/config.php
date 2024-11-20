<!-- config.php -->
<?php
$servername = "railway";
$username = "root";
$password = "pQOIedGmFzPBSivguHezVovIWLjXWmHW";
$dbname = "railway";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
