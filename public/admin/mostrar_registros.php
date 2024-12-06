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

<!-- Incluye los archivos CSS y JS de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Registros de uso de insumo -->
<div class="row card p-3">
    <h4>Movimientos de insumo</h4>
    <hr>
    <table id="tablaInsumos" class="table">
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

<!-- Inicializa DataTables -->
<script>
$(document).ready( function () {
    $('#tablaInsumos').DataTable();
});
</script>

<!-- Registros de ingresos de insumo -->


<!-- Registros de mantención de entidades de insumo -->


<!-- Registros de mantención de entidades de usuarios -->


<!-- Registros de mantención de entidades de proveedores -->

<?php
    require_once '../../src/footer.php';
?>