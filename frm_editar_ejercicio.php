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
            <li class="breadcrumb-item">
                <a href="frm_buscar_ejercicio.php">Buscar ejercicio</a>
            </li>
            <li class="breadcrumb-item active">Editar ejercicio</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Editar Ejercicio
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
            $idEjercicio = $_GET['id'];
            $adminEjercicios = new AdminEjercicios();
            $ejercicio = $adminEjercicios->consultarEjercicio($idEjercicio);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <label class="control-label">Foto:</label><br>
                    <div class="text-center">
                        <img alt="responsive image" height="200" width="400"
                             src="<?php echo $ejercicio->getRutaFotografia(); ?>"/>
                        <br>
                        <br>            
                        <output id="preview-image"></output>
                        <br>
                        <br>
                        <input type="file" accept=".jpg" class="btn-primary" id="image" name="image">    
                        <br>
                        <br>                        
                    </div>
                    <label class="control-label">Vídeo:</label><br>
                    <div class="text-center">
                        <video controls type="video/mp4" height="200" width="400" src="<?php echo $ejercicio->getPathVideo(); ?>"/>
                        <br>
                        <br>
                    </div>
                    <div class="text-center">
                        <output id="preview-video"></output>
                        <br>
                        <br>
                        <input type="file" accept=".mp4" class="btn-primary" id="video" name="video">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo $ejercicio->getNombre(); ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Series:</label>
                            <input type="text" class="form-control" name="series"value="<?php echo $ejercicio->getSeries(); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso principiante:</label>
                            <input type="text" class="form-control" name="pesoPrincipiante" value="<?php echo $ejercicio->getPesoPrincipiante(); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso intermedio:</label>
                            <input type="text" class="form-control" name="pesoIntermedio" value="<?php echo $ejercicio->getPesoIntermedio(); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Peso medio:</label>
                            <input type="text" class="form-control" name="pesoMedio" value="<?php echo $ejercicio->getPesoMedio(); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Peso medioavanzado:</label>
                            <input type="text" class="form-control" name="pesoMedioavanzado" value="<?php echo $ejercicio->getPesoMedioavanzado(); ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Peso avanzado:</label>
                            <input type="text" class="form-control" name="pesoAvanzado" value="<?php echo $ejercicio->getPesoAvanzado(); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Músculo:</label>
                            <select name="idMusculo" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < count(Util::MUSCULOS); $i++) {
                                    echo "<option";
                                    if ($ejercicio->getIdMusculo() == $i + 1) {
                                        echo " selected=\"" . "true" . "\"";
                                    }
                                    echo " value = ". ($i + 1) . ">"
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
                                    echo $ejercicio->getIdSexo();
                                    echo "<option";
                                    if ($ejercicio->getIdSexo() == $i + 1) {
                                        echo " selected=\"" . "true" . "\"";
                                    }
                                    echo " value = ". ($i + 1) . ">"
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
        $ejercicio->setNombre($_REQUEST['nombre']);
        $ejercicio->setSeries($_REQUEST['series']);
        $ejercicio->setPesoPrincipiante($_REQUEST['pesoPrincipiante']);
        $ejercicio->setPesoIntermedio($_REQUEST['pesoIntermedio']);
        $ejercicio->setPesoMedio($_REQUEST['pesoMedio']);
        $ejercicio->setPesoMedioavanzado($_REQUEST['pesoMedioavanzado']);
        $ejercicio->setPesoAvanzado($_REQUEST['pesoAvanzado']);
        $ejercicio->setIdSexo($_REQUEST['idSexo']);
        $ejercicio->setIdMusculo($_REQUEST['idMusculo']);
        if (isset($_FILES['image'])) {
            $ejercicio->setRutaFotografia(Util::cargarImagen($_FILES['image'], $idEjercicio, Util::FOTO_EJERCICIO));
        }
        if (isset($_FILES['video'])) {
            $ejercicio->setPathVideo(Util::load_video($_FILES['video'], $idEjercicio));
        }
        echo 'S';
        if ($adminEjercicios->editarEjercicio($ejercicio)) {
            ?>
            <script type="text/javascript">
                alert("El ejercicio se guardó correctamente.");
                window.location = "frm_buscar_ejercicio.php";
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
                            document.getElementById("preview-image").innerHTML = ['<div class="alert alert-info"><?php echo "La fotografía inferior es la nueva fotografía.";?></div><img height="200" width="400" src="', e.target.result,'"/><br>'].join('');
                        };
                    })(f);
                    reader.readAsDataURL(f);
                } else if (f.type.match('video.*')) {
                    var reader = new FileReader();
                    reader.onload = (function() {
                        return function(e) {
                            // Insertamos la imagen
                            document.getElementById("preview-video").innerHTML = ['<div class="alert alert-info"><?php echo "El vídeo inferior es el nuevo vídeo.";?></div><video controls height="200" width="400" src="', e.target.result,'"/><br>'].join('');
                        };
                    })(f);
                    reader.readAsDataURL(f);
                } else {
                    continue;
                }
                
            }
        }
        document.getElementById('image').addEventListener('change', archivo, false);
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
