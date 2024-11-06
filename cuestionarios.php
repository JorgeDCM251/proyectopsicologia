<?php
session_start(); 

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

// Verificar si el usuario está logueado
if (isset($_SESSION['id_usuario'])) {
    $idUsuario = $_SESSION['id_usuario']; // Obtener el ID del usuario logueado

    // Consultar el tipo de usuario
    $sqlTipo = "SELECT tipo_usuario FROM users WHERE id = '$idUsuario'";
    $resultTipo = $conn->query($sqlTipo);
    $tipoUsuario = $resultTipo->fetch_assoc()['tipo_usuario'];

    // Consultar los cuestionarios según el tipo de usuario
    if ($tipoUsuario === 'admin') {
        // Para los gestores (admin), mostrar todos los cuestionarios dirigidos a Gestores sin filtro de resueltos
        $sql = "
            SELECT c.id, c.titulo 
            FROM cuestionario c";
    } elseif ($tipoUsuario === 'estudiante') {
        // Para los estudiantes, mostrar solo cuestionarios dirigidos a Estudiantes que no han sido respondidos
        $sql = "
            SELECT c.id, c.titulo 
            FROM cuestionario c
            LEFT JOIN cuestionarios_resueltos cr 
            ON c.id = cr.id_cuestionario AND cr.id_estudiante = '$idUsuario'
            WHERE cr.id_cuestionario IS NULL AND c.dirigido = 'Estudiantes'";
    } else {
        echo "Tipo de usuario no reconocido.";
        exit();
    }

    $result = $conn->query($sql);
} else {
    echo "El usuario no ha iniciado sesión.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Cuestionario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Referencia al archivo de estilos -->
</head>
<body>
    <div class="container">
        <h1>Seleccionar Cuestionario</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['titulo']; ?></td>
                            <td>
                                <?php if ($tipoUsuario === 'admin'): ?>
                                    <!-- Opciones de Duplicar y Eliminar para el usuario admin -->
                                    <form action="duplicar_cuestionario.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_cuestionario" value="<?php echo $row['id']; ?>">
                                        <input type="text" name="nuevo_titulo" placeholder="Nuevo título" required>
                                        <button class="boton" type="submit">Duplicar</button>
                                    </form>
                                    <form action="eliminar_cuestionario.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_cuestionario" value="<?php echo $row['id']; ?>">
                                        <button class="boton" type="submit" onclick="return confirm('¿Estás seguro de eliminar este cuestionario?')">Eliminar</button>
                                    </form>
                                <?php else: ?>
                                    <!-- Opción Responder solo para estudiantes -->
                                    <a href="responder.php?id=<?php echo $row['id']; ?>">Responder</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="no-data">No hay cuestionarios disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php">Menú</a><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
$conn->close(); // Cerrar la conexión
?>
