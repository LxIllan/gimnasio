<?php
    require_once 'Usuario.php';    
?>
<!-- Chatbot -->
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/464612/nlp_compromise.min.js'></script>  
<script src="js/chatbot.js"></script>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php"><i class="fa fa-fw fa-home"></i> Gimnasio</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            <!-- Socios -->
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseSocios"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-users"></i>
                    <span class="nav-link-text">Socios</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseSocios">
                    <li>
                        <a href="frm_nuevo_socio.php">
                            <i class="fa fa-fw fa-user-plus"></i>
                            <span class="nav-link-text">Nuevo</span>

                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="frm_buscar_socio.php">
                            <i class="fa fa-fw fa-search"></i>
                            <span class="nav-link-text">Buscar</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="frm_socios_ocultos.php">
                            <i class="fa fa-fw fa-eye-slash"></i>
                            <span class="nav-link-text">Ocultos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- /Socios -->

            <!-- Productos -->
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseProductos"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-shopping-cart"></i>
                    <span class="nav-link-text">Productos</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseProductos">
                    <li>
                        <?php 
                            if ($_SESSION['usuario']['root']) {
                                ?>
                                    <a href="frm_nuevo_producto.php">
                                        <i class="fa fa-fw fa-plus-circle"></i>
                                        <span class="nav-link-text">Nuevo</span>
                                    </a>
                                <?php
                            }
                        ?>
                    </li>
                    <li>
                        <a class="nav-link" href="frm_buscar_producto.php">
                            <i class="fa fa-fw fa-search-plus"></i>
                            <span class="nav-link-text">Buscar</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- /Productos -->

            <?php
                if ($_SESSION['usuario']['root']) {
                    ?>
                    <!-- Control Financiero -->
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                            href="#collapseControlFinanciero"
                            data-parent="#exampleAccordion">
                                <i class="fa fa-fw fa-money"></i>
                                <span class="nav-link-text">Control Financiero</span>
                            </a>
                            <ul class="sidenav-second-level collapse" id="collapseControlFinanciero">
                                <li>
                                    <a href="frm_ingreso_neto.php">
                                        <i class="fa fa-fw fa-percent"></i>
                                        <span class="nav-link-text">Ingreso Neto</span>

                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="frm_retirar_efectivo.php">
                                        <i class="fa fa-fw fa-usd"></i>
                                        <span class="nav-link-text">Retirar Efectivo</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="frm_historial_de_retiros.php">
                                        <i class="fa fa-fw fa-list-alt"></i>
                                        <span class="nav-link-text">Historial de Retiros</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <!-- /Control Financiero -->
                    <?php
                }
            ?>            

            <?php
            if ($_SESSION['usuario']['root']) {
                ?>
            <!-- Estadisticas -->
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                   href="#collapseEstadisiticas"
                   data-parent="#exampleAccordion">
                    <i class="fa fa-fw fa-bar-chart"></i>
                    <span class="nav-link-text">Estadísticas</span>
                </a>
            <ul class="sidenav-second-level collapse" id="collapseEstadisiticas">
                    <li>
                        <a class="nav-link" href="frm_estadisticas_membresías.php">
                            <i class="fa fa-fw fa-calendar"></i>
                            <span class="nav-link-text">Membresías</span>
                        </a>
                    </li>
                    <li>
                        <a href="frm_estadisticas_productos.php">
                            <i class="fa fa-fw fa-shopping-cart"></i>
                            <span class="nav-link-text">Productos</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- /Estadisticas -->
            <?php
                }
            ?>            

            <?php
                if ($_SESSION['usuario']['root']) {
                    ?>
                    <!-- Configuracion -->
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse"
                        href="#collapseConfiguracion" data-parent="#exampleAccordion">
                            <i class="fa fa-fw fa-gear"></i>
                            <span class="nav-link-text">Configuración</span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="collapseConfiguracion">
                            <li>
                                <a class="nav-link-collapse collapsed" data-toggle="collapse"
                                href="#collapseRecepcionistas">
                                    <i class="fa fa-fw fa-users"></i>
                                    Recepcionistas
                                </a>
                                <ul class="sidenav-third-level collapse" id="collapseRecepcionistas">
                                    <li>
                                        <a href="frm_nuevo_recepcionista.php">
                                            <i class="fa fa-fw fa-user-plus"></i>
                                            <span class="nav-link-text">Nuevo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="frm_buscar_recepcionista.php">
                                            <i class="fa fa-fw fa-search"></i>
                                            <span class="nav-link-text">Buscar</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-link-collapse collapsed" data-toggle="collapse"
                                href="#collapseEjercicios">
                                    <i class="fa fa-fw fa-universal-access"></i>
                                    Ejercicios
                                </a>
                                <ul class="sidenav-third-level collapse" id="collapseEjercicios">
                                    <li>
                                        <a href="frm_nuevo_ejercicio.php">
                                            <i class="fa fa-fw fa-plus-circle"></i>
                                            <span class="nav-link-text">Nuevo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="frm_buscar_ejercicio.php">
                                            <i class="fa fa-fw fa-search"></i>
                                            <span class="nav-link-text">Buscar</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="frm_editar_membresias.php">
                                    <i class="fa fa-fw fa-shopping-cart"></i>
                                    <span class="nav-link-text">Editar Membresías</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- /Configuracion -->
                    <?php
                }
            ?>            
        </ul>

        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- Mensajes -.->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-envelope"></i>
                    <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
                    <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">New Messages:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>David Miller</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>Jane Smith</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <strong>John Doe</strong>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">View all messages</a>
                </div>
            </li>
            <!-- /Mensajes -->


            <!-- Notificaciones -.->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
                    <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">New Alerts:</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
                        <span class="small float-right text-muted">11:21 AM</span>
                        <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item small" href="#">View all alerts</a>
                </div>
            </li>
            <!-- /Notificaciones -->

            <!-- Busqueda -->
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0 mr-lg-2">
                    <div class="input-group">
                        <input class="form-control" type="number" placeholder="Search for...">
                        <span class="input-group-btn">                        
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </li>
            <!-- /Busqueda -->

            <li class="dropdown nav-item">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <?php
                        $nombreCompleto = $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido'];
                        echo $nombreCompleto;
                        if ($_SESSION['usuario']['root'] == Usuario::ROOT) {
                            echo ' #';
                        } else {
                            echo '  ';
                        }
                    ?>
                </a>

                <ul class="dropdown-menu">
                    <li class="dropdown-item">
                        <div class="dropdown-message">
                            <a class="dropdown-item" href="frm_perfil.php">
                                <i class="fa fa-user fa-fw"></i>
                                Perfil
                            </a>
                        </div>
                    </li>
                    <!-- Inbox -.->
                    <li class="dropdown-item">
                        <a <a class="dropdown-item" href="javascript:;"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                    </li>
                    <!-- /Inbox -->

                    <?php
                    if ($_SESSION['usuario']['root'] != Usuario::ROOT) {
                        ?>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item">
                            <div class="dropdown-message">
                                <a class="dropdown-item" href="frm_iniciar_sesion.php">
                                    <i class="fa fa-fw fa-sign-in"></i>
                                    Iniciar
                                </a>
                            </div>
                        </li>
                        <?php
                    }
                    ?>

                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a class="dropdown-item" data-toggle="modal" data-target="#chatbot">
                            <i class="fa fa-fw fa-android"></i>
                            ChatBot
                        </a>
                    </li>                    
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a class="dropdown-item" data-toggle="modal" data-target="#cerrarSesionModal">
                            <i class="fa fa-fw fa-power-off"></i>
                            Salir
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- Navigation-->


<!-- Logout Modal-->
<div class="modal fade" id="cerrarSesionModal" tabindex="-1" role="dialog"
     aria-labelledby="cerrarSesionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerrarSesionModalLabel">
                    ¿Desea salir?
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php 
                if ($_SESSION['usuario']['root'] == Usuario::ROOT) {
                    echo "Seleccione 'Salir' para salir del sistema, o<br>";
                }
                ?>
                Seleccione 'Cerrar sesión' para cerrar sesión.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-secondary" href="cerrar_sesion.php">Cerrar sesión</a>
                <?php 
                if ($_SESSION['usuario']['root'] == Usuario::ROOT) {
                    echo '<a class="btn btn-ligth" href="cerrar_sistema.php">Salir</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /Logout Modal-->

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

<!-- destruccion  -->
<?php 
if ($_SESSION['usuario']['root'] == Usuario::ROOT) { ?>
    <script>
        window.onload = function(){
            cerrarSesionAdmin();
        }
        function cerrarSesionAdmin(){
            setTimeout("window.open('cerrar_sesion.php','_top');", 900000);
        }
    </script>
    <?php
}
?>
<!-- destruccion  -->
