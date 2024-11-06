<?php

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

// Procesar los datos del cuestionario
if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['instrucciones'], $_POST['preguntas'], $_POST['dirigido'])) {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $instrucciones = $conn->real_escape_string($_POST['instrucciones']);
    $dirigido = $conn->real_escape_string($_POST['dirigido']); // Capturar la variable 'dirigido'
    $preguntasSeleccionadas = $_POST['preguntas'];

    // Insertar el nuevo cuestionario con la columna dirigido
    $sqlCuestionario = "INSERT INTO cuestionario (titulo, descripcion, instrucciones, dirigido) 
                        VALUES ('$titulo', '$descripcion', '$instrucciones', '$dirigido')";
    if ($conn->query($sqlCuestionario) === TRUE) {
        $idCuestionario = $conn->insert_id; // Obtener el ID del cuestionario recién creado

        // Insertar las relaciones en la tabla preguntascuestionario
        foreach ($preguntasSeleccionadas as $preguntaId) {
            $sqlRelacion = "INSERT INTO preguntascuestionario (id_cuestionario, id_pregunta) 
                            VALUES ('$idCuestionario', '$preguntaId')";
            if (!$conn->query($sqlRelacion)) {
                // Si hay un error en la inserción, mostrar un mensaje de error
                echo "Error al agregar la pregunta $preguntaId al cuestionario: " . $conn->error . "<br>";
            }
        }
        
        echo "Cuestionario creado exitosamente con ID: $idCuestionario";
    } else {
        echo "Error al crear el cuestionario: " . $conn->error;
    }
} else {
    echo "No se seleccionaron preguntas o faltan campos del cuestionario.";
}

$conn->close(); // Cerrar la conexión

header("Location: cuestionarios.php");
exit(); // Agregar exit para asegurarse de que la redirección ocurra correctamente
