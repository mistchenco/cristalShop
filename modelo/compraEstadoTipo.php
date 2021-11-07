<?php

class compraEstadoTipo{
    
    private $idCompraEstadoTipo; 
    private $compraEstadoTipoDescripcion;
    private $compraEstadoTipoDetalle; 
    private $mensajeOperacion; 
    //Constructor
    public function __construct(){
        $this->idCompraEstadoTipo = 0;
        $this->compraEstadoTipoDescripcion = '';
        $this->compraEstadoTipoDetalle = '';
        $this->mensajeOperacion = ''; 
    }

    //Metodos Getters
    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }
    public function getCompraEstadoTipoDescripcion(){
        return $this->compraEstadoTipoDescripcion;
    }
    public function getCompraEstadoTipoDetalle(){
        return $this->compraEstadoTipoDetalle;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //Metodos Setters
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function setIdCompraEstadoTipo($idCompraEstadoTipo){
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }
    public function setCompraEstadoTipoDescripcion($compraEstadoTipoDescripcion){
        $this->compraEstadoTipoDescripcion = $compraEstadoTipoDescripcion;
    } 
    public function setCompraEstadoTipoDetalle($compraEstadoTipoDetalle){
        $this->compraEstadoTipoDetalle = $compraEstadoTipoDetalle;
    }

    //Funcion Setear
    public function setear($datos){
        $this->setIdCompraEstadoTipo($datos['idCompraEstadoTipo']);
        $this->setCompraEstadoTipoDescripcion($datos['compraEstadoTipoDescripcion']);
        $this->setCompraEstadoTipoDetalle($datos['compraEstadoTipoDetalle']);
    }

    //Metodos Cargar
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $sql = "SELECT * 
                FROM compraestadotipo 
                WHERE idCompraEstadoTipo = '$idCompraEstadoTipo'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear(['idCompraEstadoTipo'=>$row['idCompraEstadoTipo'] ,'compraEstadoTipoDescripcion'=>$row['compraEstadoTipoDescripcion'] ,'compraEstadoTipoDetalle' => $row['compraEstadoTipoDetalle']]);
                }
            }
        } else {
            $this->setMensajeoperacion("compraestadotipo->cargar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new compraEstadoTipo();
                    $obj->setear(['idCompraEstadoTipo'=>$row['idCompraEstadoTipo'] ,'compraEstadoTipoDescripcion'=>$row['compraEstadoTipoDescripcion'] ,'compraEstadoTipoDetalle' => $row['compraEstadoTipoDetalle']]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("compraestadorol->Listar: ".$base->getError());
        }
        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $compraEstadoTipoDescripcion = $this->getCompraEstadoTipoDescripcion();
        $compraEstadoTipoDetalle = $this->getCompraEstadoTipoDetalle(); 
        $sql = "INSERT INTO compraestadotipo(idCompraEstadoTipo, compraEstadoTipoDescripcion, compraEstadoTipoDetalle) 
                VALUES('$idCompraEstadoTipo','$compraEstadoTipoDescripcion' , '$compraEstadoTipoDetalle')";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdCompraEstadoTipo($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $compraEstadoTipoDescripcion = $this->getCompraEstadoTipoDescripcion();
        $compraEstadoTipoDetalle = $this->getCompraEstadoTipoDetalle();
        $sql = "UPDATE compraestadotipo 
                SET compraEstadoTipoDescripcion ='$compraEstadoTipoDescripcion' , 
                    compraEstadiTipoDetalle = '$compraEstadoTipoDetalle'
                WHERE idCompraEstadoTipo = '$idCompraEstadoTipo'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $sql = "DELETE FROM compraestadotipo 
                WHERE idCompraEstadoTipo = '$idCompraEstadoTipo'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->eliminar: " . $base->getError());
        }
        return $resp;
    }

}


?>