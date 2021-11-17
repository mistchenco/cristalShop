<?php

class abmCompra
{
    public function agregarCompra($param, $objUsuario)
    {
        //falta instancia de compra estado! y sumar el total de la compra!!
        $respuesta = false;
        $objCompra = null;
        $arregloProductos = $param;

        $arregloCompraItem = array();
        $objCompra = new compra();
        $datosCompra = [
            'idCompra' => '',
            'compraFecha' => date('Y-m-d h:i:s', time()),
            'objUsuario' => $objUsuario,
            'coleccionItems' => $arregloCompraItem
        ];
        $objCompra->setear($datosCompra);
        $objCompra->insertar();
        $idCompra = $objCompra->getIdCompra();
        foreach ($arregloProductos as $producto) {
            $nuevoStock['productoStock'] = 0;
            $cantidadAdescontar = 0;
            $cantidadActual = 0;
            $objCompraItem = new abmCompraItem();
         
            $datosCompraItem = [
                'idCompraItem' => '',
                'idProducto' => $producto['idProducto'],
                'idCompra' => $idCompra,
                'compraItemCantidad' => $producto['cantidadCompra']
            ];

            if ($objCompraItem->alta($datosCompraItem)) {

                $objabmProducto = new abmProducto();
               
                
                $listaProductos = $objabmProducto->buscar($datosCompraItem);
                $objProducto = $listaProductos[0];
                
                $nombreProducto = $objProducto->getProductoNombre();
                $productoDetalle = $objProducto->getProductoDetalle();
                $productoPrecio = $objProducto->getProductoPrecio();
                $cantidadActual = $objProducto->getProductoStock();
               
                $cantidadAdescontar = $datosCompraItem['compraItemCantidad'];
              
                $nuevoStock['productoStock'] = $cantidadActual - $cantidadAdescontar;
                $datosProducto = [
                    'idProducto' => $producto['idProducto'],
                    'productoNombre' => $nombreProducto,
                    'productoPrecio' => $productoPrecio,
                    'productoDetalle' => $productoDetalle,
                    'productoStock' => $nuevoStock['productoStock']
                ];
               
                $objabmProducto->modificacion($datosProducto);
                array_push($arregloCompraItem, $objCompraItem);
                $respuesta = true;
            }
            $objCompra->setColeccionItems($arregloCompraItem);
        }
        return $respuesta;
    }
    public function cargarObjeto($param)
    {
        $obj = null;
        print_r($param);
        if (
            array_key_exists('idCompra', $param) and
            array_key_exists('compraFecha', $param) and
            array_key_exists('objUsuario', $param)
        ) {
            $objUsuario = new usuario();
            $objUsuario->setIdUsuario($param['idUsuario']);
            $objUsuario->cargar();
            $obj = new compra();
            $obj->setear($param['idCompra'], $param['compraFecha'], $objUsuario);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    public function seteadosCamposClaves($param)
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
    public function baja($param)
    {
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
            if (isset($param['idCompra']))
                $where .= ' and idCompra = ' . "'" . $param['idCompra'] . "'";
            if (isset($param['compraFecha']))
                $where .= ' and compraFecha =' . $param['compraFecha'] . "'";
            if (isset($param['idUsuario']))
                $where .= ' and idUsuario =' . $param['idUsuario'] . "'";
        }
        $arreglo = compra::listar($where);
        return $arreglo;
    }
}
