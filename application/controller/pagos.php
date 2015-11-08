<?php

/**
 * Class Paquetes
 *
 */
class Pagos extends Controller
{    
    
    /**
     * http://yourproject/pagos/index
     */    
    public function index()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }               
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PagosModel');
        try
        {
            $pagoList = $model->listProximosPagosPorPersona();        
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }
        
        // cargar vistas en las que se maneje la variable        
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/pagos/index.php';
        require 'application/views/_templates/footer.php';         
    }
    
    /**
     * http://yourproject/paquetes/details
     */    
    public function pagosdepersona($idpersona = null)
    {            
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        if (!isset($idpersona) || $idpersona == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
        }
        
        // cargar modelo de persona para buscar el cliente antes que sus pagos, 
        // ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try 
        {                    
            $persona = $model->getPersona($idpersona);         
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
        
        // cargar modelo de pago para buscar los pagos de la persona, 
        // ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PagosModel');
        try 
        {                    
            $pagoList = $model->listPagosDePersona($persona->idpersona);         
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        //agregarle el nombre del mes en español a cada objeto de la lista        
        foreach ($pagoList as $record)
        {
            $mesNum = date("m", strtotime($record->fecha));
            $record->mes = $model->nombreMes($mesNum);
        }

        //si la persona tiene pagos, el proximo pago sera el mes proximo
        //al ultimo pago        
        if (count($pagoList) > 0)
        {
            $fechaPago = new DateTime($pagoList[0]->fecha);       
            $fechaPago->modify('+1 month');
        }
        //si la persona no tiene pagos, el proximo pago sera su
        //fecha de inscripcion        
        else
        {
            $fechaPago = new DateTime($persona->fechainscripcion);
        }
        
        // cargar vistas en las que se maneje la variable        
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/pagos/pagosdepersona.php';
        require 'application/views/_templates/footer.php';                    
    }   
    
    /**
     * http://yourproject/pagos/create
     */    
    public function create($idpersona = null)
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        if (!isset($idpersona) || $idpersona == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliente');
            return;
        }
        
        // cargar modelo de persona para obtener la persona a la que se cargara
        // el pago
        $personas_model = $this->loadModel('PersonasModel');
        try
        {
            $persona = $personas_model->getPersona($idpersona);
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
        //Regla de Negocio: Solo puede hacer un pago un cliente activo
        if(!$persona->activo)
        {
            $this->errorMessageView('No es posible generar el pago porque el 
                cliente est&aacute; inactivo'); 
            return;
        }        
        
        //Llamar metodo de calcular siguiente fecha de pago y desde el paquete
        //que paga el cliente usualmente modelo pagos
        $pagos_model = $this->loadModel('PagosModel');
        try 
        {                    
            $fechaPago = $pagos_model->siguienteFechaPago($persona);         
            $idpaquete = $pagos_model->paqueteDePersona($persona);            
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }
        
        // cargar modelo de paquete para obtener combo de paquetes        
        $paquetes_model = $this->loadModel('PaquetesModel');
        try
        {
            $HTMLpaquetesSelect = $paquetes_model->comboPaquetes($idpaquete);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }        
        
        // mostrar el formulario de edicion
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/pagos/create.php';
        require 'application/views/_templates/footer.php';        
    }  
    
    /**
     * Esta accion se ejecuta despues del form submit del formulario en 
     * pagos/create. Se gestionan los datos enviados mediante el metodo POST
     * y luego se redirige al index del controller
     */     
    public function addpago()
    {
        //verificar sesion de usuario        
        if(!$this->validUser())
        {
            return false;
        }
        
        // verificar si hay datos POST para actualizar registro
        if (!isset($_POST["submit_add_pago"])) 
        {
            $this->errorMessageView('No se enviaron los datos correctamente');
            return;
        }

        // cargar modelo, ejecutar la accion       
        $model = $this->loadModel('PagosModel');
        try
        {
            //hacer una copia del $_POST procesar el id del paquete
            $postedData = $_POST;
            $paqueteVals = explode("#", $_POST['combopaquete']);
            $idpaquete = $paqueteVals[0];
            $postedData['idpaquete'] = $idpaquete;
            //invertir el formato de la fecha  
            $formatedDate = date("Y-m-d", strtotime(implode('/',array_reverse(explode('/',$_POST['fecha'])))));
            $postedData['fecha'] = $formatedDate;
            
            if(!$model->addNewPago($postedData))
            {
                $this->errorMessageView('Ocurrió un error al generar el pago');
                return;
            }
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }       

        // redirigir al index del controller        
        header('location: ' . URL . 'pagos/pagosdepersona/' . $postedData['idpersona']);       
    }
    
    /**
     * http://yourproject/pagos/mensualidad
     */    
    public function mensualidad()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        // verificar si hay datos POST
        if (isset($_POST["monthdate"]) && $_POST["monthdate"] != null) 
        {
            $partes = explode("/", $_POST["monthdate"]);
            $mes = $partes[0];
            $anho = $partes[1];
        }        
        //sino se reciben mes y anho asignarlos 
        else
        {
            //usar la fecha actual
            $today = date("Y-m-d");
            $dateAtributes = date_parse($today);
            $mes = $dateAtributes['month'];
            $anho = $dateAtributes['year'];
            //anteponer un cero a los meses con valor numerico menor que diez
            $mes = $mes < 10 ? "0".$mes : $mes;            
        }              
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PagosModel');
        try
        {
            $pagoList = $model->listPagosDelMes($mes, $anho);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }   
        
        //sacar sumatoria de pagos 
        $total = 0;
        foreach ($pagoList as $value) 
        {
            $total += $value->monto;
        }
        
        // mostrar vista en la que se maneje la variable
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/pagos/mensualidad.php';
        require 'application/views/_templates/footer.php';        
    }
    
    /**
     * http://yourproject/pagos/inscripcion
     */    
    public function inscripcion()
    {
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }        
        
        // verificar si hay datos POST
        if (isset($_POST["monthdate"]) && $_POST["monthdate"] != null) 
        {
            $partes = explode("/", $_POST["monthdate"]);
            $mes = $partes[0];
            $anho = $partes[1];
        }        
        //sino se reciben mes y anho asignarlos 
        else
        {
            //usar la fecha actual
            $today = date("Y-m-d");
            $dateAtributes = date_parse($today);
            $mes = $dateAtributes['month'];
            $anho = $dateAtributes['year'];
            //anteponer un cero a los meses con valor numerico menor que diez
            $mes = $mes < 10 ? "0".$mes : $mes;            
        }              
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PersonasModel');
        try
        {
            $personaList = $model->listInscritosEnMes($mes, $anho);
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            

        //sacar sumatoria de pagos 
        $total = 0;
        foreach ($personaList as $value) 
        {
            $total += $value->montoinscripcion;
        }
        
        // mostrar el formulario de edicion
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/navbar.php';
        require 'application/views/pagos/inscripcion.php';
        require 'application/views/_templates/footer.php';        
    }      
    
}
