<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtTipoMuestraAgregar = (isset($_POST['txtTipoMuestraAgregar']))?$_POST['txtTipoMuestraAgregar']:"";
    $txtIDAreaAgregar = (isset($_POST['txtIDAreaAgregar']))?$_POST['txtIDAreaAgregar']:"";
    $txtTipoMuestraEditar = (isset($_POST['txtTipoMuestraEditar']))?$_POST['txtTipoMuestraEditar']:"";
    $txtIDAreaEditar = (isset($_POST['txtIDAreaEditar']))?$_POST['txtIDAreaEditar']:"";
    
    $txtIDInsumo = (isset($_POST['txtIDInsumo']))?$_POST['txtIDInsumo']:"";
    $txtIDMuestra = (isset($_POST['txtIDMuestra']))?$_POST['txtIDMuestra']:"";
    $txtIDComponentePerfilMuestra = (isset($_POST['txtIDComponentePerfilMuestra']))?$_POST['txtIDComponentePerfilMuestra']:"";
    $txtCantidadInsumo = (isset($_POST['txtCantidadInsumo']))?$_POST['txtCantidadInsumo']:"";

    $accion_perfil = (isset($_POST['accion_perfil']))?$_POST['accion_perfil']:"";

    $accion_componente = (isset($_POST["accion_componente"]))?$_POST["accion_componente"]:"";

    switch ($accion_componente){

        case "Añadir":
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Componentes_perfil_muestra) AS lastIndex FROM componentes_perfil_muestra;");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            $sentenciaSQL = $conn->prepare("INSERT INTO componentes_perfil_muestra (ID_Componentes_perfil_muestra, Cantidad, ID_Muestra, insumo_ID) VALUES (:ID_Componentes_perfil_muestra, :Cantidad, :ID_Muestra, :insumo_ID);");
            $sentenciaSQL->bindParam(":ID_Componentes_perfil_muestra", $lastindex);
            $sentenciaSQL->bindParam(":Cantidad",$txtCantidadInsumo);
            $sentenciaSQL->bindParam(":ID_Muestra",$txtID);
            $sentenciaSQL->bindParam(":insumo_ID",$txtIDInsumo);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();

        case "Eliminar":
            $sentenciaSQL = $conn->prepare("DELETE FROM componentes_perfil_muestra WHERE ID_Componentes_perfil_muestra = :ID_ComponentePerfilMuestra;");
            $sentenciaSQL->bindParam(":ID_ComponentePerfilMuestra", $txtIDComponentePerfilMuestra);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();

        case "Editar":
            $sentenciaSQL = $conn->prepare("UPDATE componentes_perfil_muestra SET Cantidad=:Cantidad WHERE ID_Componentes_perfil_muestra=:ID_ComponentePerfilMuestra");
            $sentenciaSQL->bindParam(":Cantidad",$txtCantidadInsumo);
            $sentenciaSQL->bindParam(':ID_ComponentePerfilMuestra', $txtIDComponentePerfilMuestra);
            $sentenciaSQL->execute();
            $txtCantidadInsumo="";
            header("Location: mantener_perfiles_muestra.php");
            exit();

    }


    switch ($accion_perfil){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM perfil_muestra WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtTipoMuestraEditar = $ListaSel['Tipo_de_muestra'];
            $txtIDAreaEditar = $ListaSel['ID_Area'];

            break;
    
        case "Editar":
            // $mensaje = "Proveedor editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE perfil_muestra SET Tipo_de_muestra=:Tipo_de_muestra, ID_Area=:ID_Area WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Tipo_de_muestra', $txtTipoMuestraEditar);
            $sentenciaSQL->bindParam(':ID_Area', $txtIDAreaEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            $txtID="";
            $txtRutEditar = "";
            $txtNombreEditar = "";
            $txtCorreoEditar = "";
            $txtTelefonoEditar = "";
            $txtDireccionEditar = "";
            header("Location: mantener_perfiles_muestra.php");
            exit();
    
        case "Agregar":
            // $mensaje = "Proveedor agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM perfil_muestra");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO perfil_muestra (ID, Tipo_de_muestra, ID_Area) VALUES (:ID, :Tipo_de_muestra, :ID_Area)");
            $sentenciaSQL->bindParam(':Tipo_de_muestra', $txtTipoMuestraAgregar);
            $sentenciaSQL->bindParam(':ID_Area', $txtIDAreaAgregar);
            $sentenciaSQL->bindParam(':ID', $lastindex);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();
    
        case "Eliminar":
            // $mensaje = "Proveedor eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM perfil_muestra WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();
    
    }

    // $sentenciaSQL= $conn->prepare("SELECT perfil_muestra.ID AS ID, perfil_muestra.Tipo_de_muestra AS Tipo_de_muestra, perfil_muestra.ID_Area AS ID_Area_PM, area.ID AS ID_Area_A, area.Area AS Area FROM perfil_muestra, area WHERE ID_Area_PM = ID_Area_A;");
    // $sentenciaSQL= $conn->prepare("SELECT * FROM perfil_muestra, area WHERE perfil_muestra.ID_Area = area.ID;");
    $sentenciaSQL = $conn->prepare("SELECT perfil_muestra.ID AS PerfilID, perfil_muestra.Tipo_de_muestra, area.Area FROM perfil_muestra INNER JOIN area ON perfil_muestra.ID_Area = area.ID;");
    $sentenciaSQL->execute();
    $listaPerfilMuestra=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT ID as ID_Insumo, Nombre FROM insumo;");
    $sentenciaSQL->execute();
    $insumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM componentes_perfil_muestra;");
    $sentenciaSQL->execute();
    $componentes=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        <!-- Agregar -->
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Agregar perfil de muestra</h4>
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
                        <!-- Tipo de muestra -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtTipoMuestraAgregar" class="form-label">Tipo de muestra</label>
                                <input class="form-control" name="txtTipoMuestraAgregar" id="txtTipoMuestraAgregar" placeholder="Ingrese el tipo de muestra"></input>
                            </div>
                        </div>
                        <!-- ID Área -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtIDAreaAgregar" class="form-label">Área</label>
                                <input class="form-control" name="txtIDAreaAgregar" id="txtIDAreaAgregar" placeholder="Seleccione el área"></input>
                            </div>
                        </div>
                        <!-- Botón agregar -->
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Agregar" name="accion_perfil">
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
                    <h4 class="text-center">Editar perfil de muestra seleccionado</h4>
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
                        <!-- Tipo de muestra -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtTipoMuestraEditar" class="form-label">Tipo de muestra</label>
                                <input class="form-control" name="txtTipoMuestraEditar" id="txtTipoMuestraEditar" placeholder="Ingrese el tipo de muestra"></input>
                            </div>
                        </div>
                        <!-- ID Área -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtIDAreaEditar" class="form-label">Área</label>
                                <input class="form-control" name="txtIDAreaEditar" id="txtIDAreaEditar" placeholder="Seleccione el área"></input>
                            </div>
                        </div>
                        <!-- Editar -->
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Editar" name="accion_perfil">
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
                <h4 class="p-2">Listado de proveedores</h4>
            </thead>
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>Tipo de muestra</td>
                    <td>Área</td>
                    <td>Componentes</td>
                </tr>
                <?php foreach($listaPerfilMuestra as $lista){?>
                <tr>
                    <td><?php echo $lista["PerfilID"] ?></td>
                    <td><?php echo $lista['Tipo_de_muestra'] ?></td>
                    <td><?php echo $lista['Area'] ?></td>
                    <td>
                        <?php foreach($componentes as $componente){
                            foreach($insumos as $insumo){
                                if($componente['ID_Muestra'] == $lista['PerfilID'] && $componente['insumo_ID'] == $insumo['ID_Insumo']){ ?>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td>Cantidad</td>
                                <td>Acción</td>
                            </tr>
                        </thead>    
                            <tbody>
                                <tr>
                                    <td><?php echo $insumo['ID_Insumo']?></td>
                                    <td><?php echo $insumo['Nombre']?></td>
                                    <td><?php echo $componente['Cantidad']?></td>
                                    <td>
                                        <form method="POST">
                                            <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['PerfilID'] ?>"></input></div>
                                            <div class="row m-1"><input type="hidden" name="txtIDMuestra" id="txtIDMuestra" value="<?php echo $componente['ID_Muestra'] ?>"></input></div>
                                            <div class="row m-1"><input type="hidden" name="txtIDInsumo" id="txtIDInsumo" value="<?php echo $componente['insumo_ID'] ?>"></input></div>
                                            <div class="row m-1"><input type="hidden" name="txtIDComponentePerfilMuestra" id="txtIDComponentePerfilMuestra" value="<?php echo $componente['ID_Componentes_perfil_muestra'] ?>"></input></div>
                                            <!-- Submenú para editar cantidad de insumos -->
                                            <div class="row m-1 dropdown text-center">
                                                <a class="btn btn-warning dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Editar</a>
                                                <ul class="dropdown-menu">
                                                    <div class="card p-3">
                                                        <h4>Editar cantidad</h4>
                                                        <hr>
                                                        <div class="row m-1">
                                                            <label for="txtCantidadInsumo" class="form-label">Cantidad</label>
                                                            <input type="text" name="txtCantidadInsumo" id="txtCantidadInsumo" value="">
                                                        </div>
                                                        <div class="row m-1">
                                                            <input type="submit" name="accion_componente" value="Editar" class="btn btn-warning">
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                            <!--  -->
                                            <div class="row m-1"><input type="submit" name="accion_componente" value="Eliminar" class="btn btn-danger"></input></div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php }
                            }
                        } ?>
                        <!-- Submenú para agregar componente al perfil de muestra -->
                        <div class="dropdown text-center">
                            <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Añadir componente</a>
                            <ul class="dropdown-menu">
                                <div class="card p-3">
                                    <h4>Añadir componente</h4>
                                    <hr>
                                    <form method="POST">
                                        <div class="row m-1">
                                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['PerfilID'] ?>">
                                        </div>
                                        <div class="row m-1">
                                            <label for="txtIDInsumo" class="form-label">ID Insumo</label>
                                            <input type="text" name="txtIDInsumo" id="txtIDInsumo" value="">
                                        </div>
                                        <div class="row m-1">
                                            <label for="txtCantidadInsumo" class="form-label">Cantidad</label>
                                            <input type="text" name="txtCantidadInsumo" id="txtCantidadInsumo" value="">
                                        </div>
                                        <div class="row m-1">
                                            <input type="submit" name="accion_componente" value="Añadir" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
                            </ul>
                        </div>
                        <!--  -->
                    </td>
                    <td>
                        <form method="POST">
                            <div class="row border">
                                <!-- <div class="col-3"></div> -->
                                <div class="col">
                                    <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['PerfilID'] ?>"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion_perfil" value="Seleccionar" class="btn btn-info"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion_perfil" value="Eliminar" class="btn btn-danger"></input></div>
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