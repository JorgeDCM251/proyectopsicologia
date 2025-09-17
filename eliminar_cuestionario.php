<?php
session_start();

// Verificar si el usuario está logueado y es admin
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo "Acceso no autorizado.";
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyectopsicologia";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió el ID del cuestionario
if (isset($_POST['id_cuestionario'])) {
    $idCuestionario = intval($_POST['id_cuestionario']);

    // Eliminar las respuestas del estudiante asociadas al cuestionario
    $sqlEliminarRespuestasEstudiante = "DELETE FROM respuestaestudiante WHERE id_preguntacuestionario IN (SELECT id FROM preguntascuestionario WHERE id_cuestionario = '$idCuestionario')";

    if ($conn->query($sqlEliminarRespuestasEstudiante) === TRUE) {
        // Eliminar las preguntas asociadas al cuestionario en la tabla preguntascuestionario
        $sqlEliminarPreguntas = "DELETE FROM preguntascuestionario WHERE id_cuestionario = '$idCuestionario'";

        if ($conn->query($sqlEliminarPreguntas) === TRUE) {
            // Eliminar las respuestas asociadas al cuestionario en la tabla cuestionarios_resueltos
            $sqlEliminarRespuestas = "DELETE FROM cuestionarios_resueltos WHERE id_cuestionario = '$idCuestionario'";

            if ($conn->query($sqlEliminarRespuestas) === TRUE) {
                // Ahora eliminar el cuestionario
                $sqlEliminar = "DELETE FROM cuestionario WHERE id = '$idCuestionario'";

                if ($conn->query($sqlEliminar) === TRUE) {
                    echo "Cuestionario eliminado exitosamente.";
                    header("Location: cuestionarios.php"); // Redirigir después de eliminar
                    exit();
                } else {
                    echo "Error al eliminar el cuestionario: " . $conn->error;
                }
            } else {
                echo "Error al eliminar las respuestas del cuestionario: " . $conn->error;
            }
        } else {
            echo "Error al eliminar las preguntas del cuestionario: " . $conn->error;
        }
    } else {
        echo "Error al eliminar las respuestas de los estudiantes: " . $conn->error;
    }
} else {
    echo "No se recibió el ID del cuestionario.";
}

$conn->close();
?>
