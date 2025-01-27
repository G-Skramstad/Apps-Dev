<?php

Class wish_list_db{

public static function getWishListByID($wishListID)
{
    $db= Database::getDB();
    $query = 'SELECT w.ID, w.wlUserID,. u.firstName, u.lastName, w.description, w.isActive, w.dateCreated, '
            . 'w.dateUpdated,  count(wi.wishListID) as "wishListItemCount"'
            . 'from wishlist w left join wishlistitem wi on w.id = wi.wishListID'
            . 'join wlUser u on w.wlUserID = u.IDwhere  w.ID = :wishListID '
            . 'group by  w.ID, w.wlUserID,. u.firstName, u.lastName, w.description, w.isActive, w.dateCreated, w.dateUpdated';
    $statement = $db->prepare($query);
    $statement-> bindvalue(':wishListID', $wishListID);
    $statement->execute();
    // Should be only one row
    foreach ($statement as $row) 
    {
        $wishList= new WishList($row['ID'],  $row['wlUserID'], $row['firstName'], $row['lastName'],$row['description'], $row['wishListItemCount'], $row['dateCreated'], $row['dateUpdated'], $row['isActive'], $row['wlUserID']);
        // populate the wishlistItems
        $wishListItems= WishListDB::getWishListItemsForWishList($row['ID']);
        $wishList->setWishListItems($wishListItems);
    }
return $wishList;
}
       
 
 
 
 
// get all wishlists with the count of wishlist items, it does not include the wishListItems. 
public static function getWishAllWishLists()
{
    $db= Database::getDB();
    $query = 'SELECT w.ID, w.wlUserID, u.firstName, u.lastName, w.description, w.isActive, w.dateCreated, w.dateUpdated,  '
            . 'count(wi.wishListID) as wishListItemCount '
            . 'from wishlist w left join wishlistitem wi on w.id = wi.wishListID '
            . 'join wlUser u on w.wlUserID = u.ID '
            . 'where   w.isActive = :isActive '
            . 'group by  w.ID, w.wlUserID, u.firstName, u.lastName, w.description, w.isActive, w.dateCreated, w.dateUpdated';
    $statement = $db->prepare($query);
    $statement-> bindvalue(':isActive', 1);
    $statement->execute();
     // Hard code to 1 for now$statement->execute();
    $wishLists=array();
    foreach ($statement as $row) 
    {
        $wishList = new WishList($row['ID'], $row['firstName'] . " " .$row['lastName']
                , $row['description'], $row['wishListItemCount'], $row['dateCreated'], $row['isActive'], $row['wlUserID']); 
        // Add the Wishlist record.$wishList= new WishList($row['ID'],  $row['wlUserID'], $row['firstName'], $row['lastName'],$row['description'], $row['wishListItemCount'], $row['dateCreated'], $row['dateUpdated'], $row['isActive']);
        $wishLists[]= $wishList;
    }
    return $wishLists;
}
 
 
 
 
public static function fulfillWishListItems($wishListItemID, $wishListUserID)
{
    $db= Database::getDB();
    $query =  'Update  wishlistItem set dateUpdated = now(),fulfilledByID = :fulfilledByID '
            . 'where id = :wishListItemID';
    $statement = $db->prepare($query);
    $statement-> bindvalue(':wishListItemID', $wishListItemID);
    $statement-> bindvalue(':fulfilledByID', $wishListUserID);
    $statement->execute();
}

public static function getWishListByUserId($userID){
    $db = Database::getDB();

$query = 'SELECT w.ID, w.wlUserID, u.firstName, u.lastName, w.description, w.isActive, w.dateCreated, w.dateUpdated, '
        . 'COUNT(wi.wishListID) as "wishListItemCount" '
        . 'FROM wishlist w '
        . 'LEFT JOIN wishlistitem wi ON w.ID = wi.wishListID '
        . 'JOIN wlUser u ON w.wlUserID = u.ID '
        . 'WHERE w.wlUserID = :userID '
        . 'GROUP BY w.ID, w.wlUserID, u.firstName, u.lastName, w.description, w.isActive, w.dateCreated, w.dateUpdated';

$statement = $db->prepare($query);
$statement->bindValue(':userID', $userID);  // Bind the userID parameter
$statement->execute();

$wishLists = array();

foreach ($statement as $row) {
    $wishList = new WishList(
        $row['ID'], 
        $row['firstName'] . " " . $row['lastName'],  // Correct string concatenation
        $row['description'], 
        $row['wishListItemCount'], 
        $row['dateCreated'], 
        $row['isActive'],
        $row['wlUserID']
    ); 

    $wishLists[] = $wishList;  // Add the WishList object to the array
}

return $wishLists;

}


public static function addWishList($userID,$desc){
    $db = Database::getDB();
   
    $query = 'INSERT into wishlist(wlUserID, description,DateCreated) '
            . 'VALUES(:userID, :desc, now());'
    ;

$statement = $db->prepare($query);
$statement->bindValue(':userID', $userID); 
$statement->bindValue(':desc', $desc); 
$statement->execute();

$wishListID = $db->lastInsertId();
return $wishListID;
}

public static function deactivateWishList($wishListId)
    {
        $db = Database::getDB();
        $query = 'UPDATE wishlist 
                  SET isActive = 0, dateUpdated = NOW() 
                  WHERE ID = :wishListID';
        $statement = $db->prepare($query);
        $statement->bindValue(':wishListID', $wishListId);
        $statement->execute();
    }


}