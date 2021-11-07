<?php
include_once '../estructura/cabecera.php';
include_once '../../utiles/PHPMailer/enviaMail.php';
$sesion= new session();
$datos=data_submitted();
$enviarMail=new enviarMail();
if($sesion->iniciar($datos['usNombre'], $datos['usPass'])){
   $objUsuario=$sesion->getUsuario();
   $mailUsuario=$objUsuario->getUsMail();
   $datos['usMail']=$mailUsuario;

    if($mail=$enviarMail->newEmail("","",$datos['usMail'],$datos['usNombre'],"iNGRESO EXITOSO","Nuevo ingreso a tu cuenta registrado ")){
    
    header('Location: ../ejercicios/paginaSegura.php');
    }
}else{
    // header('Location: ../ejercicios/login.php');
}

include_once '../estructura/footer.php';