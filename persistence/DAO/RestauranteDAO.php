<?php

//dirname(__FILE__) Es el directorio del archivo actual
require_once(dirname(__FILE__) . '/../config/PersistentManager.php');

class RestauranteDAO {
    //Se define una constante con el nombre de la tabla
    const RESTAURANTE_TABLE = 'restaurant';

    //Conexión a BD
    private $conn = null;
    
    //Constructor de la clase
    public function __construct() {
        $this->conn = PersistentManager::getInstance()->get_connection();
    }
    
    public function selectAll() {
        $query = "SELECT * FROM " . RestauranteDAO::RESTAURANTE_TABLE;
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
            
            array_push($restaurantes, $restaurante);
        }
        return $restaurantes;
    }
    
    public function insert($restaurante) {
        $query = "INSERT INTO " . RestauranteDAO::RESTAURANTE_TABLE . 
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
        $query = "DELETE FROM " . RestauranteDAO::RESTAURANTE_TABLE . " WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        return $stmt->execute();
    }
    
}
