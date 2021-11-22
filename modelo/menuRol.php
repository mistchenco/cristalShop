<?php

class menuRol
{

    //Atributos (Politica un usuario puede tener un solo rol, por eso se implementa el objRol y no coleccion de Roles)
    private $objMenu;
    private $objRol;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->objMenu;
        $this->objRol;
    }

    public function setear($datos)
    {
        $this->setObjMenu($datos['objMenu']);
        $this->setObjRol($datos['objRol']);
    }

    //GETTERS
    public function getObjMenu()
    {
        return $this->objMenu;
    }
    public function getObjRol()
    {
        return $this->objRol;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }


    //SETTERS
    public function setObjMenu($objMenu)
    {
        $this->objMenu = $objMenu;

        return $this;
    }
    public function setObjRol($objRol)
    {
        $this->objRol = $objRol;

        return $this;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;

        return $this;
    }


    //CONSULTAS A BBDD
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objMenu = $this->getObjMenu();
        $idMenu = $objMenu->getIdMenu();
        $objRol = $this->getObjRol();
        $idRol = $objRol->getIdRol();
        $sql = "SELECT * FROM menurol 
                WHERE idmenu = '$idMenu' AND idRol = '$idRol'";

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $menu = new usuario();
                    $rol = new rol();
                    $menu->setIdMenu($row["idMenu"]);
                    $menu->cargar();
                    $rol->setIdRol($row["idRol"]);
                    $rol->cargar();

                    $this->setear(['objMenu' => $menu, 'objRol' => $rol]);
                }
            }
        } else {
            $this->setmensajeoperacion("MenuRol->listar: " . $base->getError());
        }
        return $resp;
    }

    public static function  listar($condicion = "")
    {

        $arregloUsuarioRol = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";
        if ($condicion != "") {
            $sql = $sql . ' where ' . $condicion;
        }


        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $objMenuRol = new menuRol();

                    $objMenu = new menu();
                    $objMenu->setIdMenu($row['idmenu']);
                    $objMenu->cargar();

                    $objRol = new rol();
                    $objRol->setIdRol($row['idRol']);
                    $objRol->cargar();

                    $objMenuRol->setear(['objMenu' => $objMenu, 'objRol' => $objRol]);

                    array_push($arregloUsuarioRol, $objMenuRol);
                }
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->listar: " . $base->getError());
        }
        return $arregloUsuarioRol;
    }


    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $objMenu = $this->getObjMenu();
        $idMenu = $objMenu->getIdMenu();
        $objRol = $this->getObjRol();
        $idRol = $objRol->getIdRol();
        $sql = "INSERT INTO menurol(idmenu, idRol) VALUES ('$idMenu', '$idRol')";

        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                //$this->setId($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("MenuRol->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("MenuRoll->insertar: " . $base->getError());
        }

        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objMenu = $this->getObjMenu();
        $idMenu = $objMenu->getIdMenu();
        $objRol = $this->getObjRol();
        $idRol = $objRol->getIdRol();
        $sql = "UPDATE menurol SET idmenu = '$idMenu', idRol = '$idRol' WHERE idmenu = '$idMenu' AND idRol = '$idRol'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion("MenuRol->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("MenuRol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        $objMenu = $this->getObjMenu();
        $idMenu = $objMenu->getIdMenu();
        $objRol = $this->getObjRol();
        $idRol = $objRol->getIdRol();
        if ($base->Iniciar()) {
            $sql = "DELETE FROM menurol WHERE idmenu = '$idMenu' AND idRol = '$idRol'";
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion("MenuRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("MenuRol->eliminar: " . $base->getError());
        }
        return $resp;
    }
}
