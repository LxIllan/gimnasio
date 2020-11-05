<?php

    require_once 'AdminUsuarios.php';

    $adminUsuarios = new AdminUsuarios();

    session_start();


    $correoElectronico = $_POST['correoElectronico'];
	$clave = sha1($_POST['clave']);

	$datos = $adminUsuarios->validarSesion($correoElectronico, $clave);
	
	if (isset($datos)) {
		$_SESSION['usuario'] = $datos;
		header('Location: index.php');
	} else {
		session_destroy();
		header('Location: login.php?error=1');
	}