<?php
session_start();
include 'config.php'; // Conexión a la base de datos

// Obtener datos del formulario
$email = trim($_POST['email']);
$password = trim($_POST['password']);

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
        exit(); // Terminar el script
    } else {
        // Contraseña incorrecta
        header("Location: login.php?error=incorrect_password");
        exit(); // Terminar el script
    }
} else {
    // Usuario no encontrado
    header("Location: login.php?error=user_not_found");
    exit(); // Terminar el script
}
?>
