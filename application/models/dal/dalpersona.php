<?php
require_once 'entities/PDO2Object.php';
require_once 'entities/persona.php';

//Clase de acceso a datos dedicada a la entidad persona
class dalpersona extends PDO2Object
{                 
    public function listAll($Filter = "")
    {     
        if ($Filter != "")
        {
            $Filter=" WHERE ".$Filtro;
        }
        $recordset = parent::queryArray("SELECT * FROM persona $Filter");
        return $recordset;
    } 
    
    //Devuelve lista de personas que no estan marcados como inscritas
    //Nota: Una regla de negocio indica que una vez inscrita, una persona no 
    //puede volver al estado preinscrito
    public function listPersonasPreinscritas()
    {     
        $SQLCommand = 
        "SELECT
        idpersona, nombre, apaterno, amaterno, direccion, telefono, email, contacto, 
        contactotelefono, fecharegistro, fechainscripcion, montoinscripcion, 
        inscrito, activo
        FROM persona
        WHERE inscrito = 0
        ORDER BY nombre";
        $recordset = parent::queryArray($SQLCommand);
        return $recordset;
    }    
    
    //Devuelve lista de personas que estan activas
    //Nota: Una regla de negocio indica que solo una persona inscrita puede
    //estar activa
    public function listPersonasActivas()
    {     
        $SQLCommand = 
        "SELECT
        idpersona, nombre, apaterno, amaterno, direccion, telefono, email, contacto, 
        contactotelefono, fecharegistro, fechainscripcion, montoinscripcion, 
        inscrito, activo
        FROM persona
        WHERE inscrito = 1
        AND activo = 1
        ORDER BY nombre";
        $recordset = parent::queryArray($SQLCommand);
        return $recordset;
    } 
    
    //Devuelve lista de personas que estan inscritas pero no activas
    public function listPersonasInactivas()
    {     
        $SQLCommand = 
        "SELECT
        idpersona, nombre, apaterno, amaterno, direccion, telefono, email, contacto, 
        contactotelefono, fecharegistro, fechainscripcion, montoinscripcion, 
        inscrito, activo
        FROM persona
        WHERE inscrito = 1
        AND activo = 0
        ORDER BY nombre";
        $recordset = parent::queryArray($SQLCommand);
        return $recordset;
    }     
    
    //Devuelve lista de personas que pagaron inscripcion en un mes particular
    public function listInscritosEnMes($iniDate, $finDate)
    {     
        $SQLCommand = "
        SELECT
        idpersona, nombre, apaterno, amaterno, direccion, telefono, email, contacto, 
        contactotelefono, fecharegistro, fechainscripcion, montoinscripcion, 
        inscrito, activo
        FROM persona
        WHERE fechainscripcion >= '$iniDate'
        AND fechainscripcion <= '$finDate'
        ORDER BY fechainscripcion DESC";
        $recordset = parent::queryArray($SQLCommand);
        return $recordset;
    }
    
}