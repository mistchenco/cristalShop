<?php
include_once '../../configuracion.php';
    
    $sesion= new session();
    $datos = data_submitted();
    $sesion->accionBorrarProductoCarrito($datos);

include_once '../estructura/footer.php';
?>