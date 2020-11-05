<?php

    require_once 'Gimnasio.php';

	class Gimnasio {
		
		const MAX_CHAR_NOMBRE = 45;

		private $_idGimanasio;
		private $_nombre;
		private $_dinero;		

		function __construct(int $idGimnasio, string $nombre, float $dinero) {
            if ((!$this->setNombre($nombre)) && (!$this->setDinero($dinero))) {
                throw new DatosInvalidosException(Util::$datosInvalidos);
            } else {
                $this->_idGimanasio = $idGimnasio;
            }
		}

		public function setNombre(string $nombre): bool {
			if ((is_string($nombre)) && (strlen($nombre) <= self::MAX_CHAR_NOMBRE)) {
				$this->_nombre = $nombre;
				return true;
			} else {
				return false;
			}
		}

		public function setDinero(float $dinero): bool {
			if ((is_float($dinero)) && ($dinero >= 0)) {
				$this->_dinero = $dinero;
				return true;
			} else {
				return false;
			}
		}

		public function getIdGimnasio(): int {
			return $this->_idGimanasio;
		}

		public function getNombre(): string {
			return $this->_nombre;
		}

		public function getDinero(): float {
			return $this->_dinero;
		}
	}