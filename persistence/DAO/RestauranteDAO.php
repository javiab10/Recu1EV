<?php

//dirname(__FILE__) Es el directorio del archivo actual
require_once(dirname(__FILE__) . '/../config/PersistentManager.php');

class RestauranteDAO {
    //Se define una constante con el nombre de la tabla
    const RESTAURANTE_TABLE = 'restaurant';
    const CATEGORY_TABLE = 'category';

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
                " (name, image, menu, minorprice, mayorprice) VALUES(?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conn, $query);
        $name = $restaurante->getName();
        $image = $restaurante->getImage();
        $menu = $restaurante->getMenu();
        $minorprice = $restaurante->getMinorprice();
        $mayorprice = $restaurante->getMayorprice();
        
        mysqli_stmt_bind_param($stmt, "sssdd", $name, $image, $menu, $minorprice, $mayorprice);
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
                " SET name=?, image=?, menu=?, minorprice=?, mayorprice=?"
                . " WHERE id=?";
        $stmt = mysqli_prepare($this->conn, $query);
        $name = $restaurante->getName();
        $image = $restaurante->getImage();
        $menu = $restaurante->getMenu();
        $minorprice = $restaurante->getMinorprice();
        $mayorprice = $restaurante->getMayorprice();
        $id = $restaurante->getId();
        
        mysqli_stmt_bind_param($stmt, "sssdds", $name, $image, $menu, $minorprice, $mayorprice, $id);
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
    
}
