<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
    }
	
	$_SESSION['usuario']['idusuario'] = $_SESSION['usuario']['auxId'];
	$_SESSION['usuario']['nombre'] = $_SESSION['usuario']['auxNombre'];
	$_SESSION['usuario']['apellido'] = $_SESSION['usuario']['auxApellido'];
	$_SESSION['usuario']['root'] = 0;
	header('Location: index.php');
?>