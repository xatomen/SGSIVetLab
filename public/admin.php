<?php
    require_once '../config/database.php';
    require_once '../src/header_admin.php';
?>
<style>
.btn-fixed-size {
    width: 200px; /* Ajusta el tamaño según tus necesidades */
    height: 200px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 5px; /* Ajusta el margen según tus necesidades */
    background-color: #2f95a3;
    color: white;
}

.btn-fixed-size i {
    font-size: 3em; /* Ajusta el tamaño según tus necesidades */
    margin-bottom: 10px; /* Espacio entre el ícono y el texto */
}

.btn-fixed-size:hover {
    /* background-color: #2f95a3; */
    /* background-color: #45c9dc; */
    background-color: #36b3c4;
    color: white;
}
</style>


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


?>

<style>
.card-personas {
    /* background-color: #a39a2f; */
    /* background-color: #f7cb73; */
    background-color: #e9c46a;
}
.card-insumos {
    /* background-color: #a32f2f; */
    /* background-color: #982fa3; */
    /* background-color: tomato; */
    background-color: #7fb77e;
}

.card-otro {
    background-color: #5dade2;
}

.card-alerta {
    background-color: #f28a8a;
}

.card-custom {
    display: flex;
    align-items: center;
    justify-content: center; /* Centra horizontalmente */
    /* background-color: #2f95a3; */
    color: white;
    padding: 20px;
    margin: 10px;
    text-align: center; /* Centra el texto */
}

.card-custom i {
    font-size: 6em; /* Tamaño grande del ícono */
    margin-right: 20px;
}

.card-custom .content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.card-custom .content .number {
    font-size: 4em; /* Tamaño del número */
    font-weight: bold;
}

.card-custom .content .text {
    font-size: 1.5em; /* Tamaño del texto */
}
</style>
<div class="row justify-content-center p-2">

    <h2 class="titulo">Bienvenido</h2>
    <hr>

    <div class="row m-2">
        <div class="col"></div>
        <div class="col card-custom card-personas">
            <i class="fas fa-user"></i>
            <div class="content">
                <div class="number"><?php echo $total_empleados; ?></div>
                <div class="text">Empleados</div>
            </div>
        </div> 

        <div class="col card-custom card-insumos">
            <i class="fas ¿fa-solid fa-id-card-clip"></i>
            <div class="content">
                <div class="number"><?php echo $total_areas; ?></div>
                <div class="text">Áreas</div>
            </div>
        </div>

        <div class="col card-custom card-otro">
            <i class="fas fa-box"></i>
            <div class="content">
                <div class="number"><?php echo $total_insumos; ?></div>
                <div class="text">Insumos</div>
            </div>
        </div>

        <div class="col card-custom card-alerta">
            <i class="fas fa-solid fa-triangle-exclamation"></i>
            <div class="content">
                <div class="number"><?php echo $total_insumos_a_vencer; ?></div>
                <div class="text">Insumos próximos a vencer</div>
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
</div>

<?php
 require_once '../src/footer.php'
?>