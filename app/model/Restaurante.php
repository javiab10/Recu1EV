<?php

class Restaurante {
    private $id;
    private $name;
    private $image;
    private $menu;
    private $minorprice;
    private $mayorprice;
    
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
    
    function pintarRestaurante(){
            $result = '<div class="col-12 col-md-6 col-lg-4 mt-5">';
            $result .= '<div class="card h-100">';
            $result .= '<img class="card-img-top" src="'.$this->getImage().'"alt="Card image cap">';
            $result .= '<div class="card-body">';
            $result .= '<span class="badge bg-primary">'.$this->getMinorprice().'-'.$this->getMayorprice().'</span>';
            $result .= '<h4 class="card-title">'.$this->getName().'</h4>';
            $result .= '<p class="card-text">'.$this->getMenu().'</p>';
            $result .= '</div>';
            $result .= '<div class="card-footer d-flex justify-content-around">';
            $result .= '<form action="../../views/private/modificar.php" method="post">';
            $result .= '<input type="hidden" name="type" value="modificar">';
            $result .= '<input type="hidden" name="id" value="'.$this->getId().'">';
            $result .= '<button type="submit" class="btn btn-warning" name="modificar" id="boton_modificar">Editar</button>';
            $result .= '</form>';
            $result .= '<form action="../../controllers/RestauranteController.php" method="post">';
            $result .= '<input type="hidden" name="type" value="borrar">';
            $result .= '<input type="hidden" name="id" value="'.$this->getId().'">';
            $result .= '<button type="submit" class="btn btn-danger" name="borrar" id="boton_delete">Borrar</button>';
            $result .= '</form>';
            $result .= '</div>';
            $result .= '</div>';
            $result .= '</div>';

            return $result;
        }



}
