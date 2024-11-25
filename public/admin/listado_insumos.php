<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM provee");
    $sentenciaSQL->execute();
    $listaProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaArea=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM registro_insumo");
    $sentenciaSQL->execute();
    $listaRegistro=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Incluye las librerías de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Listado -->
<div class="card col-9 row m-2 p-2 shadow">
    <table id="insumosTable" class="table">
        <thead>
            <h4 class="p-2">Listado de insumos</h4>
            <hr>
            <tr>
                <td>Codigo Insumo</td>
                <td>Insumo</td>
                <td>Cantidad</td>
                <td>Precio</td>
                <td>Descripción</td>
                <td>Presentación</td>
                <td>Área</td>
                <td>Proveedor</td>
                <td>Acciones</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaProvee as $provee){ ?>
                <tr>
                    <td><?php echo $provee['Codigo_Insumo'] ?></td>
                    <td>
                        <?php 
                            foreach($listaInsumos as $insumo) {
                                if($insumo['ID'] == $provee['ID_Insumo']) {
                                    echo $insumo['Nombre'];
                                    break;
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $provee['Cantidad'] ?></td>
                    <td><?php echo $provee['Precio'] ?></td>
                    <td><?php echo $provee['Descripcion'] ?></td>
                    <td><?php echo $provee['Presentacion'] ?></td>
                    <td>
                        <?php 
                            foreach($listaArea as $area) {
                                if($area['ID'] == $provee['ID_Area']) {
                                    echo $area['Area'];
                                    break;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            foreach($listaProveedores as $proveedor) {
                                if($proveedor['ID'] == $provee['ID_Proveedor']) {
                                    echo $proveedor['Nombre'];
                                    break;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroModal<?php echo $provee['ID_Provee'] ?>">
                        Abrir Registro
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="registroModal<?php echo $provee['ID_Provee'] ?>" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="registroModalLabel">Listado de Insumos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card p-4">
                                <table class="table" id="registroTable">
                                    <thead>
                                    <tr>
                                        <th>N° Registro</th>
                                        <th>Código único</th>
                                        <th>N° Lote</th>
                                        <th>Cantidad</th>
                                        <th>Fecha recibo</th>
                                        <th>Fecha vencimeinto</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($listaRegistro as $registro){
                                        if($registro['ID_Provee'] == $provee['ID_Provee']){ ?>
                                        <tr>
                                            <td><?php echo $registro['ID_Registro_Insumo'] ?></td>
                                            <td><?php echo $registro['Codigo_unico'] ?></td>
                                            <td><?php echo $registro['Numero_lote'] ?></td>
                                            <td><?php echo $registro['Cantidad'] ?></td>
                                            <td><?php echo $registro['Fecha_recibo'] ?></td>
                                            <td><?php echo $registro['Fecha_vencimiento'] ?></td>
                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready( function () {
        $('#insumosTable').DataTable();
    });

    $(document).ready( function () {
        $('#registroTable').DataTable();
    });
</script>

<?php
    include_once("../../src/footer.php");
?>