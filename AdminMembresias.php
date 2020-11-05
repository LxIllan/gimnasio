<?php 	
	require_once 'MembresiaDAO.php';
	require_once 'Util.php';

	class AdminMembresias {
		
		private $membresiaDAO;

		public function __construct() {
			$this->membresiaDAO = new MembresiaDAO();
		}

		public function agregarMembresia($membresia, $costo) {
			$idMembresia = 1;
			return $this->membresiaDAO->agregarMembresia(new Membresia($idMembresia, $membresia, $costo));
		}

		public function editarMembresia($membresia) {
			return $this->membresiaDAO->editarMembresia($membresia);
		}

		public function eliminarMembresia($idMembresia) {
			return $this->membresiaDAO->eliminarMembresia($idMembresia);
		}

		public function dameMembresia($idMembresia) {
			return $this->membresiaDAO->dameMembresia($idMembresia);
		}

		public function listarMembresias($nombre = '') {
			return $this->membresiaDAO->dameMembresias($nombre);
		}
	}
 ?>