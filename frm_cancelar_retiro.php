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
require_once 'AdminDinero.php';
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
            <li class="breadcrumb-item">
                <a href="frm_historial_de_retiros.php">Historial de retiros</a>
            </li>
            <li class="breadcrumb-item active">Cancelar retiro</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Cancelar retiro
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->


        <?php
        require_once('AdminDinero.php');
        $adminDinero = new AdminDinero();
        $idRetiro = $_GET['id'];
        $retiroDeEfectivo = $adminDinero->dameRetiro($idRetiro);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <label class="control-label" for="txtNombre">Monto:</label>
                    <input type="text" class="form-control" name="nombre" id="txtNombre"
                           value="<?php echo $retiroDeEfectivo->getMonto(); ?>" disabled><br>
                    <label class="control-label" for="txtJustificacion">Justificación:</label><br>
                    <input type="text" class="form-control" name="justificacion"
                           id="txtJustificacion"
                           value="<?php echo $retiroDeEfectivo->getJustificacion(); ?>" disabled> <br>
                    <label class="control-label" for="txtFecha">Fecha:</label><br>
                    <input type="text" class="form-control" name="fecha" id="txtFecha"
                           value="<?php echo Util::formatearFecha($retiroDeEfectivo->getFecha()); ?>"
                           disabled> <br>
                    <div class="alert alert-primary alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                            <strong>¡Cuidado!</strong> No se podrá recuperar en un futuro.
                    </div>
                    <div class="text-center">
                        <input align="Center" type="submit" name="aceptar"
                               value="Aceptar" class="btn btn-primary">
                        <input align="Center" type="submit" name="cancelar"
                               value="Cancelar" class="btn btn-litgh"><br>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

    <?php
    if (isset($_POST['aceptar'])) {
        if ($adminDinero->cancelarRetiro($idRetiro)) {
            $idGimasio = $_SESSION['usuario']['gimnasio'];
            $adminDinero->actualizarMontoActual($idGimasio, $retiroDeEfectivo->getMonto());
            ?>
            <script type="text/javascript">
                alert("Se ha cancelado el retiro.");
                window.location = "frm_historial_de_retiros.php";
            </script>
            <?php
        }
    }
    if (isset($_POST['cancelar'])) { ?>
        <script type="text/javascript">
            window.location = "frm_historial_de_retiros.php";
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
