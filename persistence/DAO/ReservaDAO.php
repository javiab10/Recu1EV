<?php
//dirname(__FILE__) Es el directorio del archivo actual
require_once(dirname(__FILE__) . '/../config/PersistentManager.php');

class ReservaDAO {
    const RESERVE_TABLE = 'reserve';
    
    private $conn = null;
    
    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }
    
    public function reserve($reserve){
        $query = "INSERT INTO " . self::RESERVE_TABLE. 
                " (id_restaurant, date, persons, IP) VALUES(?,?,?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        $id_restaurant = $reserve->getId_restaurant();
        $date = $reserve->getDate();
        $persons = $reserve->getPersons();
        $IP = $reserve->getIP();
                
        mysqli_stmt_bind_param($stmt, "isis", $id_restaurant, $date, $persons, $IP);
        return $stmt->execute();        
    }
}
