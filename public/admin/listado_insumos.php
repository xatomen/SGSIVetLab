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
?>

<!-- Incluye las librerías de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Listado -->
<div class="card row m-2 p-2 shadow">
    <table id="insumosTable" class="table">
        <thead>
            <h4 class="p-2">Listado de insumos</h4>
            <hr>
            <tr>
                <th>ID</th>
                <th>Nombre insumo</th>
                <th>Área</th>
                <th>Cantidad</th>
                <th>Stock mínimo</th>
                <th>Insumos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaInsumos as $lista){?>
            <tr>
                <td><?php echo $lista['ID'] ?></td>
                <td><?php echo $lista['Nombre'] ?></td>
                <td>
                    <?php
                        foreach($listaArea as $area){
                            if($area['ID']==$lista['ID_Area']){
                                echo $area['Area'];
                            }
                        }
                    ?>
                </td>
                <td><?php echo $lista['Cantidad'] ?></td>
                <td><?php echo $lista['Stock_minimo'] ?></td>
                <td>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código Proveedor</th>
                                <th>Área</th>
                                <th>Descripción</th>
                                <th>Presentación</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listaProvee as $provee){?>
                                <?php if($provee['ID_Insumo']==$lista['ID']){?>
                                    <tr>
                                    <td><?php echo $provee['ID_Proveedor'] ?></td>
                                    <td>
                                        <?php
                                            foreach($listaArea as $area){
                                                if($area['ID']==$provee['ID_Area']){
                                                    echo $area['Area'];
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $provee['Descripcion'] ?></td>
                                    <td><?php echo $provee['Presentacion'] ?></td>
                                    <td><?php echo $provee['Cantidad'] ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready( function () {
        $('#insumosTable').DataTable();
    });
</script>

<?php
    include_once("../../src/footer.php");
?>