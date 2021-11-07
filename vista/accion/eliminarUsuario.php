<?php
include_once '../estructura/cabecera.php';
$datos = data_submitted();
$abmUsuario = new abmUsuario();
$listaUsuario = $abmUsuario->buscar($datos);
// $idUsuario = $datos['idUsuario'];
$objUsuario = $listaUsuario[0];
// print_r($objUsuario);
$datos['usNombre'] = $objUsuario->getUsNombre();
$datos['usPass'] = $objUsuario->getUsPass();
$datos['usMail'] = $objUsuario->getUsMail();

if ($objUsuario->getUsDesabilitado()=="0000-00-00 00:00:00") {
    $datos['usDesabilitado'] = date('Y-m-d h:i:s a', time());
} else {
    $datos['usDesabilitado'] = "0000-00-00 00:00:00";
}
print_r($datos);
$exito = $abmUsuario->modificacion($datos);
header("Location: ../ejercicios/listarUsuarios.php");
include_once '../estructura/footer.php';
?>