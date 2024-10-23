<?php 

// Conexión a la BD
// require_once '../config/database.php';

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

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../public/admin.php">SGSI - VetLab</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../public/admin/cargar_insumos.php">Cargar Insumos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/admin/crear_orden_compra.php">Crear órden de compra</a>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Mantener
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="../public/admin/mantener_insumos.php">Mantener insumos</a></li>
                        <li><a class="dropdown-item" href="../public/admin/mantener_proveedores.php">Mantener proveedores</a></li>
                        <li><a class="dropdown-item" href="../public/admin/mantener_perfiles_muestra.php">Mantener perfiles de muestra</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/admin/listado_insumos.php">Listado de insumos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/admin/listado_metricas.php">Listado de métricas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/admin/gestionar_usuarios.php">Gestionar perfiles de usuario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/admin/mostrar_registros.php">Mostrar registros</a>
                </li>
            </ul>
        </div>
  
    </div>
</nav>
<div>