<?php
require_once 'dal/dalpaquete.php';
require_once 'dal/dalpago.php';
require_once 'dal/dalutils.php';
require_once 'dal/entities/paquete.php';

class PaquetesModel
{
    /**
     * Obetener un paquete de la base de datos
     */    
    public function getPaquete($id)
    {
        if (!isset($id))
        {
            return null;
        }
        
        try
        {
            $object = new paquete();
            $object->charge($id);
            if ($object->getId() == 0)
            {
                return null;
            }
        }        
        catch (Exception $e) 
        {
            return null;
        }        
                                    
        return $object;
    }
    
    /**
     * Obtener la lista de los paquetes de la base de datos
     */
    public function listAllPaquetes()
    {
        $dataaccess = new dalpaquete();
        $recordset = $dataaccess->listAll();                                    
        return $recordset;
    }
    
    /**
     * Agrega un paquete a la base de datos
     */    
    public function addNewPaquete($formValues)
    {          
        $object = new paquete();
        $object->populate($formValues);        
        
        //TODO: validaciones aqui
        //forzar que el registro sea nuevo
        $object->idpaquete = 0;
        
        try 
        {   
            $result = $object->persist();        
        }        
        catch (Exception $e) 
        {
            return false;
        }        
        return $result;
    }    
    
    /**
     * Actualiza un paquete en la base de datos
     */     
    public function updatePaquete($formValues)
    {          
        $object = new paquete();
        $object->populate($formValues);        
        //TODO: validaciones aqui
        
        try 
        {   
            $result = $object->persist();        
        }        
        catch (Exception $e) 
        {
            return false;
        }        
        return $result;
    }  
    
    /**
     * Elimina un paquete de la base de datos
     */     
    public function deletePaquete($id)
    {          
        if($id == null || $id == 0)
        {
            throw new Exception('No existe el paquete.');
        }
        
        $object = new paquete();
        $object->charge($id);        
        
        //validaciones aqui                 
        //revisar registros de pagos dependientes
        $dataaccess = new dalpago();
        if($dataaccess->existenPagosDePaquete($id))
        {
            throw new Exception('No es posible eliminar el paquete porque 
                hay registros de pagos del mismo.');
        }     

        try 
        {            
            $result = $object->destroy();        
        }        
        catch (Exception $e) 
        {
            return false;
        }        
        return $result;
    }     

    /**
     * Obtener un elemento select HTML de los paquetes de la base de datos
     */
    public function comboPaquetes($seleccionado)
    {
        $dataaccess = new dalutils();
        $HTMLselect = $dataaccess->CrearCombo2Valores('paquete', 'costo', 'titulo', $seleccionado);
        return $HTMLselect;
    }
    
}
