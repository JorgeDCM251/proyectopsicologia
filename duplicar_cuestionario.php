<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "MyCLFDBss8**";
$dbname = "proyectopsicologia";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['id_cuestionario'], $_POST['nuevo_titulo'])) {
    $idCuestionarioOriginal = intval($_POST['id_cuestionario']);
    $nuevoTitulo = $conn->real_escape_string($_POST['nuevo_titulo']);

    $sqlCuestionario = "SELECT * FROM cuestionario WHERE id = '$idCuestionarioOriginal'";
    $resultadoCuestionario = $conn->query($sqlCuestionario);
    
    if ($resultadoCuestionario && $resultadoCuestionario->num_rows > 0) {
        $cuestionario = $resultadoCuestionario->fetch_assoc();
        
        // Obtener los datos del cuestionario original
        $descripcionNuevo = $conn->real_escape_string($cuestionario['descripcion']);
        $instruccionesNuevas = $conn->real_escape_string($cuestionario['instrucciones']);
        $dirigidoOriginal = $cuestionario['dirigido']; // Mantener el mismo valor de dirigido

        $sqlInsertarNuevo = "INSERT INTO cuestionario (titulo, descripcion, instrucciones, dirigido)
                              VALUES ('$nuevoTitulo', '$descripcionNuevo', '$instruccionesNuevas', '$dirigidoOriginal')";

        if ($conn->query($sqlInsertarNuevo) === TRUE) {
            echo "Cuestionario duplicado exitosamente.";
            header("Location: cuestionarios.php");
            exit();
        } else {
            echo "Error al duplicar el cuestionario: " . $conn->error;
        }
    } else {
        echo "No se encontró el cuestionario.";
    }
} else {
    echo "No se recibió el ID del cuestionario o el nuevo título.";
}

$conn->close();
?>

