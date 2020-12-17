<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">CIP CD JUNÍN</span>

        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="images/cip.png" width="28"> CIP CD JUNÍN
        </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="images/usuario.png" class="user-image" alt="Usuario">
                        <span class="hidden-xs">
                            <i
                                class="fa fa-chevron-down"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu" style="border-width: 1px;border-style: solid;border-color: gray;">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="images/usuario.png" class="img-circle" alt="Usuario">

                            <p>
                                <span
                                    style="font-size: 12pt;"><?php echo $_SESSION["Nombres"] . " " . $_SESSION["Apellidos"] ?></span>
                                <small> <i><?php echo $_SESSION["Usuario"] ?> </i> </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat"> <i class="fa fa-cogs"></i> Cambiar
                                    Clave</a>
                            </div>
                            <div class="pull-right">
                                <a href="closesession.php" id="btnCloseSesion" class="btn btn-default btn-flat"> 
                                    <i class="fa fa-remove"></i> Cerrar Sesion
                                </a>
                                <!-- <form id="logout-form" action="#" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form> -->
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
<!-- <script>
let tools = new Tools();


$(document).ready(function() {

    $("#btnCloseSesion").click(function() {

        
        
        tools.AlertSuccess('Mensaje', 'Cerrando Sesión...')

        setTimeout(function() {
            location.href = "../closesession.php"
        }, 1000);
    })
})
</script> -->