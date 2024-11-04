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
        
        case "Crear Órden":

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

?>

<!-- Creación de la órden de compra -->
<div class="row justify-content-around">
    <form method="POST" class="d-flex flex-row gap-3">
        <div class="col-xl"></div>
        <!-- Seleccionar proveedor -->
        <div class="col-3 card p-3 m-2">
            <h3 class="text-center">Proveedor</h3>
            <hr>
            <div class="row">
                <div class="col mb-3">
                    <p>Seleccione el proveedor:</p>
                    <select id="txtIDProveedor" name="txtIDProveedor" class="form-control" onchange="this.form.submit()">
                        <option value="">Seleccione un proveedor</option>
                        <?php foreach ($listaProveedores as $proveedor): ?>
                            <option value="<?php echo $proveedor['ID']; ?>" <?php echo ($proveedor['ID'] == $txtIDProveedor) ? 'selected' : ''; ?>>
                                <?php echo $proveedor['Nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Creamos una órden de compra -->
            <div class="row">
                <div class="text-center">
                    <input class="btn btn-warning" type="submit" value="Crear Órden" name="accion">
                </div>
            </div>
        </div>

        <!-- Mostrar información del proveedor -->
        <div class="col-3 card p-3 m-2">
            <h3 class="text-center">Información proveedor</h3>
            <hr>
            <p>Nombre: <?php echo $datosProveedor ? $datosProveedor['Nombre'] : ''; ?></p>
            <p>RUT: <?php echo $datosProveedor ? $datosProveedor['RUT'] : ''; ?></p>
            <p>Fono: <?php echo $datosProveedor ? $datosProveedor['Telefono'] : ''; ?></p>
            <p>Correo: <?php echo $datosProveedor ? $datosProveedor['Correo'] : ''; ?></p>
            <p>Dirección: <?php echo $datosProveedor ? $datosProveedor['Direccion'] : ''; ?></p>
            <p>Comuna: <?php echo $datosProveedor ? $datosProveedor['Comuna'] : ''; ?></p>
            <p>Ciudad: <?php echo $datosProveedor ? $datosProveedor['Ciudad'] : ''; ?></p>
            <p>Giro: <?php echo $datosProveedor ? $datosProveedor['Giro'] : ''; ?></p>
        </div>

        <!-- Seleccionar insumos para agregar -->
        <div class="col-3 card p-3 m-2">
            <h3 class="text-center">Agregar insumos</h3>
            <hr>
            <!-- Seleccionamos la órden de compra -->
            <div class="row">
                <div class="col mb-3">
                    <p>Seleccione el número de órden de compra:</p>
                    <select id="txtNumOrden" name="txtNumOrden" class="form-control" onchange="this.form.submit()">
                        <option value="<?php echo $orden['Num_Orden_de_Compra']?>">Seleccione la órden de compra</option>
                        <?php foreach ($listaOrdenCompra as $orden): ?>
                            <option value="<?php echo $orden['Num_Orden_de_Compra'] //AGREGAR LA FECHA Y UN GUION!!!!!!!!; ?>" <?php echo ($orden['Num_Orden_de_Compra'] == $txtNumOrden) ? 'selected' : ''; ?>>
                                <?php echo "N° ".$orden['Num_Orden_de_Compra']." - Fecha (".$txtFecha.")"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- Seleccionamos el insumo a agregar -->
            <div class="row">
                <div class="col mb-3">
                    <label for="txtIDInsumo" class="form-label">Seleccione el insumo a agregar a la lista</label>
                    <select id="txtIDInsumo" name="txtIDInsumo" class="form-control">
                        <option value="">Seleccione un insumo</option>
                        <?php foreach ($listaInsumosProvee as $provee): ?>
                            <option value="<?php echo $provee['Codigo_Insumo']; ?>" <?php echo ($provee['ID_Proveedor'] == $txtIDProveedor) ? 'selected' : ''; ?>>
                                <?php echo $provee['Codigo_Insumo']. " - ". $provee['Descripcion']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- Cantidad -->
            <div class="row">
                <div class="col mb-3">
                    <label for="txtCantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="txtCantidad" id="txtCantidad" min=1 value=1 placeholder="Cantidad"></input>
                </div>
            </div>
            <!-- Cargar -->
            <div class="row">
                <div class="text-center">
                    <input class="btn btn-warning" type="submit" value="Agregar Insumo" name="accion">
                </div>
            </div>
        </div>
        <div class="col-xl"></div>
    </form>
</div>

<!-- Seleccionar los insumos -->
<div class="card row m-5 shadow overflow-scroll">
    <table class="table table-bordered">
        <thead>
            <h4 class="p-2">Insumos en la lista</h4>
        </thead>
        <tbody>
            <tr>
                <td>Cantidad</td>
                <td>Descripcion</td>
                <td>Presentacion</td>
                <td>Precio</td>
                <td>Total</td>
                <td>Acción</td>
            </tr>
            <?php foreach($listaOrdenCompra as $orden){ ?>
                <?php foreach($listaRegistrosOrdenCompra as $registro){ if($orden['Num_Orden_de_Compra'] == $registro['ID_Orden_Compra']){ if($registro['ID_Orden_Compra'] == $txtNumOrden){?>
            <tr>
                <td><?php echo $registro['Cantidad'] ?></td>
                <td><?php echo $registro['Descripcion'] ?></td>
                <td><?php echo $registro['Presentacion'] ?></td>
                <td><?php echo $registro['Precio'] ?></td>
                <td><?php echo $registro['Cantidad']*$registro['Precio'] ?></td>
                <td>
                
                    <form method="POST">
                        <div class="col">
                            <div class="row m-1"><input type="hidden" name="txtRegOrdenCompra" id="txtRegOrdenCompra" value="<?php echo $registro['Num_Registro_Orden_de_Compra'] ?>"></input></div>
                            <div class="row m-1"><input type="submit" name="accion" value="Eliminar" class="btn btn-danger"></input></div>
                        </div>
                    </form>

                </td>
            </tr>
            <?php } } } ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
    include_once("../../src/footer.php");
?>
