<?php
include_once '../../configuracion.php';
 include_once '../estructura/cabeceraSegura.php';

    $datos = data_submitted();
    $arreglo = $sesion->getCarrito();

    for ($i=0; $i < count($arreglo); $i++) { 
        if ($datos['idProducto'] == $arreglo[$i]['idProducto'] ) {
            unset($arreglo[$i]);
            $arreglo = array_values($arreglo);
            $sesion->setColeccionItems($arreglo);
        }
    }

include_once '../estructura/footer.php';
?>