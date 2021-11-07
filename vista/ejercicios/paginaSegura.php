<?php
include_once '../../configuracion.php';
$sesion = new session();
$datos = data_submitted();
$sesion->validar([""$datos]);
$objUsuario = $sesion->getObjUsuario();
print_r($objUsuario);

if (!$sesion->activa()) {
    echo "no hay sesion activa";
    header('Location: login.php');
}else{
    
    // include_once '../estructura/cabecera.php';
}

print_r($objUsuario);



echo "<h4>Usted esta Logueado como: {$objUsuario->getUsNombre()}</h4>";

echo '<form action="../accion/cerrarSesion.php">
<button  type="submit" class="btn btn-danger fas fa-sign-out-alt">
<span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión
</button>
<br><br>
</form>';

include_once '../estructura/footer.php';
?>