<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
}

require_once 'AdminUsuarios.php';

$adminUsuarios = new AdminUsuarios();

$aux_SESSION = $_SESSION;
$correoElectronico = $_POST['correoElectronico'];
$clave = sha1($_POST['clave']);
$idGimnasio = intval($_SESSION['usuario']['gimnasio']);

$datos = $adminUsuarios->cambiarSesion($_SESSION, $correoElectronico, $clave, $idGimnasio);

if (isset($datos)) {
    $_SESSION['usuario'] = $datos;
    header('Location: index.php');
} else {
    $_SESSION = $aux_SESSION;
    header('Location: frm_iniciar_sesion.php?error=1');
}
