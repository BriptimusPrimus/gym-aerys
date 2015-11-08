<?php

/**
 * Class Usuarios
 *
 */
class Usuarios extends Controller
{
    /**
     * http://yourproject/usuarios/login
     * Este metodo llama al formulario de Login
     */
    public function login()
    {
        // load views. within the views we can echo out 
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/usuarios/login.php';
        require 'application/views/_templates/footer.php';
    }    
    
    /**
     * post del formulario de login
     */
    public function trylogin()
    {
        if (!isset($_POST["cuenta"])
            || !isset($_POST["hash"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }     
        
        $model = $this->loadModel('UsuariosModel');
        try
        {
            $usuario = $model->autenticar($_POST["cuenta"], $_POST["hash"]);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }        
        
        if ($usuario == null)
        {
            //no se recibieron un nombre de usuario y password validos
            $this->errorMessageView('Cuenta de usuario no v&aacute;lida');
            return;                        
        }
        
        //si llega a este punto el login fue exitoso
        $this->sec_session_start();
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        // XSS protection as we might print this value
        $user_id = preg_replace("/[^0-9]+/", "", $usuario->idusuario);
        $_SESSION['user_id'] = $user_id;
        // XSS protection as we might print this value
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $usuario->cuenta);
        $_SESSION['username'] = $username;
        $_SESSION['login_string'] = hash('sha512', $usuario->password . $user_browser);
                
        // autenticacion exitosa, bienvenido! 
        header('location: ' . URL . 'home/index');
    }

    /**
     * accion al salir el usuario
     */    
    public function logout()            
    {
        $this->sec_session_start();

        // Unset all session values 
        $_SESSION = array();

        // get session parameters 
        $params = session_get_cookie_params();

        // Delete the actual cookie. 
        setcookie(session_name(),
                '', time() - 42000, 
                $params["path"], 
                $params["domain"], 
                $params["secure"], 
                $params["httponly"]);

        // Destroy session 
        session_destroy();
        header('location: ' . URL . 'usuarios/login'); 
    }

}
