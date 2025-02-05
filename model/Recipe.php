<?php

class Recipe{
    
    private $ID, $UserID,$name,$description,$instructions,$isActive ;
    
    public function __construct($UserID, $name, $description, $instructions, $isActive) {
        $this->UserID = $UserID;
        $this->name = $name;
        $this->description = $description;
        $this->instructions = $instructions;
        $this->isActive = $isActive;
    }
    public function getIsActive() {
        return $this->isActive;
    }

        public function getDescription() {
        return $this->description;
    }

        public function getID() {
        return $this->ID;
    }

    public function getUserID() {
        return $this->UserID;
    }

    public function getName() {
        return $this->name;
    }

    public function getInstructions() {
        return $this->instructions;
    }

        
    public function setID($ID) {
        $this->ID = $ID;
    }




}

