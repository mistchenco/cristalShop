<?php

class producto{

    private $idProducto; 
    private $productoNombre;
    private $productoDetalle; 
    private $productoStock;
    private $productoPrecio;   
    private $mensajeOperacion; 

    public function __construct(){
        $this->idProducto = '';
        $this->productoNombre = '';
        $this->productoDetalle = '';
        $this->productoPrecio = '';
        $this->productoStock = ''; 
        $this->mensajeOperacion = '';
    
    }
    public function setear($datos){
        $this->setIdProducto($datos['idProducto']);
        $this->setProductoNombre($datos['productoNombre']);
        $this->setProductoDetalle($datos['productoDetalle']);
        $this->setProductoPrecio($datos['productoPrecio']);
        $this->setProductoStock($datos['productoStock']);
    }

    // METODOS SETTERS
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function setProductoNombre($productoNombre){
        $this->productoNombre = $productoNombre;
    }
    public function setProductoDetalle($productoDetalle){
        $this->productoDetalle = $productoDetalle;
    }
    public function setProductoPrecio($productoPrecio){
        $this->productoPrecio = $productoPrecio;
    }
    public function setProductoStock($productoStock){
        $this->productoStock = $productoStock;
    }
    // METODOS GETTERS
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function getIdProducto(){
        return $this->idProducto;
    }
    public function getProductoNombre(){
        return $this->productoNombre;
    }
    public function getProductoDetalle(){
        return $this->productoDetalle;
    }
    public function getProductoStock(){
        return $this->productoStock;
    }
    public function getProductoPrecio(){
        return $this->productoPrecio;
    }
    
    
// CONSULTAS A LA BASE DE DATOS
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idProducto = $this->getIdProducto();
        $sql = "SELECT * 
                FROM producto 
                WHERE idProducto = '$idProducto'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear(['idProducto'=>$row['idProducto'],'productoNombre'=>$row['productoNombre'],'productoDetalle'=>$row['productoDetalle'], 'productoStock'=>$row['productoStock'], 'productoPrecio'=>$row['productoPrecio']]);
                }
            }
        } else {
            $this->setMensajeoperacion("producto->cargar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new producto();
                    $obj->setear(['idProducto'=>$row['idProducto'],'productoNombre'=>$row['productoNombre'],'productoDetalle'=>$row['productoDetalle'], 'productoStock'=>$row['productoStock'], 'productoPrecio'=>$row['productoPrecio']]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("producto->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();

        $productoDetalle = $this->getProductoDetalle();
        $productoNombre = $this->getProductoNombre();
        $productoPrecio = $this->getProductoPrecio();
        $productoStock = $this->getProductoStock();

        $sql = "INSERT INTO producto(productoNombre, productoDetalle , productoStock , productoPrecio) 
                VALUES('$productoNombre','$productoDetalle' , '$productoStock' , $productoPrecio)";
        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdProducto($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("producto->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idProducto = $this->getIdProducto();
        $productoNombre = $this->getProductoNombre();
        $productoDetalle = $this->getProductoDetalle();
        $productoPrecio = $this->getProductoPrecio();
        $productoStock = $this->getProductoStock(); 
        $sql = "UPDATE producto 
                SET productoNombre ='$productoNombre', 
                    productoDetalle = '$productoDetalle', 
                    productoPrecio = '$productoPrecio',
                    productoStock = '$productoStock'
                WHERE idProducto = '$idProducto'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idProducto = $this->getIdProducto();
        $sql = "DELETE  
                FROM producto 
                WHERE idProducto = '$idProducto'";
          
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminar: " . $base->getError());
        }
        return $resp;
    }


    
}

?>