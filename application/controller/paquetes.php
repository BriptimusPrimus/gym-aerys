<?php

/**
 * Class Paquetes
 *
 */
class Paquetes extends Controller
{
    /**
     * http://yourproject/paquetes/index
     */
    public function index()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PaquetesModel');
        try
        {
            $paqueteList = $model->listAllPaquetes();        
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        
        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/paquetes/index.php';
        require 'application/views/_templates/footer.php';
    }    
    
    /**
     * http://yourproject/paquetes/details
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
            $this->errorMessageView('No se indic&oacute; ning&uacute;n paquete');
            return;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PaquetesModel');
        try 
        {                    
            $paquete = $model->getPaquete($id);         
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($paquete == null)
        {
            $this->errorMessageView('No existe el paquete');
            return;                
        }

        // cargar vistas en las que se maneje la variable        
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/paquetes/details.php';
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
        require 'application/views/paquetes/create.php';
        require 'application/views/_templates/footer.php';                              
    } 
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * paquetes/create. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function addpaquete()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para un nuevo registro
        if (!isset($_POST["submit_add_paquete"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }
        
        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PaquetesModel');
        try
        {
            if(!$model->addNewPaquete($_POST))
            {
                $this->errorMessageView('Ocurri&oacute; un error al guardar el paquete');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }

        // redirigir al index del controller
        header('location: ' . URL . 'paquetes/index');
    }
    
    /**
     * http://yourproject/paquetes/edit
     */    
    public function edit($id)
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n paquete');
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PaquetesModel');
        try
        {
            $paquete = $model->getPaquete($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        if($paquete == null)
        {
            $this->errorMessageView('No existe el paquete');
            return;                
        }        

        // redirigir al index del controller                
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/paquetes/edit.php';
        require 'application/views/_templates/footer.php';        
    }    
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * paquetes/edit. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function updatepaquete()
    {
        //verificar sesion de usuario        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para actualizar registro
        if (!isset($_POST["submit_update_paquete"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }

        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PaquetesModel');
        try
        {
            if(!$model->updatePaquete($_POST))
            {
                $this->errorMessageView('Ocurrió un error al guardar el paquete');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller        
        header('location: ' . URL . 'paquetes/index');
    }    
       
    /**
     * http://yourproject/paquetes/delete
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
            $this->errorMessageView('No se indic&oacute; ning&uacute;n paquete');
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable        
        $model = $this->loadModel('PaquetesModel');
        try
        {
            $paquete = $model->getPaquete($id);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }
        if($paquete == null)
        {
            $this->errorMessageView('No existe el paquete');
            return;                
        }

        // cargar vistas en las que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/paquetes/delete.php';
        require 'application/views/_templates/footer.php';            
        
    }
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * paquetes/delete. Se gestionan los datos enviados mediante el metodo POST
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
        if (!isset($_POST["submit_delete_paquete"])
            || !isset($_POST["idpaquete"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }
        $id = $_POST["idpaquete"];
        
        // cargar modelo, ejecutar la accion
        $model = $this->loadModel('PaquetesModel');
        try
        {
            if(!$model->deletePaquete($id))
            {
                $this->errorMessageView('Ocurri&oacute; un error al eliminar el paquete');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller                
        header('location: ' . URL . 'paquetes/index');        
    }    
    
}
