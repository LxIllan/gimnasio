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
        <li class="breadcrumb-item active">Solicitar contraseña</li>
      </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Solicitar contraseña
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->


        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6">
                <form class="form-control" action="" method="post">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Ingrese su correo para restablecer la contraseña.
                    </div>
                    <label class="control-label">Nombre:</label><br>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required><br>
                    <label class="control-label">Correo electrónico:</label><br>
                    <input type="email" class="form-control" name="correoElectronico" placeholder="Correo electronico" required><br>
                    <input align="Center" type="submit" name="aceptar" value="Aceptar"
                           class="btn btn-block btn-primary">
                    <br>
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->


    <?php
        if (isset($_POST['aceptar'])) {
            require_once 'correo_solicitar_clave.php';
            $correoElectronico = $_POST['correoElectronico'];
            $nombre = $_POST['nombre'];
            $idGimnasio = $_SESSION['usuario']['gimnasio'];
            if (enviarSolicitud($correoElectronico, $nombre, $idGimnasio)) {
                ?>
                <script type="text/javascript">
                    alert("Listo, su administrador le mandará una nueva clave.");
                    window.location = "index.php";
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert("La dirección de correo electrónico no se encuentra en nuestros registros.");
                    window.location = "frm_solicitar_clave.php";
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
  <!-- /.content-wrapper-->
</body>
</html>
