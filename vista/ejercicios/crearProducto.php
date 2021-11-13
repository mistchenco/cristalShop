<?php
include_once '../../configuracion.php';

$sesion = new session();
if ($sesion->activa()) {
    include_once '../estructura/cabeceraSegura.php';
} else {
    header('Location: ../home/index.php');
}

?>

<div class="container mt-5">
    <div class="card card-info">
        <form class="" action='../accion/accionCrearProducto.php' novalidate id="formularioCrearProducto" name="formularioCrearProducto" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre Producto</label>
                <input class='form-control' id='productoNombre' name='productoNombre' type='text' placeholder='Nombre Producto' required>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Detalle Producto</label>
                <input type='email' class='form-control' id='productoDetalle' name='productoDetalle' placeholder='Detalle del producto' required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Stock</label>
                <input class='form-control' id='productoStock' name='productoStock' type='number' placeholder='Stock Producto' value='' required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Precio</label>
                <input class='form-control' id='productoPrecio' name='productoPrecio' type='number' placeholder='Precio Producto' value='' required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Imagen</label>
                <input class='form-control' id='productoImagen' name='productoImagen' type='file' accept="image/png, .jpeg, .jpg, image/gif"  placeholder='Precio Producto' value='' required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div id="validaciones"></div>
    </div>
</div>


<?php
include_once '../estructura/footer.php';
?>