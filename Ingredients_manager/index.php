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


$lifetime = 60 * 60 * 24 * 14; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();

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

elseif($controllerChoice == 'view_ingreidient'){
    $ingredientID = filter_input(INPUT_POST, 'ingreidientID');
    
    $ingredient = Ingredient_db::get_ingredient_by_id($ingredientID);
    
    include_once 'view_ingreidient.php';
}
elseif($controllerChoice == 'request_ingredient_view'){
    
    $ingredientTypes = ingredient_db::get_ingredient_types();
    
    
    include_once 'request_ingredient.php';
    
    
}
 elseif($controllerChoice == 'requestIngredient'){
     
     
     
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

