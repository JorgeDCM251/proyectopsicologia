<?php
session_start();

// Verificar si el usuario es un administrador
if ($_SESSION['tipo_usuario'] != 'admin') {
    die("Acceso denegado.");
}

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

// Definir el mapeo de las aplicaciones y las pruebas
$aplicaciones = [
    1 => [14, 15, 16, 17, 18],
    2 => [21, 25, 29, 33, 37],
    3 => [22, 26, 30, 34, 38],
    4 => [23, 27, 31, 35, 39],
    5 => [24, 28, 32, 36, 40]
];

$pruebas = [
    'experiencias_adversas' => [14, 21, 22, 23, 24],
    'escala_autocuidado' => [15, 25, 26, 27, 28],
    'escala_disociativa' => [16, 29, 30, 31, 32],
    'escala_ansiedad' => [17, 33, 34, 35, 36],
    'PCL5' => [18, 37, 38, 39, 40]
];

// Inicializar las condiciones de la consulta
$condiciones = [];
$params = [];
$types = '';

if (isset($_GET['documento']) && !empty($_GET['documento'])) {
    $condiciones[] = "u.username LIKE ?";
    $params[] = '%' . $_GET['documento'] . '%';
    $types .= 's';
}

if (isset($_GET['prueba']) && !empty($_GET['prueba']) && isset($_GET['aplicacion']) && !empty($_GET['aplicacion'])) {
    // Obtener el nombre de la prueba y el número de aplicación
    $prueba_seleccionada = $_GET['prueba'];
    $aplicacion_seleccionada = $_GET['aplicacion'];

    // Verificar si la prueba y la aplicación existen
    if (isset($pruebas[$prueba_seleccionada]) && isset($aplicaciones[$aplicacion_seleccionada])) {
        // Obtener los IDs de la prueba y la aplicación
        $ids_prueba = $pruebas[$prueba_seleccionada];
        $ids_aplicacion = $aplicaciones[$aplicacion_seleccionada];

        // Encontrar el ID común entre la prueba y la aplicación
        $id_cuestionario = array_intersect($ids_prueba, $ids_aplicacion);

        if (!empty($id_cuestionario)) {
            $id_cuestionario = array_values($id_cuestionario)[0]; // Obtener el primer (y único) ID común
            $condiciones[] = "r.id_cuestionario = ?";
            $params[] = $id_cuestionario;
            $types .= 'i';
        }
    }
}

// Consultar los resultados de la tabla 'Tabla_resultados'
$sql = "SELECT r.*, u.username FROM Tabla_resultados r JOIN users u ON r.id_estudiante = u.id";
if (count($condiciones) > 0) {
    $sql .= " WHERE " . implode(' AND ', $condiciones);
}

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Enlazar los parámetros
if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Psicología</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Resultados de las Pruebas Psicológicas</h1>

    <!-- Filtro de búsqueda -->
    <form action="Ver-Resultados.php" method="get" class="search-form">
        <div class="form-group">
            <label for="documento">Documento:</label>
            <input type="text" name="documento" id="documento" value="<?php echo isset($_GET['documento']) ? $_GET['documento'] : ''; ?>" placeholder="Buscar por Documento">
        </div>

        <div class="form-group">
            <label for="prueba">Prueba:</label>
            <select name="prueba" id="prueba">
                <option value="">Seleccionar Prueba</option>
                <?php
                foreach ($pruebas as $nombre_prueba => $ids) {
                    echo "<option value='$nombre_prueba' " . (isset($_GET['prueba']) && $_GET['prueba'] == $nombre_prueba ? 'selected' : '') . ">$nombre_prueba</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="aplicacion">Aplicación:</label>
            <select name="aplicacion" id="aplicacion">
                <option value="">Seleccionar Aplicación</option>
                <?php
                foreach ($aplicaciones as $numero_aplicacion => $ids) {
                    echo "<option value='$numero_aplicacion' " . (isset($_GET['aplicacion']) && $_GET['aplicacion'] == $numero_aplicacion ? 'selected' : '') . ">Aplicación $numero_aplicacion</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit">Filtrar</button>
    </form>

    <!-- Mostrar los resultados en una tabla -->
    <div class="table-container">
        <table class="respuestas-table rounded shadow bg-white">
            <thead>
                <tr>
                    <th>ID Estudiante</th>
                    <th>Documento</th>
                    <th>Prueba</th>
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
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    // Mostrar cada fila de resultados
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_estudiante'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";

                        // Determinar la aplicación en base al id_cuestionario
                        $aplicacion = "Desconocida";
                        foreach ($aplicaciones as $numero_aplicacion => $ids) {
                            if (in_array($row['id_cuestionario'], $ids)) {
                                $aplicacion = "Aplicación " . $numero_aplicacion;
                                break;
                            }
                        }
                        echo "<td>" . $aplicacion . "</td>";

                        // Mostrar solo las respuestas no vacías
                        for ($i = 1; $i <= 10; $i++) {
                            $respuesta = 'respuesta_' . $i;
                            if (!empty($row[$respuesta])) {
                                echo "<td>" . $row[$respuesta] . "</td>";
                            } else {
                                echo "<td>-</td>";  // Mostrar un guion si está vacío
                            }
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13' class='no-data'>No se han encontrado resultados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Botón de regreso -->
<div class="button-container">
    <a href="dashboard.php" class="btn">Regresar al Dashboard</a>
</div>

</body>
</html>

<?php
$conn->close();
?>

