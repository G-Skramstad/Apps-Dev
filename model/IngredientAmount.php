<?php

class IngredientAmount{
    
    private $ingredientID, $amount, $ingredientName;
    
    public function __construct($ingredientID, $amount, $ingredientName) {
        $this->ingredientID = $ingredientID;
        $this->amount = $amount;
        $this->ingredientName = $ingredientName;
    }

    
    
    public function getIngredientName() {
        return $this->ingredientName;
    }
   
    public function getIngredientID() {
        return $this->ingredientID;
    }

    public function getAmount() {
        return $this->amount;
    }


}