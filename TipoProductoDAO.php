<?php
    require_once 'Conexion.php';
    require_once 'TipoProducto.php';
	require_once 'Util.php';

	class TipoProductoDAO {
		
		private $conexion;

		public function __construct() {
			$this->conexion = new Conexion();
		}

		public function agregarTipoProducto($tipoProducto) {
			return $this->conexion->sentencia("INSERT INTO tipo_producto(tipo_producto) VALUES ('"
		. $tipoProducto->getTipoProducto() . "')");
		}

		public function editarTipoProducto($tipoProducto) {
			return $this->conexion->sentencia("UPDATE tipo_producto SET tipo_prodcuto = '" . $tipoProducto->gettipoProducto() . "' WHERE idtipo_producto = " . $tipoProducto->getIdTipoProducto());
		}

		public function eliminarTipoProducto($idTipoProducto) {
			return $this->conexion->sentencia("DELETE FROM tipo_producto WHERE idtipo_producto = " . $idTipoProducto);
		}

		public function dameTipoProducto($idTipoProducto) {
			$tupla = $this->conexion->consultarTupla("SELECT * FROM tipo_producto WHERE idtipo_producto = " . $idTipoProducto);
			return new TipoProducto($tupla['idtipo_producto'], $tupla['tipo_producto']);
		}

		public function dameTiposProducto($nombre) {
			$tiposProducto = new ArrayList();
			$result = $this->conexion->consultar("SELECT * FROM tipo_producto WHERE tipo_producto LIKE '%$nombre%'");
			while ($tupla = $result->fetch_array()) {
				$tiposProducto->add(new TipoProducto($tupla['idtipo_producto'], $tupla['tipo_producto']));
			}
			if (!$tiposProducto->isEmpty()) {
				return $tiposProducto;
			} else {
				return null;
			}
		}

		public function hayTiposDeProductoRegistrados() {
			$result = $this->conexion->consultar("SELECT * FROM tipo_producto");
			return $result->num_rows > 0;
		}
	}