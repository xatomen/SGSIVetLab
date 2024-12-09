<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    // $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    
    $txtCodigoInsumo = (isset($_POST['txtCodigoInsumo']))?$_POST['txtCodigoInsumo']:"";
    $txtCantidad = (isset($_POST['txtCantidad']))?$_POST['txtCantidad']:"";

    $txtIDProvee = (isset($_POST['txtIDProvee']))?$_POST['txtIDProvee']:"";

    $txtCodigoUnico = (isset($_POST['txtCodigoUnico']))?$_POST['txtCodigoUnico']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    date_default_timezone_set('America/Santiago');
    $txtFecha = date('Y-m-d H:i:s'); // Formato: Año-Mes-Día Hora:Minuto:Segundo
    // echo $txtFecha;

    switch ($accion){
        
        case "Cargar":
            // Encontrar el ID de Insumo de acuerdo al Codigo Insumo
            $sentenciaSQL = $conn->prepare("SELECT ID_Insumo FROM provee WHERE Codigo_insumo = :Codigo_insumo");
            $sentenciaSQL->bindParam(':Codigo_insumo', $txtCodigoInsumo);
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtID = $resultado['ID_Insumo'];
            
            // Encontrar el ID de Provee de acuerdo al Codigo Insumo
            $sentenciaSQL = $conn->prepare("SELECT ID_Provee FROM provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtIDProvee = $resultado['ID_Provee'];

            // Debemos crear un registro en la tabla registro_insumo
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Registro_Insumo) AS lastIndex FROM registro_insumo");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            // Debemos crear el código único, será conformado por VL000000 más el número de registro, ej: registro 1 va a ser VL000001
            $txtCodigoUnico = "VL".str_pad($lastindex, 6, "0", STR_PAD_LEFT);

            $sentenciaSQL = $conn->prepare("INSERT INTO registro_insumo (ID_Registro_Insumo, Codigo_unico, Numero_lote, Fecha_recibo, Fecha_vencimiento, Cantidad, Cantidad_actual, ID_Administrador, ID_Provee) VALUES (:ID_Registro_Insumo, :Codigo_unico, :Numero_lote, :Fecha_recibo, :Fecha_vencimiento, :Cantidad, :Cantidad_actual, :ID_Administrador, :ID_Provee)");

            // Indicamos la ID del registro
            $sentenciaSQL->bindParam(":ID_Registro_Insumo", $lastindex);

            // Debemos indicar el código único
            $sentenciaSQL->bindParam(':Codigo_unico', $txtCodigoUnico);

            // Debemos indicar el número de lote
            $txtNumLote = (isset($_POST['txtNumLote']))?$_POST['txtNumLote']:"";
            $sentenciaSQL->bindParam(':Numero_lote', $txtNumLote);

            // Debemos indicar la fecha de vencimiento
            $txtFechaVencimiento = (isset($_POST['txtFechaVencimiento']))?$_POST['txtFechaVencimiento']:"";
            $sentenciaSQL->bindParam(':Fecha_vencimiento', $txtFechaVencimiento);

            // Debemos indicar la fecha de recibo
            $sentenciaSQL->bindParam(':Fecha_recibo', $txtFecha);

            // Debemos indicar la cantidad de insumos
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad);        

            // Debemos indicar la cantidad actual de insumos
            $sentenciaSQL->bindParam(':Cantidad_actual', $txtCantidad);

            // Debemos indicar el ID del administrador
            $txtIDAdministrador = 1;
            $sentenciaSQL->bindParam(":ID_Administrador", $txtIDAdministrador);

            // Debemos indicar el ID del insumo
            $sentenciaSQL->bindParam(':ID_Provee', $txtIDProvee);        

            // Ejecutamos la sentencia SQL
            $sentenciaSQL->execute();

            // Ahora debemos incrementar la cantidad de insumos en la tabla insumos
            $sentenciaSQL = $conn->prepare("UPDATE insumo SET Cantidad = Cantidad + :Cantidad WHERE ID = :ID");
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad); 
            $sentenciaSQL->bindParam(':ID', $txtID); 
            $sentenciaSQL->execute();

            // Ahora debemos incrementar la cantidad de insumos en la tabla provee
            $sentenciaSQL = $conn->prepare("UPDATE provee SET Cantidad = Cantidad + :Cantidad WHERE ID_Provee = :ID_Provee");
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad);
            $sentenciaSQL->bindParam(':ID_Provee', $txtIDProvee);
            $sentenciaSQL->execute();

            header("Location: http://localhost/SGSIVetLab/public/admin/cargar_insumos.php");
            exit();
    
    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM Provee");
    $sentenciaSQL->execute();
    $listaProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaArea=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedor=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM registro_insumo");
    $sentenciaSQL->execute();
    $listaRegistroInsumo=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Agregar y modificar -->
<div class="row m-2 justify-content-around">
        
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Cargar insumo</h4>
                    <hr>
                    <form method="POST">
                        <!-- ID -->
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtCodigoInsumo" class="form-label">Código Insumo Proveedor</label>
                                    <input type="text" class="form-control" name="txtCodigoInsumo" id="txtCodigoInsumo" value="<?php echo $txtCodigoInsumo ?>" placeholder="Ingrese el código">
                                </div>
                            </div>
                        </div>
                        <!-- Cantidad -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtCantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" name="txtCantidad" id="txtCantidad" min=1 value=1 placeholder="Cantidad"></input>
                            </div>
                        </div>
                        <!-- Número de lote -->
                         <div class="row">
                            <div class="mb-3">
                                <label for="txtNumLote" class="form-label">N° de Lote</label>
                                <input type="number" class="form-control" name="txtNumLote" id="txtNumLote" placeholder="N° de Lote"></input>
                            </div>
                         </div>
                        <!-- Fecha de vencimiento -->
                         <div class="row">
                            <div class="mb-3">
                                <label for="txtFechaVencimiento" class="form-label">Fecha de vencimiento</label>
                                <input type="date" class="form-control" name="txtFechaVencimiento" id="txtFechaVencimiento" value="<?php echo $txtFecha ?>"></input>
                            </div>
                        </div>
                         <!-- Fecha -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtFecha" class="form-label">Fecha de ingreso</label>
                                <input type="text" class="form-control" name="txtFecha" id="txtFecha" value="<?php echo $txtFecha ?>" readonly></input>
                            </div>
                        </div>
                        <!-- Cargar -->
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Cargar" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-5 card p-2">
    <h4 class="p-2">Listado de insumos</h4>
    <hr>
    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col">
            <label for="filtroProveedor" class="form-label">Proveedor</label>
            <select class="form-control" id="filtroProveedor" onchange="filtrarTabla()">
                <option value="">Todos</option>
                <?php foreach($listaProveedor as $proveedor) { ?>
                    <option value="<?php echo $proveedor['Nombre']; ?>"><?php echo $proveedor['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col">
            <label for="filtroArea" class="form-label">Área</label>
            <select class="form-control" id="filtroArea" onchange="filtrarTabla()">
                <option value="">Todas</option>
                <?php foreach($listaArea as $area) { ?>
                    <option value="<?php echo $area['Area']; ?>"><?php echo $area['Area']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col">
            <label for="filtroNombreInsumo" class="form-label">Nombre de Insumo</label>
            <input type="text" class="form-control" id="filtroNombreInsumo" placeholder="Nombre de Insumo" onkeyup="filtrarTabla()">
        </div>
    </div>
    <!-- Tabla de insumos -->
    <table id="insumosTable" class="table">
        <thead>
            <tr>
                <th>Código Insumo</th>
                <th>Proveedor</th>
                <th>Área</th>
                <th>Nombre insumo</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaProvee as $provee) { ?>
            <tr>
                <td><?php echo $provee['Codigo_Insumo']; ?></td>
                <td>
                    <?php
                    foreach($listaProveedor as $proveedor) {
                        if($proveedor['ID'] == $provee['ID_Proveedor']) {
                            echo $proveedor['Nombre'];
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    foreach($listaArea as $area) {
                        if($area['ID'] == $provee['ID_Area']) {
                            echo $area['Area'];
                        }
                    }
                    ?>
                </td>
                <td><?php echo $provee['Descripcion']." - ".$provee['Presentacion']; ?></td>
                <td><?php echo $provee['Cantidad']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
function filtrarTabla() {
    var filtroProveedor = document.getElementById('filtroProveedor').value.toLowerCase();
    var filtroArea = document.getElementById('filtroArea').value.toLowerCase();
    var filtroNombreInsumo = document.getElementById('filtroNombreInsumo').value.toLowerCase();
    var tabla = document.getElementById('insumosTable');
    var filas = tabla.getElementsByTagName('tr');

    for (var i = 1; i < filas.length; i++) {
        var celdas = filas[i].getElementsByTagName('td');
        var proveedor = celdas[1].textContent.toLowerCase();
        var area = celdas[2].textContent.toLowerCase();
        var nombreInsumo = celdas[3].textContent.toLowerCase();
        var mostrarFila = true;

        if (filtroProveedor && proveedor.indexOf(filtroProveedor) === -1) {
            mostrarFila = false;
        }
        if (filtroArea && area.indexOf(filtroArea) === -1) {
            mostrarFila = false;
        }
        if (filtroNombreInsumo && nombreInsumo.indexOf(filtroNombreInsumo) === -1) {
            mostrarFila = false;
        }

        filas[i].style.display = mostrarFila ? '' : 'none';
    }
}
</script>

        <div class="col-xl"></div>
</div>

    
<!-- Fin -->

<!-- Incluye las librerías de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Listado -->
<div class="row m-2 text-center">
    <div class="col card p-2">
        <h4 class="p-2">Registros de insumos</h4>
        <hr>    
<!-- Filtro por rango de fecha -->
<div class="row m-2">
    <div class="col card p-2">
        Filtrar por rango de fecha de registro
        <div class="row">
            <div class="col">
                <label for="fechaInicio">Fecha Inicio:</label>
                <input type="date" id="fechaInicio" class="form-control" onchange="filtrarPorFecha()">
            </div>
            <div class="col">
                <label for="fechaFin">Fecha Fin:</label>
                <input type="date" id="fechaFin" class="form-control" onchange="filtrarPorFecha()">
            </div>
        </div>
    </div>
</div>
<script>
function filtrarPorFecha() {
    var fechaInicio = document.getElementById('fechaInicio').value;
    var fechaFin = document.getElementById('fechaFin').value;
    var table = document.getElementById('registroInsumosTable');
    var tr = table.getElementsByTagName('tr');

    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName('td')[4]; // Columna de Fecha Recibo
        if (td) {
            var fechaRecibo = new Date(td.textContent || td.innerText);
            var inicio = new Date(fechaInicio);
            var fin = new Date(fechaFin);

            if (fechaRecibo >= inicio && fechaRecibo <= fin) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}
</script>
        <table class="table" id="registroInsumosTable">    
            <thead>
                <tr>
                    <th>N° Registro</th>
                    <th>Codigo Único</th>
                    <th>Insumo</th>
                    <th>N° Lote</th>
                    <th>Fecha Recibo</th>
                    <th>Fecha Vencimiento</th>
                    <th>Cantidad</th>
                    <th>Administrador</th>
                    <th>Proveedor</th>
                    <th>Imprimir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaRegistroInsumo as $registro){?>
                    <tr>
                        <td><?php echo $registro['ID_Registro_Insumo'] ?></td>
                        <td><?php echo $registro['Codigo_unico'] ?></td>
                        <td>
                            <?php
                                foreach($listaProvee as $provee){
                                    if($provee['ID_Provee']==$registro['ID_Provee']){
                                        if($registro['ID_Provee']==$provee['ID_Provee']){
                                            echo $provee['Descripcion']." - ".$provee['Presentacion'];
                                        }
                                    }
                                }
                            ?>
                        </td>
                        <td><?php echo $registro['Numero_lote'] ?></td>
                        <td><?php echo $registro['Fecha_recibo'] ?></td>
                        <td><?php echo $registro['Fecha_vencimiento'] ?></td>
                        <td><?php echo $registro['Cantidad'] ?></td>
                        <td>
                            <?php
                                foreach($listaArea as $area){
                                    foreach($listaProvee as $provee){
                                        if($provee['ID_Provee']==$registro['ID_Provee']){
                                            if($area['ID']==$provee['ID_Area']){
                                                echo $area['Area'];
                                            }
                                        }
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach($listaProveedor as $proveedor){
                                    foreach($listaProvee as $provee){
                                        if($provee['ID_Provee']==$registro['ID_Provee']){
                                            if($proveedor['ID']==$provee['ID_Proveedor']){
                                                echo $proveedor['Nombre'];
                                            }
                                        }
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <div class="row m-0">
                            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
                                <svg id="barcode-<?php echo $registro['ID_Registro_Insumo']; ?>" class="hidden-barcode"></svg>
                                <script>
                                    JsBarcode("#barcode-<?php echo $registro['ID_Registro_Insumo']; ?>", "<?php echo $registro['Codigo_unico']; ?>", {
                                        format: "CODE128",
                                        displayValue: true
                                    });
                                </script>
                                <button class="print-button text-center" onclick="printBarcode('<?php echo $registro['ID_Registro_Insumo']; ?>')">
                                    <i class="fas fa-print"></i> Imprimir
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</div>

<style>
.print-button {
    background-color: green;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    text-align: center;
}

.print-button i {
    margin-right: 5px;
}

.hidden-barcode {
    display: none;
}
</style>

<!-- Inicializa DataTables -->
<script>
$(document).ready(function() {
    $('#insumosTable').DataTable();
});

$(document).ready(function() {
    $('#registroInsumosTable').DataTable();
});

function printBarcode(id) {
    var barcode = document.getElementById('barcode-' + id).outerHTML;
    var newWindow = window.open('', '', 'width=600,height=400');
    newWindow.document.write('<html><head><title>Imprimir Código de Barras</title>');
    newWindow.document.write('<style>@media print { svg { width: 100%; height: auto; } }</style>');
    newWindow.document.write('</head><body>');
    newWindow.document.write(barcode);
    newWindow.document.write('</body></html>');
    newWindow.document.close();
    newWindow.print();
}

</script>

<?php
    include_once("../../src/footer.php");
?>
