<?php
    session_start();
    if (!isset($_SESSION['socio'])) {
        header('Location: login_socios.php');
    }
    
    if (session_destroy()) {
        header('Location: ../index.php');
    } else {
        header('Location: frm_socio.php');
    }
	
?>