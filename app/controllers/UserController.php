<?php

require_once(dirname(__FILE__) . '/../../persistence/DAO/UserDAO.php');
require_once(dirname(__FILE__) . '/../model/User.php');
require_once(dirname(__FILE__) . '/../model/validations/ValidationRules.php');

require_once(dirname(__FILE__) . '/../../utils/SessionUtils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userController = new UserController();
    if ($_POST["type"] == "login") {
        $userController->checkCredentials(); 
    }
    if ($_POST["type"] == "logout") {
        $userController->loggOut();
    }  
}

class UserController {
    
    public function __construct() {
        
    }
    
    public function checkCredentials(){
        $user = new User();
        $user->setEmail($_POST["inputEmail"]);
        $user->setPassword($_POST["inputPass"]);

        //Creamos un objeto UserDAO para hacer las llamadas a la BD
        $userDAO = new UserDAO();
        $user = $userDAO->getUserInformation($user);
        if ($user != null) {
            // Establecemos la sesión
            SessionUtils::startSessionIfNotStarted();
            SessionUtils::setSession($user->getEmail(), $user->getType(), $user->getIdUser());

            header('Location: ../views/public/index.php');
        } else {
            header('Location: ../views/public/index.php?error=invalid_credentials');
        }
    }
    
    public function loggOut(){
        SessionUtils::destroySession();
        header('Location: ../views/public/index.php');
    }
}
