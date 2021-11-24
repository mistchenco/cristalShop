<?php
class compra
{
    private $idCompra;
    private $compraFecha;
    private $objUsuario;
    private $coleccionItems;
    private $mensajeOperacion;
    public function __construct()
    {
        $this->mensajeOperacion="";
        $this->idCompra = 0;
        $this->compraFecha = '';
        $this->objUsuario = '';
        $this->coleccionItems = [];
    }

    public function setear($datos)
    {
        $this->setIdCompra($datos['idCompra']);
        $this->setCompraFecha($datos['compraFecha']);
        $this->setObjUsuario($datos['objUsuario']);
        $this->setColeccionItems($datos['coleccionItems']);
    }

    //METODOS GETTERS
    
    public function getObjUsuario()
    {
        return $this->objUsuario;
    }

    public function getCompraFecha()
    {
        return $this->compraFecha;
    }

    public function getIdCompra()
    {
        return $this->idCompra;
    }
    public function getColeccionItems()
    {
        
        
        return $this->coleccionItems;
    }
    //METODOS SETERS
    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;
    }

    public function setCompraFecha($compraFecha)
    {
        $this->compraFecha = $compraFecha;
    }

    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }

    public function setColeccionItems($coleccionItems)
    {
        $this->coleccionItems = $coleccionItems;
    }
    public  function setmensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion=$mensajeOperacion;
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idCompra=$this->getIdCompra();
        $sql = "SELECT * FROM compra WHERE idCompra = '$idCompra'";

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $usuario = new usuario();
                    $usuario->setIdUsuario($row["idUsuario"]);
                    $usuario->cargar();
                    $idCompra = $this->setIdCompra($row['idCompra']);
                    $compraItem = new compraItem();

                    $datosCompra = [
                        'idCompra' => $row['idCompra']
                    ];
                    $objCompraItem = new abmCompraItem();
                    $coleccionCompraItems = $objCompraItem->buscar($datosCompra);
                    $this->setColeccionItems($coleccionCompraItems);
                    $coleccionItems = $this->getColeccionItems();

                    $this->setear(['idCompra'=>$row['idCompra'],'compraFecha'=>$row['compraFecha'],'objUsuario' => $usuario , 'coleccionItems' => $coleccionItems]);
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


        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql = $sql . ' WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res >= 0) {
                
                while ($row = $base->Registro()) {
                    $obj = new compra();
                    $usuario = new usuario();
                    $usuario->setIdUsuario($row["idUsuario"]);
                    $usuario->cargar();

                    // $idCompra = $row['idCompra'];
                    $datosCompra = [
                        'idCompra' => $row['idCompra']
                    ];
                    $objCompraItem = new abmCompraItem();
                    $coleccionCompraItems = $objCompraItem->buscar($datosCompra);

                    $datos = ['idCompra' => $row['idCompra'],
                    'compraFecha' => $row['compraFecha'],
                    'objUsuario' => $usuario, 
                    'coleccionItems' => $coleccionCompraItems];
                    
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }

        return $arreglo;
    }


    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
       
        $compraFecha=$this->getCompraFecha();
        $usuario=$this->getObjUsuario();
        $idUsuario=$usuario->getIdUsuario();
        
        
        $sql = "INSERT INTO compra(compraFecha,idUsuario)
            VALUES ('$compraFecha', '$idUsuario')";

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
        $idCompra=$this->getIdCompra();
        $compraFecha=$this->getCompraFecha();
        $usuario=$this->getObjUsuario();
        $idUsuario=$usuario->getIdUsuario();
        //preguntar idIncremental
        $sql = "UPDATE compra SET idCompra = '$idCompra', compraFecha = '$compraFecha', idUsuario = '$idUsuario' WHERE idCompra = '$idCompra'";  
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
        $idCompra=$this->getIdCompra();
       
        if ($base->Iniciar()) {
            $sql = "DELETE FROM compra WHERE idCompra = '$idCompra'";
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
