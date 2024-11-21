<?php
include 'config.php';
include 'config_cloudinary.php';

use Cloudinary\Api\Upload\UploadApi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $youtube_iframe = htmlspecialchars($_POST['youtube_iframe'], ENT_QUOTES, 'UTF-8');

    // Inicializar variables para la portada y galerías
    $portada_path = null;
    $galerias = [];

    // **1. Subir Imagen de Portada a Cloudinary**
    if (isset($_FILES["portada"]) && $_FILES["portada"]["error"] == UPLOAD_ERR_OK) {
        $tempFile = $_FILES["portada"]["tmp_name"];
        try {
            $result = (new UploadApi())->upload($tempFile, [
                'folder' => 'productos/portadas' // Carpeta en Cloudinary
            ]);
            $portada_path = $result['secure_url']; // Guardar la URL de la imagen subida
        } catch (Exception $e) {
            echo "Error al subir la imagen de portada: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "No se ha subido ninguna imagen de portada.<br>";
    }

    // **2. Subir Imágenes/Videos de Galerías a Cloudinary**
    if (isset($_FILES['galerias']) && $_FILES['galerias']['error'][0] != UPLOAD_ERR_NO_FILE) {
        foreach ($_FILES['galerias']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['galerias']['error'][$key] == UPLOAD_ERR_OK) {
                try {
                    $result = (new UploadApi())->upload($tmp_name, [
                        'folder' => 'productos/galerias' // Carpeta en Cloudinary
                    ]);
                    $galerias[] = $result['secure_url']; // Guardar la URL del archivo subido
                } catch (Exception $e) {
                    echo "Error al subir el archivo " . $_FILES['galerias']['name'][$key] . ": " . $e->getMessage() . "<br>";
                }
            } else {
                echo "Error al subir el archivo en galerías.<br>";
            }
        }
    }

    // **3. Insertar Datos en la Base de Datos**
    if ($portada_path) { // Solo procede si la portada fue subida correctamente
        $galerias_json = !empty($galerias) ? json_encode($galerias) : NULL;

        $stmt = $conn->prepare("INSERT INTO productos (name, description, price, portada, galerias, youtube_iframe) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("ssdsss", $nombre, $descripcion, $precio, $portada_path, $galerias_json, $youtube_iframe);

        if ($stmt->execute()) {
            header('Location: home.php');
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . htmlspecialchars($stmt->error) . "<br>";
        }

        $stmt->close();
    } else {
        echo "No se pudo subir la imagen de portada. El producto no fue guardado.<br>";
    }

    $conn->close();
}
?>