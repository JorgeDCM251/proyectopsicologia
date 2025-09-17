<?php
session_start(); // Iniciar la sesión

// Si el usuario ya está logueado, lo redirigimos al dashboard
if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <header class="header">
        <div class="container">
            <img src="http://145.223.126.108/images/logo.png" alt="Logo del Proyecto" class="logo">
            <h1>Bienvenido, Proyecto de Salud Mental UD</h1>
            <div class="button-container">
                <a href="register.php" class="btn">Registrarse</a>
                <a href="login.php" class="btn">Iniciar Sesión</a>
            </div>
        </div>
    </header>
</body>
</html>
