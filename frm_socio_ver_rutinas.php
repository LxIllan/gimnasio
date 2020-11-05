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
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php
    require_once 'navigation_socio.php';
    require_once 'Util.php';
    require_once 'AdminSocios.php';
    require_once 'AdminEjercicios.php';
?>

<!-- content-wrapper-->
<div class="content-wrapper">

    <!-- container-fluid-->
    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="frm_socio.php">Inicio</a>
            </li>
            <li class="breadcrumb-item active">Rutinas</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Rutinas
                </h1>
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
                        <div class="form-group col-md-6">
                            <label class="control-label">Socio:</label>
                            <input type="text" class="form-control" name="nombre"
                                value="<?php echo $socio->getNombrePila() . ' ' . $socio->getApellido1(); ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Nivel: </label>
                            <input type="text" class="form-control" name="nivel"
                                value="<?php echo $nivelSocio; ?>" disabled>
                        </div>
                    </div>
                    <label class="control-label">Musculo:</label><br>
                    <select name="idMusculo" class="form-control">
                        <?php
                            for ($i = 0; $i < count(Util::MUSCULOS); $i++) {
                                echo "<option";
                                if (isset($_POST['success'])) {
                                    if ($_POST['idMusculo'] - 1 == $i) {
                                        echo " selected=\"" . "true" . "\"";
                                    }
                                }
                                echo " value = ". ($i + 1) . ">"
                                    . Util::MUSCULOS[$i] . "</option>";
                            }
                        ?>
                    </select><br>
                    <div class="text-center">
                        <input type="submit" name="success" value="Aceptar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

        <?php
        if (isset($_POST['success'])) { 
            $idMusculo = $_POST['idMusculo'];
            $adminEjercicios = new AdminEjercicios();
            $parteDelCuerpo = $adminEjercicios->getParteDelCuerpo($idMusculo);
            $lesion = $adminSocios->getLesion($idSocio, $parteDelCuerpo);
            ?>
            <!-- row -->
            <div class="card">
                <div class="card-primary">
                    <div class="card-heading">
                        <h3 class="card card-title text-center">Ejercicios</h3>
                    </div>
                    <div class="card card-body">
                        <div class="table-responsive">
                            <div class="alert alert-primary alert-dismissible
                                                    text-center">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <b>Lesión: <?php echo Util::LESIONES[$lesion]; ?></b>
                            </div>
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr class="bg-primary">
                                    <th>Foto</th>
                                    <th>Video</th>
                                    <th>Ejercicio</th>
                                    <th>Series</th>
                                    <th>Peso</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ejercicios = $adminEjercicios->listarEjerciciosPUsuario($socio->getIdSexo(), $idMusculo);
                                if ($ejercicios != null) {
                                    $totalEjercicios = $ejercicios->size();
                                    $ejercicios->sort();
                                } else {
                                    $totalEjercicios = 0;
                                }
                                $i = 0;
                                while ($i < $totalEjercicios) {
                                    $id_ejercicio = $ejercicios->get($i)->getIdEjercicio();
                                    ?>
                                    <tr>
                                        <td>
                                            <img height="120" width="300"
                                                src="<?php echo $ejercicios->get($i)->getRutaFotografia(); ?>"/>
                                        </td>
                                        <td>
                                            <br>
                                            <br>
                                            <a href="#view_video<?php echo $id_ejercicio;?>" data-toggle="modal">
                                                <button type='button' class='btn btn-primary btn-lg'><span class='fa fa-fw fa-play' aria-hidden='true'></span></button>
                                            </a>
                                        </td>
                                        <td><?php echo $ejercicios->get($i)->getNombre();?></td>
                                        <td><?php echo $ejercicios->get($i)->getSeries();?></td>

                                        <td>
                                            <?php
                                                $peso = $ejercicios->get($i)->getPeso($nivelSocio);
                                                echo Util::obtenerPeso($peso, $lesion);
                                                echo ' ' . preg_replace("/[^a-zA-Z]/", '', $peso)
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    ?>                                    

                                    <!--view video Item Modal -->
                                    <div id="view_video<?php echo $id_ejercicio;?>" class="modal fade" role="dialog">
                                        <form method="post" class="form-horizontal" role="form">
                                            <div class="modal-dialog modal-md">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Demostración</h4>
                                                        <button type="button" class="close" onclick="resetVideo()" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                            $path_video = 'video/video_' . $id_ejercicio . '.mp4';
                                                            if (!file_exists($path_video)) {
                                                                $path_video = 'video/default.mp4';                                                                
                                                            }
                                                            echo '<div class="embed-responsive embed-responsive-21by9">';
                                                            echo '<video class="embed-responsive-item" id="video_exercise" controls type="video/mp4" src="' . $path_video . '"/>';
                                                            echo '</div>';
                                                        ?>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /view video Item Modal -->
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                                if ($totalEjercicios == 0) {
                                    ?>
                                    <div class="alert alert-warning text-center">
                                        <strong>¡Upps!</strong> Parece que no hay ejercicios para este músculo.
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
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

    <!-- Script to reset video -->
    <script>
    function resetVideo() {        
        var vid = document.getElementById("video_exercise");
        vid.pause();
        vid.currentTime = 0;
    }
    </script>
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