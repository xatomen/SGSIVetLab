<?php 
// Conexión a la BD
// require_once '../config/database.php';
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

session_start();
if(empty($_SESSION['ID'])){
    header('location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGSI Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body{
            background-color: #80BFFF;
        }
        
    </style>
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
                        <a href="../user.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user.php"){echo "active";}?>">
                        Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../user/utilizar_stock.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user/utilizar_stock.php"){echo "active";}?>">
                        Utilizar stock
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../user/perfiles_muestra.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user/perfiles_muestra.php"){echo "active";}?>">
                        Perfiles de muestra
                        </a>
                    </li>

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
