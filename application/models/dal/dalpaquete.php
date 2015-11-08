<?php
require_once 'entities/PDO2Object.php';
require_once 'entities/paquete.php';

//Clase de acceso a datos dedicada a la entidad paquete
class dalpaquete extends PDO2Object
{                 
    public function listAll($Filter = "")
    {     
        if ($Filter != "")
        {
            $Filter=" WHERE ".$Filtro;
        }
        $recordset = parent::queryArray("SELECT * FROM paquete $Filter");
        return $recordset;
    }                         

}