<?php
session_start(); // Iniciar sesión para acceder al ID del usuario logueado

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

// Procesar las respuestas
if (isset($_POST['id_cuestionario'], $_POST['respuesta'])) {
    $idCuestionario = intval($_POST['id_cuestionario']);
    
    // Verificar que el usuario esté logueado
    if (isset($_SESSION['id_usuario'])) {
        $idUsuario = $_SESSION['id_usuario']; // Obtener el ID del usuario logueado desde la sesión

        // Asegurarse de que $_POST['respuesta'] sea un array
        if (is_array($_POST['respuesta'])) {
            $respuestas = $_POST['respuesta'];

            // Recorrer las respuestas
            foreach ($respuestas as $idPregunta => $respuesta) {
                // Obtener el id_preguntaxcuestionario
                $sqlPreguntaCuestionario = "
                    SELECT id 
                    FROM preguntascuestionario 
                    WHERE id_pregunta = '$idPregunta' AND id_cuestionario = '$idCuestionario'";
                
                $resultadoPreguntaCuestionario = $conn->query($sqlPreguntaCuestionario);
                
                if ($resultadoPreguntaCuestionario->num_rows > 0) {
                    $rowPreguntaCuestionario = $resultadoPreguntaCuestionario->fetch_assoc();
                    $idPreguntaCuestionario = $rowPreguntaCuestionario['id'];

                    // Escapar el input del usuario para evitar inyección SQL
                    $respuesta = $conn->real_escape_string($respuesta);

                    // Guardar la respuesta en la base de datos
                    $sqlRespuesta = "
                        INSERT INTO respuestaestudiante (id_estudiante, id_preguntacuestionario, respuesta1)
                        VALUES ('$idUsuario', '$idPreguntaCuestionario', '$respuesta')";

                    if (!$conn->query($sqlRespuesta)) {
                        echo "Error al guardar la respuesta: " . $conn->error;
                    }
                } else {
                    echo "No se encontró la relación entre la pregunta y el cuestionario.";
                }
            }

            // Marcar el cuestionario como resuelto para este estudiante
            $sqlCuestionarioResuelto = "
                INSERT INTO cuestionarios_resueltos (id_estudiante, id_cuestionario)
                VALUES ('$idUsuario', '$idCuestionario')";

            if (!$conn->query($sqlCuestionarioResuelto)) {
                echo "Error al registrar el cuestionario como resuelto: " . $conn->error;
            } else {
                echo "Respuestas guardadas exitosamente y cuestionario marcado como resuelto.";
            }

        } else {
            echo "Formato de respuestas incorrecto.";
        }
    } else {
        echo "El usuario no ha iniciado sesión.";
    }
} else {
    echo "No se recibieron respuestas.";
}

$conn->close(); // Cerrar la conexión

// Redirigir a la página de cuestionarios
header("Location: cuestionarios.php");
exit(); // Asegúrate de llamar a exit() después de header() para evitar que el script continúe ejecutándose.

?>
