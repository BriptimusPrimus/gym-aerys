<?php

/**
 * Class Paquetes
 *
 */
class Reportes extends Controller
{    
    
    /**
     * http://yourproject/reportes/mensualidades
     */    
    public function mensualidades()
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
        
        $nombreMes = $model->nombreMes((int)$mes);
        
        // mostrar vista del reporte
        require 'application/reports/reppagosdemes.php';        
    }
    
    /**
     * http://yourproject/reportes/inscripciones
     */    
    public function inscripciones()
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
        
        // cargar modelo de pagos para averiguar el nombre del mes
        $pagos_model = $this->loadModel('PagosModel');        
        $nombreMes = $pagos_model->nombreMes((int)$mes);
        
        // mostrar vista del reporte
        require 'application/reports/repinscripcionesdemes.php';
    }    

    /**
     * http://yourproject/reportes/comprobante
     */    
    public function comprobante($id = null)
    {            
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n pago de mensualidad');
            return;
        }
        
        // cargar modelo, ejecutar la accion, pasar los datos a una variable
        $model = $this->loadModel('PagosModel');
        try 
        {                    
            $pago = $model->getPago($id);         
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }            
        if($pago == null)
        {
            $this->errorMessageView('No existe el pago');
            return;                
        }
        
        // cargar modelo de persona, para obtener el cliente que hizo el pago
        $model_personas = $this->loadModel('PersonasModel');
        try 
        {                    
            $persona = $model_personas->getPersona($pago->idpersona);         
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }
        
        // cargar modelo de paquete, para obtener el paquete que se ha pagado
        $model_paquetes = $this->loadModel('PaquetesModel');
        try 
        {                    
            $paquete = $model_paquetes->getPaquete($pago->idpaquete);         
        }
        catch (Exception $e) 
        {
            $this->errorMessageView($e->getMessage());
            return;
        }        

        // mostrar vista del reporte        
        //require 'application/views/_templates/header.php';
        //require 'application/views/pagos/comprobante.php';        
        require 'application/reports/repcomprobante.php';
    }  
    
    /**
     * http://yourproject/reportes/inscripcion
     */    
    public function inscripcion($id = null)
    {            
        //verificar sesion de usuario
        if(!$this->validUser())
        {
            return false;
        }
        
        if (!isset($id) || $id == null) 
        {
            $this->errorMessageView('No se indic&oacute; ning&uacute;n cliented');
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
        if(!$persona->inscrito)
        {
            $this->errorMessageView('El cliente no se ha inscrito');
            return;                
        }        

        // mostrar vista del reporte         
        //require 'application/views/_templates/header.php';
        //require 'application/views/personas/inscripcion.php';
        require 'application/reports/repinscripcion.php';
    }    
    
}
