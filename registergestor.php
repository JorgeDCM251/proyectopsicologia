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

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];  // Documento de identidad como usuario
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Insertar en la tabla users, asumiendo que el tipo de usuario por defecto es 'estudiante'
    $sql = "INSERT INTO users (username, password, tipo_usuario) VALUES ('$documento', '$password', 'admin')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir al login después de un registro exitoso
        header("Location: login.php");
        exit(); // Asegurarse de que el script se detiene después de la redirección
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
	<p>
        <a href="https://www.udistrital.edu.co/inicio"><img src="images/logo.png" width="400px"></a>
    </p>
    <div class="page-header">
        <p>
    <div class ="container">
    <h2>Formulario de Registro Gestor</h2>
    </div>
    
    <div class ="container">
    <form method="POST" action="registergestor.php">
        <label for="documento">Usuario (Documento de Identidad):</label><br>
        <input type="text" id="documento" name="documento" required><br><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button class="boton" type="submit">Registrarse</button>
    </form>
    </div>
</body>
</html>

