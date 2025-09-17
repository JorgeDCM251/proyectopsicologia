<?php
session_start();

// Verificar si el usuario está logueado y es administrador
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

// Limpiar la sesión si no hay búsqueda
if (!isset($_POST['buscar']) && isset($_SESSION['documento_consulta'])) {
    unset($_SESSION['documento_consulta']);
}

if (isset($_POST['buscar'])) {
    $documento = $_POST['documento'];

    // Guardar el documento en la sesión para poder regresar con los datos
    $_SESSION['documento_consulta'] = $documento;

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
            echo "<p class='error'>Este estudiante no ha resuelto ningún cuestionario.</p>";
        }
    } else {
        echo "<p class='error'>Estudiante no encontrado.</p>";
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

        <!-- Formulario de búsqueda -->
        <form action="consulta_estudiante.php" method="POST" class="search-form">
            <div class="form-group">
                <label for="documento">Ingrese el documento del estudiante:</label>
                <input 
                    type="text" 
                    name="documento" 
                    id="documento" 
                    value="<?php echo isset($_SESSION['documento_consulta']) ? htmlspecialchars($_SESSION['documento_consulta']) : ''; ?>" 
                    required>
            </div>
            <button type="submit" name="buscar" class="btn">Buscar</button>
        </form>

        <!-- Tabla de cuestionarios resueltos -->
        <?php if (count($cuestionarios) > 0): ?>
            <h2>Cuestionarios Resueltos</h2>
            <table class="question-table">
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
                            <td>
                                <a href="ver_respuestas.php?id_cuestionario=<?php echo $cuestionario['id']; ?>&id_estudiante=<?php echo $idEstudiante; ?>" class="btn">
                                    Ver Respuestas
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Botones de navegación -->
        <div class="button-container">
            <a href="dashboard.php" class="btn">Menú</a>
            <a href="logout.php" class="btn logout">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
