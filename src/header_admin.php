<?php 
// Conexión a la BD
// require_once '../config/database.php';
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

// session_start();

// echo $_SESSION['Usuario'];

// session_start();
// if(empty($_SESSION['ID'])){
    // header('location: ../index.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGSI Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Incluye los archivos de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluye los archivos de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!-- Incluye los archivos de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    
    <!-- Incluye los archivos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Estilos generados de manera manual -->
    <link rel="stylesheet" type="text/css" href="../src/styles.css">

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </script>
</head>
<body>
<!-- 2f3e46 -->
<!--  -->
<div class="row m-2">
        <div class="col-lg-2 col-12">
            <div class="card m-1 p-3 text-white" style="background-color: #2f3e46">
                <span class="fs-4 text-center">SGSI - VetLab</span>
                <img src="http://localhost/SGSIVetLab/src/VetLab.png" alt="">
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin.php"){echo "active";}?>">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/listado_metricas.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_metricas.php"){echo "active";}?>">
                            <i class="fas fa-chart-line"></i>   Listado de métricas
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/listado_insumos.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_insumos.php"){echo "active";}?>">
                            <i class="fas fa-list"></i> Listado de insumos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php"){echo "active";}?>">
                            <i class="fas fa-upload"></i>   Cargar insumos
                        </a>
                    </li>
                    <li>
                        <a href="http://localhost/SGSIVetLab/public/admin/mantener_insumos.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_insumos.php"){echo "active";}?>">
                            <i class="fas fa-boxes"></i>    Gestionar insumos
                        </a>
                    </li>
                    
                    <li>
                        <a href="http://localhost/SGSIVetLab/public/admin/mantener_perfiles_muestra.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_perfiles_muestra.php"){echo "active";}?>">
                            <i class="fas fa-vials"></i>    Gestionar perfiles de muestra
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a href="http://localhost/SGSIVetLab/public/admin/mantener_proveedores.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/mantener_proveedores.php"){echo "active";}?>">
                            <i class="fas fa-truck"></i>    Gestionar proveedores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php"){echo "active";}?>">
                            <i class="fas fa-file-alt"></i> Crear órdenes de compra
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/imprimir_etiquetas.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/imprimir_etiquetas.php"){echo "active";}?>">
                            <i class="fas fa-print"></i>    Imprimir etiquetas
                        </a>
                    </li> -->
                    
                    <hr>
                    
                    <!-- <li class="nav-item"> -->
                        <!-- <a href="../admin/gestionar_administradores.php" class="nav-link text-white <?php //if($url=="http://localhost/SGSIVetLab/public/admin/gestionar_administradores.php"){echo "active";}?>"> -->
                        <!-- Gestionar perfiles de administradores -->
                        <!-- </a> -->
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php"){echo "active";}?>">
                            <i class="fas fa-user"></i> Gestionar perfiles de usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php"){echo "active";}?>">
                            <i class="fas fa-list-alt"></i> Mostrar registros
                        </a>
                    </li>
                    
                </ul>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/src/controlador_sesion.php" class="nav-link text-white cerrar-sesion">
                            <i class="fas fa-door-open"></i> Cerrar sesión y salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>

<!--  -->

<div class="col-md col-12">
    <div class="card m-1 p-3" style="height:100%; height:95vh; background-color: #f9f9f9;">
