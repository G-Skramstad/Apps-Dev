<?php

    class IngredientType{
        private $ID, $Name;
        
        public function __construct($ID, $Name) {
            $this->ID = $ID;
            $this->Name = $Name;
        }

        public function getID() {
            return $this->ID;
        }

        public function getName() {
            return $this->Name;
        }

        public function setID($ID) {
            $this->ID = $ID;
        }


    }