<?php
session_start();

// Verificar si el administrador está logeado
if (!isset($_SESSION['usuario_id'])) {
    // Si no está logeado, redirigir al inicio de sesión
    header("Location: proadmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="icon" href="../imagenes/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Ajusta la ruta para el CSS -->
</head>
<body>
    <!-- <header>
        <h1>Crear Nuevo Producto</h1>
        <nav>
            <a href="index.php">Volver al Catálogo</a>
        </nav>
    </header> -->
    <?php include "header.php"; ?>

    
    <section class="form">
        <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" required>

            <label for="portada">Imagen de Portada:</label>
            <input type="file" name="portada" id="portada" required>

            <label for="galerias">Imágenes/Videos Adicionales:</label>
            <input type="file" name="galerias[]" id="galerias" multiple>

            <!-- Nuevo campo para el iframe de YouTube -->
            <label for="youtube_iframe">Código iframe de YouTube:</label>
            <textarea name="youtube_iframe" id="youtube_iframe" placeholder="Ingrese el código iframe de YouTube aquí"></textarea>

            <button type="submit">Guardar</button>
        </form>
    </section>
    
    <!-- Incluir el footer -->
    <?php include 'footer.php'; ?>

</body>
</html>
