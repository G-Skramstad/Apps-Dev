<?php 
require_once ('../model/User.php');
require_once('../model/database.php');
require_once ('../model/User.php');
require_once('../model/user_db.php');
require_once ('../model/Ingredient.php');
require_once ('../model/Ingredient_db.php');
require_once ('../model/IngredientAmount.php');
require_once ('../model/Recipe.php');
require_once ('../model/Recipe_db.php');






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
    
    
     
    
    include_once 'create_recipe_test.php';
}

elseif($controllerChoice == 'createRecipe3'){
    $ingredients= Ingredient_db::getingredients();
    
    foreach($ingredients as $ingredient){
        $ingredientName = $ingredient->getName();
        
        $isChecked = filter_input(INPUT_POST, $ingredientName);
        $iAmounts = []; 
       
        
        if($isChecked){
            $feild = $ingredientName . '_amount';
            $amount =  filter_input(INPUT_POST, $feild);
            
            $iAmount = new IngredientAmount($ingredient->getId(), $amount);
            
            $iAmounts[] = $iAmount;
        }
    }
    $_SESSION['iAmounts'] = $iAmounts;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        // Process the search logic
        echo 'search';  // Search ingredients (method to be created)
    }

    if (isset($_POST['next'])) {
        echo 'next';
    }
}
    
}
elseif($controllerChoice == 'addRecipe'){
    
}



elseif($controllerChoice == 'add-ingredient'){
    
    $ingredients= Ingredient_db::getingredients();
    
    $iAmounts = $_SESSION['iAmounts'] ?? [];
  
    
    $ingredientId = filter_input(INPUT_POST, 'ingredient');
    $amount =  filter_input(INPUT_POST, 'ingredient_amount');
            
    $ingredientAmount = new IngredientAmount($ingredientId, $amount);
            
    $iAmounts[] = $ingredientAmount;
            
    $_SESSION['iAmounts'] = $iAmounts;

    include_once 'create_recipe_test.php';
}
elseif($controllerChoice == 'delete-ingredient'){
   
    $iAmounts = $_SESSION['iAmounts'] ?? []; // Ensure it's an array

    // Get user input
    $ingredientIdToDelete = filter_input(INPUT_POST, 'ingredient', FILTER_SANITIZE_NUMBER_INT);

    if ($ingredientIdToDelete) {
        
         $ingredients= Ingredient_db::getingredients();
        
        // Filter out the ingredient to delete
        $iAmounts = array_filter($iAmounts, function ($ingredientAmount) use ($ingredientIdToDelete) {
            return $ingredientAmount->getIngredientID() != $ingredientIdToDelete;
        });

        // Reindex array
        $_SESSION['iAmounts'] = array_values($iAmounts);
    }

    include_once 'create_recipe_test.php';
}

elseif($controllerChoice == 'search-ingredient'){
    
    $iAmounts = $_SESSION['iAmounts'] ?? [];
    $ingredientName = filter_input(INPUT_POST, 'ingredients_search');
    
    $ingredients= Ingredient_db::search_ingredients($ingredientName);
    
    include_once 'create_recipe_test.php';
}




elseif($controllerChoice == 'addRecipe-Legacy'){
    
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    $instructions = filter_input(INPUT_POST, 'instructions');
    $ingredients= Ingredient_db::getingredients();
    
    foreach($ingredients as $ingredient){
        $ingredientName = $ingredient->getName();
        
        $isChecked = filter_input(INPUT_POST, $ingredientName);
        
       
        
        if($isChecked){
            $feild = $ingredientName . '_amount';
            $amount =  filter_input(INPUT_POST, $feild);
            
            $iAmount = new IngredientAmount($ingredient->getId(), $amount);
            
            $iAmounts[] = $iAmount;
        }
        
        
    }
        $recipe = new Recipe($userID, $name,$description,$instructions, 1);
        
        Recipe_db::addRecipe($recipe, $iAmounts);
    
    
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



