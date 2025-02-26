<?php 
require_once ('../model/User.php');
require_once('../model/database.php');
require_once ('../model/User.php');
require_once ('../model/Comment.php');
require_once('../model/user_db.php');
require_once ('../model/Ingredient.php');
require_once ('../model/Ingredient_db.php');
require_once ('../model/IngredientAmount.php');
require_once ('../model/Recipe.php');
require_once ('../model/Recipe_db.php');
require_once ('../model/Comment_db.php');






$lifetime = 60 * 60 * 24 * 14; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();


$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');

if($controllerChoice == null){
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
}

if (isset($_SESSION['customer'])) {
            $user = $_SESSION['customer'];
            $userID = $user-> getID();
            $userRoleID = $user ->getRoleID(); 
        }
    else{
        $userID = 0;
        $userRoleID = 0; 
    }

if($controllerChoice == 'create_recipe_view'){
    
    $ingredients= Ingredient_db::getingredients();
    

    include_once 'create_new_recipe.php';
}


elseif($controllerChoice == 'createRecipe1'){
    $errorMessage = "";
    
    if (isset($_SESSION['recipe_name'])) {
            $name = $_SESSION['recipe_name'];
        }
    else{
        $name = ""; 
    }
    
    if (isset($_SESSION['recipe_description'])) {
            $description = $_SESSION['recipe_description'];
        }
    else{
        $description = ""; 
    }
    
    include_once 'create_recipe_page1.php';
    
}


elseif($controllerChoice == 'createRecipe2'){
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    
    $_SESSION['recipe_name'] = $name;
    $_SESSION['recipe_description'] = $description;
    
    $ingredients= Ingredient_db::getingredients();
    
     $iAmounts = $_SESSION['iAmounts'] ?? [];
    
    
     
    
    include_once 'create_recipe_page2.php';
}

elseif($controllerChoice == 'createRecipe3'){
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $recipeName = $_SESSION['recipe_name'];
    $recipeDescription = $_SESSION['recipe_description'];
    
    include_once 'create_recipe_page3.php';
}



elseif($controllerChoice == 'addRecipe'){
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $recipeName = $_SESSION['recipe_name'];
    $recipeDescription = $_SESSION['recipe_description'];
    $recipeInstuctions = filter_input(INPUT_POST, 'instructions');
    
    
    $recipe = new Recipe($userID, $recipeName,$recipeDescription,$recipeInstuctions, 1);
        
    Recipe_db::addRecipe($recipe, $iAmounts);
    
    $recipes = Recipe_db::getAllRecipes();
    include_once 'recipe_list_view.php';
}



elseif($controllerChoice == 'add-ingredient'){
    
    $ingredients= Ingredient_db::getingredients();
    
    $iAmounts = $_SESSION['iAmounts'] ?? [];
  
    
    $ingredientName = filter_input(INPUT_POST, 'ingredient');
    $ingredientId = filter_input(INPUT_POST, 'ingredientID');
    $amount =  filter_input(INPUT_POST, 'ingredient_amount');
            
    $ingredientAmount = new IngredientAmount($ingredientId, $amount,$ingredientName);
            
    $iAmounts[] = $ingredientAmount;
            
    $_SESSION['iAmounts'] = $iAmounts;

    include_once 'create_recipe_page2.php';
}
elseif($controllerChoice == 'delete-ingredient'){
   
    $iAmounts = $_SESSION['iAmounts'] ?? []; // Ensure it's an array

    // Get user input
    $ingredientIdToDelete = filter_input(INPUT_POST, 'ingredientID', FILTER_SANITIZE_NUMBER_INT);

    if ($ingredientIdToDelete) {
        
         $ingredients = Ingredient_db::getingredients();
        
        // Filter out the ingredient to delete
        $iAmounts = array_filter($iAmounts, function ($ingredientAmount) use ($ingredientIdToDelete) {
            return $ingredientAmount->getIngredientID() != $ingredientIdToDelete;
        });

        // Reindex array
        $_SESSION['iAmounts'] = array_values($iAmounts);
    }

    include_once 'create_recipe_page2.php';
}

elseif($controllerChoice == 'search-ingredient'){
    
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $ingredientName = filter_input(INPUT_POST, 'ingredients_search');
    
    $ingredients= Ingredient_db::search_ingredients($ingredientName);
    
    include_once 'create_recipe_page2.php';
}

elseif($controllerChoice == 'veiw-all-recipes'){
    $recipes = Recipe_db::getAllRecipes();
    
    
    include_once 'recipe_list_view.php';
}




elseif($controllerChoice == 'view_recipe'){
    
    $id = filter_input(INPUT_POST, 'recipeID');
    
    $recipeData = Recipe_db::get_recipe_by_id($id);
    
     $recipe = $recipeData['recipe'];

    // Access the ingredients array
    $ingredients = $recipeData['ingredients'];
    
    $comments = Comment_db::get_comments("recipe", $id);
    
    
    include_once 'recipe_view.php';
}


else {
      // Show this is an unhandled $controllerChoice
       // Show generic else page
          require_once '../view/header.php';
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> controllerChoice:  $controllerChoice</h2>";
          echo "<h3> File: wish_list_manager/index.php </h3>";
          require_once '../view/footer.php';
      
}
?>



