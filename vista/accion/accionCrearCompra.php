<?php
include_once '../../configuracion.php';
// include_once '../estructura/cabeceraSegura.php';
$sesion=new session();
$objUsuario = $sesion->getObjUsuario();
$datos=data_submitted();
$listaCarrito = $sesion->getCarrito();
$objabmCompraItem=new abmCompra();
// print_r($datos);
$llenarCarrito=$objabmCompraItem->agregarCompra($listaCarrito, $objUsuario);
if($llenarCarrito){
   $sesion->setColeccionItems($coleccionItems=[]);
}else{
    echo "aguante satanas";
}
?>