<?php

    require_once 'Util.php';

    class RetiroDeEfectivo {

		private $idRetiroDeEfectivo;
		private $monto;
		private $fecha;
		private $justificacion;

		function __construct($idRetiroDeEfectivo, $monto, $fecha, $justificacion) {
			if ($monto > 0) {
				$this->idRetiroDeEfectivo = $idRetiroDeEfectivo;
				$this->monto = $monto;
				$this->fecha = $fecha;
				$this->justificacion = $justificacion;
			} else {
				throw new DatosInvalidosException("Tiene que retirar al menos un peso.");
			}
		}

		public function setMonto($monto) {
			if ($monto > 0) {
				$this->monto = $monto;
				return true;
			} else {
				return false;
			}
		}

		public function setJustificacion($justificacion) {
			if (strlen($justificacion) > 0) {
				$this->justificacion = $justificacion;
				return true;
			} else {
				return false;	
			}
		}

		public function getIdRetiroDeEfectivo() {
			return $this->idRetiroDeEfectivo;
		}

		public function getMonto() {
			return $this->monto;
		}

		public function getFecha() {
			return $this->fecha;
		}

		public function getJustificacion() {
			return $this->justificacion;
		}
	}
?>