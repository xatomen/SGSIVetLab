<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    
    $txtIDArea = (isset($_POST['txtIDArea'])) ? $_POST['txtIDArea'] : "";
    $txtArea = (isset($_POST['txtArea'])) ? $_POST['txtArea'] : "";

    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    switch($accion){
        case "Agregar":
            $sentenciaSQL = $conn->prepare("INSERT INTO area (ID, Area) VALUES (:ID, :Area)");
            $sentenciaSQL->bindParam(':ID', $txtIDArea);
            $sentenciaSQL->bindParam(':Area', $txtArea);
            $sentenciaSQL->execute();
            header("Location: gestionar_areas.php");
            break;

        case "Modificar":
            break;

        case "Eliminar":
            break;
    }

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
    <div class="p-3">
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarAreaModal">
            Agregar Área
        </button>

        <!-- Modal -->
        <div class="modal fade" id="agregarAreaModal" tabindex="-1" aria-labelledby="agregarAreaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarAreaModalLabel">Cargar insumo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <!-- ID -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="txtIDArea" class="form-label">ID Área</label>
                                        <input type="text" class="form-control" name="txtIDArea" id="txtIDArea" value="<?php echo $txtIDArea ?>" placeholder="Ingrese el ID">
                                    </div>
                                </div>
                            </div>
                            <!-- Nombre área -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="txtArea" class="form-label">Nombre Área</label>
                                        <input type="text" class="form-control" name="txtArea" id="txtArea" value="<?php echo $txtArea ?>" placeholder="Ingrese el nombre del área">
                                    </div>
                                </div>
                            </div>
                            <!-- Agregar área -->
                            <div class="row">
                                <div class="text-center">
                                    <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <div class="btn-group" role="group">
                        <a href="editar_area.php?ID_Area=<?php echo $area['ID']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="eliminar_area.php?ID_Area=<?php echo $area['ID']; ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#areasTable').DataTable();

        $('#addAreaForm').on('submit', function(e) {
            e.preventDefault();
            var areaName = $('#areaName').val();
        });
    });
</script>

<?php
    include_once("../../src/footer.php");
?>