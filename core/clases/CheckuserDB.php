<?php
namespace core\clases;

class CheckuserDB{
    
    public function __construct(){
        /*
        CHEQUEO SI VARIBALE user, user registro
        CHEQUEO SI USER ES OBJETO
        CHEQUEO SI USER REGISTRO ES OBJETO
        */
        if (
            isset ($_SESSION['user'], $_SESSION['user_registro']) 
            && is_object($_SESSION['user']) 
            //&& is_object($_SESSION['user_registro'])
           ){
            $this->Checkuser();
        }else{
            $this->DieProject();
        }
    }
    
    private function Checkuser(){
        /*******************************COMPARO CON LA IP CON LA COOKIE DE SESSION*******************************/
        if ($_SESSION['user_registro']->GetLastIp() != $_SERVER['REMOTE_ADDR']){
            $this->DieProject();
        }
        /*******************************COMPARO CON LA IP CON LA COOKIE DE SESSION*******************************/
        
        
        /*****************************COMPARO EL AGENTE CON LA COOKIE DE SESSION*********************************/
        if ($_SESSION['user_registro']->GetHttpUserAgent() != $_SERVER['HTTP_USER_AGENT']){
            $this->DieProject();
        }
        /*****************************COMPARO EL AGENTE CON LA COOKIE DE SESSION*********************************/
    }
    
    private function DieProject(){
        unset($_SESSION['user']);
        unset($_SESSION['user_registro']);
        Core::ReDirect('');
    }
}