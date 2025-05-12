<?php



require_once ('../model/User.php');
require_once('../model/database.php');
require_once('../model/user_db.php');

$lifetime = 60 * 60 * 24 * 14; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();


// Get the data from either the GET or POST collection.
$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');

if (isset($_SESSION['customer'])) {
            $user = $_SESSION['customer'];
            $userID = $user-> getID();
            $userActive = $user->getIsActive();
            $userRoleID = $user ->getRoleID(); 
        }
    else{
        $userID = 0;
        $userRoleID =-1;
        $userActive = 0;
    }
if ( $controllerChoice == NULL) {
     $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ( $controllerChoice == NULL) {
         $controllerChoice = 'Not-Set (Null)';
         // After you have debugged, you can then default the controller choice.
         //$controllerChoice = 'login_customer';
    }
}  


/*  The controller does three things
*  1: Makes a decision based on the value of $controllerChoise
*  2:  Gathers the required resources / objects needed to display on the view
*  3:  Includes the appropriet view or redirect to a different page.
*/


if($controllerChoice == 'login_customer_view'){
     $errorMessage = "";
     $userName = filter_input(INPUT_COOKIE, 'userName');
     //$password = filter_input(INPUT_COOKIE, 'password');
     
     if($userName == null){
         $userName = "";
     }
    require_once("customer_login.php");
}


else if($controllerChoice == 'validate_login'){
    $userName = filter_input(INPUT_POST, 'userName');
    $password = filter_input(INPUT_POST, 'password');
    if ($userName == null || $password == null) {
        $validLogin = filter_input(INPUT_GET, 'validLogin');
        $errorMessage = "Please enter a valid email and password";
        include('customer_login.php');
    } 
    else {
        
        setcookie("userName", $userName);
        //setcookie("password", $password);
      $user = user_db::get_user_by_userName_password($userName,$password);
        if($user)   {
            
           //$customer = get_customer_by_id($ID);
           $login_message = "Login Succesful";
           
           
           $_SESSION['customer'] = $user;
           include('customer_edit.php');
        } 
        else{
            $errorMessage = "Incorrect username or password";
            include('customer_login.php');
        }
    }
}


else if ($controllerChoice == 'list_customers_view') {
    $username  = "";
    $users = user_db::get_users(); 
    include("customer_list.php");
}
else if($controllerChoice == 'show_edit_customer_veiw'){
    $ID = filter_input(INPUT_POST, 'customer_id') ?? $userID;
    
    $user = user_db::get_user_by_id($ID);
    include("customer_edit.php");
}
else if ($controllerChoice == 'update_customer') {
    $email = filter_input(INPUT_POST, 'email');
    $userName = filter_input(INPUT_POST, 'userName');
    $ID = filter_input(INPUT_POST, 'customer_id');
    $active = filter_input(INPUT_POST, 'active');

    $phone = filter_input(INPUT_POST, 'phone');
    if($active == true){
        $active = 1;
    }
    else{
        $active = 0; 
    }

    $passwordC=null; 
    
    $user = new User($email,$passwordC,$userName,$userRoleID, $active);
    
    $user ->setId($ID);
    
    user_db::update_user($user);
    $users = user_db::get_users();
    $last_name = "";
    include ("../Recipe_manager/index.php");
}
else if($controllerChoice == 'search_customer'){
    $username = filter_input(INPUT_POST, 'username_search');
    $users = user_db::search_users($username);
    include ("customer_list.php");
}
else if($controllerChoice == "add_customer_view"){
    $registeration_message  = "";
    include ("customer_register.php");
}
else if($controllerChoice == "add_customer"){

    $email = filter_input(INPUT_POST, 'email');
    $userName = filter_input(INPUT_POST, 'userName');
    $passwordC = filter_input(INPUT_POST, 'password');
    $roleID = 2;
    $phone = filter_input(INPUT_POST, 'phone');
    $active = true; 
    
    $user = new User($email,$passwordC,$userName,$roleID, $active);
    
     $emailinUse = user_db::check_in_use_email($email);
     $userNameInUse = user_db::check_in_use_username($userName);

    if ($emailinUse == null && $userNameInUse == Null){
    
    $_SESSION['customer'] = user_db::add_user($user);
    
    $last_name = "";
    $users = user_db::get_users();
    include ("../Recipe_manager/index.php");
    
    }
    else{
        if($emailinUse == null){
        $registeration_message  = "email is in use please use a difrent email or login";}
        else{
            $registeration_message  = "UserName is in use please use a difrent one";
        }
    include ("customer_register.php");
    }
}

// Final else very helpful for debugging.
else {
      // Show this is an unhandled $controllerChoice
       // Show generic else page
          require_once '../view/header.php'; 
          echo "<h1>Not yet implimented... </h1>";
          echo "<h2> controllerChoice:  $controllerChoice</h2>";
          echo "<h3> File:  customer_manager/index.php </h3>";
          require_once '../view/footer.php';
      
}
?>
