<!-- Chatbot -->
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/464612/nlp_compromise.min.js'></script>  
<script  src="js/chatbot.js"></script>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="frm_socio.php"><i class="fa fa-fw fa-home"></i> Gimnasio</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            <!-- Menu -->
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseMenu"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-cogs"></i>
                    <span class="nav-link-text">Menú</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseMenu">
                    <li>
                        <a href="frm_socio_ver_rutinas.php">
                            <i class="fa fa-fw fa-universal-access"></i>
                            <span class="nav-link-text">Rutinas</span>

                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="frm_perfil_socio.php">
                            <i class="fa fa-fw fa-edit"></i>
                            <span class="nav-link-text">Editar datos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                ___<img height="200" width="200" src="img/logo.png"/>
            </li>
            <!-- /Menu -->                              
        </ul>

        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="dropdown nav-item">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <?php
                        $nombreCompleto = $_SESSION['socio']['nombre'] . ' ' . $_SESSION['socio']['apellido'];
                        echo $nombreCompleto;
                    ?>
                </a>

                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <div class="dropdown-message">
                            <a class="dropdown-item" href="frm_perfil_socio.php">
                                <i class="fa fa-user fa-fw"></i>
                                Perfil
                            </a>
                        </div>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a class="dropdown-item" data-toggle="modal" data-target="#chatbot">
                            <i class="fa fa-fw fa-android"></i>
                            ChatBot
                        </a>
                    </li>                    
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <div class="dropdown-message">
                            <a class="dropdown-item" href="cerrar_sesion_socio.php">
                                <i class="fa fa-fw fa-power-off"></i>
                                Salir
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- Navigation-->

<!-- Chatbot Modal-->
<div class="modal fade" id="chatbot" tabindex="-1" role="dialog"
     aria-labelledby="cerrarSesionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerrarSesionModalLabel">
                    ChatBot
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">                
                <div id='bodybox'>
                    <div id='chatborder'>
                        <p id="chatlog7" class="text-rigth">&nbsp;</p>
                        <p id="chatlog6" class="text-rigth">&nbsp;</p>
                        <p id="chatlog5" class="text-rigth">&nbsp;</p>
                        <p id="chatlog4" class="text-rigth">&nbsp;</p>
                        <p id="chatlog3" class="text-rigth">&nbsp;</p>
                        <p id="chatlog2" class="text-rigth">&nbsp;</p>
                        <p id="chatlog1" class="text-rigth">&nbsp;</p>
                        <input type="text" name="chat" id="chatbox" class="form-control" placeholder="¡Hola!, puedes preguntar lo que quieras.">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Chatbot Modal-->