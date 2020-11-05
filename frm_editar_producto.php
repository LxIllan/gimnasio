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
    <meta name="description" content="Editar Producto">
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
            <li class="breadcrumb-item">
                <a href="frm_buscar_producto.php">Buscar Producto</a>
            </li>
            <li class="breadcrumb-item active">Editar Producto</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Editar Producto
                </h1>
           </div>
        </div>
        <!-- /.Page Header -->

        <?php
        $idProducto = $_GET['id'];
        $adminTiposProducto = new AdminTiposProducto();
        $adminProductos = new AdminProductos();
        $tiposProducto = $adminTiposProducto->listarTiposProducto();
        $producto = $adminProductos->consultarProducto($idProducto);
        ?>

        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="" class="form-control" method="post" enctype="multipart/form-data">
                    <div class="alert text-center alert-ligth alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Tip:</strong> Para fijar un precio con centavos use una punto. Ejemplo: 13.5
                    </div>
                    <div class="alert text-center alert-ligth alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Tip:</strong> El campo de contenido puede quedar vacío.
                    </div>
                    <div class="text-center">
                        <img class="rounded-circle" height="200" width="200"
                             src="<?php echo $producto->getRutaFotografia(); ?>"/>
                        <br>
                        <br>
                        <output id="list"></output>
                        <br>
                        <input type="file" accept=".jpg" class="btn-info" id="files" name="files">    
                        <br>
                        <br>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtNombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="txtNombre"
                                value="<?php echo $producto->getNombre(); ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Contenido:</label>
                            <input type="text" class="form-control" name="contenido" placeholder="Contenido"
                                value="<?php  if($producto->getContenido() == Util::$strNull) {
                                    echo "";
                                } else {
                                    echo $producto->getContenido();
                                } ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtNumPiezas">Piezas:</label>
                            <input type="number" class="form-control" name="numPiezas" id="txtNumPiezas"
                                min="1" step="1"
                                value="<?php echo $producto->getNumPiezas(); ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="txtPrecio">Precio:</label>
                            <input type="number" class="form-control" name="precio" id="txtPrecio" min="1"
                                value="<?php echo $producto->getPrecio(); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="control-label" for="idTipoProducto">Tipo:</label>
                            <select class="form-control custom-select" name="idTipoProducto" id="idTipoProducto"
                                    required>
                                <?php
                                for ($i = 0; $i < $tiposProducto->size(); $i++) {
                                    echo "<option";
                                    if ($producto->getIdTipoProducto() == $i + 1) {
                                        echo " selected=\"" . "true" . "\"";
                                    }
                                    echo " value = ". $tiposProducto->get($i)->getIdTipoProducto() . ">"
                                        . $tiposProducto->get($i)->getTipoProducto() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="aceptar"
                           value="Aceptar" class="btn btn-primary">
                    </div>
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid-->

    <?php
    if (isset($_POST['aceptar'])) {
        $producto->setNombre($_POST['nombre']);
        $producto->setPrecio($_POST['precio']);
        $producto->setIdTipoProducto($_POST['idTipoProducto']);
        if (strlen($_POST['contenido']) == 0) {
            $producto->setContenido(Util::$strNull);
        } else {
            $producto->setContenido($_POST['contenido']);
        }
        if (isset($_FILES['files'])) {
            $producto->setRutaFotografia(Util::cargarImagen($_FILES['files'], $idProducto, Util::FOTO_PRODUCTO));
        }
        $idTipoProducto = $_POST['idTipoProducto'];
        if ($adminProductos->editarProducto($producto)) {
            ?>
            <script type="text/javascript">
                alert("Se modificó producto.");
                window.location = "frm_buscar_producto.php";
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
                        document.getElementById("list").innerHTML = ['<div class="alert alert-info"><?php echo "La fotografía inferior es la nueva fotografía.";?></div><img class="rounded-circle" height="200" width="200" src="', e.target.result,'"/><br>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('files').addEventListener('change', archivo, false);
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
