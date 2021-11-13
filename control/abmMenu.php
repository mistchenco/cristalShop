<?php
class abmMenu{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Tabla
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idmenu',$param) and array_key_exists('menuNombre',$param)){
            $obj = new menu();
            $objmenu = null;
            if (isset($param['idpadre'])){
                $objmenu = new menu();
                $objmenu->setIdmenu($param['idpadre']);
                $objmenu->cargar();
                
            }
            if(!isset($param['menudeshabilitado'])){
                $param['menuDeshabilitado']=null;
            }else{
                $param['menuDeshabilitado']= date("Y-m-d H:i:s");
            }
            $obj->setear($param['idmenu'], $param['menuNombre'],$param['menuDescripcion'],$objmenu,$param['menuDeshabilitado']); 
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['idmenu']) ){
            $obj = new menu();
            $obj->setIdmenu($param['idmenu']);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idmenu']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idmenu'] =null;
        $param['menuDeshabilitado'] = null;
        $elObjtTabla = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
        }
      return $resp;
     
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
      
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
       
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtMenu = $this->cargarObjeto($param);
            if($elObjtMenu!=null and $elObjtMenu->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        /*if ($param<>NULL){
            if  (isset($param['id']))
                $where.=" and id =".$param['id'];
            if  (isset($param['descrip']))
                 $where.=" and descrip ='".$param['descrip']."'";
        }*/
        $arreglo = menu::listar($where);  
        return $arreglo;
            
            
    
        
    }
   
}
?>