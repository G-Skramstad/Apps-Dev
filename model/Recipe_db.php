<?php

    

class Recipe_db{
    
    public static function getAllRecipes() {
        $db = Database::getDB();  

        $query = 'SELECT * FROM recipe WHERE isActive = 1';
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
    
    public static function searchRecipes($searchName) {
        $db = Database::getDB();  

        $query = 'SELECT * FROM recipe '
                . 'WHERE isActive = 1 AND name Like :name';
        $statement = $db->prepare($query);
        $statement->bindValue(':name', '%'.$searchName.'%');
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
    public static function myRecipes($userId) {
        $db = Database::getDB();  

        $query = 'SELECT * FROM recipe WHERE ccUserID = :userid';
            $statement = $db->prepare($query);
            $statement->bindValue(':userid', $userId);
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

    public static function get_recipe_by_id($id) {
        $db = Database::getDB();  

        try {
            // Fetch the recipe details
            $query = 'SELECT r.ID, r.ccUserID, r.Name, r.description, r.instructions, r.isActive 
                      FROM recipe r WHERE r.ID = :id';
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();

            // If the recipe exists, fetch the ingredients and amounts
            if ($row) {
                $recipe = new Recipe(
                    $row['ccUserID'],
                    $row['Name'],
                    $row['description'],
                    $row['instructions'],
                    $row['isActive']
                );
                $recipe->setId($row['ID']);

                // Fetch ingredients and their amounts using RecipeIngredient table
                $query = 'SELECT i.ID AS ingredientID, i.Name AS ingredientName, ri.amount 
                          FROM RecipeIngredient ri 
                          JOIN Ingredient i ON ri.ingredientID = i.ID 
                          WHERE ri.recipeID = :recipeID';
                $statement = $db->prepare($query);
                $statement->bindValue(':recipeID', $id);
                $statement->execute();
                $ingredientsData = $statement->fetchAll();
                $statement->closeCursor();

                // Create an array of IngredientAmount objects
                $ingredients = [];
                foreach ($ingredientsData as $ingredient) {
                    $ingredients[] = new IngredientAmount(
                        $ingredient['ingredientID'], 
                        $ingredient['amount'], 
                        $ingredient['ingredientName']
                    );
                }

                // Return the recipe along with its ingredients
                return [
                    'recipe' => $recipe,
                    'ingredients' => $ingredients
                ];
            } else {
                return null; // Recipe not found
            }
        } catch (Exception $e) {
            throw new Exception("Error fetching recipe: " . $e->getMessage());
        }
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
            $query = 'INSERT INTO RecipeIngredient (recipeID, ingredientID, amount) 
                      VALUES (:recipeID, :ingredientID,:amount)';
            $statement = $db->prepare($query);

            foreach ($ingredients as $ingredientID) {
                $statement->bindValue(':recipeID', $recipeID, PDO::PARAM_INT);
                $statement->bindValue(':ingredientID', $ingredientID->getIngredientID(), PDO::PARAM_INT);
                $statement->bindValue(':amount', $ingredientID->getAmount());
                $statement->execute();
                
            }
            
            $statement->closeCursor(); // Close cursor after execution to prevent issues

            // Commit transaction
            $db->commit();
            Database::logAction('recipe', 'INSERT', $recipe->getUserID(), 'Added recipe with ID ' . $recipeID);
            return $recipeID;
        } catch (Exception $e) {
            $db->rollBack();
            throw new Exception("Error inserting recipe: " . $e->getMessage());
            }    
    }
    
    public static function updateRecipe($recipe, $ingredients,$recipeid) {
    $db = Database::getDB();  

    try {
        $db->beginTransaction();

        // Update recipe table
        $query = 'UPDATE recipe 
                  SET Name = :name, 
                      description = :description, 
                      instructions = :instructions, 
                      isActive = :isActive
                  WHERE id = :recipeID';
        $statement = $db->prepare($query);
        $statement->execute([
            ':name' => $recipe->getName(),
            ':description' => $recipe->getDescription(),
            ':instructions' => $recipe->getInstructions(),
            ':isActive' => $recipe->getIsActive(),
            ':recipeID' => $recipeid
        ]);

        // Delete existing ingredients for this recipe
        $query = 'DELETE FROM RecipeIngredient WHERE recipeID = :recipeID';
        $statement = $db->prepare($query);
        $statement->execute([':recipeID' => $recipeid]);

        // Insert updated ingredients
        $query = 'INSERT INTO RecipeIngredient (recipeID, ingredientID, amount) 
                  VALUES (:recipeID, :ingredientID, :amount)';
        $statement = $db->prepare($query);

        foreach ($ingredients as $ingredient) {
            $statement->execute([
                ':recipeID' => $recipeid,
                ':ingredientID' => $ingredient->getIngredientID(),
                ':amount' => $ingredient->getAmount()
            ]);
        }

        $statement->closeCursor();

        $db->commit();
        Database::logAction('recipe', 'INSERT', $recipe->getUserID(), 'update recipe', $recipeid);
        return true;

    } catch (Exception $e) {
        $db->rollBack();
        throw new Exception("Error updating recipe: " . $e->getMessage());
    }
}

   
        
        
}
    
    
    

