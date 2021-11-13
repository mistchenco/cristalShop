<?php
    include_once '../../configuracion.php';
<<<<<<< HEAD

$sesion = new session(); 
if ($sesion->activa()) {
    include_once '../estructura/cabeceraSegura.php'; 
}else{
    include_once '../estructura/cabecera.php'; 
}
=======
    $sesion = new session(); 
    if ($sesion->activa()) {
        // include_once '../estructura/cabeceraSegura.php'; 
    }else{
        // include_once '../estructura/cabecera.php'; 
    }
>>>>>>> db999b502ca30f5ca8f84b714b31af6552a7c83c
?>

        <div class="container-xl mt-5 pt-5">
	        <div class="row">
		        <div class="col-md-12">
                    <?php
                        $abmProducto = new abmProducto();
                        $param = [];
                        $colObjProductos = $abmProducto->buscar(); 
                        // print_r($colObjProductos);
                        foreach ($colObjProductos as $objProducto) {
                            if ($objProducto->getProductoStock() == 0 ) {
                                continue;
                            }
                    ?>
                   
                        <div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
									<img src="/examples/images/products/macbook-air.jpg" class="img-fluid" alt="Macbook">
								</div>
								<div class="thumb-content">
                                        <?php 
                                            echo "<h2>{$objProducto->getProductoNombre()}</h2>";
                                        ?>								
									<p class="item-price">
                                    <b>
                                        <?php 
                                            echo 'Precio: ' . $objProducto->getProductoPrecio();
                                        ?>
                                    </b></p>
									<a href="#" class="btn btn-primary">Añadir al carrito</a>
								</div>						
							</div>
						</div>
                    <?php } ?>
                </div>
            </div>
        </div>


<?php
    include_once '../estructura/footer.php';
?>