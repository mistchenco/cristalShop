<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new AbmMenu();
$list = $objControl->buscar($data);
$arreglo_salida =  array();
$abmMenuRol = new abmMenuRol;
$listaMenuRol = $abmMenuRol->buscar(null);
foreach ($list as $elem ){
    
    $nuevoElem['idmenu'] = $elem->getIdMenu();
    $nuevoElem["menombre"]=$elem->getMenombre();
    $nuevoElem["medescripcion"]=$elem->getMedescripcion();
    $nuevoElem["idpadre"]=$elem->getObjMenu();
    if($elem->getObjMenu()!=null){
        $nuevoElem["idpadre"]=$elem->getObjMenu()->getMeNombre();
    }
    $nuevoElem["medeshabilitado"]=$elem->getMedeshabilitado();
    $descripcion = "";
          foreach ($listaMenuRol as $menuRol) {
            $idMenuEnRol= $menuRol->getObjMenu()->getIdmenu();
            if($idMenuEnRol == $elem->getIdMenu()){
              $objRol = $menuRol->getObjRol();
              $descripcion = $descripcion .$objRol-> getRolDescripcion(). '</br>';
            }
          }

    $nuevoElem["rol"]=$descripcion;
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida,null,2);

?>