<?php

class abmProducto
{
    public function subirArchivo($datos)
    {


        // print_r($datos);
        $nombreArchivoImagen = $datos . ".jpg";
        $dir = '../assets/img/imagenesProductos/';

        $error = "";
        $todoOK = true;

        /*Primero subamos la imagen*/
        /*Veamos si se pudo subir a la carpeta temporal*/
        if ($_FILES["productoImagen"]["error"] <= 0) {
            $todoOK = true;
            $error = "";
        } else {
            $todoOK = false;
            $error = "ERROR: no se pudo cargar el archivo de imagen. No se pudo acceder al archivo Temporal";
        }

        //El control del tipo ya lo tengo en el formulario, asi que no lo voy a controlar acá.
        //Si, voy a controlar el tema del tamaño

        if ($todoOK && $_FILES['productoImagen']["size"] / 1024 > 300) {
            $error = "ERROR: El archivo " . $nombreArchivoImagen . " supera los 300 KB.";
            $todoOK = false;
        }

        if ($todoOK && !copy($_FILES['productoImagen']['tmp_name'], $dir . $nombreArchivoImagen)) {
            $texto = "ERROR: no se pudo cargar el archivo de imagen.";
            $todoOK = false;
        }
        return $todoOK;
    }

    public function obtenerArchivos($idProducto)
    {
        $directorio = '../assets/img/imagenesProductos/' . $idProducto . ".jpg";

        return $directorio;
    }
    public function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idProducto', $param) and
            array_key_exists('productoNombre', $param) and
            array_key_exists('productoDetalle', $param) and
            array_key_exists('productoStock', $param) and
            array_key_exists('productoPrecio', $param)
        ) {
            $obj = new producto();
            $obj->setear([
                'idProducto' => $param['idProducto'],
                'productoNombre' => $param['productoNombre'],
                'productoDetalle' => $param['productoDetalle'],
                'productoStock' => $param['productoStock'],
                'productoPrecio' => $param['productoPrecio']
            ]);
        }

        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    public function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param)) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    public function altaImagen($objProducto, $param)
    {
        $directorio = md5($objProducto->getIdProducto());

        mkdir($GLOBALS['IMAGENES'] . $directorio, 0777);
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
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
    public function buscar($param = '')
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idProducto']))
                $where .= ' and idProducto = ' . "'" . $param['idProducto'] . "'";
            if (isset($param['productoNombre']))
                $where .= ' and productoNombre = ' . "'" . $param['productoNombre'] . "'";
            if (isset($param['productoDetalle']))
                $where .= ' and productoDetalle =' . "'" . $param['productoDetalle'] . "'";
            if (isset($param['productoStock']))
                $where .= ' and productoStock =' . "'" . $param['productoStock'] . "'";
            if (isset($param['productoPrecio']))
                $where .= ' and productoPrecio =' . "'" . $param['productoPrecio'] . "'";
        }
        $arreglo = producto::listar($where);
        return $arreglo;
    }
}
