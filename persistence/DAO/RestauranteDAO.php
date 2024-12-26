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
    
}
