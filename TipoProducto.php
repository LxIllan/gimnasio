<?php 
	class TipoProducto {
		
		const MAX_CHAR_TIPO_PRODUCTO = 20;

		private $idTipoProducto;
		private $tipoProducto;

		public function __construct($idTipoProducto, $tipoProducto) {
			$this->idTipoProducto = $idTipoProducto;
			$this->tipoProducto = $tipoProducto;
		}

		public function setTipoProducto($tipoProducto) {
			if (strlen($tipoProducto) <= self::MAX_CHAR_TIPO_PRODUCTO) {
				$this->tipoProducto = $tipoProducto;
				return True;
			} else {
				return False;
			}			
		}

		public function getIdTipoProducto() {
			return $this->idTipoProducto;
		}

		public function getTipoProducto() {
			return $this->tipoProducto;
		}
	}
?>