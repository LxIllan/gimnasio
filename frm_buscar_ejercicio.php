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
    require_once 'AdminEjercicios.php';
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
            <li class="breadcrumb-item active">Buscar Ejercicio</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Buscar Ejercicio
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if(isset($_POST['aceptar'])) echo $_REQUEST['nombre']; ?>">  
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Sexo:</label>
                            <select name="idSexo" class="form-control custom-select">
                                <?php
                                echo "<option value = ". (0) .">" . Todos . "</option>";
                                for ($i = 0; $i < count(Util::SEXOS); $i++) {
                                    echo "<option value = ". ($i + 1) .">"
                                        . Util::SEXOS[$i] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="aceptar" value="Aceptar" class="btn btn-primary">
                    </div>
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
                                <th>Ejercicio</th>
                                <th>Musculo</th>
                                <th>Sexo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $adminEjercicios = new AdminEjercicios();
                            $ejercicios = (isset($_POST['aceptar'])) ? $adminEjercicios->listarEjercicios($_REQUEST['nombre'], $_REQUEST['idSexo']) : $adminEjercicios->listarEjercicios('', 0);
                            $totalEjercicios = ($ejercicios != null) ? $ejercicios->size() : 0;
                            $i = 0;
                            while ($i < $totalEjercicios) {
                                $idEjercicio = $ejercicios->get($i)->getIdEjercicio();
                                ?>
                                <tr>
                                    <td><?php echo $i + 1;?></td>
                                    <td>
                                        <img height="120" width="320"
                                             src="<?php echo $ejercicios->get($i)->getRutaFotografia(); ?>"/>
                                    </td>
                                    <td><?php echo $ejercicios->get($i)->getNombre();?></td>
                                    <td><?php echo Util::MUSCULOS[$ejercicios->get($i)->getIdMusculo() - 1];?></td>
                                    <td><?php echo Util::SEXOS[$ejercicios->get($i)->getIdSexo() - 1];?></td>
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
                                                    <a class="dropdown-item" href="frm_editar_ejercicio.php?id=<?php echo $idEjercicio;?>">
                                                        <i class="fa fa-fw fa-edit"></i>
                                                        Editar
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="frm_eliminar_ejercicio.php?id=<?php echo $idEjercicio;?>">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                        Eliminar
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <?php
                                    }
                                    ?>                                    
                                </tr>
                                <?php
                                $i++;
                            }
                            if ($totalEjercicios == 0) {
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
