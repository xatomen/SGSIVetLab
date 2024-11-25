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
}

.btn-fixed-size i {
    font-size: 3em; /* Ajusta el tamaño según tus necesidades */
    margin-bottom: 10px; /* Espacio entre el ícono y el texto */
}
</style>


<div class="row">
    <h4>Bienvenido</h4>
    <hr>
    <div class="row justify-content-center">
        <div class="col-xl"></div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/listado_metricas.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_metricas.php"){echo "active";}?>">
                <i class="fas fa-chart-line"></i><br>Listado de métricas
            </a>
        </div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/listado_insumos.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_insumos.php"){echo "active";}?>">
                <i class="fas fa-list"></i><br>Listado de insumos
            </a>
        </div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php"){echo "active";}?>">
                <i class="fas fa-upload"></i><br>Cargar insumos
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
    <div class="row">
        <div class="col-xl"></div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/mantener_insumos.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_insumos.php"){echo "active";}?>">
                <i class="fas fa-boxes"></i><br>Gestionar insumos
            </a>
        </div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/mantener_perfiles_muestra.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_perfiles_muestra.php"){echo "active";}?>">
                <i class="fas fa-vials"></i><br>Gestionar perfiles de muestra
            </a>
        </div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/mantener_proveedores.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_proveedores.php"){echo "active";}?>">
                <i class="fas fa-truck"></i><br>Gestionar proveedores
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
    <div class="row">
        <div class="col-xl"></div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php"){echo "active";}?>">
                <i class="fas fa-file-alt"></i><br>Crear órdenes de compra
            </a>
        </div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php"){echo "active";}?>">
                <i class="fas fa-user"></i><br>Gestionar perfiles de usuario
            </a>
        </div>
        <div class="col">
            <a href="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php" class="btn btn-primary m-1 btn-fixed-size <?php if($url=="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php"){echo "active";}?>">
                <i class="fas fa-list-alt"></i><br>Mostrar registros
            </a>
        </div>
        <div class="col-xl"></div>
    </div>
</div>

<?php
 require_once '../src/footer.php'
?>