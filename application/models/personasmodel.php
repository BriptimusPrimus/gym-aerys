<?php
require_once 'dal/dalpersona.php';
require_once 'dal/dalpago.php';
require_once 'dal/entities/persona.php';

class PersonasModel
{
    /**
     * Obetener una persona de la base de datos
     */    
    public function getPersona($id)
    {
        if (!isset($id))
        {
            return null;
        }
        
        try
        {
            $object = new persona();
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
     * Obtener la lista de las personas de la base de datos
     */
    public function listAllPersonas()
    {
        $dataaccess = new dalpersona();
        $recordset = $dataaccess->listAll();                                    
        return $recordset;
    }
    
    /**
     * Agrega una persona a la base de datos
     */    
    public function addNewPersona($formValues)
    {          
        $object = new persona();
        $object->populate($formValues);        
        
        //TODO: validaciones aqui
        //forzar que el registro sea nuevo
        $object->idpersona = 0;
        //valores por defecto para nueva persona
        $object->montoinscripcion = 0;
        $object->inscrito = 0;
        $object->activo = 0;

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
     * Actualiza una persona en la base de datos
     */     
    public function updatePersona($formValues)
    {          
        //recuperar el registro original
        $object = $this->getPersona($formValues['idpersona']);
        if($object == null)
        {
            throw new Exception('No es posible actualizar el cliente porque no 
                existe');            
        }
        
        //solo los atributos incluidos en el $formValues se actualizaran
        $object->populate($formValues);        
        
        //TODO: validaciones aqui
        if (isset($formValues['inscrito']))
        {
            //Regla de Negocio: Una vez inscrita, una persona no 
            //puede volver al estado preinscrito            
            if ($object->inscrito && !$formValues['inscrito'])
            {
                throw new Exception('El cliente ya est&aacute; inscrito, no es 
                    posible regresarlo al estado de preinscripci&oacute;n');                 
            }
            
            //Regla de Negocio: Solo una persona inscrita puede estar activa
            if ($formValues['activo'] && !$formValues['inscrito'])
            {
                throw new Exception('El cliente no est&aacute; inscrito, no es 
                    posible asignarlo al estado activo');                 
            }            
        }
        
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
     * Elimina una persona de la base de datos
     */     
    public function deletePersona($id)
    {          
        if($id == null || $id == 0)
        {
            throw new Exception('No existe el cliente.');
        }
        
        $object = new persona();
        $object->charge($id);        
        
        //validaciones aqui   
        //no es posible eliminar personas inscritas
        if($object->inscrito || $object->activo)
        {
            throw new Exception('No es posible eliminar el cliente porque ya 
                ha sido inscrito');
        }         
        
        //revisar registros de pagos dependientes
        $dataaccess = new dalpago();
        if($dataaccess->existenPagosDePersona($id))
        {
            throw new Exception('No es posible eliminar el cliente porque 
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
     * Obtener la lista de las personas preinscritas de la base de datos
     */
    public function listPersonasPreinscritas()
    {
        $dataaccess = new dalpersona();
        $recordset = $dataaccess->listPersonasPreinscritas();                                    
        return $recordset;
    }
    
    /**
     * Obtener la lista de las personas activas de la base de datos
     */
    public function listPersonasActivas()
    {
        $dataaccess = new dalpersona();
        $recordset = $dataaccess->listPersonasActivas();                                    
        return $recordset;
    }    
    
    /**
     * Obtener la lista de las personas inactivas de la base de datos
     */
    public function listPersonasInactivas()
    {
        $dataaccess = new dalpersona();
        $recordset = $dataaccess->listPersonasInactivas();                                    
        return $recordset;
    }   
    
    /**
     * inscribe una persona no inscrita de la base de datos
     */
    public function enrollClient($idpersona, $fechainscripcion, $montoinscripcion)
    {
        //recuperar el registro original
        $object = $this->getPersona($idpersona);
        if($object == null)
        {
            throw new Exception('No es posible inscribir el cliente porque no 
                existe');            
        }
        
        //TODO: validaciones aqui
        if($object->inscrito)
        {
            throw new Exception('El cliente ya est&aacute; inscrito');
        } 
        
        //asignar valores de la inscripcion
        $object->fechainscripcion = $fechainscripcion;
        $object->montoinscripcion = $montoinscripcion;
        $object->inscrito = 1;
        $object->activo = 1;
        
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
     * reactiva una persona no activa de la base de datos
     */
    public function setActive($idpersona)
    {
        //recuperar el registro original
        $object = $this->getPersona($idpersona);
        if($object == null)
        {
            throw new Exception('No es posible activar el cliente porque no 
                existe');            
        }
        
        //TODO: validaciones aqui
        if($object->activo)
        {
            throw new Exception('El cliente ya est&aacute; activo');
        } 
        //Regla de Negocio: Solo una persona inscrita puede estar activa
        if(!$object->inscrito)
        {
            throw new Exception('El cliente no est&aacute; inscrito, no es 
                posible asignarlo al estado activo'); 
        }
        
        //asignar valor de la activacion
        $object->activo = 1;
        
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
     * desactiva una persona activa de la base de datos
     */
    public function setInactive($idpersona)
    {
        //recuperar el registro original
        $object = $this->getPersona($idpersona);
        if($object == null)
        {
            throw new Exception('No es posible activar el cliente porque no 
                existe');            
        }
        
        //TODO: validaciones aqui
        if(!$object->activo)
        {
            throw new Exception('El cliente no est&aacute; activo');
        } 
        
        //asignar valor de la desactivacion
        $object->activo = 0;
        
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
    
    //lista de todas las personas inscritas en un mes en particular
    public function listInscritosEnMes($mes, $anho)
    {
        $iniDate = "$anho-$mes-01";        
        $lastDayOfMonth = date("t", strtotime($iniDate));        
        $finDate = "$anho-$mes-$lastDayOfMonth";
        
        $dataaccess = new dalpersona();
        return $dataaccess->listInscritosEnMes($iniDate, $finDate);
    }    
    
}
