<?php
/*DATOS DE CONFIGURACION DEL PROYECTO*/
date_default_timezone_set           ('America/Argentina/Buenos_Aires');
setlocale(LC_TIME                   ,'es_ES.UTF8');

define ('VERSION'                   , '1.0');
define ('SERVER'                    ,$_SERVER['SERVER_NAME']);

define('DS'                         , DIRECTORY_SEPARATOR);
define('ROOT'                       , getcwd().DS);
define('APP'                        , ROOT.'core'.DS);
define('CLASSES'                    , APP.'clases'.DS);
define('MODELOS'                    , ROOT.'modelos'.DS);
define('CONTROLADORES'              , ROOT.'controladores'.DS);
define('CONFIG'                     , ROOT.'config'.DS);

/*URL PARA RUTAS Y ENLACES*/
define ('URL'                  ,'http://test-backend/');

define('SERVIDOR'              ,'localhost');
define('USUARIO'               ,'');
define('CLAVE'                 , '');
define('BASE'                  ,'');
