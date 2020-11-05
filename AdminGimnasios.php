<?php
	require_once 'Gimnasio.php';
	require_once 'GimnasioDAO.php';
		
	class AdminGimnasios {
		
		private $_gimnasioDAO;

		function __construct() {
			$this->_gimnasioDAO = new GimnasioDAO();
		}

		public function agregarGimnasio($nombre) {
		    $idGimnasio = 1;
		    $dinero = 0.0;
			return $this->_gimnasioDAO->agregarGimnasio(new Gimnasio($idGimnasio, $nombre, $dinero));
		}

		public function editarGimnasio($gimnasio) {
			return $this->_gimnasioDAO->editarGimnasio($gimnasio);
		}

		public function consultarGimnasio($idGimnasio) {
			return $this->_gimnasioDAO->dameGimnasio($idGimnasio);
		}

		public function listarGimnasios($nombre = '') {
			return $this->_gimnasioDAO->dameGimnasios($nombre);
		}

		public function dameNombre($idGimnasio) {
			return $this->_gimnasioDAO->dameNombre($idGimnasio);
		}
	}
?>