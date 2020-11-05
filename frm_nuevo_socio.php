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
require_once 'AdminMembresias.php';
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
            <li class="breadcrumb-item active">Nuevo Socio</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">Nuevo Socio</h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $adminMembresias = new AdminMembresias();
        $membresias = $adminMembresias->listarMembresias();
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <div class="alert alert-ligth alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Tip:</strong> Para fijar decimales en el peso y estatura use un
                            punto. Ejemplo: 77.5
                    </div>
                    <label class="control-label">Foto:</label><br>
                    <div class="text-center">
                        <output id="list"></output>
                        <br>
                        <br>
                    </div>
                    <div class="text-center">
                        <input class="btn-info" accept=".jpg" type="file" id="foto" name="foto">
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="nombrePila">Nombre: </label>
                            <input type="text" class="form-control" name="nombrePila" id="nombrePila" placeholder="Nombre" required pattern="[a-zA-Z\s]*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido1">Primer apellido:</label>
                            <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Apellido" required pattern="[a-zA-Z\s]*">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apellido2">Segundo apellido:</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Apellido" pattern="[a-zA-Z\s]*">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Fecha de nacimiento:</label><br>
                            <input type="date" class="form-control" name="fechaNacimiento"
                                value="<?php echo date('Y-m-d'); ?>">    
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Sexo:</label><br>
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
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Peso (Kg):</label><br>
                            <input type="number" class="form-control" name="peso" 
                            value="50" min="1" step="any" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Estatura (Metros):</label>
                            <input type="number" class="form-control" name="estatura" 
                                value="1.65" min="1" step="any" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Lesión en el abdomen:</label><br>
                            <select name="lesionAbdomen" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < count(Util::LESIONES); $i++) {
                                    echo "<option value = ". $i .">"
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
                                    echo "<option value = ". $i .">"
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
                                    echo "<option value = ". $i .">"
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
                                    echo "<option value = ". $i .">"
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
                                    echo "<option value = ". $i .">"
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
                                    echo "<option value = ". $i .">"
                                        . Util::LESIONES[$i] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Tiempo entrenando (meses):</label><br>
                            <input type="number" class="form-control" name="diasEntrenando" 
                                value="1" min="0" step="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label">Correo electrónico:</label><br>
                            <input type="email" class="form-control" name="correo" placeholder="ejemplo@ejemplo.com">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="idMembresia">Membresía:</label><br>
                            <select name="idMembresia" class="form-control custom-select">
                                <?php
                                for ($i = 0; $i < $membresias->size(); $i++) {
                                    echo "<option value = ". $membresias->get($i)->getIdMembresia() .">"
                                        . $membresias->get($i)->getMembresia() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <input align="center" type="submit" name="aceptar" value="Aceptar"
                                   class="btn btn-primary">
                    </div>
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

    <?php
    if (isset($_POST['aceptar'])) {
        $adminSocios = new AdminSocios();
        $idSocio = $adminSocios->getSiguienteId();
        $nombrePila = $_REQUEST['nombrePila'];
        $apellido1 = $_REQUEST['apellido1'];
        $apellido2 = $_REQUEST['apellido2'];
        $fechaNacimiento = $_REQUEST['fechaNacimiento'];
        $idSexo = $_REQUEST['idSexo'];
        $peso = $_REQUEST['peso'];
        $estatura = $_REQUEST['estatura'];
        $lesionAbdomen = $_REQUEST['lesionAbdomen'];
        $lesionBrazos = $_REQUEST['lesionBrazos'];
        $lesionEspalda = $_REQUEST['lesionEspalda'];
        $lesionHombro = $_REQUEST['lesionHombro'];
        $lesionPecho = $_REQUEST['lesionPecho'];
        $lesionPiernas = $_REQUEST['lesionPiernas'];
        $diasEntrenando = ($_REQUEST['diasEntrenando'] * 30) + 1;
        $correo = $_REQUEST['correo'];
        $rutaFotografia = Util::cargarImagen((isset($_FILES['foto'])) ? $_FILES['foto'] : null, $idSocio, Util::FOTO_SOCIO);
        $idMembresia = $_REQUEST['idMembresia'];
        $idRecepcionista = $_SESSION['usuario']['idusuario'];
        $idGimnasio = $_SESSION['usuario']['gimnasio'];
        if (!$adminSocios->existeCorreo($correo)) {
            if ($adminSocios->agregarSocio($nombrePila,  $apellido1,  $apellido2, $fechaNacimiento,
                $idSexo, $peso, $estatura, $lesionAbdomen, $lesionBrazos, $lesionEspalda, $lesionHombro,
                $lesionPecho, $lesionPiernas, $correo,  $rutaFotografia, $diasEntrenando, $idMembresia, $idGimnasio, $idRecepcionista)) {
                ?>
                    <script type="text/javascript">
                        alert('Se ha registrado el socio correctamente.');
                        window.location = "index.php";
                    </script>
                <?php
            }
        } else {
            ?>
                <script type="text/javascript">
                    alert('Error, ya existe un socio con ese correo.');
                    window.location = "frm_nuevo_socio.php";
                </script>
            <?php
        }
        
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
                        document.getElementById("list").innerHTML = ['<img class="rounded-circle" height="200" width="200" src="', e.target.result,'"/><br>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('foto').addEventListener('change', archivo, false);
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
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
</div>
<!-- /.container-fluid-->
</body>
</html>
