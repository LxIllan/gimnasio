<?php
session_start();
if (!isset($_SESSION['usuario'])) {
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
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Perfil
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idUsuario = $_SESSION['usuario']['idusuario'];
        $adminUsuarios = new AdminUsuarios();
        $usuario = $adminUsuarios->consultarUsuario($idUsuario);
        ?>


        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $usuario->getRutaFotografia(); ?>"/>
                        <br>
                        <br>
                        <output id="list"></output>
                        <input type="file" accept=".jpg" class="btn-info" id="files" name="files">
                        <br>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtNombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="txtNombre"
                                value="<?php echo $usuario->getNombrePila(); ?>" pattern="[a-zA-Z\s]*" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtApellido1">Primer apellido:</label>
                            <input type="text" class="form-control" name="apellido1" id="txtApellido1"
                                value="<?php echo $usuario->getApellido1(); ?>" pattern="[a-zA-Z\s]*" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtApellido2">Segundo apellido:</label>
                            <input type="text" class="form-control" name="apellido2" id="txtApellido2"
                                value="<?php echo $usuario->getApellido2(); ?>" pattern="[a-zA-Z\s]*">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtTelefono">Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="txtTelefono"
                                value="<?php echo $usuario->getTelefono(); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtCorreo">Correo electrónico:</label>
                            <input type="text" class="form-control" name="correo" id="txtCorreo"
                                value="<?php echo $usuario->getCorreo(); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtDomicilio">Domicilio:</label>
                            <input type="text" class="form-control" name="domicilio" id="txtDomicilio"
                                value="<?php echo $usuario->getDomicilio(); ?>">
                        </div>
                    </div>
                    <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 1) {
                                $error = 'Las contraseñas no coinciden.';
                            } elseif ($_GET['error'] == 2) {
                                // Claves menores de 8 chars
                                $error = 'Tiene que ingresar una contraseña de al menos 8 caracteres';
                            }?>
                            <div class="alert alert-danger alert-dismissible text-center">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span> </button>
                                <strong>¡Error!</strong> <?php echo $error; ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nueva Contraseña:</label>
                            <input type="password" name="clave" class="form-control"
                                placeholder="Contraseña">        
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Confirmar contraseña:</label>
                            <input type="password" name="clave1" class="form-control"
                                placeholder="Contraseña">  
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="aceptar" <?php
                        if (($usuario->getRoot()) && ($_SESSION['usuario']['root'])) {
                            echo 'enable';
                        } elseif (($usuario->getRoot()) && (!$_SESSION['usuario']['root'])) {
                            echo 'disabled';
                        } else {
                            echo 'enable';
                        } ?> value="Guardar Cambios" class="btn btn-light">

                        <input type="submit" name="Salir" <?php
                        if (($usuario->getRoot()) && ($_SESSION['usuario']['root'])) {
                            echo 'enable';
                        } elseif (($usuario->getRoot()) && (!$_SESSION['usuario']['root'])) {
                            echo 'disabled';
                        } else {
                            echo 'enable';
                        } ?> value="Cancelar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

        <?php
        if (isset($_POST['aceptar'])) {
            $usuario->setNombrePila($_POST['nombre']);
            $usuario->setApellido1($_POST['apellido1']);
            $usuario->setApellido2($_POST['apellido2']);
            $idGimnasio = $_SESSION['usuario']['gimnasio'];
            if (strcmp($_POST['correo'], $usuario->getCorreo()) != 0) {
                if (!$adminUsuarios->comprobarCorreo($_POST['correo'], $idGimnasio)) {
                    $usuario->setCorreo($_POST['correo']);
                } else {
                    ?>
                    <script type="text/javascript">
                        alert('Error, ya existe un recepcionista con ese correo.');
                        window.location = "index.php";
                    </script>
                    <?php
                }
            }
            $usuario->setTelefono($_POST['telefono']);
            $usuario->setDomicilio($_POST['domicilio']);
            if (isset($_FILES['files'])) {
                $usuario->setRutaFotografia(Util::cargarImagen($_FILES['files'], $idUsuario, Util::FOTO_USUARIO));
            }
            $clave = $_POST['clave'];
        if (strlen($clave)) {
            if (($clave == $_POST['clave1'])) {
                if (strlen($clave) >= 8) {
                    $usuario->setClave(sha1($clave));
                } else { ?>
                    <script type="text/javascript">
                        window.location = "frm_perfil.php";
                    </script>
                <?php
                }
            } else { ?>
                <script type="text/javascript">
                    window.location = "frm_perfil.php";
                </script>
                <?php
            }
        }

        if ($adminUsuarios->editarUsuario($usuario)) { ?>
            <script type="text/javascript">
                alert("Se han modificado los datos del usuario.\n" +
                    "En un momento se modificará la fotografía.");
                window.location = "index.php";
            </script>
            <?php
        } else {
            echo "error";
        }
        }
        if (isset($_POST['cancelar'])) { ?>
            <script type="text/javascript">
                if (confirm("¿Desea salir sin guardar cambios?")) {
                    window.location = "index.php";
                }
            </script>
            <?php
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
                        document.getElementById("list").innerHTML = ['<div class="alert alert-info text-center"><?php echo "La fotografía inferior es la nueva fotografía.";?></div>      <center><img class="rounded-circle" height="200" width="200" src="', e.target.result,'"/></center><br>'].join('');
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
