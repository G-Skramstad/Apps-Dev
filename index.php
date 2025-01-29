<?php 
 
require_once 'model/User.php';
$lifetime = 60 * 60 * 24 * 14; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();

$controllerChoice = filter_input(INPUT_GET, 'controllerRequest');

if($controllerChoice == 'logOut'){
    if (isset($_SESSION['customer'])) {
     $_SESSION = array();
     session_destroy();
    }

}
if (isset($_SESSION['customer'])) {
            $user = $_SESSION['customer'];
            $userID = $user-> getID();
            $userRoleID = $user ->getRoleID(); 
        }
    else{
        $userID = 0;
        $userRoleID =0;
    }

require_once 'view/header.php';


?>

 <h1>Welcome.</h1><br>


<?php require_once 'view/footer.php'; ?>