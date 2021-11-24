<?php
class compraItem
{
    private $idCompraItem;
    private $objProducto;
    private $idCompra;
    //objCompra
    private $compraItemCantidad;
    private $mensajeOperacion; 


    public function __construct()
    {
        $this->idCompraItem;
        $this->objProducto;
        $this->idCompra;
        $this->compraItemCantidad;
        $this->mensajeOperacion = '';
    }
    public function setear($datos)
    {
        $this->setIdCompraItem($datos['idCompraItem']);
        $this->setObjProducto($datos['objProducto']);
        $this->setIdCompra($datos['idCompra']);
        $this->setCompraItemCantidad($datos['compraItemCantidad']);
    }

    //METODOS GETTERS

    public function getIdCompra()
    {
        return $this->idCompra;
    }
    public function getObjProducto()
    {
        return $this->objProducto;
    }
    public function getCompraItemCantidad()
    {
        return $this->compraItemCantidad;
    }

    public function getIdCompraItem()
    {
        return $this->idCompraItem;
    }

    //METODOS SETTERS
    public function setIdCompraItem($idCompraItem)
    {
        $this->idCompraItem = $idCompraItem;

        return $this;
    }

    public function setObjProducto($objProducto)
    {
        $this->objProducto = $objProducto;

        return $this;
    }

    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;

        return $this;
    }

    public function setCompraItemCantidad($compraItemCantidad)
    {
        $this->compraItemCantidad = $compraItemCantidad;

        return $this;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }


    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idCompraItem=$this->getIdCompraItem();
        $sql = "SELECT * FROM compraitem WHERE idCompraItem = '$idCompraItem'";

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $producto = new producto();
                    $producto->setIdProducto($row["idProducto"]);
                    $producto->cargar();
                    $this->setear(['idCompraItem'=>$row['idCompraItem'],'objProducto'=>$row['idProducto'],'idCompra' => $row['idCompra'], 'compraItemCantidad'=>$row['compraItemCantidad']]);
                }
            }
        } else {
            $this->setmensajeOperacion("compra->listar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {

        $arreglo = array();
        $base = new BaseDatos();
          $sql = "SELECT * FROM compraItem ";
        if ($parametro != "") {
            $sql = $sql . ' WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res >= 0) {
                
                while ($row = $base->Registro()) {
                    $obj = new compraItem();
                    $producto = new producto();
                    $producto->setIdProducto($row["idProducto"]);
                    $producto->cargar();
                    //CAMBIAMOS  $row["idProducto"] POR $producto en linea 129
                    $obj->setear(['idCompraItem'=>$row['idCompraItem'],'objProducto'=>$producto,'idCompra' => $row['idCompra'], 'compraItemCantidad'=>$row['compraItemCantidad']]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("compraItem->insertar: " . $base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $idCompra=$this->getIdCompra();
        $objProducto=$this->getObjProducto();
        $idProducto=$objProducto->getIdProducto();
        $compraItemCantidad=$this->getCompraItemCantidad();
        $sql = "INSERT INTO compraItem(idProducto,idCompra,compraItemCantidad)
            VALUES ('$idProducto', '$idCompra','$compraItemCantidad')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompra($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $base = new BaseDatos();
        $resp = false;
        $idCompraItem=$this->getIdCompraItem();
        $idCompra=$this->getIdCompra();
        $objProducto=$this->getObjProducto();
        $idProducto=$objProducto->getIdProducto();
        $compraItemCantidad=$this->getCompraItemCantidad();
        //preguntar idIncremental
        $sql = "UPDATE compraItem SET idCompraItem = '$idCompraItem', idProducto = '$idProducto', idCompra = '$idCompra', compraItemCantidad='$compraItemCantidad' WHERE idCompraItem = '$idCompraItem'";  
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
        }
        return $resp;
    }
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        $idCompraItem=$this->getIdCompraItem();
       
        if ($base->Iniciar()) {
            $sql = "DELETE FROM compraItem WHERE idCompraItem = '$idCompraItem'";
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->eliminar: " . $base->getError());
        }
        return $resp;
    }

    
}
