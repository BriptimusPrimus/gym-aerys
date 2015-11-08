<?php
require_once 'PDO2Object.php';

class pago extends PDO2Object
{

	public $idpago;
        public $idpersona;
	public $idpaquete;
        public $fecha;
        public $monto;
        public $descuento;

        public function setId($id)
        {
            $this->idpago=$id;
	}
        
	public function getId()
        {
            return $this->idpago;
	}        

}