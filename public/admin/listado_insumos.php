<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Listado -->
    <div class="card row m-5 shadow overflow-scroll">
        <table class="table table-bordered">
            <thead>
                <h4 class="p-2">Listado de insumos</h4>
            </thead>
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>Nombre insumo</td>
                    <td>Cantidad</td>
                    <td>Stock mínimo</td>
                </tr>
                <?php foreach($listaInsumos as $lista){?>
                <tr>
                    <td><?php echo $lista['ID'] ?></td>
                    <td><?php echo $lista['Nombre'] ?></td>
                    <td><?php echo $lista['Cantidad'] ?></td>
                    <td><?php echo $lista['Stock_minimo'] ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php
    include_once("../../src/footer.php");
?>