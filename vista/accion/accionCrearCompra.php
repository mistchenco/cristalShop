<?php
include_once '../../configuracion.php';
// include_once '../estructura/cabeceraSegura.php';
$sesion=new session();
$objUsuario = $sesion->getObjUsuario();
$datos=data_submitted();
$listaCarrito = $sesion->getCarrito();
$objabmCompraItem=new abmCompra();
// print_r($datos);
$llenarCarrito=$objabmCompraItem->altaCompra($listaCarrito, $objUsuario);
if($llenarCarrito){
   $sesion->setColeccionItems($coleccionItems = []);
//    header("Location: ../ejercicios/comprasUsuario.php");
}else{
    echo "aguante satanas";
}
?>