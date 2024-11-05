<?php
 require_once '../../src/header_admin.php';
 include_once("../../config/database.php");

    // Insumo con mayor cantidad de stock
    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo ORDER BY Cantidad DESC LIMIT 5");
    $sentenciaSQL->execute();
    $TopDescStock=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Insumos con menor cantidad de stock
    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo ORDER BY Cantidad ASC LIMIT 5");
    $sentenciaSQL->execute();
    $TopAscStock=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Cantidad de insumos ingresados por mes
    $sentenciaSQL = $conn->prepare("SELECT COUNT(ID_Registro_Insumo) AS QTY, Cantidad, MONTH(Fecha) AS MES FROM registro_insumo GROUP BY MES");
    $sentenciaSQL->execute();
    $CantidadPorMes = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Uso de insumos por día
    $sentenciaSQL = $conn->prepare("SELECT COUNT(ID_Insumo_Empleado) AS QTY, Cantidad, MONTH(Fecha) AS DIA FROM insumo_usado_empleado");
    $sentenciaSQL->execute();
    $InsumosPorDia = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Promedio de insumos utilizados por día


    // Proyección próximo mes



?>

<!-- Insumo con mayor cantidad de stock -->
<div class="row">
    <!-- Listas -->
    <div class="col-4">
        <div class="row mb-3">
            <div class="card col p-3">
                <h5>Top 5 insumos con mayor cantidad de stock</h5>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <td>Insumo</td>
                        <td>Cantidad</td>
                    </thead>
                    <tbody>
                        <?php foreach($TopDescStock as $insumo){ ?>
                            <td><?php echo $insumo['Nombre'] ?></td>
                            <td><?php echo $insumo['Cantidad'] ?></td>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Insumo con menor cantidad de stock -->
        <div class="row mb-3">
            <div class="card col p-3">
                <h5>Top 5 insumos con menor cantidad de stock</h5>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <td>Insumo</td>
                        <td>Cantidad</td>
                    </thead>
                    <tbody>
                        <?php foreach($TopAscStock as $insumo){ ?>
                            <td><?php echo $insumo['Nombre'] ?></td>
                            <td><?php echo $insumo['Cantidad'] ?></td>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Gráficos -->
    <div class="col">
        <!-- Cantidad de insumos ingresados por mes -->
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Mes', 'Cantidad'],
                    <?php foreach ($CantidadPorMes as $cantidad): ?>
                        ['<?php echo $cantidad['MES']; ?>', <?php echo $cantidad['Cantidad']; ?>],
                    <?php endforeach; ?>
                ]);

                var options = {
                    title: 'Cantidad de Registros por Mes',
                    hAxis: {title: 'Mes', titleTextStyle: {color: '#333'}},
                    vAxis: {title: 'Cantidad', minValue: 0},
                    bars: 'vertical',
                    colors: ['#4CAF50']
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>

        <div class="row mb-3">
            <div class="card col p-3">
                <h5>Cantidad de insumos ingresados por mes</h5>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <table class="table table-bordered">
                            <thead>
                                <td>Fecha</td>
                                <td>Cantidad</td>
                            </thead>
                            <tbody>
                                <?php foreach($CantidadPorMes as $cantidad){ ?>
                                    <td><?php echo $cantidad['MES'] ?></td>
                                    <td><?php echo $cantidad['Cantidad']*$cantidad['QTY'] ?></td>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-8">
                        <div id="chart_div" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cantidad de insumos utilizados por día -->
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Día', 'Cantidad'],
                    <?php foreach ($InsumosPorDia as $insumo): ?>
                        ['<?php echo $insumo['DIA']; ?>', <?php echo $insumo['QTY']; ?>],
                    <?php endforeach; ?>
                ]);

                var options = {
                    title: 'Uso de Insumos por Día',
                    hAxis: {title: 'Día', titleTextStyle: {color: '#333'}},
                    vAxis: {title: 'Cantidad de Insumos Usados', minValue: 0},
                    bars: 'vertical',
                    colors: ['#4CAF50']
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_dia'));
                chart.draw(data, options);
            }
        </script>

        <div class="row mb-3">
            <div class="card col p-3">
                <h5>Cantidad de insumos usados por día</h5>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <table class="table table-bordered">
                            <thead>
                                <td>Fecha</td>
                                <td>Cantidad</td>
                            </thead>
                            <tbody>
                                <?php foreach($InsumosPorDia as $cantidad){ ?>
                                    <td><?php echo $cantidad['DIA'] ?></td>
                                    <td><?php echo $cantidad['Cantidad']*$cantidad['QTY'] ?></td>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-8">
                        <div id="chart_div_dia" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<?php
 require_once '../../src/footer.php'
?>