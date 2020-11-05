<?php

    require_once 'RetiroDeEfectivo.php';
    require_once 'DineroDAO.php';
    require_once 'Util.php';

	class AdminDinero {
		
		private $_dineroDAO;

		function __construct() {
			$this->_dineroDAO = new DineroDAO();
		}

		public function actualizarMontoActual(int $idGimnasio, float $monto): bool {
			return $this->_dineroDAO->actualizarMontoActual($idGimnasio, $monto);
		}

		public function obtenerIngresoNeto(int $idGimnasio): float {
			return $this->_dineroDAO->obtenerIngresoNeto($idGimnasio);
		}

        public function retirarEfectivo($idGimnasio, $monto, $justificacion) {
			try {
				$idRetiro = 1;
			    return $this->_dineroDAO->retirarEfectivo($idGimnasio ,
                    new RetiroDeEfectivo($idRetiro, $monto, date('Y-m-j'),
                        $justificacion));
			} catch (DatosInvalidosException $e) {
			    echo $e->getMessage();
                return null;
            }
		}

		public function dameRetiro($idRetiro) {
			return $this->_dineroDAO->dameRetiro($idRetiro);
		}

		function cancelarRetiro($idRetiro) {
			return $this->_dineroDAO->cancelarRetiro($idRetiro);
		}

        public function listarRetirosDeEfectivo() {
			return $this->_dineroDAO->listarRetirosDeEfectivo();
		}


	}