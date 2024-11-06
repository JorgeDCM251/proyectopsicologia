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
	<p>
        <a href="https://www.udistrital.edu.co/inicio"><img src="images/logo.png" width="400px"></a>
    </p>
    <div class="page-header">
        <h1>Hola, Bienvenid@ al proyecto de salud mental.</h1>
        <p>
    </p>
    <header>
        <div class="container">
            <h1>Opciones :</h1>
            <a href="register.php">Registrarse</a>
            <a href="login.php">Iniciar Sesión</a>
        </div>
    </header>
</body>
</html>

