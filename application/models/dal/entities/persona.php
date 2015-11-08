<?php
require_once 'PDO2Object.php';

class persona extends PDO2Object
{

	public $idpersona;
        public $nombre;
        public $apaterno;
        public $amaterno;
        public $direccion;
        public $telefono;
        public $email;
        public $contacto;
        public $contactotelefono;
        public $fecharegistro;
        public $fechainscripcion;
        public $montoinscripcion;
        public $inscrito;
        public $activo;

        public function setId($id)
        {
            $this->idpersona=$id;
	}
        
	public function getId()
        {
            return $this->idpersona;
	}        

}