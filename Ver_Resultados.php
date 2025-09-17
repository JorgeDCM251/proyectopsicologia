<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$dbname = "proyectopsicologia";
$user = "root";
$password = "MyCLFDBss8**";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Definir los tipos de pruebas y sus IDs de cuestionario
$pruebas = [
    "experiencias_adversas" => [14, 21, 22, 23, 24],
    "escala_autocuidado" => [15, 25, 26, 27, 28],
    "escala_disociativa" => [16, 29, 30, 31, 32],
    "escala_ansiedad" => [17, 33, 34, 35, 36],
    "PCL5" => [18, 37, 38, 39, 40]
];

// Obtener el tipo de prueba seleccionado
$tipo_prueba = isset($_GET['tipo_prueba']) ? $_GET['tipo_prueba'] : null;
$resultados = [];

// Si se seleccionó un tipo de prueba, obtener los resultados
if ($tipo_prueba && isset($pruebas[$tipo_prueba])) {
    $ids_cuestionario = implode(",", $pruebas[$tipo_prueba]);
    $query = "SELECT * FROM Tabla_resultado WHERE id_cuestionario IN ($ids_cuestionario)";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Pruebas Psicológicas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Resultados de Pruebas Psicológicas</h1>
        <form method="GET" action="">
            <label for="tipo_prueba">Seleccione el tipo de prueba:</label>
            <select name="tipo_prueba" id="tipo_prueba">
                <option value="">-- Seleccione --</option>
                <?php foreach ($pruebas as $nombre => $ids): ?>
                    <option value="<?php echo $nombre; ?>" <?php echo ($tipo_prueba == $nombre) ? 'selected' : ''; ?>>
                        <?php echo ucfirst(str_replace("_", " ", $nombre)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="boton">Filtrar</button>
        </form>

        <?php if ($tipo_prueba): ?>
            <h2>Resultados de <?php echo ucfirst(str_replace("_", " ", $tipo_prueba)); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Estudiante</th>
                        <th>ID Cuestionario</th>
                        <th>Respuesta 1</th>
                        <th>Respuesta 2</th>
                        <th>Respuesta 3</th>
                        <th>Respuesta 4</th>
                        <th>Respuesta 5</th>
                        <th>Respuesta 6</th>
                        <th>Respuesta 7</th>
                        <th>Respuesta 8</th>
                        <th>Respuesta 9</th>
                        <th>Respuesta 10</th>
                        <th>Columna 11</th>
                        <th>Columna 12</th>
                        <th>Columna 13</th>
                        <th>Columna 14</th>
                        <th>Columna 15</th>
                        <th>Columna 16</th>
                        <th>Columna 17</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($resultados) > 0): ?>
                        <?php foreach ($resultados as $fila): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['id_estudiante']); ?></td>
                                <td><?php echo htmlspecialchars($fila['id_cuestionario']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_1']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_2']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_3']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_4']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_5']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_6']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_7']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_8']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_9']); ?></td>
                                <td><?php echo htmlspecialchars($fila['respuesta_10']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_11']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_12']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_13']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_14']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_15']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_16']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nueva_columna_17']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="19" class="no-data">No hay resultados para este tipo de prueba.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>