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
            <li class="breadcrumb-item active">Historial de retiros</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Historial de retiros
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->


        <!-- row -->
        <div class="card">
            <div class="card card-primary">
                <div class="card-heading">
                    <center><h3 class=" card card-title">Retiros realizados</h3></center>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                            <tr class="bg-primary">
                                <th>N°</th>
                                <th>Monto</th>
                                <th>Justificación</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $adminDinero = new AdminDinero();
                            $retirosDeEfectivo = $adminDinero->listarRetirosDeEfectivo();
                            if ($retirosDeEfectivo != null) {
                                $totalRetiros = $retirosDeEfectivo->size();
                                $retirosDeEfectivo->sort();
                            } else {
                                $totalRetiros = 0;
                            }
                            $i = 0;
                            while ($i < $totalRetiros) { ?>
                                <tr>
                                <td><?php echo $i + 1;?></td>
                                <td><?php echo Util::formatearDinero($retirosDeEfectivo->get($i)
                                        ->getMonto());?>
                                </td>
                                <td><?php echo $retirosDeEfectivo->get($i)->getJustificacion();?></td>
                                <td><?php echo Util::formatearFecha($retirosDeEfectivo->get($i)->getFecha());?></td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                       href="frm_cancelar_retiro.php?id=<?php echo $retirosDeEfectivo->get($i)->getIdRetiroDeEfectivo();?>">
                                        Cancelar
                                    </a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            if ($totalRetiros == 0) {
                                ?>
                                <div class="alert alert-warning text-center">
                                    <strong>¡Upps!</strong> Aún no se ha realizado un retiro.
                                </div>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->



    </div>
    <!-- /.container-fluid-->


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
