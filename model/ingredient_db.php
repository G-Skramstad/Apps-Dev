<?php

    

class ingredient_db{
    
    public static function getingredients(){
        $db = Database::getDB();  
        
        $query = 'SELECT id, ingredientTypeID ,name, flavorNotes, uses, link FROM ingredient';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new Ingredient($row['ingredientTypeID'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link']);
            $ingredient->setId($row['id']);
            $ingredients[] = $ingredient;
        }

        return $ingredients;    
        
        
}
    
    
    
}
