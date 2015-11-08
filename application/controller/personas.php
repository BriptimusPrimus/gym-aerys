<?php

/**
 * Class Personas
 *
 */
class Personas extends Controller
{
    /**
     * http://yourproject/personas/index
     * lista todas las personas
     */
    public function index()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try
        {
            $personaList = $model->listAllPersonas();        
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        
        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/index.php';
        require 'application/views/_templates/footer.php';
    }
    
    /**
     * http://yourproject/personas/details
     */    
    public function details($id = null)
    {            
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
            return;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try 
        {                    
            $persona = $model->getPersona($id);         
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($persona == null)
        {
            $this->errorMessageView('No existe el cliente');
            return;                
        }

        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/details.php';
        require 'application/views/_templates/footer.php';                    
    }    
    
    /**
     * http://yourproject/paquetes/create
     */    
    public function create()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // mostrar formulario de agregar
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/create.php';
        require 'application/views/_templates/footer.php';                              
    } 
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * personas/create. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function addpersona()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para un nuevo registro
        if (!isset($_POST["submit_add_persona"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }
        
        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PersonasModel');
        try
        {
            //invertir el formato de la fecha
            $postedData = $_POST;
            $formatedDate = implode('/',array_reverse(explode('/',$_POST['fecharegistro'])));
            $formatedDate = str_replace('/', '-', $formatedDate);
            $postedData['fecharegistro'] = $formatedDate;
            //guardar nueva persona
            if(!$model->addNewPersona($postedData))
            {
                $this->errorMessageView('Ocurri&oacute; un error al guardar el cliente');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }

        // redirigir al index del controller
        header('location: ' . URL . 'personas/index');
    }
    
    /**
     * http://yourproject/personas/edit
     */    
    public function edit($id = null)
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
            return;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PersonasModel');
        try
        {
            $persona = $model->getPersona($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($persona == null)
        {
            $this->errorMessageView('No existe el cliente');
            return;                
        }        

        // mostrar el formulario de edicion
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/edit.php';
        require 'application/views/_templates/footer.php';        
    }
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * personas/edit. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function updatepersona()
    {
        //verificar sesion de usuario        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para actualizar registro
        if (!isset($_POST["submit_update_persona"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }

        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PersonasModel');
        try
        {
            //invertir el formato de la fecha
            $postedData = $_POST;
            $formatedDate = implode('/',array_reverse(explode('/',$_POST['fecharegistro'])));
            $formatedDate = str_replace('/', '-', $formatedDate);
            $postedData['fecharegistro'] = $formatedDate;
            //actualizar persona            
            if(!$model->updatePersona($postedData))
            {
                $this->errorMessageView('Ocurrió un error al guardar el cliente');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller        
        header('location: ' . URL . 'personas/index');
    }   
    
    /**
     * http://yourproject/personas/delete
     */    
    public function delete($id = null)
    {
        //verificar sesion de usuario                
        if(!$this->validUser())
        {
            return false;
        }
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
            return;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PersonasModel');
        try
        {
            $persona = $model->getPersona($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }
        if($persona == null)
        {
            $this->errorMessageView('No existe el cliente');
            return;                
        }

        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/delete.php';
        require 'application/views/_templates/footer.php';            
        
    }    

    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * personas/delete. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */    
    public function deleteconfirmed()
    {
        //verificar sesion de usuario                        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para eliminar registro        
        if (!isset($_POST["submit_delete_persona"])
            || !isset($_POST["idpersona"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }
        $id = $_POST["idpersona"];
        
        // cargar modelo, ejecutar la accion        
        $model = $this->loadModel('PersonasModel');
        try
        {
            if(!$model->deletePersona($id))
            {
                $this->errorMessageView('Ocurri&oacute; un error al eliminar el cliente');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller                
        header('location: ' . URL . 'personas/index');        
    }
    
    /**
     * http://yourproject/personas/enrollclient
     * Llama la vista con el formulario de inscripcion
     */    
    public function enrollclient($id = null)
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PersonasModel');
        try
        {
            $persona = $model->getPersona($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($persona == null)
        {
            $this->errorMessageView('No existe el cliente');
            return;                
        }  
        
        if ($persona->inscrito)
        {
            $this->errorMessageView('El cliente ya est&aacute; inscrito');
            return;
        }

        // cargar vistas en las que se maneje la variable               
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/enrollclient.php';
        require 'application/views/_templates/footer.php';        
    } 
        
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * personas/enrollclient. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function enrollconfirmed()
    {
        //verificar sesion de usuario        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para actualizar registro
        if (!isset($_POST["submit_enroll_persona"])
            || !isset($_POST["idpersona"])
                || !isset($_POST["fechainscripcion"])                
                    || !isset($_POST["montoinscripcion"]))
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }

        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PersonasModel');
        try
        {
            $id = $_POST['idpersona'];
            $monto = $_POST['montoinscripcion'];
            //invertir el formato de la fecha            
            $formatedDate = implode('/',array_reverse(explode('/',$_POST['fechainscripcion'])));
            $formatedDate = str_replace('/', '-', $formatedDate);
            //actualizar persona            
            if(!$model->enrollClient($id, $formatedDate, $monto))
            {
                $this->errorMessageView('Ocurrió un error al inscribir al cliente');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller        
        header('location: ' . URL . 'personas/index');
    }
    
    /**
     * http://yourproject/personas/setactive
     * Llama la vista de confirmacion de activacion
     */    
    public function setactive($id = null)
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PersonasModel');
        try
        {
            $persona = $model->getPersona($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($persona == null)
        {
            $this->errorMessageView('No existe el cliente');
            return;                
        }  
        
        if ($persona->activo)
        {
            $this->errorMessageView('El cliente ya est&aacute; activo');
            return;
        }
        if (!$persona->inscrito)
        {
            $this->errorMessageView('El cliente no est&aacute; inscrito, no es 
                posible asignarlo al estado activo');
            return;
        }        

        // cargar vistas en las que se maneje la variable               
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/setactive.php';
        require 'application/views/_templates/footer.php';        
    }
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * personas/setactive. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function setactiveconfirmed()
    {
        //verificar sesion de usuario        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para actualizar registro
        if (!isset($_POST["submit_setactive_persona"])
            || !isset($_POST["idpersona"]))
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }

        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PersonasModel');
        try
        {
            $id = $_POST['idpersona'];
            //activar persona            
            if(!$model->setActive($id))
            {
                $this->errorMessageView('Ocurrió un error al activar al cliente');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller        
        header('location: ' . URL . 'personas/index');
    } 
    
    /**
     * http://yourproject/personas/setinactive
     * Llama la vista de confirmacion de desactivacion
     */    
    public function setinactive($id = null)
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PersonasModel');
        try
        {
            $persona = $model->getPersona($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($persona == null)
        {
            $this->errorMessageView('No existe el cliente');
            return;                
        }  
        
        if (!$persona->activo)
        {
            $this->errorMessageView('El cliente no est&aacute; activo');
            return;
        }

        // cargar vistas en las que se maneje la variable               
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/setinactive.php';
        require 'application/views/_templates/footer.php';        
    }
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * personas/setinactive. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function setinactiveconfirmed()
    {
        //verificar sesion de usuario        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para actualizar registro
        if (!isset($_POST["submit_setinactive_persona"])
            || !isset($_POST["idpersona"]))
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }

        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PersonasModel');
        try
        {
            $id = $_POST['idpersona'];
            //desactivar persona            
            if(!$model->setInactive($id))
            {
                $this->errorMessageView('Ocurrió un error al desactivar al cliente');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller        
        header('location: ' . URL . 'personas/index');
    }    
    
    /**
     * http://yourproject/personas/preinscritos
     * lista las personas no inscritas
     */
    public function preinscritos()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try
        {
            $personaList = $model->listPersonasPreinscritas();        
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        
        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/index.php';
        require 'application/views/_templates/footer.php';
    }
    
    /**
     * http://yourproject/personas/activos
     * lista las personas activas
     */
    public function activos()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try
        {
            $personaList = $model->listPersonasActivas();        
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        
        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/index.php';
        require 'application/views/_templates/footer.php';
    }
    
    /**
     * http://yourproject/personas/activos
     * lista las personas inactivas
     */
    public function inactivos()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try
        {
            $personaList = $model->listPersonasInactivas();        
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        
        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/personas/index.php';
        require 'application/views/_templates/footer.php';
    }        
    
}
