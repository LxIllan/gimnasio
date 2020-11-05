<?php

    require_once 'Conexion.php';
	require_once 'Socio.php';
	require_once 'DineroDAO.php';
	require_once 'Ejercicio.php';
	require_once 'Util.php';

	class SocioDAO {
		
		private $conexion;

		public function __construct() {
			$this->conexion = new Conexion();
		}

		public function agregarSocio(Socio $socio, int $idGimnasio, int $idRecepcionista) {
			echo 'S';
			print_r($socio);
			$dineroDAO = new DineroDAO();
			$tupla = $this->conexion->consultarTupla("SELECT costo FROM membresia WHERE "
					. "idmembresia = " . $socio->getIdMembresia());
			$costoMembresia = $tupla[0];
			return $this->conexion->consultar("INSERT INTO socio(nombre_pila, apellido1, "
				. "apellido2, fecha_nacimiento, idsexo, peso, estatura, lesion_abdomen, lesion_brazos, " 
				. "lesion_espalda, lesion_hombro, lesion_pecho, lesion_piernas, correo_electronico, "
				. "ruta_fotografia, fecha_inscripcion, ultima_asistencia, dias_entrenando, "
				. "fecha_fin_membresia, oculto, idmembresia)" 
				. "VALUES ('" . $socio->getNombrePila() . "', '"
				. $socio->getApellido1() . "', '" 
				. $socio->getApellido2() . "', '"
				. $socio->getFechaNacimiento() . "', "
				. $socio->getIdSexo() . ", "
				. $socio->getPeso() . ", "
				. $socio->getEstatura() . ", "
				. $socio->getLesionAbdomen() . ", "
				. $socio->getLesionBrazos() . ", "
				. $socio->getLesionEspalda() . ", "
				. $socio->getLesionHombro() . ", "
				. $socio->getLesionPecho() . ", "
				. $socio->getLesionPiernas() . ", '"
				. $socio->getCorreo() . "', '"
				. $socio->getRutaFotografia() . "', '" 
				. date('Y-m-j') . "', '" // Fecha inscripcion
				. date('Y-m-j') . "', " // Fecha ultima asistencia
				. $socio->getDiasEntrenando() . ", '"
				. Util::fechaFinMembresia($socio->getIdMembresia(), date('Y-m-j')) . "',"
				.  0 . ", " 
				. $socio->getIdMembresia() . " )") 
				&& $this->conexion->sentencia("INSERT INTO venta_membresias(fecha, idmembresia, " 
						."precio, idsocio, idusuario) VALUES ('" . date('Y-m-j') . "', " 
						. $socio->getIdMembresia() . " , " . $costoMembresia
						. " , " . ($this->getSiguienteId() - 1) . ", " . $idRecepcionista . ")") 
				&& $dineroDAO->actualizarMontoActual($idGimnasio, $costoMembresia);
		}

		public function getSiguienteId() {
			$tupla = $this->conexion->consultarTupla("SELECT AUTO_INCREMENT FROM " 
				. "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'socio'");
			return $tupla[0];
		}

		public function getLesion(int $idSocio, int $idParteDelCuerpo)
		{
			$tupla = $this->conexion->consultarTupla('SELECT lesion_abdomen, lesion_brazos, ' 
				. 'lesion_espalda, lesion_hombro, lesion_pecho, lesion_piernas '
				. 'FROM socio WHERE idsocio = ' . $idSocio);
			return $tupla[--$idParteDelCuerpo];
		}

		public function getNivel(int $idSocio)
		{
			$tupla = $this->conexion->consultarTupla('SELECT dias_entrenando ' . 
				'FROM socio WHERE idsocio = ' . $idSocio);
			$diasEntrenados = $tupla[0];
			if ($diasEntrenados <= 0) {
				$diasEntrenados = 0;
			}
			$nivel = '';
			if (($diasEntrenados >= 0) && ($diasEntrenados <= 60)) {
				$nivel = Ejercicio::NIVELES[0];
			} else if (($diasEntrenados >= 61) && ($diasEntrenados <= 160)) {
				$nivel = Ejercicio::NIVELES[1];
			} else if (($diasEntrenados >= 161) && ($diasEntrenados <= 260)) {
				$nivel = Ejercicio::NIVELES[2];
			} else if (($diasEntrenados >= 261) && ($diasEntrenados <= 365)) {
				$nivel = Ejercicio::NIVELES[3];
			} else { // días > 365
				$nivel = Ejercicio::NIVELES[4];
			}
			return $nivel;
		}

		public function setAsistencia(int $idSocio) {
			$tupla = $this->conexion->consultarTupla("SELECT dias_entrenando, ultima_asistencia " . 
				"FROM socio WHERE " . "idsocio = " . $idSocio);
			$diasEntrenados = $tupla[0];
			$ultimaAsistencia = $tupla[1];
			if (((Util::diasSobrantes($ultimaAsistencia)) - 1) != 0) {
				$diasDeDiferencia = (Util::diasSobrantes($ultimaAsistencia) * -1);
				if ($diasDeDiferencia  <= 0) {
					$diasDeDiferencia = 0;
				}
				if ($diasDeDiferencia > 8) {
					$diasEntrenados -= intval(ceil($diasDeDiferencia * .5));
				}
				$diasEntrenados++;
				if ($diasEntrenados < 0) {
					$diasEntrenados = 0;
				}
				return $this->conexion->sentencia("UPDATE socio SET " 
					. "dias_entrenando = " . $diasEntrenados . ", "
					. "ultima_asistencia = '" . date('Y-m-j') . "' "
					. "WHERE idsocio = " . $idSocio);
			} else {
				return false;
			}
		}

		public function editarSocio(Socio $socio) {
			return $this->conexion->sentencia("UPDATE socio SET " 
					. "nombre_pila = '"  . $socio->getNombrePila() . "', " 
					. "apellido1 = '" . $socio->getApellido1()  . "', "
					. "apellido2 = '" . $socio->getApellido2() . "', " 
					. "idsexo = " . $socio->getIdSexo() . ", "
					. "fecha_nacimiento = '" . $socio->getFechaNacimiento() . "', "
					. "peso = " . $socio->getPeso() . ", "
					. "estatura = " . $socio->getEstatura() . ", "
					. "lesion_abdomen = " . $socio->getLesionAbdomen() . ", "
					. "lesion_brazos = " . $socio->getLesionBrazos() . ", "
					. "lesion_espalda = " . $socio->getLesionEspalda() . ", "
					. "lesion_hombro = " . $socio->getLesionHombro() . ", "
					. "lesion_pecho = " . $socio->getLesionPecho() . ", "
					. "lesion_piernas = " . $socio->getLesionPiernas() . ", "
					. "correo_electronico = '" . $socio->getCorreo() . "', " 
					. "ruta_fotografia = '" . $socio->getRutaFotografia() . "' "
					. "WHERE idsocio = " . $socio->getIdSocio());
		}

		public function renovarMembresia($idSocio, $idMembresia, $fechaDePago, $idGimnasio,
							 $idRecepcionista) {		
			$dineroDAO = new DineroDAO();
			$fechaActual = date('Y-m-d');
			$tupla = $this->conexion->consultarTupla("SELECT costo FROM membresia WHERE " 
				. "idmembresia = " . $idMembresia);
			$costoMembresia = $tupla['costo'];
			$fechaFinMembresia = Util::fechaFinMembresia($idMembresia, $fechaDePago);
			return (($this->conexion->sentencia("UPDATE socio SET fecha_fin_membresia = '" 
				. $fechaFinMembresia . "', idmembresia = " . $idMembresia 
				. " WHERE idsocio = " . $idSocio))
			&& ($this->conexion->sentencia("INSERT INTO venta_membresias(fecha, " 
				. "idmembresia, precio, idsocio, idusuario) " 
				. "VALUES ('" . $fechaActual . "', " . $idMembresia 
				. " , " . $costoMembresia . " , " . $idSocio . ", " . $idRecepcionista . ")"))
				&& ($dineroDAO->actualizarMontoActual($idGimnasio, $costoMembresia)));
		}

		public function eliminarSocio(int $idSocio) {
			$ubicacionDeLaFoto = "img/Socios/IMG_" . $idSocio . ".jpeg";
			if (file_exists($ubicacionDeLaFoto)) {
				unlink($ubicacionDeLaFoto);
			}
			return $this->conexion->sentencia("DELETE FROM socio WHERE idsocio = " . $idSocio);
		}

		public function ocultarSocio($idSocio) {
			return $this->conexion->sentencia("UPDATE socio SET oculto = 1 WHERE idsocio = " 
				. $idSocio);
		}

		public function desOcultarSocio($idSocio) {
			return $this->conexion->sentencia("UPDATE socio SET oculto = 0 WHERE idsocio = " 
				. $idSocio);
		}

		public function dameSocio($idSocio) {			
			try {
				$tupla = $this->conexion->consultarTupla("SELECT * FROM socio WHERE idsocio = " 
					. $idSocio);
				return new Socio($tupla[0], $tupla[1], $tupla[2], $tupla[3], $tupla[4], 
								$tupla[5], $tupla[6], $tupla[7], $tupla[8], $tupla[9],
								$tupla[10], $tupla[11], $tupla[12], $tupla[13], $tupla[14], 
								$tupla[15], $tupla[16], $tupla[17], $tupla[18], $tupla[19], $tupla[20],
								$tupla[21]);
			} catch (DatosInvalidosException $e) {
				echo $e->getMessage();
			}			
			return null;
		}
		
		public function dameSocios($nombre = '') {
			$socios = new ArrayList();
			$result = $this->conexion->consultar("SELECT idsocio FROM socio WHERE nombre_pila " 
				. "LIKE '%$nombre%' AND oculto = 0 ORDER BY nombre_pila");
			try {
				while($row = $result->fetch_array()) {								
					$socios->add(self::dameSocio($row['idsocio']));  
				}
				$result->free();
			} catch (DatosInvalidosException $e) {
					echo $e->getMessage();
			}
			return $socios->isEmpty() ? null : $socios;
		}

		public function dameSociosOcultos($nombre = '') {
			$socios = new ArrayList();
			$result = $this->conexion->consultar("SELECT idsocio FROM socio WHERE nombre_pila "
				. "LIKE '%$nombre%' AND oculto = 1 ORDER BY nombre_pila");
			try {
				while($row = $result->fetch_array()) {								
					$socios->add(self::dameSocio($row['idsocio']));
				}
				$result->free();
			} catch (DatosInvalidosException $e) {
					echo $e->getMessage();
			}
            return $socios->isEmpty() ? null : $socios;
		}

		public function existeCorreo(string $correoElectronico) {
			$tupla = $this->conexion->consultarTupla("SELECT correo_electronico "
				. "FROM socio WHERE correo_electronico = '" . $correoElectronico . "'");
			return (isset($tupla) && Util::validarEmail($tupla[0]));
		}

		public function validarSesion(int $idSocio, string $correoElectronico)
		{
			$tupla = $this->conexion->consultarTupla("SELECT idsocio, correo_electronico "
				. "FROM socio WHERE idsocio = " . $idSocio . " "
				. "AND correo_electronico = '" . $correoElectronico . "'");
			return (isset($tupla)) ? self::dameSocio($tupla[0]) : null;
		}

		public function dameVentaDeMembresias($ventasDeHoy) {
			$strQuery = "SELECT socio.nombre_pila, socio.apellido1, "
					. "membresia.membresia, venta_membresias.precio, usuario.nombre_pila, "
					. "usuario.apellido1 FROM venta_membresias, usuario, "
					. "membresia, socio WHERE venta_membresias.idsocio = socio.idsocio "
					. "AND venta_membresias.idmembresia = membresia.idmembresia "
					. "AND usuario.idusuario = venta_membresias.idusuario ";
			if ($ventasDeHoy) {
				$ahora = date('Y-m-j');
				$result = $this->conexion->consultar($strQuery . "AND venta_membresias.fecha = '$ahora' ");
			} else {
				$result = $this->conexion->consultar($strQuery);
			}				
            $ventaDeMembresias = array();
			while ($tupla = $result->fetch_array()) {
				array_push($ventaDeMembresias, array($tupla[0] . ' '  . $tupla[1], $tupla[2], 
					$tupla[3], $tupla[4] . ' ' . $tupla[5]));
			}
			return (count($ventaDeMembresias) > 0) ? $ventaDeMembresias : null;
		}

		public function dameVentaDeMembresiasFechas($fechaIncio, $fechaFin) {	
			$result = $this->conexion->consultar("SELECT socio.nombre_pila, socio.apellido1, " 
				. "membresia.membresia, venta_membresias.precio, venta_membresias.fecha, "
				. "usuario.nombre_pila, usuario.apellido1 "
				. "FROM venta_membresias, membresia, socio, usuario "
				. "WHERE venta_membresias.idsocio = socio.idsocio "
				. "AND venta_membresias.idmembresia = membresia.idmembresia "
				. "AND venta_membresias.idusuario = usuario.idusuario "
				. "AND venta_membresias.fecha >= '$fechaIncio' "
				. "AND venta_membresias.fecha <= '$fechaFin' "
				. "ORDER BY venta_membresias.fecha");
            $ventaDeMembresias = array();
			while ($tupla = $result->fetch_array()) {
				array_push($ventaDeMembresias, array($tupla[0] . " " . $tupla[1], $tupla[2], 
					$tupla[3], $tupla[4], $tupla[5] . ' ' . $tupla[6]));
			}
            return (count($ventaDeMembresias) > 0) ? $ventaDeMembresias : null;
		}
	}