<?php

require_once 'SocioDAO.php';
require_once 'Socio.php';
require_once 'Util.php';

class AdminSocios{
	
	private $socioDAO;

	function __construct() {
		$this->socioDAO = new SocioDAO();
	}

	public function agregarSocio($nombrePila, $apellido1, 
			$apellido2, $fechaNacimiento, $idSexo, $peso, $estatura, $lesionAbdomen, 
			$lesionBrazos, $lesionEspalda, $lesionHombro, $lesionPecho, $lesionPiernas,
			$correo, $rutaFotografia, $diasEntrenando, $idMembresia,
									int $idGimnasio, int $idRecepcionista) {
										echo 'S';
			$idSocio = 1;
			$fechaInscripcion = 1;
			$ultimaAsistencia = 1;
			$fechaFinMembresia = 1;
			$oculto = 1;
			return $this->socioDAO->agregarSocio(new Socio($idSocio, $nombrePila, $apellido1, 
				$apellido2, $fechaNacimiento, $idSexo, $peso, $estatura, $lesionAbdomen, 
				$lesionBrazos, $lesionEspalda, $lesionHombro, $lesionPecho, $lesionPiernas,
				$correo, $rutaFotografia, $fechaInscripcion, $ultimaAsistencia,
				$diasEntrenando, $fechaFinMembresia, $oculto, $idMembresia), $idGimnasio, $idRecepcionista);
	}

	public function editarSocio($socio) {
		return $this->socioDAO->editarSocio($socio);
	}

	public function renovarMembresia($idSocio, $idMembresia, $fechaDePago, $idGimnasio,
						$idRecepcionista) {
		return $this->socioDAO->renovarMembresia($idSocio, $idMembresia, $fechaDePago, 
					$idGimnasio, $idRecepcionista);
	}

	public function ocultarSocio(int $idSocio) {
		return $this->socioDAO->ocultarSocio($idSocio);
	}

	public function desOcultarSocio(int $idSocio) {
		return $this->socioDAO->desOcultarSocio($idSocio);
	}

	public function eliminarSocio(int $idSocio) {
		return $this->socioDAO->eliminarSocio($idSocio);
	}

	public function consultarSocio($idSocio) {
		return $this->socioDAO->dameSocio($idSocio);
	}

	public function getLesion(int $idSocio, int $idParteDelCuerpo)
	{
		return $this->socioDAO->getLesion($idSocio, $idParteDelCuerpo);
	}

	public function getNivel(int $idSocio)
	{
		return $this->socioDAO->getNivel($idSocio);
	}

	public function setAsistencia(int $idSocio) {
		return $this->socioDAO->setAsistencia($idSocio);
	}

	public function listarSocios(string $nombre = '') {
		return $this->socioDAO->dameSocios($nombre);
	}

	public function listarSociosOcultos(string $nombre = '') {
		return $this->socioDAO->dameSociosOcultos($nombre);
	}	    

	public function dameVentaDeMembresias($ventasDeHoy) {
		return $this->socioDAO->dameVentaDeMembresias($ventasDeHoy);
	}

	public function dameVentaDeMembresiasFechas($fechaIncio, $fechaFin) {
		return $this->socioDAO->dameVentaDeMembresiasFechas($fechaIncio, $fechaFin);
	}

	public function getSiguienteId() {
		return $this->socioDAO->getSiguienteId();
	}

	public function existeCorreo(string $correoElectronico) {
		return $this->socioDAO->existeCorreo($correoElectronico);
	}

	public function validarSesion(int $idSocio, string $correoElectronico) {
		return $this->socioDAO->validarSesion($idSocio, $correoElectronico);
	}
}