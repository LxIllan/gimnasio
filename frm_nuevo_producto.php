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
            <li class="breadcrumb-item active">Nuevo Producto</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Nuevo Producto
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $adminTiposProducto = new AdminTiposProducto();
        $tiposProducto = $adminTiposProducto->listarTiposProducto();
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">
                    <div class="alert alert-ligth alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Tip:</strong> Para fijar un precio con centavos use un
                            punto. Ejemplo: 13.5
                    </div>
                    <div class="alert alert-ligth alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <strong>Tip:</strong> El campo de contenido/Descripción puede quedar vacío.
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
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre:</label><br>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtContenido">Contenido/Descripción:</label><br>
                            <input type="text" class="form-control" name="contenido" id="txtContenido"
                                placeholder="Contenido">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="idTipoProducto">Tipo:</label><br>
                            <select name="idTipoProducto" class="form-control custom-select" id="idTipoProducto">
                                <?php
                                for ($i = 0; $i < $tiposProducto->size(); $i++) {
                                    echo "<option value = ". $tiposProducto->get($i)->getIdTipoProducto() . ">"
                                        . $tiposProducto->get($i)->getTipoProducto() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtNumPiezas">Piezas:</label><br>
                            <input type="number" class="form-control" name="numPiezas" id="txtNumPiezas"
                                value="1" min="1" step="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtPrecio">Precio:</label><br>
                            <input type="number" class="form-control" name="precio" id="txtPrecio"
                                value="1" min="1" step="any" required>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">  
                        <input align="center" type="submit" name="submit"
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
        $adminProductos = new AdminProductos();
        $nombre = $_REQUEST['nombre'];
        $precio = $_REQUEST['precio'];
        $idProducto = $adminProductos->getSiguienteId();
        $rutaFotografia = Util::cargarImagen((isset($_FILES['foto'])) ? $_FILES['foto'] : null, $idProducto, Util::FOTO_PRODUCTO);
        if (strlen($_REQUEST['contenido']) == 0) {
            $contenido = Util::$strNull;
        } else {
            $contenido = $_REQUEST['contenido'];
        }
        $numPiezas = $_REQUEST['numPiezas'];
        $idTipoProducto = $_REQUEST['idTipoProducto'];
        if ($adminProductos->agregarProducto($nombre, $rutaFotografia, $precio, $contenido, $numPiezas, $idTipoProducto)) {
            ?>
            <script type="text/javascript">
                alert("El producto se registró correctamente.");
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
</div>
<!-- /.content-wrapper-->
</body>
</html>
