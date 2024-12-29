<?php

//dirname(__FILE__) Es el directorio del archivo actual
require_once(dirname(__FILE__) . '/../config/PersistentManager.php');

class RestauranteDAO {
    //Se define una constante con el nombre de la tabla
    const RESTAURANTE_TABLE = 'restaurant';
    const CATEGORY_TABLE = 'category';
    const RESERVE_TABLE = 'reserve';

    //Conexión a BD
    private $conn = null;
    
    //Constructor de la clase
    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }
    
    public function selectAll() {
        $query = "SELECT * FROM " . self::RESTAURANTE_TABLE;
        $result = mysqli_query($this->conn, $query);
        $restaurantes = array();
        while ($restauranteBD = mysqli_fetch_array($result)) {

            $restaurante= new Restaurante();
            $restaurante->setId($restauranteBD["id"]);
            $restaurante->setName($restauranteBD["name"]);
            $restaurante->setImage($restauranteBD["image"]);
            $restaurante->setMenu($restauranteBD["menu"]);
            $restaurante->setMinorprice($restauranteBD["minorprice"]);
            $restaurante->setMayorprice($restauranteBD["mayorprice"]);
            $restaurante->setIdCategory($restauranteBD["idCategory"]);
            
            array_push($restaurantes, $restaurante);
        }
        return $restaurantes;
    }
    
    public function insert($restaurante) {
        $query = "INSERT INTO " . self::RESTAURANTE_TABLE . 
                " (name, image, menu, minorprice, mayorprice, idCategory) VALUES(?,?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        $name = $restaurante->getName();
        $image = $restaurante->getImage();
        $menu = $restaurante->getMenu();
        $minorprice = $restaurante->getMinorprice();
        $mayorprice = $restaurante->getMayorprice();
        $idCategory = $restaurante->getIdCategory();
        
        mysqli_stmt_bind_param($stmt, "sssddi", $name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        return $stmt->execute();        
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . self::RESTAURANTE_TABLE . " WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        return $stmt->execute();
    }
    
    public function update($restaurante) {
        $query = "UPDATE " . self::RESTAURANTE_TABLE .
                " SET name=?, image=?, menu=?, minorprice=?, mayorprice=?, idCategory=?"
                . " WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $query);
        $name = $restaurante->getName();
        $image = $restaurante->getImage();
        $menu = $restaurante->getMenu();
        $minorprice = $restaurante->getMinorprice();
        $mayorprice = $restaurante->getMayorprice();
        $idCategory = $restaurante->getIdCategory();
        $id = $restaurante->getId();
        
        mysqli_stmt_bind_param($stmt, "sssddii", $name, $image, $menu, $minorprice, $mayorprice, $idCategory, $id);
        return $stmt->execute();        
    }
    
    public function selectCategory($nameCategory) {
        $query = "SELECT r.id AS restaurant_id,"
                . "r.name AS restaurant_name,"
                . "r.image,"
                . "r.menu,"
                . "r.minorprice,"
                . "r.mayorprice,"
                . "r.idCategory AS restaurant_idCategory,"
                . "c.id AS category_id,"
                . "c.name AS category_name"
                . " FROM " . self::RESTAURANTE_TABLE. " AS r"  
                . " JOIN ". self::CATEGORY_TABLE. " AS c"
                . " ON r.idCategory = c.id"
                . " WHERE LOWER(c.name) = LOWER(?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt,"s", $nameCategory);
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $restaurantes = array();
        while ($restauranteBD = mysqli_fetch_array($result)) {

            $restaurante= new Restaurante();
            $restaurante->setId($restauranteBD["restaurant_id"]);
            $restaurante->setName($restauranteBD["restaurant_name"]);
            $restaurante->setImage($restauranteBD["image"]);
            $restaurante->setMenu($restauranteBD["menu"]);
            $restaurante->setMinorprice($restauranteBD["minorprice"]);
            $restaurante->setMayorprice($restauranteBD["mayorprice"]);
            $restaurante->setIdCategory($restauranteBD["restaurant_idCategory"]);
            
            array_push($restaurantes, $restaurante);
        }
        return $restaurantes;
    }
    
    public function fetchCategoryByName($name){
        $query = "SELECT id FROM ".self::CATEGORY_TABLE
                . " WHERE name = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt,"s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result); 
            return $row['id']; 
        } else {
            return null;
        }
    }
    
    public function fetchRestaurantNameById($id){
        $query = "SELECT name FROM ".self::RESTAURANTE_TABLE
                . " WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt,"i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result); 
            return $row['name']; 
        } else {
            return null;
        }
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
