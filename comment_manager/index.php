<?php

require_once ('../model/User.php');
require_once('../model/database.php');
require_once ('../model/Comment.php');
require_once ('../model/Comment_db.php');
require_once ('profanity_api.php');


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
        $userRoleID = -1;
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
    
    Comment_db::unlike_comment($userID, $commentID);
    $controllerChoice = "comment";
    
        
        if($tableType == 1){
            include_once '../Recipe_manager/index.php';
        }
        elseif($tableType == 2){
            include_once '../Ingredients_manager/index.php';
        }
    
    
}
elseif($controllerChoice == 'sort_comment'){
    
    $tableType = filter_input(INPUT_POST, 'TableType');

    $controllerChoice = "comment";
    $sort = filter_input(INPUT_POST, 'sort');
            
        if($tableType == 1){
            include_once '../Recipe_manager/index.php';
        }
        elseif($tableType == 2){
            include_once '../Ingredients_manager/index.php';
        }
    
    
}
elseif($controllerChoice == "post_comment"){
    
    $tableType = filter_input(INPUT_POST, 'TableType');
    $title = filter_input(INPUT_POST, 'title');
    $comment = filter_input(INPUT_POST, 'comment');
    $commentedForID = filter_input(INPUT_POST, 'id');
    
    $titleCheck = "test:".$title;
    $commentCheck= "test:".$comment; 
    $APICheck = profanity_api::checkMessage($commentCheck); 
    $APICheck2 = profanity_api::checkMessage($titleCheck);
    
    if($APICheck['isProfanity'] || $APICheck2['isProfanity']){
        $error = "please refrain from all profanity in the comment section";
    }
    else if($title == "" || $comment == ""){
        $error = "Please fill out all fields";
    }
    else{
        Comment_db::add_comments($title, $comment, $userID, $commentedForID, $tableType);
    }
    
    
    
    
        
        if($tableType == 1){
            include_once '../Recipe_manager/index.php';
        }
        elseif($tableType == 2){
            include_once '../Ingredients_manager/index.php';
        }
    
}