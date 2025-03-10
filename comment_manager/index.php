<?php

require_once ('../model/User.php');
require_once('../model/database.php');
require_once ('../model/Comment.php');
require_once ('../model/Comment_db.php');


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

if($controllerChoice == 'like_comment'){
    
    $commentID= filter_input(INPUT_POST, 'commentID');
    $tableType = filter_input(INPUT_POST, 'TableType');
    $id = filter_input(INPUT_POST, 'id');
    Comment_db::like_comment($userID, $commentID);
    
   $controllerChoice = "comment"; 
        if($tableType == 1){
            include_once '../Recipe_manager/index.php';
        }
        elseif($tableType == 2){
            include_once '../Ingredients_manager/index.php';
        }
        
    
}


elseif($controllerChoice == 'unlike_comment'){
    $commentID= filter_input(INPUT_POST, 'commentID');
    $tableType = filter_input(INPUT_POST, 'TableType');
    //$id = filter_input(INPUT_POST, 'id');
    Comment_db::unlike_comment($userID, $commentID);
    $controllerChoice = "comment";
    
        
        if($tableType == 1){
            include_once '../Recipe_manager/index.php';
        }
        elseif($tableType == 2){
            include_once '../Ingredients_manager/index.php';
        }
    
    
}