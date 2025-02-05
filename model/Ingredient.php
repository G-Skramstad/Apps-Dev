<?php

class Ingredient{
    
    private $id, $ingredientTypeID, $name, $flavorNotes, $uses, $Image;
    
    public function __construct($ingredientTypeID, $name, $flavorNotes, $uses, $Image) {
        $this->ingredientTypeID = $ingredientTypeID;
        $this->name = $name;
        $this->flavorNotes = $flavorNotes;
        $this->uses = $uses;
        $this->Image = $Image;
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
