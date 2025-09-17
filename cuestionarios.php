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
if (!isset($_SESSION['id_usuario'])) {
    echo "El usuario no ha iniciado sesión.";
    exit();
}

$idUsuario = (int)$_SESSION['id_usuario'];

// (Opcional) obtener tipo de usuario
$sqlTipo = "SELECT tipo_usuario FROM users WHERE id = ?";
$stmtTipo = $conn->prepare($sqlTipo);
$stmtTipo->bind_param("i", $idUsuario);
$stmtTipo->execute();
$resultTipo = $stmtTipo->get_result();
$tipoUsuarioRow = $resultTipo->fetch_assoc();
$tipoUsuario = $tipoUsuarioRow ? $tipoUsuarioRow['tipo_usuario'] : null;
$stmtTipo->close();

/* ---------------------------
   1) Verificar consentimiento (ID 12) primero
   --------------------------- */
$consentId = 12;
$sqlConsent = "SELECT 1 FROM cuestionarios_resueltos WHERE id_cuestionario = ? AND id_estudiante = ? LIMIT 1";
$stmtConsent = $conn->prepare($sqlConsent);
$stmtConsent->bind_param("ii", $consentId, $idUsuario);
$stmtConsent->execute();
$consentCompletado = $stmtConsent->get_result()->num_rows > 0;
$stmtConsent->close();

/* ---------------------------
   2) Definir tandas
   --------------------------- */
$aplicaciones = [
    1 => [14, 15, 16, 17, 18],
    2 => [21, 25, 29, 33, 37],
    3 => [22, 26, 30, 34, 38],
    4 => [23, 27, 31, 35, 39],
    5 => [24, 28, 32, 36, 40]
];

/* ---------------------------
   3) Lógica de progreso (solo si ya hay consentimiento)
   --------------------------- */
$completoTanda1 = false;
$completoTanda2 = false;
$mostrarBoton = true; // por defecto

if ($consentCompletado) {
    // Verificar si el estudiante ha completado todos los cuestionarios de la tanda 1
    $completoTanda1 = true;
    foreach ($aplicaciones[1] as $idCuestionario) {
        $sqlCheck = "SELECT 1 FROM cuestionarios_resueltos WHERE id_cuestionario = ? AND id_estudiante = ? LIMIT 1";
        $stmt = $conn->prepare($sqlCheck);
        $stmt->bind_param("ii", $idCuestionario, $idUsuario);
        $stmt->execute();
        if ($stmt->get_result()->num_rows == 0) {
            $completoTanda1 = false;
            $stmt->close();
            break;
        }
        $stmt->close();
    }

    // Verificar si completó la tanda 2 (si aplica)
    $completoTanda2 = true;
    if ($completoTanda1) {
        foreach ($aplicaciones[2] as $idCuestionario) {
            $sqlCheck2 = "SELECT 1 FROM cuestionarios_resueltos WHERE id_cuestionario = ? AND id_estudiante = ? LIMIT 1";
            $stmt2 = $conn->prepare($sqlCheck2);
            $stmt2->bind_param("ii", $idCuestionario, $idUsuario);
            $stmt2->execute();
            if ($stmt2->get_result()->num_rows == 0) {
                $completoTanda2 = false;
                $stmt2->close();
                break;
            }
            $stmt2->close();
        }
    }

    // Control del botón según tiempo y tandas
    // (se mantiene tu regla de 10 horas entre tanda 1 y 2)
    if ($completoTanda1 && !$completoTanda2) {
        $sqlUltimaFecha = "SELECT MAX(fecha_resolucion) AS f
                           FROM cuestionarios_resueltos 
                           WHERE id_estudiante = ? AND id_cuestionario IN (14, 15, 16, 17, 18)";
        $stmtF = $conn->prepare($sqlUltimaFecha);
        $stmtF->bind_param("i", $idUsuario);
        $stmtF->execute();
        $resFecha = $stmtF->get_result();
        $row = $resFecha->fetch_assoc();
        $stmtF->close();

        if (!empty($row['f'])) {
            $ultimaFechaResolucion = new DateTime($row['f']);
            $fechaActual = new DateTime();
            $intervalo = $fechaActual->getTimestamp() - $ultimaFechaResolucion->getTimestamp();
            $mostrarBoton = ($intervalo >= 10 * 3600);
            if (!$mostrarBoton) {
                $mensajeEspera = "Espera hasta la próxima sesión para continuar con la siguiente tanda.";
            }
        }
    }
} else {
    // Si NO ha completado el consentimiento, solo permitimos el 12 y habilitamos el botón.
    // Esta línea asegura que pueda responder el 12 inmediatamente.
    $mostrarBoton = true;
}

/* ---------------------------
   4) Construir lista de cuestionarios permitidos
   --------------------------- */
if (!$consentCompletado) {
    // SOLO el consentimiento mientras no esté resuelto
    $cuestionariosPermitidos = [$consentId];
} else {
    // Consentimiento ya resuelto: aplicar tu lógica por tandas
    if (!$completoTanda1) {
        $cuestionariosPermitidos = array_merge([$consentId], $aplicaciones[1]);
    } else {
        if ($mostrarBoton && !$completoTanda2) {
            $cuestionariosPermitidos = array_merge([$consentId], $aplicaciones[1], $aplicaciones[2]);
        } else {
            $cuestionariosPermitidos = array_merge([$consentId], $aplicaciones[1]);
        }
    }
}

// Quitar duplicados y forzar enteros
$cuestionariosPermitidos = array_values(array_unique(array_map('intval', $cuestionariosPermitidos)));
$idList = implode(',', $cuestionariosPermitidos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Cuestionario</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .notice { margin: 10px 0; padding: 10px; background:#fff7cc; border:1px solid #f0d500; border-radius:8px; }
        .no-data { text-align:center; color:#666; }
        .btn[disabled] { opacity:.6; cursor:not-allowed; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Seleccionar Cuestionario</h1>

        <?php if (!$consentCompletado): ?>
            <div class="notice">
                Debes completar primero el <strong>Consentimiento Informado</strong> antes de continuar con cualquier otro cuestionario.
            </div>
        <?php elseif (isset($mensajeEspera)): ?>
            <div class="notice"><?php echo htmlspecialchars($mensajeEspera, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <table class="question-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // IMPORTANTE:
                // - LEFT JOIN y filtramos los que NO estén resueltos (cr.id_cuestionario IS NULL)
                // - c.dirigido = 'Estudiantes'
                // - Ordenar con 12 primero usando FIELD
                $sql = "
                    SELECT c.id, c.titulo
                    FROM cuestionario c
                    LEFT JOIN cuestionarios_resueltos cr
                      ON c.id = cr.id_cuestionario AND cr.id_estudiante = ?
                    WHERE cr.id_cuestionario IS NULL
                      AND c.dirigido = 'Estudiantes'
                      AND c.id IN ($idList)
                    ORDER BY FIELD(c.id, $idList)
                ";

                $stmtList = $conn->prepare($sql);
                $stmtList->bind_param("i", $idUsuario);
                $stmtList->execute();
                $result = $stmtList->get_result();

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                        <tr>
                            <td><?php echo (int)$row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($mostrarBoton || (int)$row['id'] === $consentId): ?>
                                    <!-- Importante: aunque $mostrarBoton sea false,
                                         el consentimiento (12) siempre debe poder responderse -->
                                    <a href="responder.php?id=<?php echo (int)$row['id']; ?>" class="btn">Responder</a>
                                <?php else: ?>
                                    <button class="btn" disabled>Responder</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="3" class="no-data">No hay cuestionarios disponibles.</td>
                    </tr>
                <?php
                endif;
                $stmtList->close();
                ?>
            </tbody>
        </table>
    </div>

    <div class="button-container">
        <a href="dashboard.php" class="btn">Menú</a>
        <a href="logout.php" class="btn logout">Cerrar Sesión</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
