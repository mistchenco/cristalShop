<?php
class abmCompraEstado
{
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('idCompra', $param)) {
            //creo objeto estadotipos
            $objCompra = new compra();
            $objCompra->setIdCompra($param['idCompra']);
            $objCompra->cargar();

            // Creo objeto usuario
            $objCompraEstadoTipo = new compraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idCompraEstadoTipo']);
            $objCompraEstadoTipo->cargar();

            // Agregarle los otros objetos
            $obj = new compraEstado();
            
            $obj->setear(['idCompraEstado'=>$param['idCompraEstado'],'objCompra'=> $objCompra, 
            'objCompraEstadoTipo'=>$objCompraEstadoTipo, 
            'compraEstadoFechaInicial'=>$param['compraEstadoFechaInicial'], 
            'compraEstadoFechaFinal'=>$param['compraEstadoFechaFinal']]);
        }
        return $obj;
    }

    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], null, null, null, null);
        }
        return $obj;
    }

    private function seteadosCamposClaves($param)
    {
        $resp = false;

        if (isset($param['idCompraEstado'])) {
            $resp = true;
        }

        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        // $param['idcompraestado'] = null;
        $objCompraEstado = $this->cargarObjeto($param);

        if ($objCompraEstado != null and $objCompraEstado->insertar()) {
            $resp = true;
        }

        return $resp;
    }

    public function modificacion($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjeto($param);
            if ($objCompraEstado != null and $objCompraEstado->modificar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    public function aceptarCompra($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            // Busco el estadoCompra actual
            $arrayBusqueda = ["idcompraestado" => $param['idcompraestado']];
            $objCompraEstadoBusqueda = $this->buscar($arrayBusqueda);
            // Busco el estadoTipo de 'aceptada'
            $abmEstadoTipo = new AbmCompraEstadoTipo;
            $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 2]);
            // Seteo el compraEstadoTipo 'aceptada'
            $objCompraEstadoBusqueda[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
            // Si la compra no es nula y la fecha de fin de la compraEstado es igual a '0000-00-00 00:00:00' entonces hago la modificacion del estadoTipo

            if ($objCompraEstadoBusqueda != null and $objCompraEstadoBusqueda[0]->getCeFechaFin() == "0000-00-00 00:00:00") {
                if ($objCompraEstadoBusqueda[0]->modificar()) {
                    $resp = true;
                }
            }
        }

        return $resp;
    }

    public function enviarCompra($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            // Busco el estadoCompra actual
            $arrayBusqueda = ["idcompraestado" => $param['idcompraestado']];
            $objCompraEstadoBusqueda = $this->buscar($arrayBusqueda);
            // Busco el estadoTipo de 'aceptada'
            $abmEstadoTipo = new AbmCompraEstadoTipo;
            $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 3]);
            // Seteo el compraEstadoTipo 'aceptada'
            $objCompraEstadoBusqueda[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
            // Si la compra no es nula y la fecha de fin de la compraEstado es igual a '0000-00-00 00:00:00' entonces hago la modificacion del estadoTipo
            if ($objCompraEstadoBusqueda != null and $objCompraEstadoBusqueda[0]->getCeFechaFin() == "0000-00-00 00:00:00") {
                $objCompraEstadoBusqueda[0]->setCeFechaFin(date("Y-m-d H:i:s"));
                if ($objCompraEstadoBusqueda[0]->modificar()) {
                    $resp = true;
                }
            }
        }

        return $resp;
    }

    public function finCompra($param)
    {
        $resp = false;

        if ($this->seteadosCamposClaves($param)) {
            $objCompraEstado = $this->cargarObjetoConClave($param);
            $listaCompraEstado = $objCompraEstado->listar("idcompraestado='" . $param['idcompraestado'] . "'");
            if (count($listaCompraEstado) > 0) {
                $estadoCompra = $listaCompraEstado[0]->getCeFechaFin();
                if ($estadoCompra == '0000-00-00 00:00:00') {
                    $abmEstadoTipo = new AbmCompraEstadoTipo;
                    $objCompraEstadoTipo = $abmEstadoTipo->buscar(['idcompraestadotipo' => 4]);
                    // Seteo el compraEstadoTipo 'cancelada'
                    $listaCompraEstado[0]->setIdCompraEstadoTipo($objCompraEstadoTipo[0]);
                    if ($listaCompraEstado[0]->modificar()) {
                        $listaCompraEstado[0]->estado(date("Y-m-d H:i:s"));
                        $resp = true;
                    }
                }
            }
        }

        return $resp;
    }

    public function buscar($param)
    {
        $where = " true ";

        if ($param <> NULL) {
            if (isset($param['idCompraEstado']))
                $where .= " and idCompraEstado =" ."'". $param['idCompraEstado']."'";
            if (isset($param['idCompra']))
                $where .= " and idCompra =" ."'". $param['idCompra']."'";
            if (isset($param['idCompraEstadoTipo']))
                $where .= " and idCompraEstadoTipo ='" ."'". $param['idCompraEstadoTipo'] . "'";
            if (isset($param['compraEstadoFechaInicial']))
                $where .= " and compraEstadoFechaInicial ='" ."'". $param['compraEstadoFechaInicial'] . "'";
            if (isset($param['compraEstadoFechaFinal']))
                $where .= " and compraEstadoFechaFinal ='" ."'". $param['compraEstadoFechaFinal'] . "'";
        }
        $arreglo = compraEstado::listar($where);

        return $arreglo;
    }

    public function editarEstadoCompraCliente($datos){
        $abmcompraEstadoTipo=new abmCompraEstadoTipo();
        $datosCompraEstadoTipo=['idCompraEstadoTipo'=>4];
        $listaCompraEstadoTipo=$abmcompraEstadoTipo->buscar($datosCompraEstadoTipo);
        $objCompraEstadoTipo=$listaCompraEstadoTipo[0];

        $listaCompraEstado=$this->buscar($datos);
        $objCompraEstado=$listaCompraEstado[0];


        $objCompra=$objCompraEstado->getObjCompra();
        $idCompraEstado=$objCompraEstado->getIdCompraEstado();
        $fechaInicio=$objCompraEstado->getCompraEstadoFechaInicial();
        $idCompra=$objCompra->getIdCompra();

        $idCompraEstadoTipo=$objCompraEstadoTipo->getIdCompraEstadoTipo();
        $datosCompraEstado=['idCompraEstado'=>$idCompraEstado,
                                'idCompra'=>$idCompra,
                                'idCompraEstadoTipo'=>$idCompraEstadoTipo,
                                'compraEstadoFechaInicial'=>$fechaInicio,
                                'compraEstadoFechaFinal'=> date('Y-m-d h-m-s')
                                ];
        return $datosCompraEstado;
    }

    public function editarEstadoCompra($datos,$objCompraEstado){
        if ($datos['idCompraEstadoTipo'] == 4 || $datos['idCompraEstadoTipo'] == 3) {
            $fechaFinal = date('Y-m-d h:i:s', time());
        }else{
            $fechaFinal = '0000-00-00 00:00:00';
        }
        $datosNuevos = [
            'idCompraEstado' => $datos['idCompraEstado'], 
            'idCompra' => $datos['idCompra'],
            'idCompraEstadoTipo' => $datos['idCompraEstadoTipo'],
            'compraEstadoFechaInicial' => $objCompraEstado->getCompraEstadoFechaInicial(),
            'compraEstadoFechaFinal' => $fechaFinal
        ]; 
        return $datosNuevos;
    } 



}