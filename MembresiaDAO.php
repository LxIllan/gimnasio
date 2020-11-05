<?php	

	require_once 'Conexion.php';
	require_once 'Membresia.php';
	require_once 'Util.php';


	class MembresiaDAO {

		private $conexion;

		public function __construct() {
			$this->conexion = new Conexion();
		}

		public function agregarMembresia(Membresia $membresia) {
			return $this->conexion->sentencia("INSERT INTO membresia(membresia, costo) VALUES ('" . 
				$membresia->getMembresia(). "', " . $membresia->getCosto() . ")");
		}

		public function editarMembresia(Membresia $membresia) {
			return $this->conexion->sentencia("UPDATE membresia" . 
				" SET membresia = '" . $membresia->getMembresia() . 
				"', costo = " . $membresia->getCosto() . " WHERE idmembresia = " . 
				$membresia->getIdMembresia());
		}

		public function eliminarMembresia($idMembresia) {
			return $this->conexion->sentencia("DELETE FROM membresia WHERE idmembresia = " .
                $idMembresia);
		}

		public function dameMembresia($idMembresia) {					
			try {
				$tupla = $this->conexion->consultarTupla("SELECT * FROM membresia WHERE idmembresia = " . $idMembresia);
				return new Membresia($tupla["idmembresia"], $tupla["membresia"], $tupla["costo"]);
			} catch (DatosInvalidosException $e) {
				echo $e->getMessage();
			}			
			return null;	
		}		

		public function dameMembresias($nombre = '') {
			$membresias = new ArrayList();
			$result = $this->conexion->consultar("SELECT * FROM membresia " .
                "WHERE membresia LIKE '%" . $nombre . "%'");
			try {
				while($row = $result->fetch_array()) {
					$membresias->add(new Membresia($row['idmembresia'], $row['membresia'],
                        $row['costo']));
                }
                $result->free();
			} catch (DatosInvalidosException $e) {
				echo $e->getMessage();
			}
			return $membresias->isEmpty() ? null : $membresias;
		}
	}