<?php
require_once 'entities/PDO2Object.php';
require_once 'entities/usuario.php';

//Clase de acceso a datos dedicada a la entidad usuario
class dalusuario extends PDO2Object
{                 
    /**
     * busca un usuario en la base de datos y lo devuelve si este existe
     * sino existe devolvera null
     */     
    public function autenticar($user, $pass)
    {     
        $SQLCommand = 
        "SELECT 
         idusuario, cuenta, password 
         FROM usuario 
         WHERE cuenta = '$user' AND password = '$pass'
         LIMIT 1";
        $recordset = parent::query($SQLCommand);	
        $usuario = $recordset->fetchObject();
        return $usuario;
    }                         
}