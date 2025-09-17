<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyectopsicologia";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el identificador está en la URL para mostrar la pregunta
if (isset($_GET['id'])) {
    // Escapar el identificador como una cadena
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT pregunta FROM pregunta WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pregunta = $row['pregunta'];
    } else {
        echo "Pregunta no encontrada.";
        exit();
    }
} elseif (isset($_POST['id'], $_POST['pregunta'])) {
    // Actualizar la pregunta en la base de datos
    $id = $conn->real_escape_string($_POST['id']);
    $pregunta = $conn->real_escape_string($_POST['pregunta']);
    $sql = "UPDATE pregunta SET pregunta = '$pregunta' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Pregunta actualizada exitosamente.";
        header("Location: seleccionpregunta.php");
        exit();
    } else {
        echo "Error al actualizar la pregunta: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <h2>Editar Pregunta</h2>
    <form action="editar_pregunta.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label for="pregunta">Pregunta:</label>
        <textarea id="pregunta" name="pregunta" required><?php echo htmlspecialchars($pregunta); ?></textarea>
        <br><br>
        <input class = "boton" type="submit" value="Actualizar Pregunta">
    </form>
</body>
</html>
