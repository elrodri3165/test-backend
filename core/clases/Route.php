<?php
/****************************~WebMaker core MVC~************************************/
/*~ Librería de clase proyecto WebMaker
/*~ Route.php
/*~ VERSION 4.0
/*~ 21/02/2022
/*~ Autor: Gallo Rodrigo Nicolas. RGweb.com.ar

COMENTARIOS
VERSION 4.0. MEJORA DEL CONTROLADOR.
BUSCA PARÁMETROS TANTO AMIGABLES COMO CON ? Y LOS ENVIA COMO RESULTADO.

DENTRO DE ['friendly_parameters'] ESTAN LOS AMIGABLES.

FALTARIA CORREGIR EL ERROR DE LA RUTA
WEBMAKER/LOGIN?HOLA. -- NO TOMA EL LOGIN

/****************************~WebMaker core MVC~************************************/

namespace core\clases;

class Route{

    private $basepath;
    private $uri;
    private $base_url;
    private $routes;
    private $route;
    /*PARAMETROS EN LA URL*/
    private $params;
    
    /*PARAMETROS EN LA URL DE FORMA AMIGABLE*/
    private $frindly_parameters;
    
    /*BOOLEAN SI SE BUSCAN PARAMETROS O NO*/
    private $get_params;
    

    function __construct($get_params = false) {
        $this->get_params = $get_params;
        }

    public function getRoutes(){
        $this->base_url = $this->getCurrentUri();
        $this->routes = explode('/', $this->base_url);

        $this->getParams();
        $this->getFriendlyParams();
        return $this->routes;
        }

    private function getCurrentUri(){
        $this->basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $this->uri = substr($_SERVER['REQUEST_URI'], strlen($this->basepath));

        if($this->get_params){
            $this->getParams();
            }else{
            if (strstr($this->uri, '?')) $this->uri = substr($this->uri, 0, strpos($this->uri, '?'));
        }

        $this->uri = '/' . trim($this->uri, '/');
        return $this->uri;
        }

    private function getParams(){
        if (strstr($this->uri, '?')){
            $params = explode("?", $this->uri);
            $params = $params[1];

            parse_str($params, $this->params);
            $this->routes[0] = $this->params;
            array_pop($this->routes);
            }
        }
    
    private function getFriendlyParams(){
        if (isset($this->routes[2])){
            
            $arrayA = array();
            $arrayB = array();
            
            $this->frindly_parameters = array_slice($this->routes, 2, 11);
            
            for($i = 0; $i < count($this->frindly_parameters); $i++){
                
                if ($i % 2 == 0){
                    //es par
                    array_push($arrayA, $this->frindly_parameters[$i]);
                }else{
                    //es impar
                    array_push($arrayB, $this->frindly_parameters[$i]);
                }
            }
            
            if (count($arrayA) > count($arrayB)){
                array_push($arrayB, '');
            }
            
            $this->frindly_parameters = array_combine($arrayA, $arrayB);
            
            $this->frindly_parameters = [
                'friendly_parameters' => $this->frindly_parameters,
            ];
            
            $this->routes = array_merge($this->routes, $this->frindly_parameters); 
        }
    }
    

}
