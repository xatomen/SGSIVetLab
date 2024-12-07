<?php
    require_once '../config/database.php';
    require_once '../src/header_user.php';

    // Ahora debemos buscar el ID del empleado considerando el ID de credenciales
    $sentenciaSQL = $conn->prepare("SELECT * FROM empleado WHERE ID_Credenciales = :ID_Credenciales");
    $sentenciaSQL->bindParam(':ID_Credenciales', $_SESSION['ID']);
    $sentenciaSQL->execute();
    $empleado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
    $txtIDEmpleado = $empleado['ID'];

    $sentenciaSQL = $conn->prepare("SELECT SUM(Cantidad) AS total_insumos FROM insumo_usado_empleado WHERE ID_Empleado = :ID_Empleado");
    $sentenciaSQL->bindParam(":ID_Empleado", $txtIDEmpleado);
    $sentenciaSQL->execute();
    $insumos = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
    $total_insumos = $insumos['total_insumos'];

?>

<div class="row justify-content-center p-2">

    <h2 class="titulo">Bienvenido</h2>
    <hr>

    <div class="row m-2">
        <div class="col"></div>

        <div class="col card-custom card-personas">
            <i class="fas fa-box"></i>
            <div class="content">
                <div class="number"><?php echo $total_insumos; ?></div>
                <div class="text">Insumos Utilizados</div>
            </div>
        </div> 

        <div class="col"></div>
    </div>

    <hr>

    
    <div class="row m-2">
        <div class="col-xl"></div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/user/utilizar_stock.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_metricas.php"){echo "active";}?>">
                <i class="fas fa-box"></i><br>Utilizar stock
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/user/perfiles_muestra.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_insumos.php"){echo "active";}?>">
                <i class="fas fa-vial"></i><br>Perfiles de muestra
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/user/movimientos_realizados.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php"){echo "active";}?>">
                <i class="fas fa-exchange-alt"></i><br>Movimientos realizados
            </a>
        </div>
        <div class="col-xl"></div>
    </div>

</div>

<?php
 require_once '../src/footer.php'
?>