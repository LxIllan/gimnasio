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
require_once 'AdminProductos.php';
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
            <li class="breadcrumb-item active">Estadísticas</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Estadísticas
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post">
                    <div class="alert alert-ligth alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        Seleccione las fechas en las que desea ver las estadísticas.
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="fechaInicio">Incio:</label><br>
                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio"
                                value="<?php
                                if(isset($_POST['submit'])) {
                                    echo $_REQUEST['fechaInicio'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>"
                                min="2017-06-01" max="<?php echo date("Y-m-d");?>">  
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="fechaFin">Fin:</label><br>
                            <input type="date" class="form-control" name="fechaFin" id="fechaFin"
                                value="<?php
                                if(isset($_POST['submit'])) {
                                    echo $_REQUEST['fechaFin'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>"
                                min="2017-07-01" max="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" value="Aceptar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

        <?php
        if (isset($_POST['submit'])) {
            $fechaInicio = $_REQUEST['fechaInicio'];
            $fechaFin = $_REQUEST['fechaFin'];
            if ($fechaInicio <= $fechaFin) { ?>
                <!-- card -->
                <br>
                <div class="card">
                    <div class="card-primary">
                        <div class="card card-heading text-center">
                            <h3 class="card-title">
                                Estadísticas del
                                <?php echo "<b>" . Util::formatearFecha($fechaInicio)
                                    . " </b>al<b> " . Util::formatearFecha($fechaFin)
                                    . "</b>"; ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="alert alert-primary alert-dismissible text-center">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <b>Productos</b>
                                    </div>
                                    <!-- Tabla Productos -->
                                    <table class="table table-hover table-condensed">
                                        <thead>
                                        <tr class="bg-primary">
                                            <th>Producto</th>
                                            <th>Contenido</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Fecha</th>
                                            <th>Recepcionista</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $dineroAcomulado = 0;
                                        $adminProductos = new AdminProductos();
                                        $ventasDeHoy = $adminProductos->dameVentaDeProductosFechas($fechaInicio, $fechaFin);
                                        if ($ventasDeHoy != null) {
                                            foreach ($ventasDeHoy as $fila) { ?>
                                                <tr>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($fila as $elemento) { ?>
                                                        <td><?php
                                                            if ($i== 3) {
                                                                echo "$". $elemento . " M.X.N";
                                                                $valor = $elemento;
                                                            } else if ($i == 5) {
                                                                echo Util::formatearFecha($elemento);
                                                            } else {
                                                                echo $elemento;
                                                            } ?></td> <?php
                                                        if ($i == 4) {
                                                            $dineroAcomulado += $valor * $elemento;
                                                        }
                                                        $i++;
                                                    } ?>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <?php
                                    if ($dineroAcomulado > 0) {?>
                                        <div class="alert alert-primary text-center">
                                            <?php echo "<b>Total  $". $dineroAcomulado. " M.X.N<b>"; ?>
                                        </div>
                                    <?php } else { ?>
                                        <br>
                                        <div class="alert alert-warning text-center">
                                            <strong>¡Upps!</strong> <?php echo "Ningún honorario del <b>" . Util::formatearFecha($fechaInicio) . " </b>al<b> " . Util::formatearFecha($fechaFin) . "</b>" ;?>
                                        </div>
                                        <?php
                                    } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /card -->
                <?php
            } else { ?>
                <div class="alert alert-danger text-center">
                    <strong>¡Error!</strong> La fecha de inicio debe ser menor que la final.
                </div>
                <?php
            }
        }
        ?>



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
