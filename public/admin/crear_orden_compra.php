<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtIDProveedor = isset($_POST['txtIDProveedor']) ? $_POST['txtIDProveedor'] : "";

    $txtIDInsumo = isset($_POST['txtIDInsumo']) ? $_POST['txtIDInsumo'] : "";
    // echo "Codigo_Insumo = ".$txtIDInsumo;

    $txtNumOrden = isset($_POST['txtNumOrden']) ? $_POST['txtNumOrden'] : "";

    $txtCantidad = isset($_POST['txtCantidad']) ? $_POST['txtCantidad'] : "";

    $txtRegOrdenCompra = isset($_POST['txtRegOrdenCompra']) ? $_POST['txtRegOrdenCompra'] : "";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    // Obtener lista de proveedores para el desplegable
    $sentenciaSQL = $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los datos del proveedor seleccionado
    $datosProveedor = null;
    if ($txtIDProveedor) {
        $sentenciaSQL = $conn->prepare("SELECT * FROM proveedor WHERE ID = :id");
        $sentenciaSQL->bindParam(':id', $txtIDProveedor);
        $sentenciaSQL->execute();
        $datosProveedor = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
    }

    // Fecha actual
    date_default_timezone_set('America/Santiago');
    $txtFecha = date('Y-m-d H:i:s'); // Formato: Año-Mes-Día Hora:Minuto:Segundo
    // echo $txtFecha;

    switch ($accion){
        
        case "Crear Orden":

            // Obtenemos el índice de la última órden de compra
            $sentenciaSQL = $conn->prepare("SELECT MAX(Num_Orden_de_Compra) AS lastIndex FROM orden_de_compra");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            $txtIDAdministrador = 1;

            // Insertamos la nueva órden de compra en la tabla
            $sentenciaSQL = $conn->prepare("INSERT INTO orden_de_compra (Num_Orden_de_Compra, Fecha, ID_Administrador, ID_Proveedor) VALUES (:Num_Orden_de_Compra, :Fecha, :ID_Administrador, :ID_Proveedor)");
            $sentenciaSQL->bindParam(':Num_Orden_de_Compra', $lastindex);   
            $sentenciaSQL->bindParam(':Fecha', $txtFecha);   
            $sentenciaSQL->bindParam(':ID_Administrador', $txtIDAdministrador);   
            $sentenciaSQL->bindParam(':ID_Proveedor', $txtIDProveedor);   
            $sentenciaSQL->execute();

            header("Location: crear_orden_compra.php");
            exit();
    
        case "Agregar Insumo":

            // Obtener el número de la órden de compra
            // echo $txtNumOrden;
            $txtCodigoInsumo = $txtIDInsumo;
            // Obtener la ID del insumo de la tabla insumo
            $sentenciaSQL = $conn->prepare("SELECT ID_Insumo FROM Provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);
            $sentenciaSQL->execute();
            $txtIDInsumo = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtIDInsumo = $txtIDInsumo['ID_Insumo'];

            // echo "Numero Orden ->".$txtNumOrden;
            // echo "Codigo Insumo ->".$txtCodigoInsumo;
            // echo "ID ->".$txtIDInsumo;

            // Obtener el precio del insumo
            $sentenciaSQL = $conn->prepare("SELECT Precio FROM Provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);
            $sentenciaSQL->execute();
            $txtPrecio = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtPrecio = $txtPrecio['Precio'];

            // Obtener la descripción
            $sentenciaSQL = $conn->prepare("SELECT Descripcion FROM Provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);
            $sentenciaSQL->execute();
            $txtDescripcion = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtDescripcion = $txtDescripcion['Descripcion'];


            // Obtener la presentacion
            $sentenciaSQL = $conn->prepare("SELECT Presentacion FROM Provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);
            $sentenciaSQL->execute();
            $txtPresentacion = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtPresentacion = $txtPresentacion['Presentacion'];

            // Obtener el último índice para la tabla registro_orden_de_compra
            $sentenciaSQL = $conn->prepare("SELECT MAX(Num_Registro_Orden_de_Compra) AS lastIndex FROM registro_orden_de_compra");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            // Insertar el insumo seleccionado
            $sentenciaSQL = $conn->prepare("INSERT INTO registro_orden_de_compra (Num_Registro_Orden_de_Compra, Precio, Cantidad, Descripcion, Presentacion, Codigo_Insumo, ID_Orden_Compra, ID_Insumo) VALUES (:Num_Registro_Orden_de_Compra, :Precio, :Cantidad, :Descripcion, :Presentacion, :Codigo_Insumo, :ID_Orden_Compra, :ID_Insumo)");
            $sentenciaSQL->bindParam(':Num_Registro_Orden_de_Compra',$lastindex);
            $sentenciaSQL->bindParam(':Precio',$txtPrecio);
            $sentenciaSQL->bindParam(':Cantidad',$txtCantidad);
            $sentenciaSQL->bindParam(':Descripcion',$txtDescripcion);
            $sentenciaSQL->bindParam(':Presentacion',$txtPresentacion);
            $sentenciaSQL->bindParam(':Codigo_Insumo',$txtCodigoInsumo);
            $sentenciaSQL->bindParam(':ID_Orden_Compra',$txtNumOrden);
            $sentenciaSQL->bindParam(':ID_Insumo',$txtIDInsumo);
            $sentenciaSQL->execute();

            header("Location: crear_orden_compra.php");
            exit();

        case "Eliminar":

            $sentenciaSQL = $conn->prepare("DELETE FROM registro_orden_de_compra WHERE Num_Registro_Orden_de_Compra=:Num_Registro_Orden_de_Compra");
            $sentenciaSQL->bindParam(":Num_Registro_Orden_de_Compra",$txtRegOrdenCompra);
            $sentenciaSQL->execute();

            header("Location: crear_orden_compra.php");
            exit();

    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM provee");
    $sentenciaSQL->execute();
    $listaInsumosProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM orden_de_compra ORDER BY Num_Orden_de_Compra DESC");
    $sentenciaSQL->execute();
    $listaOrdenCompra = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM registro_orden_de_compra");
    $sentenciaSQL->execute();
    $listaRegistrosOrdenCompra = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    // Total orden de compra
    $totalOrdenCompra = 0;
    if ($txtNumOrden) {
        $sentenciaSQL = $conn->prepare("
            SELECT SUM(Cantidad * Precio) AS Total 
            FROM registro_orden_de_compra 
            WHERE ID_Orden_Compra = :ID_Orden_Compra
        ");
        $sentenciaSQL->bindParam(':ID_Orden_Compra', $txtNumOrden);
        $sentenciaSQL->execute();
        $resultadoTotal = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
        $totalOrdenCompra = $resultadoTotal['Total'];
    }

?>

<!-- Creación de la orden de compra -->
<div class="row">
    <div class="col-3 card p-3 m-2">
        <form method="POST">
            <!-- Seleccionar proveedor -->
            <h3 class="text-center">Proveedor</h3>
            <hr>
            <p>Seleccione el proveedor:</p>
            <div class="row m-2">
                <select id="txtIDProveedor" name="txtIDProveedor" class="form-control" onchange="this.form.submit()">
                    <option value="">Seleccione un proveedor</option>
                    <?php foreach ($listaProveedores as $proveedor): ?>
                        <option value="<?php echo $proveedor['ID']; ?>" <?php echo ($proveedor['ID'] == $txtIDProveedor) ? 'selected' : ''; ?>>
                            <?php echo $proveedor['Nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Creamos una orden de compra -->
            <div class="row m-2 text-center">
                <input class="btn btn-warning" type="submit" value="Crear Orden" name="accion">
            </div>
            <div class="row card m-2 p-4">
                <h5 class="text-center">Información del proveedor</h5>
                <hr>
                <!-- Mostrar información del proveedor -->
                <p>Nombre: <?php echo $datosProveedor ? $datosProveedor['Nombre'] : ''; ?></p>
                <p>RUT: <?php echo $datosProveedor ? $datosProveedor['RUT'] : ''; ?></p>
                <p>Fono: <?php echo $datosProveedor ? $datosProveedor['Telefono'] : ''; ?></p>
                <p>Correo: <?php echo $datosProveedor ? $datosProveedor['Correo'] : ''; ?></p>
                <p>Dirección: <?php echo $datosProveedor ? $datosProveedor['Direccion'] : ''; ?></p>
                <p>Comuna: <?php echo $datosProveedor ? $datosProveedor['Comuna'] : ''; ?></p>
                <p>Ciudad: <?php echo $datosProveedor ? $datosProveedor['Ciudad'] : ''; ?></p>
                <p>Giro: <?php echo $datosProveedor ? $datosProveedor['Giro'] : ''; ?></p>
            </div>
        </form>
    </div>

    <!-- Ordenes de compra -->
    <div class="card col m-2 shadow">
        <table class="table table-bordered">
            <h4 class="p-2">Órdenes de compra</h4>
            <thead>    
                <tr>
                    <th>N° de orden</th>
                    <th>Fecha de creación</th>
                    <th>Proveedor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaOrdenCompra as $orden){ ?>
                <tr>
                    <td><?php echo $orden['Num_Orden_de_Compra'] ?></td>
                    <td><?php echo $orden['Fecha'] ?></td>
                    <td><?php foreach($listaProveedores as $proveedor){if($orden['ID_Proveedor']==$proveedor['ID']){echo $proveedor['Nombre'];}}?></td>
                    <td>
                        <div class="row text-center">
                            <!-- Botón para abrir el modal -->
                            <div class="col">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarInsumoModal<?php echo $orden['Num_Orden_de_Compra']; ?>" data-id="<?php echo $orden['Num_Orden_de_Compra']; ?>">
                                    <i class="fas fa-plus"></i> <!-- Icono de agregar -->
                                </button>
                            </div>
                            <!-- Botón para abrir el modal de la lista -->
                            <div class="col">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#listaInsumosModal<?php echo $orden['Num_Orden_de_Compra']; ?>">
                                    <i class="fa-regular fa-eye"></i> <!-- Icono de lista -->
                                </button>
                            </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="listaInsumosModal<?php echo $orden['Num_Orden_de_Compra']; ?>" tabindex="-1" aria-labelledby="listaInsumosModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="listaInsumosModalLabel">Insumos en la lista</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card row m-5 shadow">
                                        <table class="table table-bordered">
                                            <h4 class="p-2">Insumos en la lista N°<?php echo $orden['Num_Orden_de_Compra']; ?></h4>
                                            <thead>    
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Descripcion</th>
                                                    <th>Presentacion</th>
                                                    <th>Precio</th>
                                                    <th>Total</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($listaRegistrosOrdenCompra as $registro){
                                                    if($orden['Num_Orden_de_Compra'] == $registro['ID_Orden_Compra']){
                                                        $totalInsumo = $registro['Cantidad']*$registro['Precio'];
                                                        $totalOrdenCompra += $totalInsumo;
                                                ?>
                                                <tr>
                                                    <td><?php echo $registro['Cantidad'] ?></td>
                                                    <td><?php echo $registro['Descripcion'] ?></td>
                                                    <td><?php echo $registro['Presentacion'] ?></td>
                                                    <td><?php echo number_format($registro['Precio'], 0) ?></td>
                                                    <td><?php echo number_format($registro['Cantidad']*$registro['Precio'], 0) ?></td>
                                                    <td>
                                                    <form method="POST">
                                                        <div class="col">
                                                        <div class="row m-1"><input type="hidden" name="txtRegOrdenCompra" id="txtRegOrdenCompra" value="<?php echo $registro['Num_Registro_Orden_de_Compra'] ?>"></input></div>
                                                        <div class="row m-1"><button type="submit" name="accion" value="Eliminar" class="btn btn-danger"><i class="fas fa-trash"></i></button></div> <!-- Icono de eliminar -->
                                                        </div>
                                                    </form>
                                                    </td>
                                                </tr>
                                                <?php } } ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td><?php echo number_format($totalOrdenCompra, 0); ?></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>IVA (19%)</td>
                                                    <td><?php echo number_format($totalOrdenCompra*0.19, 0); ?></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td><?php echo number_format($totalOrdenCompra * 1.19, 0); ?></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col">
                                                <form method="POST" action="descargar_orden.php" class="d-flex flex-row gap-3">
                                                    <input type="hidden" name="txtNumOrden" value="<?php echo $txtNumOrden; ?>">
                                                    <!-- Botón Descargar PDF -->
                                                    <button type="submit" name="download_pdf" class="btn btn-primary">
                                                        <i class="fas fa-file-pdf"></i> <!-- Icono de PDF -->
                                                        Descargar orden de compra
                                                    </button>
                                                </form>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal agregar Insumo a la Orden de Compra-->
                        <div class="modal fade" id="agregarInsumoModal<?php echo $orden['Num_Orden_de_Compra']; ?>" tabindex="-1" aria-labelledby="agregarInsumoModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="agregarInsumoModalLabel">Agregar insumo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="crear_orden_compra.php">
                                            <!-- Seleccionamos el insumo a agregar -->
                                            <div class="row">
                                                <div class="col mb-3">
                                                <label for="txtIDInsumo" class="form-label">Seleccione el insumo a agregar a la lista</label>
                                                <select id="txtIDInsumo" name="txtIDInsumo" class="form-control">
                                                    <option value="">Seleccione un insumo</option>
                                                    <?php foreach ($listaInsumosProvee as $provee){ ?>
                                                    <?php if($provee['ID_Proveedor']==$orden['ID_Proveedor']){ ?>
                                                    <option value="<?php echo $provee['Codigo_Insumo']; ?>">
                                                        <?php echo $provee['Codigo_Insumo']. " - ". $provee['Descripcion']; ?>
                                                    </option>
                                                    <?php }} ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label for="txtCantidad" class="form-label">Cantidad</label>
                                                    <input type="number" id="txtCantidad" name="txtCantidad" class="form-control" required>
                                                </div>
                                            </div>
                                            <input type="hidden" name="txtNumOrden" value="<?php echo $orden['Num_Orden_de_Compra']; ?>">
                                            <div class="row">
                                                <div class="col text-center">
                                                    <button type="submit" name="accion" value="Agregar Insumo" class="btn btn-primary">Agregar insumo</button> <!-- Icono de agregar -->
                                                </div>
                                            </div>
                                        </form>
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


</div>

<?php
    include_once("../../src/footer.php");
?>
