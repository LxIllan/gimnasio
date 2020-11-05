<?php
	require_once 'ProductoDAO.php';

	class AdminProductos {
		
		private $productoDAO;

		public function __construct() {
			$this->productoDAO = new ProductoDAO();
		}

		public function agregarProducto($nombre, $rutaFotografia, $precio, $contenido, $numPiezas, $idTipoProducto) {
			$idProducto = 1;
			return $this->productoDAO->agregarProducto(new Producto($idProducto, $nombre, $rutaFotografia, $precio, 
													$contenido, $numPiezas, $idTipoProducto));
		}

		public function getSiguienteId() {
			return $this->productoDAO->getSiguienteId();
		}

		public function editarProducto($producto) {
			return $this->productoDAO->editarProducto($producto);
		}

		public function surtirProducto($idProducto, $numPiezas) {
			return $this->productoDAO->surtirProducto($idProducto, $numPiezas);
		}

		public function venderProducto($idProducto, $piezasVendidas, $idGimnasio, $idRecepcionista) {
			return $this->productoDAO->venderProducto($idProducto, $piezasVendidas, $idGimnasio, 
					$idRecepcionista);
		}

		public function eliminarProducto($idProducto) {
			return $this->productoDAO->eliminarProducto($idProducto);
		}

		public function consultarProducto($idProducto) {
			return $this->productoDAO->dameProducto($idProducto);
		}

		public function listarProductos($nombre = '') {
			return $this->productoDAO->dameProductos($nombre);
		}

		public function dameVentaDeProductos($ventasDeHoy) {
			return $this->productoDAO->dameVentaDeProductos($ventasDeHoy);
		}

		public function dameVentaDeProductosFechas($fechaInicio, $fechaFin) {
			return $this->productoDAO->dameVentaDeProductosFechas($fechaInicio, $fechaFin);
		}

		public function registrarVisita($idGimnasio, $idRecepcionista) {
			return $this->productoDAO->registrarVisita($idGimnasio, $idRecepcionista);
		}

		public function editarVisita($precio) {
			return $this->productoDAO->editarVisita($precio);
		}
	}	
?>