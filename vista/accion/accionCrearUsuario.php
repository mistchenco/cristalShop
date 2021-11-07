<?php
    include_once '../estructura/cabecera.php';
    include_once '../../configuracion.php';
?>

<?php
    $datos = data_submitted();
    $abmUsuario = new abmUsuario();

    $busquedaNombreUsuario = ['usNombre' => $datos['usNombre']];
    $respuesta1 = $abmUsuario->buscar($busquedaNombreUsuario);

    $busquedaMailUsuario = ['usMail' => $datos['usMail']];
    $respuesta2 = $abmUsuario->buscar($busquedaMailUsuario);

    if (count($respuesta1) > 0 || count($respuesta2) > 0) {
        $mensaje="El usuario no se ha podido crear." . $mail;
        header("Location: ../ejercicios/crearUsuario.php?Message=" . urlencode($mensaje));
    }else{
        $datosUsuario = [
            "usNombre" => $datos['usNombre'],
            "usMail" => $datos['usMail'],
            "usPass" => md5($datos['usPass']),
            "usDesabilitado" => "0000-00-00 00:00:00"
        ]; 
        $usuario = $abmUsuario->alta($datosUsuario);
        $busqueda = [
            "usMail" => $datos['usMail']
        ];
        $objUsuario = $abmUsuario->buscar($busqueda);
        $idUsuario = $objUsuario[0]->getIdUsuario();
        $rol = new abmRol();
        $paramRol = [
            'idRol' => 3
        ];
        $objRol = $rol->buscar($paramRol);
        $param = [
            'idUsuario' => $idUsuario,
            'idRol' => $objRol[0]->getIdRol()
        ];

        $rolUsuario = new abmUsuarioRol();
        $rolUsuario->alta($param);

        $mensaje="El usuario se creó con exito, Revise su casilla" . $mail;
        header("Location: ../ejercicios/login.php?Message=" . urlencode($mensaje));
    
    }

?>


<?php
    include_once '../estructura/footer.php';
?>