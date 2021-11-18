<?php

$sesion = new session();

include_once '../../configuracion.php';
if (!$sesion->activa()) {
    header('location:../ejercicios/login.php');
}else{
    $objUsuario = $sesion->getObjUsuario();
    $menu = new AbmMenu();
    $arregloMenu = $menu->buscar("");
    $roles = $sesion->getColeccionRol();
    $i = 0;
    $bandera = false;
    do { //hacer un foreach o consultar si realmente es un objeto
        $idRol = $roles[$i]->getIdRol();
        echo 'ID ROL DE CABECERA SEGURA' . $idRol;
        $rolActivo = $sesion->setRolActivo($idRol);
        $bandera = true;
    } while ($bandera == false);
    $objRolActivo = $sesion->getRolActivo();
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
                <!-- <li class="nav-item"><a class="nav-link" href="../ejercicios/crearProducto.php">Crear Productos</a></li>
                <ul class="nav-item"><a class="nav-link" href="../ejercicios/mostrarProductos.php">Productos</a>
                <li><a class="dropdown-item" href="../ejercicios/crearProducto.php">Cargar Productos</a></li>
                <li><a class="dropdown-item" href="">Modificar Productos</a></li>
                <li><a class="dropdown-item" href="">Eliminar Productos</a></li>
                </ul> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Productos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="../ejercicios/mostrarProductos.php">Ver nuestros Productos</a></li>
                        <li><a class="dropdown-item" href="../ejercicios/crearProducto.php">Cargar Productos</a></li>
                        <li><a class="dropdown-item" href="../ejercicios/listarProductos.php">Administrar Productos</a></li>
                    <?php
                        for ($i=0; $i < (count($arregloMenu)); $i++) { 
                    ?>
                        <li>
                            <a class="dropdown-item" href="<?php echo $arregloMenu[$i]->getMedescripcion();?>"><?php echo $arregloMenu[$i]->getMenombre();?></a>
                        </li>
                    <?php
                        }
                    ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/carrito.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/listarUsuarios.php">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="../ejercicios/editarMenu.php">Menu</a></li>
            </ul>
        </div>
                <?php
                    echo "<ul class='navbar-nav pull-xs-right'> <a class='nav-link'>Hola {$objUsuario->getUsNombre()}</a></ul>"
                ?>
                <?php
                    // $roles = $sesion->getColeccionRol();
                    // $rolActivo = $sesion->getRolActivo();
                    $select = ''; 
                    foreach ($roles as $rol) {
                        $select = $select  . "<option>{$rol->getIdRol()}{$rol->getRolDescripcion()}</option>";
                    }
                    echo "<div class='col-md-2'>
                    <form action = '../accion/accionseleccionarol.php' method='post'>
                    <label for='inputState' class='form-label text-light'>Rol</label>
                        <select onclick=id='inputState' class='form-select btn-sm'>
                        <option selected >{$objRolActivo->getRolDescripcion()}</option>
                            $select
                        </select>
                    </form>
                    </div>"
                ?>
        <a href="../accion/cerrarSesion.php" class="nav-item btn btn-danger"> <i class="fas fa-sign-in-alt"></i>Log Out </a>
        
    </div>
</nav>

<body id="page-top">