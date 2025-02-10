<?php

    

class ingredient_db{
    
    public static function getingredients(){
        $db = Database::getDB();  
        
        $query = 'SELECT id, ingredientTypeID ,name, flavorNotes, uses, link,isActive FROM ingredient';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new Ingredient($row['ingredientTypeID'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['isActive']);
            $ingredient->setId($row['id']);
            $ingredients[] = $ingredient;
        }

        return $ingredients;    
        
        
    }
    
    
    public static function get_ingredient_by_id($ingredientID){
        $db = Database::getDB();  
        
        $query = 'SELECT id, ingredientTypeID ,name, flavorNotes, uses, link,isActive '
                . 'FROM ingredient WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id',  $ingredientID );
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new Ingredient($row['ingredientTypeID'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['isActive']);
            $ingredient->setId($row['id']);
            $ingredients[] = $ingredient;
        }

        return $ingredients;    
        
        
    }
    
    
    public static function search_ingredients($ingredientName){
        $db = Database::getDB();  
        
        $query = 'SELECT id, ingredientTypeID ,name, flavorNotes, uses, link,isActive '
                . 'FROM ingredient WHERE name LIKE :iName';
        $statement = $db->prepare($query);
        $statement->bindValue(':iName', '%' . $ingredientName . '%');
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new Ingredient($row['ingredientTypeID'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['isActive']);
            $ingredient->setId($row['id']);
            $ingredients[] = $ingredient;
        }

        return $ingredients;    
        
        
    }
    
   
    


    
    
    
}
