<?php
require_once 'PDO2Object.php';

class paquete extends PDO2Object
{

	public $idpaquete;
        public $titulo;
	public $costo;
        public $descripcion;

        public function setId($id)
        {
            $this->idpaquete=$id;
	}
        
	public function getId()
        {
            return $this->idpaquete;
	}        

}