<?php
include_once '../../configuracion.php';
$sesion= new session();
$objUsuario=$sesion->getUsuario();

$datos=data_submitted();
if (!$sesion->activa()) {
    echo "no hay sesion activa";
     header('Location: login.php');
}else{
    
include_once '../estructura/cabecera.php';


}

echo "<h4>Usted esta Logueado como: {$objUsuario->getUsNombre()}</h4>";

echo '<form action="../accion/cerrarSesion.php">
<button  type="submit" class="btn btn-danger fas fa-sign-out-alt">
<span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión
</button>
<br><br>
</form>';

include_once '../estructura/footer.php';
?>