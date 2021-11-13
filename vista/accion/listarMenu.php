<?php
include_once '../../configuracion.php';

$data = data_submitted();

$objControl = new abmMenu();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idMenu'] = $elem->getIdMenu();
    $nuevoElem["menuNombre"]=$elem->getMenuNombre();
    $nuevoElem["menuDescripcion"]=$elem->getMenuDescripcion();
    $nuevoElem["idPadre"]=$elem->getObjPadre();
    if($elem->getObjMenu()!=null){
        $nuevoElem["idpadre"]=$elem->getObjPadre()->getMenuNombre();
    }
    $nuevoElem["menuDeshabilitado"]=$elem->getMedeshabilitado();
   
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida,null,2);

?>