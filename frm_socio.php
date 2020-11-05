<?php
session_start();
if (!isset($_SESSION['socio'])) {
    header('Location: login_socios.php');
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
    <!-- Others -->
    <script src = "js/Util.js"></script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php
    require_once 'Util.php';
    require_once 'AdminSocios.php';
    require_once 'AdminEjercicios.php';
    require_once 'navigation_socio.php';
?>

<!-- content-wrapper-->
<div class="content-wrapper">

    <!-- container-fluid-->
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">Inicio</h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
          $idSocio = $_SESSION['socio']['idSocio'];
          $adminSocios = new AdminSocios();
          $socio = $adminSocios->consultarSocio($idSocio);
          $nivelSocio = $adminSocios->getNivel($idSocio);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post">
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $socio->getRutaFotografia(); ?>"/>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="txtNombre" class="control-label">Nombre:</label>
                            <input id="txtNombre" type="text" class="form-control" name="txtNombre"
                                value="<?php echo $socio->getNombrePila(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="txtApellido1" class="control-label">Primer apellido:</label>
                            <input id="txtApellido1" type="text" class="form-control" name="txtApellido1"
                               value="<?php echo $socio->getApellido1(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="txtApellido2" class="control-label">Segundo apellido:</label>
                            <input id="txtApellido2" type="text" class="form-control" name="txtApellido2"
                                value="<?php echo $socio->getApellido2(); ?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso (Kg):</label><br>
                            <input type="number" class="form-control" name="peso" 
                                min="1" step="any" value="<?php echo $socio->getPeso(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="inputPassword4">Nivel: </label>
                            <input type="text" class="form-control" name="nivel"
                                value="<?php echo $nivelSocio; ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Estatura (Metros):</label><br>
                            <input type="number" class="form-control" name="estatura" 
                                min="1" step="any" value="<?php echo $socio->getEstatura(); ?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Fecha de inscripción:</label><br>
                            <input type="text" class="form-control" name="peso" 
                                min="1" step="any" value="<?php echo $socio->getFechaInscripcion(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Membresía:</label><br>
                            <input type="text" class="form-control" name="peso" 
                                min="1" step="any" value="<?php echo Util::MEMBRESIAS[$socio->getIdMembresia() - 1]; ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="inputPassword4">Fin de memebresía: </label>
                            <input type="text" class="form-control" name="nivel"
                                value="<?php echo $socio->getFechaFinMembresia(); ?>" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->


    </div>
    <!-- /.content-wrapper-->


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
</div>
<!-- /.container-fluid-->
</body>
</html>
