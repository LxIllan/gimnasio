<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
    }
    
    if (session_destroy()) {
        header('Location: ../index.php');
    } else {
        header('Location: index.php');
    }
	
?>