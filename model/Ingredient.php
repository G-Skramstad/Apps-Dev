<?php

class Ingredient{
    
    private $id, $ingredientTypeID, $name, $flavorNotes, $uses, $Image, $isActive;
    
    public function __construct($ingredientTypeID, $name, $flavorNotes, $uses, $Image,$isActive) {
        $this->ingredientTypeID = $ingredientTypeID;
        $this->name = $name;
        $this->flavorNotes = $flavorNotes;
        $this->uses = $uses;
        $this->Image = $Image;
        $this->isActive = $isActive;
    }
    
    public function getIsActive() {
        return $this->isActive;
    }

        public function getId() {
        return $this->id;
    }

    public function getIngredientTypeID() {
        return $this->ingredientTypeID;
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
