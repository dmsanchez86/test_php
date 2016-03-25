<?php

include 'Conexion.php';

$con = new Conexion();

$con->conect();

if(isset($_POST['key'])){
    $res = $con->deleteUser($_POST['key']);
    
    echo $res;
}