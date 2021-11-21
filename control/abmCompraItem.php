<?php
class abmCompraItem
{
    private function cargarObjeto($param)
    {
        $obj = null;
        // print_r($param);
        // echo"cargarObjeto";
        if (array_key_exists('idCompraItem', $param) && array_key_exists('idProducto', $param) && array_key_exists('idCompra', $param) && array_key_exists('compraItemCantidad', $param)) {
            $objProducto = new producto();
            $objProducto->setIdProducto($param['idProducto']);
            $objProducto->cargar();

            $objCompra = new compra();
            $objCompra->setIdCompra($param['idCompra']);
            $objCompra->cargar();
            $idCompra=$objCompra->getIdCompra();
            // echo $idCompra;
            $obj = new compraItem();
            //sacamos de setear 'idCompraItem'=>$param['idCompraItem'],
            $obj->setear(['objProducto'=> $objProducto,'idCompra'=> $idCompra, 'compraItemCantidad'=>$param['compraItemCantidad']]);
        }
       
        return $obj;
    }

    // private function cargarObjetoConClave($param)
    // {
    //     $obj = null;
    //     if (isset($param['idCompraItem'])) {
    //         $obj = new CompraItem();
    //         $obj->setear($param['idCompraItem'], null, null, null);
    //     }

    //     return $obj;
    // }

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraitem'])) {
            $resp = true;
        }

        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        // $param['idCompraItem'] = '';
        $elObjtArchivoE = $this->cargarObjeto($param);
        //print_r($elObjtArchivoE);
        if ($elObjtArchivoE != null and $elObjtArchivoE->insertar()) {
            $resp = true;
        }
        return $resp;
    }

     public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtArchivoE = $this->cargarObjetoConClave($param);
            if ($elObjtArchivoE!=null and $elObjtArchivoE->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    } 

    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtArchivoE = $this->cargarObjeto($param);
            if ($elObjtArchivoE != null and $elObjtArchivoE->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idCompraItem']))
                $where .= " and idCompraItem = '" . $param['idCompraItem'] . "'";
            if (isset($param['idProducto']))
                $where .= " and idProducto = '" . $param['idProducto'] . "'";
            if (isset($param['idCompra']))
                $where .= " and idCompra = '" . $param['idCompra'] . "'";
            if (isset($param['compraItemCantidad']))
                $where .= " and compraItemCantidad = '" . $param['compraItemCantidad'] . "'";
        }
        // echo ' WHERE DE ABM COMPRA ITEM';
        // echo $where;
        $arreglo = compraItem::listar($where);
        return $arreglo;
    }
}