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
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <h2>Crear Cuestionario</h2>
    <form action="guardar_cuestionario.php" method="POST">
        <label for="titulo">Título del Cuestionario:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br><br>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        <br><br>

        <label for="instrucciones">Instrucciones:</label>
        <textarea id="instrucciones" name="instrucciones" required></textarea>
        <br><br>

        <label for="dirigido">Dirigido a:</label>
        <select name="dirigido" id="dirigido" required>
            <option value="Estudiantes">Estudiantes</option>
            <option value="Gestor">Gestor</option>
        </select>
        <br><br>

        <h3>Seleccionar Preguntas para el Cuestionario</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>ID Pregunta</th>
                    <th>Pregunta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Mostrar cada pregunta con una casilla de verificación y opciones de editar/eliminar
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td><input type='checkbox' name='preguntas[]' value='{$row['id']}'></td>
                                <td>{$row['id']}</td>
                                <td>{$row['pregunta']}</td>
                                <td>
                                    <a href='editar_pregunta.php?id={$row['id']}'>Editar</a> |
                                    <a href='eliminar_pregunta.php?id={$row['id']}' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta pregunta?\");'>Eliminar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay preguntas registradas.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <input class="boton" type="submit" value="Guardar Cuestionario">
    </form>
</body>
</html>

<?php
$conn->close(); // Cerrar la conexión
?>
