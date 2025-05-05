<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require_once('../model/database.php');
require_once ('../model/User.php');
require_once ('../model/Ingredient.php');
require_once ('../model/Ingredient_db.php');
require_once ('../model/IngredientType.php');
require_once ('../model/RequestedInngredient.php');
require_once ('../model/Comment_db.php');
require_once ('../model/Comment.php');

if (session_status() !== PHP_SESSION_ACTIVE) {
$lifetime = 60 * 60 * 24 * 14; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();}

if (isset($_SESSION['customer'])) {
            $user = $_SESSION['customer'];
            $userID = $user-> getID();
            $userRoleID = $user ->getRoleID(); 
        }
    else{
        $userID = 0;
        $userRoleID = 0 ;
    }

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');

if($controllerChoice == null){
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
}

if($controllerChoice == 'ingredient_list_view'){
     $ingredients = Ingredient_db::getingredients();
    
    include_once 'ingredient_list_view.php'; 
}

elseif($controllerChoice == 'view_ingreidient' ||
        $controllerChoice == 'like_comment' ||
        $controllerChoice == 'unlike_comment'||
        $controllerChoice == 'post_comment'||
        $controllerChoice == 'sort_comment'){
    
    $scrollToComments = in_array($controllerChoice, [
    'like_comment', 'unlike_comment', 'post_comment', 'sort_comment'
    ]);
    
    $id = filter_input(INPUT_POST, 'id');
    
    $ingredient = Ingredient_db::get_ingredient_by_id($id);
    $tableType="2";
    
    include_once 'view_ingreidient.php';
}
elseif($controllerChoice == 'search_ingredient'){
    $ingredientName= filter_input(INPUT_POST, 'ingredient_name');
    $ingredients = Ingredient_db::search_ingredients($ingredientName);
    
    
    
    include_once 'ingredient_list_view.php'; 
}
elseif($controllerChoice == 'request_ingredient_view'){
    
    $ingredientTypes = ingredient_db::get_ingredient_types();
    
    
    include_once 'request_ingredient.php';
    
    
}
 elseif($controllerChoice == 'requestIngredient'){
     
     $name = filter_input(INPUT_POST, 'name');
     $ingredientTypeid = filter_input(INPUT_POST, 'ingredientType');
     $flavorNotes = filter_input(INPUT_POST, 'flavor');
     $uses = filter_input(INPUT_POST, 'uses');
     $img = filter_input(INPUT_POST, 'img');
     
     $ingredient = new Ingredient($ingredientTypeid, $name, $flavorNotes,$uses,$img,1);
     
     $newID = ingredient_db::add_request_ingredient($ingredient,$userID);
     
     $ingredientName= filter_input(INPUT_POST, 'ingredient_name');
    $ingredients = Ingredient_db::search_ingredients($ingredientName);
    
    include_once 'ingredient_list_view.php';
 }
 elseif($controllerChoice == 'ingredient_Requests_veiw'){
     
     $ingredients = Ingredient_db::get_requested_ingredients();
    
    include_once 'Requested_list.php'; 
 }

 elseif($controllerChoice == 'Approval_view'){
     $id = filter_input(INPUT_POST, 'ingreidientID');
     
     $ingredient = Ingredient_db::get_requested_ingredient($id);
    
    include_once 'ingredient_Approve.php'; 
 }
  elseif($controllerChoice == 'deny_ingredient'){
     $id = filter_input(INPUT_POST, 'ingreidientID');
     
     Ingredient_db::deny_ingredient($id);
    
     
     $ingredients = Ingredient_db::get_requested_ingredients();
    include_once 'Requested_list.php'; 
 }
  elseif($controllerChoice == 'approve_ingredient'){
     $id = filter_input(INPUT_POST, 'ingreidientID');
     
     $ingredient = Ingredient_db::get_requested_ingredient_typeid($id);
    
    Ingredient_db::approve_ingredient($id,$ingredient); 
     
     $ingredients = Ingredient_db::get_requested_ingredients();
    include_once 'Requested_list.php'; 
 }
else {
      // Show this is an unhandled $controllerChoice
       // Show generic else page
          require_once '../view/header.php'; 
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> controllerChoice:  $controllerChoice</h2>";
          echo "<h3> File: store_manager/index.php </h3>";
          require_once '../view/footer.php';
      
}

