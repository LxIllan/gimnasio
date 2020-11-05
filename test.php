<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Nuevo Producto">
    <link rel="shortcut icon" href="img/logo.png">
    <meta name="author" content="Fernando Illan">
    <title>Picología IO</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

    <!-- content-wrapper-->
    <div class="content-wrapper">

    <!-- container-fluid-->
    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Psicología IO</a>
            </li>
            <li class="breadcrumb-item active">Nuevo comentario</li>
        </ol>
        <!-- /.Breadcrumbs-->

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <h1 class="modal-header">
                    Nuevo comentario
                </h1>
            </div>
        </div>
        <!-- /.Page Header -->


        <!-- row -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form class="form-control" action="" method="post" enctype="multipart/form-data">                    
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label class="control-label">Respuesta:</label><br>
                            <textarea name="comentario" class="form-control"></textarea>
                        </div>                        
                    </div>
                    <div class="form-row">                        
                        <div class="form-group col-md-6">
                            <label class="control-label">Pregunta:</label><br>
                            <input type="text" class="form-control" name="para">
                        </div>
                    </div>
                    <br>
                    <div class="text-center">  
                        <input type="submit" name="submit"
                           value="Aceptar" class="btn btn-primary ">
                    </div>                    
                </form>
                <br>
            </div>
        </div>
        <!-- /.row -->
    

        <?php
        if (isset($_POST['submit'])) {
            require_once 'ChatBot.php';
            $chatbot = new ChatBot();
            $chatbot->procesarPregunta('hola');
        }
        ?>


    </div>
    <!-- /.container-fluid-->


    <!-- footer -->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small><?php echo DAO::STR_FOOTER; ?></small>
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