<?php
require_once '../../src/header_admin.php';
include_once("../../config/database.php");

// // Conectar a la base de datos
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Verificar la conexión
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// }

// $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : '';
// $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : '';

// // Obtener datos de métricas (cantidad de insumos utilizados por área)
// $sql = "SELECT area.Area, SUM(insumo_usado_empleado.Cantidad) as TotalInsumosUsados 
//         FROM insumo_usado_empleado 
//         INNER JOIN empleado ON insumo_usado_empleado.ID_Empleado = empleado.ID
//         INNER JOIN area ON empleado.ID_Area = area.ID 
//         WHERE insumo_usado_empleado.Fecha BETWEEN '$fechaInicio' AND '$fechaFin'
//         GROUP BY area.Area";
// $result = $conn->query($sql);

// $areas = [];
// $totales = [];

// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $areas[] = $row['Area'];
//         $totales[] = $row['TotalInsumosUsados'];
//     }
// } else {
//     echo "0 resultados";
// }
// $conn->close();
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <h2>Listado de Métricas</h2>
    <form method="post" action="">
        <label for="fechaInicio">Fecha Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo $fechaInicio; ?>" required>
        <label for="fechaFin">Fecha Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin" value="<?php echo $fechaFin; ?>" required>
        <button type="submit">Filtrar</button>
    </form>
    <canvas id="metricasChart"></canvas>
</div>

<script>
    var ctx = document.getElementById('metricasChart').getContext('2d');
    var metricasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($areas); ?>,
            datasets: [{
                label: 'Cantidad de Insumos Utilizados por Área',
                data: <?php echo json_encode($totales); ?>,
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
</script>

<?php
require_once '../../src/footer.php';
?>