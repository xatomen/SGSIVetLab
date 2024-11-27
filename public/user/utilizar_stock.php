<?php
    
    require_once '../../src/header_user.php';

    require_once '../../config/database.php';

    // $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    
    $txtCodigoInsumo = (isset($_POST['txtCodigoInsumo']))?$_POST['txtCodigoInsumo']:"";
    $txtCantidad = (isset($_POST['txtCantidad']))?$_POST['txtCantidad']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    date_default_timezone_set('America/Santiago');
    $txtFecha = date('Y-m-d H:i:s'); // Formato: Año-Mes-Día Hora:Minuto:Segundo
    // echo $txtFecha;

    switch ($accion){
        
        case "Usar":

            // Para obtener la ID del insumo, debemos leer el Código del Insumo del proveedor (tabla Provee)
            $sentenciaSQL = $conn->prepare("SELECT ID_Insumo FROM Provee WHERE Codigo_Insumo = :Codigo_Insumo");
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoInsumo);   
            $sentenciaSQL->execute();
            // Recuperamos el ID
            $txtID = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $txtID = $txtID['ID_Insumo'];
            echo $txtID;

            // Debemos crear un registro en la tabla registro_insumo
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Insumo_Empleado) AS lastIndex FROM insumo_usado_empleado");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            $sentenciaSQL = $conn->prepare("INSERT INTO insumo_usado_empleado (ID_Insumo_Empleado, Fecha, Cantidad, ID_Empleado, ID_Insumo) VALUES (:ID_Insumo_Empleado, :Fecha, :Cantidad, :ID_Empleado, :ID_Insumo)");

            // Indicamos la ID del registro
            $sentenciaSQL->bindParam(":ID_Insumo_Empleado", $lastindex);

            // Debemos indicar la fecha
            $sentenciaSQL->bindParam(':Fecha', $txtFecha);

            // Debemos indicar la cantidad de insumos
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad);        
            
            // Debemos indicar el ID del administrador
            $txtIDAdministrador = 1;
            $sentenciaSQL->bindParam(":ID_Empleado", $_SESSION['ID']);

            // Debemos indicar el ID del insumo
            $sentenciaSQL->bindParam(':ID_Insumo', $txtID);        

            // Ejecutamos la sentencia SQL
            $sentenciaSQL->execute();

            // Ahora debemos incrementar la cantidad de insumos en la tabla insumos
            $sentenciaSQL = $conn->prepare("UPDATE insumo SET Cantidad = Cantidad - :Cantidad WHERE ID = :ID");
            $sentenciaSQL->bindParam(':Cantidad', $txtCantidad); 
            $sentenciaSQL->bindParam(':ID', $txtID); 
            $sentenciaSQL->execute();

            header("Location: http://localhost/SGSIVetLab/public/user/utilizar_stock.php");
            exit();
    
    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM Provee");
    $sentenciaSQL->execute();
    $listaProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM empleado WHERE ID_Credenciales = :ID_Credenciales");
    $sentenciaSQL->bindParam(':ID_Credenciales', $_SESSION['ID']);
    $sentenciaSQL->execute();
    $empleado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    $areaUsuario = $empleado['ID_Area'];

    $sentenciaSQL= $conn->prepare("SELECT * FROM registro_insumo");
    $sentenciaSQL->execute();
    $listaRegistro=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaArea=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Usar insumo</h4>
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
                                <input class="btn btn-warning" type="submit" value="Usar" name="accion">
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
    <div class="card col row m-5 shadow">
        <h4 class="p-2">Listado de insumos</h4>
        <hr>
        <table id="insumosTable" class="table">
            <thead>
                <tr>
                    <th>Código Único</th>
                    <th>Insumo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Presentación</th>
                    <th>Área</th>
                    <th>Proveedor</th>
                    <th>Fecha de vencimeinto próxima</th>
                    <th>Semáforo</th>
                </tr>                
            </thead>
            <tbody>
                <?php foreach($listaProvee as $provee){ if($areaUsuario == $provee['ID_Area']){?>
                <tr>
                    <td><?php echo $provee['Codigo_Insumo'] ?></td>
                    <td>
                        <?php 
                            foreach($listaInsumos as $insumo) {
                                if($insumo['ID'] == $provee['ID_Insumo']) {
                                    echo $insumo['Nombre'];
                                    break;
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $provee['Cantidad'] ?></td>
                    <td><?php echo $provee['Precio'] ?></td>
                    <td><?php echo $provee['Descripcion'] ?></td>
                    <td><?php echo $provee['Presentacion'] ?></td>
                    <td class="area">
                        <?php 
                            foreach($listaArea as $area) {
                                if($area['ID'] == $provee['ID_Area']) {
                                    echo $area['Area'];
                                    break;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            foreach($listaProveedores as $proveedor) {
                                if($proveedor['ID'] == $provee['ID_Proveedor']) {
                                    echo $proveedor['Nombre'];
                                    break;
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            $fechaVencimiento = "";
                            $fechaActual = new DateTime();
                            $fechaMinima = null;

                            foreach($listaRegistro as $registro) {
                                if($registro['ID_Provee'] == $provee['ID_Provee']) {
                                    $fechaVenc = new DateTime($registro['Fecha_vencimiento']);
                                    if ($fechaMinima === null || $fechaVenc < $fechaMinima) {
                                        $fechaMinima = $fechaVenc;
                                    }
                                }
                            }

                            if ($fechaMinima !== null) {
                                $diferencia = $fechaActual->diff($fechaMinima)->days;
                                if ($diferencia <= 7) {
                                    $claseVencimiento = 'vencimiento-proximo';
                                    $colorSemaforo = 'rojo';
                                } elseif ($diferencia >= 8 && $diferencia <= 15) {
                                    $claseVencimiento = 'vencimiento-cercano';
                                    $colorSemaforo = 'amarillo';
                                } else {
                                    $claseVencimiento = '';
                                    $colorSemaforo = 'verde';
                                }
                                $fechaVencimiento = $fechaMinima->format('Y-m-d');
                            } else {
                                $claseVencimiento = '';
                                $colorSemaforo = '';
                            }
                        ?>
                        <span class="<?php echo $claseVencimiento; ?>">
                            <?php echo $fechaVencimiento; ?>
                        </span>
                    </td>
                    <td class="">
                        <div class="semaforo <?php echo $colorSemaforo; ?>">
                            <span class="text-hidden"><?php echo $colorSemaforo; ?></span>
                        </div>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>

    </div>

    <?php
        require_once '../../src/footer.php';
    ?>

    <script>
        $(document).ready(function() {
            // Inicializa DataTables
            var table = $('#insumosTable').DataTable();

            // Aplica la búsqueda al textbox
            $('#searchBox').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</body>
</html>