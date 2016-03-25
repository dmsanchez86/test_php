<?php 
    // validamos si ya se inicio una session
    session_start();
    if(!isset($_SESSION['logged']))
        header('Location: /');
        
    // incluimos la clase de utilidades
    include 'lib/Utils.php';
    
    $utils = new Utils();
    
    include 'lib/Conexion.php';
        
    // creamos la instancia de la clase conexion
    $objConexion = new Conexion();
    
    // nos conectamos a la base de datos
    $con = $objConexion->conect();
?>

<?php $utils->getHeader('Dashboard - @s'); ?>


        <div class="navigator">
            <div class="container">
                <div class="user">
                    <span>
                        <?= $_SESSION['data_user']->user ?>
                        <ul class="submenu">
                        <?php 
                            if($_SESSION['data_user']->rol == "administrator"){ ?>
                                    <li>
                                        <a href="dashboard.php?option=request">Solicitudes</a>
                                    </li>
                                    <li>
                                        <a href="dashboard.php?option=payments">Pagos</a>
                                    </li>
                                    <li>
                                        <a href="dashboard.php">Usuarios</a>
                                    </li>
                            <?php }else{ ?>
                                    <li>
                                        <a href="dashboard.php">Perfil</a>
                                    </li>
                                    <li>
                                        <a href="dashboard.php?option=my_loans">Mis Prestamos</a>
                                    </li>
                                    <li>
                                        <a href="dashboard.php?option=request_loan">Solicitar Prestamo</a>
                                    </li>
                                    <li>
                                        <a href="dashboard.php?option=pay">Abonar</a>
                                    </li>
                            <?php } 
                        ?>
                        </ul>
                    </span>
                </div>
                <div class="logout">
                    <a href="logout.php">Salir</a>
                </div>
            </div>
        </div>
        <div class="dashboard">
            <div class="container">
                <h1 class="title">Bienvenido <?= $_SESSION['data_user']->user ?></h1>
                <?php 
                // si es un administrador mostramos el panel de todos los usuarios
                if($_SESSION['data_user']->rol == "administrator"){
                    if(!isset($_GET['option'])){
                        $utils->listUsers($objConexion);
                    }else{
                        echo $_GET['option'];
                    }
                }else{  // si no es un usuario normal y mostramos los datos del perfil
                    if(!isset($_GET['option'])){
                        $utils->profile($objConexion);
                    }else{
                        if($_GET['option'] == "request_loan"){
                            $utils->getRequest($objConexion);
                        }else if($_GET['option'] == "my_loans"){
                            $utils->getRequestUser($objConexion);
                        }
                    } ?>
                <?php }
                ?>
            </div>
        </div>


<?php $utils->getFooter(); ?>