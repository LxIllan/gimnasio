<?php
require_once 'Conexion.php';
require_once 'Util.php';
require_once 'Usuario.php';

class UsuarioDAO {

    private $_conexion;

    function __construct() {
        $this->_conexion = new Conexion();
    }

    public function agregarUsuario(Usuario $usuario): bool {
        return $this->_conexion->sentencia("INSERT INTO usuario(nombre_pila, apellido1, "
            . "apellido2, correo_electronico, domicilio, telefono, clave, ruta_fotografia, "
            . "root, habilitado, idgimnasio) "
            . "VALUES ('" . $usuario->getNombrePila() . "', '"
            . $usuario->getApellido1() . "', '"
            . $usuario->getApellido2() . "', '"
            . $usuario->getCorreo() . "', '"
            . $usuario->getDomicilio() . "', '"
            . $usuario->getTelefono() . "', '"
            . $usuario->getClave() . "', '"
            . $usuario->getRutaFotografia() . "', '"
            . $usuario->getRoot() . "', '"
            . $usuario->getHabilitado() . "', '"
            . $usuario->getIdGimnasio() . "')");
    }


    public function getSiguienteId(): int {
        $tupla = $this->_conexion->consultarTupla("SELECT AUTO_INCREMENT FROM "
            . "INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'usuario'");
        return $tupla[0];
    }

    public function editarUsuario(Usuario $usuario): bool {
        return $this->_conexion->sentencia("UPDATE usuario SET "
            . "nombre_pila = '" . $usuario->getNombrePila() . "', "
            . "apellido1 = '" . $usuario->getApellido1() . "', "
            . "apellido2 = '" . $usuario->getApellido2() . "', "
            . "correo_electronico = '" . $usuario->getCorreo() . "', "
            . "clave = '" . $usuario->getClave() . "', "
            . "telefono = '" . $usuario->getTelefono() . "', "
            . "domicilio = '" . $usuario->getDomicilio() . "', "
            . "ruta_fotografia = '" . $usuario->getRutaFotografia() . "' "
            . "WHERE idusuario = " . $usuario->getIdUsuario());
    }

    public function eliminarUsuario($idUsuario) {
        $ubicacioneDeLaFoto = "img/Usuarios/IMG_" . $idUsuario . ".jpg";
        if (file_exists($ubicacioneDeLaFoto)) {
            unlink($ubicacioneDeLaFoto);
        }
        return $this->_conexion->sentencia("DELETE FROM usuario WHERE idusuario = "
            . $idUsuario);
    }    

    public function dameUsuario(int $idUsuario) {
        $tupla = $this->_conexion->consultarTupla("SELECT idusuario, nombre_pila, apellido1, "
            . "apellido2, correo_electronico, telefono, domicilio, clave, ruta_fotografia, "
            ."root, habilitado, idgimnasio "
            . "FROM usuario WHERE idusuario = " . $idUsuario);
        if (isset($tupla)) {
            return new Usuario($tupla[0], $tupla[1], $tupla[2], $tupla[3], $tupla[4],
                $tupla[5], $tupla[6], $tupla[7], $tupla[8], $tupla[9],
                $tupla[10], $tupla[11]);
        } else {
            return null;
        }
    }

    public function dameRecepcionistas(int $idGimnasio, string $nombre = '') {
        $recepcionistas = new ArrayList();
        $result = $this->_conexion->consultar("SELECT idusuario, nombre_pila, apellido1,"
            . " apellido2, correo_electronico, telefono, domicilio, clave, "
            . " ruta_fotografia, root, habilitado, idgimnasio FROM usuario"
            . " WHERE nombre_pila LIKE '%$nombre%' AND idgimnasio = " . $idGimnasio
            . " AND root = 0 AND habilitado = 1 ORDER BY nombre_pila");
        while ($row = $result->fetch_array()) {
            $recepcionistas->add(new Usuario($row['idusuario'], $row['nombre_pila'],
                $row['apellido1'], $row['apellido2'],
                $row['correo_electronico'], $row['telefono'],
                $row['domicilio'], $row['clave'],
                $row['ruta_fotografia'], $row['root'],
                $row['habilitado'],$row['idgimnasio']));

        }
        $result->free();
        return $recepcionistas->isEmpty() ? null : $recepcionistas;
    }

    public function eliminarRecepcionista(int $idrecepcionista):  bool {
        return $this->_conexion->sentencia("UPDATE usuario SET habilitado = 0 " .
            "WHERE idusuario = " . $idrecepcionista);
    }

    public function validarSesion(string $correoElectronico, string $clave) {
        $result = $this->_conexion->consultar("SELECT idusuario, nombre_pila, apellido1, "
            . "idgimnasio FROM usuario "
            . "WHERE correo_electronico LIKE '$correoElectronico' AND correo_electronico = '$correoElectronico' "
            . "AND clave = '$clave' "
            . "AND root = 1");
        if ($result->num_rows == 1) {
            $row = $result->fetch_array();
            $datos = [
                'idusuario' => $row['idusuario'],
                'nombre' => $row['nombre_pila'],
                'apellido' => $row['apellido1'],
                'gimnasio' => $row['idgimnasio'],
                'root' => 0,
                'auxId' => $row['idusuario'],
                'auxNombre' => $row['nombre_pila'],
                'auxApellido' => $row['apellido1'],
                'auxRoot' => 0
            ];
        }
        return isset($datos) ? $datos : null;
    }

    public function cambiarSesion(array $sesion, string $correoElectronico, string $clave,
                                  int $idGimasio) {
        $result = $this->_conexion->consultar("SELECT idusuario, nombre_pila, apellido1 "
            . "FROM usuario WHERE "
            . "correo_electronico = '$correoElectronico' AND clave = '$clave' "
            . "AND habilitado = 1 AND idgimnasio = " . $idGimasio);
        if ($result->num_rows == 1) {
            $row = $result->fetch_array();
            $datos = [
                'idusuario' => $row['idusuario'],
                'nombre' => $row['nombre_pila'],
                'apellido' => $row['apellido1'],
                'gimnasio' => $sesion['usuario']['gimnasio'],
                'root' => 0,
                'auxId' => $sesion['usuario']['auxId'],
                'auxNombre' => $sesion['usuario']['auxNombre'],
                'auxApellido' => $sesion['usuario']['auxApellido'],
                'auxRoot' => $sesion['usuario']['auxRoot']
            ];
        } else {
            return null;
        }

        if (isset($datos)) {
            if (($datos['idusuario'] === $datos['auxId']) &&
                ($datos['nombre'] === $datos['auxNombre']) &&
                ($datos['apellido'] === $datos['auxApellido'])) {
                $datos['root'] = 1;
            }
            return $datos;
        } else {
            return null;
        }
    }

    public function dameCorreoAdministrador(int $idGimnasio) {
        $tupla = $this->_conexion->consultarTupla("SELECT correo_electronico FROM usuario "
            . "WHERE idgimnasio = " . $idGimnasio . " AND root = 1");
        return (isset($tupla)) ? $tupla[0] : null;
    }

    public function comprobarCorreo(string $correoElectronico, int $idGimnasio) {
        $tupla = $this->_conexion->consultarTupla("SELECT correo_electronico "
            . "FROM usuario WHERE idgimnasio = " . $idGimnasio . 
            " AND correo_electronico = '" . $correoElectronico . "'");
        return (isset($tupla) && Util::validarEmail($tupla[0]));
    }
}