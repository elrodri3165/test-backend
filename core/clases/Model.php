<?php
namespace core\clases;

abstract class Model{

    
    public function __construct(){
    }
    
    public function Guardar(){
        $query = $this->CrearQuery('INSERT');
        $conexion = new AppDB();
        
        return $conexion ->Insert($query);
    }
    
    public function Actualizar($where){
        $query = $this->CrearQuery('UPDATE', $where);
        $conexion = new AppDB();
        
        return $conexion ->UpdateDelete($query);
    }

    public function ActualizarQuery($query){
        $conexion = new AppDB();
        
        return $conexion ->UpdateDelete($query);
    }
    
    public function Buscar($where = null){
        $query = $this->CrearQuery('SELECT');
        $conexion = new AppDB();
        
        return $conexion ->Select($query);
    }

    public function BuscarQuery($query){
        $conexion = new AppDB();
        
        return $conexion ->Select($query);
    }
    
    
    /*funcion de generar campos y valores*/
    private function CrearQuery($tipo, $where = null){
        $variables = get_object_vars($this);
        $tabla = $class_name = get_class($this);
        
        if ($tipo == 'SELECT'){
            $query = 'SELECT * FROM '.$tabla.' ';
            
            if ($variables != null){
                $where_parcial = ' WHERE ';
                $i = 1;
                $cantidad = count($variables);
                
                foreach ($variables as $variable => $valor){
                    $valor = $this->ComprobarTipo($valor);
                    if ($i < $cantidad){
                        $where_parcial .= $variable.' = '.$valor.' AND ';
                    }else{
                        $where_parcial .= $variable.' = '.$valor;
                    }
                $i++;
                }
                $query = $query.$where_parcial;
            }
            return $query;    
        }
        
        if($tipo == 'INSERT'){
            
            $campos = '(';
            $valores = '(';

            $i = 1;
            $cantidad = count($variables);
            foreach ($variables as $variable => $valor){
                
                $valor = $this->ComprobarTipo($valor);

                if ($i != $cantidad){
                    $campos .= $variable.', ';
                    $valores .= $valor.', ';
                    $i++;
                }else{
                    $campos .= $variable;
                    $valores .= $valor;
                }

            }
            $campos .= ')';
            $valores .= ')';

            return "INSERT INTO ".$tabla." ".$campos." VALUES ".$valores;
        }
        
        else if ($tipo == 'UPDATE'){
            $where = str_replace(" ", "", explode(',', $where));
            
            $campo_valor = 'UPDATE '.$tabla.' SET ';

            $i = 1;
            $no_where = 0;
            $cantidad = count($variables);
            
            if (count($where) == 1){
                $where = $where[0];
                    foreach ($variables as $variable => $valor){

                    $valor = $this->ComprobarTipo($valor);

                    if ($i != $cantidad){
                        if ($where == $variable){
                            $where = ' WHERE '.$variable.' = '.$valor;
                        }else{
                            $campo_valor .= $variable." = ".$valor.", ";
                            $no_where++;
                        }

                        $i++;
                    }else{
                        if ($where == $variable){
                            $where = ' WHERE '.$variable.' = '.$valor;
                        }else{
                            $campo_valor .= $variable." = ".$valor;
                            $no_where++;
                        } 
                    }
                }
            }else{ 
                $where_parcial = ' WHERE ';
                
                $total_where = count($where);
                $i_where = 1;
                foreach ($where as $row){
                    
                    foreach ($variables as $variable => $valor){
                        $valor = $this->ComprobarTipo($valor);
                        if ($row == $variable){
                            if($i_where < $total_where){
                                $where_parcial .= $variable.' = '.$valor.' AND ';
                            }else{
                                $where_parcial .= $variable.' = '.$valor;
                            }
                            unset($variables[$variable]);
                        }
                    }
                    $i_where++;
                }
                $i_where--;
                
                $i = 1;
                $cantidad_campos = $cantidad - $total_where;
                
                foreach ($variables as $variable => $valor){
                    $valor = $this->ComprobarTipo($valor);
                    
                    if ($i != $cantidad_campos){
                        $campo_valor .= $variable." = ".$valor.", ";
                        $no_where++;
                    }
                    else{
                        $campo_valor .= $variable." = ".$valor;
                            $no_where++;
                    }
                    $i++;
                }    
                
            }
            
            /* COMENTADA PORQUE DA ERROR
            if ($total_where != $i_where){
                die('ERROR: Alguna de las no variable cumple la condicion para WHERE');
            }
            */
            
            if ($cantidad == $no_where){
                die('ERROR: Ninguna variable cumple la condicion para WHERE');
            }
            
            if (isset($where_parcial)){
                return $campo_valor.$where_parcial;
            }else{
                return $campo_valor.$where;   
            }
        }
    }
    /*funcion de generar campos y valores*/
    
    /*funcion para selecionar el tipo, y agregar comillas si es nesesario*/
    private function ComprobarTipo($valor){
        $conex = new AppDB();

        if (is_int($valor) || is_float($valor) || is_bool($valor)) {
            return $valor;
        }
        else if (is_string($valor)){
            $valor = $conex->SubSanarString($valor);
            return "'".$valor."'";
        }
        else if ($valor === null || $valor === ''){
            return 'null';
        }
        else if ($valor instanceof \DateTime){
            return "'" . $valor->format('Y-m-d H:i:s') . "'";
        }else{
            // Manejar otros tipos de datos aquí, si es necesario
            // Por ejemplo, podrías lanzar una excepción o retornar un valor predeterminado
            return 'valor_desconocido';
        }
    }
    /*funcion para selecionar el tipo, y agregar comillas si es nesesario*/
}