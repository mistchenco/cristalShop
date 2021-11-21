<?php
include_once '../../configuracion.php';
// include_once '../estructura/cabeceraSegura.php';
$datos=data_submitted();
//desde los datos recibido buscamos el obj CompraEstado,
// obtenemos sus objetos y los datos necesarios para realizar la modificacion

$abmcompraEstado=new abmCompraEstado();
$abmcompraEstadoTipo=new abmCompraEstadoTipo();
$datosCompraEstadoTipo=['idCompraEstadoTipo'=>4];
$listaCompraEstadoTipo=$abmcompraEstadoTipo->buscar($datosCompraEstadoTipo);
$objCompraEstadoTipo=$listaCompraEstadoTipo[0];

$listaCompraEstado=$abmcompraEstado->buscar($datos);
$objCompraEstado=$listaCompraEstado[0];


$objCompra=$objCompraEstado->getObjCompra();
$idCompraEstado=$objCompraEstado->getIdCompraEstado();
$fechaInicio=$objCompraEstado->getCompraEstadoFechaInicial();
$idCompra=$objCompra->getIdCompra();

$idCompraEstadoTipo=$objCompraEstadoTipo->getIdCompraEstadoTipo();
$datosCompraEstado=['idCompraEstado'=>$idCompraEstado,
'idCompra'=>$idCompra,
'idCompraEstadoTipo'=>$idCompraEstadoTipo,
'compraEstadoFechaInicial'=>$fechaInicio,
'compraEstadoFechaFinal'=>date('Y-m-d h-m-s')
];

if($abmcompraEstado->modificacion($datosCompraEstado)){
    $mensaje = "Compra cancelada con exito";
    header("Location: ../ejercicios/comprasUsuario.php?Message=" . urlencode($mensaje));

}else{
    $mensaje = "La compra no se pudo cancelar";
    header("Location: ../ejercicios/comprasUsuario.php?Message=" . urlencode($mensaje));
}