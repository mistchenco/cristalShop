<?php
class session
{

    //CONSTRUCTOR
    public function __construct()
    {
        session_start();
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados
     */
    public function iniciar($usNombre, $usPass)
    {
        $exito = false;
        $usPass = md5($usPass);

        if ($this->validar($usNombre, $usPass)) {

            $exito = true;
        }
        return $exito;
    }

    /**
     *  Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar($usNombre, $usPass)
    {
        $exito = false;
        $abmUs = new abmUsuario();
        $listaUsuario = $abmUs->buscar(['usNombre' => $usNombre, 'usPass' => $usPass]);

        if (count($listaUsuario) > 0) {
            if ($listaUsuario[0]->getUsDesabilitado() == NULL || $listaUsuario[0]->getUsDesabilitado() == "0000-00-00 00:00:00") {
                $_SESSION['idUsuario'] = $listaUsuario[0]->getIdUsuario();

                $exito = true;
            }
        }
        return $exito;
    }

    /**
     * Devuelve true o false si la sesión está activa o no.
     */
    public function activa()
    {
        $activa = false;
        if (isset($_SESSION['idUsuario'])) {
            $activa = true;
        }
        return $activa;
    }

    /**
     * Devuelve el usuario logeado
     */
    public function getUsuario(){

        $usuario = null;
        $abmUs = new abmUsuario();
        $list = $abmUs->buscar(['idUsuario' => $_SESSION['idUsuario']]);
        if (count($list) > 0) {
            $usuario = $list[0];
        }
        return $usuario;
    }
    /**
     * Devuelve el rol del usuario logeado
     */
    public function getRol()
    {
        $roles = array();
        $abmUR = new abmUsuarioRol();
        $abmR = new abmRol();
        $uss = $this->getUsuario();
        $list = $abmUR->buscar(['idUsuario' => $uss->getIdUsuario()]);

        if (count($list) > 0) {
            foreach ($list as $UR) {
                $objRol = $abmR->buscar(['idRol' => $UR->getObjRol()->getIdRol()]);

                array_push($roles, $objRol[0]);
            }
        }
        return $roles;
    }

    /**
     * Cierra la sesión actual
     */
    public function cerrar()
    {
        $close = false;
        if (session_destroy()) {
            $close = true;
        }
        return $close;
    }
}
