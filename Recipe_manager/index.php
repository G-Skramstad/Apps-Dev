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





if (session_status() !== PHP_SESSION_ACTIVE) {
$lifetime = 60 * 60 * 24 * 14; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();
}

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
    if(isset($_SESSION['Recipe-from-edit'])){
        $fromEdit =$_SESSION['Recipe-from-edit'];
    }
    else{
        $fromEdit = false;
    }
    $fromEdit =$_SESSION['Recipe-from-edit'];
    
    if($fromEdit == true){
        $_SESSION['Recipe-from-edit'] = false;
        unset($_SESSION['iAmounts']);
        unset($_SESSION['recipe_name']);
        unset($_SESSION['recipe_description']);
        unset($_SESSION['recipe_instructions']);
    }
    
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
    
    $redirect = filter_input(INPUT_POST, 'page');
    if($redirect == 'edit'){
    include_once 'edit_recipe_page2.php';
    }
    else{
      include_once 'create_recipe_page2.php';  
    }
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

    $redirect = filter_input(INPUT_POST, 'page');
    if($redirect == 'edit'){
    include_once 'edit_recipe_page2.php';
    }
    else{
      include_once 'create_recipe_page2.php';  
    }
}

elseif($controllerChoice == 'search-ingredient'){
    
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $ingredientName = filter_input(INPUT_POST, 'ingredients_search');
    
    $ingredients= Ingredient_db::search_ingredients($ingredientName);
    
    $redirect = filter_input(INPUT_POST, 'page');
    if($redirect == 'edit'){
    include_once 'edit_recipe_page2.php';
    }
    else{
      include_once 'create_recipe_page2.php';  
    }
}

elseif($controllerChoice == 'veiw-all-recipes'){
    $recipes = Recipe_db::getAllRecipes();
    
    
    include_once 'recipe_list_view.php';
}

elseif($controllerChoice == 'search_recipe'){
    $searchName = filter_input(INPUT_POST, 'search_name');
    
    
    $recipes = Recipe_db::searchRecipes($searchName);
    
    
    include_once 'recipe_list_view.php';
}


elseif($controllerChoice == 'view_recipe' ||
        $controllerChoice == 'like_comment' ||
        $controllerChoice == 'unlike_comment'||
        $controllerChoice == 'post_comment'||
        $controllerChoice == 'sort_comment'){
    
    $scrollToComments = in_array($controllerChoice, [
    'like_comment', 'unlike_comment', 'post_comment', 'sort_comment'
    ]);
    
    $id = filter_input(INPUT_POST, 'id');
    
    $recipeData = Recipe_db::get_recipe_by_id($id);
    
     $recipe = $recipeData['recipe'];
     $tableType="1";

    // Access the ingredients array
    $ingredients = $recipeData['ingredients'];
    
    //$comments = Comment_db::get_comments($tableType, $id);
    
    
    include_once 'recipe_view.php';
}
elseif($controllerChoice == 'myRecipes' ||$controllerChoice == 'add_customer' ||
        $controllerChoice == 'update_customer'){
    $searchName = filter_input(INPUT_POST, 'search_name');
    
    
    $recipes = Recipe_db::myRecipes($userID);
    
    include_once 'recipe_list_view.php';
}

elseif($controllerChoice == 'UserRecipies'){
    $id = filter_input(INPUT_POST, 'customer_id');
    $searchName = filter_input(INPUT_POST, 'search_name');
    
    
    $recipes = Recipe_db::myRecipes($id);
    
    include_once 'recipe_list_view.php';
}

elseif($controllerChoice == 'Edit-view'){
    $id = filter_input(INPUT_POST, 'id');
    
    $recipeData = Recipe_db::get_recipe_by_id($id);
    
    $recipe = $recipeData['recipe'];

    $_SESSION['editing-recipie-id'] = $id;
    
     $_SESSION['Recipe-from-edit'] = true;
    
    $ingredients = $recipeData['ingredients'];
    
    $errorMessage = "";
    
    $_SESSION['iAmounts'] = $ingredients;
    $name = $recipe ->getName();
        
    $description = $recipe->getDescription();
    $_SESSION['recipe_instructions'] = $recipe->getInstructions();
    include_once 'edit_recipe_page1.php';
}
elseif($controllerChoice == 'EditRecipe2'){
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    
    $_SESSION['recipe_name'] = $name;
    $_SESSION['recipe_description'] = $description;
    
    $ingredients= Ingredient_db::getingredients();
    
     $iAmounts = $_SESSION['iAmounts'] ?? [];
    
    
     
    
    include_once 'edit_recipe_page2.php';
}
elseif($controllerChoice == 'editRecipe3'){
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $recipeName = $_SESSION['recipe_name'];
    $recipeDescription = $_SESSION['recipe_description'];
    $instructions = $_SESSION['recipe_instructions'];
    include_once 'edit_recipe_page3.php';
}



elseif($controllerChoice == 'editRecipe'){
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $recipeName = $_SESSION['recipe_name'];
    $recipeDescription = $_SESSION['recipe_description'];
    $recipeInstuctions = filter_input(INPUT_POST, 'instructions');
    $recipeId = $_SESSION['editing-recipie-id'];
    
    $recipe = new Recipe($userID, $recipeName,$recipeDescription,$recipeInstuctions, 1);
        
    //Recipe_db::addRecipe($recipe, $iAmounts);
    Recipe_db::updateRecipe($recipe, $iAmounts,$recipeId);
    $recipes = Recipe_db::getAllRecipes();
    include_once 'recipe_list_view.php';
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



