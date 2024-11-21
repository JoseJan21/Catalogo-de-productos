<?php
session_start();
include 'config.php';

// Verificar si el usuario ha iniciado sesión y tiene una ID de usuario en la sesión
$is_logged_in = isset($_SESSION['usuario_id']);

// Verificar si el ID del producto está en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener el producto
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el producto fue encontrado
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $galerias = json_decode($product['galerias'], true);
    } else {
        echo "Producto no encontrado.";
        exit; 
    }
} else {
    echo "ID de producto inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="icon" href="../imagenes/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <?php include "header.php"; ?>
    </header>

    <section class="detalle-producto">
        <div class="descripcion">
            <img src="<?php echo htmlspecialchars($product['portada']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <div>
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <span><?php echo number_format($product['price'], 2); ?> AR</span>

                <!-- Botones de edición y eliminación solo visibles si el usuario ha iniciado sesión -->
                <?php if ($is_logged_in): ?>
                    <div class="acciones">
                        <a href="editar_producto.php?id=<?php echo $product['id']; ?>" class="btn-editar">Editar</a>
                        <a href="eliminar_producto.php?id=<?php echo $product['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="galeria" id="galeria">
            <?php if (!empty($galerias)): ?>
                <?php foreach ($galerias as $index => $archivo): ?>
                    <div class="item" style="<?php echo $index > 5 ? 'display: none;' : ''; ?>">
                        <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo)): ?>
                            <img src="<?php echo htmlspecialchars($archivo); ?>" alt="Galería de <?php echo htmlspecialchars($product['name']); ?>">
                        <?php elseif (preg_match('/\.(mp4|webm|ogg)$/i', $archivo)): ?>
                            <video controls>
                                <source src="<?php echo htmlspecialchars($archivo); ?>" type="video/<?php echo pathinfo($archivo, PATHINFO_EXTENSION); ?>">
                                Tu navegador no soporta el video.
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay imágenes o videos disponibles para este producto.</p>
            <?php endif; ?>
        </div>

        <?php if (!empty($product['youtube_iframe'])): ?>
            <div class="video-youtube">
                <?php echo htmlspecialchars_decode($product['youtube_iframe']); ?>
            </div>
        <?php endif; ?>
    </section>
    
    <!-- Incluir el footer -->
    <?php include 'footer.php'; ?>
</body>
</html>