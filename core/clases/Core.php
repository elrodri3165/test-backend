<?php
namespace core\clases;

class Core{

    // La función principal que se ejecuta al instanciar nuestra clase
    function __construct() {
        $this->init();
    }

    private function Init_Autoload() {
        require_once CLASSES.'Autoloader.php';
        Autoloader::init();
        return;
    }

    private function Init() {
        // Todos los métodos que queremos ejecutar consecutivamente
        $this->Init_Load_Config();
        $this->Init_Autoload();
        $this->StartSesion();
        $this->StartControlador();
    }

    private function Init_Load_Config() {
        // Carga del archivo de settings inicialmente para establecer las constantes personalizadas
        // desde un comienzo en la ejecución del sitio
        $file = 'config/config_site.php';
        if(!is_file($file)) {
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file));
        }
        
        require_once $file;

        return;
    }
    
    private function StartControlador(){
        $controlador = new Controlador();
    }
    
    public static function Start(){
        $webmaker = new self();
        return;
    }
    
    private function StartSesion(){
        session_start();
    }
    
    
    public static function StartToken(){
        if (isset ($_SESSION['token'], $_SESSION['token_expiration']) && $_SESSION['token_expiration']-time() > 0){
            define('TOKEN', $_SESSION['token']);
            return;
        }
        
        $token = new TokenKey();
        $_SESSION['token'] = $token ->GetToken();
        $_SESSION['token_expiration'] = time() + 300;
        define('TOKEN', $_SESSION['token']);
    }
    /*
    Void
    VALIDAR TOKEN
    */
    public static function ValidateToken(){
        if (isset ($_SESSION['token'], $_POST['token']) && $_POST['token'] === $_SESSION['token']){
            return;
        }
        Core::ReDirect('');
    }
    
    /*
    Void
    VALIDAR USUARIOS
    */
    public static function ValidateUser(){
        new CheckuserDB();
    }
  
    
    /*FUNCIÓN PARA REDIRECCIONAR RÁPIDAMENTE*/
    public static function ReDirect($destino){
        ob_start();
        $destino = 'Location: '.URL.$destino;
        header ($destino);
        ob_end_flush();
        die;
    }
    
}