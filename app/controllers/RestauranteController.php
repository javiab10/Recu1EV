<?php

require_once(dirname(__FILE__) . '/../../persistence/DAO/RestauranteDAO.php');

class RestauranteController {
    
    public function __construct(){
        
    }
    
    // Obtención de la lista completa de restaurantes
    function readAction() {
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectAll();
    }
}
