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
    <!-- Others -->
    <script src = "js/Util.js"></script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php
require_once 'Util.php';
require_once 'AdminSocios.php';
require_once 'navigation.php';
require_once 'AdminProductos.php';
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
            <li class="breadcrumb-item active">Inicio</li>
        </ol>
        <!-- /.Breadcrumbs-->


        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">Inicio</h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <!-- Accordion -->
        <div id="accordion" role="tablist">

            <!-- card Honorarios -->
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" href="#collapseHonorarios" aria-expanded="true" aria-controls="collapseHonorarios">
                            Honorarios
                        </a>
                    </h5>
                </div>

                <div id="collapseHonorarios" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card panel-green">
                                    <div class="card-heading">
                                        <h3 class="card text-center">Honorarios del <?php echo
                                                Util::formatearFecha(date('j-M-Y')); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <div class="alert alert-primary alert-dismissible
                                                text-center">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <b>Venta de membresías</b>
                                                </div>
                                                <table class="table table-hover table-sm">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th>Socio</th>
                                                        <th>Membresía</th>
                                                        <th>Precio</th>
                                                        <th>Recepcionista</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $adminSocios = new AdminSocios();
                                                    $membresiasDeHoy = $adminSocios->dameVentaDeMembresias(true);
                                                    $dineroAcomulado = 0;
                                                    if ($membresiasDeHoy != null) {
                                                        foreach ($membresiasDeHoy as $fila) { ?>
                                                            <tr>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($fila as $elemento) { ?>
                                                                    <td><?php
                                                                        if ($i== 3) {
                                                                            echo Util::formatearDinero($elemento);
                                                                            $dineroAcomulado += $elemento;
                                                                        } else {
                                                                            echo $elemento;
                                                                        } ?></td> <?php
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
                                                <div class="alert alert-primary alert-dismissible
                                                text-center">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <b>Venta de productos</b>
                                                </div>
                                                <!-- Tabla Productos -->
                                                <table class="table table-hover table-sm">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th>Producto</th>
                                                        <th>Contenido</th>
                                                        <th>Precio</th>
                                                        <th>Cantidad</th>
                                                        <th>Recepcionista</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $adminProductos = new AdminProductos();
                                                    $ventasDeHoy = $adminProductos->dameVentaDeProductos(true);
                                                    if ($ventasDeHoy != null) {
                                                        foreach ($ventasDeHoy as $fila) { ?>
                                                            <tr>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($fila as $elemento) { ?>
                                                                    <td><?php
                                                                        if ($i == 3) {
                                                                            echo Util::formatearDinero($elemento);
                                                                            $valor = $elemento;
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
                                                if ($dineroAcomulado > 0) { ?>
                                                    <div class="alert alert-success text-center">
                                                        <?php echo "<b>Total " .
                                                            Util::formatearDinero
                                                            ($dineroAcomulado) . "<b>"; ?>
                                                    </div>
                                                <?php } else { ?>
                                                    </tbody>
                                                    </table>
                                                    <br>
                                                    <div class="alert alert-warning text-center">
                                                        <strong>¡Opps!</strong> <?php echo "Ningún honorario hasta el momento.";?>
                                                    </div>
                                                    <?php
                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- /card Honorarios -->

            <!-- card Socios por expirar -->
            <div class="card">
                <div class="card-header" role="tab" id="headingTwo">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseSociosPorExpirar" aria-expanded="false" aria-controls="collapseSociosPorExpirar">
                            Socios por expirar
                        </a>
                    </h5>
                </div>
                <div id="collapseSociosPorExpirar" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card panel-warning">
                                    <div class="card-heading">
                                        <h3 class="card text-center">Socios Por
                                                Expirar</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-sm">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th>Foto</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <th>Fin de membresía</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $adminSocios = new AdminSocios();
                                                    $socios = $adminSocios->listarSocios();
                                                    if ($socios != null) {
                                                        $numSocios = $socios->size();
                                                    } else {
                                                        $numSocios = 0;
                                                    }
                                                    $seMostroUnDato = false;
                                                    for ($i = 0; $i < $numSocios; $i++) {
                                                        $diasSobrantes = Util::diasSobrantes($socios->get($i)->getFechaFinMembresia());
                                                        if (($diasSobrantes >= 1) && ($diasSobrantes <= 3)){
                                                            ?>
                                                            <tr <?php if(($diasSobrantes) == 0) echo "class=\"table-danger\"";
                                                            else echo "class=\"table-warning\""; ?>>
                                                                <td><img class="rounded-circle" height="120" width="120" src="<?php echo $socios->get($i)->getRutaFotografia(); ?>"/></td>
                                                                <td><?php echo $socios->get($i)->getNombrePila();?></td>
                                                                <td><?php echo $socios->get($i)->getApellido1() . " " . $socios->get($i)->getApellido2();?></td>
                                                                <td><?php echo Util::formatearFecha($socios->get($i)->getFechaFinMembresia());?></td>
                                                            </tr>
                                                            <?php
                                                            $seMostroUnDato = true;
                                                        }
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                if (!$seMostroUnDato) { ?>
                                                    <div class="alert alert-warning
                                                    alert-dismissible text-center">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <strong>¡Opps!</strong> <?php echo "A todos los clientes les quedan al menos cuatro días.";?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- /card Socios por expirar -->

            <!-- card Socios vencidos -->
            <div class="card">
                <div class="card-header" role="tab" id="headingThree">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseSociosVencidos" aria-expanded="false" aria-controls="collapseSociosVencidos">
                            Socios vencidos
                        </a>
                    </h5>
                </div>
                <div id="collapseSociosVencidos" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card panel-danger">
                                    <div class="card-heading text-center">
                                        <h3 class="card">Socios Vencidos</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-sm">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th>Foto</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <th>Fecha en que vencio</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $adminSocios = new AdminSocios();
                                                    $socios = $adminSocios->listarSocios("");
                                                    if ($socios != null) {
                                                        $numSocios = $socios->size();
                                                    } else {
                                                        $numSocios = 0;
                                                    }
                                                    $seMostroUnDato = false;
                                                    for ($i = 0; $i < $numSocios; $i++) {
                                                        $diasSobrantes = Util::diasSobrantes($socios->get($i)->getFechaFinMembresia());
                                                        if ($diasSobrantes <= 0) {
                                                            ?>
                                                            <tr class="table-warning">
                                                                <td><img class="rounded-circle" height="120" width="120" src="<?php echo $socios->get($i)->getRutaFotografia(); ?>"/></td>
                                                                <td><?php echo $socios->get($i)->getNombrePila();?></td>
                                                                <td><?php echo $socios->get($i)->getApellido1() . " " . $socios->get($i)->getApellido2();?></td>
                                                                <td><?php echo Util::formatearFecha($socios->get($i)->getFechaFinMembresia());?></td>
                                                                <td><button class = "btn btn-primary btn-xs" onclick="cargarPagina('frm_renovar_membresia.php?id=<?php echo $socios->get($i)->getIdSocio();?>');">Cobrar</button>
                                                                <td><button class = "btn btn-ligth btn-xs" onclick="cargarPagina('ocultar_socio.php?id=<?php echo $socios->get($i)->getIdSocio();?>');">Ocultar</button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $seMostroUnDato = true;
                                                        }
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                if (!$seMostroUnDato) { ?>
                                                    <div class="alert alert-warning
                                                    alert-dismissible text-center">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <strong>¡Opps!</strong> <?php echo "Ningún socio tiene la membresía vencida.";?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- /card Socios por expirar -->

        </div>
        <!-- Accordion -->

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
