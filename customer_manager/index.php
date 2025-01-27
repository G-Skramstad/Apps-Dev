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
            $userRoleID = $user ->getRoleID(); 
        }
    else{
        $userID = 0;
        $userRoleID =0;
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
     $email = filter_input(INPUT_COOKIE, 'email');
     //$password = filter_input(INPUT_COOKIE, 'password');
     
     if($email == null){
         $email = "";
     }
    require_once("customer_login.php");
}


else if($controllerChoice == 'validate_login'){
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    if ($email == null || $password == null) {
        $validLogin = filter_input(INPUT_GET, 'validLogin');
        $errorMessage = "Please enter a valid email and password";
        include('customer_login.php');
    } 
    else {
        
        setcookie("email", $email);
        //setcookie("password", $password);
      $user = user_db::get_user_by_email_password($email,$password);
        if($user)   {
            
           //$customer = get_customer_by_id($ID);
           $login_message = "Login Succesful";
           
           
           $_SESSION['customer'] = $user;
           include('customer_edit.php');
        } 
        else{
            $errorMessage = "Incorrect email or password";
            include('customer_login.php');
        }
    }
}


else if ($controllerChoice == 'list_customers_view') {
    $last_name = "";
    $users = user_db::get_users(); 
    include("customer_list.php");
}
else if($controllerChoice == 'show_edit_customer_veiw'){
    $ID = filter_input(INPUT_POST, 'customer_id');
    $user = user_db::get_user_by_id($ID);
    include("customer_edit.php");
}
else if ($controllerChoice == 'update_customer') {
    $email = filter_input(INPUT_POST, 'email');
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $address = filter_input(INPUT_POST, 'address');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $zip = filter_input(INPUT_POST, 'zip');
    $ID = filter_input(INPUT_POST, 'customer_id');
    $active = filter_input(INPUT_POST, 'active');

    $phone = filter_input(INPUT_POST, 'phone');
    if($active == true){
        $active = 1;
    }
    else{
        $active = 0; 
    }

    $passwordC = filter_input(INPUT_POST, 'password');
    
    $user = new User($email, $passwordC, $firstName, $lastName, $address, $city, $state, $zip, $active, $userRoleID, $phone);
    
    $user ->setId($ID);
    
    user_db::update_user($user);
    $users = user_db::get_users();
    $last_name = "";
    include ("customer_list.php");
}
else if($controllerChoice == 'search_customer'){
    $last_name = filter_input(INPUT_POST, 'last_name_search');
    $users = user_db::search_users($last_name);
    include ("customer_list.php");
}
else if($controllerChoice == "add_customer_view"){
    $registeration_message  = "";
    include ("customer_register.php");
}
else if($controllerChoice == "add_customer"){

    $email = filter_input(INPUT_POST, 'email');
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $address = filter_input(INPUT_POST, 'address');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $zip = filter_input(INPUT_POST, 'zip');
    $passwordC = filter_input(INPUT_POST, 'password');
    $roleID = 1;
    $phone = filter_input(INPUT_POST, 'phone');
    $active = true; 
    
    $user = new User($email, $passwordC, $firstName, $lastName, $address, $city, $state, $zip, $active, $roleID, $phone);
    
     $emailinUse = user_db::check_in_use_email($email);

    if ($emailinUse == null){
    
    user_db::add_user($user);
    
    $last_name = "";
    $users = user_db::get_users();
    include ("customer_list.php");
    
    }
    else{
        $registeration_message  = "email is in use please use a difrent email or login";
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
