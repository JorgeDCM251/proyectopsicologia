<?php 
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

// Diferenciar las opciones según el tipo de usuario
$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Panel Principal</h1>

        <?php if ($tipo_usuario == 'admin'): ?>
            <a href="gestionpregunta.php">Gestionar Preguntas</a><br>
            <a href="seleccionpregunta.php">Gestionar Formulario Nuevo</a><br>
            <a href="consulta_estudiante.php">Consultar Cuestionarios Resueltos</a><br>
        <?php endif; ?>

        <a href="cuestionarios.php">Cuestionarios</a><br>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>

