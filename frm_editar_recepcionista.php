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
require_once 'Util.php';
require_once 'AdminUsuarios.php';
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
            <li class="breadcrumb-item">
                <a href="frm_buscar_recepcionista.php">Buscar recepcionista</a>
            </li>
            <li class="breadcrumb-item active">Editar recepcionista</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Editar Recepcionista
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idRecepcionista = $_GET['id'];
        $adminUsuarios = new AdminUsuarios();
        $recepcionista = $adminUsuarios->consultarUsuario($idRecepcionista);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post">
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $recepcionista->getRutaFotografia(); ?>"/>
                        <br>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtNombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="txtNombre"
                                value="<?php echo $recepcionista->getNombrePila(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtApellido1">Primer apellido:</label>
                            <input type="text" class="form-control" name="apellido1" id="txtApellido1"
                                value="<?php echo $recepcionista->getApellido1();?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtApellido2">Segundo apellido:</label>
                            <input type="text" class="form-control" name="apellido2" id="txtApellido2"
                                value="<?php echo $recepcionista->getApellido2();?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <!-- Espacio en blanco -->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtCorreo">Correo:</label>
                            <input type="text" class="form-control" name="correo" id="txtCorreo"
                                value="<?php echo $recepcionista->getCorreo();?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <!-- Espacio en blanco -->
                        </div>
                    </div>
                    <a class="btn btn-block btn-litgh" data-toggle="modal" data-target="#enviarClaveModal">Enviar nueva contraseña<a/>
                    <br>
                    <div class="text-center">
                        <input type="submit" name="aceptar" value="Aceptar" class="btn btn-light">
                        <input type="submit" name="cancelar" value="Cancelar" class="btn btn-primary">
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
        $idGimnasio = $_SESSION['usuario']['gimnasio'];
        if (!$adminUsuarios->comprobarCorreo($_POST['correo'], $idGimnasio)) {
            echo $_POST['correo'];
            $recepcionista->setCorreo($_POST['correo']);
            if ($adminUsuarios->editarUSuario($recepcionista)) { ?>
                <script type="text/javascript">
                    alert("Se ha modificado el correo electrónico.");
                    window.location = "frm_buscar_recepcionista.php";
                </script>
                <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                alert('Error, ya existe un recepcionista con ese correo.');
                window.location = "frm_buscar_recepcionista.php";
            </script>
            <?php
        }
    }
    ?>

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

    <!-- Logout Modal-->
<div class="modal fade" id="enviarClaveModal" tabindex="-1" role="dialog"
     aria-labelledby="enviarClaveModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enviarClaveModalLabel">
                    Restablecer contraseña.
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Se modificará la contraseña del recepcionista.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-ligth" href="reenviar_clave.php?id=<?php echo $idRecepcionista;?>">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<!-- /Logout Modal-->

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
