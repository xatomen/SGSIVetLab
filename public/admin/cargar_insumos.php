<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    // $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    
    $txtCodigoInsumo = (isset($_POST['txtCodigoInsumo']))?$_POST['txtCodigoInsumo']:"";
    $txtCantidad = (isset($_POST['txtCantidad']))?$_POST['txtCantidad']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    date_default_timezone_set('America/Santiago');
    $txtFecha = date('Y-m-d H:i:s'); // Formato: Año-Mes-Día Hora:Minuto:Segundo
    echo $txtFecha;

    switch ($accion){
        
        case "Cargar":

            // Para obtener la ID del insumo, debemos leer el Código del Insumo del proveedor (tabla Provee)
            $sentenciaSQL = $conn->prepare("SELECT ID_Insumo FROM Provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);   
            $sentenciaSQL->execute();
            // Recuperamos el ID
            $txtID = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtID = $txtID['ID_Insumo'];
            echo $txtID;

            // Debemos crear un registro en la tabla registro_insumo
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Registro_Insumo) AS lastIndex FROM registro_insumo");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            $sentenciaSQL = $conn->prepare("INSERT INTO registro_insumo (ID_Registro_Insumo, Fecha, Cantidad, ID_Administrador, ID_Insumo) VALUES (:ID_Registro_Insumo, :Fecha, :Cantidad, :ID_Administrador, :ID_Insumo)");

            // Indicamos la ID del registro
            $sentenciaSQL->bindParam(":ID_Registro_Insumo", $lastindex);

            // Debemos indicar la fecha
            $sentenciaSQL->bindParam(':Fecha', $txtFecha);

            // Debemos indicar la cantidad de insumos
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad);        
            
            // Debemos indicar el ID del administrador
            $txtIDAdministrador = 1;
            $sentenciaSQL->bindParam(":ID_Administrador", $txtIDAdministrador);

            // Debemos indicar el ID del insumo
            $sentenciaSQL->bindParam(':ID_Insumo', $txtID);        

            // Ejecutamos la sentencia SQL
            $sentenciaSQL->execute();

            // Ahora debemos incrementar la cantidad de insumos en la tabla insumos
            $sentenciaSQL = $conn->prepare("UPDATE insumo SET Cantidad = Cantidad + :Cantidad WHERE ID = :ID");
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad); 
            $sentenciaSQL->bindParam(':ID', $txtID); 
            $sentenciaSQL->execute();

            header("Location: mantener_insumos.php");
            exit();
    
    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM Provee");
    $sentenciaSQL->execute();
    $listaProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    

?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        
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
                                    <label for="txtCodigoInsumo" class="form-label">ID Insumo Proveedor</label>
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
                        <!-- Fecha -->
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtFecha" class="form-label">Fecha</label>
                                <input type="text" class="form-control" name="txtFecha" id="txtFecha" value="<?php echo $txtFecha ?>"></input>
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
                </tr>
                <?php foreach($listaInsumos as $lista){?>
                <tr>
                    <td><?php echo $lista['ID'] ?></td>
                    <td><?php echo $lista['Nombre'] ?></td>
                    <td><?php echo $lista['Cantidad'] ?></td>
                    <td><?php echo $lista['Stock_minimo'] ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php
    include_once("../../src/footer.php");
?>

                                    <!-- <select id="txtID" name="txtID" class="form-control">
                                        <option value="">Seleccione el insumo</option>
                                        <?php foreach ($listaInsumos as $insumo): ?>
                                        <option value="<?php echo $insumo['ID']; ?>" <?php echo ($insumo['ID'] == $txtID) ? 'selected' : ''; ?>>
                                            <?php echo $insumo['Nombre']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select> -->

