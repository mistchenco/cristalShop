<?php
include_once '../../configuracion.php';
// include_once '../estructura/cabeceraSegura.php';
$datos = data_submitted();
print_r($datos);
$abmCompraEstado = new abmCompraEstado();
$abmProducto = new abmProducto();

//Obj compra estado
$listaCompraEstado = $abmCompraEstado->buscar($datos);
$objCompraEstado = $listaCompraEstado[0];

echo 'OBJ COMPRA ESTADO';
print_r($objCompraEstado);

//Obj Compra 
$objCompra = $objCompraEstado->getObjCompra();

// print_r($objCompra);

//Obj compra estado tipo
$objCompraEstadoTipo = $objCompraEstado->getObjCompraEstadoTipo();

//Obj Compra item
$listaColeccionItems = $objCompra->getColeccionItems();


echo 'coleccion items';
// print_r($listaColeccionItems);
$busquedaCompraItem = [
    "idCompra" => $objCompra->getIdCompra()
];
$abmCompraItem = new abmCompraItem();
$listaCompraItem = $abmCompraItem->buscar($busquedaCompraItem);

//producto

// print_r($coleccionProductos);

?>

<form action="" method="get">

</form>
