// <?php
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
        <nav>
            <ul>
                <li><a href="../public/home.php">Inicio</a></li>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li><a href="../public/crear_producto.php">Crear Producto</a></li>
                    <!-- <li><a href="../public/crear_usuario.php">Crear Usuario</a></li> Enlace a crear usuario -->
                    <li><a href="../public/cerrar_sesion.php">Cerrar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<!-- Mensaje flotante de notificación -->
<div id="notification" class="notification"></div>
</body>
</html>
