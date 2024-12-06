<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    
    $txtIDArea = (isset($_POST['txtIDArea'])) ? $_POST['txtIDArea'] : "";
    $txtArea = (isset($_POST['txtArea'])) ? $_POST['txtArea'] : "";

    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

    switch($accion){
        case "Agregar":
            // Debemos encontrar el último ID de la tabla area y sumarle 1 para obtener la ID nueva
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS ID FROM area");
            $sentenciaSQL->execute();
            $ID = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtIDArea = $ID['ID'] + 1;

            $sentenciaSQL = $conn->prepare("INSERT INTO area (ID, Area) VALUES (:ID, :Area)");
            $sentenciaSQL->bindParam(':ID', $txtIDArea);
            $sentenciaSQL->bindParam(':Area', $txtArea);
            $sentenciaSQL->execute();
            header("Location: gestionar_areas.php");
            exit();

        case "Modificar":
            $sentenciaSQL = $conn->prepare("UPDATE area SET Area = :Area WHERE ID = :ID");
            $sentenciaSQL->bindParam(':ID', $txtIDArea);
            $sentenciaSQL->bindParam(':Area', $txtArea);
            $sentenciaSQL->execute();
            header("Location: gestionar_areas.php");
            exit();

        case "Eliminar":
            $sentenciaSQL = $conn->prepare("DELETE FROM area WHERE ID = :ID");
            $sentenciaSQL->bindParam(':ID', $txtIDArea);
            $sentenciaSQL->execute();
            header("Location: gestionar_areas.php");
            exit();
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
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="txtIDArea" value="<?php echo $area['ID']; ?>">
                        <div class="btn-group" role="group">
                            <button type="submit" name="accion" value="Modificar" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="submit" name="accion" value="Eliminar" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </form>
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