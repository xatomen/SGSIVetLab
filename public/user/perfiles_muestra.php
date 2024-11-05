<?php
    include_once("../../config/database.php");
    include_once("../../src/header_user.php");

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

    // $sentenciaSQL= $conn->prepare("SELECT perfil_muestra.ID AS ID, perfil_muestra.Tipo_de_muestra AS Tipo_de_muestra, perfil_muestra.ID_Area AS ID_Area_PM, area.ID AS ID_Area_A, area.Area AS Area FROM perfil_muestra, area WHERE ID_Area_PM = ID_Area_A;");
    // $sentenciaSQL= $conn->prepare("SELECT * FROM perfil_muestra, area WHERE perfil_muestra.ID_Area = area.ID;");
    $sentenciaSQL = $conn->prepare("SELECT perfil_muestra.ID AS PerfilID, perfil_muestra.Tipo_de_muestra, perfil_muestra.ID_Area, area.Area FROM perfil_muestra INNER JOIN area ON perfil_muestra.ID_Area = area.ID;");
    $sentenciaSQL->execute();
    $listaPerfilMuestra=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT ID as ID_Insumo, Nombre FROM insumo;");
    $sentenciaSQL->execute();
    $insumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM componentes_perfil_muestra;");
    $sentenciaSQL->execute();
    $componentes=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaAreas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Listado -->
    <div class="card row m-5 shadow overflow-scroll">
        <table class="table table-bordered">
            <thead>
                <h4 class="p-2">Listado de perfiles de muestra</h4>
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
                                if($componente['ID_Muestra'] == $lista['PerfilID'] && $componente['ID_Insumo'] == $insumo['ID_Insumo']){ ?>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td>Cantidad</td>
                            </tr>
                        </thead>    
                            <tbody>
                                <tr>
                                    <td><?php echo $insumo['ID_Insumo']?></td>
                                    <td><?php echo $insumo['Nombre']?></td>
                                    <td><?php echo $componente['Cantidad']?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php }
                            }
                        } ?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php
    include_once("../../src/footer.php");
?>