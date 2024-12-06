<?php
    require_once '../../config/database.php';
    require_once '../../src/header_admin.php';

    $sentenciaSQL = $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $insumos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM insumo_usado_empleado");
    $sentenciaSQL->execute();
    $listaInsumosUsados = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM provee");
    $sentenciaSQL->execute();
    $listaProvee = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM empleado");
    $sentenciaSQL->execute();
    $listaEmpleados = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM registro_insumo");
    $sentenciaSQL->execute();
    $listaRegistrosInsumo = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Incluye los archivos CSS y JS de DataTables y daterangepicker -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Registros de uso de insumo -->
<div class="row card p-3 m-3">
    <h4>Movimientos de insumo</h4>
    <hr>
    <!-- Filtros personalizados -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filtroProveedor">Filtrar por Proveedor:</label>
            <select id="filtroProveedor" class="form-control">
                <option value="">Todos</option>
                <?php foreach($listaProveedores as $proveedor) { ?>
                    <option value="<?php echo $proveedor['Nombre']; ?>"><?php echo $proveedor['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filtroEmpleado">Filtrar por Empleado:</label>
            <select id="filtroEmpleado" class="form-control">
                <option value="">Todos</option>
                <?php foreach($listaEmpleados as $empleado) { ?>
                    <option value="<?php echo $empleado['Nombre']; ?>"><?php echo $empleado['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="filtroFecha">Filtrar por Rango de Fechas:</label>
            <input type="text" id="filtroFecha" class="form-control" placeholder="Selecciona un rango de fechas">
        </div>
    </div>
    <table id="tablaInsumos" class="table display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Fecha de vencimiento</th>
                <th>Código único insumo</th>
                <th>Insumo</th>
                <th>Empleado</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($listaInsumosUsados as $insumoUsado){
            ?>
            <tr>
                <td><?php echo $insumoUsado['ID_Insumo_Empleado']; ?></td>
                <td><?php echo $insumoUsado['Fecha']; ?></td>
                <td>
                    <?php
                        foreach($listaProveedores as $proveedor){
                            foreach($listaProvee as $provee){
                                if($provee['ID_Provee'] == $insumoUsado['ID_Provee']){
                                    if($proveedor['ID'] == $provee['ID_Proveedor']){
                                        echo $proveedor['Nombre'];
                                    }
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach($listaRegistrosInsumo as $registroInsumo){
                            if($registroInsumo['Codigo_unico'] == $insumoUsado['Codigo_unico']){
                                echo $registroInsumo['Fecha_vencimiento'];
                            }
                        }
                    ?>
                </td>
                <td><?php echo $insumoUsado['Codigo_unico'] ?></td>
                <td>
                    <?php
                        foreach($listaProvee as $provee){
                            if($provee['ID_Provee'] == $insumoUsado['ID_Provee']){
                                echo $provee['Descripcion']." - ".$provee['Presentacion'];
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach($listaEmpleados as $empleado){
                            if($empleado['ID'] == $insumoUsado['ID_Empleado']){
                                echo $empleado['Nombre'];
                            }
                        }
                    ?>
                </td>
                <td><?php echo $insumoUsado['Cantidad']; ?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>

<!-- Inicializa DataTables y daterangepicker -->
<script>
$(document).ready(function() {
    var table = $('#tablaInsumos').DataTable();

    // Filtro por Proveedor
    $('#filtroProveedor').on('change', function() {
        table.column(2).search(this.value).draw();
    });

    // Filtro por Empleado
    $('#filtroEmpleado').on('change', function() {
        table.column(6).search(this.value).draw();
    });

    // Inicializa daterangepicker
    $('#filtroFecha').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    // Filtro por Rango de Fechas
    $('#filtroFecha').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var date = new Date(data[1]);
                if (
                    (startDate === null && endDate === null) ||
                    (startDate === null && date <= new Date(endDate)) ||
                    (new Date(startDate) <= date && endDate === null) ||
                    (new Date(startDate) <= date && date <= new Date(endDate))
                ) {
                    return true;
                }
                return false;
            }
        );
        table.draw();
        $.fn.dataTable.ext.search.pop();
    });
});
</script>

<!-- Registros de ingresos de insumo -->


<!-- Registros de mantención de entidades de insumo -->


<!-- Registros de mantención de entidades de usuarios -->


<!-- Registros de mantención de entidades de proveedores -->

<?php
    require_once '../../src/footer.php';
?>