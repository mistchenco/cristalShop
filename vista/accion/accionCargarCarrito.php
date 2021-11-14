<?php
include_once '../../configuracion.php';
//  include_once '../estructura/cabeceraSegura.php';
   $sesion=new session();
    $datos = data_submitted();
    echo "datoooos";
    print_r($datos);
    echo "</br>";
    $arreglo=$sesion->getColeccionItems($datos);
//   print_r($arreglo);
include_once '../estructura/footer.php';
?>