<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión completamente
session_destroy();

// Redirigir a la página de inicio de sesión o inicio
header("Location: ../public/home.php"); // Ajusta la ubicación si es necesario
exit();
?>
