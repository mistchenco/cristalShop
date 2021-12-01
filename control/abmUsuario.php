<?php

class abmUsuario
{

    private function cargarObjeto($param)
    {

        $obj = null;

        if (array_key_exists('idUsuario', $param) and array_key_exists('usNombre', $param) and array_key_exists('usPass', $param) and array_key_exists('usMail', $param) and array_key_exists('usDesabilitado', $param)) {

            $obj = new usuario();
            $obj->setear([ 'idUsuario' => $param['idUsuario'] , "usNombre" => $param["usNombre"], "usPass" => $param["usPass"], "usMail" => $param["usMail"], "usDesabilitado" => $param["usDesabilitado"]]);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param)) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuario = $this->cargarObjeto($param);
            $abmUsuariorol = new abmUsuarioRol();
            $arregloRoles = $abmUsuariorol->buscar($param);
            foreach ($arregloRoles as $objRol) {
                $abmUsuariorol->baja($param);
            }

            if ($objUsuario != null and $objUsuario->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }



    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    

    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {


        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idUsuario']))
                $where .= ' and idUsuario = ' . "'" . $param['idUsuario'] . "'";
            if (isset($param['usNombre']))
                $where .= ' and usNombre =' . "'" . $param['usNombre'] . "'";
            if (isset($param['usPass']))
                $where .= ' and usPass =' . "'" . $param['usPass'] . "'";
            if (isset($param['usMail']))
                $where .= ' and usMail =' . "'" . $param['usMail'] . "'";
            if (isset($param['usDesabilitado']))
                $where .= ' and usDesabilitado =' . $param['usDesabilitado'] . "'";
        }

        $arreglo = usuario::listar($where);

        return $arreglo;
    }


    public function accionCrearUsuario($datos){
    $busquedaNombreUsuario = ['usNombre' => $datos['usNombre']];
    $respuesta1 = $this->buscar($busquedaNombreUsuario);

    $busquedaMailUsuario = ['usMail' => $datos['usMail']];
    $respuesta2 = $this->buscar($busquedaMailUsuario);

    if (count($respuesta1) > 0 || count($respuesta2) > 0) {
        $mensaje="El usuario no se ha podido crear.";
        header("Location: ../ejercicios/crearUsuario.php?Message=" . urlencode($mensaje));
    }else{
        
        $datosUsuario = [
            "idUsuario"=>'',
            "usNombre" => $datos['usNombre'],
            "usMail" => $datos['usMail'],
            "usPass" => md5($datos['usPass']),
            "usDesabilitado" => '0000-00-00 00:00:00'
        ]; 

        $usuario = $this->alta($datosUsuario);
        $busqueda = [
            "usMail" => $datos['usMail']
        ];
        $objUsuario = $this->buscar($busqueda);
        
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

        $mensaje="El usuario se creó con exito, Revise su casilla";
        header("Location: ../ejercicios/login.php?Message=" . urlencode($mensaje));
        }
    }

    public function accionCambiarDatosUsuario($datos , $sesion){
        $objUsuario = $sesion->getObjUsuario();
        //Genero una busqueda en el abm usuario del MAIL ingresado por formulario
        $paramMail = ['usMail' => $datos['usMail']];
        $objUsuarioBase = $this->buscar($paramMail);
        $mensajeHeader = []; 
        //Primero compruebo que la password ingresada como antigua, sea igual a la de la base de
        //datos. Luego compruebo que el mail sea igual o no haya otro igual en la base para no 
        //cambiar cualquiera. Luego modifico en la base de datos y seteo la variable de sesion
        //termino redirigiendo nuevamente a pagina segura o muestro mensaje. 
    if (md5($datos['usPass']) ==  $objUsuario->getUsPass()) {
        if ($datos['usMail'] == $objUsuario->getUsMail() || count($objUsuarioBase) == 0) {
            $datosModificacion = [
                'idUsuario' => $objUsuario->getIdUsuario(),
                'usNombre' => $objUsuario->getUsNombre(),
                'usPass' => md5($datos['usPassNuevo']),
                'usMail' => $datos['usMail'],
                'usDesabilitado' => '0000-00-00 00:00:00'
            ];
            if($this->modificacion($datosModificacion)){
                echo 'se dio papa';
            }
            $sesion->setObjUsuario($datosModificacion);
            $mensajeHeader['mensaje'] = "El usuario se modifico con exito";
            $mensajeHeader['header'] = "../ejercicios/paginaSegura.php";
        }else{
            $mensajeHeader['mensaje'] = "El Usuario NO se ha modificado. Revise los datos ingresados";
            $mensajeHeader['header'] = "../ejercicios/cambiarDatosUsuario.php";
        }
    }else{
        $mensajeHeader['mensaje'] = "La contraseña antigua no es valida. Por favor, vuelva a ingresar sus datos nuevamente";
        $mensajeHeader['header'] = "../ejercicios/cambiarDatosUsuario.php";
    }

    return $mensajeHeader;
    }

    public function accionEditarUsuario($datos){
        $arregloRoles = array();
        $usuario = ['idUsuario' => $datos['idUsuario']];
        $listaUsuario = $this->buscar($usuario);
        $objUsuario = $listaUsuario[0];


        $datos['usDesabilitado'] = $objUsuario->getUsDesabilitado();
        $datos['usPass'] = md5($datos['usPass']);

        $abmUsuarioRol=new abmUsuarioRol();
        $listaRol=$abmUsuarioRol->buscar($usuario);
        $modificoUsuario=$this->modificacion($datos);


        if($modificoUsuario || isset($datos['roles'])){
            if(count($listaRol)>0){
                foreach($listaRol as $objRol){
                    array_push($arregloRoles, $objRol->getObjRol()->getIdRol());
                }
                foreach ($arregloRoles as $idRol){
                    if (!in_array($idRol, $datos['roles'])) {
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
            $mensaje = "El usuario se modifico con exito, Revise su casilla";
           
        }else{
            $mensaje = 'ERROR de modificacion,Debe cambiar al menos un valor y no debe tener campos vacios';
        }
        return $mensaje;
    }


}
