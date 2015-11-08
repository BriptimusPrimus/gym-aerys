<?php
require_once 'dal/dalpago.php';
require_once 'dal/dalutils.php';
require_once 'dal/entities/pago.php';

class PagosModel
{
    private $spanishMonths = array
    (
        1 => "Enero", 
        2 => "Febrero", 
        3 => "Marzo", 
        4 => "Abril", 
        5 => "Mayo", 
        6 => "Junio", 
        7 => "Julio", 
        8 => "Agosto", 
        9 => "Septiembre", 
        10 => "Octubre", 
        11 => "Noviembre", 
        12 => "Diciembre"
    );    
    
    /**
     * Obetener un pago de la base de datos
     */    
    public function getPago($id)
    {
        if (!isset($id))
        {
            return null;
        }
        
        try
        {
            $object = new pago();
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
     * Busca algun pago de la persona durante el mes de la fecha recibida como
     * parametro en  la base de datos. Devuelve TRUE si encuentra al menos un
     * pago
     */      
    public function isMonthPayed($idpersona, $date)
    {
        $dateAtributes = date_parse($date);
        $lastDayOfMonth = date("t", strtotime($date));
        
        //calcular fecha de inicio y fecha final para la query
        $iniDate = $dateAtributes['year'] . '-'. $dateAtributes['month'] . '-01';
        $finDate = $dateAtributes['year'] . '-'. $dateAtributes['month'] . '-' . $lastDayOfMonth;
        
        $dataaccess = new dalpago();
        $recordset = $dataaccess->listPagosDePersonaEnPeriodo($idpersona, $iniDate, $finDate); 
        
        return count($recordset) > 0;        
    }
    
    /**
     * Agrega un pago a la base de datos
     */    
    public function addNewPago($formValues)
    {          
        //revisar persona y paquete validos
        $dataaccess = new dalutils();
        $persona = $dataaccess->getRecord('persona', $formValues['idpersona']);
        if($persona == NULL)
        {
            throw new Exception('No existe el cliente al cual se le est&aacute;
                adjudicando el pago');            
        }
        $paquete = $dataaccess->getRecord('paquete', $formValues['idpaquete']);
        if($paquete == NULL)
        {
            throw new Exception('No existe el paquete');            
        }        
        
        $object = new pago();
        $object->populate($formValues);          
        
        //validaciones aqui        
        //Regla de Negocio: Solo puede hacer un pago un cliente activo
        if(!$persona->activo)
        {
            throw new Exception('No es posible generar el pago porque el 
                cliente est&aacute; inactivo');            
        }        
        //Regla de Negocio: Un cliente solo puede hacer un pago al mes
        if ($this->isMonthPayed($object->idpersona, $object->fecha))
        {
            throw new Exception('No es posible generar el pago porque el 
                cliente ya ha pagado este mes');            
        }        
        //si aplica descuento, calcular nuevo precio
        if ($object->descuento > 0)
        {
            $object->monto = $object->monto - ($object->monto * $object->descuento / 100);            
        }        
        
        //forzar que el registro sea nuevo
        $object->idpago = 0;
        
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
     * Obtener la lista de los pagos de una persona de la base de datos
     */
    public function listPagosDePersona($idpersona)
    {
        $dataaccess = new dalpago();
        $recordset = $dataaccess->listPagosDePersona($idpersona);                                    
        return $recordset;
    }      

    /**
     * Obtiene el id del ultimo paquete paquete pagado por la persona
     * o 0 sino ha pagado ningun paquete
     */    
    public function paqueteDePersona($persona)
    {
        //obtener la lista de pagos de la persona
        $dataaccess = new dalpago();
        $pagoList = $dataaccess->listPagosDePersona($persona->idpersona);
        //si la persona tiene pagos, deveolver el idpaquete del ultimo        
        if (count($pagoList) > 0)
        {            
            return $pagoList[0]->idpaquete;            
        }
        else
        {
            return 0;
        }
    }
    
    /**
     * Obtiene la proxima fecha de pago de una persona de la base de datos
     */    
    public function siguienteFechaPago($persona)
    {
        //obtener la lista de pagos de la persona
        $dataaccess = new dalpago();
        $pagoList = $dataaccess->listPagosDePersona($persona->idpersona);
        //si la persona tiene pagos, el proximo pago sera el mes proximo
        //al ultimo pago
        if (count($pagoList) > 0)
        {
            //el ultimo pago es primero en la lista
            $date = new DateTime($pagoList[0]->fecha);
            $date->modify('+1 month');
        }
        //si la persona no tiene pagos, el proximo pago sera su
        //fecha de inscripcion
        else
        {
            $date = new DateTime($persona->fechainscripcion);
        }
        return $date;
    }

    /**
     * Obtiene la proxima fecha de pago de todas las personas activas
     * de la base de datos
     */        
    public function listProximosPagosPorPersona()
    {
        //obtener la lista de pagos de la persona
        $dataaccess = new dalpago();
        $ultimosPagosList = $dataaccess->listUltimosPagosPorPersona();
        
        $hoy = strtotime(date('Y-m-d'));        
        //por cada cliente involucrado, calcular proxima fecha de pago
        foreach ($ultimosPagosList as $record)
        {
            //si la persona tiene pagos, el proximo pago sera el mes proximo
            //al ultimo pago
            if ($record->idpago)
            {
                $fechaAux = new DateTime($record->fecha);
                $fechaAux->modify('+1 month');
                $fechaCorte = $fechaAux->format('Y-m-d');
            }
            //si la persona no tiene pagos, el proximo pago sera su
            //fecha de inscripcion            
            else
            {
                $fechaCorte = $record->fechainscripcion;
            }   
            $diaCorte = strtotime($fechaCorte);
            
            //diferencia en dias entre la fecha de hoy y la de corte
            $diasVencidos = floor(($hoy - $diaCorte) / 86400);
            
            //se agregan dos atributos a la fachada
            $record->fechaCorte = $fechaCorte;           
            $record->diasVencidos = $diasVencidos;
        }
        
        //ordenar el array por diasVencidos
        //usort($ultimosPagosList, $this->cmp);
        usort($ultimosPagosList, array('pagosmodel','cmpDiasVencidos'));
        return $ultimosPagosList;
    }

    /**
     * Metodo que compara dos elementos de la lista de ultimos pagos     
     * para asistir al ordenado de la misma
     */    
    private function cmpDiasVencidos($a, $b)
    {       
        return (int)$a->diasVencidos  < (int)$b->diasVencidos;
    }

    //convierte el valor numerico de un mes en su nombres en español
    public function nombreMes($mes)
    {
        return $this->spanishMonths[(int)$mes];
    }
        
    //lista de todos los pagos de un mes en particular
    public function listPagosDelMes($mes, $anho)
    {
        $iniDate = "$anho-$mes-01";        
        $lastDayOfMonth = date("t", strtotime($iniDate));        
        $finDate = "$anho-$mes-$lastDayOfMonth";
        
        $dataaccess = new dalpago();
        return $dataaccess->listPagosDelMes($iniDate, $finDate);
    }
            
}
