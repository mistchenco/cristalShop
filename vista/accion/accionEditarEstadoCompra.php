<?php
include_once '../../configuracion.php';

$datos = data_submitted();
// echo 'DATOS DE ESTADO COMPRA';
// print_r($datos);
$abmCompraEstado = new abmCompraEstado();
$listaCompraEstado = $abmCompraEstado->buscar(['idCompraEstado' => $datos['idCompraEstado'] ]);
$objCompraEstado = $listaCompraEstado[0];
// echo 'LISTA COMPRA ESTADO DE COMPRA';
// print_r($listaCompraEstado);



if ($datos['idCompraEstadoTipo'] == 4 || $datos['idCompraEstadoTipo'] == 3) {
    $fechaFinal = date('Y-m-d h:i:s', time());
}else{
    $fechaFinal = '0000-00-00 00:00:00';
}


$datosNuevos = [
    'idCompraEstado' => $datos['idCompraEstado'], 
    'idCompra' => $datos['idCompra'],
    'idCompraEstadoTipo' => $datos['idCompraEstadoTipo'],
    'compraEstadoFechaInicial' => $objCompraEstado->getCompraEstadoFechaInicial(),
    'compraEstadoFechaFinal' => $fechaFinal
]; 

if($abmCompraEstado->modificacion($datosNuevos)){
  
    $mensaje = "Estado de la compra modificado con exito!";
    header("Location: ../ejercicios/editarEstadoCompra.php?Message=" . urlencode($mensaje));
}else{
    $mensaje = "El estado de la compra no se modifico, contacte al administrador!";
    header("Location: ../ejercicios/editarEstadoCompra.php?Message=" . urlencode($mensaje));
}


?>