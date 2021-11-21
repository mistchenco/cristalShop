<?php
include_once '../../configuracion.php';
 include_once '../estructura/cabeceraSegura.php';

$objUsuario=$sesion->getObjUsuario();
$idUsuario=$objUsuario->getIdUsuario();
$abmCompra=new abmCompra();
$datos=['idUsuario'=>$idUsuario];
// print_r($datos);
//Buscamos las compras del usuario Logueado
$listaCompras=$abmCompra->buscar($datos);


?>
<div class="container" style="margin-top: 100px;">
  <h1>El historial de compras en nuestra tienda!</h1>
  <h4>Podras seguir el proceso de tu compra</h4>
  <h4>Recorda que podes cancelar la compra mientras su estado sea iniciada</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" class="text-center">Compra N°</th>
        <th scope="col" class="text-center">Fecha de Inicio</th>
        <th scope="col" class="text-center"> Estado de la compra</th>
        <th scope="col" class="text-center">Cancelar Compra</th>
      
      </tr>
    </thead>


<?php
//Por cada Compra Buscamos en compra estado sus compras
foreach($listaCompras as $objCompra){
$idCompra=$objCompra->getIdCompra();
$datos=['idCompra'=>$idCompra];
$abmCompraEstado=new abmCompraEstado();
$listaComprasEstado=$abmCompraEstado->buscar($datos);

//mostramos el id de la tabla compra, el estado y la fecha de inicio de la compra
foreach($listaComprasEstado as $objCompraEstado){
    $idCompraEstado=$objCompraEstado->getIdCompraEstado();
    $listaCompraEstadoTipo=$objCompraEstado->getObjCompraEstadoTipo();
    $objCompraEstadoTipo=$listaCompraEstadoTipo;
    echo '<tr><td class="text-center" style="width:200px;">' . $idCompra . '</td>';
    echo '<td class=" text-center" style="width:200px;">' . $objCompraEstadoTipo->getCompraEstadoTipoDescripcion() . '</td>';    
    echo '<td class="text-center" style="width:200px;">' . $objCompraEstado->getCompraEstadoFechaInicial() . '</td>';
     if($objCompraEstadoTipo->getCompraEstadoTipoDescripcion()=="iniciada"){
       echo " <form action='../ejercicios/editarEstadoCompra.php' method='post'>
        <td class='text-center'>
        <input name='idUsuario' id='idUsuario' type='hidden' value='$idCompraEstado'>
        <button class=' btn btn-dark' type='submit'>
        <i class='fas fa-ban'></i></i></button></td></form></tr>";
     }   
        
       
}
}
?>

</div>
</table>

<?php
include_once '../estructura/footer.php';
?>