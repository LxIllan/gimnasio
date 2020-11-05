<?php 		
	class Producto {
		
		const VISITA = 1;
		const MAX_CHAR_NOMBRE = 30;
		const MAX_CHAR_CONTENIDO = 20;

		private $idProducto;
		private $nombre;
		private $rutaFotografia;
		private $precio;
		private $contenido;
		private $numPiezas;
		private $idTipoProducto;

		public function __construct($idProducto, $nombre, $rutaFotografia, $precio, $contenido, $numPiezas, 
									$idTipoProducto) {
			$this->idProducto = $idProducto;
			$this->nombre = $nombre;
			$this->rutaFotografia = $rutaFotografia;
			$this->precio = $precio;
			$this->contenido = $contenido;
			$this->numPiezas = $numPiezas;
			$this->idTipoProducto = $idTipoProducto;
		}

		public function setNombre($nombre) {
			$this->nombre = $nombre;
		}

		public function setRutaFotografia($rutaFotografia) {
			$this->rutaFotografia = $rutaFotografia;
		}

		public function setPrecio($precio) {
			$this->precio = $precio;	
		}

		public function setContenido($contenido) {
			$this->contenido = $contenido;
		}

		public function setNumPiezas($numPiezas) {
			$this->numPiezas = $numPiezas;
		}

		public function setIdTipoProducto($idTipoProducto) {
			$this->idTipoProducto = $idTipoProducto;
		}

		public function getIdProducto() {
			return $this->idProducto;
		}

		public function getNombre() {
			return $this->nombre;
		}

		public function getRutaFotografia() {
			return $this->rutaFotografia;
		}

		public function getPrecio() {
			return $this->precio;
		}

		public function getContenido()  {
			return $this->contenido;
		}

		public function getNumPiezas() {
			return $this->numPiezas;
		}

		public function getIdTipoProducto() {
			return $this->idTipoProducto;
		}
	}
?>