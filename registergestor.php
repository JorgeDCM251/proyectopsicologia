<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "MyCLFDBss8**";
$dbname = "proyectopsicologia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$error = ""; // Variable para mensajes de error

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];  
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $facultad = "Administrativo"; // Asignar automáticamente "Administrativo"

    // Consulta preparada para mayor seguridad
    $stmt = $conn->prepare("INSERT INTO users (username, password, tipo_usuario, facultad) VALUES (?, ?, 'admin', ?)");
    $stmt->bind_param("sss", $documento, $password, $facultad);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error en el registro. Inténtelo de nuevo.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Gestor</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h2>Registro de Gestor</h2>

        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form method="POST" action="registergestor.php">  
            <label for="documento">Documento de Identidad:</label>
            <input type="text" id="documento" name="documento" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>


