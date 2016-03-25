<?php
    // incluimos la clase de utilidades
    include 'lib/Utils.php';
    
    $utils = new Utils();

    session_start();
    if(isset($_SESSION['logged']))
        header("Location: dashboard.php");

    if(isset($_POST)){
        include 'lib/Conexion.php';
        
        // creamos la instancia de la clase conexion
        $objConexion = new Conexion();
        
        // nos conectamos a la base de datos
        $con = $objConexion->conect();
    }
?>
<?php $utils->getHeader('Home - @s'); ?>
        <div class="main">
            <div class="forms_content <?= (isset($_POST['register']) && !isset($_GET['register'])) ? "register": "" ?>">
                <div class="login_content">
                    <h1>Iniciar Sesión</h1>
                    <form method="POST">
                        <div class="input-content <?= (isset($_REQUEST['user']) ? "with-data": "") ?>">
                            <input type="text" name="user" id="user" value="<?= $_REQUEST['user'] ?>" required>
                            <label for="user">Usuario</label>
                        </div>
                        <div class="input-content">
                            <input type="password" name="password" id="password" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="container_btn">
                            <button type="submit" name="enter">Entrar</button>
                            <button type="button" id="btn_register">Registrarse</button>
                        </div>
                        <div class="response">
                            <?php 
                            if(isset($_POST['enter'])){
                                // validamos
                                $result = $objConexion->validateUser($_POST['user'], $_POST['password']);
                                
                                // si los datos estan en la base de datos
                                if($result->num_rows > 0){
                                    $data = $result->fetch_object();
                                    
                                    // inicio la sesion
                                    session_start();
                                    
                                    // guardamos la informacion del usuario
                                    $_SESSION['logged'] = true;
                                    $_SESSION['data_user'] = $data;
                                    
                                    header("Location: dashboard.php"); // redireccionamos
                                }else{
                                    // mostramos el mensaje de error
                                    echo "<span class='error'>datos incorrectos</span>";
                                }
                            }

                            // si el registro es exitoso mostramos el mensaje
                            if($_GET['register'] == "ok")
                                echo "<span class='success'>Registro Exitoso!</span>";
                            ?>
                        </div>
                    </form>
                </div>
                <div class="register_content">
                    <h1>Registro</h1>
                    <form method="POST">
                        <div class="input-content">
                            <input type="text" name="user" id="user_register" required>
                            <label for="user_register">Usuario</label>
                        </div>
                        <div class="input-content">
                            <input type="password" name="password" id="password_register" required>
                            <label for="password_register">Contraseña</label>
                        </div>
                        <div class="input-content">
                            <input type="password" name="password_confirm" id="password_register_conf" required>
                            <label for="password_register_conf">Confirmar Contraseña</label>
                        </div>
                        <div class="container_btn">
                            <button type="submit" name="register">Registrarse</button>
                            <button type="button" id="btn_login">Iniciar Sesión</button>
                        </div>
                        <div class="response">
                            <?php 
                            if(isset($_POST['register'])){
                                // miramos si la contraseña es igual a la otra
                                if($_POST['password'] === $_POST['password_confirm']){
                                    
                                    // validamos
                                    $result = $objConexion->registerUser($_POST['user'], $_POST['password']);
                                    
                                    var_dump($result);
                                    
                                    // si el registro es exitoso
                                    if($result > 0){
                                        header("Location: /?register=ok&user=".$_POST['user']); // redireccionamos
                                    }else{
                                        // mostramos el mensaje de error
                                        echo "<span class='error'>Ocurrio un error</span>";
                                    }
                                }else{
                                    echo "<span class='error'>Las contraseñas no son iguales</span>";
                                }
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php $utils->getFooter(); ?>