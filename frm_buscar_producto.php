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
    <meta name="description" content="Buscar Producto">
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
            <li class="breadcrumb-item active">Buscar Producto</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Buscar Producto
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6">
                <form action="" class="form-control" method="post">
                    <label class="control-label">Nombre:</label><br>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if(isset($_POST['aceptar'])) echo $_REQUEST['nombre']; ?>"> <br>
                    <input align="Center" type="submit" name="aceptar" value="Aceptar"
                           class="btn btn-primary">
                    <br>
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->

        <!-- card -->
        <div class="card">
            <div class="card-primary">
                <div class="card-heading">
                    <h3 class="card card-title text-center">Resultados de la búsqueda</h3>
                </div>
                <div class="card card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                            <tr class="bg-primary">
                                <th>N°</th>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Contenido</th>
                                <th>Precio</th>
                                <th>Existencias<th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $adminProductos = new AdminProductos();
                            if (isset($_POST['aceptar'])) {
                                $productos = $adminProductos->listarProductos($_REQUEST['nombre']);
                            } else {
                                $productos = $adminProductos->listarProductos();
                            }
                            if ($productos != null) {
                                $totalProductos = $productos->size();
                            } else {
                                $totalProductos = 0;
                            }
                            $i = 0;
                            while ($i < $totalProductos) {
                                $idProdcuto =$productos->get($i)->getIdProducto();
                                $numPiezas = $productos->get($i)->getNumPiezas();
                                ?>
                                <tr <?php if ($numPiezas == 0) echo "class=\"table-warning\"";?>>
                                    <td><?php echo $i + 1;?></td>
                                    <td>
                                        <img class="rounded-circle" height="120" width="120"
                                             src="<?php echo $productos->get($i)->getRutaFotografia(); ?>"/>
                                    </td>
                                    <td><?php echo $productos->get($i)->getNombre();?></td>
                                    <td><?php echo $productos->get($i)->getContenido();?></td>
                                    <td><?php echo Util::formatearDinero($productos->get($i)
                                            ->getPrecio());?>
                                    </td>
                                    <td><?php echo $productos->get($i)->getNumPiezas();?></td>
                                    <?php
                                    if ($_SESSION['usuario']['root']) { ?>
                                        <td><div class="btn-group">
                                                <button type="button" class="btn btn-primary
                                                dropdown-toggle btn-sm"
                                                        data-toggle="dropdown">&nbsp;&nbsp;<i
                                                        class="fa fa-fw fa-cogs"></i>&nbsp;&nbsp;
                                                    <span class="caret"></span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="frm_editar_producto.php?id=<?php echo $idProdcuto;?>">
                                                        <i class="fa fa-fw fa-edit"></i>
                                                        Editar
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="frm_eliminar_producto.php?id=<?php echo $idProdcuto;?>">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                        Eliminar
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="frm_surtir_producto.php?id=<?php echo $idProdcuto;?>">
                                                        <i class="fa fa-fw fa-cart-plus"></i>
                                                        Surtir
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($numPiezas > 0) { ?>
                                        <td>
                                            <a class="btn btn-sm btn-secondary"
                                               href="frm_vender_producto.php?id=<?php echo $idProdcuto;?>">
                                                <i class="fa fa-fw fa-usd"></i>
                                                Vender
                                            </a>
                                        </td>
                                        <?php
                                    } else { ?>
                                        <td></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            if ($totalProductos == 0) {
                                ?>
                                <div class="alert alert-warning text-center">
                                    <strong>¡Upps!</strong> No tenemos registros de lo que buscas.
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
        <!-- /card -->

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
