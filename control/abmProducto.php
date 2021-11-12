<?php

class abmProducto{
    public function cargarObjeto($param){
        $obj = null;
        $param = ['idProducto' => '', 
        'productoNombre' => $param['productoNombre'] ,
        'productoDetalle' => $param['productoDetalle'], 
        'productoStock' => $param['productoStock'], 
        'productoPrecio' => $param['productoPrecio']];

        if (array_key_exists('idProducto', $param) and 
            array_key_exists('productoNombre', $param) and 
            array_key_exists('productoDetalle', $param) and 
            array_key_exists('productoStock', $param) and 
            array_key_exists('productoPrecio', $param)){
            $obj = new producto();
            $obj->setear(['idProducto' => $param['idProducto'], 
                        'productoNombre' => $param['productoNombre'] ,
                        'productoDetalle' => $param['productoDetalle'] , 
                        'productoStock' => $param['productoStock'] , 
                        'productoPrecio' => $param['productoPrecio']]);
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

    public function altaImagen($objProducto , $param){
        $directorio = md5($objProducto->getIdProducto());

        mkdir( $GLOBALS['IMAGENES'] . $directorio , 0777);
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
            if (isset($param['idProducto']))
                $where .= ' and idProducto = ' ."'". $param['idProducto']."'";
            if (isset($param['productoNombre']))
                $where .= ' and productoNombre = ' . "'" . $param['productoNombre'] . "'";
            if (isset($param['productoDetalle']))
                $where .= ' and productoDetalle =' . "'" . $param['productoDetalle'] . "'";
            if (isset($param['productoStock']))
                $where .= ' and productoStock =' . "'" . $param['productoStock'] . "'";
            if (isset($param['productoPrecio']))
                $where .= ' and productoPrecio =' . "'" . $param['productoPrecio'] . "'";
        }
        $arreglo = producto::listar($where);
        return $arreglo;
    }
}
