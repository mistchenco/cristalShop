<?php

class menu
{
    private $idMenu;
    private $menuNombre;
    private $menuDescripcion;
    private $objPadre; //preguntar si es un obj y como seria
    private $menuDeshabilitado;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idMenu = '';
        $this->menuNombre = '';
        $this->menuDescripcion = '';
        $this->objPadre = null;
        $this->menuDeshabilitado = null;
        $this->mensajeOperacion = '';
    }
    // Metodos Setters
    public function setear($datos)
    {
        $this->setIdMenu($datos['idMenu']);
        $this->setMenuNombre($datos['menuNombre']);
        $this->setMenuDescripcion($datos['menuDescripcion']);
        $this->setObjPadre($datos['objPadre']);
        $this->setMenuDeshabilitado($datos['menuDeshabilitado']);
    }


    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
    }
    public function setMenuNombre($menuNombre)
    {
        $this->menuNombre = $menuNombre;
    }
    public function setMenuDescripcion($menuDescripcion)
    {
        $this->menuDescripcion = $menuDescripcion;
    }

    public function setObjPadre($objPadre)
    {
        $this->objPadre = $objPadre;
    }
    public function setMenuDeshabilitado($menuDeshabilitado)
    {
        $this->menuDeshabilitado = $menuDeshabilitado;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // Metodos Getters
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    public function getMenuNombre()
    {
        return $this->menuNombre;
    }

    public function getMenuDescripcion()
    {
        return $this->menuDescripcion;
    }

    public function getObjPadre()
    {
        return $this->objPadre;
    }

    public function getMenuDeshabilitado()
    {
        return $this->menuDeshabilitado;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    // Consultas a la Base de Datos

    public function cargar()
    {
        
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idMenu = " . $this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);

            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objPadre = null;
                    if ($row['idPadre']!=null or $row['idPadre']!='') {
                        $objPadre = new menu();
                        $objPadre->setIdMenu($row['idPadre']);
                        $objPadre->cargar();
                        $datos = ['idMenu' => $row['idMenu'], 'menuNombre' => $row['menuNombre'], 'menuDescripcion' => $row['menuDescripcion'], 'objPadre' => $objPadre, 'menuDeshabilitado' => $row['menuDeshabilitado']];
                        $this->setear($datos);
                    }
                }
            } else {
                $this->setMensajeOperacion("menu->listar: " . $base->getError());
            }
            return $resp;
        }
    }

    public static function listar($parametro="")
    {
        
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";
        if ($parametro != "") {
            $sql = $sql . 'WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);

        if ($res > -1) {
            if ($res >= 0) {
                
                while ($row = $base->Registro()) {
                    $obj = new menu();
                    $objPadre = null;
                    if ($row['idPadre']!=null){
                        $objPadre = new menu();
                        $objPadre->setIdmenu($row['idPadre']);
                        $objPadre->cargar();
                    }
                    
                    $datos = ['idMenu' => $row['idMenu'], 'menuNombre' => $row['menuNombre'], 'menuDescripcion' => $row['menuDescripcion'],'objPadre'=> $objPadre, 'menuDeshabilitado' => $row['menuDeshabilitado']];
                    
                    $obj->setear($datos);
                 
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("menu->listar: " . $base->getError());
        }

        return $arreglo;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;

        $idMenu = $this->getIdMenu();
        $menuNombre = $this->getMenuNombre();
        $menuDescripcion = $this->getMenuDescripcion();
        $idPadre = $this->getIdPadre();
        $menuDeshabilitado = $this->getMenuDeshabilitado();
        //Preguntar si ponemos el id del menu
        $sql = "INSERT INTO menu(idMenu,menuNombre, menuDescripcion, idPadre, menuDeshabilitado)";
        $sql.="VALUES ('".$this->getMenuNombre()."','".$this->getMenuDescripcion()."',";
            if ($this->getObjPadre()!= null)
                $sql.=$this->getObjPadre()->getIdmenu().",";
            else
                $sql.="null,";
            if ($this->getMedeshabilitado()!=null)
                $sql.= "'".$this->getMedeshabilitado()."'";
            else 
            $sql.="null";
        $sql.= ");";   

        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("menu->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->insertar: " . $base->getError());
        }

        return $resp;
    }


    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idMenu = $this->getIdMenu();
        $menuNombre = $this->getMenuNombre();
        $menuDescripcion = $this->getMenuDescripcion();
    
        $sql = "UPDATE menu SET menuNombre = '$menuNombre', menuDescripcion = '$menuDescripcion', ";

         if ($this->getObjPadre()!= null)
            $sql.=",idpadre= ".$this->getObjPadre()->getIdmenu();
         else
            $sql.=",idpadre= null";
         if ($this->getMedeshabilitado()!=null)
             $sql.= ",menuDeshabilitado='".$this->getMenuDeshabilitado()."'";
         else
              $sql.=" ,menuDeshabilitado=null";
        $sql.= " WHERE idmenu = ".$this->getIdmenu();
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion("menu->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        $idMenu = $this->getIdMenu();
        if ($base->Iniciar()) {
            $sql = "DELETE FROM menu WHERE idMenu = '$idMenu'";
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion("menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->eliminar: " . $base->getError());
        }
        return $resp;
    }
}

?>