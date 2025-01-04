<?php

require_once(dirname(__FILE__) . '/../../persistence/DAO/RestaurantDAO.php');
require_once(dirname(__FILE__) . '/../model/validations/ValidationRules.php');
require_once(dirname(__FILE__) . '/../model/Restaurant.php');
require_once(dirname(__FILE__) . '/../model/Book.php');

$restaurantController = new RestaurantController();

//Recibimos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "create") {
        $restaurantController->createAction();
    }elseif ($_POST["type"] == "borrar") {
        $restaurantController->deleteAction();
    }elseif ($_POST["type"] == "editar") {
        $restaurantController->editAction();
    }
}

class RestaurantController {
    const toMainPage = "Location: ../views/public/index.php";
    const toInsert = "Location: ../views/private/insertar.php";
    const toModify = "Location: ../views/private/modify.php";
    const msgEmptyFields = "?error=Todos los campos deben estar completos";
    const msgInvalidURL = "?error=URL de imagen No válida";
    const msgInvalidCategory = "?error=Categoría de Restaurante no válida";
    
    public function __construct(){
        
    }
    
    // Obtención de la lista completa de restaurantes
    function readAction() {
        $restaurantDAO = new RestaurantDAO();
        return $restaurantDAO->selectAll();
    }
    
    function createAction() {
        $restaurantDAO = new RestaurantDAO();        
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $image = ValidationRules::test_input($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        $idCategory = $restaurantDAO->fetchCategoryByName($_POST["category"]);
        
        if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
            $this->redirectWithError(self::toInsert, self::msgEmptyFields);
        }
        
        if(!$isUrl){
            $this->redirectWithError(self::toInsert, self::msgInvalidURL);
        }
        
        if($idCategory == null){
            $this->redirectWithError(self::toInsert, self::msgInvalidCategory);
        }
        
        // Creamos el objeto auxiliar y lo llenamos con sus atributos   
        $restaurant = self::createRestaurant($name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        //Creamos un objeto RestauranteDAO para hacer las llamadas a la BD
        $restaurantDAO->insert($restaurant);

        header(self::toMainPage);
        
    }
    
    function deleteAction() {
        $id = $this->checkID();
        
        $restaurantDAO = new RestaurantDAO();
        $restaurantDAO->delete($id);
        
        header(self::toMainPage);
    }
    
    function editAction() {
        $restaurantDAO = new RestaurantDAO();
        $id = $this->checkID();
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $image = ValidationRules::test_input($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        $idCategory = $restaurantDAO->fetchCategoryByName($_POST["category"]);
        
        if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
            $this->redirectWithError(self::toModify, self::msgEmptyFields);
        }
        
        if(!$isUrl){
            $this->redirectWithError(self::toModify, self::msgInvalidURL);
        }
        
        if($idCategory == null){
            $this->redirectWithError(self::toModify, self::msgInvalidCategory);
        }
        
        // Creamos el objeto auxiliar y lo llenamos con sus atributos 
        $restaurant = self::createRestaurant($name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        // Establecemos el id
        $restaurant->setId($id);
        //Usamos el objeto RestauranteDAO para hacer las llamadas a la BD
        $restaurantDAO->update($restaurant);

        header(self::toMainPage);
        
    }
    
    static function createRestaurant($name, $image, $menu, $minorprice, $mayorprice, $idCategory) {
        $restaurant = new Restaurant();
        $restaurant->setName($name);
        $restaurant->setImage($image);
        $restaurant->setMenu($menu);
        $restaurant->setMinorprice($minorprice);
        $restaurant->setMayorprice($mayorprice);
        $restaurant->setIdCategory($idCategory);
        return $restaurant;
    }
    
    public function redirectWithError($location, $message){
        header($location . urldecode($message));
        exit();
    }
    
    public function checkID() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"]; // Obtenemos el id del registro
            
        } else {
            // Si no se encuentra el id en el Post
            echo "El ID no se ha recibido correctamente.";
            return;
        }
        
        return $id;
    }
    
    function fetchCategoryByName($name){
        $nameCategory = ValidationRules::test_input($name);
        $restaurantDAO = new RestaurantDAO();
        return $restaurantDAO->selectCategory($nameCategory);
    }
    
    function fetchRestaurantById($id){
        $restaurantDAO = new RestaurantDAO();
        return $restaurantDAO->fetchRestaurantNameById($id);
    }
    
}
