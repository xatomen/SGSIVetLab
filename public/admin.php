<?php
    require_once '../config/database.php';
    require_once '../src/header_admin.php';
?>

<?php 

$total_empleados = 0;
$sentenciaSQL = $conn->prepare("SELECT COUNT(*) AS total_empleados FROM empleado");
$sentenciaSQL->execute();
$empleado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$total_empleados = $empleado['total_empleados'];

// Consulta para obtener la cantidad de insumos
$sentenciaSQL = $conn->prepare("SELECT SUM(Cantidad) AS total_insumos FROM insumo");
$sentenciaSQL->execute();
$insumos = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$total_insumos = $insumos['total_insumos'];

// Consulta para obtener la cantidad de áreas del laboratorio
$sentenciaSQL = $conn->prepare("SELECT COUNT(*) AS total_areas FROM area");
$sentenciaSQL->execute();
$areas = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$total_areas = $areas['total_areas'];

// Consulta para obtener la cantidad de insumos que están próximas a vencer (menos de 15 días)
$sentenciaSQL = $conn->prepare("SELECT SUM(Cantidad) AS total_insumos FROM registro_insumo WHERE Fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)");
$sentenciaSQL->execute();
$insumos = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$total_insumos_a_vencer = $insumos['total_insumos'];

// Consulta para obtener la cantidad de insumos que estén por debajo del stock crítico
$sentenciaSQL = $conn->prepare("SELECT COUNT(*) AS total_insumos FROM insumo WHERE Cantidad <= Stock_minimo");
$sentenciaSQL->execute();
$insumos = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$total_insumos_criticos = $insumos['total_insumos'];

?>
<!-- Estilos generados de manera manual -->
<link rel="stylesheet" type="text/css" href="http://localhost/SGSIVetLab/src/styles.css">
<style>

</style>

<div class="row justify-content-center p-2">

    <h2 class="titulo">Bienvenido</h2>
    <hr>

    <div class="row m-2">
        <div class="col"></div>
        <div class="col card-custom card-personas">
            <div class="content">
                <div class="icon-number">
                    <i class="fas fa-user"></i>
                    <div class="number"><?php echo $total_empleados; ?></div>
                </div>
                <div class="text">Empleados</div>
            </div>
        </div> 

        <div class="col card-custom card-insumos">
            <div class="content">
                <div class="icon-number">
                    <i class="fas fa-id-card-clip"></i>
                    <div class="number"><?php echo $total_areas; ?></div>
                </div>
                <div class="text">Áreas</div>
            </div>
        </div>

        <div class="col card-custom card-otro">
            <div class="content">
                <div class="icon-number">
                    <i class="fas fa-box"></i>
                    <div class="number"><?php echo $total_insumos; ?></div>
                </div>
                <div class="text">Insumos</div>
            </div>
        </div>

        <div class="col card-custom card-alerta">
            <div class="content">
                <div class="icon-number">
                    <i class="fas fa-triangle-exclamation"></i>
                    <div class="number"><?php echo $total_insumos_a_vencer; ?></div>
                </div>
                <div class="text">Insumos por vencer</div>
            </div>
        </div>

        <div class="col card-custom card-alerta-insumo">
            <div class="content">
                <div class="icon-number">
                    <i class="fas fa-circle-exclamation"></i>
                    <div class="number"><?php echo $total_insumos_criticos; ?></div>
                </div>
                <div class="text">Insumos con bajo stock</div>
            </div>
        </div>

        <div class="col"></div>
    </div>

    <hr>

    
    <div class="row m-2">
        <div class="col-xl"></div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/listado_metricas.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_metricas.php"){echo "active";}?>">
                <i class="fas fa-chart-line"></i><br>Listado de métricas
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/listado_insumos.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_insumos.php"){echo "active";}?>">
                <i class="fas fa-list"></i><br>Listado de insumos
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php"){echo "active";}?>">
                <i class="fas fa-upload"></i><br>Cargar insumos
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
    <div class="row m-2">
        <div class="col-xl"></div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/mantener_insumos.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_insumos.php"){echo "active";}?>">
                <i class="fas fa-boxes"></i><br>Gestionar insumos
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/mantener_perfiles_muestra.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_perfiles_muestra.php"){echo "active";}?>">
                <i class="fas fa-vials"></i><br>Gestionar perfiles de muestra
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/mantener_proveedores.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_proveedores.php"){echo "active";}?>">
                <i class="fas fa-truck"></i><br>Gestionar proveedores
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
    <div class="row m-2">
        <div class="col-xl"></div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php"){echo "active";}?>">
                <i class="fas fa-file-alt"></i><br>Crear órdenes de compra
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php"){echo "active";}?>">
                <i class="fas fa-user"></i><br>Gestionar perfiles de usuario
            </a>
        </div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php"){echo "active";}?>">
                <i class="fas fa-list-alt"></i><br>Mostrar registros
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
    <div class="row m-2">
    <div class="col-xl"></div>
        <div class="col-auto">
            <a href="http://localhost/SGSIVetLab/public/admin/gestionar_areas.php" class="btn m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php"){echo "active";}?>">
                <i class="fas fa-id-card-clip"></i><br>Gestionar áreas
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
</div>

<?php
 require_once '../src/footer.php'
?>