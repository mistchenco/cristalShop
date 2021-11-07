<?php

class abmMenu
{

    private function cargarObjeto($param)
    {

        $obj = null;

        if (array_key_exists('idMenu', $param) and array_key_exists('menuNombre', $param) and array_key_exists('menuDescripcion', $param) and array_key_exists('objPadre', $param) and array_key_exists('menuDeshabilitado', $param)) {

            $obj = new menu();
            $obj->setear(["idMenu" => $param["idMenu"], "menuNombre" => $param["menuNombre"], "menuDescripcion" => $param["menuDescripcions"], "objPadre" => $param["objPadre"], "menuDeshabilitado" => $param["menuDeshabilitado"]]);
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
            $abmMenuRol = new abmMenuRol();
            $arregloRoles = $abmMenuRol->buscar($param);
            foreach ($arregloRoles as $objRol) {
                $abmMenuRol->baja($param);
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
            if (isset($param['idMenu']))
                $where .= ' and idMenu = ' . "'" . $param['idMenu'] . "'";
            if (isset($param['menuNombre']))
                $where .= ' and menuNombre =' . "'" . $param['menuNombre'] . "'";
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
