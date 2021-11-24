<?php
include_once '../../configuracion.php';
//  include_once '../estructura/cabeceraSegura.php';
 $sesion=new session();
$objUsuario = $sesion->getObjUsuario();
$datos=data_submitted();
$listaCarrito = $sesion->getCarrito();
$objabmCompraItem=new abmCompra();
// print_r($datos);
$llenarCarrito=$objabmCompraItem->altaCompra($listaCarrito, $objUsuario);
if($llenarCarrito){
   $sesion->setColeccionItems($coleccionItems = []);
   $mensaje = "Su compra fue realizada con exito, muchas gracias!";
header("Location: ../ejercicios/comprasUsuario.php?Message=" . urlencode($mensaje));
}else{
    echo "Su compra no pudo ser realizada, disculpe las molestias";
}
?>