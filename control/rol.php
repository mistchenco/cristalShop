<?php

class rol{

    private $idRol; 
    private $rolDescripcion; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idRol = '';
        $this->rolDescripcion = '';
      
    }
// METODOS SETTERS
    public function setear($datos){
        $this->setIdRol($datos['idRol']);
        $this->setRolDescripcion($datos['rolDescripcion']);
    }

    public function setIdRol($idRol){
        $this->idRol = $idRol;
    }
    public function setRolDescripcion($rolDescripcion){
        $this->rolDescripcion = $rolDescripcion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    
    // METODOS GETTERS
    public function getRolDescripcion(){
        return $this->rolDescripcion;
    }

   
    public function getIdRol(){
        return $this->idRol;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    
// CONSULTAS A LA BASE DE DATOS
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $sql="SELECT * FROM rol WHERE idRol = '$idRol'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear(['idRol'=>$row['idRol'], 'rolDescripcion'=>$row['rolDescripcion']]);
                }
            }
        } else {
            $this->setMensajeoperacion("Rol->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new rol();
                    $obj->setear(['idRol'=>$row['idRol'], 'rolDescripcion'=>$row['rolDescripcion']]);
                    array_push($arreglo, $obj);
                 
                }
            }
        } else {
          $this->setMensajeoperacion("rol->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $rolDescripcion=$this->getRolDescripcion();
        $sql = "INSERT INTO rol(idRol, rolDescripcion) VALUES('$idRol','$rolDescripcion')";
        if ($base->Iniciar()) {
            if ($idRol = $base->Ejecutar($sql)) {
                $this->setIdRol($idRol);
                $resp = true;
            } else {
                $this->setmensajeoperacion("rol->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("rol->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $rolDescripcion=$this->getRolDescripcion();
        $sql = "UPDATE  SET rolDescripcion ='$rolDescripcion' WHERE idRol='$idRol'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Rol->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $sql = "DELETE FROM rol WHERE idRol='$idRol'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->eliminar: " . $base->getError());
        }
        return $resp;
    }

 

}

?>