<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require_once('../model/database.php');
require_once ('../model/User.php');
require_once('../model/Store.php');
require_once('../model/store_db.php');

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

if($controllerChoice == 'stores'){
    $stores = store_db::getStores();
    
    include_once 'store_list.php'; 
}
else if($controllerChoice == 'add_store'){
    $name = filter_input(INPUT_POST, 'name');
    
    store_db::addStore($name);
        
    $stores = store_db::getStores();
    
    include_once 'store_list.php'; 
}
else if($controllerChoice == 'Deactivate_store'){
    $id = filter_input(INPUT_POST, 'storeID');
    
    store_db::deactivateStore($id);
        
    $stores = store_db::getStores();
    
    include_once 'store_list.php'; 
}
else if($controllerChoice == 'Activate_store'){
    $id = filter_input(INPUT_POST, 'storeID');
    
    store_db::activateStore($id);
        
    $stores = store_db::getStores();
    
    include_once 'store_list.php'; 
}
else if($controllerChoice == 'edit_store'){
    $id = filter_input(INPUT_POST, 'storeID');
    $name = filter_input(INPUT_POST, 'name');
    
    store_db::editStore($id, $name);
        
    $stores = store_db::getStores();
    
    include_once 'store_list.php'; 
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