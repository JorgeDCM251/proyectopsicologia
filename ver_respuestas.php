<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}

// Verificar si los parámetros existen
if (!isset($_GET['id_cuestionario']) || !isset($_GET['id_estudiante'])) {
    echo "Faltan parámetros en la URL.";
    exit;
}

$id_cuestionario = $_GET['id_cuestionario'];
$id_estudiante = $_GET['id_estudiante'];

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

// Consultar las preguntas y respuestas del cuestionario resuelto
$sql = "
    SELECT p.pregunta, re.respuesta1
    FROM pregunta p
    JOIN preguntascuestionario pc ON p.id = pc.id_pregunta
    JOIN respuestaestudiante re ON re.id_preguntacuestionario = pc.id
    WHERE re.id_estudiante = '$id_estudiante' AND pc.id_cuestionario = '$id_cuestionario'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Ver Respuestas</title>
</head>
<body>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<h1>Respuestas del Cuestionario</h1>";
            echo "<table class='respuestas-table'>";
            echo "<tr><th>Pregunta</th><th>Respuesta</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['pregunta']) . "</td>";
                echo "<td>" . htmlspecialchars($row['respuesta1']) . "</td>"; // Muestra la primera respuesta
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<div class='no-data'>No se encontraron respuestas para este cuestionario.</div>";
        }

        $conn->close();
        ?>
    </div>

    <div class="button-container">
        <a href="consulta_estudiante.php?documento=<?php echo $_SESSION['documento_consulta']; ?>" class="btn">Volver a Consultar Cuestionarios</a>
        <a href="dashboard.php" class="btn">Menú</a>
        <a href="logout.php" class="btn logout">Cerrar Sesión</a>
    </div>
</body>
</html>