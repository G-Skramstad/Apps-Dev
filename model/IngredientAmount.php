<?php

class IngredientAmount{
    
    private $ingredientID, $amount;
    
    public function __construct($ingredientID, $amount) {
        $this->ingredientID = $ingredientID;
        $this->amount = $amount;
    }
    
    
   

    public function getIngredientID() {
        return $this->ingredientID;
    }

    public function getAmount() {
        return $this->amount;
    }


}