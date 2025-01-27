<?php

class Store{
    
    private $id,$name,$isActive;
    
    public function __construct( $name, $isActive) {
        $this->name = $name;
        $this->isActive = $isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getIsActive() {
        return $this->isActive;
    }


}
