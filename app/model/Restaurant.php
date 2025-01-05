<?php

class Restaurant {
    private $id;
    private $name;
    private $image;
    private $menu;
    private $minorprice;
    private $mayorprice;
    private $idCategory;
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getMinorprice() {
        return $this->minorprice;
    }

    public function getMayorprice() {
        return $this->mayorprice;
    }
    
    public function getIdCategory() {
        return $this->idCategory;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setImage($image): void {
        $this->image = $image;
    }

    public function setMenu($manu): void {
        $this->menu = $manu;
    }

    public function setMinorprice($minorprice): void {
        $this->minorprice = $minorprice;
    }

    public function setMayorprice($mayorprice): void {
        $this->mayorprice = $mayorprice;
    }
    
    public function setIdCategory($idCategory): void {
        $this->idCategory = $idCategory;
    }
    
    function drawRestaurant(){
        $isLogged = $isLogged = SessionUtils::loggedIn();
        $type = $isLogged ? $_SESSION['user_type'] : "";
        
        $result = 
            '<div class="col-12 col-md-6 col-lg-4 mt-5">'.
                '<div class="card h-100">'.
                    '<img class="card-img-top" src="'.$this->getImage().'"alt="Card image cap">'.
                    '<div class="card-body">'.
                        '<span class="badge bg-primary">'.$this->getMinorprice().'-'.$this->getMayorprice().'</span>'.
                        '<h4 class="card-title">'.$this->getName().'</h4>'.
                        '<p class="card-text">'.$this->getMenu().'</p>'.
                    '</div>'.
                    '<div class="card-footer d-flex justify-content-around">';

        if(!$isLogged){
            $result = $this->drawBookForm($result);
        }
        
        if($isLogged && $type == "Gestor"){
            $result = $this->drawBookForm($result);
            $result = $this->drawModifyForm($result);
        }
        
        if($isLogged && $type == "Admin"){
            $result = $this->drawBookForm($result);
            $result = $this->drawModifyForm($result);
            $result = $this->drawDeleteForm($result);           
        }                    
                
        $result .=      '</div>'.
                    '</div>'.
                '</div>';
        
        return $result;
    }
    
    function drawBookForm($result){
        $result .= '<form action="../../views/public/booking.php" method="post">'.
                            '<input type="hidden" name="type" value="book">'.
                            '<input type="hidden" name="id" value="'.$this->getId().'">'.
                            '<button type="submit" class="btn btn-success" name="book" id="btn_book">Reservar</button>'.
                        '</form>';
        return $result;
    }
    
    function drawModifyForm($result){
        $result .= '<form action="../../views/private/modify.php" method="post">'.
                            '<input type="hidden" name="type" value="modify">'.
                            '<input type="hidden" name="id" value="'.$this->getId().'">'.
                            '<button type="submit" class="btn btn-warning" name="modify" id="btn_modify">Editar</button>'.
                        '</form>';
        return $result;
    }
    
    function drawDeleteForm($result){
        $result .= '<form action="../../controllers/RestaurantController.php" method="post">'.
                            '<input type="hidden" name="type" value="delete">'.
                            '<input type="hidden" name="id" value="'.$this->getId().'">'.
                            '<button type="submit" class="btn btn-danger" name="delete" id="btn_delete">Borrar</button>'.
                        '</form>';
        return $result;
    }

}
