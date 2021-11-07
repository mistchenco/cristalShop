<?php


class abmMenuRol{
   
    public function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idMenu', $param) and array_key_exists('objRol', $param)){
            $obj = new abmMenuRol();
            $obj->setear($param['idMenu'], $param['objRol']);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    public function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param)){
            $resp = true;
        }
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param){
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
            $elObjtTabla = $this->cargarObjeto($param);
            $abmMenuRol = new abmMenuRol();
            $arregloRoles = $abmMenuRol->buscar($param);
            foreach ($arregloRoles as $objRol) {
                $abmMenuRol->baja($param);
            }

            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
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
    public function modificacion($param){
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
                $where .= ' and idMenu = ' ."'". $param['idMenu']."'";
            if (isset($param['objRol']))
                $where .= ' and objRol =' . $param['objRol'] . "'";
        }
        $arreglo = menuRol::listar($where);
        return $arreglo;
    }
}
