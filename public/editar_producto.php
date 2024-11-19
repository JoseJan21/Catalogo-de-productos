<?php
session_start();
include 'config.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verificar si el ID del producto es válido y cargar los datos del producto
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener el producto de la base de datos
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Actualizar datos del producto
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $youtube_iframe = $_POST['youtube_iframe'];

        // Manejar imagen de portada
        if (!empty($_FILES['portada']['name'])) {
            $portada = $_FILES['portada']['name'];
            move_uploaded_file($_FILES['portada']['tmp_name'], "../imagenes/" . $portada);
        } else {
            $portada = $product['portada']; // Mantener la portada actual si no se cambia
        }

        // Manejar galería de imágenes y videos adicionales
        $galerias = [];
        if (!empty($_FILES['galerias']['name'][0])) {
            foreach ($_FILES['galerias']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['galerias']['name'][$key];
                move_uploaded_file($tmp_name, "../imagenes/" . $file_name);
                $galerias[] = $file_name;
            }
        } else {
            $galerias = json_decode($product['galerias'], true); // Mantener las galerías actuales si no se cambian
        }
        $galerias_json = json_encode($galerias);

        // Actualizar los datos en la base de datos
        $stmt = $conn->prepare("UPDATE productos SET name = ?, description = ?, price = ?, portada = ?, galerias = ?, youtube_iframe = ? WHERE id = ?");
        $stmt->bind_param("ssdsssi", $name, $description, $price, $portada, $galerias_json, $youtube_iframe, $id);
        $stmt->execute();

        header("Location: detalles_producto.php?id=$id");
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
    <title>Editar Producto</title>
    <link rel="icon" href="../imagenes/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include "header.php"; ?>

    <section>
        <h1>Editar Producto</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Nombre del Producto:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="description">Descripción:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="price">Precio:</label>
            <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <label for="portada">Imagen de Portada:</label>
            <?php if (!empty($product['portada'])): ?>
                <img src="../imagenes/<?php echo htmlspecialchars($product['portada']); ?>" alt="Portada Actual" width="150">
            <?php endif; ?>
            <input type="file" name="portada" id="portada">

            <label for="galerias">Imágenes/Videos Adicionales:</label>
            <?php if (!empty($product['galerias'])): ?>
                <div class="galeria">
                    <?php foreach (json_decode($product['galerias'], true) as $archivo): ?>
                        <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $archivo)): ?>
                            <img src="../imagenes/<?php echo htmlspecialchars($archivo); ?>" alt="Galería Imagen" width="100">
                        <?php elseif (preg_match('/\.(mp4|webm|ogg)$/i', $archivo)): ?>
                            <video src="../imagenes/<?php echo htmlspecialchars($archivo); ?>" width="100" controls></video>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <input type="file" name="galerias[]" id="galerias" multiple>

            <label for="youtube_iframe">Código iframe de YouTube:</label>
            <textarea name="youtube_iframe" id="youtube_iframe"><?php echo htmlspecialchars($product['youtube_iframe']); ?></textarea>

            <button type="submit">Guardar Cambios</button>
        </form>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>
