<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtStockMinimoAgregar = (isset($_POST['txtStockMinimoAgregar']))?$_POST['txtStockMinimoAgregar']:"";
    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtStockMinimoEditar = (isset($_POST['txtStockMinimoEditar']))?$_POST['txtStockMinimoEditar']:"";

    $txtIDProveedor = (isset($_POST['txtIDProveedor']))?$_POST['txtIDProveedor']:"";

    $txtIDArea = (isset($_POST['txtIDArea']))?$_POST['txtIDArea']:"";

    $txtIDInsumoProveedor = (isset($_POST['txtIDInsumoProveedor']))?$_POST['txtIDInsumoProveedor']:"";
    $txtCodigoAgregar = (isset($_POST['txtCodigoAgregar']))?$_POST['txtCodigoAgregar']:"";
    $txtDescripcionAgregar = (isset($_POST['txtDescripcionAgregar']))?$_POST['txtDescripcionAgregar']:"";
    $txtPresentacionAgregar = (isset($_POST['txtPresentacionAgregar']))?$_POST['txtPresentacionAgregar']:"";
    $txtPrecioAgregar = (isset($_POST['txtPrecioAgregar']))?$_POST['txtPrecioAgregar']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";
    $accion_insumo_proveedor = (isset($_POST['accion_insumo_proveedor']))?$_POST['accion_insumo_proveedor']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM insumo WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtNombreEditar = $ListaSel['Nombre'];
            $txtStockMinimoEditar = $ListaSel['Stock_minimo'];

            break;
    
        case "Editar":
            $mensaje = "Insumo editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE insumo SET Nombre=:Nombre, Stock_minimo=:Stock_minimo WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Stock_minimo', $txtStockMinimoEditar);
            $sentenciaSQL->bindParam(':Nombre', $txtNombreEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            $txtID="";
            $txtNombreEditar="";
            $txtStockMinimoEditar="";
            header("Location: mantener_insumos.php");
            exit();
    
        case "Agregar":
            $mensaje = "Insumo agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM insumo");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO insumo (ID, NOMBRE, STOCK_MINIMO) VALUES (:ID, :NOMBRE, :STOCK_MINIMO)");
            $sentenciaSQL->bindParam(":ID", $lastindex);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreAgregar);
            $sentenciaSQL->bindParam(':STOCK_MINIMO', $txtStockMinimoAgregar);
            $sentenciaSQL->execute();
            header("Location: mantener_insumos.php");
            exit();
    
        case "Eliminar":
            $mensaje = "Insumo eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM insumo WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();
            header("Location: mantener_insumos.php");
            exit();

        case "Agregar Insumo":
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Provee) AS lastIndex FROM provee");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            // echo $lastindex;
            // echo " - ";
            // echo $txtCodigoAgregar;
            // echo " - ";
            // echo $txtPrecioAgregar;
            // echo " - ";
            // echo $txtDescripcionAgregar;
            // echo " - ";
            // echo $txtPresentacionAgregar;
            // echo " - ";
            // echo $txtIDArea;
            // echo " - ";
            // echo $txtIDProveedor;
            // echo " - ";
            // echo $txtID;

            $sentenciaSQL = $conn->prepare("INSERT INTO provee (ID_Provee, Codigo_Insumo, Precio, Descripcion, Presentacion, ID_Area, ID_Proveedor, ID_Insumo) VALUES (:ID_Provee, :Codigo_Insumo, :Precio, :Descripcion, :Presentacion, :ID_Area, :ID_Proveedor, :ID_Insumo)");
            $sentenciaSQL->bindParam(":ID_Provee", $lastindex);
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoAgregar);
            $sentenciaSQL->bindParam(':Precio', $txtPrecioAgregar);
            $sentenciaSQL->bindParam(':Descripcion', $txtDescripcionAgregar);
            $sentenciaSQL->bindParam(':Presentacion', $txtPresentacionAgregar);
            $sentenciaSQL->bindParam(':ID_Area', $txtIDArea);
            $sentenciaSQL->bindParam(':ID_Proveedor', $txtIDProveedor);
            $sentenciaSQL->bindParam(':ID_Insumo', $txtID);

            $sentenciaSQL->execute();
            header("Location: mantener_insumos.php");
            exit();

    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    
    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM provee");
    $sentenciaSQL->execute();
    $listaProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaAreas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Agregar insumo</h4>
                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtNombreAgregar" class="form-label">Nombre insumo</label>
                                    <input type="text" class="form-control" name="txtNombreAgregar" id="txtNombreAgregar" placeholder="Ingrese el nombre del insumo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtStockMinimoAgregar" class="form-label">Stock mínimo</label>
                                <input class="form-control" name="txtStockMinimoAgregar" id="txtStockMinimoAgregar" placeholder="Ingrese el stock mínimo"></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Editar insumo seleccionado</h4>
                    <hr>
                    <form method="POST">
                        <input type="hidden" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtNombreEditar" class="form-label">Nombre insumo</label>
                                    <input type="text" class="form-control" name="txtNombreEditar" id="txtNombreEditar" value="<?php echo $txtNombreEditar?>" placeholder="Ingrese el nombre del insumo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtStockMinimoEditar" class="form-label">Stock mínimo</label>
                                <input class="form-control" name="txtStockMinimoEditar" id="txtStockMinimoEditar" value="<?php echo $txtStockMinimoEditar?>" placeholder="Ingrese la descripción"></input>
                            </div>
                        </div>
                        <!-- Editar y Deseleccionar -->
                        <div class="row">
                            <div class="col text-center">
                                <input class="btn btn-warning" type="submit" value="Editar" name="accion">
                            </div>
                            <div class="col text-center">
                                <input class="btn btn-info" type="submit" value="Deseleccionar" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <div class="col">
                <div class="card p-3 shadow">
                    <form method="POST">
                        <h4 class="text-center">Agregar proveedor para el insumo seleccionado</h4>
                        <hr>
                        <!-- <label for="txtID" class="form-label">ID</label> -->
                        <input type="hidden" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID">
                        <!-- Inserción de datos -->
                        <div class="row">
                            <!-- Columna izquierda -->
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="txtIDProveedor" class="form-label">Seleccionar proveedor</label>
                                            <select id="txtIDProveedor" name="txtIDProveedor" class="form-control">
                                                <option value="">Seleccione un proveedor</option>
                                                <?php foreach ($listaProveedores as $proveedor): ?>
                                                    <option value="<?php echo $proveedor['ID']; ?>" <?php echo ($proveedor['ID'] == $txtIDProveedor) ? 'selected' : ''; ?>>
                                                        <?php echo $proveedor['Nombre']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="coL">
                                        <div class="mb-3">
                                            <label for="txtIDArea" class="form-label">Seleccionar área</label>
                                            <select id="txtIDArea" name="txtIDArea" class="form-control">
                                                <option value="">Seleccione un área</option>
                                                <?php foreach ($listaAreas as $area): ?>
                                                    <option value="<?php echo $area['ID']; ?>" <?php echo ($area['ID'] == $txtIDArea) ? 'selected' : ''; ?>>
                                                        <?php echo $area['Area']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Código -->
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="txtCodigoAgregar" class="form-label">Codigo</label>
                                            <input type="text" class="form-control" name="txtCodigoAgregar" id="txtCodigoAgregar" value="<?php echo $txtCodigoAgregar?>" placeholder="Ingrese el código">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Columna derecha -->
                            <div class="col">
                                <!-- Descripción -->
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="txtDescripcionAgregar" class="form-label">Descripción</label>
                                            <input type="text" class="form-control" name="txtDescripcionAgregar" id="txtDescripcionAgregar" value="<?php echo $txtDescripcionAgregar?>" placeholder="Ingrese la descripción">
                                        </div>
                                    </div>
                                </div>
                                <!-- Presentación -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtPresentacionAgregar" class="form-label">Presentación</label>
                                        <input class="form-control" name="txtPresentacionAgregar" id="txtPresentacionAgregar" value="<?php echo $txtPresentacionAgregar?>" placeholder="Ingrese la presentación"></input>
                                    </div>
                                </div>
                                <!-- Precio -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtPrecioAgregar" class="form-label">Precio</label>
                                        <input class="form-control" name="txtPrecioAgregar" id="txtPrecioAgregar" value="<?php echo $txtPrecioAgregar?>" placeholder="Ingrese el precio"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- Agregar -->
                        <div class="row">
                            <div class="col text-center">
                                <input class="btn btn-warning" type="submit" value="Agregar Insumo" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl"></div>
    </div>
<!-- Fin -->

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
                    <td></td>
                    <td>Editar elemento</td>
                </tr>
                <?php foreach($listaInsumos as $insumo){?>
                <tr>
                    <td><?php echo $insumo['ID'] ?></td>
                    <td><?php echo $insumo['Nombre'] ?></td>
                    <td><?php echo $insumo['Cantidad'] ?></td>
                    <td><?php echo $insumo['Stock_minimo'] ?></td>
                    <td>
                        <table class="table table-bordered">
                            <thead>
                                <td>Proveedor</td>
                                <td>Código Insumo</td>
                                <td>Descripción</td>
                                <td>Presentación</td>
                                <td>Precio</td>
                            </thead>
                            <tbody>
                    <?php foreach($listaProveedores as $proveedor){ ?>
                    <?php foreach($listaProvee as $provee){ ?>
                    <?php if($insumo['ID']==$provee['ID_Insumo'] && $proveedor['ID']==$provee['ID_Proveedor']){ ?>
                                <tr>
                                    <td><?php echo $proveedor['Nombre'] ?></td>
                                    <td><?php echo $provee['Codigo_Insumo'] ?></td>
                                    <td><?php echo $provee['Descripcion'] ?></td>
                                    <td><?php echo $provee['Presentacion'] ?></td>
                                    <td><?php echo $provee['Precio'] ?></td>
                                </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <form method="POST">
                            <div class="row border">
                                <!-- <div class="col-3"></div> -->
                                <div class="col">
                                    <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $insumo['ID'] ?>"></input></div>
                                    <div class="row m-1"><input type="hidden" name="txtNombreEditar" id="txtNombreEditar" value="<?php echo $insumo['Nombre'] ?>"></input></div>
                                    <div class="row m-1"><input type="hidden" name="txtStockMinimoEditar" id="txtStockMinimoEditar" value="<?php echo $insumo['Stock_minimo'] ?>"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Seleccionar" class="btn btn-info"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Eliminar" class="btn btn-danger"></input></div>
                                </div>
                                <!-- <div class="col-3"></div> -->
                            </div>
                        </form>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php
    include_once("../../src/footer.php");
?>