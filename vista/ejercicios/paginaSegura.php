<?php
include_once '../../configuracion.php';
$sesion = new session();
$datos = data_submitted();
$objUsuario = $sesion->getObjUsuario();
if (!$sesion->activa()) {
    echo "no hay sesion activa";
    header('Location: login.php');
}else{
    
    include_once '../estructura/cabeceraSegura.php';
}

echo "<h4>Usted esta Logueado como: {$objUsuario->getUsNombre()}</h4>";



include_once '../estructura/footer.php';
?>