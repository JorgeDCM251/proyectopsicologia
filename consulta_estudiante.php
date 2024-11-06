<?php 
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "MyCLFDBss8**";
$dbname = "proyectopsicologia";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$cuestionarios = [];

if (isset($_POST['buscar'])) {
    $documento = $_POST['documento'];

    // Consulta para obtener el id del estudiante según su username
    $sqlEstudiante = "SELECT id FROM users WHERE username = '$documento'";
    $resultEstudiante = $conn->query($sqlEstudiante);

    if ($resultEstudiante->num_rows > 0) {
        $idEstudiante = $resultEstudiante->fetch_assoc()['id'];

        // Consulta para obtener los cuestionarios resueltos por el estudiante
        $sqlCuestionarios = "
            SELECT c.id, c.titulo, cr.fecha_resolucion 
            FROM cuestionario c
            JOIN cuestionarios_resueltos cr ON c.id = cr.id_cuestionario
            WHERE cr.id_estudiante = '$idEstudiante'
        ";
        $resultCuestionarios = $conn->query($sqlCuestionarios);

        if ($resultCuestionarios->num_rows > 0) {
            while ($row = $resultCuestionarios->fetch_assoc()) {
                $cuestionarios[] = $row;
            }
        } else {
            echo "Este estudiante no ha resuelto ningún cuestionario.";
        }
    } else {
        echo "Estudiante no encontrado.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Cuestionarios Resueltos</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Consultar Cuestionarios Resueltos</h1>

        <form action="consulta_estudiante.php" method="POST">
            <label for="documento">Ingrese el documento del estudiante:</label>
            <input type="text" name="documento" id="documento" required>
            <button class = "boton" type="submit" name="buscar">Buscar</button>
        </form>

        <?php if (count($cuestionarios) > 0): ?>
            <h2>Cuestionarios Resueltos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Cuestionario</th>
                        <th>Título</th>
                        <th>Fecha de Resolución</th>
                        <th>Ver Respuestas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cuestionarios as $cuestionario): ?>
                        <tr>
                            <td><?php echo $cuestionario['id']; ?></td>
                            <td><?php echo $cuestionario['titulo']; ?></td>
                            <td><?php echo $cuestionario['fecha_resolucion']; ?></td>
                            <td><a href="ver_respuestas.php?id_cuestionario=<?php echo $cuestionario['id']; ?>&id_estudiante=<?php echo $idEstudiante; ?>">Ver Respuestas</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <a href="dashboard.php">Menu</a><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
$conn->close();
?>
