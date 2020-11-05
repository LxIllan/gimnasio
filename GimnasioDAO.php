<?php

    require_once 'Conexion.php';
    require_once 'Gimnasio.php';
    require_once 'Util.php';
	
	class GimnasioDAO {
		
		private $_conexion;

		function __construct() {
			$this->_conexion = new Conexion();
		}

		public function agregarGimnasio(Gimnasio $gimnasio) {
			return $this->_conexion->sentencia("INSERT INTO gimnasio (nombre, dinero) VALUES " 
				. "('" . $gimnasio->getNombre() . "', 0.0)");
		}

		private function getSiguienteId() {
			$tupla = $this->_conexion->consultarTupla("SELECT AUTO_INCREMENT FROM " 
					. "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'gimnasio'");
			return $tupla[0];
		}

		public function editarGimnasio(Gimnasio $gimnasio) {
			return $this->_conexion->sentencia("UPDATE gimnasio SET "
				. "nombre = '" . $gimnasio->getNombre() . "' "
				. "WHERE idgimnasio = " . $gimnasio->getIdGimnasio());	
		}


		public function dameGimnasio($idGimnasio) {
			$tupla = $this->_conexion->consultarTupla("SELECT idgimnasio, nombre, dinero " . 
				"FROM gimnasio WHERE idgimnasio = " . $idGimnasio);
			if (isset($tupla)) {
				return new Gimnasio($tupla[0], $tupla[1], $tupla[2]);
			} else {
				return null;
			}
		}

		public function dameNombre($idGimnasio) {
			$tupla = $this->_conexion->consultarTupla("SELECT nombre " . 
				"FROM gimnasio WHERE idgimnasio = " . $idGimnasio);
			if (isset($tupla)) {
				return $tupla[0];
			} else {
				return "Gimnasio";
			}	
		}

		public function dameGimnasios($nombre = '') {
			$gimnasios = new ArrayList();
			$result = $this->_conexion->consultar("SELECT idgimnasio, nombre, dinero " . 
				"LIKE '%$nombre%' ORDER BY nombre");
			while ($row = $result->fetch_array()) {
				$gimnasios->add(new Gimnasio($row['idgimnasio'], $row['nombre'], $row['dinero']));
			}
			$result->free();
            return $gimnasios->isEmpty() ? null : $gimnasios;
		}
	}