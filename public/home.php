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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="icon" href="../imagenes/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Ajusta la ruta para el CSS -->
</head>
<body>
    <?php include "header.php"; ?>

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
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="producto">
                <a href="detalles_producto.php?id=<?php echo $row['id']; ?>">
                    <!-- Validación y generación de la URL dinámica -->
                    <?php
                    if (!empty($row['portada'])) {
                        $portada = htmlspecialchars($row['portada']);
                        echo "<img src='{$portada}' alt='" . htmlspecialchars($row['name']) . "'>";
                    } else {
                        echo "<img src='../imagenes/default-image.png' alt='Imagen no disponible'>"; // Imagen por defecto
                    }
                    ?>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <span><?php echo number_format($row['price'], 2); ?> AR</span>
                </a>
            </div>
        <?php endwhile; ?>
    </section>

    <!-- Incluir el footer -->
    <?php include 'footer.php'; ?>
</body>
</html>