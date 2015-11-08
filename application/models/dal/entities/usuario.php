<?php
require_once 'PDO2Object.php';

class usuario extends PDO2Object
{

	public $idusuario;
        public $cuenta;
	public $password;

        public function setId($id)
        {
            $this->idusuario=$id;
	}
        
	public function getId()
        {
            return $this->idusuario;
	}        

}