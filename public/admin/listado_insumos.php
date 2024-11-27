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

<div class="card row m-2 p-2 shadow">
    <h4 class="p-2">Filtros</h4>
    <hr>
    <div class="row">
        <!-- Filtro de Área -->
        <div class="card col p-2">
            <div class="col-12 mb-3">
                <label for="filtroArea" class="form-label">Filtrar por Área:</label>
                <select id="filtroArea" class="form-control">
                    <option value="">Todas las Áreas</option>
                    <?php foreach ($listaArea as $area): ?>
                        <option value="<?php echo $area['Area']; ?>"><?php echo $area['Area']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Filtro de Semáforo -->
        <div class="card col p-2">
            <div class="col-12 mb-3">
                <label for="filtroSemaforo" class="form-label">Filtrar por Semáforo:</label>
                <select id="filtroSemaforo" class="form-control">
                    <option value="">Todos los colores</option>
                    <option value="rojo">Rojo</option>
                    <option value="amarillo">Amarillo</option>
                    <option value="verde">Verde</option>
                </select>
            </div>
        </div>
    </div>
</div>


<!-- Listado -->
<div class="card col row m-2 p-2 shadow">
    <table id="insumosTable" class="table">
        <thead>
            <h4 class="p-2">Listado de insumos</h4>
            <hr>
            <tr>
                <th>Codigo Insumo</th>
                <th>Insumo</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Presentación</th>
                <th class="area">Área</th>
                <th>Proveedor</th>
                <th>Fecha de vencimiento próxima</th>
                <th>Semáforo</th>
                <th>Acciones</th>
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
                    <td class="area">
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
                        <?php 
                            $fechaVencimiento = "";
                            $fechaActual = new DateTime();
                            $fechaMinima = null;

                            foreach($listaRegistro as $registro) {
                                if($registro['ID_Provee'] == $provee['ID_Provee']) {
                                    $fechaVenc = new DateTime($registro['Fecha_vencimiento']);
                                    if ($fechaMinima === null || $fechaVenc < $fechaMinima) {
                                        $fechaMinima = $fechaVenc;
                                    }
                                }
                            }

                            if ($fechaMinima !== null) {
                                $diferencia = $fechaActual->diff($fechaMinima)->days;
                                if ($diferencia <= 7) {
                                    $claseVencimiento = 'vencimiento-proximo';
                                    $colorSemaforo = 'rojo';
                                } elseif ($diferencia >= 8 && $diferencia <= 15) {
                                    $claseVencimiento = 'vencimiento-cercano';
                                    $colorSemaforo = 'amarillo';
                                } else {
                                    $claseVencimiento = '';
                                    $colorSemaforo = 'verde';
                                }
                                $fechaVencimiento = $fechaMinima->format('Y-m-d');
                            } else {
                                $claseVencimiento = '';
                                $colorSemaforo = '';
                            }
                        ?>
                        <span class="<?php echo $claseVencimiento; ?>">
                            <?php echo $fechaVencimiento; ?>
                        </span>
                    </td>
                    <td class="">
                        <div class="semaforo <?php echo $colorSemaforo; ?>">
                            <span class="text-hidden"><?php echo $colorSemaforo; ?></span>
                        </div>
                    </td>
                    <td>
                        <!-- Botón para abrir el modal -->
                        <div class="row m-0">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#registroModal<?php echo $provee['ID_Provee'] ?>">
                            <i class="fas fa-eye"></i>
                            </button>
                        </div>

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
                                <table class="table" id="registroTable<?php echo $provee['ID_Provee'] ?>">
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
                                <script>
                                    $(document).ready( function () {
                                        $('#registroTable<?php echo $provee['ID_Provee'] ?>').DataTable();
                                    });
                                </script>
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

    $(document).ready(function() {
        var table = $('#insumosTable').DataTable();

        $('#filtroArea').on('change', function() {
            var area = $(this).val();
            if (area) {
                table.columns('.area').search('^' + area + '$', true, false).draw();
            } else {
                table.columns('.area').search('').draw();
            }
        });
    });

    $('#filtroSemaforo').on('change', function() {
        var table = $('#insumosTable').DataTable();
        var color = $(this).val();
        if (color) {
            table.columns(9).search(color, true, false).draw();
        } else {
            table.columns(9).search('').draw();
        }
    });

</script>

<?php
    include_once("../../src/footer.php");
?>