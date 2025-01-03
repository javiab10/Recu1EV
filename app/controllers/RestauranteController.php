<?php

require_once(dirname(__FILE__) . '/../../persistence/DAO/RestauranteDAO.php');
require_once(dirname(__FILE__) . '/../model/validations/ValidationRules.php');
require_once(dirname(__FILE__) . '/../model/Restaurante.php');
require_once(dirname(__FILE__) . '/../model/Reserva.php');

$restauranteController = new RestauranteController();

//Recibimos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "create") {
        $restauranteController->createAction();
    }elseif ($_POST["type"] == "borrar") {
        $restauranteController->deleteAction();
    }elseif ($_POST["type"] == "editar") {
        $restauranteController->editAction();
    }
}

class RestauranteController {
    const toMainPage = "Location: ../views/public/index.php";
    const toInsertar = "Location: ../views/private/insertar.php";
    const toModificar = "Location: ../views/private/modificar.php";
    const msgCamposVacios = "?error=Todos los campos deben estar completos";
    const msgURLNoValida = "?error=URL de imagen No válida";
    const msgCategoriaNoValida = "?error=Categoría de Restaurante no válida";
    
    public function __construct(){
        
    }
    
    // Obtención de la lista completa de restaurantes
    function readAction() {
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectAll();
    }
    
    function createAction() {
        $restauranteDAO = new RestauranteDAO();        
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        $idCategory = $restauranteDAO->fetchCategoryByName($_POST["category"]);
        
        $image = ValidationRules::test_input($_POST["picture"]);
        if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
            $this->redirectWithError(self::toInsertar, self::msgCamposVacios);
        }
        
        if(!$isUrl){
            $this->redirectWithError(self::toInsertar, self::msgURLNoValida);
        }
        
        if($idCategory == null){
            $this->redirectWithError(self::toInsertar, self::msgCategoriaNoValida);
        }
        
        // Creamos el objeto auxiliar y lo llenamos con sus atributos   
        $restaurante = self::createRestaurante($name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        //Creamos un objeto RestauranteDAO para hacer las llamadas a la BD
        $restauranteDAO->insert($restaurante);

        header(self::toMainPage);
        
    }
    
    function deleteAction() {
        $id = $this->checkID();
        
        $restauranteDAO = new RestauranteDAO();
        $restauranteDAO->delete($id);
        
        header(self::toMainPage);
    }
    
    function editAction() {
        $restauranteDAO = new RestauranteDAO();
        $id = $this->checkID();
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        $idCategory = $restauranteDAO->fetchCategoryByName($_POST["category"]);
            
        $image = ValidationRules::test_input($_POST["picture"]);
        if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
            $this->redirectWithError(self::toModificar, self::msgCamposVacios);
        }
        
        if(!$isUrl){
            $this->redirectWithError(self::toModificar, self::msgURLNoValida);
        }
        
        if($idCategory == null){
            $this->redirectWithError(self::toModificar, self::msgCategoriaNoValida);
        }
        
        // Creamos el objeto auxiliar y lo llenamos con sus atributos 
        $restaurante = self::createRestaurante($name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        // Establecemos el id
        $restaurante->setId($id);
        //Usamos el objeto RestauranteDAO para hacer las llamadas a la BD
        $restauranteDAO->update($restaurante);

        header(self::toMainPage);
        
    }
    
    static function createRestaurante($name, $image, $menu, $minorprice, $mayorprice, $idCategory) {
        $restaurante = new Restaurante();
        $restaurante->setName($name);
        $restaurante->setImage($image);
        $restaurante->setMenu($menu);
        $restaurante->setMinorprice($minorprice);
        $restaurante->setMayorprice($mayorprice);
        $restaurante->setIdCategory($idCategory);
        return $restaurante;
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
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectCategory($nameCategory);
    }
    
    function fetchRestaurantById($id){
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->fetchRestaurantNameById($id);
    }
    
}
