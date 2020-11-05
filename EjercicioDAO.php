<?php
    require_once 'Ejercicio.php';
    require_once 'Conexion.php';
    require_once 'Util.php';

    class EjercicioDAO
    {
        private $conexion;

        public function __construct()
        {
            $this->conexion = new Conexion();
        }

        public function agregarEjercicio($ejercicio)
        {
            return $this->conexion->sentencia("INSERT INTO ejercicio(nombre, series, ruta_fotografia, ruta_video, peso_principiante, " 
                . "peso_intermedio, peso_medio, peso_medioavanzado, peso_avanzado, idmusculo, idsexo)"
                . "VALUES ('" . $ejercicio->getNombre() . "', '"
                . $ejercicio->getSeries() . "', '"
                . $ejercicio->getRutaFotografia() . "', '"
                . $ejercicio->getPathVideo() . "', '"
                . $ejercicio->getPesoPrincipiante() . "', '"
                . $ejercicio->getPesoIntermedio() . "', '"
                . $ejercicio->getPesoMedio() . "', '"
                . $ejercicio->getPesoMedioavanzado() . "', '"
                . $ejercicio->getPesoAvanzado() . "', "
                . $ejercicio->getIdMusculo() . ", "
                . $ejercicio->getIdSexo() . ")");
        }

        public function getSiguienteId(): int
        {
            $tupla = $this->conexion->consultarTupla("SELECT AUTO_INCREMENT FROM "
                . "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'ejercicio'");
            return $tupla[0];
        }

        public function editarEjercicio($ejercicio)
        {            
            return $this->conexion->sentencia("UPDATE ejercicio SET "
                . "nombre = '" . $ejercicio->getNombre() . "', "
                . "series = '" . $ejercicio->getSeries() . "', "
                . "ruta_fotografia = '" . $ejercicio->getRutaFotografia() . "', "
                . "ruta_video = '" . $ejercicio->getPathVideo() . "', "
                . "peso_principiante = '" . $ejercicio->getPesoPrincipiante() . "', "
                . "peso_intermedio = '" . $ejercicio->getPesoIntermedio() . "', "
                . "peso_medio = '" . $ejercicio->getPesoMedio() . "', "
                . "peso_medioavanzado = '" . $ejercicio->getPesoMedioavanzado() . "', "
                . "peso_avanzado = '" . $ejercicio->getPesoAvanzado() . "', "
                . "idmusculo = " . $ejercicio->getIdMusculo() . ", "
                . "idsexo = " . $ejercicio->getIdSexo() . " "
                . "WHERE idejercicio = " . $ejercicio->getIdEjercicio());
        }        

        public function eliminarEjercicio($idEjercicio)
        {
            $ubicacionDeLaFoto = "img/Ejercicios/IMG_" . $idEjercicio . ".jpeg";
			if (file_exists($ubicacionDeLaFoto)) {
				unlink($ubicacionDeLaFoto);
            }
            $location_of_video = 'video/video_' . $idEjercicio . '.mp4';
            if (file_exists($location_of_video)) {
                unlink($location_of_video);
            }
            return $this->conexion->sentencia("DELETE FROM ejercicio WHERE idejercicio = " . $idEjercicio);
        }                

        public function dameEjercicio($idEjercicio)
        {
            $tupla = $this->conexion->consultarTupla('SELECT idejercicio, nombre, series, ruta_fotografia, '
                . 'ruta_video, peso_principiante, peso_intermedio, peso_medio, peso_medioavanzado, peso_avanzado, '
                . 'idmusculo, idsexo '
                . 'FROM ejercicio '
                . 'WHERE idejercicio = ' . $idEjercicio);
            return new Ejercicio(
                $tupla[0], $tupla[1], $tupla[2], $tupla[3], $tupla[4], $tupla[5], $tupla[6], 
                $tupla[7], $tupla[8], $tupla[9], $tupla[10], $tupla[11]);
        }

        public function dameEjerciciosPSexo($idSexo)
        {
            $ejercicios = new ArrayList();
            $result = $this->conexion->consultar('SELECT idejercicio FROM ejercicio WHERE idsexo = ' . $idSexo);
            while ($tupla = $result->fetch_array()) {
                $ejercicios->add(self::dameEjercicio($tupla['idejercicio']));
            }
            return ($ejercicios->isEmpty()) ? null : $ejercicios;
        }

        public function dameEjerciciosPMusculo($idMusculo)
        {
            $ejercicios = new ArrayList();
            $result = $this->conexion->consultar('SELECT idejercicio FROM ejercicio WHERE idmusculo = ' . $idMusculo);
            while ($tupla = $result->fetch_array()) {
                $ejercicios->add(self::dameEjercicio($tupla['idejercicio']));
            }
            return ($ejercicios->isEmpty()) ? null : $ejercicios;
        }

        public function dameEjerciciosPUsuario(int $idSexo, int $idMusculo)
        {
            $ejercicios = new ArrayList();
            $result = $this->conexion->consultar('SELECT idejercicio FROM ejercicio '
                . 'WHERE idmusculo = ' . $idMusculo . ' AND idsexo = ' . $idSexo);
            while ($tupla = $result->fetch_array()) {
                $ejercicios->add(self::dameEjercicio($tupla['idejercicio']));
            }
            return ($ejercicios->isEmpty()) ? null : $ejercicios;
        }

        public function dameEjercicios($nombre = '', $idSexo)
        {
            $ejercicios = new ArrayList();
            if ($idSexo == 0) {
                $result = $this->conexion->consultar("SELECT idejercicio FROM ejercicio WHERE nombre LIKE '%$nombre%' ORDER BY nombre");
            } else {
                $result = $this->conexion->consultar("SELECT idejercicio FROM ejercicio "
                    . "WHERE idsexo = " . $idSexo . " AND nombre LIKE '%$nombre%' ORDER BY nombre");
            }
            while ($tupla = $result->fetch_array()) {
                $ejercicios->add(self::dameEjercicio($tupla['idejercicio']));
            }
            return ($ejercicios->isEmpty()) ? null : $ejercicios;
        }

        public function getParteDelCuerpo($idMusculo)
        {
            $tupla = $this->conexion->consultarTupla('SELECT idparte_del_cuerpo '
                . 'FROM musculo '
                . 'WHERE idmusculo = ' . $idMusculo);
            return $tupla[0];
        }
    }
