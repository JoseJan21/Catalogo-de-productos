<?php
// Leer las variables de entorno proporcionadas por Railway
$servername = getenv('MYSQLHOST');       // Dirección del servidor (host)
$username = getenv('MYSQLUSER');         // Usuario de la base de datos
$password = getenv('MYSQLPASSWORD');     // Contraseña del usuario
$dbname = getenv('MYSQLDATABASE');       // Nombre de la base de datos
$port = getenv('MYSQLPORT');             // Puerto de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
