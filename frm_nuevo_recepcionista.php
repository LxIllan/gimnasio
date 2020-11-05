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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" href="img/logo.png">
    <meta name="author" content="Fernando Illan">
    <title>Gimnasio</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php
    require_once 'navigation.php';
    require_once 'AdminUsuarios.php';
    require_once 'enviar_clave.php';
    require_once 'Util.php';
?>

<!-- content-wrapper-->
<div class="content-wrapper">

    <!-- container-fluid-->
    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Gimnasio</a>
            </li>
            <li class="breadcrumb-item active">Nuevo Recepcionista</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Nuevo Recepcionista
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->


        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <label class="control-label">Foto:</label>
                    <div class="text-center">
                        <output id="list"></output>
                        <input class="btn-info" accept=".jpg" type="file" id="files" name="files">
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombrePila"
                                placeholder="Nombre" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Primer apellido:</label>
                            <input type="text" class="form-control" name="apellido1"
                                placeholder="Apellido" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Segundo apellido:</label>
                            <input type="text" class="form-control" name="apellido2"
                               placeholder="Apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Domicilio:</label>
                            <input type="text" class="form-control" name="domicilio"
                                placeholder="Domicilio">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Correo electrónico:</label>
                            <input type="text" class="form-control" name="correo"
                               placeholder="ejemplo@ejemplo.com" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Teléfono:</label>
                            <input type="text" class="form-control" name="telefono"
                                placeholder="33-44-55-66-77">
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="aceptar"
                                   value="Aceptar" class="btn btn-primary">
                    </div>
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

    <?php
    if (isset($_POST['aceptar'])) {
        $adminUsuarios = new AdminUsuarios();
        $idGimnasio = $_SESSION['usuario']['gimnasio'];
        $nombrePila = $_REQUEST['nombrePila'];
        $apellido1 = $_REQUEST['apellido1'];
        $apellido2 = $_REQUEST['apellido2'];
        $correo = $_REQUEST['correo'];
        $telefono = $_REQUEST['telefono'];
        $domicilio = $_REQUEST['domicilio'];

        if (!$adminUsuarios->comprobarCorreo($correo, $idGimnasio)) {
            $idUsuario = $adminUsuarios->getSiguienteId();
            $rutaFotografia = Util::cargarImagen($_FILES['files'], $idUsuario, Util::FOTO_USUARIO);
            $clave = enviarClave($correo, $nombrePila . ' ' . $apellido1);
            if ($adminUsuarios->agregarRecepcionista($nombrePila, $apellido1, $apellido2,
                $correo, $telefono, $domicilio, $clave, $rutaFotografia, $idGimnasio)) {
                ?>
                <script type="text/javascript">
                    alert("El recepcionista se registró correctamente.");
                    window.location = "index.php";
                </script>
                <?php
            }
        } else {
            ?>e
                <script type="text/javascript">
                    alert("Error, el correo ya ha sido registrado.");
                    window.location = "frm_nuevo_recepcionista.php";
                </script>
                <?php
        }
    }
    ?>

    <script>
        function archivo(evt) {
            var files = evt.target.files; // FileList object
            // Obtenemos la imagen del campo "file".
            for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function() {
                    return function(e) {
                        // Insertamos la imagen
                        document.getElementById("list").innerHTML = ['<img class="rounded-circle" height="200" width="200" src="', e.target.result,'"/><br>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('files').addEventListener('change', archivo, false);
    </script>


    <!-- footer -->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small><?php echo Util::STR_FOOTER; ?></small>
            </div>
        </div>
    </footer>
    <!-- /.footer -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- /.Scroll to Top Button-->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
    <script src="vendor/sweetalert2/dist/core.js"></script>
</div>
<!-- /.content-wrapper-->
</body>
</html>
