<?php
    require_once 'AdminGimnasios.php';
    require_once 'Util.php';    

    function enviarClave($destinatario, $nombre) {        
        $adminGimnasios = new AdminGimnasios();
        $gimnasio = $adminGimnasios->consultarGimnasio($_SESSION['usuario']['gimnasio']);        
        $nombreGimnasio = $gimnasio->getNombre();
        $clave = Util::generarClave();
        // Correo
        $para      =  $destinatario;
        $asunto    =  'Bienvenido a ' . $nombreGimnasio;
        $cabeceras =  'From: ' . $nombreGimnasio . "@$nombreGimnasio.com\r\n" .
                      'Reply-To: L.Fernando.Illan@gmail.com' . "\r\n" .
                      'X-Mailer: PHP/' . phpversion();
                     // Cabeceras para indicar que tiene datos HTML
        $cabeceras .= 'MIME-Version: 1.0' . "\r\n" .
                      'Content-type: text/html; charset=utf-8' . "\r\n";


        $mensaje =  '<html>'.
                    '<head>' . 
                    '<title>Bienvenido a ' . $nombreGimnasio . '</title>' .
                    '</head>'.
                    '<body>'.
                    '<h1>¡Feliciades ' . $nombre . '!</h1>' .
                    'Ahora eres parte del equipo de ' . $nombreGimnasio . '. =)' .
                    '<br>' .
                    'Se te entrega esta contraseña temporal <b> ' . $clave . ' </b> ' .
                    'con la cual iniciaras sesión junto con tu correo.' . 
                    '<br>' . 
                    'Se recomienda cambiar la contraseña inmediatamente.' .
                    '<br>' .
                    'Cualquier duda la puedes aclarar con tu superior. ' .
                    '<a href="http://iaml.damsoluciones.com/Gimnasio/index.php">www.Gimnasio.com</a>'.
                    '<br>' .
                    '</body>' .
                    '</html>';
        
        if (mail($para, $asunto, $mensaje, $cabeceras)) {
            echo "1";
        } else {
            echo "0";
        }
        return sha1($clave);
    }    
?>