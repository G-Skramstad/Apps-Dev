<?php

Class WishList{
    
    private $id, $Name, $description, $Items, $DateCreated, $isActive, $userID; 

    
    public function __construct($id, $Name, $description, $Items, $DateCreated, $isActive, $userID) {
        $this->id = $id;
        $this->Name = $Name;
        $this->description = $description;
        $this->Items = $Items;
        $this->DateCreated = $DateCreated;
        $this->isActive = $isActive;
        $this->userID = $userID; 
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->Name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getItems() {
        return $this->Items;
    }

    public function getDateCreated() {
        return $this->DateCreated;
    }

    public function getIsActive() {
        return $this->isActive;
    }
    public function getUserID() {
        return $this->userID;
    }

        public function setId($id) {
        $this->id = $id;
    }


    
}

