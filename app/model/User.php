<?php

class User {
    
    private $idUser;
    private $email;
    private $password;
    private $type;
    
    public function __construct() {
        
    }
    
    public function getIdUser() {
        return $this->idUser;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getType() {
        return $this->type;
    }

    public function setIdUser($idUser): void {
        $this->idUser = $idUser;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setType($type): void {
        $this->type = $type;
    }

}
