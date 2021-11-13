<?php
include_once '../../configuracion.php';
$datos = data_submitted();
$abmProducto=new abmProducto();

$listaProducto=$abmProducto->buscar($datos);

$objProducto=$listaProducto[0];
$datos['idProducto']=$objProducto->getIdProducto();
$datos['productoNombre']=$objProducto->getProductoNombre();
$datos['productoDetalle']=$objProducto->getProductoDetalle();
$datos['productoPrecio']=$objProducto->getProductoPrecio();
$datos['productoStock']=$objProducto->getProductoStock();
 
$exito=$abmProducto->baja($datos);
if($exito){
    $mensaje = "El producto se creó con exito";
    header("Location: ../ejercicios/listarProductos.php?Message=" . urlencode($mensaje));
}else{
    echo"no se borro";
}
