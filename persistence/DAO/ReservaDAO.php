<?php
//dirname(__FILE__) Es el directorio del archivo actual
require_once(dirname(__FILE__) . '/../config/PersistentManager.php');

class ReservaDAO {
    const BOOK_TABLE = 'book';
    
    private $conn = null;
    
    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }
    
    public function book($book){
        $query = "INSERT INTO " . self::BOOK_TABLE. 
                " (id_restaurant, date, persons, IP) VALUES(?,?,?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        $id_restaurant = $book->getId_restaurant();
        $date = $book->getDate();
        $persons = $book->getPersons();
        $IP = $book->getIP();
                
        mysqli_stmt_bind_param($stmt, "isis", $id_restaurant, $date, $persons, $IP);
        return $stmt->execute();        
    }
}
