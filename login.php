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

$mensaje_error = ""; // Variable para almacenar mensajes de error

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos
    $sql = "SELECT * FROM users WHERE username='$documento'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Guardar información en la sesión
            $_SESSION['id_usuario'] = $row['id']; // ID del usuario
            $_SESSION['tipo_usuario'] = $row['tipo_usuario']; // Tipo de usuario

            // Redirigir a dashboard.php
            header("Location: dashboard.php");
            exit(); // Asegurar que el script se detenga después de la redirección
        } else {
            $mensaje_error = "Contraseña incorrecta!";
        }
    } else {
        $mensaje_error = "Documento de identidad no encontrado!";
    }
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
    <style>
        /* Estilo para el recuadro del mensaje de error */
        .alerta {
            border: 1px solid red;
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <form method="POST" action="login.php">
            <label for="documento">Documento de Identidad:</label><br>
            <input type="text" id="documento" name="documento" required><br><br>

            <!-- Mostrar mensaje de error aquí, entre el documento y la contraseña -->
            <?php if (!empty($mensaje_error)): ?>
                <div class="alerta">
                    <?php echo $mensaje_error; ?>
                </div>
            <?php endif; ?>

            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button class="boton" type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
