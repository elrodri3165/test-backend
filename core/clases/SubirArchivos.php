<?php
/****************************~WebMaker core MVC~************************************/
/*~ Librería de clase proyecto WebMaker
/*~ SubirArchivos.php
/*~ VERSION 1.0
/*~ 21/02/2022
/*~ Autor: Gallo Rodrigo Nicolas. RGweb.com.ar

COMENTARIOS

/****************************~WebMaker core MVC~************************************/
//require 'ClienteDB.php';

namespace core\clases;

class SubirArchivos extends AppDB{
    
    private $tabla;
    private $nombre;
    private $carpeta = ROOT."img/";
    //el name del imput files
    private $name; 
    //agregar las extensiones que se quieran aceptar en el array
    private $extension = array("jpg", "gif", "png", "jpeg");
    //setear peso maximo por defecto esta hasta 6mb
    private $pesomax = 6000000;
    
    
    function __construct($tabla = null, $carpeta = null, $name = 'Foto'){
        $this->name = $name;
        $this->nombre = $_FILES[$this->name]['name'];
        
        if ($this->carpeta != null){
            $this->carpeta .= $carpeta."/";
        }
        
        if ($this->tabla != null){
            $this->tabla = $tabla;
        }
        
        echo $this->carpeta;
    }
    
    
    
    public function Subir(){
        if ($this->ControlExt() == true && $this->ControlPeso() == true){
            if (opendir($this->carpeta)==false){
                mkdir($this->carpeta, 0777, true);
            }
            $destino = $this->carpeta.$_FILES[$this->name]['name'];
            copy ($_FILES[$this->name]['tmp_name'], $destino);
            if (move_uploaded_file($_FILES['Foto']['tmp_name'], $destino)) {
                echo "El fichero es válido y se subió con éxito.\n";
                return true;
            }
            else {
                echo "¡Posible ataque de subida de ficheros!\n";
                return false;
            }    
        }else{
            echo "El fichero tiene una extensión no válida o es muy pesado.\n";
            return false;
        }
    }
    
    private function Insert(){
        $this-> conexion = new AppDB();
        $this-> resultado = $this->conexion-> Ejecutaquery($this->query);
        return $this->resultado;
    }
    
    private function ControlExt(){
        $extension = substr($this->nombre, -3);
        $extensionjpeg= substr($this->nombre, -4);

        $extension = strtolower($extension); //saco la mayuscula aca para no sacarla 4 veces en cada if
        $extensionjpeg = strtolower($extensionjpeg); //saco la mayuscula aca para no sacarla 4 veces en cada if
    
        foreach ($this->extension as $ext){
            if ($extension == $ext || $extensionjpeg == $ext){
               return true;
            }
        }
        return false;
        
    }
    
    
    private function ControlPeso(){
        $peso = $_FILES[$this->name]['size'];
        if ($peso <= $this->pesomax){
            return true;
        }
        else return false;
    }
    
    
}