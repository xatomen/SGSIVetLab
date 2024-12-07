<?php 
ob_start(); // Inicia el buffer de salida
// Conexión a la BD
// require_once '../config/database.php';
$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

session_start();

// echo $_SESSION['Usuario'];
// echo $_SESSION['ID'];

// Encontrar el nombre del usuario
$sentenciaSQL = $conn->prepare("SELECT Nombre FROM empleado WHERE ID_Credenciales = :ID_Credenciales");
$sentenciaSQL->bindParam(':ID_Credenciales', $_SESSION['ID']);
$sentenciaSQL->execute();
$empleado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$nombreUsuario = $empleado['Nombre'];


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
    <link rel="stylesheet" type="text/css" href="http://localhost/SGSIVetLab/src/styles.css">

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </script>
</head>
<body>

<!--  -->

<div class="row m-2">
        <div class="col-lg-2 col-12">
            <div class="card m-1 p-3 text-white" style="background-color: #2f3e46">
                <span class="fs-4 text-center">SGSI - VetLab</span>
                <img src="http://localhost/SGSIVetLab/src/VetLab.png" alt="">
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <i class="fas fa-user"></i> <?php echo $nombreUsuario; ?>
                        </span>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/user.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user.php"){echo "active";}?>">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/user/utilizar_stock.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user/utilizar_stock.php"){echo "active";}?>">
                            <i class="fas fa-box"></i>  Utilizar stock
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/public/user/perfiles_muestra.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user/perfiles_muestra.php"){echo "active";}?>">
                            <i class="fas fa-vial"></i> Perfiles de muestra
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="http://localhost/SGSIVetLab/public/user/movimientos_realizados.php" class="nav-link text-white <?php if($url=="http://localhost/SGSIVetLab/public/user/movimientos_realizados.php"){echo "active";}?>">
                        <i class="fas fa-exchange-alt"></i> Movimientos realizados
                        </a>
                    </li>

                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="http://localhost/SGSIVetLab/src/controlador_sesion.php" class="nav-link text-white cerrar-sesion">
                            <i class="fas fa-door-open"></i>    Cerrar sesión y salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>

<!--  -->
  
<div class="col-md col-12">
    <div class="card m-1 p-3">
