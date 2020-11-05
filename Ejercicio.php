<?php
    class Ejercicio
    {
        
        public const NIVELES = ['Principiante', 'Intermedio', 'Medio', 'Medioavanzado', 'Avanzado'];

        private $idEjercicio;
        private $nombre;
        private $series;
        private $rutaFotografia;
        private $path_video;
        private $pesoPrincipiante;
        private $pesoIntermedio;
        private $pesoMedio;
        private $pesoMedioavanzado;
        private $pesoAvanzado;
        private $idMusculo;
        private $idSexo;

        public function __construct($idEjercicio, $nombre, $series, $rutaFotografia, $path_video, $pesoPrincipiante,
            $pesoIntermedio, $pesoMedio, $pesoMedioavanzado, $pesoAvanzado, $idMusculo, $idSexo)
        {
            $this->idEjercicio = $idEjercicio;
            $this->nombre = $nombre;
            $this->series = $series;
            $this->path_video = $path_video;
            $this->rutaFotografia = $rutaFotografia;
            $this->pesoPrincipiante = $pesoPrincipiante;
            $this->pesoIntermedio = $pesoIntermedio;
            $this->pesoMedio = $pesoMedio;
            $this->pesoMedioavanzado = $pesoMedioavanzado;
            $this->pesoAvanzado = $pesoAvanzado;
            $this->idMusculo = $idMusculo;
            $this->idSexo = $idSexo;
        }

        public function getIdEjercicio()
        {
            return $this->idEjercicio;
        }

        public function setIdEjercicio($idEjercicio)
        {
            $this->idEjercicio = $idEjercicio;
        }

        public function getNombre()
        {
            return $this->nombre;
        }

        public function setNombre($nombre)
        {
            $this->nombre = $nombre;
        }

        public function setSeries($series)
        {
            $this->series = $series;
        }

        public function getSeries()
        {
            return $this->series;
        }

        public function getRutaFotografia()
        {
            return $this->rutaFotografia;
        }

        public function getPathVideo()
        {
            return $this->path_video;
        }

        public function setPathVideo($path_video)
        {
            $this->path_video = $path_video;
        }

        public function setRutaFotografia($rutaFotografia)
        {
            $this->rutaFotografia = $rutaFotografia;
        }

        public function setPesoPrincipiante($pesoPrincipiante)
        {
            $this->pesoPrincipiante = $pesoPrincipiante;
        }

        public function getPesoPrincipiante()
        {
            return $this->pesoPrincipiante;
        }

        public function setPesoIntermedio($pesoIntermedio)
        {
            $this->pesoIntermedio = $pesoIntermedio;
        }

        public function getPesoIntermedio()
        {
            return $this->pesoIntermedio;
        }

        public function setPesoMedio($pesoMedio)
        {
            $this->pesoMedio = $pesoMedio;
        }

        public function getPesoMedio()
        {
            return $this->pesoMedio;
        }

        public function setPesoMedioavanzado($pesoMedioavanzado)
        {
            $this->pesoMedioavanzado = $pesoMedioavanzado;
        }

        public function getPesoMedioavanzado()
        {
            return $this->pesoMedioavanzado;
        }

        public function setPesoAvanzado($pesoAvanzado)
        {
            $this->pesoAvanzado = $pesoAvanzado;
        }

        public function getPesoAvanzado()
        {
            return $this->pesoAvanzado;
        }        

        public function getPeso($nivelSocio)
        {
            $peso = 'Ocurrio un error.';
            switch ($nivelSocio) {
                case self::NIVELES[0]:
                    $peso = self::getPesoPrincipiante();           
                    break;
                case self::NIVELES[1]:
                    $peso = self::getPesoIntermedio();
                    break;
                case self::NIVELES[2]:
                    $peso = self::getPesoMedio();
                    break;
                case self::NIVELES[3]:
                    $peso = self::getPesoMedioavanzado();
                    break;
                case self::NIVELES[4]:
                    $peso = self::getPesoAvanzado();
                    break;
                default:
                    $peso = 'Ocurrio un error.';
                    break;
            }
            return $peso;
        }

        public function getIdMusculo()
        {
            return $this->idMusculo;
        }

        public function setIdMusculo($idMusculo)
        {
            $this->idMusculo = $idMusculo;
        }

        public function getIdSexo()
        {
            return $this->idSexo;
        }

        public function setIdSexo($idSexo)
        {
            $this->idSexo = $idSexo;
        }
    }
