<?php 

class Utils{
    
    // funcion que me imprime la cabecera de la pagina
    public function getHeader($title){
        include 'assets/header.php';
    }
    
    // funcion que me imprime el pie de pagina
    public function getFooter(){
        include 'assets/footer.php';
    }
    
    // funcion que me muestra todos los usuarios
    public function listUsers($objConexion){ ?>
        <div class="content_users">
            <table>
                <thead>
                    <tr>
                        <th colspan="3">
                            Listado de Usuarios
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Usuario
                        </th>
                        <th>
                            Rol
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $dataUsers = $objConexion->getUSers();
                        
                        foreach($dataUsers as $key){ 
                            if($key['user'] != $_SESSION['data_user']->user ){ ?>
                            <tr>
                                <td>
                                    <?= $key['user'] ?>
                                </td>
                                <td>
                                    <?= ($key['rol'] == "administrator") ? "Administrador" : "Usuario" ?>
                                </td>
                                <td>
                                    <a href="#" data-key="<?= $key['user'] ?>" class="delete_user">
                                        Eliminar
                                    </a>
                                </td>
                            </tr> 
                        <?php }
                        } ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    // funcion que me muestra los datos del perfil
    public function profile($objConexion){ ?>
        <div class="data_user">
            <h1 class="title">Información</h1>
            <?php 
                // obtenemos la informacion del usuario
                $result = $objConexion->dataUser($_SESSION['data_user']->user);
                $dataUser = array();
                
                foreach($result as $key){
                    $dataUser['id'] = $key['id'];
                    $dataUser['name'] = $key['fullname'];
                    $dataUser['email'] = $key['email'];
                    $dataUser['gender'] = $key['gender'];
                }
            ?>
            <form action="" method="POST">
                <div class="input-content <?= ($dataUser['id'] != NULL) ? "with-data" : "" ?>">
                    <input type="text" name="id" id="nameUser" value="<?= $dataUser['id'] ?>" required>
                    <label for="nameUser">Identificación</label>
                </div>
                <div class="input-content <?= ($dataUser['name'] != NULL) ? "with-data" : "" ?>">
                    <input type="text" name="fullname" id="fullnameUser" value="<?= $dataUser['name'] ?>" required>
                    <label for="fullnameUser">Nombre Completo</label>
                </div>
                <div class="input-content <?= ($dataUser['email'] != NULL) ? "with-data" : "" ?>">
                    <input type="email" name="email" id="emailUSer" value="<?= $dataUser['email'] ?>" required>
                    <label for="emailUSer">Correo Electrónico</label>
                </div>
                <div class="input-content with-data">
                    <select name="gender" id="genderUser" required>
                        <option value="">---------</option>
                        <option value="Male" <?= ($dataUser['gender'] == "Male") ? "selected": "" ?>>Masculino</option>
                        <option value="Female" <?= ($dataUser['gender'] == "Female") ? "selected": "" ?>>Femenino</option>
                    </select>
                    <label for="genderUser">Género</label>
                </div>
                <div class="container_btn">
                    <button type="submit" name="updateProfile">Actualizar</button>
                </div>
                <div class="response">
                    <?php
                    
                    if(isset($_POST['updateProfile'])){
                        
                        // validamos
                        $result = $objConexion->updateUser(
                            $_POST['id'],
                            $_POST['fullname'],
                            $_POST['email'],
                            $_POST['gender'],
                            $_SESSION['data_user']->user
                        );
                        
                        // si la actualizacion se hizo correctamente
                        if($result > 0){
                            // mostramos el mensaje de la actualizacion
                            header("Location: dashboard.php?update=ok"); // redireccionamos
                        }else{
                            // mostramos el mensaje de error
                            echo "<span class='error' title='Verifica tu conexión a internet'>Ocurrio un error</span>";
                        }
                    }

                    // si el registro es exitoso mostramos el mensaje
                    if($_GET['update'] == "ok")
                        echo "<span class='success'>
                        ¡Actualización Exitosa!</span>";
                    ?>
                </div>
            </form>
        </div>
        <?php
    }
    
    // funcion que me muestra para solicitar un prestamo
    function getRequest($objConexion){ ?>
        <div class="request_loan">
            <h1 class="title">Solicitar Prestamo</h1>
            <form action="" method="POST">
                <div class="input-content">
                    <input type="number" min="50000" max="10000000" name="amount" id="amount" required>
                    <label for="amount">Presupuesto</label>
                </div>
                <div class="input-content with-data">
                    <select name="dues" id="dues" required>
                        <option value="">---------</option>
                        <option value="1">1 Mes</option>
                        <option value="3">3 Meses</option>
                        <option value="5">5 Meses</option>
                        <option value="6">6 Meses</option>
                        <option value="12">1 año</option>
                        <option value="18">1 año y medio</option>
                        <option value="24">2 años</option>
                        <option value="36">3 años</option>
                    </select>
                    <label for="dues">Cuotas</label>
                </div>
                <div class="container_btn">
                    <button type="submit" name="requestLoan">Solicitar Prestamo</button>
                </div>
                <div class="response">
                <?php 
                    
                    // si solicito un prestamo
                    if(isset($_POST['requestLoan'])){
                        $result = $objConexion->requestLoan(
                            $_SESSION['data_user']->user,
                            $_POST['amount'],
                            $_POST['dues']
                        );
                        
                        // si la actualizacion se hizo correctamente
                        if($result > 0){
                            // mostramos el mensaje de la actualizacion
                            header("Location: dashboard.php?option=request_loan&request=ok"); // redireccionamos
                        }else{
                            // mostramos el mensaje de error
                            echo "<span class='error' title='Verifica tu conexión a internet'>Ocurrio un error</span>";
                        }
                    }
                    
                    // si el registro es exitoso mostramos el mensaje
                    if($_GET['request'] == "ok")
                        echo "<span class='success'>
                        ¡Solicitud Exitosa!</span>";
                ?>
                </div>
            </form>
        </div>
        <?php
    }
    
    // funcion que me muestra las solicitudes de prestamos
    function getRequestUser($objConexion){ ?>
        
        <?php
    }
    
}