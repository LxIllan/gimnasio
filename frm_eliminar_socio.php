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
require_once 'AdminSocios.php';
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
                <a href="frm_buscar_socio.php">Buscar Socio</a>
            </li>
            <li class="breadcrumb-item active">Eliminar Socio</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Eliminar socio
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idSocio = $_GET['id'];
        $adminSocios = new AdminSocios();
        $socio = $adminSocios->consultarSocio($idSocio);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post">
                    <div class="alert alert-light alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>¡Cuidado!</strong> Revise los datos antes de eliminar.
                    </div>
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $socio->getRutaFotografia(); ?>"/>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtNombre">Nombre:</label><br>
                            <input type="text" class="form-control" name="txtNombre" id="txtNombre"
                                value="<?php echo $socio->getNombrePila(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtApellido1">Primer apellido:</label><br>
                            <input type="text" class="form-control" name="txtApellido1" id="txtApellido1"
                                value="<?php echo $socio->getApellido1();?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtApellido2">Segundo apellido:</label><br>
                            <input type="text" class="form-control" name="txtApellido2" id="txtApellido2"
                                value="<?php echo $socio->getApellido2();?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtCorreo">Correo:</label><br>
                            <input type="text" class="form-control" name="txtCorreo" id="txtCorreo"
                                value="<?php echo $socio->getCorreo();?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                        <label class="control-label" for="txtDiasSobrantes">Estado:</label><br>
                            <input type="text" class="form-control" name="txtDiasSobrantes"
                                id="txtDiasSobrantes"
                                value="<?php
                                $diasSobrantes = Util::diasSobrantes($socio->getFechaFinMembresia());
                                    if($diasSobrantes > 0) {
                                        echo "Activo: La membresía termina el "
                                            . Util::formatearFecha($socio->getFechaFinMembresia()) . ".";
                                    } else {
                                        echo "Inactivo: La mebresía terminó el " . Util::formatearFecha
                                            ($socio->getFechaFinMembresia()) . "";
                                    } ?>" disabled>
                        </div>
                    </div>
                    <div class="alert alert-primary alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span> </button>
                        <strong>¡Cuidado!</strong> No se podrá recuperar en un futuro.
                    </div>
                    <div class="text-center">
                        <input align="Center" type="submit" name="success"
                               value="Aceptar" class="btn btn-light">

                        <input align="Center" type="submit" name="cancel"
                               value="Cancelar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

        <?php
        if (isset($_POST['success'])) {
            if ($adminSocios->eliminarSocio($idSocio)) {
                ?>
                <script>
                    alert("Se ha eliminado el socio.");
                    window.location = "frm_buscar_socio.php";
                </script>
                <?php
            } else {
                echo 'Error';
            }
        }
        if (isset($_POST['cancel'])) { ?>
            <script>
                window.location = "frm_buscar_socio.php";
            </script>
            <?php
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
