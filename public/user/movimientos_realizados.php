<?php
    include_once("../../config/database.php");
    include_once("../../src/header_user.php");

    $sentenciaSQL = $conn->prepare("SELECT * FROM insumo_usado_empleado;");
    $sentenciaSQL->execute();
    $listaMovimientos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM Provee;");
    $sentenciaSQL->execute();
    $listaProvee = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Incluye las librerías de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<div class="row col card">
    <h2 class="p-2">Movimientos realizados</h2>
    <hr>
    <table id="tablaMovimientos" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Descripción</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaMovimientos as $movimiento){ ?>
            <tr>
                <td><?php echo $movimiento['ID_Insumo_Empleado']; ?></td>
                <td><?php echo $movimiento['Fecha']; ?></td>
                <td><?php echo $movimiento['ID_empleado']; ?></td>
                <td><?php echo $movimiento['ID_Provee']; ?></td>
                <td>
                    <?php
                        foreach($listaProvee as $provee){
                            if($provee['ID_Provee'] == $movimiento['ID_Provee']){
                                echo $provee['Descripcion'];
                            }
                        }
                    ?>
                </td>
                <td><?php echo $movimiento['Cantidad']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tablaMovimientos').DataTable();
    });
</script>

<?php
    include_once("../../src/footer.php");
?>