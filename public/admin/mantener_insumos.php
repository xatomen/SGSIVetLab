<?php
    require_once '../../config/database.php';
    require_once '../../src/header_admin.php';

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtStockMinimoAgregar = (isset($_POST['txtStockMinimoAgregar']))?$_POST['txtStockMinimoAgregar']:"";
    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtStockMinimoEditar = (isset($_POST['txtStockMinimoEditar']))?$_POST['txtStockMinimoEditar']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM insumo WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtNombreEditar = $ListaSel['NOMBRE'];
            $txtStockMinimoEditar = $ListaSel['STOCK_MINIMO'];
            break;
    
        case "Editar":
            $mensaje = "Insumo editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE insumo SET NOMBRE=:NOMBRE, STOCK_MINIMO=:STOCK_MINIMO WHERE ID=:ID");
            $sentenciaSQL->bindParam(':STOCK_MINIMO', $txtStockMinimoEditar);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreEditar);
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
    
    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);




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
                                    <label for="txtID" class="form-label">Nombre insumo</label>
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
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtID" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID">
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtNombreEditar" class="form-label">Nombre insumo</label>
                                    <input type="text" class="form-control" name="txtNombreEditar" id="txtNombreEditar" value="<?php echo $txtNombreEditar?>" placeholder="Ingrese el título">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtStockMinimoEditar" class="form-label">Stock mínimo</label>
                                <input class="form-control" name="txtStockMinimoEditar" id="txtStockMinimoEditar" value="<?php echo $txtStockMinimoEditar?>" placeholder="Ingrese la descripción"></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Editar" name="accion">
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
                    <td>Editar elemento</td>
                </tr>
                <?php foreach($listaInsumos as $lista){?>
                <tr>
                    <td><?php echo $lista['ID'] ?></td>
                    <td><?php echo $lista['Nombre'] ?></td>
                    <td><?php echo $lista['Cantidad'] ?></td>
                    <td><?php echo $lista['Stock_minimo'] ?></td>
                    <td>
                        <form method="POST">
                            <div class="row border">
                                <!-- <div class="col-3"></div> -->
                                <div class="col">
                                    <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['ID'] ?>"></input></div>
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
    require_once '../../src/footer.php'
?>