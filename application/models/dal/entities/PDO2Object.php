<?php
#######################################################################################
# Class Name : PDO2Object
# @author Armando Ceballos / Roberto Brito
# Last Mofidy Date : 2016-06-17
# License : GPL
# Email : sarjo6 [at] gmail [dot] com
#######################################################################################

require_once __DIR__.'/Configuration.php';
/**
 * Class DB
 */
class PDO2Object extends PDO
{
    /*** Attributes: ***/
    
    /**
    * Atributo que contiene la Configuracion con la que se creara la conexion y otros parametros
    * @var object
    * @access private
    */
    private $Configuration;

    /**
    * Constructor de la Clase
    *
    * @param Configuration Configuration
    * @return
    * @access public
    */
    public function __construct($Configuration=NULL)
    {
        if ($Configuration==NULL)
        {
            $this->Configuration=new Configuration();
        }else{
            $this->Configuration=$Configuration;
        }
        switch ($this->Configuration->typedb)
        {
            case 'pgsql':
                $str = 'pgsql:host='.$this->Configuration->server.';dbname='. $this->Configuration->database;
            break;
            case 'sqlite':
                $str = 'sqlite:'. $this->Configuration->db_file;
            break;  
            case 'firebird':
                $str = 'firebird:dbname='.$this->Configuration->server.':'. $this->Configuration->database . '", "SYSDBA", "masterkey';
            break;  
            case 'informix':
                $str = 'informix:DSN='. $this->Configuration->database;
            break;  
            case 'oracle':
            case 'OCI':
                $str = 'OCI:dbname='. $this->Configuration->database . ';charset=UTF-8';
            break;  
            case 'dblib':
                $str = 'dblib:host='.$this->Configuration->server.':10060;dbname='. $this->Configuration->database;
            break;  
            case 'ibm':
                $str = 'ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE='. $this->Configuration->database . '; HOSTNAME='.$this->Configuration->server.';PORT=56789;PROTOCOL=TCPIP;';
            break;
            case 'mssql':
                $str = 'mssql:host='.$this->Configuration->server.',1433;dbname='. $this->Configuration->database ;
            break;  
            default:
                $str = 'mysql:host='.$this->Configuration->server.';dbname='. $this->Configuration->database;
            break;
        }
        try 
        {
            parent::__construct($str, $this->Configuration->user, $this->Configuration->password);
            $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $this->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        }
        catch (Exception $e) 
        {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
    * Metodo para borrar de la tabla 
    * @param string table
    * @param string condition
    * @return PDOStatement
    * @access public
    */
    public function delete($table, $condition='')
    {
        if ($condition!=''){
            $condition='WHERE '.$condition;
        }
        $sql="DELETE FROM ".$this->Configuration->tablePrefix."$table $condition";        
        try
        {
            return parent::exec($sql);
        }        
        catch (Exception $e) 
        {
            print "La cadena de delete es = ".$sql."<br/>";
            print "¡Error!: " . $e->getMessage() . "<br/>";
        }
    }

    /**
    * Metodo para ejecutar query en la Base de datos
    * @param string string
    * @return bool
    * @access public
    */
    public function query($string)
    {
        try
        {
            return parent::query($string);    
        }
        catch (Exception $e) 
        {
            print "La cadena de la query es = ".$string."<br/>";
            print "¡Error!: " . $e->getMessage() . "<br/>";
        }
    }

    /**
    * Metodo para insertar en la tabla 
    * @param string table
    * @param string columns
    * @param string values
    * @return bool
    * @access public
    */
    public function insert($table, $columns, $values)
    {
        $sql="INSERT INTO ".$this->Configuration->tablePrefix."$table ($columns) VALUES ($values)";
        try
        {
            parent::exec($sql);
            return true;
        }        
        catch (Exception $e) 
        {
            print "La cadena de insert es = ".$sql."<br/>";
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return false;
        }
    }

    /**
    * Metodo para actualizar en la tabla 
    * @param string table
    * @param string string
    * @param string condition
    * @return bool
    * @access public
    */
    public function update($table, $string, $condition = '')
    {
        $condition = ($condition!='') ?  'WHERE '.$condition : $condition;
        $sql='UPDATE '.$this->Configuration->tablePrefix."$table SET $string $condition";        
        try
        {
            parent::exec($sql);
            return true;
        }
        catch (Exception $e) 
        {
            print "La cadena de update es = ".$sql."<br/>";
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return false;
        }
    }

    /**
    * Metodo para contabilizar campos en una query
    * @param PDOStatement query
    * @return int
    * @access public
    */
    public function howMany($query)
    {
        try {
            return $query->rowCount();    
        } 
        catch (Exception $e) 
        {
            print "¡Error!: " . $e->getMessage() . "<br/>";   
        }
    }

    /**
    * Metodo para conseguir un campo en forma de objeto
    * @param PDOStatement query
    * @return object
    * @access public
    */
    public function handle($query)
    {
        try
        {
            return $query->fetchObject();    
        }
        catch (Exception $e) 
        {
            print "¡Error!: " . $e->getMessage() . "<br/>";   
        }   
    }

    /**
    * Metodo para persistir datos en la DB
    * Crea un update o insert segun sea el caso para guardar atributos de objetos en DB
    * @param object class
    * @return bool
    * @access public
    */
    public function persist($class=NULL)
    {
        if ($class==NULL)
        {
            $class=$this;
        }
        $columns='';
        $values='';
        foreach (get_object_vars($class) as $key => $value) 
        {
            if (($key!='Configuration') and ($key!='key') and ($key!='id'.get_class($class)))
            {
                if(isset($this->$key))
                {
                    $columns.="$key,";
                    $value=$this->clean($value);
                    $values.= ($class->getId()==0) ? "'$value'," : "$key='$value',";    
                }
            }            
        }
        $columns=substr($columns, 0, strlen($columns)-1);
        $values=substr($values, 0, strlen($values)-1);
        if ($class->getId()==0)
        {
            $insert=$this->insert($this->Configuration->tablePrefix.get_class($class), $columns, $values);
            $class->setId($this->lastInsertId());                 
            return $insert;
        }
        else
        {
            $id=$class->getId();
            $key=(empty($this->key))? "id".get_class($class) : $this->key;
            return $this->update($this->Configuration->tablePrefix.get_class($class), $values, $key."='$id'");
        }
    }

    /**
    * Metodo para cargar datos de un registro a un objeto
    * @param mixe id
    * @param object class
    * @return 
    * @access public
    */
    public function charge($id, $class=NULL)
    {
        if ($class==NULL)
        {
            $class=$this;
        }
        $table=$this->Configuration->tablePrefix.get_class($class);
        $key=(isset($this->key)) ? $this->key : "id".get_class($class);
        $object=$this->handle($this->query("select * from $table where ".$key."='$id'"));
        
        if($object == null)
        {
            $class->setId(0);
            return;            
        }
        
        if (serialize($object)!="b:0;")
        {
            $class->setId($id);
        }
        foreach (get_object_vars($object) as $key => $value)
        {
            if (($key!="Configuration") and ($key!="key")) {
                $class->$key=$object->$key;
            }
        }
    }

    /**
    * Metodo para destruir un objeto en la DB
    * @param object class
    * @return bool
    * @access public
    */
    public function destroy($class=NULL)
    {
        if ($class==NULL)
        {
            $class=$this;
        }
        $id=$class->getId();
        $key=(isset($this->key)) ? $this->key : "id".get_class($class);
        return $this->delete($this->Configuration->tablePrefix.get_class($class), $key."='$id'");
    }

    /**
    * Metodo para limpiar una variable de posibles injexxiones o xss
    * @param string string
    * @return 
    * @access public
    */
    public function clean($string)
    {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        //$string = mysql_real_escape_string($string);
        return htmlspecialchars(rawurldecode(trim($string)), ENT_QUOTES,'UTF-8');
    }

    /**
    * Metodo para cargar un array asosiativo en el objeto
    * Particularmente creado para cargar con POST o GET objetos
    * @param array array
    * @return 
    * @access public
    */
    public function populate($array)
    {
        foreach ($array as $key => $value) {
            if (property_exists($this,$key)) {
                //@todo Limpiar la entrada antes de cargarla en el objeto
                $this->$key=$value;  
            }
        }
    }

    //FUNCIONES NUEVAS DE PRUEBA PARA INTEGRACION


    //esta funcion solo funciona si la llave se llama id$clase
    public function getId()
    {
        $llave='id'.get_class($this);
        if (empty($this->llave))
        {
            return @$this->$llave;
        }else{
            return 0;
        }
    }

    public function setId($id)
    {
        $llave='id'.get_class($this);
        $this->$llave=$id;
    }

    //esta ocupa ser probada sobre todo con tablas grandes
    public function getAll($condition='')
    {
        $condition=(empty($condition)) ? $condition : ' where '.$condition;
        $query=$this->query('select * from '.get_class($this).$condition);
        $todos=array();
        while ($uno=$this->handle($query)) {
            $todos[]=$uno;
        }
        return $todos;
    }
    
    public function queryArray($string)
    {
        $query=$this->query($string);
        $resultset=array();
        while ($record=$this->handle($query)) {
            $resultset[]=$record;
        }
        return $resultset;
    }    
   
}//end of DB