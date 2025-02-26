<?php

class RequestedInngredient{
    
    private $id, $userID,$ingredientType, $name, $flavorNotes, $uses, $Image, $otherNotes;
    
    public function __construct($userID, $ingredientTypeID, $name, $flavorNotes, $uses, $Image,$otherNotes) {
        $this->userID = $userID;
        $this->ingredientType = $ingredientTypeID;
        $this->name = $name;
        $this->flavorNotes = $flavorNotes;
        $this->uses = $uses;
        $this->Image = $Image;
        $this->otherNotes = $otherNotes;
    }
    
    public function getUserID() {
        return $this->userID;
    }

    public function getOtherNotes() {
        return $this->otherNotes;
    }

    
        public function getId() {
        return $this->id;
    }

    public function getIngredientType() {
        return $this->ingredientType;
    }

    public function getName() {
        return $this->name;
    }

    public function getFlavorNotes() {
        return $this->flavorNotes;
    }

    public function getUses() {
        return $this->uses;
    }

    public function getImage() {
        return $this->Image;
    }

    public function setId($id) {
        $this->id = $id;
    }




}
