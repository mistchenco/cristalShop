<?php

include_once '../../configuracion.php';

//Traemos los datos de siempre
$sesion = new session();
$datos = data_submitted();
$abmUsuario = new abmUsuario();
$objUsuario = $sesion->getObjUsuario();

//Genero una busqueda en el abm usuario del MAIL ingresado por formulario
$paramMail = ['usMail' => $datos['usMail']];
$objUsuarioBase = $abmUsuario->buscar($paramMail);

//Primero compruebo que la password ingresada como antigua, sea igual a la de la base de
//datos. Luego compruebo que el mail sea igual o no haya otro igual en la base para no 
//cambiar cualquiera. Luego modifico en la base de datos y seteo la variable de sesion
//termino redirigiendo nuevamente a pagina segura o muestro mensaje. 
if (md5($datos['usPass']) ==  $objUsuario->getUsPass()) {
    if ($datos['usMail'] == $objUsuario->getUsMail() || count($objUsuarioBase) == 0) {
        echo 'ENTRE EN EL IF';
        print_r($objUsuario);
        $datosModificacion = [
            'idUsuario' => $objUsuario->getIdUsuario(),
            'usNombre' => $objUsuario->getUsNombre(),
            'usPass' => md5($datos['usPassNuevo']),
            'usMail' => $datos['usMail'],
            'usDesabilitado' => '0000-00-00 00:00:00'
        ];
        if($abmUsuario->modificacion($datosModificacion)){
            echo 'se dio papa';
        }
        $sesion->setObjUsuario($datosModificacion);
        $mensaje = "El usuario se modifico con exito";
        header("Location: ../ejercicios/paginaSegura.php?Message=" . urlencode($mensaje));
    }else{
        $mensaje = "El Usuario NO se ha modificado. Revise los datos ingresados";
        header("Location: ../ejercicios/cambiarDatosUsuario.php?Message=" . urlencode($mensaje));
    }
}else{
    $mensaje = "La contraseña antigua no es valida. Por favor, vuelva a ingresar sus datos nuevamente";
    header("Location: ../ejercicios/cambiarDatosUsuario.php?Message=" . urlencode($mensaje));
}



?>