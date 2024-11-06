<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pregunta</title>
    <link rel="stylesheet" href="styles.css">  <!-- Enlace al archivo de estilos -->
</head>
<body>
<div class="container">
    <?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "MyCLFDBss8**";
    $dbname = "proyectopsicologia"; // Nombre de tu base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

   // Procesar el formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores enviados desde el formulario
        $pregunta = $_POST['pregunta'];
        $tipo_pregunta = $_POST['tipo_pregunta'];

        // Si la pregunta es de opción múltiple, tomar las opciones
        if ($tipo_pregunta === 'multiple') {
            $op1 = $_POST['op1'];
            $op2 = $_POST['op2'];
            $op3 = isset($_POST['op3']) ? $_POST['op3'] : NULL;
            $op4 = isset($_POST['op4']) ? $_POST['op4'] : NULL;
            $op5 = isset($_POST['op5']) ? $_POST['op5'] : NULL;
            $op6 = isset($_POST['op6']) ? $_POST['op6'] : NULL;
            $op7 = isset($_POST['op7']) ? $_POST['op7'] : NULL;
            $op8 = isset($_POST['op8']) ? $_POST['op8'] : NULL;
            $op9 = isset($_POST['op9']) ? $_POST['op9'] : NULL;
            $op10 = isset($_POST['op10']) ? $_POST['op10'] : NULL;
            $op11 = isset($_POST['op11']) ? $_POST['op11'] : NULL;
        } else {
            // Si es pregunta abierta, las opciones son nulas
            $op1 = $op2 = $op3 = $op4 = $op5 = $op6 = $op7 = $op8 = $op9 = $op10 = $op11 = NULL;
        }

        // Obtener el ID de la pregunta, si se proporciona
        $id_pregunta = isset($_POST['id_pregunta']) && !empty($_POST['id_pregunta']) ? $_POST['id_pregunta'] : NULL;

        // Preparar la consulta para insertar los datos en la tabla pregunta
        $sql = "INSERT INTO pregunta (pregunta, tipo_pregunta, op_pregunta1, op_pregunta2, op_pregunta3, op_pregunta4, op_pregunta5, op_pregunta6, op_pregunta7, op_pregunta8, op_pregunta9, op_pregunta10, op_pregunta11, id) 
                VALUES ('$pregunta', '$tipo_pregunta', '$op1', '$op2', '$op3', '$op4', '$op5', '$op6', '$op7', '$op8', '$op9', '$op10', '$op11', '$id_pregunta')";

        // Ejecutar la consulta y verificar si fue exitosa
        if ($conn->query($sql) === TRUE) {
            echo "Pregunta guardada exitosamente!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Cerrar la conexión
    $conn->close();
    ?>
    
<h2>Agregar una Nueva Pregunta</h2>
<form action="" method="POST">
    <div class="container">
        <div class="containerGP">
            <label for="id_pregunta">ID de la Pregunta:</label>
            <input type="text" id="id_pregunta" name="id_pregunta" placeholder="Obligatorio">
        </div>

        <div class="containerGP">
            <label class="label" for="pregunta">Pregunta:</label>
            <input type="text" id="pregunta" name="pregunta" required>
        </div>

        <div class="containerGP">
            <label for="tipo_pregunta">Tipo de Pregunta:</label>
            <select id="tipo_pregunta" name="tipo_pregunta" onchange="toggleOpciones()">
                <option value="multiple">Opción Múltiple</option>
                <option value="abierta">Pregunta Abierta</option>
            </select>
        </div>
    </div>

    <div id="opciones_container">
        <!-- Opciones de respuesta -->
        <div class="container">
            <label for="op1">Opción 1:</label>
            <input type="text" id="op1" name="op1">
        </div>
        <div class="container">
            <label for="op2">Opción 2:</label>
            <input type="text" id="op2" name="op2">
        </div>
        <div class="container">
            <label for="op3">Opción 3:</label>
            <input type="text" id="op3" name="op3">
        </div>
        <div class="container">
            <label for="op4">Opción 4:</label>
            <input type="text" id="op4" name="op4">
        </div>
        <div class="container">
            <label for="op5">Opción 5:</label>
            <input type="text" id="op5" name="op5">
        </div>
        <div class="container">
            <label for="op6">Opción 6:</label>
            <input type="text" id="op6" name="op6">
        </div>
        <div class="container">
            <label for="op7">Opción 7:</label>
            <input type="text" id="op7" name="op7">
        </div>
        <div class="container">
            <label for="op8">Opción 8:</label>
            <input type="text" id="op8" name="op8">
        </div>
        <div class="container">
            <label for="op9">Opción 9:</label>
            <input type="text" id="op9" name="op9">
        </div>
        <div class="container">
            <label for="op10">Opción 10:</label>
            <input type="text" id="op10" name="op10">
        </div>
        <div class="container">
            <label for="op11">Opción 11:</label>
            <input type="text" id="op11" name="op11">
        </div>
    </div>

    <div class="container">
        <button class="boton" type="submit">Guardar Pregunta</button>
    </div>
</div>
</form>

<script>
function toggleOpciones() {
    var tipoPregunta = document.getElementById("tipo_pregunta").value;
    var opcionesContainer = document.getElementById("opciones_container");

    if (tipoPregunta === "abierta") {
        opcionesContainer.style.display = "none";
    } else {
        opcionesContainer.style.display = "block";
    }
}
</script>
</body>
	<a href="dashboard.php">Menu</a><br>
</html>
