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
        $result = '<div class="col-12 col-md-6 col-lg-4 mt-5">';
        $result .= '<div class="card h-100">';
        $result .= '<img class="card-img-top" src="'.$this->getImage().'"alt="Card image cap">';
        $result .= '<div class="card-body">';
        $result .= '<span class="badge bg-primary">'.$this->getMinorprice().'-'.$this->getMayorprice().'</span>';
        $result .= '<h4 class="card-title">'.$this->getName().'</h4>';
        $result .= '<p class="card-text">'.$this->getMenu().'</p>';
        $result .= '</div>';
        $result .= '<div class="card-footer d-flex justify-content-around">';
        $result .= '<form action="../../views/public/booking.php" method="post">';
        $result .= '<input type="hidden" name="type" value="book">';
        $result .= '<input type="hidden" name="id" value="'.$this->getId().'">';
        $result .= '<button type="submit" class="btn btn-success" name="book" id="btn_book">Reservar</button>';
        $result .= '</form>';
        $result .= '<form action="../../views/private/modify.php" method="post">';
        $result .= '<input type="hidden" name="type" value="modify">';
        $result .= '<input type="hidden" name="id" value="'.$this->getId().'">';
        $result .= '<button type="submit" class="btn btn-warning" name="modify" id="btn_modify">Editar</button>';
        $result .= '</form>';
        $result .= '<form action="../../controllers/RestaurantController.php" method="post">';
        $result .= '<input type="hidden" name="type" value="delete">';
        $result .= '<input type="hidden" name="id" value="'.$this->getId().'">';
        $result .= '<button type="submit" class="btn btn-danger" name="delete" id="btn_delete">Borrar</button>';
        $result .= '</form>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';

        return $result;
    }

}
