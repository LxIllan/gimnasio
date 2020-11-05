<?php

class Socio {

    const MAX_CHAR_NOMBRE = 45;
    const MAX_CHAR_APELLIDO = 20;
    const MAX_CHAR_CORREO = 45;
    const MAX_CHAR_RUTA_FOTO = 100;

    private $idSocio;
    private $nombrePila;
    private $apellido1;
    private $apellido2;
    private $fechaNacimiento;
    private $idSexo;
    private $peso;
    private $estatura;
    private $lesionAbdomen;
    private $lesionBrazos;
    private $lesionEspalda;
    private $lesionHombro;
    private $lesionPecho;
    private $lesionPiernas;
    private $correo;
    private $rutaFotografia;
    private $fechaInscripcion;
    private $ultimaAsistencia;
    private $diasEntrenando;
    private $fechaFinMembresia;
    private $oculto;
    private $idMembresia;


    public function __construct($idSocio, $nombrePila, $apellido1, $apellido2, $fechaNacimiento,
                                $idSexo, $peso, $estatura, $lesionAbdomen, $lesionBrazos,
                                $lesionEspalda, $lesionHombro, $lesionPecho, $lesionPiernas,
                                $correo, $rutaFotografia, $fechaInscripcion, $ultimaAsistencia,
                                $diasEntrenando, $fechaFinMembresia, $oculto, $idMembresia) {
        $this->idSocio = $idSocio;
        $this->nombrePila = $nombrePila;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->idSexo = $idSexo;
        $this->peso = $peso;
        $this->estatura = $estatura;
        $this->lesionAbdomen = $lesionAbdomen;
        $this->lesionBrazos = $lesionBrazos;
        $this->lesionEspalda = $lesionEspalda;
        $this->lesionHombro = $lesionHombro;
        $this->lesionPecho = $lesionPecho;
        $this->lesionPiernas = $lesionPiernas;
        $this->correo = $correo;
        $this->rutaFotografia = $rutaFotografia;
        $this->fechaInscripcion = $fechaInscripcion;
        $this->ultimaAsistencia = $ultimaAsistencia;
        $this->diasEntrenando = $diasEntrenando;
        $this->fechaFinMembresia = $fechaFinMembresia;
        $this->oculto = $oculto;
        $this->idMembresia = $idMembresia;
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

    public function setCorreo($correo) {
        if (strlen($correo) <= self::MAX_CHAR_CORREO) {
            $this->correo = $correo;
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

    public function setFechaInscripcion() {
        $this->fechaInscripcion = date('Y-m-d');
        return true;
    }

    public function setOculto($oculto) {
        if (($oculto == 0) || ($oculto == 1)) {
            $this->oculto = $oculto;
            return true;
        } else {
            return false;
        }
    }

    public function getIdSocio() {
        return $this->idSocio;
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

    public function getRutaFotografia() {
        return $this->rutaFotografia;
    }

    public function getFechaInscripcion() {
        return $this->fechaInscripcion;
    }

    public function getFechaFinMembresia() {
        return $this->fechaFinMembresia;
    }

    public function getOculto() {
        return $this->oculto;
    }

    public function getIdMembresia() {
        return $this->idMembresia;
    }
    
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }
     
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }
    
    public function getPeso()
    {
        return $this->peso;
    }
     
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }
    
    public function getEstatura()
    {
        return $this->estatura;
    }
     
    public function setEstatura($estatura)
    {
        $this->estatura = $estatura;
    }
    
    public function getUltimaAsistencia()
    {
        return $this->ultimaAsistencia;
    }
     
    public function setUltimaAsistencia($ultimaAsistencia)
    {
        $this->ultimaAsistencia = $ultimaAsistencia;
    }
    
    public function getDiasEntrenando()
    {
        return $this->diasEntrenando;
    }
     
    public function setDiasEntrenando($diasEntrenando)
    {
        $this->diasEntrenando = $diasEntrenando;
    }
    
    public function getLesionAbdomen()
    {
        return $this->lesionAbdomen;
    }
     
    public function setLesionAbdomen($lesionAbdomen)
    {
        $this->lesionAbdomen = $lesionAbdomen;
    }
    
    public function getLesionBrazos()
    {
        return $this->lesionBrazos;
    }
     
    public function setLesionBrazos($lesionBrazos)
    {
        $this->lesionBrazos = $lesionBrazos;
    }
    
    public function getLesionEspalda()
    {
        return $this->lesionEspalda;
    }
     
    public function setLesionEspalda($lesionEspalda)
    {
        $this->lesionEspalda = $lesionEspalda;
    }
    
    public function getLesionHombro()
    {
        return $this->lesionHombro;
    }
     
    public function setLesionHombro($lesionHombro)
    {
        $this->lesionHombro = $lesionHombro;
    }
    
    public function getLesionPecho()
    {
        return $this->lesionPecho;
    }
     
    public function setLesionPecho($lesionPecho)
    {
        $this->lesionPecho = $lesionPecho;
    }
    
    public function getLesionPiernas()
    {
        return $this->lesionPiernas;
    }
     
    public function setLesionPiernas($lesionPiernas)
    {
        $this->lesionPiernas = $lesionPiernas;
    }

    public function getIdSexo()
    {
        return $this->idSexo;
    }

    public function setIdSexo($idSexo)
    {
        $this->idSexo = $idSexo;
    }

    public function setIdMembresia($idMembresia)
    {
        $this->idMembresia = $idMembresia;
    }
}