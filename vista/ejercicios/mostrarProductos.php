<?php
    include_once '../../configuracion.php';

$sesion = new session(); 
if ($sesion->activa()) {
    include_once '../estructura/cabeceraSegura.php'; 
}else{
    include_once '../estructura/cabecera.php'; 
}
?>

        <div class="container-xl mt-5 pt-5">
	        <div class="row">
		        <div class="col-md-12">
                    <?php
                        $abmProducto = new abmProducto();
                        $param = [];
                        $colObjProductos = $abmProducto->buscar(); 
                        // print_r($colObjProductos);
                        
                        // print_r($arregloArchivos);
                        for($i=0 ; count($colObjProductos)>$i; $i++) {
                            if ($colObjProductos[$i]->getProductoStock() == 0 ) {
                                continue;

                            }
                            $arregloArchivos=$abmProducto->obtenerArchivos(md5($colObjProductos[$i]->getIdProducto()));
                           
                    ?>
                   
                        <div class="col-sm-3">
							<div class="thumb-wrapper">
								<div class="img-box">
                                    
									<?php
                                   
                                     echo "<img src='$arregloArchivos' class='img-fluid' alt='productos'>";
								?>
                                </div>
								<div class="thumb-content">
                                        <?php 
                                            echo "<h2>{$colObjProductos[$i]->getProductoNombre()}</h2>";
                                            echo "<h6>{$colObjProductos[$i]->getProductoDetalle()}</h6>";
                                        ?>								
									<p class="item-price">
                                    <b>
                                        <?php 
                                            echo "<p>Precio $ {$colObjProductos[$i]->getProductoPrecio()}</p>";
                                            echo "<p>Stock: {$colObjProductos[$i]->getProductoStock()}</p>";
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