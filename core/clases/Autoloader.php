<?php 
namespace core\clases;

class Autoloader
{
  /**
   * Método encargado de ejecutar el autocargador de forma estática
   *
   * @return void
   */
  public static function init() {
    spl_autoload_register([__CLASS__, 'autoload']);
  }

  private static function autoload($class_name){
    if(is_file(MODELOS.$class_name.'.php')) {
      require_once MODELOS.$class_name.'.php';
    }
    if(is_file(CONTROLADORES.$class_name.'.php')) {
      require_once CONTROLADORES.$class_name.'.php';
    }
    if (file_exists(str_replace('\\', '/', $class_name).'.php')){
      require_once str_replace('\\', '/', $class_name).'.php';
    }
    return;
  }
}