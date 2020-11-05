<?php
	require_once 'EjercicioDAO.php';
	require_once 'Ejercicio.php';

	class AdminEjercicios
    {
        private $EjercicioDAO;

        public function __construct()
        {
            $this->EjercicioDAO = new EjercicioDAO();
        }

        public function agregarEjercicio(
            $nombre,
            $series,
            $rutaFotografia,
            $path_video,
            $pesoPrincipiante,
            $pesoIntermedio,
            $pesoMedio,
            $pesoMedioavanzado,
            $pesoAvanzado,
            $idMusculo,
            $idSexo
        ) {
			
			$idEjercicio = 1;
            return $this->EjercicioDAO->agregarEjercicio(new Ejercicio(
                $idEjercicio,
                $nombre,
                $series,
                $rutaFotografia,
                $path_video,
                $pesoPrincipiante,
                $pesoIntermedio,
                $pesoMedio,
                $pesoMedioavanzado,
                $pesoAvanzado,
                $idMusculo,
                $idSexo
            ));
        }

        public function getSiguienteId()
        {
            return $this->EjercicioDAO->getSiguienteId();
        }

        public function editarEjercicio($ejercicio)
        {
            return $this->EjercicioDAO->editarEjercicio($ejercicio);
        }

        public function eliminarEjercicio($idEjercicio)
        {
            return $this->EjercicioDAO->eliminarEjercicio($idEjercicio);
        }

        public function consultarEjercicio($idEjercicio)
        {
            return $this->EjercicioDAO->dameEjercicio($idEjercicio);
        }

        public function listarEjercicios($nombre = '', $idSexo)
        {
            return $this->EjercicioDAO->dameEjercicios($nombre, $idSexo);
        }

        public function listarEjerciciosPSexo($idSexo)
        {
            return $this->EjercicioDAO->dameEjerciciosPSexo($idSexo);
        }

        public function listarEjerciciosPMusculo($idMusculo)
        {
            return $this->EjercicioDAO->dameEjerciciosPMusculo($idMusculo);
        }

        public function listarEjerciciosPUsuario($idSexo, $idMusculo)
        {
            return $this->EjercicioDAO->dameEjerciciosPUsuario($idSexo, $idMusculo);
        }

        function getParteDelCuerpo($idMusculo) 
        {
            return $this->EjercicioDAO->getParteDelCuerpo($idMusculo);
        }
    }
