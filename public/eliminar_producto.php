<?php
session_start();
include 'config.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verificar si el ID del producto es válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener el producto de la base de datos
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Eliminar la imagen de portada
        if (!empty($product['portada'])) {
            $portadaPath = "../imagenes/" . $product['portada'];
            if (file_exists($portadaPath)) {
                unlink($portadaPath); // Elimina la imagen de portada del sistema de archivos
            }
        }

        // Eliminar las imágenes de la galería
        if (!empty($product['galerias'])) {
            $galerias = json_decode($product['galerias'], true);
            foreach ($galerias as $archivo) {
                $archivoPath = "../imagenes/" . $archivo;
                if (file_exists($archivoPath)) {
                    unlink($archivoPath); // Elimina cada archivo de la galería
                }
            }
        }

        // Eliminar el registro del producto de la base de datos
        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Redirigir después de la eliminación
        header("Location: home.php"); // Cambia "home.php" a la página que prefieras
        exit;
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto inválido.";
    exit;
}
?>
