<?php

	class Usuario {
		
		const ROOT = 1;
		const COMUN = 0;
		
		const MAX_CHAR_NOMBRE = 45;
    	const MAX_CHAR_APELLIDO = 20;
    	const MAX_CHAR_CORREO = 50;
    	const MAX_CHAR_RUTA_FOTO = 100;
    	const MAX_CHAR_TELEFONO = 20;
    	const MAX_CHAR_CLAVE = 40;
    	const MAX_CHAR_DOMICILIO = 50;

    	private $idUsuario;
    	private $nombrePila;
    	private $apellido1;
	    private $apellido2;
	    private $rutaFotografia;
	    private $correo;
	    private $telefono;
	    private $domicilio;
	    private $clave;
	    private $root;
	    private $habilitado;
	    private $idGimnasio;

		function __construct($idUsuario, $nombrePila, $apellido1, $apellido2, $correo,
					$telefono, $domicilio, $clave, $rutaFotografia, $root, $habilitado,
					$idGimnasio) {
			$this->idUsuario = $idUsuario;
	    	$this->nombrePila = $nombrePila;
	    	$this->apellido1 = $apellido1;
		    $this->apellido2 = $apellido2;
		    $this->correo = $correo;
		    $this->telefono = $telefono;
		    $this->domicilio = $domicilio;
		    $this->clave = $clave;
		    $this->rutaFotografia = $rutaFotografia;
		    $this->root = $root;
		    $this->habilitado = $habilitado;
		    $this->idGimnasio = $idGimnasio;
		}

		public function setNombrePila($nombrePila) {
			if (strlen($nombrePila) <= self::MAX_CHAR_NOMBRE) {
			    $this->nombrePila = $nombrePila;
			    return true;
			} else {
			    return false;
			}
		}

	    public function setApellido1($apellido1) {
			if (strlen($apellido1) <= self::MAX_CHAR_APELLIDO) {
			    $this->apellido1 = $apellido1;
			    return true;
			} else {
			    return false;
			}
	    }

	    public function setApellido2($apellido2) {
			if (strlen($apellido2) <= self::MAX_CHAR_APELLIDO) {
			    $this->apellido2 = $apellido2;
			    return true;
			} else {
			    return false;
			}
	    }

	    public function setRutaFotografia($rutaFotografia) {
			if (strlen($rutaFotografia) <= self::MAX_CHAR_RUTA_FOTO) {
			    $this->rutaFotografia = $rutaFotografia;
			    return true;
			} else {
			    return false;
			}
	    }

	    public function setCorreo($correo) {
			if (strlen($correo) <= self::MAX_CHAR_CORREO) {
			    $this->correo = $correo;
			    return true;
			} else {
			    return false;
			}
	    }

	    public function setTelefono($telefono) {
	    	if (strlen($telefono) <= self::MAX_CHAR_TELEFONO) {
	    		$this->telefono = $telefono;
	    		return true;
	    	} else {
	    		return false;
	    	}
	    }

	    public function setDomicilio($domicilio) {
	    	if (strlen($domicilio) <= self::MAX_CHAR_DOMICILIO) {
	    		$this->domicilio = $domicilio;
	    		return true;
	    	} else {
	    		return false;
	    	}
	    }
		 
		public function setClave($clave) {
			if (strlen($clave) <= self::MAX_CHAR_CLAVE) {
			    $this->clave = $clave;
			    return true;
			} else {
			    return false;
			}
	    } 

	    public function getIdUsuario() {
			return $this->idUsuario;
		}

		public function getNombrePila() {
			return $this->nombrePila;
	    }

	    public function getApellido1() {
			return $this->apellido1;
	    }

	    public function getApellido2() {
			return $this->apellido2;
	    }

	    public function getCorreo() {
			return $this->correo;
	    }

	    public function getDomicilio() {
	    	return $this->domicilio;
	    }
	    
	    public function getTelefono() {
	    	return $this->telefono;
	    }

	    public function getRutaFotografia() {
			return $this->rutaFotografia;
	    }

	    public function getClave() {
	    	return $this->clave;
	    }

	    public function getRoot() {
	    	return $this->root;
	    }

	    public function getHabilitado() {
	    	return $this->habilitado;
	    }

	    public function getIdGimnasio() {
			return $this->idGimnasio;
	    }	    
	}
?>