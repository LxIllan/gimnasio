<?php
	require_once('AdminSocios.php');
	$adminSocios = new AdminSocios();
	$idSocio = $_GET['id'];
	$adminSocios->ocultarSocio($idSocio);
	header('Location:' . $_SERVER['HTTP_REFERER']);
?>