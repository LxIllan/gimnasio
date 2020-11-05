<?php
	require_once 'TipoProductoDAO.php';

	class AdminTiposProducto {
		
		private $tipoProductoDAO;

		public function __construct() {
			$this->tipoProductoDAO = new TipoProductoDAO();
		}

		public function agregarTipoProducto($tipoProducto) {
			return $this->tipoProductoDAO->agregarTipoProducto(new TipoProducto(1, $tipoProducto));
		}

		public function editarTipoProducto($tipoProducto) {
			return $this->tipoProductoDAO->editarTipoProducto($tipoProducto);
		}

		public function eliminarTipoProducto($idTipoProducto) {
			return $this->tipoProductoDAO->eliminarTipoProducto($idTipoProducto);
		}

		public function consultarTipoProducto($idTipoProducto) {
			return $this->tipoProductoDAO->dameTipoProducto($idTipoProducto);
		}

		public function listarTiposProducto($nombre = '') {
			return $this->tipoProductoDAO->dametiposProducto($nombre);
		}
	}
?>