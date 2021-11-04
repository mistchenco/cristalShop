<?php

class abmUsuario
{

    private function cargarObjeto($param)
    {

        $obj = null;

        if (array_key_exists('idUsuario', $param) and array_key_exists('usNombre', $param) and array_key_exists('usPass', $param) and array_key_exists('usMail', $param) and array_key_exists('usDesabilitado', $param)) {

            $obj = new usuario();
            $obj->setear(["idUsuario" => $param["idUsuario"], "usNombre" => $param["usNombre"], "usPass" => $param["usPass"], "usMail" => $param["usMail"], "usDesabilitado" => $param["usDesabilitado"]]);
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
}
