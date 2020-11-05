<?php

	class Conexion {

		const SERVIDOR = "mysql.hostinger.mx";
		const USUARIO = "u775772700_gimna";
		const PASSWORD = "u775772700_Gimna";
		const BASE_DE_DATOS = "u775772700_gimna";

		private $_mysqli;

        function __construct() {
            date_default_timezone_set('America/Mexico_City');
            setlocale(LC_MONETARY, 'en_ES');

            $this->_mysqli = new mysqli(self::SERVIDOR, self::USUARIO,
                    self::PASSWORD, self::BASE_DE_DATOS);
			if ($this->_mysqli->connect_errno) {
				echo 'Conexión Fallida : ' . $this->_mysqli->connect_error;
				exit();
			}
		}

        public function __destruct() {
            $this->_mysqli->close();
    	}

        public function consultar(string $query) {
			return $this->sentencia($query);
		}

        public function consultarTupla(string $query) {
			$result = $this->sentencia($query);
			return $result->fetch_array();
		}

        public function sentencia(string $query) {
            return $this->_mysqli->query($query);
        }
    }