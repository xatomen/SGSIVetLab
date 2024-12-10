<?php
include_once("../../config/database.php");
require_once '../../src/header_admin.php';

// Mostrar la cantidad de insumos utilizados por empleado

// Verifica si se han enviado las fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

$sentenciaSQL = $conn->prepare("SELECT ID_Empleado, SUM(Cantidad) AS cantidad FROM insumo_usado_empleado WHERE (:fecha_inicio = '' OR fecha >= :fecha_inicio) AND (:fecha_fin = '' OR fecha <= :fecha_fin) GROUP BY ID_Empleado");
$sentenciaSQL->bindParam(':fecha_inicio', $fechaInicio);
$sentenciaSQL->bindParam(':fecha_fin', $fechaFin);
$sentenciaSQL->execute();
$cantidadInsumosUsados = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Prepara los datos para pasarlos a JavaScript
$empleados = [];
$cantidadesPorEmpleado = [];
foreach ($cantidadInsumosUsados as $fila) {
    // Obtener el nombre del empleado
    $sentenciaNombre = $conn->prepare("SELECT Nombre FROM empleado WHERE ID = :ID");
    $sentenciaNombre->bindParam(':ID', $fila['ID_Empleado']);
    $sentenciaNombre->execute();
    $nombreEmpleado = $sentenciaNombre->fetch(PDO::FETCH_ASSOC)['Nombre'];
    $empleados[] = $nombreEmpleado;
    $cantidadesPorEmpleado[] = $fila['cantidad'];
}

// Mostrar la cantidad de insumos utilizados por área

// Verifica si se han enviado las fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

// Debemos encontrar la cantidad de insumos usados por área, para ello debemos consultar el id del área del empleado que usó el insumo y agrupar por ID_Area
$sentenciaSQL = $conn->prepare("SELECT ID_Area, SUM(Cantidad) AS cantidad FROM insumo_usado_empleado INNER JOIN empleado ON insumo_usado_empleado.ID_Empleado = empleado.ID WHERE (:fecha_inicio = '' OR fecha >= :fecha_inicio) AND (:fecha_fin = '' OR fecha <= :fecha_fin) GROUP BY ID_Area");
$sentenciaSQL->bindParam(':fecha_inicio', $fechaInicio);
$sentenciaSQL->bindParam(':fecha_fin', $fechaFin);
$sentenciaSQL->execute();
$cantidadInsumosUsados = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Prepara los datos para pasarlos a JavaScript
$areas = [];
$cantidades = [];
foreach ($cantidadInsumosUsados as $fila) {
    // Obtener el nombre del área
    $sentenciaNombre = $conn->prepare("SELECT Area FROM area WHERE ID = :ID");
    $sentenciaNombre->bindParam(':ID', $fila['ID_Area']);
    $sentenciaNombre->execute();
    $nombreArea = $sentenciaNombre->fetch(PDO::FETCH_ASSOC)['Area'];
    $areas[] = $nombreArea;
    $cantidades[] = $fila['cantidad'];
}

// Mostrar la cantidad de insumos usados por día

// Verifica si se han enviado las fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

$sentenciaSQL = $conn->prepare("SELECT fecha, SUM(Cantidad) AS cantidad FROM insumo_usado_empleado WHERE (:fecha_inicio = '' OR fecha >= :fecha_inicio) AND (:fecha_fin = '' OR fecha <= :fecha_fin) GROUP BY fecha");
$sentenciaSQL->bindParam(':fecha_inicio', $fechaInicio);
$sentenciaSQL->bindParam(':fecha_fin', $fechaFin);
$sentenciaSQL->execute();
$cantidadInsumosUsados = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Prepara los datos para pasarlos a JavaScript
$fechas = [];
$cantidadesPorFecha = [];
foreach ($cantidadInsumosUsados as $fila) {
    $fechas[] = $fila['fecha'];
    $cantidadesPorFecha[] = $fila['cantidad'];
}

?>
<div class="row">

    <div class="col card p-4 m-4 container">
        <h4>Mostrar la cantidad de insumos utilizados por empleado</h4>
        <hr>
        <form method="post" id="filtroFechasEmpleado">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fechaFin; ?>">
            <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
        </form>
        <canvas id="insumosUsadosPorEmpleado"></canvas>
    </div>

    <div class="col card p-4 m-4 container">
        <h4>Mostrar la cantidad de insumos utilizados por área</h4>
        <hr>
        <form method="post" id="filtroFechasArea">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fechaFin; ?>">
            <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
        </form>
        <canvas id="insumosUsadosPorArea"></canvas>
    </div>

</div>

<div class="row">
    <div class="col-xl"></div>
    <div class="col-6 card p-4 m-4 container">
        <h4>Mostrar la cantidad de insumos utilizados por fecha</h4>
        <hr>
        <form method="post" id="filtroFechasFecha">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">
            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fechaFin; ?>">
            <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
        </form>
        <canvas id="insumosUsadosPorFecha"></canvas>
    </div>
    <div class="col-xl"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxEmpleado = document.getElementById('insumosUsadosPorEmpleado').getContext('2d');
        var ctxArea = document.getElementById('insumosUsadosPorArea').getContext('2d');
        var ctxFecha = document.getElementById('insumosUsadosPorFecha').getContext('2d');

        var chartEmpleado = new Chart(ctxEmpleado, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($empleados); ?>,
                datasets: [{
                    label: 'Cantidad de insumos usados por empleado',
                    data: <?php echo json_encode($cantidadesPorEmpleado); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var chartArea = new Chart(ctxArea, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($areas); ?>,
                datasets: [{
                    label: 'Cantidad de insumos usados por área',
                    data: <?php echo json_encode($cantidades); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var chartFecha = new Chart(ctxFecha, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($fechas); ?>,
                datasets: [{
                    label: 'Cantidad de insumos usados por fecha',
                    data: <?php echo json_encode($cantidadesPorFecha); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?php
require_once '../../src/footer.php';
?>