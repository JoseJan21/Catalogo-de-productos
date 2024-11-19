<?php
session_start();
include 'config.php'; // Conexión a la base de datos

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta para verificar al usuario administrador
$query = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Verificar la contraseña
    if (password_verify($password, $user['password'])) { // password_verify para comparar contraseñas hash
        // Guardar el estado de la sesión
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_name'] = $user['name'];
        
        // Redirigir al home
        header("Location: home.php");
        exit();
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta.";
    }
} else {
    // Usuario no encontrado
    echo "Correo electrónico no encontrado.";
}
?>
