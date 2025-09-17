<?php
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

// Obtener el ID del cuestionario
$idCuestionario = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar la descripción e instrucciones del cuestionario
$sqlCuestionario = "
    SELECT titulo, descripcion, instrucciones 
    FROM cuestionario 
    WHERE id = $idCuestionario";
$resultCuestionario = $conn->query($sqlCuestionario);

// Verificar si se encontró el cuestionario
if ($resultCuestionario->num_rows > 0) {
    $cuestionario = $resultCuestionario->fetch_assoc();
} else {
    echo "No se encontró el cuestionario.";
    exit;
}

// Consultar las preguntas del cuestionario
$sqlPreguntas = "
    SELECT pq.id_pregunta, p.pregunta, p.tipo_pregunta, 
           op_pregunta1, op_pregunta2, op_pregunta3, 
           op_pregunta4, op_pregunta5, op_pregunta6,
           op_pregunta7, op_pregunta8, op_pregunta9, 
           op_pregunta10, op_pregunta11
    FROM preguntascuestionario pq 
    JOIN pregunta p ON pq.id_pregunta = p.id 
    WHERE pq.id_cuestionario = $idCuestionario";
$resultPreguntas = $conn->query($sqlPreguntas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder Cuestionario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Hoja de estilos -->
</head>
<body>
    <div class="container">
        <h1><?php echo $cuestionario['titulo']; ?></h1>
        <p><strong>Descripción:</strong> <?php echo $cuestionario['descripcion']; ?></p>
        <p><strong>Instrucciones:</strong> <?php echo $cuestionario['instrucciones']; ?></p>

        <form action="guardar_respuestas.php" method="POST">
            <input type="hidden" name="id_cuestionario" value="<?php echo $idCuestionario; ?>">

            <?php if ($resultPreguntas->num_rows > 0): ?>
                <table class="likert-table">
                    <thead>
                        <tr>
                            <th>Pregunta</th>
                            <th colspan="11">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultPreguntas->fetch_assoc()): ?>
                            <?php if ($row['tipo_pregunta'] === 'abierta'): ?>
                                </tbody>
                                </table>

                                <div class="question-abierta">
                                    <h3><?php echo $row['pregunta']; ?></h3>
                                    <textarea name="respuesta[<?php echo $row['id_pregunta']; ?>]" rows="4" placeholder="Escribe tu respuesta aquí..." required></textarea>
                                </div>

                                <table class="likert-table">
                                <tbody>
                            <?php else: ?>
                                <tr>
                                    <td><?php echo $row['pregunta']; ?></td>
                                    <?php
                                    $opciones = [
                                        $row['op_pregunta1'], $row['op_pregunta2'], $row['op_pregunta3'],
                                        $row['op_pregunta4'], $row['op_pregunta5'], $row['op_pregunta6'],
                                        $row['op_pregunta7'], $row['op_pregunta8'], $row['op_pregunta9'],
                                        $row['op_pregunta10'], $row['op_pregunta11']
                                    ];
                                    foreach ($opciones as $opcion):
                                        if (!empty($opcion)): ?>
                                            <td>
                                                <label>
                                                    <input type="radio" name="respuesta[<?php echo $row['id_pregunta']; ?>]" value="<?php echo htmlspecialchars($opcion); ?>" required>
                                                    <?php echo htmlspecialchars($opcion); ?>
                                                </label>
                                            </td>
                                        <?php endif;
                                    endforeach; ?>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No hay preguntas para este cuestionario.</p>
            <?php endif; ?>

            <button class="btn" type="submit">Enviar Respuestas</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>



