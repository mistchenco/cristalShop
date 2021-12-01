<?php
    include_once '../../configuracion.php';
    include_once '../estructura/cabecera.php';
    $datos = data_submitted();
    $abmUsuario = new abmUsuario();
    $abmUsuario->accionEditarUsuario($datos);
    include_once '../estructura/footer.php';
?>