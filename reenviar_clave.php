<?php
    session_start();
    if (isset($_SESSION['usuario'])) {
        require_once 'Usuario.php';
        if ($_SESSION['usuario']['root'] != Usuario::ROOT) {
            header('Location: index.php');
        }
    } else {
        header('Location: login.php');
    }
    require_once 'AdminGimnasios.php';
    require_once 'AdminSocios.php';
    require_once 'AdminUsuarios.php';
    require_once 'Util.php';

    $idRecepcionista = $_GET['id'];
    echo $idRecepcionista;
    $adminUsuarios = new AdminUsuarios();
    $recepcionista = $adminUsuarios->consultarUsuario($idRecepcionista);
    $idGimnasio = $_SESSION['usuario']['gimnasio'];
    $nombreRecepcionista = $recepcionista->getNombrePila();
    $correoRecepcionista = $recepcionista->getCorreo();
    $clave = reenviarClave($correoRecepcionista, $nombreRecepcionista, $idGimnasio);
    if (isset($clave)) {
        $recepcionista->setClave($clave);
        if ($adminUsuarios->editarUSuario($recepcionista)) { ?>
            <script type="text/javascript">
                alert("Se ha enviado una nueva contraseña.");
                window.location = "frm_buscar_recepcionista.php";
            </script>
            <?php
        }
    }

    function reenviarClave($destinatario, $nombre, $idGimnasio) {
        $adminGimnasios = new AdminGimnasios();
        $gimnasio = $adminGimnasios->consultarGimnasio($idGimnasio);
        $nombreGimnasio = $gimnasio->getNombre();
        $clave = Util::generarClave();
        // Correo
        $para      =  $destinatario;
        $asunto    =  'Restablecer contraseña - ' . $nombreGimnasio;
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
                    '<h1>Cambio de contraseña</h1>' .
                    'Hola, ' . $nombre . ' se solicitó un cambio de contraseña.' .
                    '<br>' .
                    'Tu nueva contraseña es  <b> ' . $clave . '.</b> ' .
                    '<br>' . 
                    'Se recomienda cambiar la contraseña inmediatamente.' .
                    '<br>' .
                    'Cualquier duda la puedes aclarar con tu superior. ' .
                    '<a href="http://iaml.damsoluciones.com/Gimnasio/index.php">www.Gimnasio.com</a>'.
                    '<br>' .
                    '</body>' .
                    '</html>';
        
        return (mail($para, $asunto, $mensaje, $cabeceras)) ? sha1($clave) : null;
    }    
?>