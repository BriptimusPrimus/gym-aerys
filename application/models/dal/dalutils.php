<?php
require_once 'entities/PDO2Object.php';

//Esta clase es para hacer consultas genéricas
class dalutils extends PDO2Object
{    
    public function getRecord($entity, $id)
    {     
        $key = "id" . $entity;
        $SQLCommand = 
        "SELECT * 
        FROM $entity 
        WHERE $key = $id";
        $recordset = parent::query($SQLCommand);		
        return parent::handle($recordset);
    }    
    
    public function getList($entidad, $Filtro = "")
    {     
        if ($Filtro != "")
        {
            $Filtro=" WHERE ".$Filtro;
        }
        $recordset = parent::queryArray("Select * from $entidad $Filtro");		
        return $recordset;
    }                 
    
    public function CrearCombo( $entidad, $displayValue, $selectedId, $Filtro = "" ) 
    {
        if ($Filtro!="")
        {
            $Filtro=" WHERE ".$Filtro;
        }
        
        $keyValue = 'id' . $entidad;
        
        $result="<select class='input-block-level' name='combo$entidad' id='combo$entidad' onchange='javascript:void(comboDependiente$entidad());'>";
        if($selectedId == 0)
        {
            $result.="<option value='0' selected></option>";
        }    

        $recordset=parent::query("Select * from $entidad $Filtro");
        while ($records=parent::handle($recordset))
        {            
            $value = $records->$displayValue;
            $key = $records->$keyValue;
         
            if($key == $selectedId)
            {
                $result.="<option value='$key' selected>$value</option>";
            }
            else
            {
                $result.="<option value='$key'>$value</option>";
            }
        }
        $result.='</select>';
        return $result;
    }
    
    //Crea combo con 2 valores concatenados separados por un '#'
    public function CrearCombo2Valores( $entidad, $secondVal, $displayValue, $selectedId, $Filtro = "" ) 
    {
        if ($Filtro!="")
        {
            $Filtro=" WHERE ".$Filtro;
        }
        
        $keyValue = 'id' . $entidad;
        
        $result="<select name='combo$entidad' id='combo$entidad' onchange='javascript:void(comboDependiente$entidad());'>";
        if($selectedId == 0)
        {
            $result.="<option value='0' selected></option>";
        }    

        $recordset=parent::query("Select * from $entidad $Filtro");
        while ($records=parent::handle($recordset))
        {            
            $value = $records->$displayValue;
            $key = $records->$keyValue;
            $key2 = $records->$secondVal;
         
            if($key == $selectedId)
            {
                $result.="<option value='$key#$key2' selected>$value</option>";
            }
            else
            {
                $result.="<option value='$key#$key2'>$value</option>";
            }
        }
        $result.='</select>';
        return $result;
    }    

}