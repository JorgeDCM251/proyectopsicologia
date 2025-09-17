<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$error = ""; // Variable para mostrar errores

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $facultad = $_POST['facultad']; // Capturar la facultad seleccionada

    // Consulta preparada para evitar inyección SQL
    $stmt = $conn->prepare("INSERT INTO users (username, password, facultad, tipo_usuario) VALUES (?, ?, ?, 'estudiante')");
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
    <title>Registro de Estudiante</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Estudiante</h2>

        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form method="POST" action="register.php">
            <label for="documento">Documento de Identidad:</label>
            <input type="text" id="documento" name="documento" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="facultad">Facultad:</label>
            <select id="facultad" name="facultad" required>
                <option value="">Selecciona una facultad</option>
                <option value="ASAB">ASAB</option>
                <option value="Macarena">Macarena</option>
                <option value="Vivero">Vivero</option>
                <option value="Bosa">Bosa</option>
                <option value="Tecnologica">Tecnológica</option>
                <option value="Ingenieria">Ingeniería</option>
            </select>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>
