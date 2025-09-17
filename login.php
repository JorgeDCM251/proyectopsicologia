<?php
session_start(); // Iniciar la sesión

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

$error = ""; // Variable para almacenar mensajes de error

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];
    $password = $_POST['password'];

    // Usar consultas preparadas para mayor seguridad
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_usuario'] = $row['id']; // ID del usuario
            $_SESSION['tipo_usuario'] = $row['tipo_usuario']; // Tipo de usuario

            // Redirigir a dashboard.php
            header("Location: dashboard.php");
            exit(); // Asegurar que el script se detenga después de la redirección
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Documento de identidad no encontrado.";
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
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form method="POST" action="login.php" class="login-form">
            <label for="documento">Documento de Identidad:</label>
            <input type="text" id="documento" name="documento" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
