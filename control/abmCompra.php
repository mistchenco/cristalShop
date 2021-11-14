<?php

class abmCompra{
    public function cargarObjeto($param){
        $obj = null;
        print_r($param);
        if (array_key_exists('idCompra', $param) and 
            array_key_exists('compraFecha', $param) and 
            array_key_exists('objUsuario', $param)){
            $objUsuario = new usuario();
            $objUsuario->setIdUsuario($param['idUsuario']);
            $objUsuario->cargar();
            $obj = new compra();
            $obj->setear($param['idCompra'], $param['compraFecha'] , $objUsuario);
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
        print_r($param);
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
            if (isset($param['idCompra']))
                $where .= ' and idCompra = ' ."'". $param['idCompra']."'";
            if (isset($param['compraFecha']))
                $where .= ' and compraFecha =' . $param['compraFecha'] . "'";
            if (isset($param['idUsuario']))
                $where .= ' and idUsuario =' . $param['idUsuario'] . "'";
        }
        $arreglo = compra::listar($where);
        return $arreglo;
    }
}

?>