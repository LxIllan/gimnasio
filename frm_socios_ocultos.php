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
require_once 'AdminSocios.php';
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
            <li class="breadcrumb-item">
                <a href="index.php">Buscar Socio</a>
            </li>
            <li class="breadcrumb-item active">Socios Ocultos</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Socios Ocultos
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <!-- row -->
        <div class="card">
            <div class="card card-primary">
                <div class="card card-heading">
                    <h3 class="card-title text-center">Socios ocultos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                            <tr class="bg-primary">
                                <th>N°</th>
                                <th>Foto</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Estado</th>
                                <th>Fin de membresía<th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $adminSocios = new AdminSocios();
                            $socios = $adminSocios->listarSociosOcultos("");
                            if ($socios != null) {
                                $totalSocios = $socios->size();
                                $socios->sort();
                            } else {
                                $totalSocios = 0;
                            }
                            $i = 0;
                            while ($i < $totalSocios) {
                                $diasSobrantes = Util::diasSobrantes($socios->get($i)->getFechaFinMembresia());
                                $idSocio = $socios->get($i)->getIdSocio();
                                ?>
                                <tr <?php if ($diasSobrantes <= 0) echo "class=\"table-warning\""; else if (($diasSobrantes > 0) && ($diasSobrantes <= 5)) echo "class=\"table-warning\"";?>>
                                    <td>
                                        <?php echo $i + 1;?>
                                    </td>

                                    <td>
                                        <img class="rounded-circle" height="120" width="120"
                                             src="<?php echo $socios->get($i)->getRutaFotografia(); ?>"/>
                                    </td>

                                    <td>
                                        <?php echo $socios->get($i)->getNombrePila();?>
                                    </td>

                                    <td>
                                        <?php echo $socios->get($i)->getApellido1() . " "
                                            . $socios->get($i)->getApellido2();?>
                                    </td>

                                    <td>
                                        <?php if($diasSobrantes > 0) echo "Activo"; else echo "Inactivo";?>
                                    </td>

                                    <td>
                                        <?php echo Util::formatearFecha($socios->get($i)->getFechaFinMembresia());?>
                                    </td>
                                    <td><div class="btn-group">
                                            <button type="button" class="btn btn-primary
                                                dropdown-toggle btn-sm"
                                                    data-toggle="dropdown">&nbsp;&nbsp;<i
                                                        class="fa fa-fw fa-cogs"></i>&nbsp;&nbsp;
                                                <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="frm_editar_socio.php?id=<?php echo $idSocio;?>">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                    Editar
                                                </a>
                                                <?php
                                                if ($_SESSION['usuario']['root']) { ?>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item"
                                                       href="frm_eliminar_socio.php?id=<?php echo $idSocio;?>">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                        Eliminar
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="frm_renovar_membresia.php?id=<?php echo $idSocio;?>">
                                                    <i class="fa fa-fw fa-money"></i>
                                                    Renovar
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="desocultar_socio.php?id=<?php echo
                                                   $idSocio;?>">
                                                    <i class="fa fa-fw fa-eye-slash"></i>
                                                    Desocultar
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            if ($totalSocios == 0){
                                ?>
                                <div class="alert alert-warning text-center">
                                    <strong>¡Opps!</strong> Parece que no tenemos registros de lo que buscas.
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
        <!-- row -->




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
