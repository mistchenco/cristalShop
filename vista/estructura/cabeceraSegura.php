<?php

$sesion = new session();
include_once '../../configuracion.php';
if (!$sesion->activa()) {
    header('location:../ejercicios/login.php');
}else{
    $objUsuario = $sesion->getObjUsuario();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cristal Shop - Compra de Cristales - Cactus y Mas</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/styles.css" rel="stylesheet" />
</head>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top"><img src="../assets/img/logos/logo.png" alt="..." /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Navegacion
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="#proximosEventos">Proximos Eventos</a></li>
                        <li><a class="dropdown-item" href="#quienesSomos">¿Quienes Somos?</a></li>
                        <li><a class="dropdown-item" href="#contact">Contacto</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/crearProducto.php">Crear Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="#productos">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/listarUsuarios.php">Usuarios</a></li>
            </ul>
        </div>
                <?php
                    echo "<ul class='navbar-nav pull-xs-right'> <a class='nav-link'>Hola {$objUsuario->getUsNombre()}</a></ul>"
                ?>
        <a href="../accion/cerrarSesion.php" class="nav-item btn btn-danger"> <i class="fas fa-sign-in-alt"></i>Log Out </a>
        
    </div>
</nav>

<body id="page-top">