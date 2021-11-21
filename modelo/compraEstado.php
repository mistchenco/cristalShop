<?php

class compraEstado{

    private $idCompraEstado; 
    private $objCompra; 
    private $objCompraEstadoTipo;
    private $compraEstadoFechaInicial; 
    private $compraEstadoFechaFinal;
    private $mensajeOperacion; 

    //Constructor
    public function __construct(){
        $this->idCompraEstado = 0;
        $this->objCompra = '';
        $this->objCompraEstadoTipo = '';
        $this->compraEstadoFechaInicial = '';
        $this->compraEstadoFechaFinal = ''; 
    }

    //Metodo Setear
    public function setear($datos){
        $this->setIdCompraEstado($datos['idCompraEstado']);
        $this->setObjCompra($datos['objCompra']);
        $this->setObjCompraEstadoTipo($datos['objCompraEstadoTipo']); 
        $this->setCompraEstadoFechaInicial($datos['compraEstadoFechaInicial']);
        $this->setCompraEstadoFechaFinal($datos['compraEstadoFechaFinal']);
    }


    //Metodos Getters
    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }
    public function getObjCompra(){
        return $this->objCompra;
    }
    public function getObjCompraEstadoTipo(){
        return $this->objCompraEstadoTipo;
    }
    public function getCompraEstadoFechaFinal(){
        return $this->compraEstadoFechaFinal;
    }
    public function getCompraEstadoFechaInicial(){
        return $this->compraEstadoFechaInicial;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Metodos Setters
    public function setIdCompraEstado($idCompraEstado){
        $this->idCompraEstado = $idCompraEstado;
    }
    public function setObjCompra($objCompra){
        $this->objCompra = $objCompra;
    }
    public function setObjCompraEstadoTipo($objCompraEstadoTipo){
        $this->objCompraEstadoTipo = $objCompraEstadoTipo;
    }
    public function setCompraEstadoFechaInicial($compraEstadoFechaInicial){
        $this->compraEstadoFechaInicial = $compraEstadoFechaInicial;
    }
    public function setCompraEstadoFechaFinal($compraEstadoFechaFinal){
        $this->compraEstadoFechaFinal = $compraEstadoFechaFinal;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    


    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstado = $this->getIdCompraEstado();
        $sql = "SELECT * FROM compraestado 
                WHERE idCompraEstado = '$idCompraEstado'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objCompra = new compra();
                    //Consultar si setear el ID o invocar el metodo listar con el $row['idCompra']
                    $objCompra->setIdCompra($row['idCompra']);
                    $objCompra->cargar();

                    $objCompraEstadoTipo = new compraEstadoTipo; 
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idCompraEstadoTipo']);
                    $objCompraEstadoTipo->cargar(); 
                    $datos = [
                        "idCompraEstado" => $row['idCompraEstado'], 
                        "objCompra" => $objCompra, 
                        "objCompraEstadoTipo" => $objCompraEstadoTipo, 
                        "compraEstadoFechaInicial" => $row['compraEstadoFechaInicial'], 
                        "compraEstadoFechaFinal" => $row['compraEstadoFechaFinal'] 
                    ];
                    $this->setear($datos);
                }
            }
        } else {
            $this->setMensajeoperacion("compraEstado->cargar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado";
      
        if ($parametro != "") {
            $sql .= ' WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new compraEstado();
                    $objCompra = new compra();
                    $objCompra->setIdCompra($row['idCompra']);
                    $objCompra->cargar();
                    //Consultar si setear el ID o invocar el metodo listar con el $row['idCompra']
                    $objCompraEstadoTipo = new compraEstadoTipo; 
                    $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idCompraEstadoTipo']);
                    $objCompraEstadoTipo->cargar(); 
                    $datos = [
                        "idCompraEstado" => $row['idCompraEstado'], 
                        "objCompra" => $objCompra, 
                        "objCompraEstadoTipo" => $objCompraEstadoTipo, 
                        "compraEstadoFechaInicial" => $row['compraEstadoFechaInicial'], 
                        "compraEstadoFechaFinal" => $row['compraEstadoFechaFinal'] 
                    ];
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("compraEstado->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        // $idCompraEstado = $this->getIdCompraEstado();
        $objCompra = $this->getObjCompra()->getIdCompra();
        $objCompraEstadoTipo = $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $compraEstadoFechaFinal = $this->getCompraEstadoFechaFinal();
        $compraEstadoFechaInicial = $this->getCompraEstadoFechaInicial();
        $sql = "INSERT INTO compraestado(idCompra , idCompraEstadoTipo , compraEstadoFechaInicial, compraEstadoFechaFinal) 
                VALUES('$objCompra','$objCompraEstadoTipo' , '$compraEstadoFechaInicial' , '$compraEstadoFechaFinal')";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdCompraEstado($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestado->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("compraestado->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstado = $this->getIdCompraEstado();
        $objCompra = $this->getObjCompra()->getIdCompra();
        $objCompraEstadoTipo = $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $compraEstadoFechaFinal = $this->getCompraEstadoFechaFinal();
        $compraEstadoFechaInicial = $this->getCompraEstadoFechaInicial();
        $sql = "UPDATE compraestado 
                SET idCompra = '$objCompra' , idCompraEstadoTipo = '$objCompraEstadoTipo' , 
                    compraEstadoFechaInicial = '$compraEstadoFechaInicial' , compraEstadoFechaFinal = '$compraEstadoFechaFinal' 
                WHERE idCompraEstado = '$idCompraEstado'";
        echo $sql;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestado->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestado->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstado = $this->getIdCompraEstado();
        $sql = "DELETE * ¨
                FROM compraestado 
                WHERE idCompraEstado = '$idCompraEstado'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraestado->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestado->eliminar: " . $base->getError());
        }
        return $resp;
    }



}