<?php
include_once '../../configuracion.php';
$sesion = new session();
$datos = data_submitted();
$objUsuario = $sesion->getObjUsuario();
$objRolActivo = $sesion->getRolActivo();
if (!$sesion->activa()) {
    echo "no hay sesion activa";
    header('Location: login.php');
}else{
    
    include_once '../estructura/cabeceraSegura.php';
}
echo "</br></br></br></br></br></br>";
echo "<h4>Usted esta Logueado como: {$objUsuario->getUsNombre()} con el Rol: {$sesion->getRolActivo()->getRolDescripcion()}</h4>";


?>
<?php

include_once '../estructura/footer.php';
?>