<?php 
require_once ('../model/User.php');
require_once('../model/database.php');
require_once('../model/wish_list_db.php');
require_once ('../model/WishList.php');
require_once ('../model/WishListItem.php');
require_once('../model/wish_list_item_db.php');
require_once('../model/Store.php');
require_once('../model/store_db.php');
require_once ('../model/User.php');
require_once('../model/user_db.php');


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

if($controllerChoice == 'myWishes'){
    
    
    $wishLists = wish_list_db::getWishListByUserId($userID);

    include_once 'wish_list_user.php';
}
elseif($controllerChoice == 'edit_list_items') {
    $wishListId = filter_input(INPUT_POST, 'wishListID');
    
    $wishListItems = wish_list_item_db::getWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_edit.php';
}
else if ($controllerChoice == 'add_list_item'){
    $wishListId = filter_input(INPUT_POST, 'wishListID');
    $desc= filter_input(INPUT_POST, 'description');
    $quantity= filter_input(INPUT_POST, 'quantity');
    $notes= filter_input(INPUT_POST, 'notes');
    $storeId= filter_input(INPUT_POST, 'store');
    wish_list_item_db::addListItem($wishListId, $desc, $quantity, $notes, $storeId);
    
    $wishListItems = wish_list_item_db::getWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_edit.php';
}
else if ($controllerChoice == 'Deactivate_item'){
    $wishListId = filter_input(INPUT_POST, 'wishListID');
    $itemID = filter_input(INPUT_POST, 'itemID');
    wish_list_item_db::deactivateItem($itemID);
    
    $wishListItems = wish_list_item_db::getWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_edit.php';
}
else if ($controllerChoice == 'Activate_item'){
    $wishListId = filter_input(INPUT_POST, 'wishListID');
    $itemID = filter_input(INPUT_POST, 'itemID');
    wish_list_item_db::activateItem($itemID);
    
    $wishListItems = wish_list_item_db::getWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_edit.php';
}
else if($controllerChoice == 'wishLists'){
    
    
    $wishLists = wish_list_db::getWishAllWishLists();

    include_once 'wish_list_user.php';
}
else if($controllerChoice == 'userWishes'){
    $ListuserID = filter_input(INPUT_POST, 'customer_id');
    
    
    $wishLists = wish_list_db::getWishListByUserId($ListuserID);

    include_once 'wish_list_user.php';
    
}
else if ($controllerChoice == 'wishListSearch'){
    
}
else if ($controllerChoice == 'wishesGranted'){
    
    
    $wishListItems = wish_list_item_db::getWishListItemsGranted($userID);
    
    
    include_once 'wishes_granted.php';
}
else if ($controllerChoice == 'create_new_list_view'){
    $users = user_db::get_users(); 
    
    include_once 'create_new_list.php';
}
else if ($controllerChoice == 'addList'){
    
    
    $description = filter_input(INPUT_POST, 'description');
    
    $listUserID = filter_input(INPUT_POST, 'listUserID');
    
    if ($listUserID == ""){
        $listUserID = $userID;
    }

    $wishListId = wish_list_db::addWishList($listUserID, $description);
    $wishListItems = wish_list_item_db::getWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_edit.php';
    
}
else if ($controllerChoice == 'View_list_Items'){
    
    
    $wishListId = filter_input(INPUT_POST, 'wishListID');
    
    $wishListItems = wish_list_item_db::getActiveWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_veiw.php';
    
}
else if ($controllerChoice == 'fulfill'){
    if (isset($_SESSION['customer'])) {
            $user = $_SESSION['customer'];
            $userID = $user-> getID();
        }
    else{
        $userID = 0;
    }
    $itemID = filter_input(INPUT_POST, 'itemID'); 
    $wishListId = filter_input(INPUT_POST, 'wishListID'); 
    
    wish_list_db::fulfillWishListItems($itemID, $userID); 
    $wishListItems = wish_list_item_db::getWishListItemsByID($wishListId);
    $stores = store_db::getActiveStores();
    
    include_once 'wish_list_item_veiw.php';
}
else if($controllerChoice == 'delete_list'){
    $wishListId = filter_input(INPUT_POST, 'wishListID');
    
    
    wish_list_db::deactivateWishList($wishListId);
    
    $wishLists = wish_list_db::getWishAllWishLists();

    include_once 'wish_list_user.php';
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



