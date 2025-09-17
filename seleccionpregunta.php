<?php
//session_start(); // Iniciar la sesión

// Verificar si el usuario está logueado
//if (!isset($_SESSION['usuario'])) {
//    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está logueado
//    exit();
//}

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

// Consultar todas las preguntas
$sql = "SELECT id, pregunta FROM pregunta";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuestionario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Referencia al archivo de estilos -->
</head>
<body>
    <div class="container">
        <h2>Crear Cuestionario</h2>
        <form action="guardar_cuestionario.php" method="POST">
            <!-- Grupo de formulario para el título -->
            <div class="form-group">
                <label for="titulo">Título del Cuestionario:</label>
                <input type="text" id="titulo" name="titulo" class="rounded" required>
            </div>

            <!-- Grupo de formulario para la descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="rounded" required></textarea>
            </div>

            <!-- Grupo de formulario para las instrucciones -->
            <div class="form-group">
                <label for="instrucciones">Instrucciones:</label>
                <textarea id="instrucciones" name="instrucciones" class="rounded" required></textarea>
            </div>

            <!-- Grupo de formulario para seleccionar a quién está dirigido -->
            <div class="form-group">
                <label for="dirigido">Dirigido a:</label>
                <select name="dirigido" id="dirigido" class="rounded" required>
                    <option value="Estudiantes">Estudiantes</option>
                    <option value="Gestor">Gestor</option>
                </select>
            </div>

            <!-- Título para la sección de selección de preguntas -->
            <h3>Seleccionar Preguntas para el Cuestionario</h3>

            <!-- Tabla de preguntas -->
            <table class="question-table">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>ID Pregunta</th>
                        <th>Pregunta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Mostrar cada pregunta con una casilla de verificación
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td><input type='checkbox' name='preguntas[]' value='{$row['id']}'></td>
                                    <td>{$row['id']}</td>
                                    <td>{$row['pregunta']}</td>
                                  </tr>";
                        }
                    } else {
                        // Mensaje si no hay preguntas registradas
                        echo "<tr><td colspan='3' class='no-data'>No hay preguntas registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Botón para guardar el cuestionario -->
            <div class="form-group">
                <button type="submit" class="btn">Guardar Cuestionario</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close(); // Cerrar la conexión
?>