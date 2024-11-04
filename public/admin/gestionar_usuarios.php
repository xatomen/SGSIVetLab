<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtIDCredencial = (isset($_POST['txtIDCredencial']))?$_POST['txtIDCredencial']:"";
    $txtIDArea = (isset($_POST['txtIDArea']))?$_POST['txtIDArea']:"";

    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtUsuarioAgregar = (isset($_POST['txtUsuarioAgregar']))?$_POST['txtUsuarioAgregar']:"";
    $txtContraseniaAgregar = (isset($_POST['txtContraseniaAgregar']))?$_POST['txtContraseniaAgregar']:"";
    $txtAreaAgregar = (isset($_POST['txtAreaAgregar']))?$_POST['txtAreaAgregar']:"";

    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtUsuarioEditar = (isset($_POST['txtUsuarioEditar']))?$_POST['txtUsuarioEditar']:"";
    $txtContraseniaEditar = (isset($_POST['txtContraseniaEditar']))?$_POST['txtContraseniaEditar']:"";
    $txtAreaEditar = (isset($_POST['txtAreaEditar']))?$_POST['txtAreaEditar']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM administrador WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtNombreEditar = $ListaSel['Nombre'];
            $txtIDCredencial = $ListaSel['ID_Credenciales'];

            $sentenciaSQL=$conn->prepare("SELECT * FROM credenciales WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtIDCredencial);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            
            $txtUsuarioEditar = $ListaSel['Usuario'];
            $txtContraseniaEditar = $ListaSel['Contrasenha'];
            
            break;
    
        case "Editar":
            // $mensaje = "Proveedor editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE administrador SET Nombre=:Nombre WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Nombre', $txtNombreEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conn->prepare("UPDATE credenciales SET Usuario=:Usuario, Contrasenha=:Contrasenha WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Usuario', $txtUsuarioEditar);
            $sentenciaSQL->bindParam(':Contrasenha', $txtContraseniaEditar);
            $sentenciaSQL->bindParam(':ID', $txtIDCredencial);
            $sentenciaSQL->execute();

            $txtID="";
            $txtNombreEditar = "";
            $txtIDCredencial = "";
            $txtUsuarioEditar = "";
            $txtContraseniaEditar = "";

            header("Location: gestionar_usuarios.php");
            exit();
    
        // TERMINAR EL AGREGAR!!!!!!!!
        case "Agregar":
            // $mensaje = "Proveedor agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $txtTipoUsuario = "Usuario";
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM credenciales");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindexCred = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO credenciales (ID, Usuario, Contrasenha, Tipo_Usuario) VALUES (:ID, :Usuario, :Contrasenha, :Tipo_Usuario)");
            $sentenciaSQL->bindParam(':Usuario', $txtUsuarioAgregar);
            $sentenciaSQL->bindParam(':Contrasenha', $txtContraseniaAgregar);
            $sentenciaSQL->bindParam(':Tipo_Usuario', $txtTipoUsuario);
            $sentenciaSQL->bindParam(':ID', $lastindexCred);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM empleado");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindexEmp = $resultado['lastIndex']+1;

            $sentenciaSQL = $conn->prepare("INSERT INTO empleado (ID, Nombre, ID_Credenciales, ID_Area) VALUES (:ID, :Nombre, :ID_Credenciales, :ID_Area)");
            $sentenciaSQL->bindParam(':Nombre', $txtNombreAgregar);
            $sentenciaSQL->bindParam(':ID_Credenciales', $lastindexCred);
            $sentenciaSQL->bindParam(':ID_Area', $txtAreaAgregar);
            $sentenciaSQL->bindParam(':ID', $lastindexEmp);
            $sentenciaSQL->execute();
            
            header("Location: gestionar_usuarios.php");
            exit();
    
        case "Eliminar":
            // $mensaje = "Proveedor eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM empleado WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conn->prepare("DELETE FROM credenciales WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtIDCredencial);
            $sentenciaSQL->execute();

            header("Location: gestionar_usuarios.php");
            exit();
    
    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM empleado");
    $sentenciaSQL->execute();
    $listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM credenciales");
    $sentenciaSQL->execute();
    $listaCredenciales=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaAreas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        <!-- Agregar -->
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Agregar usuario</h4>
                    <hr>
                    <form method="POST">
                        <!-- Nombre -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtNombreAgregar" class="form-label">Nombre</label>
                                <input class="form-control" name="txtNombreAgregar" id="txtNombreAgregar" placeholder="Ingrese el nombre"></input>
                            </div>
                        </div>
                        <!-- Area -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtAreaAgregar" class="form-label">Área</label>
                                <input class="form-control" name="txtAreaAgregar" id="txtAreaAgregar" placeholder="Ingrese el área"></input>
                            </div>
                        </div>
                        <!-- Usuario -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtUsuarioAgregar" class="form-label">Nombre de usuario</label>
                                <input class="form-control" name="txtUsuarioAgregar" id="txtUsuarioAgregar" placeholder="Ingrese el nombre de usuario"></input>
                            </div>
                        </div>
                        <!-- Contraseña -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtContraseniaAgregar" class="form-label">Contraseña</label>
                                <input class="form-control" name="txtContraseniaAgregar" id="txtContraseniaAgregar" placeholder="Ingrese la contraseña"></input>
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
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Editar usuario seleccionado</h4>
                    <hr>
                    <form method="POST">
                        <!-- ID -->
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtID" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID">
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <!-- Nombre -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtNombreEditar" class="form-label">Nombre</label>
                                <input class="form-control" name="txtNombreEditar" id="txtNombreEditar" value="<?php echo $txtNombreEditar?>" placeholder="Ingrese el nombre"></input>
                            </div>
                        </div>
                        <!-- Area -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtAreaEditar" class="form-label">Área</label>
                                <input class="form-control" name="txtAreaEditar" id="txtAreaEditar" placeholder="Ingrese el área"></input>
                            </div>
                        </div>
                        <!-- Usuario -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtUsuarioEditar" class="form-label">Nombre de usuario</label>
                                <input class="form-control" name="txtUsuarioEditar" id="txtUsuarioEditar" value="<?php echo $txtUsuarioEditar?>" placeholder="Ingrese el nombre de usuario"></input>
                            </div>
                        </div>
                        <!-- Contraseña -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtContraseniaEditar" class="form-label">Contraseña</label>
                                <input class="form-control" name="txtContraseniaEditar" id="txtContraseniaEditar" value="<?php echo $txtContraseniaEditar?>" placeholder="Ingrese la contraseña"></input>
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
    <div class="card row m-5 shadow overflow-scroll">
        <table class="table table-bordered">
            <thead>
                <h4 class="p-2">Listado de usuarios</h4>
            </thead>
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>Nombre</td>
                    <td>Usuario</td>
                    <td>Contraseña</td>
                    <td>Área</td>
                </tr>
                <?php foreach($listaUsuarios as $lista){?>
                <tr>
                    <td><?php echo $lista['ID'] ?></td>
                    <td><?php echo $lista['Nombre']?></td>
                    <?php foreach($listaCredenciales as $credencial){if($lista['ID_Credenciales']==$credencial['ID']){?>
                    <td><?php echo $credencial['Usuario'] ?></td>
                    <td><?php echo $credencial['Contrasenha'] ?></td>
                    <?php } } ?>
                    <?php foreach($listaAreas as $area){if($lista['ID_Area']==$area['ID']){?>
                    <td><?php echo $area['ID'] ?></td>
                    <td><?php echo $area['Area'] ?></td>
                    <?php } } ?>
                    
                    <td>
                        <form method="POST">
                            <div class="row border">
                                <!-- <div class="col-3"></div> -->
                                <div class="col">
                                    <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['ID'] ?>"></input></div>
                                    <div class="row m-1"><input type="hidden" name="txtIDCredencial" id="txtIDCredencial" value="<?php echo $credencial['ID'] ?>"></input></div>
                                    <div class="row m-1"><input type="hidden" name="txtIDArea" id="txtIDArea" value="<?php echo $area['ID'] ?>"></input></div>
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