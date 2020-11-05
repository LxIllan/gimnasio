<?php
    require_once('AdminUsuarios.php');
    require_once('AdminGimnasios.php');

    function enviarSolicitud(string $correoElectronico, string $nombre, int $idGimnasio) {
        $adminUsuarios = new AdminUsuarios();
        $adminGimnasios = new AdminGimnasios();
        $correoAdmin = $adminUsuarios->dameCorreoAdministrador($idGimnasio);
        $nombreGimnasio = $adminGimnasios->dameNombre($idGimnasio);
        if ($adminUsuarios->comprobarCorreo($correoElectronico, $idGimnasio) 
            && (isset($correoAdmin))) {
                $para      =  $correoAdmin;
                $asunto    =  'Ayuda - Restablecer contraseña';
                $cabeceras =  'From: ' . $nombreGimnasio . "@$nombreGimnasio.com\r\n" .
                              'Reply-To: L.Fernando.Illan@gmail.com' . "\r\n" .
                              'X-Mailer: PHP/' . phpversion();
                             // Cabeceras para indicar que tiene datos HTML
                $cabeceras .= 'MIME-Version: 1.0' . "\r\n" .
                              'Content-type: text/html; charset=utf-8' . "\r\n";
        
        
                $mensaje =  '<html>'.
                            '<head>' . 
                            '<title></title>' .
                            '</head>'.
                            '<body>'.
                            '<h1>Restablecer contraseña</h1>' .
                            'El/La recepcionista <b>' . $nombre . '</b> necesita ' .
                            'restablecer la contraseña, parece que la ha olvidado.' .
                            '<br>' . 
                            'En el apartado de los recepcionistas, en editar recepcionista puede ' .
                            'cambiar la contraseña dando clic en el botón \'Enviar nueva contraseña\'.'.
                            '<br>' .
                            'Por ahora es todo, gracias por su atención.' .
                            '<br>' . 
                            '<b>ATT:</b> El equipo de ' . $nombreGimnasio . ' GYM.' .
                            '</body>' .
                            '</html>';
                
                return mail($para, $asunto, $mensaje, $cabeceras);
        } else {
            return false;
        }
    }
    