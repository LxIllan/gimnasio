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
    <meta name="description" content="Editar Socio">
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
require_once 'AdminSocios.php';
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
                <a href="frm_buscar_socio.php">Buscar Socio</a>
            </li>
            <li class="breadcrumb-item active">Editar Socio</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Editar Socio
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idSocio = $_GET['id'];
        $adminSocios = new AdminSocios();
        $socio = $adminSocios->consultarSocio($idSocio);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="alert alert-light alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Tip:</strong> El segundo apellido, correo electrónico y la foto
                                pueden quedar en blanco.
                    </div>
                    <label class="control-label">Foto:</label>
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $socio->getRutaFotografia(); ?>"/>
                        <br>
                        <br>
                        <output id="list"></output>
                        <br>
                        <input type="file" accept=".jpg" class="btn-info" id="files" name="files">    
                        <br>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="txtNombre" class="control-label">Nombre:</label>
                            <input id="txtNombre" type="text" class="form-control" name="txtNombre"
                                value="<?php echo $socio->getNombrePila(); ?>" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="txtApellido1" class="control-label">Primer apellido:</label>
                            <input id="txtApellido1" type="text" class="form-control" name="txtApellido1"
                               value="<?php echo $socio->getApellido1(); ?>" required pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="txtApellido2" class="control-label">Segundo apellido:</label>
                            <input id="txtApellido2" type="text" class="form-control" name="txtApellido2"
                                value="<?php echo $socio->getApellido2(); ?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]*">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Peso (Kg):</label><br>
                            <input type="number" class="form-control" name="peso" 
                                min="1" step="any" value="<?php echo $socio->getPeso(); ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Estatura (Metros):</label><br>
                            <input type="number" class="form-control" name="estatura" 
                                min="1" step="any" value="<?php echo $socio->getEstatura(); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en el abdomen:</label><br>
                            <select name="lesionAbdomen" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                    echo "<option";
                                    if ($socio->getLesionAbdomen() == $i) {
                                        echo " selected=\"" . "true" . "\"";
                                    }
                                    echo " value = ". $i . ">"
                                        . Util::LESIONES[$i] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en los brazos:</label><br>
                            <select name="lesionBrazos" class="form-control custom-select">
                                <?php
                                    for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                        echo "<option";
                                        if ($socio->getLesionBrazos() == $i) {
                                            echo " selected=\"" . "true" . "\"";
                                        }
                                        echo " value = ". $i . ">"
                                            . Util::LESIONES[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en la espalda:</label><br>
                            <select name="lesionEspalda" class="form-control custom-select">
                                <?php
                                    for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                        echo "<option";
                                        if ($socio->getLesionEspalda() == $i) {
                                            echo " selected=\"" . "true" . "\"";
                                        }
                                        echo " value = ". $i . ">"
                                            . Util::LESIONES[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en el hombro:</label><br>
                            <select name="lesionHombro" class="form-control custom-select">
                                <?php
                                    for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                        echo "<option";
                                        if ($socio->getLesionHombro() == $i) {
                                            echo " selected=\"" . "true" . "\"";
                                        }
                                        echo " value = ". $i . ">"
                                            . Util::LESIONES[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en el pecho:</label><br>
                            <select name="lesionPecho" class="form-control custom-select">
                                <?php
                                    for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                        echo "<option";
                                        if ($socio->getLesionPecho() == $i) {
                                            echo " selected=\"" . "true" . "\"";
                                        }
                                        echo " value = ". $i . ">"
                                            . Util::LESIONES[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en las piernas:</label><br>
                            <select name="lesionPiernas" class="form-control custom-select">
                                <?php
                                    for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                        echo "<option";
                                        if ($socio->getLesionPiernas() == $i) {
                                            echo " selected=\"" . "true" . "\"";
                                        }
                                        echo " value = ". $i . ">"
                                            . Util::LESIONES[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Sexo:</label><br>
                            <select name="idSexo" class="form-control custom-select">
                                <?php
                                    for ($i = 0; $i < count(Util::SEXOS); $i++) {
                                        echo "<option";
                                        if ($socio->getIdSexo() - 1 == $i) {
                                            echo " selected=\"" . "true" . "\"";
                                        }
                                        echo " value = ". ($i + 1) . ">"
                                            . Util::SEXOS[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="txtCorreo" class="control-label">Correo electrónico:</label>
                            <input id="txtCorreo" type="email" class="form-control" name="txtCorreo"
                                value="<?php echo $socio->getCorreo(); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Fecha de nacimiento:</label><br>
                            <input type="date" class="form-control" name="fechaNacimiento"
                                value="<?php echo $socio->getFechaNacimiento(); ?>"> 
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <input type="submit" name="aceptar" value="Aceptar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->


        <?php
        if (isset($_POST['aceptar'])) {
            $socio->setNombrePila($_POST['txtNombre']);
            $socio->setApellido1($_POST['txtApellido1']);
            $socio->setApellido2($_POST['txtApellido2']);
            $socio->setIdSexo($_POST['idSexo']);
            $socio->setFechaNacimiento($_POST['fechaNacimiento']);
            $socio->setPeso($_POST['peso']);
            $socio->setEstatura($_POST['estatura']);
            $socio->setLesionAbdomen($_POST['lesionAbdomen']);
            $socio->setLesionBrazos($_POST['lesionBrazos']);
            $socio->setLesionEspalda($_POST['lesionEspalda']);
            $socio->setLesionHombro($_POST['lesionHombro']);
            $socio->setLesionPecho($_POST['lesionPecho']);
            $socio->setLesionPiernas($_POST['lesionPiernas']);
            $correo = $_POST['txtCorreo'];
            if (strcmp($correo, $socio->getCorreo()) != 0) {
                if (!$adminSocios->existeCorreo($correo)) {
                    $socio->setCorreo($correo);
                } else {
                    ?>
                    <script type="text/javascript">
                        alert('Error, ya existe un socio con ese correo.');
                        // window.location = "frm_buscar_socio.php";
                    </script>
                    <?php
                }
            }
            if (isset($_FILES['files'])) {
                $socio->setRutaFotografia(Util::cargarImagen($_FILES['files'], $idSocio, Util::FOTO_SOCIO));
            }
            
            if ($adminSocios->editarSocio($socio)) { 
                ?>
                <script type="text/javascript">
                    alert("Se han modificado los datos del socio.\n" +
                    "En un momento se modificará la fotografía.");
                    window.location = "frm_buscar_socio.php";
                </script>
                <?php
            }
        }
        if (isset($_POST['cancelar'])) { ?>
            <script type="text/javascript">
                if (confirm("¿Desea salir sin guardar cambios?")) {
                    window.location = "frm_buscar_socio.php";
                }
            </script>
            <?php
        }
        ?>

        <script>
            function archivo(evt) {
                var files = evt.target.files; // FileList object
                // Obtenemos la imagen del campo "file".
                for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
                    var reader = new FileReader();
                    reader.onload = (function() {
                        return function(e) {
                            // Insertamos la imagen
                            document.getElementById("list").innerHTML = ['<div class="alert alert-info"><?php echo "La fotografía inferior es la nueva fotografía.";?></div><img class="rounded-circle" height="200" width="200" src="', e.target.result,'"/><br>'].join('');
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }
            }
            document.getElementById('files').addEventListener('change', archivo, false);
        </script>

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
    <!-- SweetAlert2 -->
    <script src="vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
</div>
<!-- /.container-fluid-->
</body>
</html>
