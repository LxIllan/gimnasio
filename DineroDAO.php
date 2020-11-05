<?php

	require_once 'Conexion.php';
	require_once 'Util.php';
	require_once 'RetiroDeEfectivo.php';

	class DineroDAO {
		
		private $conexion;

		function __construct() {
			$this->conexion = new Conexion();
		}

		public function actualizarMontoActual($idGimnasio, $monto) {
			$sumaTotal = $this->obtenerIngresoNeto($idGimnasio);
			$sumaTotal += $monto;
			return $this->conexion->sentencia("UPDATE gimnasio SET dinero = " . $sumaTotal .
                " WHERE idgimnasio = " . $idGimnasio);
		}

		public function obtenerIngresoNeto($idGimnasio) {
			$tupla = $this->conexion->consultarTupla("SELECT dinero FROM gimnasio " .
                "WHERE idgimnasio = " . $idGimnasio);
			if ($tupla != null) {
				return $tupla[0];	
			} else {
				return 0.0;
			}			
		}

		public function retirarEfectivo(int $idGimnasio, RetiroDeEfectivo $retiroDeEfectivo) {
			if ($this->conexion->sentencia("INSERT INTO retiro_efectivo(monto, fecha, justificacion) "
				. "VALUES(". $retiroDeEfectivo->getMonto() . ", '" 
				. $retiroDeEfectivo->getFecha() . "','" 
				. $retiroDeEfectivo->getJustificacion() . "')")) {
					self::actualizarMontoActual($idGimnasio, -$retiroDeEfectivo->getMonto());
					return true;
			} else {
				return false;
			}
		}

		public function dameRetiro($idRetiro) {
			$tupla = $this->conexion->consultarTupla("SELECT idretiro, monto, fecha, justificacion FROM retiro_efectivo WHERE idretiro = " . $idRetiro);
			if ($tupla != null) {
				return new retiroDeEfectivo($tupla[0], $tupla[1], $tupla[2], $tupla[3]);
			} else {
				return $tupla;
			}
		}

		public function cancelarRetiro($idRetiro) {
			return $this->conexion->sentencia("DELETE FROM retiro_efectivo WHERE idretiro = " . $idRetiro);
		}

		public function listarRetirosDeEfectivo() {
			$retirosDeEfectivo = new ArrayList();
			$result = $this->conexion->consultar("SELECT * FROM retiro_efectivo");
			while ($tupla = $result->fetch_array()) {
				$retirosDeEfectivo->add(new retiroDeEfectivo($tupla['idretiro'], $tupla['monto'],
                        $tupla['fecha'], $tupla['justificacion']));
			}
            return !$retirosDeEfectivo->isEmpty() ? $retirosDeEfectivo : null;
		}
	}