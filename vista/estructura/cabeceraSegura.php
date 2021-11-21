<?php

$sesion = new session();

include_once '../../configuracion.php';
if (!$sesion->activa()) {
    header('location:../ejercicios/login.php');
} else {
    $objUsuario = $sesion->getObjUsuario();
    $menu = new AbmMenu();
    $arregloMenu = $menu->buscar("");
    
    
    $rolActivo=$sesion->getRolActivo();
  
  
    if ($rolActivo==null) {
       echo "entro al if";
       $listaRoles = $sesion->getColeccionRol();
       
         $objRol = $listaRoles[0];
         print_r($objRol);
        
         $sesion->setRolActivo($objRol);
    }
   
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

    <link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/themes/color.css">
    <link rel="stylesheet" type="text/css" href="../js/jquery-easyui-1.6.6/demo/demo.css">
    <script type="text/javascript" src="../js/jquery-easyui-1.6.6/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery-easyui-1.6.6/jquery.easyui.min.js"></script>
</head>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="../home/index.php#page-top"><img src="../assets/img/logos/logo.png" alt="..." /></a>
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
                        <li><a class="dropdown-item" href="../home/index.php#proximoseventos">Proximos Eventos</a></li>
                        <li><a class="dropdown-item" href="../home/index.php#quienesSomos">¿Quienes Somos?</a></li>
                        <li><a class="dropdown-item" href="../home/index.php#contact">Contacto</a></li>
                    </ul>
                </li>
              
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Productos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="../ejercicios/mostrarProductos.php">Ver nuestros Productos</a></li>
                        <li><a class="dropdown-item" href="../ejercicios/crearProducto.php">Cargar Productos</a></li>
                        <li><a class="dropdown-item" href="../ejercicios/listarProductos.php">Administrar Productos</a></li>
                        <li><a class="dropdown-item" href="../ejercicios/administrarCompras.php">Administrar Compras</a></li>
                        <?php
                        for ($i = 0; $i < (count($arregloMenu)); $i++) {
                        ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo $arregloMenu[$i]->getMedescripcion(); ?>"><?php echo $arregloMenu[$i]->getMenombre(); ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/carrito.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/administrarCompras.php">Administrar Compras</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/comprasUsuario.php">Mis Compras</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/listarUsuarios.php">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/editarMenu.php">Menu</a></li>
                

        
        
        <!-- cortamos linea 103 lo anterior -->

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class=" fas fa-user-cog"></i>Cambiar Rol
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
        
               <?php
               $listaRoles = $sesion->getColeccionRol();
               $span="";
               foreach($listaRoles as $rol){
                $idRol=$rol->getIdRol();
                $span = "<li class='dropdown-item'>{$rol->getRolDescripcion()}<span class='fas fa-users'></span></li>";
                echo "<a class='nav-link' href='../accion/accionseleccionarRol.php?idRol=$idRol'>{$span}</a>";  
                }

               ?> 
           </ul>
        
        </li>

        <?php
        echo "<li class='navbar-nav pull-xl-right'> <a class='nav-link' href='../ejercicios/cambiarDatosUsuario.php' >Usuario: {$objUsuario->getUsNombre()}</br>{$sesion->getRolActivo()->getRolDescripcion()} </a></li>";
        // echo "<li class='navbar-nav pull-xl-right'> <a class='nav-link'>Rol: </a></li>";
        ?>
        
    </div>
    </ul>
        </ul>
        <a href="../accion/cerrarSesion.php" class="nav-item btn btn-danger"> <i class="fas fa-sign-in-alt"></i>Log Out </a>
    </div>
</nav>

<body id="page-top">