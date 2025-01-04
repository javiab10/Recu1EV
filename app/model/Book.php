<?php

class Book {
    private $id;
    private $id_restaurant;
    private $date;
    private $persons;
    private $IP;
    
    public function __construct() {
        
    }
    
    public function getId_restaurant() {
        return $this->id_restaurant;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPersons() {
        return $this->persons;
    }

    public function getIP() {
        return $this->IP;
    }

    public function setId_restaurant($id_restaurant): void {
        $this->id_restaurant = $id_restaurant;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function setPersons($persons): void {
        $this->persons = $persons;
    }

    public function setIP($IP): void {
        $this->IP = $IP;
    }




    
}
