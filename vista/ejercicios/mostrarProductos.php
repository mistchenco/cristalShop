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
include_once '../estructura/footer.php';
?>