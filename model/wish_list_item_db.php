<?php

Class wish_list_item_db{

    public static function getWishListItemsByID($wishListID)
{
    $db = Database::getDB();
    $query = 'SELECT w.ID, w.description, w.quantity, s.name AS storeName, w.notes, 
                     u.firstName, w.isActive, w.dateCreated, w.dateUpdated 
              FROM wishlistitem w 
              left JOIN wluser u ON w.fulfilledByID = u.ID  
              JOIN store s ON w.storeID = s.ID 
              WHERE w.wishListID = :wishListID';  // Assuming wishListID is meant to filter items belonging to a wish list
    
    $statement = $db->prepare($query);
    $statement->bindValue(':wishListID', $wishListID);
    $statement->execute();

    $wishListItems = [];
    
    foreach ($statement as $row) {
        $wishListItem = new WishListItem(
            $row['description'], 
            $row['quantity'], 
            $row['notes'],
            $row['storeName'],
            $row['firstName'],
            $row['isActive'] 
        );
        $wishListItem->setId($row['ID']);
        
        $wishListItems[] = $wishListItem;
    }

    $statement->closeCursor();
    return $wishListItems;
}


public static function getWishListItemsGranted($userId)
{
    $db = Database::getDB();
    $query = 'SELECT w.ID, w.description, w.quantity, s.name AS storeName, w.notes, 
                     u.firstName, w.isActive, w.dateCreated, w.dateUpdated 
              FROM wishlistitem w 
              left JOIN wluser u ON w.fulfilledByID = u.ID  
              JOIN store s ON w.storeID = s.ID 
              WHERE w.fulfilledByID = :userId ';  // Assuming wishListID is meant to filter items belonging to a wish list
    
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $wishListItems = [];
    
    foreach ($statement as $row) {
        $wishListItem = new WishListItem(
            $row['description'], 
            $row['quantity'], 
            $row['notes'],
            $row['storeName'],
            $row['firstName'],
            $row['isActive'] 
        );
        $wishListItem->setId($row['ID']);
        
        $wishListItems[] = $wishListItem;
    }

    $statement->closeCursor();
    return $wishListItems;
}

public static function editListItem($wishListItemID,$desc,$quantity,$notes,$storeId) {
    $db= Database::getDB();
    $query =  'Update  wishlistItem set dateUpdated = now(),description = :desc, '
            . 'quantity = :quantity, storeID = :storeId '
            . 'where id = :wishListItemID';
    $statement = $db->prepare($query);
    $statement-> bindvalue(':wishListItemID', $wishListItemID);
    $statement-> bindvalue(':desc', $desc);
    $statement-> bindvalue(':quantity', $quantity);
    $statement-> bindvalue(':notes', $notes);
    $statement-> bindvalue(':storeId', $storeId);
    $statement->execute();
}

public static function addListItem($wishListId, $desc,$quantity,$notes,$storeId){
    $db= Database::getDB();
    $query =  'INSERT INTO wishlistItem (dateUpdated,wishListID ,description, quantity,'
            . ' notes,storeID ) '
              .'VALUES (now(),:listID ,:desc, :quantity, :notes,:storeId );';
    $statement = $db->prepare($query);
    $statement-> bindvalue(':listID', $wishListId);
    $statement-> bindvalue(':desc', $desc);
    $statement-> bindvalue(':quantity', $quantity);
    $statement-> bindvalue(':notes', $notes);
    $statement-> bindvalue(':storeId', $storeId);
    
    $statement->execute();
}

public static function deleteListItem($itemId) {
    $db = Database::getDB();
    $query = 'UPDATE wishlistItem '
            . 'SET isActive = 0, dateUpdated = NOW() '
            . 'WHERE id = :itemId';
    $statement = $db->prepare($query);
    $statement->bindValue(':itemId', $itemId);
    $statement->execute();
    
}
public static function getActiveWishListItemsByID($wishListID)
{
    $db = Database::getDB();
    $query = 'SELECT w.ID, w.description, w.quantity, s.name AS storeName, w.notes, 
                     u.firstName, w.isActive, w.dateCreated, w.dateUpdated 
              FROM wishlistitem w 
              left JOIN wluser u ON w.fulfilledByID = u.ID  
              JOIN store s ON w.storeID = s.ID 
              WHERE w.wishListID = :wishListID AND  w.isActive = 1';  // Assuming wishListID is meant to filter items belonging to a wish list
    
    $statement = $db->prepare($query);
    $statement->bindValue(':wishListID', $wishListID);
    $statement->execute();

    $wishListItems = [];
    
    foreach ($statement as $row) {
        $wishListItem = new WishListItem(
            $row['description'], 
            $row['quantity'], 
            $row['notes'],
            $row['storeName'],
            $row['firstName'],
            $row['isActive'] 
        );
        $wishListItem->setId($row['ID']);
        
        $wishListItems[] = $wishListItem;
    }

    $statement->closeCursor();
    return $wishListItems;
}
public static function deactivateItem($itemId)
    {
        $db = Database::getDB();



        $query = "UPDATE wishlistItem 
                  SET isActive = 0, dateUpdated = NOW() 
                  WHERE ID = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $itemId);
        

        $statement->execute();
    }
    public static function activateItem($itemId)
    {
        $db = Database::getDB();



        $query = "UPDATE wishlistItem 
                  SET isActive = 1, dateUpdated = NOW() 
                  WHERE ID = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $itemId);
        

        $statement->execute();
    }


}

