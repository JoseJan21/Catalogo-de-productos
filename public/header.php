<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nombre de tu Sitio Web</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Ajusta la ruta para el CSS -->
    <script src="../js/script.js" defer></script>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo-nombre">
            <img src="../imagenes/logo.png" alt="Logo de la Empresa" class="logo">
            <h1>Panda Sonido</h1>
        </div>
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
        <nav>
            <ul>
                <li><a href="../public/home.php">Inicio</a></li>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="../public/crear_producto.php">Crear Producto</a></li>
                    <li><a href="../public/cerrar_sesion.php" class="cerrar-sesion">Cerrar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<script>
    // Aquí va tu código JavaScript
    document.addEventListener('DOMContentLoaded', function () {
        // Este código se ejecutará cuando el DOM esté completamente cargado
        console.log('Página cargada correctamente');
    });
</script>

</body>
</html>