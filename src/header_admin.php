<?php 
// Conexión a la BD
// require_once '../config/database.php';
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGSI Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>

<!--  -->

<div class="row m-2">
        <div class="col-lg-2 col-12">
            <div class="card m-1 p-3 text-bg-dark">
                <span class="fs-4 text-center">SGSI - VetLab</span>
                <img src="http://localhost/SGSIVetLab/src/VetLab.png" alt="">
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="../admin.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin.php"){echo "active";}?>">
                        Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../admin/cargar_insumos.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/cargar_insumos.php"){echo "active";}?>">
                        Cargar insumos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../admin/crear_orden_compra.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/crear_orden_compra.php"){echo "active";}?>">
                        Crear órdenes de compra
                        </a>
                    </li>
                    <div class="dropdown">
                        <a class="nav-link text-decoration-none dropdown-toggle text-white" data-bs-toggle="dropdown" aria-expanded="false">
                        Mantener
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="../admin/mantener_insumos.php">Mantener insumos</a></li>
                            <li><a class="dropdown-item" href="../admin/mantener_proveedores.php">Mantener proveedores</a></li>
                            <li><a class="dropdown-item" href="../admin/mantener_perfiles_muestra.php">Mantener perfiles de muestra</a></li>
                        </ul>
                        </div>
                    <li class="nav-item">
                        <a href="../admin/listado_insumos.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_insumos.php"){echo "active";}?>">
                        Listado de insumos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../admin/listado_metricas.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/listado_metricas.php"){echo "active";}?>">
                        Listado de métricas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../admin/gestionar_usuarios.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/gestionar_usuarios.php"){echo "active";}?>">
                        Gestionar perfiles de usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../admin/mostrar_registros.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/admin/mostrar_registros.php"){echo "active";}?>">
                        Mostrar registros
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white bg-danger">
                        Cerrar sesión y salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>

<!--  -->
  
<div class="col-md col-12">
    <div class="card m-1 p-3">
