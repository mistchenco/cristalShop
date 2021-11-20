<?php
include_once '../../configuracion.php';
// include_once '../estructura/cabeceraSegura.php';
$datos = data_submitted();
$abmCompraEstado = new abmCompraEstado();
$abmProducto = new abmProducto();

//Obj compra estado
$listaCompraEstado = $abmCompraEstado->buscar($datos);
$objCompraEstado = $listaCompraEstado[0];

//Obj Compra 
$objCompra = $objCompraEstado->getObjCompra();

//Obj compra estado tipo
$objCompraEstadoTipo = $objCompraEstado->getObjCompraEstadoTipo();

//Obj Compra item
$busquedaCompraItem = [
    "idCompra" => $objCompra->getIdCompra()
];
$abmCompraItem = new abmCompraItem();
$listaCompraItem = $abmCompraItem->buscar($busquedaCompraItem);

//producto
$coleccionProductos = [];
foreach ($listaCompraItem as $producto) {
    $idProducto = $producto->getObjProducto();
    $busqueda = [
        'idProducto' => $idProducto
    ];
    $nuevoProducto = $abmProducto->buscar($busqueda);
    array_push($coleccionProductos, $nuevoProducto[0]);
}

print_r($coleccionProductos);





?>
