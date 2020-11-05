<?php

require_once 'UsuarioDAO.php';
require_once 'Util.php';

class AdminUsuarios {

    private $_usuarioDAO;

    function __construct() {
        $this->_usuarioDAO = new UsuarioDAO();
    }

    public function agregarRecepcionista($nombrePila, $apellido1, $apellido2, $correo, $telefono,
                                         $domicilio, $clave, $rutaFotografia, $idGimnasio) {
        $idUsuario = 1;
        $root = 0;
        $habilitado = 1;
        return $this->_usuarioDAO->agregarUsuario(new Usuario($idUsuario, $nombrePila, $apellido1,
            $apellido2, $correo, $telefono, $domicilio, $clave, $rutaFotografia, $root,
            $habilitado, $idGimnasio));
    }

    public function agregarGerente($nombrePila, $apellido1, $apellido2, $correo, $telefono,
                                   $domicilio, $clave, $rutaFotografia, $idGimnasio) {
        $idUsuario = 1;
        $root = 1;
        $habilitado = 1;
        return $this->_usuarioDAO->agregarUsuario(new Usuario($idUsuario, $nombrePila, $apellido1,
            $apellido2, $correo, $telefono, $domicilio, $clave, $rutaFotografia, $root,
            $habilitado, $idGimnasio));
    }

    public function editarUsuario($usuario) {
        return $this->_usuarioDAO->editarUsuario($usuario);
    }

    public function eliminarUsuario($idUsuario) {
        return $this->_usuarioDAO->eliminarUsuario($idUsuario);
    }

    public function eliminarRecepcionista($idRecepcionista) {
        return $this->_usuarioDAO->eliminarRecepcionista($idRecepcionista);
    }

    public function consultarUsuario($idUsuario) {
        return $this->_usuarioDAO->dameUsuario($idUsuario);
    }

    public function listarRecepcionistas($idGimnasio, $nombre = '') {
        return $this->_usuarioDAO->dameRecepcionistas($idGimnasio, $nombre);
    }

    public function validarSesion(string $correoElectronico, string $clave) {
        return $this->_usuarioDAO->validarSesion($correoElectronico, $clave);
    }

    public function cambiarSesion(array $sesion, string $correoElectronico, string $clave,
                                  int $idGimasio) {
        return $this->_usuarioDAO->cambiarSesion($sesion, $correoElectronico, $clave, $idGimasio);
    }

    public function comprobarCorreo(string $correoElectronico, int $idGimnasio) {
        return Util::validarEmail($correoElectronico) ? $this->_usuarioDAO->comprobarCorreo($correoElectronico, $idGimnasio) : false;
    }

    public function dameCorreoAdministrador(int $idGimnasio) {
        return $this->_usuarioDAO->dameCorreoAdministrador($idGimnasio);
    }

    public function getSiguienteId() {
        return $this->_usuarioDAO->getSiguienteId();
    }
}