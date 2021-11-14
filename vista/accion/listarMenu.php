<?php
include_once '../../configuracion.php';

$data = data_submitted();

$objControl = new abmMenu();
$listaMenu = $objControl->buscar($data);
$arreglo_salida =  array();

foreach ($listaMenu as $objMenu ){
    
    $nuevoElem['idMenu'] = $objMenu->getIdMenu();
    $nuevoElem["menuNombre"]=$objMenu->getMenuNombre();
    $nuevoElem["menuDescripcion"]=$objMenu->getMenuDescripcion();
    $nuevoElem["idPadre"]=$objMenu->getObjPadre();
    if($objMenu->getObjPadre()!=null){
        $nuevoElem["idPadre"]=$objMenu->getObjPadre()->getMenuNombre();
    }
    $nuevoElem["menuDeshabilitado"]=$objMenu->getMenuDeshabilitado();
   
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);

echo json_encode($arreglo_salida,null,2);

?>