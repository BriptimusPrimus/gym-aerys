<?php
require_once 'dal/dalusuario.php';
require_once 'dal/entities/usuario.php';

class UsuariosModel
{
    /**
     * busca un usuario en la base de datos con los datos de autenticacion
     * y lo devuelve si este existe
     * sino existe devolvera null
     */     
    public function autenticar($user, $pass)
    {     
        $dataset = new dalusuario();
        return $dataset->autenticar($user, $pass);
    }    
    
    /**
     * busca un usuario en la base de datos y lo devuelve si este existe
     * sino existe devolvera null
     */    
    public function getUsuario($id)
    {
        if (!isset($id))
        {
            return null;
        }
        
        try
        {
            $object = new usuario();
            $object->charge($id);
            if ($object->getId() == 0)
            {
                return null;
            }
        }        
        catch (Exception $e) 
        {
            //print "¡Error!: " . $e->getMessage() . "<br/>";
            return null;
        }        
                                    
        return $object;
    }    
}
