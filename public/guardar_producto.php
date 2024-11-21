<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $youtube_iframe = $_POST['youtube_iframe'];

    // Directorio de destino para las imágenes y videos
    // $target_dir = "/mnt/data/imagenes/";
    $target_dir = __DIR__ . "/imagenes/";


    // Verificar si el directorio es escribible
    if (!is_writable($target_dir)) {
        die("El directorio no tiene permisos de escritura. Contacta al administrador.");
    }

    // Inicializar variables para la portada y galerías
    $portada_path = null;
    $galerias = [];

    // **1. Manejo de la Imagen de Portada**
    if (isset($_FILES["portada"]) && $_FILES["portada"]["error"] == UPLOAD_ERR_OK) {
        $portada_filename = basename($_FILES["portada"]["name"]);
        $portada_file = $target_dir . $portada_filename;
        $portada_uploadOk = 1;
        $portada_fileType = strtolower(pathinfo($portada_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen real
        $check = getimagesize($_FILES["portada"]["tmp_name"]);
        if ($check === false) {
            echo "La imagen de portada no es una imagen válida.<br>";
            $portada_uploadOk = 0;
        }

        // Permitir ciertos formatos de archivo para la portada
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($portada_fileType, $allowed_image_types)) {
            echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF para la portada.<br>";
            $portada_uploadOk = 0;
        }

        // Intentar subir la imagen de portada
        if ($portada_uploadOk) {
            if (move_uploaded_file($_FILES["portada"]["tmp_name"], $portada_file)) {
                $portada_path = $portada_filename; // Guardar solo el nombre del archivo
            } else {
                die("Error: No se pudo mover el archivo de portada. Verifica los permisos del directorio.");
            }
        }
    } else {
        echo "No se ha subido ninguna imagen de portada.<br>";
    }

    // **2. Manejo de Imágenes/Videos Adicionales**
    if (isset($_FILES['galerias']) && $_FILES['galerias']['error'][0] != UPLOAD_ERR_NO_FILE) {
        foreach ($_FILES['galerias']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['galerias']['error'][$key] == UPLOAD_ERR_OK) {
                $filename = basename($_FILES['galerias']['name'][$key]);
                $file = $target_dir . $filename;
                $uploadOk = 1;
                $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                // Permitir ciertos formatos de archivo para galerías
                $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'ogg'];
                if (!in_array($fileType, $allowed_file_types)) {
                    echo "Lo siento, el archivo $filename tiene un formato no permitido.<br>";
                    $uploadOk = 0;
                }

                // Verificar si es una imagen válida
                if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $check = getimagesize($tmp_name);
                    if ($check === false) {
                        echo "El archivo $filename no es una imagen válida.<br>";
                        $uploadOk = 0;
                    }
                }

                // Intentar subir el archivo si pasa todas las validaciones
                if ($uploadOk) {
                    if (move_uploaded_file($tmp_name, $file)) {
                        $galerias[] = $filename; // Guardar solo el nombre del archivo
                    } else {
                        echo "Lo siento, hubo un error al subir el archivo $filename.<br>";
                    }
                }
            } else {
                echo "Error al subir el archivo en galerías.<br>";
            }
        }
    }

    // **3. Insertar Datos en la Base de Datos**
    if ($portada_path) { // Asegurarse de que la portada se haya subido correctamente
        // Convertir el arreglo de galerías a JSON
        $galerias_json = !empty($galerias) ? json_encode($galerias) : NULL;

        // Escapar el código del iframe para prevenir XSS
        $youtube_iframe = htmlspecialchars($youtube_iframe, ENT_QUOTES, 'UTF-8');

        // Preparar la consulta SQL con los nuevos campos
        $stmt = $conn->prepare("INSERT INTO productos (name, description, price, portada, galerias, youtube_iframe) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . htmlspecialchars($conn->error));
        }

        // Vincular los parámetros
        $stmt->bind_param("ssdsss", $nombre, $descripcion, $precio, $portada_path, $galerias_json, $youtube_iframe);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            header('Location: home.php'); // Ajusta la ruta según corresponda
            exit(); // Asegúrate de salir después de redirigir
        } else {
            echo "Error al ejecutar la consulta: " . htmlspecialchars($stmt->error) . "<br>";
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "No se pudo subir la imagen de portada. El producto no fue guardado.<br>";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
