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
    <meta name="description" content="Nuevo Producto">
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
            <li class="breadcrumb-item active">Nuevo Ejercicio</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Nuevo Ejercicio
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <label class="control-label">Foto:</label><br>
                    <div class="text-center">
                        <output id="preview-image"></output>
                        <br>
                        <br>
                    </div>
                    <div class="text-center">
                        <input class="btn-primary" accept=".jpg" type="file" id="foto" name="foto">
                    </div>                    
                    <br>
                    <label class="control-label">Vídeo:</label><br>
                    <div class="text-center">
                        <output id="preview-video"></output>
                        <br>
                        <br>
                    </div>
                    <div class="text-center">
                        <input class="btn-primary" accept=".mp4" type="file" id="video" name="video">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Ejercicio" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Series:</label>
                            <input type="text" class="form-control" name="series" placeholder="Series" required>        
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso principiante:</label>
                            <input type="text" class="form-control" name="pesoPrincipiante" placeholder="5kg" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso intermedio:</label>
                            <input type="text" class="form-control" name="pesoIntermedio" placeholder="5lbs" required>        
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso medio:</label>
                            <input type="text" class="form-control" name="pesoMedio" placeholder="5 discos" required>  
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Peso medioavanzado:</label>
                            <input type="text" class="form-control" name="pesoMedioavanzado" placeholder="5 placas" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Peso avanzado:</label>
                            <input type="text" class="form-control" name="pesoAvanzado" placeholder="5 barras" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Músculo:</label>
                            <select name="idMusculo" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < count(Util::MUSCULOS); $i++) {
                                    echo "<option value = ". ($i + 1) .">"
                                        . Util::MUSCULOS[$i] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Sexo:</label>
                            <select name="idSexo" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < count(Util::SEXOS); $i++) {
                                    echo "<option value = ". ($i + 1) .">"
                                        . Util::SEXOS[$i] . "</option>";
                                }
                                ?>
                            </select>  
                        </div>
                    </div>
                    <div class="text-center">  
                        <input type="submit" name="submit"
                           value="Aceptar" class="btn btn-primary ">
                    </div>
                    
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid-->

    <?php
    if (isset($_POST['submit'])) {        
        $adminEjercicios = new AdminEjercicios();
        $nombre = $_REQUEST['nombre'];
        $series = $_REQUEST['series'];
        $pesoPrincipiante = $_REQUEST['pesoPrincipiante'];
        $pesoIntermedio = $_REQUEST['pesoIntermedio'];
        $pesoMedio = $_REQUEST['pesoMedio'];
        $pesoMedioavanzado = $_REQUEST['pesoMedioavanzado'];
        $pesoAvanzado = $_REQUEST['pesoAvanzado'];
        $idSexo = $_REQUEST['idSexo'];
        $idMusculo = $_REQUEST['idMusculo'];
        $idEjercicio = $adminEjercicios->getSiguienteId();
        $rutaFotografia = Util::cargarImagen((isset($_FILES['foto'])) ? $_FILES['foto'] : null, $idEjercicio, Util::FOTO_EJERCICIO);
        $path_video = Util::load_video((isset($_FILES['video'])) ? $_FILES['video'] : null, $idEjercicio);
        if ($adminEjercicios->agregarEjercicio($nombre, $series, $rutaFotografia, $path_video, $pesoPrincipiante, $pesoIntermedio, $pesoMedio, $pesoMedioavanzado, $pesoAvanzado, $idMusculo, $idSexo)) {
            ?>
            <script type="text/javascript">
                alert("El ejercicio se registró correctamente.");
                window.location = "index.php";
            </script>
            <?php
        } else {
            echo "1";
        }
    }
    ?>

    <script>
        function archivo(evt) {
            var files = evt.target.files; // FileList object
            // Obtenemos la imagen del campo "file".
            for (var i = 0, f; f = files[i]; i++) {
                // Solo admitimos imágenes.
                if (f.type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = (function() {
                        return function(e) {
                            // Insertamos la imagen
                            document.getElementById("preview-image").innerHTML = ['<img alt="responsive image" height="200" width="400" src="', e.target.result,'"/><br>'].join('');
                        };
                    })(f);
                    reader.readAsDataURL(f);
                } else if (f.type.match('video.*')) {
                    var reader = new FileReader();
                    reader.onload = (function() {
                        return function(e) {
                            // Insertamos la imagen
                            document.getElementById("preview-video").innerHTML = ['<video controls type="video/mp4" height="200" width="400" src="', e.target.result,'"/><br>'].join('');
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }
                else {
                    continue;
                }     
            }
        }
        document.getElementById('foto').addEventListener('change', archivo, false);
        document.getElementById('video').addEventListener('change', archivo, false);
    </script>


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
