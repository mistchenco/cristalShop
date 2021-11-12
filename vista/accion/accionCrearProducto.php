<?php
include_once '../../configuracion.php';

$sesion = new session(); 
if ($sesion->activa()) {
    include_once '../estructura/cabeceraSegura.php'; 
}else{
    include_once '../estructura/cabecera.php'; 
}
?>

<?php
    $datos = data_submitted();
    $abmProducto = new abmProducto();

    $busquedaNombreProducto = ['productoNombre' => $datos['productoNombre']];
    $respuesta1 = $abmProducto->buscar($busquedaNombreProducto);

    if (count($respuesta1) > 0) {
        echo  "El Producto no se ha podido crear porque ya existe ese nombre de producto.";
        $mensaje = "El Producto no se ha podido crear porque ya existe ese nombre de producto.";
        header("Location: ../ejercicios/crearProducto.php?Message=" . urlencode($mensaje));
    }else{

        $producto = $abmProducto->alta($datos);
        // $busqueda = [
        //     "productoNombre" => $datos['productoNombre']
        // ];
        // $objProducto = $abmProducto->buscar($busqueda);
        // $idProductoImagen = md5($objProducto[0]->getIdUsuario());
        
        if ($producto) {
            $mensaje = "El producto se creó con exito, Revise su casilla";
            header("Location: ../ejercicios/mostrarProductos.php?Message=" . urlencode($mensaje));
        }
    }

?>




<?php
include_once '../estructura/footer.php';
?>