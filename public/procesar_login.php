<?php
// Inicia la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php'; // Conexión a la base de datos

// Limpiar y obtener datos del formulario
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($email) || empty($password)) {
    // Redirigir si faltan datos
    header("Location: login.php?error=missing_data");
    exit();
}

// Consulta para verificar al usuario administrador
$query = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Guardar datos en la sesión
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_name'] = $user['name'];

            // Redirigir al home
            header("Location: home.php");
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=incorrect_password");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: login.php?error=user_not_found");
        exit();
    }
} else {
    // Error en la preparación de la consulta
    header("Location: login.php?error=query_error");
    exit();
}
?>
