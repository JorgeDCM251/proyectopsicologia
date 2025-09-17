<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "MyCLFDBss8**";
$dbname = "proyectopsicologia";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el identificador está en la URL para eliminar la pregunta
if (isset($_GET['id'])) {
    // Escapar el identificador como una cadena
    $id = $conn->real_escape_string($_GET['id']);

    // Primero, obtener los ids en preguntascuestionario que se relacionan con la pregunta a eliminar
    $queryPreguntascuestionario = "SELECT id FROM preguntascuestionario WHERE id_pregunta = '$id'";
    $result = $conn->query($queryPreguntascuestionario);

    if ($result->num_rows > 0) {
        // Recorrer los ids obtenidos para eliminarlos de respuestaestudiante
        while ($row = $result->fetch_assoc()) {
            $idPreguntascuestionario = $row['id'];

            // Eliminar referencias en respuestaestudiante para cada id en preguntascuestionario
            $sqlDeleteRespuestas = "DELETE FROM respuestaestudiante WHERE id_preguntacuestionario = '$idPreguntascuestionario'";
            if ($conn->query($sqlDeleteRespuestas) !== TRUE) {
                echo "Error al eliminar las respuestas en respuestaestudiante: " . $conn->error;
                exit();
            }
        }

        // Luego, eliminar las referencias en preguntascuestionario
        $sqlDeleteReferences = "DELETE FROM preguntascuestionario WHERE id_pregunta = '$id'";
        if ($conn->query($sqlDeleteReferences) === TRUE) {
            echo "Referencias eliminadas de la tabla preguntascuestionario.<br>";

            // Eliminar la pregunta en la tabla principal
            $sqlDeleteQuestion = "DELETE FROM pregunta WHERE id = '$id'";
            if ($conn->query($sqlDeleteQuestion) === TRUE) {
                echo "Pregunta eliminada exitosamente.";
                header("Location: seleccionpregunta.php"); // Redirecciona después de la eliminación
                exit();
            } else {
                echo "Error al eliminar la pregunta en la tabla principal: " . $conn->error;
            }
        } else {
            echo "Error al eliminar las referencias en preguntascuestionario: " . $conn->error;
        }
    } else {
        echo "No se encontraron referencias en preguntascuestionario para el id proporcionado.<br>";
    }
} else {
    echo "ID de la pregunta no proporcionado.";
}

$conn->close();
?>
