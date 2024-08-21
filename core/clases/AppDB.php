<?php
namespace core\clases;
use core\clases\ConectorDB as ConectorDB;
use core\clases\ManejadorErrores as ManejadorErrores;


class AppDB extends ConectorDB{
    
    protected $conexion;
    protected $query;
    protected $resultado;
    
    public function __construct(){
        $this->conexion = ConectorDB::Conectar(SERVIDOR, USUARIO, CLAVE, BASE);
    }
    

    public function Select($query){
        return $this->conexion->Select($query);
    }
    
    public function Insert($query){
        return $this->conexion->Insert($query);
    }
    
    public function UpdateDelete($query){
        return $this->conexion->UpdateDelete($query);
    }

    public function SubSanarString($string){
        return $this-> conexion ->Subsanar($string);
    }
}