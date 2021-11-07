<?php

class abmCompraEstadoTipo{
    public function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idCompraEstadoTipo', $param) and 
            array_key_exists('compraEstadoTipoDescripcion', $param) and 
            array_key_exists('compraEstadoTipoDetalle', $param)){
            $obj = new compraEstadoTipo();
            $obj->setear($param['idCompraEstadoTipo'], $param['compraEstadoTipoDescripcion'], $param['compraEstadoTipoDetalle']);
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
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
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
    public function buscar($param){
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idCompraEstadoTipo']))
                $where .= ' and idCompraEstadoTipo = ' ."'". $param['idCompraEstadoTipo']."'";
            if (isset($param['compraEstadoTipoDescripcion']))
                $where .= ' and compraEstadoTipoDescripcion =' . $param['compraEstadoTipoDescripcion'] . "'";
            if (isset($param['compraEstadoTipoDetalle']))
                $where .= ' and compraEstadoTipoDetalle =' . $param['compraEstadoTipoDetalle'] . "'";
        }
        $arreglo = compraEstadoTipo::listar($where);
        return $arreglo;
    }
}
