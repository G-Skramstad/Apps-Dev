<?php

Class WishListItem{
    
    private $id, $desc, $quantity, $notes, $Store, $FulfilledBy, $isActive; 
    
    public function __construct($desc, $quantity, $notes, $Store, $FulfilledBy, $isActive) {
        $this->desc = $desc;
        $this->quantity = $quantity;
        $this->notes = $notes;
        $this->Store = $Store;
        $this->FulfilledBy = $FulfilledBy;
        $this->isActive = $isActive; 
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getStore() {
        return $this->Store;
    }

    public function getFulfilledBy() {
        return $this->FulfilledBy;
    }

    public function getIsActive() {
        return $this->isActive;
    }
    public function getId() {
        return $this->id;
    }

            public function setId($id) {
        $this->id = $id;
    }


    
    
}
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

