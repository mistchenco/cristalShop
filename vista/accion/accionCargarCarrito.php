<?php
include_once '../../configuracion.php';
//  include_once '../estructura/cabeceraSegura.php';
    $sesion = new session();
    $datos = data_submitted();
    // print_r($datos);
    $arreglo = $sesion->agregarColeccionItems($datos);
    print_r($arreglo);
    if( $arreglo != null){
        header("Location: ../ejercicios/carrito.php");
    }else{
        echo 'error en accion cargar carrito';
    }

include_once '../estructura/footer.php';
?>