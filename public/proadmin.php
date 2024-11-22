<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../imagenes/logo.png" type="image/x-icon">

</head>
<body>
    <?php include "header.php"; ?>

    <div class="form">
        <form action="procesar_login.php" method="POST">
            <h2>Iniciar Sesión</h2>
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
    <!-- Incluir el footer -->
    <?php include 'footer.php'; ?>
</body>
</html>