<?php
include_once '../../configuracion.php';
$sesion = new session();
$datos = data_submitted();
if (!$sesion->activa()) {
    header('Location: index.php');
} else {
    include_once '../estructura/cabeceraSegura.php';
}

$listaCarrito=$sesion->obtenerCarrito();
 print_r($listaCarrito);
?>
<div class="container mt-5">
  <h1>Panel de administracion de Productos</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" class="text-center">Id Producto</th>
        <th scope="col" class="text-center">Nombre del Producto</th>
        <th scope="col" class="text-center"> Descripcion</th>
        <th scope="col" class="text-center">Precio</th>
        <th scope="col" class="text-center">Cantidad a comprar</th>
    
      </tr>
    </thead>
    <?php
    if (count($listaCarrito) > 0) {

      foreach ($listaCarrito as $carrito) {
          


            echo '<tr><td class="text-center" style="width:200px;">' . $carrito['idProducto'] . '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['productoNombre']. '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['productoDetalle']. '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['productoPrecio'] . '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['cantidadCompra']. '</td>';
            '</tr>';

          
        // echo "</br> carritoooooooo";
        // print_r($carrito);
        //   foreach($carrito as $car){
        //       echo "</br> caaaaaaaaaaaaaaaaaaaaaaaaaaaaaaar";
        //       print_r($car);
        //  $idProducto=$carrito->getIdProducto();
        
        }
    
    } else {

      echo '<h3> No se encontraron registros </h3>';
    }

    ?>
</div>
</table>