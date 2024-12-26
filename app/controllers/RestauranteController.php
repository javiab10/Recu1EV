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
        
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        
        if($isUrl==true){
            $image = ValidationRules::test_input($_POST["picture"]);
            
            if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
                echo "<p>Todos los campos deben estar completos</p>";
                header('Location: ../views/private/insertar.php?error=Todos los campos deben estar completos');
            }
            else{
                // Creación de objeto auxiliar   
                $restaurante = new Restaurante();
                $restaurante->setName($name);
                $restaurante->setImage($image);
                $restaurante->setMenu($menu);
                $restaurante->setMinorprice($minorprice);
                $restaurante->setMayorprice($mayorprice);
                //Creamos un objeto CreatureDAO para hacer las llamadas a la BD
                $restauranteDAO = new RestauranteDAO();
                $restauranteDAO->insert($restaurante);

                header('Location: ../views/public/index.php');
            }
        }else{
            echo "<p>El campo image debe ser una URL</p>";
            header('Location: ../views/private/insertar.php?error=El campo image debe ser una URL');
        }
        
    }
    
    function deleteAction() {
        $id = $this->comprobarID();
        
        $restauranteDAO = new RestauranteDAO();
        $restauranteDAO->delete($id);
        
        header('Location: ../views/public/index.php');
    }
    
    function editAction() {
        $id = $this->comprobarID();
        // Obtención de los valores del formulario y validación
        $name = ValidationRules::test_input($_POST["name"]);
        $isUrl = ValidationRules::validate_url($_POST["picture"]);
        $menu = ValidationRules::test_input($_POST["menu"]);
        $minorprice = ValidationRules::test_input($_POST["minorprice"]);
        $mayorprice = ValidationRules::test_input($_POST["mayorprice"]);
        
        if($isUrl==true){
            $image = ValidationRules::test_input($_POST["picture"]);
            
            if($name==null||$image==null||$menu==null||$minorprice==null||$mayorprice==null){
                echo "<p>Todos los campos deben estar completos</p>";
                header('Location: ../views/private/modificar.php?error=Todos los campos deben estar completos');
            }
            else{
                // Creación de objeto auxiliar   
                $restaurante = new Restaurante();
                $restaurante->setId($id);
                $restaurante->setName($name);
                $restaurante->setImage($image);
                $restaurante->setMenu($menu);
                $restaurante->setMinorprice($minorprice);
                $restaurante->setMayorprice($mayorprice);
                //Creamos un objeto CreatureDAO para hacer las llamadas a la BD
                $restauranteDAO = new RestauranteDAO();
                $restauranteDAO->update($restaurante);

                header('Location: ../views/public/index.php');
            }
        }else{
            echo "<p>El campo image debe ser una URL</p>";
            header('Location: ../views/private/modificar.php?error=El campo image debe ser una URL');
        }
        
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
}
