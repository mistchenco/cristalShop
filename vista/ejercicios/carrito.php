<?php
//primero crear la compra recorremos el 
//arreglo carrito por cada posicion creo una compraitem 
//y armo la coleccion correspondiente a compra y se inicializa el estado de la compra
include_once '../../configuracion.php';
error_reporting(E_ERROR  | E_PARSE);
$sesion = new session();
$datos = data_submitted();
if (!$sesion->activa()) {
    header('Location: index.php');
} else {
    include_once '../estructura/cabeceraSegura.php';
}

$listaCarrito = $sesion->getCarrito();
// print_r($listaCarrito);
?>
<div class="container mt-5">
  <h1 style='margin-top: 150px;'>Panel de administracion de Productos</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" class="text-center">Id Producto</th>
        <th scope="col" class="text-center">Nombre del Producto</th>
        <th scope="col" class="text-center"> Descripcion</th>
        <th scope="col" class="text-center">Precio</th>
        <th scope="col" class="text-center">Cantidad a comprar</th>
        <th scope="col" class="text-center">Borrar</th>
      </tr>
    </thead>
    <?php
    if ($listaCarrito == null) {
      echo '<h3> No se encontraron registros </h3>';
    } else{
      $suma=0;
      foreach ($listaCarrito as $carrito) {
            // print_r($carrito);
            $suma+=$carrito['cantidadCompra']*$carrito['productoPrecio'];
            echo '<tr><td class="text-center" style="width:200px;">' . $carrito['idProducto'] . '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['productoNombre']. '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['productoDetalle']. '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['productoPrecio'] . '</td>';
            echo '<td class="text-center" style="width:200px;">' . $carrito['cantidadCompra']. '</td>';
            '</tr>';
           
            echo "<form action='../accion/accionBorrarProductoCarrito.php' method='post'>
            <td class='text-center'>
            <input name='idProducto' id='idProducto' type='hidden' value='{$carrito['idProducto']}'>
            <button class=' btn btn-dark' type='submit'>
            <i class='fas fa-trash-alt'></i></i></button></td></form></tr>";
            
        }
        echo "<tr>
        <td class='text-center' style='width:200px;'>Total</td>
        <td  class='text-center' style='width:200px;'></td>
        <td  class='text-center' style='width:200px;'></td>
        <td  class='text-center' style='width:200px;'>$ {$suma}</td>
        <td  class='text-center' style='width:200px;'></td>
        <td><form action='../accion/accionCrearCompra.php' method='post'>
     
        <button class='btn btn-dark' type='submit'  value='<?php $listaCarrito ?>'>Comprar</button></td>
        </form>
        </tr>";
      
    }

    ?>
    </table>
    <div class="d-flex justify-items-right">
    
    </div>
  </div>


<?php
include_once '../estructura/footer.php';
?>