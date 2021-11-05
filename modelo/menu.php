<?php

class menu
{
    private $idMenu;
    private $menuNombre;
    private $menuDescripcion;
    private $objPadre; 
    private $menuDeshabilitado;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idMenu = '';
        $this->menuNombre = '';
        $this->menuDescripcion = '';
        $this->objPadre = '';
        $this->menuDeshabilitado = '';
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
        $idMenu = $this->getIdMenu();
        $sql = "SELECT * FROM menu WHERE idMenu = '.$idMenu.'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);

            if ($res > -1) {
                if ($res > 0) {

                    $row = $base->Registro();

                    $this->setear(['idMenu' => $row['idMenu'], 'menuNombre' => $row['menuNombre'], 'menuDescripcion' => $row['menuDescripcion'], 'objPadre' => $row['idPadre'], 'menuDeshabilitado' => $row['menuDeshabilitado']]);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
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
                //Aca no llega, no tengo ni idea
                while ($row = $base->Registro()) {
                    $objMenu = new menu();
                    $objPadre = new menu();
                    $objPadre->setIdMenu($row['idPadre']);
                    $objPadre->cargar();
                    $objMenu->setear(['idMenu' => $row['idMenu'], 'menuNombre' => $row['menuNombre'], 'menuDescripcion' => $row['menuDescripcion'], 'objPadre' => $objPadre, 'menuDeshabilitado' => $row['menuDeshabilitado']]);
                    array_push($arreglo, $objMenu);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: " . $base->getError());
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
        $idPadre = $this->getObjPadre()->getIdMenu();
        $menuDeshabilitado = $this->getMenuDeshabilitado();
        //como la tabla menu es autoincrement no le pasamos ID
        $sql = "INSERT INTO menu(menuNombre, menuDescripcion, idPadre, menuDeshabilitado)
        VALUES ('$menuNombre', '$menuDescripcion', '$idPadre', '$menuDeshabilitado')";

        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
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
        $objPadre = $this->getObjPadre()->getIdMenu();
        $menuDeshabilitado = $this->getMenuDeshabilitado();

        $sql = "UPDATE menu SET menuNombre = '$menuNombre', menuDescripcion = '$menuDescripcion', objPadre = '$objPadre', menuDeshabilitado = '$menuDeshabilitado' WHERE idMenu = '$idMenu'";

        
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
