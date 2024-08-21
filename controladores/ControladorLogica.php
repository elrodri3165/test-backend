<?php

class ControladorLogica{
    
    
    public function __construct(){
        
    }
    
    public function Index(){
    
    }
    
    public function CerrarSesion(){
        if(!isset($_SESSION)){
            session_start();
        }
        session_destroy();
        WebMaker::ReDirect('');
    }
    
    public function CrearUsuario(){
        if (isset ($_POST['apellido'],$_POST['nombre'],$_POST['email'],$_POST['user'], $_POST['password'])){
    
        $apellido = trim($_POST['apellido']);
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $user = trim($_POST['user']);
        $password = trim($_POST['password']);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            
        $newuser = new users();
        $newuser ->SetApellido($apellido);
        $newuser ->SetNombre($nombre);
        $newuser ->SetEmail($email);
        $newuser ->SetPassword($password);
        

        $resultado = $newuser ->Guardar();
        $this->EnviarCorreo($email);

        if ($resultado == true){
            WebMaker::ReDirect('index');
        }else{
            WebMaker::ReDirect('index');
        }
    }else{
          WebMaker::ReDirect('/');  
        }
    }
    
    
    public function ValidarLogin(){
        if (isset($_POST['user'], $_POST['password'])){
                
            $user=$_POST['user'];
            $password=$_POST['password'];

            $new_user = new users();
            $new_user->SetDni($user);
            $new_user->SetActivo(1);
            $resultado = $new_user->Buscar();
            
            if($resultado != null){
                foreach ($resultado as $row){
                    if (password_verify($password, $row['password'])){
                        $_SESSION['user'] = $new_user;
                        
                        $_SESSION['user'] ->SetIdUser($row['id_user']);
                        $_SESSION['user'] ->SetApellido($row['apellido']);
                        $_SESSION['user'] ->SetNombre($row['nombre']);
                        $_SESSION['user'] ->SetDni($row['dni']);
                        $_SESSION['user'] ->SetEmail($row['email']);
                        $_SESSION['user'] ->SetFecha_Nacimiento($row['fecha_nacimiento']);
                        $_SESSION['user'] ->SetLastIp($row['last_ip']);
                        $_SESSION['user'] ->SetActivo($row['activo']);
                        
                        $new_user ->SetLastIp($_SERVER['REMOTE_ADDR']);
                        $new_user ->Actualizar('dni');
                        WebMaker::ReDirect('login');
                    }else{
                        WebMaker::ReDirect('admin');
                    }
                }
            }
            WebMaker::ReDirect('admin');
        }
    }
    
    public function SubirArchivos(){
        WebMaker::SubirArchivos();
    }
    
    private function EnviarCorreo($email){
        $obj = new PhpMailerInit();
        $body = 'hola como estas?';
        $resultado = $obj ->Enviar($body, 'asunto', $email);
    }
    
}