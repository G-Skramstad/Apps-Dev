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
        
        $query = 'SELECT i.id, i.ingredientTypeID ,i.name as ingredient, i.flavorNotes, i.uses, '
                . 'i.link, i.isActive, it.name AS ingredientType '
                . 'FROM ingredient AS i JOIN ingredienttype AS it ON i.ingredientTypeID = it.id '
                . 'WHERE i.name LIKE :iName';
        $statement = $db->prepare($query);
        $statement->bindValue(':iName', '%' . $ingredientName . '%');
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new Ingredient($row['ingredientType'], $row['ingredient'],
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

    
   
  public static function add_request_ingredient($ingredient,$userID) {
      $db = Database::getDB();
      
      $query = 'INSERT INTO requestedIngredient (ccUser_id, ingredientTypeID, name, flavorNotes, uses, link) 
                  VALUES (:user, :ingredientTypeID, :name, :flavorNotes, :uses, :link)';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $userID);
        $statement->bindValue(':ingredientTypeID', $ingredient->getIngredientType(), PDO::PARAM_INT);
        $statement->bindValue(':name', $ingredient->getName(), PDO::PARAM_STR);
        $statement->bindValue(':flavorNotes', $ingredient->getFlavorNotes(), PDO::PARAM_STR);
        $statement->bindValue(':uses', $ingredient->getUses(), PDO::PARAM_STR);
        $statement->bindValue(':link', $ingredient->getImage(), PDO::PARAM_STR);


        $statement->execute();
        $statement->closeCursor();

        return $db->lastInsertId();
  } 
  
  public static function get_requested_ingredients(){
      $db = Database::getDB();  
        
        $query = 'SELECT i.id,i.ccUser_id, i.ingredientTypeID ,i.name, i.flavorNotes, i.uses, '
                . 'i.link, i.otherNotes, it.name AS ingredientType '
                . 'FROM requestedingredient AS i JOIN ingredienttype AS it ON i.ingredientTypeID = it.id '
                . 'WHERE adminApproved is null';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $ingredient = new RequestedInngredient ($row['ccUser_id'], $row['ingredientType'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['otherNotes']);
            $ingredient->setId($row['id']);
            $ingredients[] = $ingredient;
        }

        return $ingredients;
  }
  
  public static function get_requested_ingredient($id){
      $db = Database::getDB();  
        
        $query = 'SELECT i.id,i.ccUser_id, i.ingredientTypeID ,i.name, i.flavorNotes, i.uses, '
                . 'i.link, i.otherNotes, it.name AS ingredientType '
                . 'FROM requestedingredient AS i JOIN ingredienttype AS it ON i.ingredientTypeID = it.id'
                . ' WHERE i.id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id );
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        
            $ingredient = new RequestedInngredient ($row['ccUser_id'], $row['ingredientType'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['otherNotes']);
            $ingredient->setId($row['id']);

        

        return $ingredient;
  }
  
  public static function get_requested_ingredient_typeid($id){
      $db = Database::getDB();  
        
        $query = 'SELECT i.id,i.ccUser_id, i.ingredientTypeID ,i.name, i.flavorNotes, i.uses, '
                . 'i.link, i.otherNotes, i.ingredientTypeID '
                . 'FROM requestedingredient AS i '
                . ' WHERE i.id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id );
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        
            $ingredient = new RequestedInngredient ($row['ccUser_id'], $row['ingredientTypeID'], $row['name'],
                    $row['flavorNotes'], $row['uses'],$row['link'],$row['otherNotes']);
            $ingredient->setId($row['id']);

        

        return $ingredient;
  }
  
  public static function approve_ingredient($id, $ingredient){
      $db = Database::getDB(); 
      
      $queryaprove = 'UPDATE requestedingredient 
          SET adminApproved = 1 
          WHERE id = :id';
      $statement = $db->prepare($queryaprove);
        $statement->bindValue(':id', $id );
        $statement->execute();
        $statement->closeCursor();
      
      $querymove = 'INSERT INTO ingredient (ingredientTypeID, name, flavorNotes, uses, link) 
                  VALUES (:ingredientTypeID, :name, :flavorNotes, :uses, :link)';
        $statement2 = $db->prepare($querymove);
        $statement2->bindValue(':ingredientTypeID', $ingredient->getIngredientType(), PDO::PARAM_INT);
        $statement2->bindValue(':name', $ingredient->getName(), PDO::PARAM_STR);
        $statement2->bindValue(':flavorNotes', $ingredient->getFlavorNotes(), PDO::PARAM_STR);
        $statement2->bindValue(':uses', $ingredient->getUses(), PDO::PARAM_STR);
        $statement2->bindValue(':link', $ingredient->getImage(), PDO::PARAM_STR);


        $statement2->execute();
        $statement2->closeCursor();

        return $db->lastInsertId();
  }
  
  public static function deny_ingredient($id){
      $db = Database::getDB(); 
      
      $query = 'UPDATE requestedingredient 
          SET adminApproved = 0 
          WHERE id = :id';
      $statement = $db->prepare($query);
        $statement->bindValue(':id', $id );
        $statement->execute();
  }


    
    
    
}
