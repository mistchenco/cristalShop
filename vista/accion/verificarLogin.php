<?php
// include_once '../estructura/cabecera.php';
include_once '../../configuracion.php';
include_once '../../utiles/PHPMailer/enviaMail.php';
$sesion = new session();
$datos = data_submitted();
// $enviarMail = new enviarMail();
print_r($datos);
if($sesion->iniciar($datos['usNombre'], $datos['usPass'])){
    $objUsuario=$sesion->getObjUsuario();
    $mailUsuario=$objUsuario->getUsMail();
    $datos['usMail']=$mailUsuario;
    print_r($objUsuario);
    // if($mail=$enviarMail->newEmail("","",$datos['usMail'],$datos['usNombre'],"iNGRESO EXITOSO","Nuevo ingreso a tu cuenta registrado ")){
    // }
    // header('Location: ../ejercicios/paginaSegura.php');
    
}else{
    header('Location: ../ejercicios/login.php');
}

include_once '../estructura/footer.php';