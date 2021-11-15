<?php
include_once '../../configuracion.php';
 include_once '../estructura/cabeceraSegura.php';

    $datos = data_submitted();
    $arreglo = $sesion->getCarrito();
    $arreglo = array_values($arreglo); 
    for ($i=0; $i < count($arreglo); $i++) { 
        if ($datos['idProducto'] == $arreglo[$i]['idProducto'] ) {
            unset($arreglo[$i]);
            $sesion->setColeccionItems($arreglo);
        }
    }
    $arreglo = array_values($arreglo);

include_once '../estructura/footer.php';
?>