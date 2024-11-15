<?php
include 'config.php'; // Conexión a la base de datos

// Datos del nuevo usuario
$name = 'Mariano';
$email = 'marianomoltoni@hotmail.com';
$password = 'Hondabiz105';

// Encriptar la contraseña usando password_hash()
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Preparar la consulta para insertar el usuario
$query = "INSERT INTO usuarios (name, email, password) VALUES (?, ?, ?)";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("sss", $name, $email, $password_hash);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario registrado con éxito.";
    } else {
        // Mostrar el error si no se puede ejecutar
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    // Mostrar error si no se puede preparar la consulta
    echo "Error al preparar la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
