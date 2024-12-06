<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $sentenciaSQL = $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $areas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Incluye las bibliotecas de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<div class="col card p-4 shadow">
    <h4>Áreas</h4>
    <hr>
    <table id="areasTable" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Área</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($areas as $area){ ?>
            <tr>
                <td><?php echo $area['ID']; ?></td>
                <td><?php echo $area['Area']; ?></td>
                <td>
                    <a href="editar_area.php?ID_Area=<?php echo $area['ID']; ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="eliminar_area.php?ID_Area=<?php echo $area['ID']; ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#areasTable').DataTable();
    });
</script>

<?php
    include_once("../../src/footer.php");
?>