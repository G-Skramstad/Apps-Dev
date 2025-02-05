<?php

    

class Recipe_db{
    
    public static function getAllRecipes() {
        $db = Database::getDB();  

        $query = 'SELECT * FROM recipe';
        $statement = $db->prepare($query);
        $statement->execute();
        $recipesData = $statement->fetchAll();
        $statement->closeCursor();

        $recipes = [];
        foreach ($recipesData as $row) {
            $recipe = new Recipe(
                $row['ccUserID'],      // UserID
                $row['name'],          // Name
                $row['description'],   // Description
                $row['instructions'],  // Instructions
                $row['isActive']       // isActive
            );

            $recipe->setId($row['id']); // Set the recipe ID
            $recipes[] = $recipe;
        }

        return $recipes;
    }



    
    
    
    
    
    
    
    public static function addRecipe($recipe, $ingredients){
        $db = Database::getDB();  

        try {
            $db->beginTransaction();

            // Insert into recipe table
            $query = 'INSERT INTO recipe (ccUserID, Name, description, instructions,isActive) 
                      VALUES (:userID, :name, :description, :instructions,:isActive)';
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $recipe->getUserID());
            $statement->bindValue(':name', $recipe->getName());
            $statement->bindValue(':description', $recipe->getDescription());
            $statement->bindValue(':instructions', $recipe->getInstructions());
            $statement->bindValue(':isActive', $recipe->getIsActive());
            $statement->execute();

            // Get last inserted recipe ID
            $recipeID = $db->lastInsertId();

            // Insert ingredients into RecipeIngredient table
            $query = 'INSERT INTO RecipeIngredient (recipeID, ingredientID) 
                      VALUES (:recipeID, :ingredientID)';
            $statement = $db->prepare($query);

            foreach ($ingredients as $ingredientID) {
                $statement->bindValue(':recipeID', $recipeID, PDO::PARAM_INT);
                $statement->bindValue(':ingredientID', $ingredientID->getIngredientID(), PDO::PARAM_INT);
                $statement->execute();
                
            }
            
            $statement->closeCursor(); // Close cursor after execution to prevent issues

            // Commit transaction
            $db->commit();
            return $recipeID;
        } catch (Exception $e) {
            $db->rollBack();
            throw new Exception("Error inserting recipe: " . $e->getMessage());
            }    
    }
   
        
        
}
    
    
    

