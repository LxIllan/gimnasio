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
    require_once 'AdminMembresias.php';
    require_once 'AdminProductos.php';
    require_once 'Producto.php';
    require_once 'Membresia.php';
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
        <li class="breadcrumb-item active">Membresías</li>
      </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Membresías
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->


         <?php
            $adminMembresias = new AdminMembresias();
            $adminProductos = new AdminProductos();
            $visita = $adminProductos->consultarProducto(1);
            $mensual = $adminMembresias->dameMembresia(Membresia::MENSUAL);
            $trimestral = $adminMembresias->dameMembresia(Membresia::TRIMESTRAL);
            $semestral = $adminMembresias->dameMembresia(Membresia::SEMESTRAL);
            $anual = $adminMembresias->dameMembresia(Membresia::ANUAL);
            $semanal = $adminMembresias->dameMembresia(Membresia::SEMANAL);        
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Visita:</label><br>
                            <input type="number" class="form-control" name="visita" step="10" value="<?php echo $visita->getPrecio(); ?>" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Mensual:</label><br>
                            <input type="number" class="form-control" name="mensual" step="50" value="<?php echo $mensual->getCosto(); ?>" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Trimestral:</label><br>
                            <input type="number" class="form-control" name="trimestral"  step="50" value="<?php echo $trimestral->getCosto(); ?>" min="0" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Semestral:</label><br>
                            <input type="number" class="form-control" name="semestral"  step="50" value="<?php echo $semestral->getCosto(); ?>" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Anual:</label><br>
                            <input type="number" class="form-control" name="anual" step="50" value="<?php echo $anual->getCosto(); ?>" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Semanal:</label><br>
                            <input type="number" class="form-control" name="semanal" step="50" value="<?php echo $semanal->getCosto(); ?>" min="0" required>  
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="aceptar" value="Aceptar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

    <?php 
        if (isset($_POST['aceptar'])) {
            $visita->setPrecio($_POST['visita']);
            $adminProductos->editarProducto($visita);

            $mensual->setCosto($_POST['mensual']);
            $adminMembresias->editarMembresia($mensual);

            $trimestral->setCosto($_POST['trimestral']);
            $adminMembresias->editarMembresia($trimestral);

            $semestral->setCosto($_POST['semestral']);
            $adminMembresias->editarMembresia($semestral);

            $anual->setCosto($_POST['anual']);
            $adminMembresias->editarMembresia($anual);

            $semanal->setCosto($_POST['semanal']);
            $adminMembresias->editarMembresia($semanal);
            ?>
            <script type="text/javascript">
                alert("Las membresías se actualizaron correctamente.");
                window.location = "Index.php";
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
