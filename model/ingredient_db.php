<?php

    

class ingredient_db{
    
    public static function getingredients(){
        $db = Database::getDB();  
        
        $query = 'SELECT i.id, i.ingredientTypeID ,i.name, i.flavorNotes, i.uses, '
                . 'i.link, i.isActive, it.name AS ingredientType '
                . 'FROM ingredient AS i JOIN ingredienttype AS it ON i.ingredientTypeID = it.id';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new Ingredient($row['ingredientType'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['isActive']);
            $ingredient->setId($row['id']);
            $ingredients[] = $ingredient;
        }

        return $ingredients;    
        
        
    }
    
    
    public static function get_ingredient_by_id($ingredientID){
        $db = Database::getDB();  
        
        $query = 'SELECT i.id, it.name as ingredientType ,i.name, i.flavorNotes, i.uses, i.link, i.isActive '
                . 'FROM ingredient AS i JOIN ingredienttype AS it ON i.ingredientTypeID = it.id'
                . ' WHERE i.id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id',  $ingredientID );
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        
            $ingredient = new Ingredient($row['ingredientType'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['isActive']);
            $ingredient->setId($row['id']);
            

        return $ingredient;    
        
        
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
    
    public static function get_ingredient_types() {
    $db = Database::getDB();
    
    // Query to fetch all ingredient types
    $query = 'SELECT * FROM ingredienttype'; // Change the table name if necessary
    $statement = $db->prepare($query);
    $statement->execute();
    
    // Fetch all the rows as an array
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $ingredientTypes = [];

    // Loop through the fetched data and create objects or store in an array
    foreach ($rows as $row) {
        // Assuming each ingredient type has an ID and a name
        $ingredientTypes[] = new IngredientType($row['id'], $row['name']); // Adjust based on actual column names
    }

    return $ingredientTypes;
}

    
   
    


    
    
    
}
