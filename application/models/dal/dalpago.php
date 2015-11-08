<?php
require_once 'entities/PDO2Object.php';
require_once 'entities/pago.php';

//Clase de acceso a datos dedicada a la entidad pago
class dalpago extends PDO2Object
{                 
    public function listAll($Filter = "")
    {     
        if ($Filter != "")
        {
            $Filter=" WHERE ".$Filtro;
        }
        $recordset = parent::queryArray("SELECT * FROM pago $Filter");
        return $recordset;
    }
      
    public function existenPagosDePaquete($idpaquete)
    {
        $SQLCommand = 
        "SELECT 
         COUNT(idpago)
         FROM pago 
         WHERE idpaquete = '$idpaquete'";
        $query = parent::query($SQLCommand);	
        $cantidad = $query->fetchColumn();
        return $cantidad > 0;        
    }
    
    public function listPagosDePaquete($idpaquete)
    {
        $SQLCommand = 
        "SELECT 
         idpago, idpersona, idpaquete, fecha, monto, descuento 
         FROM pago 
         WHERE idpaquete = '$idpaquete'";
        $recordset = parent::queryArray($SQLCommand);	
        return $recordset;        
    }    
    
    public function existenPagosDePersona($idpersona)
    {
        $SQLCommand = 
        "SELECT 
         COUNT(idpago)
         FROM pago 
         WHERE idpersona = '$idpersona'";
        $query = parent::query($SQLCommand);	
        $cantidad = $query->fetchColumn();
        return $cantidad > 0;        
    } 
    
    //Devuelve una coleccion de una facade entity con atributos de pago y paquete
    //facade entity pagoDePaquete
    //  pago: 
    //      idpago, 
    //      idpersona, 
    //      idpaquete, 
    //      fecha, 
    //      monto, 
    //      descuento,
    //  paquete: 
    //      titulo, 
    //      costo, 
    //      descripcion
    public function listPagosDePersona($idpersona)
    {
        $SQLCommand = 
        "SELECT 
         o.idpago, o.idpersona, o.idpaquete, o.fecha, o.monto, o.descuento, o.comentarios,
         e.titulo, e.costo, e.descripcion
         FROM pago o
         INNER JOIN paquete e ON (o.idpaquete = e.idpaquete)        
         WHERE o.idpersona = '$idpersona'
         ORDER BY o.fecha DESC";
        $recordset = parent::queryArray($SQLCommand);	
        return $recordset;        
    }    

    public function listPagosDePersonaEnPeriodo($idpersona, $iniDate, $finDate)
    {
        $SQLCommand =
        "SELECT 
         idpago, idpersona, idpaquete, fecha, 
         monto, descuento, comentarios
         FROM pago 
         WHERE idpersona = '$idpersona'
         AND fecha >= '$iniDate'
         AND fecha <= '$finDate'        
         ORDER BY fecha DESC";
        $recordset = parent::queryArray($SQLCommand);	
        return $recordset;         
    }
    
    //Devuelve una coleccion de una facade entity con atributos de persona y pago 
    //facade entity ultimosPagos
    //  persona:
    //      idpersona,
    //      nombre,
    //      apaterno,
    //      amaterno,
    //      fechainscripcion
    //  pago: 
    //      idpago, 
    //      idpaquete, 
    //      fecha, 
    //      monto, 
    public function listUltimosPagosPorPersona()
    {
        $SQLCommand = "
        SELECT 
        e.idpersona, e.nombre, e.apaterno, e.amaterno, e.fechainscripcion
        , a.idpago, a.idpaquete, a.fecha, a.monto
        FROM persona e
        LEFT JOIN pago a ON (e.idpersona = a.idpersona
        AND a.fecha =
        (
                SELECT MAX(x.fecha)
                FROM pago x
                WHERE x.idpersona = e.idpersona
        ))
        WHERE e.activo = 1";
        $recordset = parent::queryArray($SQLCommand);	
        return $recordset;        
    }

    //Devuelve una coleccion de una facade entity con atributos de persona y pago 
    //facade entity pagosDelMes
    //  persona:
    //      idpersona,
    //      nombre,
    //      apaterno,
    //      amaterno,
    //      fechainscripcion,
    //      montoinscripcion
    //  pago: 
    //      idpago, 
    //      idpaquete, 
    //      fecha, 
    //      monto, 
    public function listPagosDelMes($iniDate, $finDate)
    {
        $SQLCommand = "
        SELECT 
        o.idpago, o.idpersona, o.idpaquete, o.fecha, o.monto,
        e.nombre, e.apaterno, e.amaterno, e.fechainscripcion, e.montoinscripcion
        FROM pago	o
        INNER JOIN persona e ON (o.idpersona = e.idpersona)
        WHERE o.fecha >= '$iniDate'
        AND o.fecha <= '$finDate'
        ORDER BY o.fecha DESC";
        $recordset = parent::queryArray($SQLCommand);	
        return $recordset;        
    }
    
}