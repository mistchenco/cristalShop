<?php
include_once '../estructura/cabecera.php';
include_once '../../utiles/PHPMailer/enviaMail.php';
$datos = data_submitted();
print_r($datos);
$arregloRoles=array();
$abmUsuario = new abmUsuario();
$enviarMail=new enviarMail();
$usuario=['idUsuario' => $datos['idUsuario']];
$listaUsuario = $abmUsuario->buscar($usuario);
$objUsuario = $listaUsuario[0];

$datos['usDesabilitado'] = $objUsuario->getUsDesabilitado();
$datos['usPass']= md5($datos['usPass']);

$abmUsuarioRol=new abmUsuarioRol();
$listaRol=$abmUsuarioRol->buscar($usuario);
$modificoUsuario=$abmUsuario->modificacion($datos);
if($modificoUsuario || isset($datos['roles'])){
    if(count($listaRol)>0){
        foreach($listaRol as $objRol){
            array_push($arregloRoles, $objRol->getObjRol()->getIdRol());
        }
        foreach ($arregloRoles as $idRol){
            if (!in_array($idRol, $datos['roles'])) {
                print_r($datos);
                $abmUsuarioRol->baja(['idUsuario' => $datos['idUsuario'], 'idRol' => $idRol]);
                $respRol=true;
            }
        }
    }
    if (isset($datos["roles"])) {
        foreach ($datos['roles'] as $idRol) {
            if (!in_array($idRol, $arregloRoles)) {
                $abmUsuarioRol->alta(['idUsuario' => $datos['idUsuario'], 'idRol' => $idRol]);
                $respRol=true;
            }
        }
    }
}
if($modificoUsuario || $respRol){
    
    // $mail=$enviarMail->newEmail("","",$datos['usMail'],$datos['usNombre'],"MODIFICACION USUARIO","Sus Datos Fueron modificados correctamente");
    $mensaje = "El usuario se modifico con exito, Revise su casilla";
    header("Location: ../ejercicios/listarUsuarios.php?Message=" . urlencode($mensaje));
}else{
    echo "<h1>ERROR de modificacion,Debe cambiar al menos un valor y no debe tener campos vacios</h1>";
}
    

    


include_once '../estructura/footer.php';

