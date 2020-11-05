<?php
    require_once 'Util.php';

	class Membresia {

		const MENSUAL = 1;
    	const TRIMESTRAL = 2;
    	const SEMESTRAL = 3;
    	const ANUAL = 4;
    	const SEMANAL = 5;

		const MAX_CHAR_MEMBRESIA = 11;   	

		private $idMembresia;
		private $membresia;
		private $costo;

		public function __construct($idMembresia = 0, $membresia, $costo) {
			$this->idMembresia = $idMembresia;
			$this->membresia = $membresia;
			$this->costo = $costo;
		}

		public function setMembresia($membresia) {
			if (strlen($membresia) <= self::MAX_CHAR_MEMBRESIA) {
				$this->membresia = $membresia;
				return True;
			} else {
				return False;
			}
		}

		public function setCosto($costo) {	
			if ($costo > 0) {				
				$this->costo = $costo;
				return True;
			} else {				
				return False;
			}
		}

		public function getIdMembresia() {
			return $this->idMembresia;
		}

		public function getMembresia() {
			return $this->membresia;
		}

		public function getCosto() {
			return $this->costo;
		}		
	}
 ?>