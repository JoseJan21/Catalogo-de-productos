<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- Botón para el menú hamburguesa -->
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
        <!-- Menú de navegación -->
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
    // La función toggleMenu ahora se asegura de que el menú se muestre y oculte correctamente.
    function toggleMenu() {
        const nav = document.querySelector('nav');
        nav.classList.toggle('active'); // Alterna la clase 'active' que muestra/oculta el menú
    }
</script>

</body>
</html>
