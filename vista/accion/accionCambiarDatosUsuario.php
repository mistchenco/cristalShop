<?php
    include_once '../../configuracion.php';
    $sesion = new session();
    $datos = data_submitted();
    $abmUsuario = new abmUsuario(); 
    $abmUsuario->accionCambiarDatosUsuario($datos, $sesion);    
?>