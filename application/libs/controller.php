<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;
    
    /**
     * @var salt for hashing passwords
     */
    public $salt = "azucar";    

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {
        $this->openDatabaseConnection();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        //$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        //$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
    }

    /**
     * Load the model with the given name.
     * loadModel("SongModel") would include models/songmodel.php and create the object in the controller, like this:
     * $songs_model = $this->loadModel('SongsModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
    public function loadModel($model_name)
    {
        require 'application/models/' . strtolower($model_name) . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->db);
    }

    /**
     *Shows a custom message within the generic error view
     */
    public function errorMessageView($errormessage = "Error")
    {        
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/errormessage.php';
        require 'application/views/_templates/footer.php';        
    }

    //---------------------SESION functions-----------------------------
    /**
     *This function makes your login script a whole lot more secure. It stops 
     * crackers accessing the session id cookie through JavaScript 
     * (for example in an XSS attack).
     */    
    function sec_session_start() 
    {
        $session_name = 'sec_session_id';   // Set a custom session name
        $secure = SECURE;
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
            $cookieParams["path"], 
            $cookieParams["domain"], 
            $secure,
            $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session 
        session_regenerate_id();    // regenerated the session, delete the old one. 
    }    
    
    /**
     * This method checks if the user is logged in by checking the 
     * "user_id" and the "login_string" SESSION variables. The "login_string" 
     * SESSION variable has the user's browser information hashed together with 
     * the password.
     */        
    function login_check() 
    {
        // Check if all session variables are set 
        if (!isset($_SESSION["user_id"])
            || !isset($_SESSION["username"])
                || !isset($_SESSION["login_string"])) 
        {
            return false;
        }  
        
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        
        $model = $this->loadModel('UsuariosModel');
        try
        {
            $user = $model->getUsuario($user_id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }                
        if ($user == null)
        {
            // Not logged in 
            return false;            
        }
        
        // If the user exists get variables from result.
        $password = $user->password;
        $login_check = hash('sha512', $password . $user_browser);

        if ($login_check == $login_string) 
        {
            // Logged In!!!! 
            return true;
        } 
        else 
        {
            // Not logged in 
            return false;
        }
    }
    
    /**
     * This method implements login_check  
     * redirect the user to the login page if login_check fails 
     * the password.
     */      
    function validUser() 
    {
        $this->sec_session_start(); 
        if(!$this->login_check())
        {
            header('location: ' . URL . 'usuarios/login');
            return false;
        }
        return true;
    }
    
    /**
     This next function sanitizes the output from the PHP_SELF server variable. 
     * It is a modificaton of a function of the same name used by the WordPress 
     * Content Management System
     */    
    function esc_url($url) 
    {
        if ('' == $url) 
        {
            return $url;
        }

        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string) $url;

        $count = 1;
        while ($count) 
        {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') 
        {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } 
        else 
        {
            return $url;
        }
    } 
    //---------------------SESION functions-----------------------------

}
