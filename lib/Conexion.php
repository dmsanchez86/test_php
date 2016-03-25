<?php

class Conexion{
    private $mysqli;
    
    public function conect(){
        $this->mysqli = new mysqli('localhost', 'dmsanchez86','', 'prueba');
        
        if ($this->mysqli->connect_errno){
            echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        
        return $this->mysqli;
    }
    
    public function validateUser($user, $password){
        return $this->mysqli->query('SELECT * FROM user WHERE user = "'.$user.'" AND password = "'.$password.'"');
    }
    
    public function registerUser($user, $password){
        // insertamos los datos en la tabla usuario
        $this->mysqli->query('INSERT INTO user VALUES("'.$user.'","'.$password.'", "user")');
        
        // insertamos los datos en la tabla informacion del usuario
        $this->mysqli->query('INSERT INTO dataUser VALUES(0,NULL,NULL,NULL,"'.$user.'")');
        
        return $this->mysqli->affected_rows;
    }
    
    public function deleteUser($user){
        $this->mysqli->query('DELETE FROM user WHERE user = "'.$user.'"');
        
        return $this->mysqli->affected_rows;
    }
    
    public function getUsers(){
        return $this->mysqli->query('SELECT * FROM user ORDER BY rol');
    }
    
    public function updateUser($id, $fullName, $email, $gender, $user){
        $this->mysqli->query('UPDATE dataUser SET id = '.intval($id).', fullname = "'.$fullName.'", email = "'.$email.'", gender = "'.$gender.'" WHERE user = "'.$user.'"');
        
        return $this->mysqli->affected_rows;
    }
    
    public function dataUser($user){
        return $this->mysqli->query('SELECT * FROM dataUser WHERE user = "'.$user.'"');
    }
    
    public function requestLoan($user, $amount, $dues){
        // insertamos los datos en la tabla usuario
        $this->mysqli->query('INSERT INTO requests VALUES(0, "'.$user.'","'.$amount.'", "'.$dues.'", "active")');
        
        return $this->mysqli->affected_rows;
    }
}