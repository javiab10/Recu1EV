<?php

require_once(dirname(__FILE__) . '/../../persistence/DAO/RestauranteDAO.php');
require_once(dirname(__FILE__) . '/../model/validations/ValidationRules.php');
require_once(dirname(__FILE__) . '/../model/Restaurante.php');

$restauranteController = new RestauranteController();

//Recibimos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["type"] == "create"){
        $restauranteController->createAction();
    }elseif ($_POST["type"] == "borrar") {
        $restauranteController->deleteAction();
    }elseif ($_POST["type"] == "editar"){
        $restauranteController->editAction();
    }
}

class RestauranteController {
    
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
        $idCategory = $restauranteDAO->fetchCategory($_POST["category"]);
        
        if($idCategory == null){
            self::redirectWithError("Categoría de Restaurante no válida");
        }
        
        if(!$isUrl){
            self::redirectWithError("El campo image debe ser una URL");
        }
        
        $image = ValidationRules::test_input($_POST["picture"]);
        if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
            self::redirectWithError("Todos los campos deben estar completos");
        }
        
        // Creamos el objeto auxiliar y lo llenamos con sus atributos   
        $restaurante = self::createRestaurante($name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        //Creamos un objeto RestauranteDAO para hacer las llamadas a la BD
        $restauranteDAO->insert($restaurante);

        header('Location: ../views/public/index.php');
        
    }
    
    function deleteAction() {
        $id = $this->comprobarID();
        
        $restauranteDAO = new RestauranteDAO();
        $restauranteDAO->delete($id);
        
        header('Location: ../views/public/index.php');
    }
    
    function editAction() {
        $restauranteDAO = new RestauranteDAO();
        $id = $this->comprobarID();
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        $idCategory = $restauranteDAO->fetchCategory($_POST["category"]);
        
        if($idCategory == null){
            self::redirectWithError("Categoría de Restaurante no válida");
        }
        
        if(!$isUrl){
            self::redirectWithError("El campo image debe ser una URL");
        }
            
        $image = ValidationRules::test_input($_POST["picture"]);
        if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
            self::redirectWithError("Todos los campos deben estar completos");
        }
        
        // Creamos el objeto auxiliar y lo llenamos con sus atributos 
        $restaurante = self::createRestaurante($name, $image, $menu, $minorprice, $mayorprice, $idCategory);
        // Establecemos el id
        $restaurante->setId($id);
        //Usamos el objeto RestauranteDAO para hacer las llamadas a la BD
        $restauranteDAO->update($restaurante);

        header('Location: ../views/public/index.php');
        
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
    
    static function redirectWithError($message){
        echo "<p>".$message."</p>";
        header('Location: ../views/private/modificar.php?error='. urldecode($message));
    }
    
    function comprobarID() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"]; // Obtenemos el id del registro
            
        } else {
            // Si no se encuentra el id en el Post
            echo "El ID no se ha recibido correctamente.";
            return;
        }
        
        return $id;
    }
    
    function readCategory($category){
        $nameCategory = ValidationRules::test_input($category);
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectCategory($nameCategory);
    }
}
