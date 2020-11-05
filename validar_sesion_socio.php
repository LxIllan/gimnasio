<?php

    require_once 'AdminSocios.php';

    $adminSocios = new AdminSocios();

    session_start();


    $correoElectronico = $_POST['correoElectronico'];
	$idSocio = $_POST['codigo'];

	
	$socio = $adminSocios->validarSesion($idSocio, $correoElectronico);
	if (isset($socio)) {
		$_SESSION['socio'] = ['idSocio' => $idSocio,
							'nombre' => $socio->getNombrePila(),
							'apellido' => $socio->getApellido1()];
		header('Location: frm_socio.php');
	} else {
		session_destroy();
		header('Location: login_socios.php?error=1');
	}