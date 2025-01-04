<?php

require_once(dirname(__FILE__) . '/../config/PersistentManager.php');

class UserDAO {

    const USER_TABLE = 'users';

    //Conexión a BD
    private $conn = null;

    //Constructor de la clase
    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }
    
    public function getUserInformation($user) {
        $query = "SELECT idUser, email, password, type FROM " . UserDAO::USER_TABLE . " WHERE email=? AND password=?";
        $stmt = mysqli_prepare($this->conn, $query);
        $auxEmail = $user->getEmail();
        $auxPass =  $user->getPassword();
            
        $stmt ->bind_param('ss', $auxEmail, $auxPass);
        $stmt->execute();
        $result = $stmt->get_result();
        mysqli_stmt_bind_param($stmt, 'ss', $auxEmail, $auxPass);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt); 
        $rows = mysqli_stmt_num_rows($stmt);
        if($result ->num_rows == 1){
            $dataDB = $result->fetch_row();
            $user->setIdUser($dataDB[0]);
            $user->setType($dataDB[3]);
            return $user;
        }         
        else{
            return null;
        }
    }
}
