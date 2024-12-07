<?php
include_once("../../config/database.php");
require_once '../../src/header_admin.php';

// Mostrar la cantidad de insumos utilizados por empleado

// Verifica si se han enviado las fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

$sentenciaSQL = $conn->prepare("SELECT ID_Empleado, COUNT(*) AS cantidad FROM insumo_usado_empleado WHERE (:fecha_inicio = '' OR fecha >= :fecha_inicio) AND (:fecha_fin = '' OR fecha <= :fecha_fin) GROUP BY ID_Empleado");
$sentenciaSQL->bindParam(':fecha_inicio', $fechaInicio);
$sentenciaSQL->bindParam(':fecha_fin', $fechaFin);
$sentenciaSQL->execute();
$cantidadInsumosUsados = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Prepara los datos para pasarlos a JavaScript
$empleados = [];
$cantidades = [];
foreach ($cantidadInsumosUsados as $fila) {
    // Obtener el nombre del empleado
    $sentenciaNombre = $conn->prepare("SELECT Nombre FROM empleado WHERE ID = :ID");
    $sentenciaNombre->bindParam(':ID', $fila['ID_Empleado']);
    $sentenciaNombre->execute();
    $nombreEmpleado = $sentenciaNombre->fetch(PDO::FETCH_ASSOC)['Nombre'];
    $empleados[] = $nombreEmpleado;
    $cantidades[] = $fila['cantidad'];
}

// Mostrar la cantidad de insumos utilizados por área

// Verifica si se han enviado las fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

// Debemos encontrar la cantidad de insumos por empleado

// Debemos encontrar el área de los empleados

// Ahora contamos la cantidad de insumos usados por área

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <h4>Mostrar la cantidad de insumos utilizados por empleado</h4>
    <hr>
    <form method="post" id="filtroFechas">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $fechaFin; ?>">
        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
    </form>
    <canvas id="insumosUsadosPorEmpleado"></canvas>
</div>

<script>
    // Datos de PHP a JavaScript
    const empleados = <?php echo json_encode($empleados); ?>;
    const cantidades = <?php echo json_encode($cantidades); ?>;

    // Configuración del gráfico
    const ctx = document.getElementById('insumosUsadosPorEmpleado').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: empleados,
            datasets: [{
                label: 'Cantidad de insumos usados',
                data: cantidades,
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

    // Actualiza el gráfico cuando se envía el formulario
    document.getElementById('filtroFechas').addEventListener('submit', function(event) {
        event.preventDefault();
        this.submit();
    });
</script>

<?php
require_once '../../src/footer.php';
?>