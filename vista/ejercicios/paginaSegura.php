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
$abmUsuario = new abmUsuario();
$abmRol = new abmUsuarioRol();
$listaUsuario = $abmUsuario->buscar(null);
if ($tienePermiso == false) {
  echo "</br></br></br></br></br></br>";
  echo "<h4 class='alert alert-danger'>Usted no tiene Permisos para esta seccion</h4>";
} else {
?>
<?php
}
include_once '../estructura/footer.php';
?>