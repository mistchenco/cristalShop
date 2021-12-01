<?php
    error_reporting(0);
class session{
    private $objUsuario;
    private $coleccionRol;
    private $coleccionItems;
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
     * Devuelve el rol activo del usuario logueado como arreglo
     */
    public function getRolActivo(){
        return $_SESSION['rolactivo'];
    }

    public function buscarRolActivo(){
        // echo "entra a rol activo";
        $abmRol = new abmRol();
        $idRol=$_SESSION['rolactivo']->getIdRol();
     
        $rol = $abmRol->buscar(["idRol" => $idRol]);
        return $rol[0];
    }

    public function setRolActivo($idrol){
       
       
    $_SESSION['rolactivo'] = $idrol;
            
        
        return $_SESSION['rolactivo'];
    }


    /**
     *  Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar($usNombre, $usPass)
    {
        $coleccionRol = [];
        $objUsuario = '';
        $exito = false;
        $abmUs = new abmUsuario();
        $listaUsuario = $abmUs->buscar(['usNombre' => $usNombre, 'usPass' => $usPass]);
        // print_r($listaUsuario);
        if (count($listaUsuario) > 0) {
            if ($listaUsuario[0]->getUsDesabilitado() == NULL || $listaUsuario[0]->getUsDesabilitado() == "0000-00-00 00:00:00") {
                $_SESSION['idUsuario'] = $listaUsuario[0]->getIdUsuario();
                // $objRol= new abmRol;
                // $listaRoles = $objRol->buscar("");
                 $_SESSION['rolactivo'] = array();
                // $_SESSION["rolactivo"] = $listaRoles[0]['idRol'];
                $_SESSION['coleccionItems'] = array();
                
                $valido = true;
                $exito = true;
                //invocar funcion que calcule los atributos
                // $objUsuario = $this->buscarUsuario();
                // $this->setObjUsuario($objUsuario);
                // $coleccionRol = $this->buscarRol();
                // $this->setColeccionRol($coleccionRol);
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
    public function getCarrito(){
        return $_SESSION['coleccionItems'];
    }




    public function agregarColeccionItems($param){
        $abmProducto = new abmProducto();
        $listaProductos = $abmProducto->buscar($param);
        if(count($listaProductos) > 0){
            $objProducto = $listaProductos[0];
            //Si el carrito es nulo o no posee objetos le carga el primero 
            if ($_SESSION['coleccionItems'] == null ) {
                $datosCompra=[ 
                    'idProducto' => $objProducto->getIdProducto(), 
                    'productoNombre' => $objProducto->getProductoNombre(), 
                    'productoDetalle' => $objProducto->getProductoDetalle(), 
                    'productoPrecio' => $objProducto->getProductoPrecio(), 
                    'cantidadCompra' => $param['compraItemCantidad'] 
                ]; 
                $_SESSION['coleccionItems'][] = $datosCompra; 
                $this->setColeccionItems($_SESSION['coleccionItems']); 
            }else{
                $carrito = $this->getCarrito();
                array_values($carrito);
                $bandera= false;
                for ($i=0; $i < count($carrito); $i++) { 
                    //Si el objeto que se quiere cargar en el carrito ya se encuentra
                    //solamente se le suma la nueva cantidad y se setea ese objeto en el carrito
                    if ($carrito[$i]['idProducto'] == $param['idProducto'] ) {
                        $bandera = true;
                        $carrito[$i]['cantidadCompra'] = $carrito[$i]['cantidadCompra'] + $param['compraItemCantidad'];
                        $_SESSION['coleccionItems'][$i] = $carrito[$i];
                        $this->setColeccionItems($_SESSION['coleccionItems']); 
                    }
                }
                //si no se encuentra en la coleccion lo carga en la misma
                if ($bandera == false){
               
                        $datosCompra=[ 
                            'idProducto' => $objProducto->getIdProducto(), 
                            'productoNombre' => $objProducto->getProductoNombre(), 
                            'productoDetalle' => $objProducto->getProductoDetalle(), 
                            'productoPrecio' => $objProducto->getProductoPrecio(), 
                            'cantidadCompra' => $param['compraItemCantidad'] 
                        ]; 
                        $_SESSION['coleccionItems'][] = $datosCompra; 
                        $this->setColeccionItems($_SESSION['coleccionItems']); 
                    
                }
            }
        }else{
            echo 'No se ha encontrado el producto';
        }
    }





    /**
     * Devuelve el usuario logeado
     */
    public function getObjUsuario(){

        $usuario = null;
        $abmUs = new abmUsuario();
        $list = $abmUs->buscar(['idUsuario' => $_SESSION['idUsuario']]);
        if (count($list) > 0) {
            $usuario = $list[0];
        }
        return $usuario;
    }
    /**
     * Devuelve el rol del usuario logeado ver cambiar el nombre y volver a probar
     */
    public function getColeccionRol(){
        $roles = array();
        $abmUR = new abmUsuarioRol();
        $abmR = new abmRol();
        $uss = $this->getObjUsuario();
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


    public function setColeccionRol($coleccionRol)
    {
        $this->coleccionRol = $coleccionRol;

    }

    
    public function setObjUsuario($objUsuario)
    {
        $this->objUsuario = $objUsuario;
    }

  
    /**
     * Set the value of coleccionItems
     *
     * @return  self
     */ 
    public function setColeccionItems($coleccionItems){
        $_SESSION['coleccionItems'] = $coleccionItems;
    }


    public function accionBorrarProductoCarrito($datos){
        $arreglo = $this->getCarrito();
        $arreglo = array_values($arreglo); 
        for ($i=0; $i < count($arreglo); $i++) { 
            if ($datos['idProducto'] == $arreglo[$i]['idProducto'] ) {
                unset($arreglo[$i]);
                $this->setColeccionItems($arreglo);
            }
        }
        $arreglo = array_values($arreglo);
        $mensaje = "Producto borrado del carrito";
        return $mensaje; 
    }


    public function accionCrearCompra($datos){
        $objUsuario = $this->getObjUsuario();
        $listaCarrito = $this->getCarrito();
        $objabmCompraItem = new abmCompra();
        $llenarCarrito = $objabmCompraItem->altaCompra($listaCarrito, $objUsuario);
        if($llenarCarrito){
            $this->setColeccionItems($coleccionItems = []);
            $mensaje = "Su compra fue realizada con exito, muchas gracias!";
        }else{
            $mensaje = "Su compra no pudo ser realizada, disculpe las molestias";
        }
        return $mensaje;
    }


}
