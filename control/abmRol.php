<?php

class abmRol{
   
    public function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idRol', $param) and array_key_exists('rolDescripcion', $param)){
            $obj = new rol();
            $obj->setear($param['idRol'], $param['rolDescripcion']);
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
            $abmUsuariorol = new abmUsuarioRol();
            $arregloRoles = $abmUsuariorol->buscar($param);
            foreach ($arregloRoles as $objRol) {
                $abmUsuariorol->baja($param);
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
            if (isset($param['idRol']))
                $where .= ' and idRol = ' ."'". $param['idRol']."'";
            if (isset($param['rolDescripcion']))
                $where .= ' and rolDescripcion =' . $param['rolDescripcion'] . "'";
        }
        $arreglo = rol::listar($where);
        return $arreglo;
    }
}
