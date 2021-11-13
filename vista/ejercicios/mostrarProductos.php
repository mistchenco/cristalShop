<?php
include_once '../../configuracion.php';

$sesion = new session();
if ($sesion->activa()) {
    include_once '../estructura/cabeceraSegura.php';
} else {
    include_once '../estructura/cabecera.php';
}
?>
<link rel="stylesheet" href="../css/stylesProducto.css">
<div class="container mt-2">
    <section class="py-2">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 m-3 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $abmProducto = new abmProducto();
                $param = [];
                $colObjProductos = $abmProducto->buscar();
                for ($i = 0; count($colObjProductos) > $i; $i++) {
                    if ($colObjProductos[$i]->getProductoStock() == 0) {
                        continue;
                    }
                    $arregloArchivos = $abmProducto->obtenerArchivos(md5($colObjProductos[$i]->getIdProducto()));

                ?>
                    <div class="card " style="width: 18rem;">
                            <?php
                                echo "<img src='$arregloArchivos' style='max-width: 400px; widht:400px; '  class='img-fluid' alt='productos'>";
                            ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                echo "<h2>{$colObjProductos[$i]->getProductoNombre()}</h2>";
                                ?>
                            </h5>
                            <p class="card-text">
                                <?php
                                echo "<h6>{$colObjProductos[$i]->getProductoDetalle()}</h6>";
                                ?>
                            </p>
                            <p class="card-text">
                                <?php
                                echo "<p>Precio $ {$colObjProductos[$i]->getProductoPrecio()}</p>";
                                echo "<p>Stock: {$colObjProductos[$i]->getProductoStock()}</p>";
                                ?>
                            </p>
                            <a href="#" class="btn btn-primary">Añadir al carrito</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
</div>


<?php
include_once '../estructura/footer.php';
?>