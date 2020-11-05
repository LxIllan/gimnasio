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
require_once 'AdminMembresias.php';
require_once 'AdminSocios.php';
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
                <a href="frm_buscar_socio.php">Buscar Socio</a>
            </li>
            <li class="breadcrumb-item active">Renovar Membresía</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Renovar Membresía
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idSocio = $_GET['id'];
        $adminSocios = new AdminSocios();
        $adminMembresias = new AdminMembresias();
        $socio = $adminSocios->consultarSocio($idSocio);
        $membresias = $adminMembresias->listarMembresias();
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
                            <label class="control-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre"
                                value="<?php echo $socio->getNombrePila(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Primer apellido:</label>
                            <input type="text" class="form-control" name="apellido1"
                                value="<?php echo $socio->getApellido1(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido2">Segundo apellido:</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Membresía:</label>
                            <select name="idMembresia" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < $membresias->size(); $i++) {
                                    echo "<option value = ". $membresias->get($i)->getIdMembresia() .">"
                                        . $membresias->get($i)->getMembresia() . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Fecha de pago:</label>
                            <input type="date" class="form-control" name="fechaDePago"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    
                    
                    
                    <div class="text-center">
                        <input align="center" type="submit" name="aceptar" value="Aceptar"
                            class="btn  btn-primary">
                    </div>
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.content-wrapper-->


    <?php
    if (isset($_POST['aceptar'])) {
        $idRecepcionista = $_SESSION['usuario']['idusuario'];
        $fechaDePago = $_REQUEST['fechaDePago'];
        $idMembresia = $_REQUEST['idMembresia'];
        $idRecepcionista = $_SESSION['usuario']['idusuario'];
        $idGimnasio = $_SESSION['usuario']['gimnasio'];
        if ($adminSocios->renovarMembresia($idSocio, $idMembresia, $fechaDePago, $idGimnasio,
            $idRecepcionista)) { ?>
            <script type="text/javascript">
                alert("Se renovó la membresía correctamente.");
                window.location = "index.php";
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
<!-- /.container-fluid-->
</body>
</html>
