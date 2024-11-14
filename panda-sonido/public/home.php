<?php
// Verifica que la conexión a la base de datos esté establecida
if (!isset($conn)) {
    include 'config.php'; // Incluye el archivo de configuración si no se ha incluido
}

// Realiza la consulta para obtener los productos
$result = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <link rel="icon" href="../imagenes/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Ajusta la ruta para el CSS -->
</head>
<body>
    <?php include "header.php"; ?>
    <!-- <header>
        <h1>Nombre del Negocio</h1>
        <p>Información sobre el negocio...</p>
        <nav>
            <a href="crear_producto.php">Crear Producto</a>
        </nav>
    </header> -->

    <section class="presentacion-negocio">
    <div class="contenido-presentacion">
        <h1>Alquiler de Sonido y Luces para Eventos</h1>
        <p>Ofrecemos el mejor servicio de alquiler de equipos de sonido, iluminación y más para hacer que tus eventos brillen. Ya sea una fiesta, un evento corporativo o cualquier celebración, ¡tenemos lo que necesitas!</p>
        <p>Contáctanos: </p>
        <div class="contacto-redes">
            <a href="https://www.instagram.com/pandasonido/" target="_blank">
                <img src="../imagenes/instagram-icon.png" alt="Instagram">
                <span>Instagram</span>
            </a>
            <a href="https://wa.me/2995491899" target="_blank">
                <img src="../imagenes/whatsapp-icon.png" alt="WhatsApp">
                <span>WhatsApp</span>
            </a>
        </div>
    </div>
    <div class="imagen-presentacion">
        <img src="../imagenes/logo.png" alt="Alquiler de sonido y luces para eventos">
    </div>
</section>


    
    <section class="catalogo">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="producto">
                <a href="detalles_producto.php?id=<?php echo $row['id']; ?>">
                    <img src="../imagenes/<?php echo $row['portada']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <span><?php echo $row['price']; ?></span>
                </a>
            </div>
        <?php endwhile; ?>

    </section>
    <!-- Incluir el footer -->
    <?php include 'footer.php'; ?>


</body>
</html>
