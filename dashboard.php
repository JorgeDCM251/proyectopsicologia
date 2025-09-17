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
            <a href="gestionpregunta.php" class="btn">Gestionar Preguntas</a>
            <a href="seleccionpregunta.php" class="btn">Gestionar Formulario Nuevo</a>
            <a href="consulta_estudiante.php" class="btn">Consultar Cuestionarios Resueltos</a>
            <a href="Ver-Resultados.php" class="btn">Ver Resultados</a>
            <a href="PowerBI.html" class="btn">Ver Reporte</a> <!-- Solo visible para admin -->
        <?php endif; ?>

        <a href="cuestionarios.php" class="btn">Cuestionarios</a>
        <a href="logout.php" class="btn logout">Cerrar Sesión</a>
    </div>
</body>
</html>

