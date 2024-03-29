<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <link rel="shortcut icon" href="img/logo.png">
  <meta name="author" content="Fernando Illan">
  <title>Iniciar Sesión</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Iniciar Sesión</div>
      <div class="card-body">
        <form method="post" action="validar_sesion.php">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 1) {
                    $error = 'Correo electrónico o contraseña incorrecta';
                } elseif ($_GET['error'] == 2) {
                    $error = 'Primeramente debe iniciar sesión para ver el contenido';
                }?>
                <div class="alert alert-danger alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>¡Error!</strong> <?php echo $error; ?>
                </div>
                <?php
            }
            ?>
          <div class="form-group">
            <label for="CorreoElectronico">Correo Electróncio</label>
            <input class="form-control" name="correoElectronico" type="email"
                   aria-describedby="emailHelp"
                   placeholder="Correo Electróncio">
          </div>
          <div class="form-group">
            <label for="clave">Contraseña</label>
            <input class="form-control" name="clave" type="password"
                   placeholder="Contraseña">
          </div>
            <!-- Recordar Password -.->
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
            <!-- /Recordar Password -->
            <div class="form-group">
                <input class="form-control btn btn-primary btn-block"  type="submit" value="Iniciar Sesión">
            </div>
        </form>
        <div class="text-center">
          <a class="d-block small" href="forgot-password.php">¿Olvidaste la contraseña?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
