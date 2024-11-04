<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";

    $txtRutAgregar = (isset($_POST['txtRutAgregar']))?$_POST['txtRutAgregar']:"";
    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtCorreoAgregar = (isset($_POST['txtCorreoAgregar']))?$_POST['txtCorreoAgregar']:"";
    $txtTelefonoAgregar = (isset($_POST['txtTelefonoAgregar']))?$_POST['txtTelefonoAgregar']:"";
    $txtDireccionAgregar = (isset($_POST['txtDireccionAgregar']))?$_POST['txtDireccionAgregar']:"";
    $txtComunaAgregar = (isset($_POST['txtComunaAgregar']))?$_POST['txtComunaAgregar']:"";
    $txtCiudadAgregar = (isset($_POST['txtCiudadAgregar']))?$_POST['txtCiudadAgregar']:"";
    $txtGiroAgregar = (isset($_POST['txtGiroAgregar']))?$_POST['txtGiroAgregar']:"";

    $txtRutEditar = (isset($_POST['txtRutEditar']))?$_POST['txtRutEditar']:"";
    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtCorreoEditar = (isset($_POST['txtCorreoEditar']))?$_POST['txtCorreoEditar']:"";
    $txtTelefonoEditar = (isset($_POST['txtTelefonoEditar']))?$_POST['txtTelefonoEditar']:"";
    $txtDireccionEditar = (isset($_POST['txtDireccionEditar']))?$_POST['txtDireccionEditar']:"";
    $txtComunaEditar = (isset($_POST['txtComunaEditar']))?$_POST['txtComunaEditar']:"";
    $txtCiudadEditar = (isset($_POST['txtCiudadEditar']))?$_POST['txtCiudadEditar']:"";
    $txtGiroEditar = (isset($_POST['txtGiroEditar']))?$_POST['txtGiroEditar']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM proveedor WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtRutEditar = $ListaSel['RUT'];
            $txtNombreEditar = $ListaSel['Nombre'];
            $txtCorreoEditar = $ListaSel['Correo'];
            $txtTelefonoEditar = $ListaSel['Telefono'];
            $txtDireccionEditar = $ListaSel['Direccion'];
            $txtComunaEditar = $ListaSel['Comuna'];
            $txtCiudadEditar = $ListaSel['Ciudad'];
            $txtGiroEditar = $ListaSel['Giro'];
            break;
    
        case "Editar":
            // $mensaje = "Proveedor editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE proveedor SET RUT=:RUT, NOMBRE=:NOMBRE, CORREO=:CORREO, TELEFONO=:TELEFONO, DIRECCION=:DIRECCION, Comuna=:Comuna, Ciudad=:Ciudad, Giro=:Giro WHERE ID=:ID");
            $sentenciaSQL->bindParam(':RUT', $txtRutEditar);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreEditar);
            $sentenciaSQL->bindParam(':CORREO', $txtCorreoEditar);
            $sentenciaSQL->bindParam(':TELEFONO', $txtTelefonoEditar);
            $sentenciaSQL->bindParam(':DIRECCION', $txtDireccionEditar);
            $sentenciaSQL->bindParam(':Comuna', $txtComunaEditar);
            $sentenciaSQL->bindParam(':Ciudad', $txtCiudadEditar);
            $sentenciaSQL->bindParam(':Giro', $txtGiroEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            $txtID="";
            $txtRutEditar = "";
            $txtNombreEditar = "";
            $txtCorreoEditar = "";
            $txtTelefonoEditar = "";
            $txtDireccionEditar = "";
            $txtComunaEditar = "";
            $txtCiudadEditar = "";
            $txtGiroEditar = "";
            header("Location: mantener_proveedores.php");
            exit();
    
        case "Agregar":
            // $mensaje = "Proveedor agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM proveedor");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO proveedor (ID, RUT, NOMBRE, CORREO, TELEFONO, DIRECCION, Comuna, Ciudad, Giro) VALUES (:ID, :RUT, :NOMBRE, :CORREO, :TELEFONO, :DIRECCION, :Comuna, :Ciudad, :Giro)");
            $sentenciaSQL->bindParam(':RUT', $txtRutAgregar);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreAgregar);
            $sentenciaSQL->bindParam(':CORREO', $txtCorreoAgregar);
            $sentenciaSQL->bindParam(':TELEFONO', $txtTelefonoAgregar);
            $sentenciaSQL->bindParam(':DIRECCION', $txtDireccionAgregar);
            $sentenciaSQL->bindParam(':Comuna', $txtComunaAgregar);
            $sentenciaSQL->bindParam(':Ciudad', $txtCiudadAgregar);
            $sentenciaSQL->bindParam(':Giro', $txtGiroAgregar);
            $sentenciaSQL->bindParam(':ID', $lastindex);
            $sentenciaSQL->execute();
            header("Location: mantener_proveedores.php");
            exit();
    
        case "Eliminar":
            // $mensaje = "Proveedor eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM proveedor WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();
            header("Location: mantener_proveedores.php");
            exit();
    
        case "Deseleccionar":
            $txtID="";
            $txtRutEditar = "";
            $txtNombreEditar = "";
            $txtCorreoEditar = "";
            $txtTelefonoEditar = "";
            $txtDireccionEditar = "";
            $txtComunaEditar = "";
            $txtCiudadEditar = "";
            $txtGiroEditar = "";
            break;

    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        <!-- Agregar -->
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Agregar proveedor</h4>
                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col">
                                <!-- RUT -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtRutAgregar" class="form-label">Rut</label>
                                        <input class="form-control" name="txtRutAgregar" id="txtRutAgregar" placeholder="Ingrese el RUT"></input>
                                    </div>
                                </div>
                                <!-- Nombre -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtNombreAgregar" class="form-label">Nombre</label>
                                        <input class="form-control" name="txtNombreAgregar" id="txtNombreAgregar" placeholder="Ingrese el nombre"></input>
                                    </div>
                                </div>
                                <!-- Correo -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtCorreoAgregar" class="form-label">Correo</label>
                                        <input class="form-control" name="txtCorreoAgregar" id="txtCorreoAgregar" placeholder="Ingrese el correo"></input>
                                    </div>
                                </div>
                                <!-- Teléfono -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtTelefonoAgregar" class="form-label">Teléfono</label>
                                        <input class="form-control" name="txtTelefonoAgregar" id="txtTelefonoAgregar" placeholder="Ingrese el número telefónico"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <!-- Dirección -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtDireccionAgregar" class="form-label">Dirección</label>
                                        <input class="form-control" name="txtDireccionAgregar" id="txtDireccionAgregar" placeholder="Ingrese la dirección"></input>
                                    </div>
                                </div>
                                <!-- Comuna -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtComunaAgregar" class="form-label">Comuna</label>
                                        <input class="form-control" name="txtComunaAgregar" id="txtComunaAgregar" placeholder="Ingrese la comuna"></input>
                                    </div>
                                </div>
                                <!-- Ciudad -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtCiudadAgregar" class="form-label">Ciudad</label>
                                        <input class="form-control" name="txtCiudadAgregar" id="txtCiudadAgregar" placeholder="Ingrese la ciudad"></input>
                                    </div>
                                </div>
                                <!-- Giro -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtGiroAgregar" class="form-label">Giro</label>
                                        <input class="form-control" name="txtGiroAgregar" id="txtGiroAgregar" placeholder="Ingrese el giro"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botón agregar -->
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Editar -->
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Editar proveedor seleccionado</h4>
                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col-6">
                                <!-- ID -->
                                <input type="hidden" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID">
                                <!-- RUT -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtRutEditar" class="form-label">Rut</label>
                                        <input class="form-control" name="txtRutEditar" id="txtRutEditar" value="<?php echo $txtRutEditar?>" placeholder="Ingrese el RUT"></input>
                                    </div>
                                </div>
                                <!-- Nombre -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtNombreEditar" class="form-label">Nombre</label>
                                        <input class="form-control" name="txtNombreEditar" id="txtNombreEditar" value="<?php echo $txtNombreEditar?>" placeholder="Ingrese el nombre"></input>
                                    </div>
                                </div>
                                <!-- Correo -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtCorreoEditar" class="form-label">Correo</label>
                                        <input class="form-control" name="txtCorreoEditar" id="txtCorreoEditar" value="<?php echo $txtCorreoEditar?>" placeholder="Ingrese el correo"></input>
                                    </div>
                                </div>
                                <!-- Teléfono -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtTelefonoEditar" class="form-label">Teléfono</label>
                                        <input class="form-control" name="txtTelefonoEditar" id="txtTelefonoEditar" value="<?php echo $txtTelefonoEditar?>" placeholder="Ingrese el número telefónico"></input>
                                    </div>
                                </div>
                                
                            </div>
                            

                            <div class="col-6">
                                <!-- Dirección -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtDireccionEditar" class="form-label">Dirección</label>
                                        <input class="form-control" name="txtDireccionEditar" id="txtDireccionEditar" value="<?php echo $txtDireccionEditar?>" placeholder="Ingrese la dirección"></input>
                                    </div>
                                </div>
                                <!-- Comuna -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtComunaEditar" class="form-label">Comuna</label>
                                        <input class="form-control" name="txtComunaEditar" id="txtComunaEditar" value="<?php echo $txtComunaEditar?>" placeholder="Ingrese la comuna"></input>
                                    </div>
                                </div>
                                <!-- Ciudad -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtCiudadEditar" class="form-label">Ciudad</label>
                                        <input class="form-control" name="txtCiudadEditar" id="txtCiudadEditar" value="<?php echo $txtCiudadEditar?>" placeholder="Ingrese la ciudad"></input>
                                    </div>
                                </div>
                                <!-- Giro -->
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="txtGiroEditar" class="form-label">Giro</label>
                                        <input class="form-control" name="txtGiroEditar" id="txtGiroEditar" value="<?php echo $txtGiroEditar?>" placeholder="Ingrese el giro"></input>
                                    </div>
                                </div>
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
        <div class="col-xl"></div>
    </div>
<!-- Fin -->

<!-- Listado -->
</div>
    <div class="card row m-5 shadow overflow-scroll">
        <table class="table table-bordered">
            <thead>
                <h4 class="p-2">Listado de proveedores</h4>
            </thead>
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>RUT</td>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Dirección</td>
                    <td>Comuna</td>
                    <td>Ciudad</td>
                    <td>Giro</td>
                </tr>
                <?php foreach($listaProveedores as $lista){?>
                <tr>
                    <td><?php echo $lista['ID'] ?></td>
                    <td><?php echo $lista['RUT'] ?></td>
                    <td><?php echo $lista['Nombre'] ?></td>
                    <td><?php echo $lista['Correo'] ?></td>
                    <td><?php echo $lista['Telefono'] ?></td>
                    <td><?php echo $lista['Direccion'] ?></td>
                    <td><?php echo $lista['Comuna'] ?></td>
                    <td><?php echo $lista['Ciudad'] ?></td>
                    <td><?php echo $lista['Giro'] ?></td>
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
    include_once("../../src/footer.php");
?>