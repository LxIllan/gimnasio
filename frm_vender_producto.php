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
    <meta name="description" content="Vender Producto">
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
require_once 'AdminTiposProducto.php';
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
                <a href="frm_buscar_producto.php">Buscar Producto</a>
            </li>
            <li class="breadcrumb-item active">Vender Producto</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Vender Producto
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idProducto = $_GET['id'];
        $adminTiposProducto = new AdminTiposProducto();
        $adminProductos = new AdminProductos();
        $producto = $adminProductos->consultarProducto($idProducto);
        $tipoProducto = $adminTiposProducto->consultarTipoProducto($producto->getIdTipoProducto());
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post" enctype="multipart/form-data">
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $producto->getRutaFotografia(); ?>"/>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtNombre">Nombre: </label><br>
                            <input type="text" class="form-control" name="nombre" id="txtNombre"
                                value="<?php echo $producto->getNombre(); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtContenido">Contenido:</label><br>
                            <input type="text" class="form-control" name="contenido" id="txtContenido"
                                value="<?php echo $producto->getContenido(); ?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Tipo:</label><br>
                            <input type="text" class="form-control" name="numPiezas" id="txtPiezasVendidas" min="1"
                                step="1" value="<?php echo $tipoProducto->getTipoProducto(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtPiezasVendidas">Piezas a vender:</label><br>
                            <input type="number" class="form-control" name="piezasVendidas"
                                id="txtPiezasVendidas" min="1" max="<?php echo $producto->getNumPiezas(); ?>" 
                                step="1" value="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtPrecio">Precio:</label><br>
                            <input type="text" class="form-control" name="precio" id="txtPrecio"
                                value="<?php echo Util::formatearDinero($producto->getPrecio());?>"
                                disabled>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" value="Aceptar"
                            class="btn  btn-primary">
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

    <?php
    if (isset($_POST['submit'])) {
        $piezasVendidas = $_REQUEST['piezasVendidas'];
        $idRecepcionista = $_SESSION['usuario']['idusuario'];
        $idGimnasio = $_SESSION['usuario']['gimnasio'];
        if ($adminProductos->venderProducto($idProducto, $piezasVendidas, $idGimnasio,
            $idRecepcionista)) {
            ?>
            <script type="text/javascript">
                alert("Venta exitosa.");
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
<!-- /.content-wrapper-->
</body>
</html>